@extends('layouts.app')

@section('content')
    

<div class="container-lg p-5">
  <h1>CREA UN NUOVO APPARTAMENTO</h1>
  <span>* campi obbligatori</span>
  <div class="row mt-3">
    <div class="col-12 bg-white shadow rounded-lg">
      <form class="container-xl" action="{{ route('admin.apartments.store') }}" method="POST" enctype="multipart/form-data" onsubmit="return preventSubmit()">
        @method('POST')
        @csrf

        {{-- TITOLO --}}
        <div class="form-group mt-4">
          <label for="apartments-title" class="form-label"><b>Titolo:</b> *</label>
          <input type="text" required max="255" id="apartments-title" class="form-control" placeholder="Inserisci il titolo dell'appartamento" name="title" value="{{ old('title') }}">
          @error('title')
          <span style="color: red; text-transform: uppercase">{{ $message }}</span>
          @enderror
        </div>

        <div class="form-group mt-2">
          <div class="row">
            <div class="col-8">
              
              {{-- IMMAGINI --}}
              <div class="my-4">
                <label for="apartments-cover_img" class="form-label"><b>Scegli un'immagine di copertina:</b></label>
                {{-- input cover img --}}
                <input type="file" class="form-control" name="cover_img" id="apartments-cover_img" placeholder="Immagine" aria-describedby="fileHelpId">
              </div>
              
              <div class="my-4">
                <label for="images" class="form-label"><b>Carica altre immagini:</b></label>
                {{-- input altre img --}}
                <input type="file" name="images[]" id="images_extra" class="form-control mb-2" placeholder="Immagine" aria-describedby="fileHelpId" multiple>  
              </div>
              
              @error('cover_img')
              <span style="color: red; text-transform: uppercase">{{ $message }}</span>
              @enderror

              
              {{-- PREVIEW IMG EXTRA --}}
              <div class="my-2">
                <label for="apartments-city" class="form-label d-block"><b>Preview immagini extra:</b></label>
                <div class="preview-extra row" style="overflow-y: scroll; max-height: 140px;">
  
                </div>
              </div>

              {{-- DESCRIZIONE --}}
              <div class="form-group mt-4">
                <label for="apartments-description" class="form-label"><b>Descrizione:</b> *</label>
                <textarea id="apartments-description" required class="form-control" placeholder="Inserisci la descrizione dell'appartamento" rows="8" name="description">{{ old('description') }}</textarea>
                @error('description')
                <span style="color: red; text-transform: uppercase">{{ $message }}</span>
                @enderror
              </div>
            </div>

            {{-- PREVIEW IMG --}}
            <div class="col-4">
              <label for="apartments-city" class="form-label d-block mb-2"><b>Preview:</b></label>
              <div class="preview text-center d-inline-block p-3" style="max-height: 300px; width: 100%; min-height: 300px; overflow: hidden">
                <img class="img-fluid" src="https://www.bellearti.com/sites/default/files/custom/img_non_disponibile/img_non_disponibile.jpg" alt="Card image cap">
              </div>
            </div>
          

          </div>
        </div> 
        
        <div class="row">

          {{-- INDIRIZZO --}}
          <div class="col-6">
            <div class="form-group mt-4">
                <label for="apartments-address" class="form-label"><b>Via:</b> *</label>
                <input type="text" required max="255" id="apartments-address" class="form-control" placeholder="Inserisci l'indirizzo dell'appartamento" name="address" value="{{ old('address') }}" list="apartments-address_list" onkeyup="getIndirizzoCompleto()"
                onfocus="this.value='', cleanAll()" onchange="this.blur();getCity()" autocomplete="off">
                <datalist id="apartments-address_list">
                  {{-- CONTENUTO RICERCA --}}
                </datalist>
                @error('address')
                <span style="color: red; text-transform: uppercase">{{ $message }}</span>
                @enderror
            </div>
          </div>

          {{-- CITTA' --}}
          <div class="col-2">
            <div class="form-group mt-4">
              <label for="apartments-city" class="form-label"><b>Città:</b> *</label>
              {{-- <select name="city" id="apartments-city" class="form-control" required onchange="getCap()">
                <option disabled selected>Scegli una città</option>
              </select> --}}
              <input type="text" name="city" id="apartments-city" class="form-control" onkeyup="getCity()" list="apartments-city_list" required autocomplete="off" placeholder="Scegli una Città" max="200" onfocus="this.value=''" value="{{ old('city') }}">
              <datalist id="apartments-city_list">
                {{-- CONTENUTO RICERCA --}}
              </datalist>
            </div>
          </div>

          {{-- NUMERO CIVICO --}}
          <div class="col-2">
            <div class="form-group mt-4">
              <label for="apartments-address_number" class="form-label"><b>Numero civico:</b> *</label>
              <input type="text" required max="9999" min="0001" id="apartments-address_number" class="form-control" placeholder="5B" name="address_number" value="{{ old('address_number') }}" pattern="[0-9a-zA-Z]+" onfocus="this.value=''">
              @error('address_number')
              <span style="color: red; text-transform: uppercase">{{ $message }}</span>
              @enderror
            </div>
          </div>

          {{-- CODICE POSTALE --}}
          <div class="col-2">
            <div class="form-group mt-4">
              <label for="apartments-postal_code" class="form-label"><b>Codice postale:</b> *</label>
              <input type="text" required id="apartments-postal_code" class="form-control"  name="postal_code" list="apartments-cap_list" onkeyup="getCap()" autocomplete="off" pattern="[0-9]{1,5}" onfocus="this.value=''" value="{{ old('postal_code') }}">
              <datalist id="apartments-cap_list">
                {{-- CONTENUTO RICERCA --}}
              </datalist>
              @error('postal_code')
              <span style="color: red; text-transform: uppercase">{{ $message }}</span>
              @enderror
            </div>
          </div>
        </div>
        <div class="row">

          {{-- NUMERO DI STANZE --}}
          <div class="col-md-3">
            <div class="form-group mt-4">
              <label for="apartments-number_of_rooms" class="form-label"><b>Numero stanze:</b> *</label>
              <input type="number" required max="20" min="1" id="apartments-number_of_rooms" class="form-control" placeholder="3" name="number_of_rooms" value="{{ old('number_of_rooms') }}" pattern="[0-9]+">
              @error('number_of_rooms')
              <span style="color: red; text-transform: uppercase">{{ $message }}</span>
              @enderror
            </div>
          </div>

          {{-- NUMERO DI BAGNI --}}
          <div class="col-md-3">
            <div class="form-group mt-4">
              <label for="apartments-number_of_bathrooms" class="form-label"><b>Numero bagni:</b> *</label>
              <input type="number" required max="20" min="1" id="apartments-number_of_bathrooms" class="form-control" placeholder="2" name="number_of_bathrooms" value="{{ old('number_of_bathrooms') }}" pattern="[0-9]+">
              @error('number_of_bathrooms')
              <span style="color: red; text-transform: uppercase">{{ $message }}</span>
              @enderror
            </div>
          </div>

          {{-- MQ --}}
          <div class="col-md-3">
            <div class="form-group mt-4">
              <label for="apartments-square_meters" class="form-label"><b>Metri quadrati:</b> *</label>
              <input type="number" required max="1000" min="1" id="apartments-square_meters" class="form-control" placeholder="50" name="square_meters" value="{{ old('square_meters') }}" pattern="[0-9]+">
              @error('square_meters')
              <span style="color: red; text-transform: uppercase">{{ $message }}</span>
              @enderror
            </div>
          </div>

          {{-- PREZZO --}}
          <div class="col-md-3">
              <div class="form-group mt-4">
                <label for="apartments-price" class="form-label"><b>Prezzo:</b> *</label>
                <input type="number" required max="99999" min="1" id="apartments-price" class="form-control" placeholder="499,99" name="price" value="{{ old('price') }}" step="0.01" pattern="\d+(\.\d{1,2})?">
                @error('price')
                <span style="color: red; text-transform: uppercase">{{ $message }}</span>
                @enderror
              </div>
          </div>
        </div>

        {{-- SERVICE --}}
        <div class="form-group mt-4">
          <label class="form-label"><b>Servizi:</b> *</label>
          <p id="service_error" class="d-none text-danger">Seleziona almeno un servizio</p>
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
        <label class="mt-4" for=""><b>Visibilità:</b> </label>  
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

        <button type="submit" class="my-3 btn btn-primary" id="sub-btn">Aggiungi</button>
      </form>
    </div>
  </div>
</div>

<script>

  //FUNCTION VERIFICA SERVIZZI SELEZIONATI
  let elementoCheckd = false;

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
    
  });

  document.querySelectorAll(".form-check-input").forEach(element => {
    element.addEventListener("click", function(e) {
        serviceCheck();
        if (!elementoCheckd) {
            document.getElementById('service_error').classList.remove('d-none');
        } else {
            document.getElementById('service_error').classList.add('d-none');
        }
    });
  });

  // FUNCTION PREVIEW IMG CARICATA
  document.getElementById("apartments-cover_img").addEventListener("change", function(e) {
    let reader = new FileReader();
    reader.onload = function(event) {
      let imagePreview = document.querySelector(".preview");
      imagePreview.innerHTML = 
        `<img src="${event.target.result}" alt="Preview" class="img-fluid rounded mx-auto" max-height: 300px">`;
        console.log("Files selezionati:", event.target.files);
    }
    reader.readAsDataURL(e.target.files[0]);
  });


  const imageExtra = document.getElementById("images_extra");
  
  imageExtra.addEventListener("change", function(e) {
    
    let files = e.target.files;
    let imageExtra = document.querySelector(".preview-extra");
    
    for (let i = 0; i < files.length; i++) {
      let reader = new FileReader();
      
      reader.onload = function(event) {
        let imageContent = event.target.result;
        imageExtra.innerHTML += 
        `<div class="col-3">
          <img src="${imageContent}" alt="Preview" class="img-fluid rounded mx-auto" max-height: 300px">
        </div>`;
        console.log("Contenuto del file " + (i + 1) + ":", imageContent);
      };
      
      reader.readAsDataURL(files[i]);
    }

  });

  // FUNCTION PER FILTRARE LE CITTA' SELEZIONABILI IN BASE ALLA VIA SCRITTA DALL'UTENTE
  let city = document.getElementById('apartments-city');
  let indirizzo = document.getElementById('apartments-address');
  let civico = document.getElementById('apartments-address_number');
  let cap = document.getElementById('apartments-postal_code');

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


  function getIndirizzoCompleto() {

    
    let NuovaCitta = city.value;
    let NuovoIndirizzo = indirizzo.value;
    
    cleanAll();

    let lunghezza = NuovoIndirizzo.length;
    
    if (lunghezza > 5) {
      const tomTomUrl = `https://api.tomtom.com/search/2/search/${NuovoIndirizzo}.json?key=${apiKey}&countrySet=${countrySet}&typeahead=${typeahead}&limit=${limit}`;
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


        // uniqueCitiesName = [...new Set(filteredResults.map(element => element.address.municipality))];
        // uniqueCitiesName = uniqueCitiesName.sort((a, b) => a.localeCompare(b));


        // city.innerHTML = `<option disabled selected>Scegli una città</option>`;

        // uniqueCitiesName.forEach(element => {
        //   if(element !== undefined){
        //     city.innerHTML += `<option>${element}</option>`;

        //     if ("{{ old('city') }}" === element) {
        //       option.setAttribute('selected', 'selected');
        //     }
        //   }
        // });

        cap.innerHTML = `<option disabled selected>Scegli un CAP</option>`;
        civico.value = '';
      });
    }
  };

  function getCity() {
    let NuovaCitta = city.value;
    let NuovoIndirizzo = indirizzo.value;

    let lunghezza = NuovaCitta.length;

    if (lunghezza > 1) {
      const tomTomUrl = `https://api.tomtom.com/search/2/search/${NuovoIndirizzo}%20${NuovaCitta}.json?key=${apiKey}&countrySet=${countrySet}&typeahead=${typeahead}&limit=${limit}`;
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
       tomTomUrl = `https://api.tomtom.com/search/2/search/${NuovoIndirizzo}%20${NuovoCivico}%20${NuovaCitta}.json?key=${apiKey}&countrySet=${countrySet}&typeahead=${typeahead}&limit=${limit}&idxSet=str`;
    }else{
      // console.log('noncè il civico')
       tomTomUrl = `https://api.tomtom.com/search/2/search/${NuovoIndirizzo}%20${NuovaCitta}%20.json?key=${apiKey}&countrySet=${countrySet}&typeahead=${typeahead}&limit=${limit}`;
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

  function cleanAll(){
    city.value = "";
    cap.value = "";
    civico.value = '';
  }

  function checkAddress() {
    let indirizzo = document.getElementById('apartments-address')
    let citta = document.getElementById('apartments-city')
    let civico  = document.getElementById('apartments-address_number') 
    let cap  = document.getElementById('apartments-postal_code')

  

    if (indirizzo.value !== '' && citta.value !== '' && citta.value.length > 2 && civico.value !== '' && cap !== '' && cap.value.length > 4){
      const tomTomUrl = `https://api.tomtom.com/search/2/geocode/${indirizzo.value}%20${civico.value}%20${cap.value}%20${citta.value}.json?key=${apiKey}&countrySet=${countrySet}&typeahead=${typeahead}&limit=${limit}&minFuzzyLevel=2&typeahed=false`;
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
