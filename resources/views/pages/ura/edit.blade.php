@extends('layouts.app')
@section('content')

    <h1>MODIFICA {{ old('name') ?? $apartment->name }}</h1>
    <div class="container-lg">
        <div class="row">
            <div class="col-12">
                <form action="{{route('admin.apartments.update', $apartment)}}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
            
                    {{-- TITOLO --}}
                    <div class="form-group">
                        <label for="apartments-title" class="form-label text-white-50">Titolo</label>
                        <input type="text" required max="255"  id="apartments-title" class="form-control"
                        placeholder="Inserisci il titolo dell'appartamento" name="title" value="{{ old('title') ?? $apartment->title }}">
                        @error('title')
                            <span style="color: red; text-transform: uppercase">{{$message}}</span>
                        @enderror
                    </div>
                    
                    {{-- IMMAGINE --}}
                    <div class="mb-3 form-group">
                        <label for="apartments-cover_img" class="form-label">Scegli una immagine</label>
                        <input type="file" class="form-control" name="cover_img" id="apartments-cover_img" placeholder="image" aria-describedby="fileHelpId">
                        @error('cover_img')
                            <span style="color: red; text-transform: uppercase">{{$message}}</span>
                        @enderror
                    </div>
            
                    {{-- DESCRIZIONE --}}
                    <div class="form-group">
                        <label for="apartments-description" class="form-label text-white-50">Descrizione</label>
                        <textarea id="apartments-description" class="form-control"
                        placeholder="Inserisci la descrizione dell'appartamento" name="description">{{ old('description') ?? $apartment->description }}</textarea>
                        @error('description')
                            <span style="color: red; text-transform: uppercase">{{$message}}</span>
                        @enderror
                    </div>
            
                    {{-- INDIRIZZO --}}
                    <div class="form-group">
                        <label for="apartments-address" class="form-label text-white-50">Indirizzo</label>
                        <input type="text" required max="255"  id="apartments-address" class="form-control"
                        placeholder="Inserisci l'indirizzo dell'appartamento" name="address" value="{{ old('address') ?? $apartment->getIndirizzo() }}">
                        @error('address')
                            <span style="color: red; text-transform: uppercase">{{$message}}</span>
                        @enderror
                    </div>
            
                    {{-- NUMERO CIVICO --}}
                    <div class="form-group">
                        <label for="apartments-address_number" class="form-label text-white-50">Numero civico</label>
                        <input type="text" required max="9999" min="0001"  id="apartments-address_number" class="form-control"
                        placeholder="5/B" name="address_number" value="{{ old('address_number') ?? $apartment->getCivico() }}" pattern="[0-9a-zA-Z]+">
                        @error('address_number')
                            <span style="color: red; text-transform: uppercase">{{$message}}</span>
                        @enderror
                    </div>
            
                    {{-- CITTA' --}}
                    <div class="form-group">
                        <select name="city" id="apartments-city" required>
                            <option disabled >Scegli una città</option>
                            @foreach ($cities as $city)
                                <option  {{ old('city',$apartment->city) == $city ? 'selected' : ''}}>{{$city}}</option>
                            @endforeach
                        </select>
                    </div>
            
                    {{-- CODICE POSTALE --}}
                    <div class="form-group">
                        <label for="apartments-postal_code" class="form-label text-white-50">Codice postale</label>
                        <input type="text" required max="5" min="5"  id="apartments-postal_code" class="form-control"
                        placeholder="35010" name="postal_code" value="{{ old('address') ?? $apartment->getCap() }}" pattern="[0-9]+">
                        @error('postal_code')
                            <span style="color: red; text-transform: uppercase">{{$message}}</span>
                        @enderror
                    </div>
            
                    {{-- NUMERO DI STANZE --}}
                    <div class="form-group">
                        <label for="apartments-postal_code" class="form-label text-white-50">Numero stanze</label>
                        <input type="number" required max="20" min="1"  id="apartments-number_of_rooms" class="form-control"
                        placeholder="3" name="number_of_rooms" value="{{ old('number_of_rooms') ?? $apartment->number_of_rooms }}" pattern="[0-9]+">
                        @error('number_of_rooms')
                            <span style="color: red; text-transform: uppercase">{{$message}}</span>
                        @enderror
                    </div>
            
                    {{-- NUMERO DI BAGNI --}}
                    <div class="form-group">
                        <label for="apartments-number_of_bathrooms" class="form-label text-white-50">Numero bagni</label>
                        <input type="number" required max="20" min="1"  id="apartments-number_of_bathrooms" class="form-control"
                        placeholder="2" name="number_of_bathrooms" value="{{ old('number_of_bathrooms') ?? $apartment->number_of_bathrooms }}" pattern="[0-9]+">
                        @error('number_of_bathrooms')
                            <span style="color: red; text-transform: uppercase">{{$message}}</span>
                        @enderror
                    </div>
            
                    {{-- MQ --}}
                    <div class="form-group">
                        <label for="apartments-square_meters" class="form-label text-white-50">Metri quadrati</label>
                        <input type="number" required max="1000" min="1"  id="apartments-square_meters" class="form-control"
                        placeholder="50" name="square_meters" value="{{ old('square_meters') ?? $apartment->square_meters }}" pattern="[0-9]+">
                        @error('square_meters')
                            <span style="color: red; text-transform: uppercase">{{$message}}</span>
                        @enderror
                    </div>
            
                    {{-- PREZZO --}}
                    <div class="form-group">
                        <label for="apartments-price" class="form-label text-white-50">Prezzo</label>
                        <input type="number" required max="99999" min="1"  id="apartments-price" class="form-control"
                        placeholder="499,99" name="price" value="{{ old('price') ?? $apartment->price }}" step="0.01" pattern="\d+(\.\d{1,2})?">
                        @error('price')
                            <span style="color: red; text-transform: uppercase">{{$message}}</span>
                        @enderror
                    </div>
            
            
                    {{-- SERVICE --}}
                    <div class="form-group">

                        @foreach( $services as $service )
                        
                        <div class="form-check">
                        
                              @if( $errors->any() )
                              <input class="form-check-input" type="checkbox" name="services[]" value="{{$service->id}}" id="post-checkbox-{{$service->id}}"
                               {{ in_array( $service->id, old('services', [] ) ) ? 'checked' : '' }}>
                              @else
                              <input class="form-check-input" type="checkbox" name="services[]" value="{{$service->id}}" id="post-checkbox-{{$service->id}}"
                               {{ ( $apartment->services->contains($service) ) ? 'checked' : '' }}>
                              @endif
                              <label class="form-check-label" for="post-checkbox-{{$service->id}}">
                                {{$service->name}}
                              </label>
                        </div>
                        
                        @endforeach
                        
                        </div>
            
                    {{-- VISIBILITY --}}
                    <div class="form-group">
                        <label for="apartments-visibility" class="form-label text-black-50">Privato</label>
                        <input type="radio" name="visibility" value="0" checked="{{ old('visibility',$apartment->visibility) == 0 ? 'checked' : ''}}">
                        <label for="apartments-visibility" class="form-label text-black-50">Visibile</label>
                        <input type="radio" name="visibility" value="1" checked="{{ old('visibility',$apartment->visibility) == 1 ? 'checked' : ''}}">
                    </div>
            
                    <button type="submit" class="my-3 btn btn-primary">Aggiungi</button>
            
                </form>
            </div>
        </div>
    </div>
@endsection