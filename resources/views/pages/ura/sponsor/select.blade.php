@extends('layouts.app')

@section('content')


<main class="container-fluid">
    <div class="row justify-content-center mt-5">
        <div id class="col-8 col-xl-4">
            <h2>Sponsorizza il Tuo Appartamento e Ottieni Maggior Visibilità!</h2>
            <p class="mt-5">Benvenuto nella pagina di acquisto sponsor per il tuo appartamento! Se possiedi un appartamento da affittare e desideri aumentare la visibilità del tuo annuncio, sei nel posto giusto. Con il nostro servizio di sponsorizzazione, puoi promuovere il tuo appartamento e farlo emergere tra gli altri annunci, raggiungendo un pubblico più ampio di potenziali inquilini. Scegli tra una varietà di pacchetti di sponsorizzazione, ciascuno progettato per adattarsi alle tue esigenze e al tuo budget. Dalla sponsorizzazione base per una visibilità temporanea a quella premium per una promozione di lunga durata, abbiamo tutto ciò di cui hai bisogno per ottenere il massimo dalla tua esperienza di affitto. Affrettati e sfrutta questa opportunità unica per dare un'accelerazione alla tua attività di affitto e ottenere il successo che meriti!</p>
        </div>
        <div class="col-8 col-xl-4">
            <span class="p-s-badge badge text-bg-warning">Sponsored</span>
            <img class="img-fluid rounded-4" src="{{asset('storage/' . $apartment->cover_img)}}" alt="">
        </div>
    </div>
    <div id="sponsor-row" class="row justify-content-center pt-5">
        <div class="col-10 col-sm-3 col-xl-3 m-2">
            <div class="p-sponsor-card text-center p-4">
                <h2 class="">BRONZE SPONSOR</h2>
                <hr>
                <p class="pt-3">Entra nella vetrina del successo con il nostro pacchetto Bronze Sponsor della durata di 24 ore! Ottieni visibilità esclusiva e raggiungi il tuo target attraverso la nostra piattaforma.</p>
                <form action="{{ route('checkout', $apartment_id) }}" method="post">
                  @csrf
                    <input type="hidden" name="input" value="2.99">
                    <button type="submit" class="btn btn-primary mt-3">Compra ora</button>  
                </form>
            </div>
        </div>
        <div class="col-10 col-sm-3 col-xl-3 m-2">
            <div class="p-sponsor-card text-center p-4">
               <h2 class="">SILVER SPONSOR</h2>
               <hr>
               <p class="pt-3">Porta la tua inserzione al livello successivo con il nostro pacchetto Silver Sponsor di 72 ore! Approfitta di una maggiore esposizione e visibilità durante il lungo periodo dell'evento. Scegli il pacchetto Silver Sponsor e diventa un leader nel mercato.</p>
               <form action="{{ route('checkout', $apartment_id) }}" method="post">
                  @csrf
                    <input type="hidden" name="input" value="5.99">
                    <button type="submit" class="btn btn-primary mt-3">Compra ora</button>  
                </form>
            </div>
        </div>
        <div class="col-10 col-sm-3 col-xl-3 m-2">
            <div class="p-sponsor-card text-center p-4">
               <h2 class="">GOLD</h2>
               <h2>SONSOR</h2>
               <hr>
               <p class="pt-3">Eccellenza e prestigio ti aspettano con il nostro pacchetto Gold Sponsor della durata di 144 ore! Con una presenza di lunga durata, il pacchetto Gold Sponsor ti permette di mettere in mostra il tuo immobile a un vasto pubblico. Prendi il posto che meriti come protagonista.</p>
               <form action="{{ route('checkout', $apartment_id) }}" method="post">
                  @csrf
                    <input type="hidden" name="input" value="9.99">
                    <button type="submit" class="btn btn-primary mt-3">Compra ora</button>  
                </form>
            </div>
        </div>
    </div>
</main>


<script>

</script>
@endsection