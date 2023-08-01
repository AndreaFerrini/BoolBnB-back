@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-6 text-center">
            <h1 class="fs-4 text-secondary my-4 ms-2">
                I tuoi Annunci  
            </h1>
        </div>
    </div>

    {{-- offcanvas dx --}}
    @if (isset($result->message))
        @if($result->status == 'failed')
            <div class="alert alert-danger d-flex align-items-center mt-4" role="alert">
                <div>
                    {{$result->message}}
                </div>
            </div>
        @elseif($result->status == 'success')
            <div class="alert alert-success d-flex align-items-center mt-4" role="alert">
                <div>
                    {{$result->message}}
                </div>
            </div>
        @endif
    @endif
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h3 class="offcanvas-title" id="offcanvasRightLabel">I tuoi messaggi</h3>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
    @foreach ($apartments as $apartment)
        @forelse($apartment->messages as $message)
            <div class="card border-dark mb-3" style="max-width: 18rem;">
                <div class="card-header">
                    <h4>Messaggio inviato da: <span class="text-primary">{{$message->name}} {{$message->surname}}</span></h4>
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{$apartment->title}}</h5>
                    <p class="card-text">{{$message->email_body}}</p>
                </div>
                <div class="card-footer">
                    <h5 class="card-title">Contact info:</h5>
                    <a class="card-text">{{$message->email}}</a>
                    <form action="{{ route('message.destroy', $message->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger mt-2">Elimina</button>
                    </form>
                </div>
            </div>
        @empty

        @endforelse
        @endforeach
    </div>
</div>

    @if (session('status'))
        <div class="alert alert-success" id="visibilita">
            {{ session('status') }}
        </div>            
    @endif
    <div>
        @if (session('success') )
        <div class="alert alert-success" id="visibilita">
            {{ session('success') }}
        </div>
        @endif
        @if(session('negate'))
        <div class="alert alert-danger" id="visibilita">
            {{ session('negate') }}
        </div>
        @endif

        @if(isset($apartments)) 
        <div class="p-3">
            <div class="row">
                @foreach ($apartments as $apartment)
                <div class="p-3 col-12" >
                    <div class="card shadow"
                    @if ($apartment->visibility == 0)
                    style="background-color: rgba(128, 128, 128, 0.123)"
                        
                    @endif>
                    <div class="row align-content-center px-2 py-4">
                        <div class="col-12 col-lg-6 col-xl-4">
                            <div class="row p-3">
                                <div class="col-12"  style="  overflow: hidden; max-height: 300px" >
                                    @if ( $apartment->cover_img)
                                    <img class="h-100 w-100 object-fit-cover" src="{{asset('storage/' . $apartment->cover_img)}}" alt="Card image cap">
                                    @else
                                    <img class="h-100 w-100 object-fit-cover" src="https://www.bellearti.com/sites/default/files/custom/img_non_disponibile/img_non_disponibile.jpg" alt="Card image cap">
                                    @endif
                                </div>
                                @if ($apartment->pictures)
                                <div class="d-flex flex-wrap col-12">
                                    @foreach ($apartment->pictures as $picture)
                                    <div class="col-3 mt-2 pe-2" style="height: 100px; overflow: hidden">
                                        <img class="h-100 w-100 object-fit-cover" src="{{asset('storage/' . $picture->picture_url)}}" alt="Card image cap">
                                    </div>                                   
                                    @endforeach
                                </div> 
                            </div>   
                        </div>

                        <div class="col-12 col-lg-6 pe-3 col-xl-8">
                            <h5 class="card-title text-center my-3">{{$apartment->title}}</h5>
                            <hr>
                            <div class="row">
                                <div class="col-12 col-lg-6 text-center">
                                    <span><b>Visibiltà:</b>
                                        @if ($apartment->visibility === 1)
                                            pubblico
                                        @else
                                            privato
                                        @endif
                                    </span> 
                                        @endif
                                </div>
                                <div class="col-12 col-lg-6 text-center">
                                    <span>
                                        <b>
                                            prezzo:
                                        </b>
                                        {{$apartment->price}}&#8364;	
                                    </span>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                    <div class="col-12 mb-3">
                                        <p class="card-text">{{$apartment->description}}</p>
                                    </div>
                                    <hr>
                                    <div class="col-12 mt-1">
                                        <p><i>{{$apartment->address}}, {{$apartment->city}}</i></p>
                                        <iframe
                                        src="https://www.google.com/maps?q={{ $apartment->latitude }},{{ $apartment->longitude }}&z=17&output=embed&iwloc=near"
                                        width="100%"
                                        height="200"
                                        frameborder="0"
                                        style="border:0;"
                                        allowfullscreen=""
                                        loading="lazy"
                                      ></iframe>
                                    </div>
                                    <hr>
                                    <div class="col-12 col-md-4 my-md-2">
                                        <span><b>Stanze:</b> {{$apartment->number_of_rooms}}</span>
                                    </div>
                                    <div class="col-12 col-md-4 my-md-2">
                                        <span><b>Bagni:</b> {{$apartment->number_of_bathrooms}}</span>
                                    </div>
                                    <div class="col-12 col-md-4 mb-3 my-md-2">
                                        <span><b>Superficie:</b> {{$apartment->square_meters}}Mq</span>
                                    </div>
                                    <hr>
                                    <div class="col-12">
                                        <div class="mt-3 row">
                                            <span>
                                                <b>Servizi:</b>
                                            </span>
                                            @foreach ($apartment->services as $service)
                                            <div class="col-12 col-md-6 col-lg-4">
                                                <i class="{{$service->icon}} me-2"></i>
                                                {{$service->name}}
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                            </div>
                            <hr>
                            <div class="row align-items-center justify-content-center mt-4">
                                <div class="col-6 col-xl-3 text-center ">
                                    <a href="{{route('admin.apartments.edit', $apartment)}}" class="btn btn-primary">Modifica</a>
                                </div>
    
                                <div class="col-6 col-xl-3 text-center ">
                                    <!-- Modale di conferma -->
                                    <div style="display: none;" class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h1 class="modal-title fs-5 text-danger" id="exampleModalLabel">Elimina appartamento</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                          </div>
                                            <div class="modal-body">
                                              <span class="">Sei sicuro di voler procedere ad eliminare l' appartamento?</span>
                                            </div>
                                          <div class="modal-footer">
                                           <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="confirmDelete">Conferma</button>
                                            <button type="button" class="btn btn-primary" id="cancelDelete" data-bs-dismiss="modal">Annulla</button>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    
                                    <!-- Form di eliminazione -->
                                    <form action="{{ route('admin.apartments.destroy', $apartment) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button id="deleteButton" style="border-color: red" type="button"><i class="fa-solid fa-trash-can text-danger" data-bs-toggle="modal" data-bs-target="#exampleModal"></i></button>
                                    </form>
                                </div>
                                <div class="col-12 col-xl-3 text-center mt-2 mt-xl-0">
                                    <a href="{{route('admin.apartments.visibility', $apartment)}}" class="text-black text-decoration-none">
                                        <i class="fa-solid fa-eye{{$apartment->visibility ? '' : '-slash'}}"></i>
                                        cambia visibilità
                                    </a>
                                </div>
                                <div class="col-12 col-xl-3 text-center mt-2 mt-xl-0 ">
                                    <a class="btn btn-warning text-white" href="{{route('sponsor', $apartment)}}">Sponsorizza</a>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        @endif
    </div>
    {{-- <a href="{{route('admin.apartments.index')}}">prova</a> --}}
    </div>

<script>
    setTimeout(function () {
        document.getElementById('welcome_banner').classList.add('d-none');
    }, 8000);

    setTimeout(function () {
        document.getElementById('visibilita').classList.add('d-none');
    }, 8000);


    // Funzione per mostrare il modale di conferma
    function showConfirmationModal() {
        var modal = document.getElementById('exampleModal');
        modal.style.display = 'block';
    }

    // Funzione per nascondere il modale di conferma
    function hideConfirmationModal() {
        var modal = document.getElementById('exampleModal');
        modal.style.display = 'none';
    }

    // Aggiungi un gestore di eventi onclick al pulsante di eliminazione
    document.getElementById('deleteButton').onclick = function() {
        showConfirmationModal();
    };

    // Aggiungi un gestore di eventi onclick al pulsante di conferma nel modale
    document.getElementById('confirmDelete').onclick = function() {
        hideConfirmationModal();
        // Invia il modulo solo se l'utente ha confermato
        document.querySelector('.delete-form').submit();
    };

    // Aggiungi un gestore di eventi onclick al pulsante di annullamento nel modale
    document.getElementById('cancelDelete').onclick = function() {
        hideConfirmationModal();
    };
</script>
@endsection


