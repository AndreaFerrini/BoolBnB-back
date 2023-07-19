@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-6">
            <h1 class="fs-4 text-secondary my-4 ms-2">
                I tuoi Annunci
            </h1>
        </div>
        <div class="col-6 text-end">
            <h2 class="fs-4 text-secondary my-4 me-2">
                <a href="{{route('admin.apartments.create')}}" class="text-secondary text-decoration-none">Aggiungi un Appartamento</a>
            </h2>
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
                <div class="p-2 col-12">
                    <div class="card shadow"
                    @if ($apartment->visibility == 0)
                    style="background-color: rgba(128, 128, 128, 0.123)"
                        
                    @endif>
                        <h5 class="card-title text-center my-3">{{$apartment->title}}</h5>
                        <p class="text-center"><b>Visibiltà:</b>
                            @if ($apartment->visibility === 1)
                                pubblico
                            @else
                                privato
                            @endif
                            </p>
                        <div class="row p-3">
                            <div class="col-4">
                                @if ( $apartment->cover_img)
                                <img class="img-fluid" src="{{asset('storage/' . $apartment->cover_img)}}" alt="Card image cap">
                                @else
                                <img class="img-fluid" src="https://www.bellearti.com/sites/default/files/custom/img_non_disponibile/img_non_disponibile.jpg" alt="Card image cap">
                                @endif
                            </div>
                            <div class="col-8">
                                <div>
                                    <p class="card-text">{{$apartment->description}}</p>
                                    <p><i>{{$apartment->address}}, {{$apartment->city}}</i></p>
                                    <span><b>Longitudine:</b> {{$apartment->longitude}}</span>
                                    <span><b>Latitudine:</b> {{$apartment->latitude}}</span>
                                    <div class="mt-2">
                                        <span><b>Stanze:</b>{{$apartment->number_of_rooms}}</span>
                                        <span><b>Bagni:</b>{{$apartment->number_of_bathrooms}}</span>
                                        <span><b>Superficie:</b>{{$apartment->square_meters}}Mq</span>
                                    </div>
                                    <div class="mt-3">
                                        <span>
                                            <b>Servizi:</b>
                                        </span>
                                        @foreach ($apartment->services as $service)
                                        <span>
                                            {{$service->name}}
                                            <i class="{{$service->icon}}"></i>
                                        </span>
                                        @endforeach
                                    </div>
                                    <div class="row align-items-center mt-4">
                                        <div class="col-2">
                                            <a href="{{route('admin.apartments.edit', $apartment)}}" class="btn btn-primary">Modifica</a>
                                        </div>
                                        <div class="col-1">
                                            <form action="{{ route('admin.apartments.destroy', $apartment) }}" method="POST" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button style="border-color: red" type="submit"><i class="fa-solid fa-trash-can text-danger"></i></button>
                                            </form>
                                        </div>
                                        <div class="col-3">
                                            <a href="{{route('admin.apartments.visibility', $apartment)}}" class="text-black text-decoration-none">
                                                <i class="fa-solid fa-eye{{$apartment->visibility ? '' : '-slash'}}"></i>
                                                cambia visibilità
                                            </a>
                                        </div>
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
    }, 2000);

    setTimeout(function () {
        document.getElementById('visibilita').classList.add('d-none');
    }, 2000);
</script>
@endsection


