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
        @if(isset($apartments))
        <div class="card p-3">
            <div class="row">
                @foreach ($apartments as $apartment)
                <div class="p-2 col-4">
                    <div class="card">
                        <h5 class="card-title text-center my-2">{{$apartment->title}}</h5>
                        <img class="card-img-top" src="https://static.vecteezy.com/system/resources/previews/005/337/799/original/icon-image-not-found-free-vector.jpg" alt="Card image cap">
                        <div class="card-body">

                            <p class="card-text">{{$apartment->description}}</p>
                            <p><i>{{$apartment->address}}, {{$apartment->city}}</i></p>
                            <span><b>Longitudine:</b> {{$apartment->longitude}}</span>
                            <span><b>Latitudine:</b> {{$apartment->latitude}}</span>
                            <div>
                                <span><b>Stanze:</b>{{$apartment->number_of_rooms}}</span>
                                <span><b>Bagni:</b>{{$apartment->number_of_bathrooms}}</span>
                                <span><b>Superficie:</b>{{$apartment->square_meters}}Mq</span>
                            </div>
                            <div>
                                @foreach ($apartment->services as $service)
                                <span>
                                    {{$service->name}}
                                    <i class="{{$service->icon}}"></i>
                                </span>
                                @endforeach
                            </div>

                            <a href="#" class="btn btn-primary">Go somewhere</a>
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
</script>
@endsection


