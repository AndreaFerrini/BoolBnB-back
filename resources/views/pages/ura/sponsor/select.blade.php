@extends('layouts.app')

@section('content')


<main class="container-fluid">
    <div class="row justify-content-center mt-5 pt-5">
        <div class="col-10 col-sm-3 col-xl-2 m-5">
            <div class="p-sponsor-card text-center p-4">
                <h2 class="">BRONZE SPONSOR</h2>
                <hr>
                <p class="pt-3">Entra nella vetrina del successo con il nostro pacchetto Bronze Sponsor della durata di 24 ore! Ottieni visibilità esclusiva e raggiungi il tuo target attraverso la nostra piattaforma.</p>
                <form action="{{ route('checkout', $apartment_id) }}" method="post">
                    @csrf
                    <input type="hidden" value="2.99">
                    <button type="button" class="btn btn-primary mt-3">Compra ora</button>
                </form>
            </div>
        </div>
        <div class="col-10 col-sm-3 col-xl-2 m-5">
            <div class="p-sponsor-card text-center p-4">
               <h2 class="">SILVER SPONSOR</h2>
               <hr>
               <p class="pt-3">Porta la tua inserzione al livello successivo con il nostro pacchetto Silver Sponsor di 72 ore! Approfitta di una maggiore esposizione e visibilità durante il lungo periodo dell'evento. Scegli il pacchetto Silver Sponsor e diventa un leader nel mercato.</p>
            </div>
        </div>
        <div class="col-10 col-sm-3 col-xl-2 m-5">
            <div class="p-sponsor-card text-center p-4">
               <h2 class="">GOLD</h2>
               <h2>SONSOR</h2>
               <hr>
               <p class="pt-3">Eccellenza e prestigio ti aspettano con il nostro pacchetto Gold Sponsor della durata di 144 ore! Con una presenza di lunga durata, il pacchetto Gold Sponsor ti permette di mettere in mostra il tuo immobile a un vasto pubblico. Prendi il posto che meriti come protagonista.</p>
            </div>
        </div>
    </div>
</main>


<script>

</script>
@endsection