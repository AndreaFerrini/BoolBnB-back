<section>
    <header>
        <h2 class="text-secondary">
            {{ __('Informazioni profilo') }}
        </h2>

        <p class="mt-1 text-muted">
            {{ __("Aggiorna le informazioni del tuo profilo o la tua mail") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('admin.profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="mb-2">
            <label for="name">{{__('Nome')}}</label>
            <input class="form-control" type="text" name="name" id="name" autocomplete="name" value="{{old('name', $user->name)}}" autofocus>
            @error('name')
            <span class="invalid-feedback" role="alert">

            </span>
            @enderror
            <label for="surname">{{__('Cognome')}}</label>
            <input class="form-control" type="text" name="surname" id="surname" autocomplete="surname" value="{{old('surname', $user->surname)}}" autofocus>
            @error('surname')
            <span class="invalid-feedback" role="alert">

            </span>
            @enderror
            <label for="birth">{{__('Data di nascita')}}</label>
            <input class="form-control" type="date" name="birth" id="birth" autocomplete="birth" value="{{old('birth', $user->birth)}}" autofocus>
            @error('birth')
            <span class="invalid-feedback" role="alert">

            </span>
            @enderror
            
        </div>

        <div class="mb-2">
            <label for="email">
                {{__('Email') }}*
            </label>

            <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email)}}" required autocomplete="username" />

            @error('email')
            <span class="alert alert-danger mt-2" role="alert">
                <strong>{{ $errors->get('email')}}</strong>
            </span>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div>
                <p class="text-sm mt-2 text-muted">
                    {{ __('La tua mail non è verificata.') }}

                    <button form="send-verification" class="btn btn-outline-dark">
                        {{ __('Clicca qui per reinviare la verifica della tua mail') }}
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                <p class="mt-2 text-success">
                    {{ __('Un nuovo link di verifica è stato inviato al tuo indirizzo mail') }}
                </p>
                @endif
            </div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-4">
            <button class="btn btn-primary" type="submit">{{ __('Salva') }}</button>

            @if (session('status') === 'profile-updated')
            <script>
                const show = true;
                setTimeout(() => show = false, 2000)
                const el = document.getElementById('profile-status')
                if (show) {
                    el.style.display = 'block';
                }
            </script>
            <p id='profile-status' class="fs-5 text-success">{{ __('Salvato.') }}</p>
            @endif
            @if (session('status') === 'profile-not-changed')
            <script>
                const show = true;
                setTimeout(() => show = false, 2000)
                const el = document.getElementById('profile-status')
                if (show) {
                    el.style.display = 'block';
                }
            </script>
            <p id='profile-status' class="fs-5 text-danger">Nessuna modifica effettuata.</p>
            @endif
        </div>
    </form>
</section>
