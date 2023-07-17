@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="fs-4 text-secondary my-4">
        I tuoi Annunci
    </h2>
    <div class="row justify-content-center">
        <div class="col">
            <div class="card"  id="welcome_banner">
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    Sei loggato!
                </div>
            </div>
        </div>

    </div>
    <div>
        <a href="{{route('admin.apartments.create')}}">create</a>
        @if (session('success') )
        <div class="alert alert-success" id="visibilita">
            {{ session('success') }}
        </div>
        @endif
        @if(isset($apartments))
        <div class="card p-3">
            <div class="row">
                @foreach ($apartments as $apartment)
                <div class="p-2 col-12">
                    <div class="card">
                        <h5 class="card-title text-center my-2">{{$apartment->title}}</h5>
                        <div class="row p-3">
                            <div class="col-4">
                                <img class="img-fluid" src="{{asset('storage/' . $apartment->cover_img)}}" alt="Card image cap">
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
                                        <span><b>Visibiltà:</b>
                                        @if ($apartment->visibility === 1)
                                            pubblico
                                        @else
                                            privato
                                        @endif
                                        </span>
                                    </div>
                                    <div>
                                        @foreach ($apartment->services as $service)
                                        <span>
                                            {{$service->name}}
                                            <i class="{{$service->icon}}"></i>
                                        </span>
                                        @endforeach
                                    </div>
                                    <div class="row align-items-center mt-2">
                                        <div class="col-2">
                                            <a href="{{route('admin.apartments.edit', $apartment)}}" class="btn btn-primary">Modifica</a>
                                        </div>
                                        <div class="col-1">
                                            <form action="{{ route('admin.apartments.destroy', $apartment) }}" method="POST" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"><i class="fa-solid fa-trash-can"></i></button>
                                            </form>
                                        </div>
                                        <div class="col-1">
                                            <a href="{{route('admin.apartments.visibility', $apartment)}}" class="text-black">
                                                <i class="fa-solid fa-eye{{$apartment->visibility ? '' : '-slash'}}"></i>
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
    <a href="{{route('admin.apartments.index')}}">prova</a>
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


