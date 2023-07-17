@extends('layouts.app')
@section('content')

<h1 class="text-center">MODIFICA: {{ old('title') ?? $apartment->title }}</h1>
<div class="container-lg">
  <div class="row">
    <div class="col-12 bg-white shadow rounded-lg">
      <form action="{{route('admin.apartments.update', $apartment)}}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf

        <div class="form-group">
          <label for="apartments-title" class="form-label mb-4">Titolo:</label>
          <input type="text" required max="255" id="apartments-title" class="form-control" placeholder="Inserisci il titolo dell'appartamento" name="title" value="{{ old('title') ?? $apartment->title }}">
          @error('title')
          <span style="color: red; text-transform: uppercase">{{ $message }}</span>
          @enderror
          <div class="row">
            <div class="col-8">
              <label for="apartments-cover_img" class="form-label mt-4">Scegli un'immagine</label>
              <input type="file" class="form-control" name="cover_img" id="img-preview" placeholder="image" aria-describedby="fileHelpId">
              <div class="preview mt-2 text-center d-inline-block"></div>
              @error('cover_img')
              <span style="color: red; text-transform: uppercase">{{ $message }}</span>
              @enderror
              <div class="form-group">
                <label for="apartments-description" class="form-label mt-4">Descrizione</label>
                <textarea id="apartments-description" class="form-control" placeholder="Inserisci la descrizione dell'appartamento" rows="8" name="description">{{ old('description') ?? $apartment->description }}</textarea>
                @error('description')
                <span style="color: red; text-transform: uppercase">{{ $message }}</span>
                @enderror
              </div>
            </div>
            <div class="col-4">
              <label for="apartments-city" class="form-label d-block mt-4 mb-2">Preview:</label>
              <div class="preview text-center d-inline-block p-3" style="max-height: 300px; width: 100%; min-height: 300px; overflow: hidden" id="box-preview">
              <img class="img-fluid" src="{{asset('storage/' . $apartment->cover_img)}}" alt="">
            </div>
            </div>
          </div>
        </div>

        <div class="mb-3 form-group">
        </div>


        <div class="form-group">
          <label for="apartments-address" class="form-label mt-4">Indirizzo</label>
          <input type="text" required max="255" id="apartments-address" class="form-control" placeholder="Inserisci l'indirizzo dell'appartamento" name="address" value="{{ old('address') ?? $apartment->getIndirizzo() }}">
          @error('address')
          <span style="color: red; text-transform: uppercase">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="apartments-address_number" class="form-label mt-4">Numero civico</label>
          <input type="text" required max="9999" min="0001" id="apartments-address_number" class="form-control" placeholder="5B" name="address_number" value="{{ old('address_number') ?? $apartment->getCivico() }}" pattern="[0-9a-zA-Z]+">
          @error('address_number')
          <span style="color: red; text-transform: uppercase">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="apartments-city" class="form-label mt-4">Città</label>
          <select name="city" id="apartments-city" class="form-control" required>
            <option disabled selected>Scegli una città</option>
            @foreach ($cities as $city)
              <option {{ old('city',$apartment->city) == $city ? 'selected' : '' }}>{{ $city }}</option>
            @endforeach
          </select>
        </div>

        <div class="row">
          <div class="col-md-4">
            <div class="form-group mt-4">
              <label for="apartments-postal_code" class="form-label">Codice postale</label>
              <input type="text" required max="5" min="5" id="apartments-postal_code" class="form-control" placeholder="35010" name="postal_code" value="{{ old('address') ?? $apartment->getCap() }}" pattern="[0-9]+">
              @error('postal_code')
              <span style="color: red; text-transform: uppercase">{{ $message }}</span>
              @enderror
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group mt-4">
              <label for="apartments-number_of_rooms" class="form-label">Numero stanze</label>
              <input type="number" required max="20" min="1" id="apartments-number_of_rooms" class="form-control" placeholder="3" name="number_of_rooms" value="{{ old('number_of_rooms') ?? $apartment->number_of_rooms }}" pattern="[0-9]+">
              @error('number_of_rooms')
              <span style="color: red; text-transform: uppercase">{{ $message }}</span>
              @enderror
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group mt-4">
              <label for="apartments-number_of_bathrooms" class="form-label">Numero bagni</label>
              <input type="number" required max="20" min="1" id="apartments-number_of_bathrooms" class="form-control" placeholder="2" name="number_of_bathrooms" value="{{ old('number_of_bathrooms') ?? $apartment->number_of_bathrooms }}" pattern="[0-9]+">
              @error('number_of_bathrooms')
              <span style="color: red; text-transform: uppercase">{{ $message }}</span>
              @enderror
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4">
            <div class="form-group mt-4">
              <label for="apartments-square_meters" class="form-label">Metri quadrati</label>
              <input type="number" required max="1000" min="1" id="apartments-square_meters" class="form-control" placeholder="50" name="square_meters" value="{{ old('square_meters') ?? $apartment->square_meters }}" pattern="[0-9]+">
              @error('square_meters')
              <span style="color: red; text-transform: uppercase">{{ $message }}</span>
              @enderror
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-group mt-4">
              <label for="apartments-price" class="form-label">Prezzo</label>
              <input type="number" required max="99999" min="1" id="apartments-price" class="form-control" placeholder="499,99" name="price" value="{{ old('price') ?? $apartment->price }}" step="0.01" pattern="\d+(\.\d{1,2})?">
              @error('price')
              <span style="color: red; text-transform: uppercase">{{ $message }}</span>
              @enderror
            </div>
          </div>
        </div>

        <div class="form-group">
          <label class="form-label mt-4">Service:</label>
          <div class="form-check">
            @foreach ($services as $service)
              <div class="form-check">
                @if ($errors->any())
                  <input class="form-check-input" type="checkbox" name="services[]" value="{{ $service->id }}" id="post-checkbox-{{ $service->id }}" {{ in_array($service->id, old('services', [])) ? 'checked' : '' }}>
                @else
                  <input class="form-check-input" type="checkbox" name="services[]" value="{{ $service->id }}" id="post-checkbox-{{ $service->id }}" {{ $apartment->services->contains($service) ? 'checked' : '' }}>
                @endif
                <label class="form-check-label" for="post-checkbox-{{ $service->id }}">
                  {{ $service->name }}
                </label>
              </div>
            @endforeach
          </div>
        </div>

        <div class="form-group">
          <label class="form-label mt-4">Visibility:</label>
          <div>
            <label for="apartments-visibility" class="form-label mt-4">Privato</label>
            <input type="radio" name="visibility" value="0" checked="{{ old('visibility',$apartment->visibility) == 0 ? 'checked' : '' }}">
            <label for="apartments-visibility" class="form-label mt-4">Visibile</label>
            <input type="radio" name="visibility" value="1" checked="{{ old('visibility',$apartment->visibility) == 1 ? 'checked' : '' }}">
          </div>
        </div>

        <button type="submit" class="my-3 btn btn-primary">Aggiungi</button>
      </form>
    </div>
  </div>
</div>

<script>
  document.getElementById("img-preview").addEventListener("change", function(e) {
    let reader = new FileReader();
    reader.onload = function(event) {
      let imagePreview = document.querySelector("#box-preview");
      imagePreview.innerHTML = `
      
      <img src="${event.target.result}" alt="Preview" class="img-fluid" style=" max-height: 300px">`;
    }
    reader.readAsDataURL(e.target.files[0]);
  });
</script>

@endsection