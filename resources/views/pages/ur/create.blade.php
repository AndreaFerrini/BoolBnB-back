@extends('layouts.app')

@section('content')
    

<div class="container-lg">
  <h1 class="mt-5">CREATE</h1>
  <div class="row">
    <div class="col-12 bg-white shadow rounded-lg">
      <form class="container-xl" action="{{ route('admin.apartments.store') }}" method="POST" enctype="multipart/form-data">
        @method('POST')
        @csrf

        {{-- TITOLO --}}
        <div class="form-group mt-4">
          <label for="apartments-title" class="form-label">Titolo:</label>
          <input type="text" required max="255" id="apartments-title" class="form-control" placeholder="Inserisci il titolo dell'appartamento" name="title" value="{{ old('title') }}">
          @error('title')
          <span style="color: red; text-transform: uppercase">{{ $message }}</span>
          @enderror
        </div>

        {{-- IMMAGINE --}}
        <div class="form-group mt-4">
          <label for="apartments-cover_img" class="form-label">Scegli un'immagine:</label>
          <input type="file" class="form-control" name="cover_img" id="apartments-cover_img" placeholder="Immagine" aria-describedby="fileHelpId">
          <div class="preview mt-2 text-center d-inline-block"></div>
          @error('cover_img')
          <span style="color: red; text-transform: uppercase">{{ $message }}</span>
          @enderror
        </div> 
        
        {{-- DESCRIZIONE --}}
        <div class="form-group mt-4">
            <label for="apartments-description" class="form-label">Descrizione:</label>
            <textarea id="apartments-description" class="form-control" placeholder="Inserisci la descrizione dell'appartamento" name="description">{{ old('description') }}</textarea>
            @error('description')
            <span style="color: red; text-transform: uppercase">{{ $message }}</span>
            @enderror
        </div>
        
        {{-- INDIRIZZO --}}
        <div class="form-group mt-4">
            <label for="apartments-address" class="form-label">Indirizzo:</label>
            <input type="text" required max="255" id="apartments-address" class="form-control" placeholder="Inserisci l'indirizzo dell'appartamento" name="address" value="{{ old('address') }}">
            @error('address')
            <span style="color: red; text-transform: uppercase">{{ $message }}</span>
            @enderror
        </div>
        
        {{-- CITTA' --}}
        <div class="form-group mt-4">
          <label for="apartments-city" class="form-label">Città:</label>
          <select name="city" id="apartments-city" class="form-control" required>
            <option disabled selected>Scegli una città</option>
            @foreach ($cities as $city)
            <option>{{ $city }}</option>
            @endforeach
          </select>
        </div>

        <div class="row">

        {{-- NUMERO CIVICO --}}
          <div class="col-md-4">
            <div class="form-group mt-4">
              <label for="apartments-address_number" class="form-label">Numero civico:</label>
              <input type="text" required max="9999" min="0001" id="apartments-address_number" class="form-control" placeholder="5/B" name="address_number" value="{{ old('address_number') }}" pattern="[0-9a-zA-Z]+">
              @error('address_number')
              <span style="color: red; text-transform: uppercase">{{ $message }}</span>
              @enderror
            </div>
          </div>

          {{-- CODICE POSTALE --}}
          <div class="col-md-4">
            <div class="form-group mt-4">
              <label for="apartments-postal_code" class="form-label">Codice postale:</label>
              <input type="text" required max="5" min="5" id="apartments-postal_code" class="form-control" placeholder="35010" name="postal_code" value="{{ old('postal_code') }}" pattern="[0-9]+">
              @error('postal_code')
              <span style="color: red; text-transform: uppercase">{{ $message }}</span>
              @enderror
            </div>
          </div>

          {{-- NUMERO DI STANZE --}}
          <div class="col-md-4">
            <div class="form-group mt-4">
              <label for="apartments-number_of_rooms" class="form-label">Numero stanze:</label>
              <input type="number" required max="20" min="1" id="apartments-number_of_rooms" class="form-control" placeholder="3" name="number_of_rooms" value="{{ old('number_of_rooms') }}" pattern="[0-9]+">
              @error('number_of_rooms')
              <span style="color: red; text-transform: uppercase">{{ $message }}</span>
              @enderror
            </div>
          </div>
        </div>

        <div class="row">

        {{-- NUMERO DI BAGNI --}}
          <div class="col-md-4">
            <div class="form-group mt-4">
              <label for="apartments-number_of_bathrooms" class="form-label">Numero bagni:</label>
              <input type="number" required max="20" min="1" id="apartments-number_of_bathrooms" class="form-control" placeholder="2" name="number_of_bathrooms" value="{{ old('number_of_bathrooms') }}" pattern="[0-9]+">
              @error('number_of_bathrooms')
              <span style="color: red; text-transform: uppercase">{{ $message }}</span>
              @enderror
            </div>
          </div>

          {{-- MQ --}}
          <div class="col-md-4">
            <div class="form-group mt-4">
              <label for="apartments-square_meters" class="form-label">Metri quadrati:</label>
              <input type="number" required max="1000" min="1" id="apartments-square_meters" class="form-control" placeholder="50" name="square_meters" value="{{ old('square_meters') }}" pattern="[0-9]+">
              @error('square_meters')
              <span style="color: red; text-transform: uppercase">{{ $message }}</span>
              @enderror
            </div>
          </div>

          {{-- PREZZO --}}
          <div class="col-md-4">
              <div class="form-group mt-4">
                <label for="apartments-price" class="form-label">Prezzo:</label>
                <input type="number" required max="99999" min="1" id="apartments-price" class="form-control" placeholder="499,99" name="price" value="{{ old('price') }}" step="0.01" pattern="\d+(\.\d{1,2})?">
                @error('price')
                <span style="color: red; text-transform: uppercase">{{ $message }}</span>
                @enderror
              </div>
          </div>
        </div>

        {{-- SERVICE --}}
        <div class="form-group mt-4">
          <label class="form-label">Servizi:</label>
          <div class="form-check d-flex flex-wrap">
            @foreach ($services as $service)
            <div class="col-2">
                <input class="form-check-input" type="checkbox" name="services[]" value="{{ $service->id }}" id="servicies-checkbox-{{ $service->id }}" @if(old('services') && in_array($service->id, old('services'))) checked @endif>
                <label class="form-check-label" for="servicies-checkbox-{{ $service->id }}">{{ $service->name }}</label>
                <br>
            </div>
            @endforeach
          </div>
          @error('services')
          <span style="color: red; text-transform: uppercase">{{ $message }}</span>
          @enderror
        </div>

        {{-- VISIBILITY --}}
        <label class="mt-4" for="">Visibility:</label>  
        <div class="form-group d-flex mt-3">
          <div class="form-check">
            <input class="form-check-input" type="radio" name="visibility" id="apartments-visibility-private" value="0">
            <label class="form-check-label" for="apartments-visibility-private">Privato</label>
          </div>
          <div class="form-check ms-5">
            <input class="form-check-input" type="radio" name="visibility" id="apartments-visibility-visible" value="1" checked>
            <label class="form-check-label" for="apartments-visibility-visible">Visibile</label>
          </div>
        </div>

        <button type="submit" class="my-3 btn btn-primary">Aggiungi</button>
      </form>
    </div>
  </div>
</div>

<script>
  document.getElementById("apartments-cover_img").addEventListener("change", function(e) {
    let reader = new FileReader();
    reader.onload = function(event) {
      let imagePreview = document.querySelector(".preview");
      imagePreview.innerHTML = `
      <span class="d-block mt-4 mb-3">preview:</span>
      <img src="${event.target.result}" alt="Preview" class="img-fluid rounded" style="max-width: 300px;">`;
    }
    reader.readAsDataURL(e.target.files[0]);
  });
</script>

@endsection
