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

          {{-- TITOLO --}}
          <label for="apartments-title" class="form-label mb-4">Titolo:</label>
          <input type="text" required max="255" id="apartments-title" class="form-control" placeholder="Inserisci il titolo dell'appartamento" name="title" value="{{ old('title') ?? $apartment->title }}">
          @error('title')
          <span style="color: red; text-transform: uppercase">{{ $message }}</span>
          @enderror
          <div class="row">

            <div class="col-8">

              {{-- IMMAGINE --}}
              <label for="apartments-cover_img" class="form-label mt-4">Scegli un'immagine</label>
              <input type="file" class="form-control" name="cover_img" id="img-preview" placeholder="image" aria-describedby="fileHelpId">
              <div class="preview mt-2 text-center d-inline-block"></div>
              @error('cover_img')
              <span style="color: red; text-transform: uppercase">{{ $message }}</span>
              @enderror

              {{-- DESCRIZIONE --}}
              <div class="form-group">
                <label for="apartments-description" class="form-label mt-4">Descrizione</label>
                <textarea id="apartments-description" class="form-control" placeholder="Inserisci la descrizione dell'appartamento" rows="8" name="description">{{ old('description') ?? $apartment->description }}</textarea>
                @error('description')
                <span style="color: red; text-transform: uppercase">{{ $message }}</span>
                @enderror
              </div>
            </div>

            {{-- PREVIEW IMG --}}
            <div class="col-4">
              <label for="apartments-city" class="form-label d-block mt-4 mb-2">Preview:</label>
              <div class="preview text-center d-inline-block p-3" style="max-height: 300px; width: 100%; min-height: 300px; overflow: hidden" id="box-preview">
                @if($apartment->cover_img)
                <img class="img-fluid" src="{{asset('storage/' . $apartment->cover_img)}}" alt="">
                @else
                <img class="img-fluid" src="https://www.bellearti.com/sites/default/files/custom/img_non_disponibile/img_non_disponibile.jpg" alt="Card image cap">
                @endif
              </div>
            </div>
          </div>
        </div>

        <div>
          <div class="row">

            {{-- INDIRIZZO --}} 
            <div class="col-6">
              <div class="form-group">
                <label for="apartments-address" class="form-label mt-4">Via:</label>
                <input type="text" required max="255" id="apartments-address" class="form-control" placeholder="Inserisci l'indirizzo dell'appartamento" name="address" value="{{ old('address') ?? $apartment->getIndirizzo() }}" list="apartments-address_list" onkeyup="getIndirizzoCompleto()"
                onfocus="this.value='', cleanAll()" onchange="this.blur();getCity()" autocomplete="off">
                <datalist id="apartments-address_list" >
                  {{-- CONTENUTO RICERCA --}}
                </datalist>
                @error('address')
                <span style="color: red; text-transform: uppercase">{{ $message }}</span>
                @enderror
              </div>
            </div>

            {{-- CITTA' --}}
            <div class="col-2">
              <div class="form-group">
                <label for="apartments-city" class="form-label mt-4">Città:</label>
              <input type="text" name="city" id="apartments-city" class="form-control" onkeyup="getCity()" list="apartments-city_list" required autocomplete="off" placeholder="Scegli una Città" max="200" onfocus="this.value=''" value="{{ old('city') ?? $apartment->city }}">
              <datalist id="apartments-city_list">
                {{-- CONTENUTO RICERCA --}}
              </datalist>
              </div>
            </div>

            {{-- NUMERO CIVICO --}}
            <div class="col-2">
              <div class="form-group">
                <label for="apartments-address_number" class="form-label mt-4">Numero civico: </label>
                <input type="text" required max="9999" min="0001" id="apartments-address_number" class="form-control" placeholder="5B" name="address_number" value="{{ old('address_number') ?? $apartment->getCivico() }}" pattern="[0-9a-zA-Z]+" onfocus="this.value=''">
                @error('address_number')
                <span style="color: red; text-transform: uppercase">{{ $message }}</span>
                @enderror
              </div>
            </div>

            {{-- CODICE POSTALE --}}
            <div class="col-2">
              <div class="form-group mt-4">
                <label for="apartments-postal_code" class="form-label">Codice postale:</label>
                <input type="text" required id="apartments-postal_code" class="form-control" placeholder="35010" name="postal_code" list="apartments-cap_list" onkeyup="getCap()" autocomplete="off" pattern="[0-9]{1,5}" onfocus="this.value=''" value="{{ old('postal_code') ?? $apartment->getCap()}}">
                <datalist id="apartments-cap_list">
                  {{-- CONTENUTO RICERCA --}}
                </datalist>
                @error('postal_code')
                <span style="color: red; text-transform: uppercase">{{ $message }}</span>
                @enderror
              </div> 
            </div>
          </div>
        </div>

        <div class="row">

          {{-- NUMERO DI STANZE --}}
          <div class="col-3">
            <div class="form-group mt-4">
              <label for="apartments-number_of_rooms" class="form-label">Numero stanze</label>
              <input type="number" required max="20" min="1" id="apartments-number_of_rooms" class="form-control" placeholder="3" name="number_of_rooms" value="{{ old('number_of_rooms') ?? $apartment->number_of_rooms }}" pattern="[0-9]+">
              @error('number_of_rooms')
              <span style="color: red; text-transform: uppercase">{{ $message }}</span>
              @enderror
            </div>
          </div>

          {{-- NUMERO DI BAGNI --}}
          <div class="col-3">
            <div class="form-group mt-4">
              <label for="apartments-number_of_bathrooms" class="form-label">Numero bagni</label>
              <input type="number" required max="20" min="1" id="apartments-number_of_bathrooms" class="form-control" placeholder="2" name="number_of_bathrooms" value="{{ old('number_of_bathrooms') ?? $apartment->number_of_bathrooms }}" pattern="[0-9]+">
              @error('number_of_bathrooms')
              <span style="color: red; text-transform: uppercase">{{ $message }}</span>
              @enderror
            </div>
          </div>
          
          {{-- MQ --}}
          <div class="col-3">
            <div class="form-group mt-4">
              <label for="apartments-square_meters" class="form-label">Metri quadrati</label>
              <input type="number" required max="1000" min="1" id="apartments-square_meters" class="form-control" placeholder="50" name="square_meters" value="{{ old('square_meters') ?? $apartment->square_meters }}" pattern="[0-9]+">
              @error('square_meters')
              <span style="color: red; text-transform: uppercase">{{ $message }}</span>
              @enderror
            </div>
          </div>
          
          {{-- PREZZO --}}
          <div class="col-3">
            <div class="form-group mt-4">
              <label for="apartments-price" class="form-label">Prezzo</label>
              <input type="number" required max="99999" min="1" id="apartments-price" class="form-control" placeholder="499,99" name="price" value="{{ old('price') ?? $apartment->price }}" step="0.01" pattern="\d+(\.\d{1,2})?">
              @error('price')
              <span style="color: red; text-transform: uppercase">{{ $message }}</span>
              @enderror
            </div>
          </div>
        </div>

        {{-- SERVICE --}}
        <div class="form-group">
          <label class="form-label mt-4">Service:</label>
          <p id="service_error" class="d-none text-danger">Seleziona almeno un servizio</p>
          <div class="form-check">
            <div class="row">
            @foreach ($services as $service)
              <div class="form-check col-2">
                @if ($errors->any())
                  <input class="form-check-input" type="checkbox" name="services[]" value="{{ $service->id }}" id="servicies-checkbox-{{ $service->id }}" {{ in_array($service->id, old('services', [])) ? 'checked' : '' }}>
                @else
                  <input class="form-check-input" type="checkbox" name="services[]" value="{{ $service->id }}" id="servicies-checkbox-{{ $service->id }}" {{ $apartment->services->contains($service) ? 'checked' : '' }}>
                @endif
                <label class="form-check-label" for="post-checkbox-{{ $service->id }}">
                  {{ $service->name }}
                </label>
              </div>
            @endforeach
            </div>
          </div>
        </div>

        {{-- VISIBILITY --}}
        <div class="form-group">
          <label class="form-label mt-4">Visibility:</label>
          <div>
            <label for="apartments-visibility" class="form-label mt-2">Privato</label>
            <input type="radio" name="visibility" value="0" checked="{{ old('visibility',$apartment->visibility) == 0 ? 'checked' : '' }}">
            <label for="apartments-visibility" class="form-label mt-2">Visibile</label>
            <input type="radio" name="visibility" value="1" checked="{{ old('visibility',$apartment->visibility) == 1 ? 'checked' : '' }}">
          </div>
        </div>

        <button type="submit" class="my-3 btn btn-primary" id="sub-btn">Modifica</button>
      </form>
    </div>
  </div>
</div>

<script>
 
    let city = document.getElementById('apartments-city');
    let indirizzo = document.getElementById('apartments-address');
    let civico = document.getElementById('apartments-address_number');
    let cap = document.getElementById('apartments-postal_code');
  //FUNCTION VERIFICA SERVIZI SELEZIONATI
    let elementoCheckd = true;
    let lista = document.getElementById('apartments-address_list');
    let listaCitta = document.getElementById('apartments-city_list');
    let listaCap = document.getElementById('apartments-cap_list');


    let uniqueStreetNames = [];
    let uniqueCitiesName = [];
    let uniqueCapNames = [];
    let indirizzoDigitato = indirizzo.value;
    let cittaScelta = '';
    let capScelto = cap.value;
    let civicoScelto = civico.value;
    const apiKey = '0xSqzIGFfYOPGxiHBIkZWuMQuGORRmfV';
    const countrySet = 'IT';
    const typeahead = true;
    const limit = 100;


    function serviceCheck() {
      let arrayCheck = document.querySelectorAll('[id*="servicies-checkbox-"]');
      
      elementoCheckd = Array.from(arrayCheck).some(element => element.checked);
    }

    document.getElementById("sub-btn").addEventListener("click", function(e) {
      serviceCheck();

      if (!elementoCheckd) {
         e.preventDefault();
         document.getElementById('service_error').classList.remove('d-none');
      } else {
        document.getElementById('service_error').classList.add('d-none');
      }
    
    })

    document.querySelectorAll(".form-check-input").forEach(element => {
      element.addEventListener("click", function(e) {
        serviceCheck();
        if (!elementoCheckd) {
            document.getElementById('service_error').classList.remove('d-none');
        } else {
            document.getElementById('service_error').classList.add('d-none');
        }
      });
    })

    // FUNCTION PREVIEW IMG CARICATA
    document.getElementById("img-preview").addEventListener("change", function(e) {
      let reader = new FileReader();
      reader.onload = function(event) {
        let imagePreview = document.querySelector("#box-preview");
        imagePreview.innerHTML = 
          `<img src="${event.target.result}" alt="Preview" class="img-fluid rounded mx-auto" max-height: 300px">`;
      }
      reader.readAsDataURL(e.target.files[0]);
    })

    function cleanAll(){
      let city = document.getElementById('apartments-city');
      let indirizzo = document.getElementById('apartments-address');
      let civico = document.getElementById('apartments-address_number');
      let cap = document.getElementById('apartments-postal_code');

      city.value = "";
      cap.value = "";
      civico.value = '';
    }

    function getIndirizzoCompleto() {


      let NuovaCitta = city.value;
      let NuovoIndirizzo = indirizzo.value;

      cleanAll();

      let lunghezza = NuovoIndirizzo.length;

      if (lunghezza > 5) {
        const tomTomUrl = `https://api.tomtom.com/search/2/search/${NuovoIndirizzo}.json?key=${apiKey}&countrySet=${countrySet}&typeahead=${typeahead}& limit=${limit}`;
        fetch(tomTomUrl)
        .then(response => response.json())
        .then(data => {
          const results = data.results;

          const filteredResults = results;

          uniqueStreetNames = [...new Set(filteredResults.map(element => element.address.streetName))];
          uniqueStreetNames = uniqueStreetNames.sort((a, b) => a.localeCompare(b));

          lista.innerHTML = "";

          uniqueStreetNames.forEach(element => {
            lista.innerHTML += `<option value="${element}">${element}</option>`;
          });

          cap.innerHTML = `<option disabled selected>Scegli un CAP</option>`;
          civico.value = '';
        });
      }
    }

    console.log('ciao1')

    function getCity() {
      let NuovaCitta = city.value;
      let NuovoIndirizzo = indirizzo.value;

      let lunghezza = NuovaCitta.length;

      if (lunghezza > 1) {
        const tomTomUrl = `https://api.tomtom.com/search/2/search/${NuovoIndirizzo}%20${NuovaCitta}.json?key=${apiKey}&countrySet=${countrySet}&  typeahead=${typeahead}&limit=${limit}`;
        fetch(tomTomUrl)
        .then(response => response.json())
        .then(data => {
          const results = data.results;
          const filteredResults = results.filter(element => element.type === "Street");
          uniqueCitiesName = [...new Set(filteredResults.map(element => element.address.municipality))];
          uniqueCitiesName = uniqueCitiesName.sort((a, b) => a.localeCompare(b));
          listaCitta.innerHTML = "";
          uniqueCitiesName.forEach(element => {
            if(element !== undefined){
              listaCitta.innerHTML += `<option value="${element}">${element}</option>`;
            }
          });
        });
      }
    }



    function getCap() {

  
      let NuovaCitta = city.value;
      let NuovoIndirizzo = indirizzo.value;
      // let NuovoCap = cap.value;
      let NuovoCivico = civico.value;
      let tomTomUrl = '';
      if(NuovoCivico !== ''){
        // console.log('cè il civico')
         tomTomUrl = `https://api.tomtom.com/search/2/search/${NuovoIndirizzo}%20${NuovoCivico}%20${NuovaCitta}.json?key=${apiKey}&countrySet=$ {countrySet}&typeahead=${typeahead}&limit=${limit}&idxSet=str`;
      }else{
        // console.log('noncè il civico')
         tomTomUrl = `https://api.tomtom.com/search/2/search/${NuovoIndirizzo}%20${NuovaCitta}%20.json?key=${apiKey}&countrySet=${countrySet}&typeahead=$ {typeahead}&limit=${limit}`;
      }
      fetch(tomTomUrl)
      .then(response => response.json())

      .then(data => {
        const results = data.results;
        const filteredResults = results.filter(
        element =>
          element.type === "Street" &&
          element.address.postalCode &&
          element.address.municipality == NuovaCitta
        );



        // console.log (filteredResults)

        let postalCodes = filteredResults
          .map(element => element.address.postalCode)
          .filter(code => code !== undefined) // Remove undefined postal codes
          .map(code => code.split(',')) // Split the postal codes
          .flat();
        postalCodes = postalCodes.map(code => code.trim());
        postalCodes = postalCodes.map(code => code.padStart(5, '0'));
        uniqueCapNames = [...new Set(postalCodes)].sort((a, b) => a.localeCompare(b));
        // console.log(uniqueCapNames)

        listaCap.innerHTML = '';
        uniqueCapNames.forEach(element => {
          listaCap.innerHTML += `<option value="${element}">${element}</option>`;
        });

      });
    }

    console.log('cia2')

    function checkAddress() {
    
      let indirizzo = document.getElementById('apartments-address')
      let citta = document.getElementById('apartments-city')
      let civico  = document.getElementById('apartments-address_number') 
      let cap  = document.getElementById('apartments-postal_code')

      

        if (indirizzo.value !== '' && citta.value !== '' && citta.value.length > 2 && civico.value !== '' && cap !== '' && cap.value.length > 4){
        const tomTomUrl = `https://api.tomtom.com/search/2/geocode/${indirizzo.value}%20${civico.value}%20${cap.value}%20${citta.value}.json?key=${apiKey}&countrySet=${countrySet}&limit=${limit}&minFuzzyLevel=2&typeahed=false`;
        fetch(tomTomUrl)
        .then(response => response.json())
        .then(data => {
          const results = data.results[0];
          console.log(results)
          if (results['address']['streetName'] !== indirizzo.value) {
            indirizzo.value = results['address']['streetName']
          }
          if (results['address']['municipality'] !== citta.value) {
            citta.value = results['address']['municipality']
          }
          if (results['address']['streetNumber'] !== civico.value) {
            if(results['address']['streetNumber']  !== undefined){

              civico.value = results['address']['streetNumber']
            }else {
              civico.value = 1
            }
          }
          if (results['address']['postalCode'] !== cap.value) {
            cap.value = results['address']['postalCode']
          }
        })
      }
    }

    document.getElementById('apartments-address').addEventListener('input', checkAddress);
    document.getElementById('apartments-city').addEventListener('input', checkAddress);
    document.getElementById('apartments-address_number').addEventListener('input', checkAddress);
    document.getElementById('apartments-postal_code').addEventListener('input', checkAddress);

</script>

@endsection