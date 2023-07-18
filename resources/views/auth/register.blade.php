@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" id="form" action="{{ route('register') }}">
                        @csrf

                        {{-- NOME --}}
                        <div class="mb-4 row mt-3">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nome') }}</label>
                                                                        
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name" autofocus>
                                                
                            </div>
                        </div>

                        {{-- COGNOME --}}
                        <div class="mb-4 row mt-3">
                            <label for="surname" class="col-md-4 col-form-label text-md-right">{{ __('Cognome') }}</label>
                                                
                            <div class="col-md-6">
                                <input id="surname" type="text" class="form-control @error('surname') is-invalid @enderror" name="surname" value="{{ old('surname') }}"autocomplete="surname" autofocus>
                        
                            </div>
                        </div>

                        {{-- DATA DI NASCITA --}}
                        <div class="mb-4 row mt-3">
                            <label for="birth" class="col-md-4 col-form-label text-md-right">{{ __('Data di nascita') }}</label>
                        
                            <div class="col-md-6">
                                <input id="birth" type="date" class="form-control @error('birth') is-invalid @enderror" name="birth" value="{{ old('birth') }}"autocomplete="birth" autofocus style="min-width: 150px">

                            </div>
                        </div>

                        {{-- E-MAIL --}}
                        <div class="mb-4 row mt-3">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }} *</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        {{-- PASSWORD --}}
                        <div class="mb-4 row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }} *</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                <span class="invalid-feedback" role="alert">
                                    <strong id="error"></strong>
                                </span>

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        {{-- VERIFICA PASSWORD --}}
                        <div class="mb-4 row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Conferma Password') }} *</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>

                            <span class="invalid-feedback" role="alert">
                                <strong id="errordue"></strong>
                            </span>

                        </div>

                        <div class="mb-4 row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                        <span>* campi obbligatori</span>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let password = document.getElementById('password')
    let verifica_password = document.getElementById('password-confirm')
    let error = document.getElementById('error')
    let errorDue = document.getElementById('errordue')
    let email = document.getElementById('email')
    
    document.getElementById('password-confirm').addEventListener("input", function(e) {

        if (password.value !== verifica_password.value) {
            event.preventDefault();
            password.classList.remove("is-valid"); // Rimuovi la classe "is-valid" da password
            verifica_password.classList.remove("is-valid"); // Rimuovi la classe "is-valid" da verifica_password
            verifica_password.classList.add("is-invalid"); // Aggiungi la classe "is-invalid" a verifica_password
            errorDue.innerHTML = "Le password inserite dall'utente non corrispondono";
        } else {
            password.classList.remove("is-invalid"); // Rimuovi la classe "is-invalid" da password
            verifica_password.classList.remove("is-invalid"); // Rimuovi la classe "is-invalid" da verifica_password
            password.classList.add("is-valid"); // Aggiungi la classe "is-valid" a password
            verifica_password.classList.add("is-valid"); // Aggiungi la classe "is-valid" a verifica_password
            errorDue.innerHTML = ""; // Rimuovi eventuali messaggi di errore precedenti
        }

    })

    document.getElementById("form").addEventListener('submit', function(event){
        
        if(password.value !== verifica_password.value || !(email.value.includes("@"))){
            event.preventDefault()
            if(password.value !== verifica_password.value) {
                password.classList.add("is-invalid")
                verifica_password.classList.add("is-invalid")
                error.innerHTML = "Le password inserite dall'utente non corrispondono"
            } else if (!(email.value.includes("@"))){
                email.classList.add("is-invalid")
            } else if (password.value !== verifica_password.value && !(email.value.includes("@"))) {
                password.classList.add("is-invalid")
                verifica_password.classList.add("is-invalid")
                error.innerHTML = "Le password inserite dall'utente non corrispondono"
                email.classList.add("is-invalid")
            }
        }
        
    })

    document.getElementById('email').addEventListener("input", function(e){
        if(email.value.includes("@")){
            email.classList.add("is-valid");
            email.classList.remove("is-invalid");
        } else{
            email.classList.remove("is-valid");
            email.classList.add("is-invalid");
        }
    })

</script>
@endsection

