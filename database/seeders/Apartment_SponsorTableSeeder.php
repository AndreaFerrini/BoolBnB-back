<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Apartment as Apartment;
use App\Models\Sponsor as Sponsor;

class Apartment_SponsorTableSeeder extends Seeder
{
    // protected   $max_sponsors_seeding_side  = 7; 
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //  // Il ragionamento da fare in questo seeder è il seguente:
        //  // Nella pivot trovano posto anche le sponsorizzazioni scadute, fornendo materiale utile ai fini statistici.
        //  // Non necessariamente un appartamento deve avere qualche sponsor ma se ne ha valgono le seguenti regole:
        //  // Un appartamento può avere anche un'unica sponsorizzazione che potrà essere già scaduta oppure ancora valida.
        //  // Un appartamento, laddove abbia più sponsorizzazioni, può averne solo una (l'ultima) che sia valida; tutte le altre devono necessariamente essere scadute.
        //  // Quando una sponsorizzazione scade, il suo campo "expire_at" diventa "null"
        //  // Le seguenti tre righe di codice sono sovrapponibili a quelle nel seeder della tabella Apartment_Service
        //  $all_apartments     =   Apartment::All();
        //  $all_sponsors_ids   =   Sponsor::pluck('id');
        //  $total_sponsors     =   count($all_sponsors_ids); 
        //  // Si ciclano tutti gli appartamenti presenti nel database
        //  foreach ($all_apartments as $apartment)
        //  {
        //      // La variabile "exit_loop", se true, forza l'uscita dal ciclo foreach, mentre il "counter" funge, appunto da contatore dei cicli
        //      $exit_loop = false;
        //      $counter = 0;
        //      // Il seguente ciclo "do-while" persiste fintantochè "exit_loop" si mantiene sul valore false ed il contatore non raggiunge il numero massimo di sponsorizzazioni accettabili (in fase di seeding)
        //      do
        //      {
        //          // La variabile "with_sponsors" assume un valore randomico tale che, se "0" si traduce in niente (o niente più) sponsorizzazioni per l'appartamento attuale, mentre, per tutti gli altri valori, identifica il tipo di sponsorizzazione da applicare all'appartamento in questione
        //          $with_sponsor = mt_rand(0, $total_sponsors);
        //          if ($with_sponsor == 0)
        //              $exit_loop = true;
        //          else
        //          {
        //              // Nel caso in cui si debba procedere con una sponsorizzazione si eseguono una serie di operazioni:
        //              // Il contatore viene incrementato
        //              $counter++;
        //              // Si acquisiscono tutte le informazioni relative alla sponsorizzazione del caso
        //              $sponsor = Sponsor::find($all_sponsors_ids[$with_sponsor - 1]);
        //              // Si valuta, con un booleano randomico, se l'attuale sponsorizzazione debba essere di tipo "scaduta" oppure di tipo "non scaduta"
        //              $is_expired = (bool) mt_rand(0,1);
        //              if (!$is_expired)
        //              {
        //                  // Se la sponsorizzazione deve essere di tipo "non scaduta" dovrà necessariamente essere l'ultima per il corrente appartamento, quindi la variabile "exit_loop" dovrà diventare true, inoltre si determina la data di scadenza della sponsorizzazione aggiungendo alla data/ora corrente, un numero di ore corrispondente alla durata del tipo di sponsorizzazione
        //                  $expire_date = \Carbon\Carbon::now()->addHours($sponsor->period)->toDateTimeString();
        //                  $data = ['expire_at' => $expire_date];
        //                  // Infine si salva la sponsorizzazione nella tabella pivot, senza rimuovere le eventuali precedenti sponsorizzazioni (ovviamente scadute)
        //                  $apartment->sponsors()->syncWithoutDetaching([$sponsor->id => $data]);
        //                  $exit_loop = true;
        //              }
        //              else
        //             {
        //                  // Se invece la sponsorizzazione dovrà essere "scaduta" allora se ne registrano le informazioni nella pivot senza forzare la fuoriuscita dal ciclo
        //                 $apartment->sponsors()->syncWithoutDetaching([$sponsor->id => ['expire_at' => null]]);
        //             }
        //          }
        //      }
        //      while (!$exit_loop && ($counter < $this->max_sponsors_seeding_side));
        // }

        $all_apartments = Apartment::all();
        $all_sponsors_ids = Sponsor::pluck('id');
        
        // Genera la data di scadenza aggiungendo 24 ore alla data corrente
        function date1()
        {
            date_default_timezone_set('Europe/Rome');
            return date('Y-m-d H:i:s', strtotime('+24 hours'));
        }
        
        // Genera la data di scadenza aggiungendo 72 ore alla data corrente
        function date2()
        {
            date_default_timezone_set('Europe/Rome');
            return date('Y-m-d H:i:s', strtotime('+72 hours'));
        }
        
        // Genera la data di scadenza aggiungendo 144 ore alla data corrente
        function date3()
        {
            date_default_timezone_set('Europe/Rome');
            return date('Y-m-d H:i:s', strtotime('+144 hours'));
        }
        
        // Genera una data di scadenza passata casualmente tra il 1 gennaio 2023 e la data corrente
        function generateRandomPastDate()
        {
            date_default_timezone_set('Europe/Rome');
            $startDate = strtotime('2023-01-01');
            $currentTimestamp = time();
            $randomTimestamp = mt_rand($startDate, $currentTimestamp);
            return date('Y-m-d H:i:s', $randomTimestamp);
        }
        
        foreach ($all_apartments as $apartment) {
            $number_of_sponsors = mt_rand(0, 10);
            $past_expiration_date = []; // Array per memorizzare le date di scadenza passate
        
            for ($i = 0; $i < $number_of_sponsors; $i++) {
                $sponsor_type = mt_rand(1, 3);
                $active = mt_rand(0, 1);
                $neverPromoted = mt_rand(0, 5); // 1/5 di possibilità che non si gnerino ultriori entry per l'appartamento
                

                if ($neverPromoted == 3) {

                    break; // esce dal ciclo se l'appartamento non è mai stato promosso o se non e attualmente promosso ma lo è stato in passato rende i dati piu realistici

                } else if ($active) {
                    $scadenza = null;
        
                    if ($sponsor_type == 1) {
                        $scadenza = date1(); // Genera la data di scadenza per il tipo di sponsorizzazione 1
                    } else if ($sponsor_type == 2) {
                        $scadenza = date2(); // Genera la data di scadenza per il tipo di sponsorizzazione 2
                    } else if ($sponsor_type == 3) {
                        $scadenza = date3(); // Genera la data di scadenza per il tipo di sponsorizzazione 3
                    }
        
                    $apartment->sponsors()->attach($sponsor_type, ['expire_at' => $scadenza]);
                    break; // Esce dal ciclo for se trova una sponsorizzazione attiva
                } else {
                    $scadenza = generateRandomPastDate(); // Genera una data di scadenza passata casualmente
        
                    if (!in_array($scadenza, $past_expiration_date)) {
                        $apartment->sponsors()->attach($sponsor_type, ['expire_at' => $scadenza]);
                        array_push($past_expiration_date, $scadenza); // Aggiunge la data di scadenza passata all'array
                    }
                }
            }
        }
    }    
}
