<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Apartment as Apartment;
use App\Models\Sponsor as Sponsor;

class Apartment_SponsorTableSeeder extends Seeder
{
    protected   $max_sponsors_seeding_side  = 7; 
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Il ragionamento da fare in questo seeder è il seguente:
        // Nella pivot trovano posto anche le sponsorizzazioni scadute, fornendo materiale utile ai fini statistici.
        // Non necessariamente un appartamento deve avere qualche sponsor ma se ne ha valgono le seguenti regole:
        // Un appartamento può avere anche un'unica sponsorizzazione che potrà essere già scaduta oppure ancora valida.
        // Un appartamento, laddove abbia più sponsorizzazioni, può averne solo una (l'ultima) che sia valida; tutte le altre devono necessariamente essere scadute.
        // Quando una sponsorizzazione scade, il suo campo "expire_at" diventa "null"
        // Le seguenti tre righe di codice sono sovrapponibili a quelle nel seeder della tabella Apartment_Service
        $all_apartments     =   Apartment::All();
        $all_sponsors_ids   =   Sponsor::pluck('id');
        $total_sponsors     =   count($all_sponsors_ids); 
        // Si ciclano tutti gli appartamenti presenti nel database
        foreach ($all_apartments as $apartment)
        {
            // La variabile "exit_loop", se true, forza l'uscita dal ciclo foreach, mentre il "counter" funge, appunto da contatore dei cicli
            $exit_loop = false;
            $counter = 0;
            // Il seguente ciclo "do-while" persiste fintantochè "exit_loop" si mantiene sul valore false ed il contatore non raggiunge il numero massimo di sponsorizzazioni accettabili (in fase di seeding)
            do
            {
                // La variabile "with_sponsors" assume un valore randomico tale che, se "0" si traduce in niente (o niente più) sponsorizzazioni per l'appartamento attuale, mentre, per tutti gli altri valori, identifica il tipo di sponsorizzazione da applicare all'appartamento in questione
                $with_sponsor = mt_rand(0, $total_sponsors);
                if ($with_sponsor == 0)
                    $exit_loop = true;
                else
                {
                    // Nel caso in cui si debba procedere con una sponsorizzazione si eseguono una serie di operazioni:
                    // Il contatore viene incrementato
                    $counter++;
                    // Si acquisiscono tutte le informazioni relative alla sponsorizzazione del caso
                    $sponsor = Sponsor::find($all_sponsors_ids[$with_sponsor - 1]);
                    // Si valuta, con un booleano randomico, se l'attuale sponsorizzazione debba essere di tipo "scaduta" oppure di tipo "non scaduta"
                    $is_expired = (bool) mt_rand(0,1);
                    if (!$is_expired)
                    {
                        // Se la sponsorizzazione deve essere di tipo "non scaduta" dovrà necessariamente essere l'ultima per il corrente appartamento, quindi la variabile "exit_loop" dovrà diventare true, inoltre si determina la data di scadenza della sponsorizzazione aggiungendo alla data/ora corrente, un numero di ore corrispondente alla durata del tipo di sponsorizzazione
                        $expire_date = \Carbon\Carbon::now()->addHours($sponsor->period)->toDateTimeString();
                        $data = ['expire_at' => $expire_date];
                        // Infine si salva la sponsorizzazione nella tabella pivot, senza rimuovere le eventuali precedenti sponsorizzazioni (ovviamente scadute)
                        $apartment->sponsors()->syncWithoutDetaching([$sponsor->id => $data]);
                        $exit_loop = true;
                    }
                    else
                    {
                        // Se invece la sponsorizzazione dovrà essere "scaduta" allora se ne registrano le informazioni nella pivot senza forzare la fuoriuscita dal ciclo
                        $apartment->sponsors()->syncWithoutDetaching([$sponsor->id => ['expire_at' => null]]);
                    }
                }
            }
            while (!$exit_loop && ($counter < $this->max_sponsors_seeding_side));
        }
    }
}
