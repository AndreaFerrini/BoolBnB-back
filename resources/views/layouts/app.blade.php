<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('storage/BoolBnB favicon.png') }}" type="">


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../scss/app.scss">

    <!-- Usando Vite -->
    @vite(['resources/js/app.js'])
</head>

<body>
    <div id="app">
        <div class="wrapper">


            {{-- <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container">
                    <a class="navbar-brand d-flex align-items-center" href="{{ url('/admin/apartments') }}">
                        <div class="logo_laravel">
                            <svg viewBox="0 0 651 192" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 150px">
                                <g clip-path="url(#clip0)" fill="#EF3B2D">
                                    <path d="M248.032 44.676h-16.466v100.23h47.394v-14.748h-30.928V44.676zM337.091 87.202c-2.101-3.341-5.083-5.965-8.949-7.875-3.865-1.909-7.756-2.864-11.669-2.864-5.062 0-9.69.931-13.89 2.792-4.201 1.861-7.804 4.417-10.811 7.661-3.007 3.246-5.347 6.993-7.016 11.239-1.672 4.249-2.506 8.713-2.506 13.389 0 4.774.834 9.26 2.506 13.459 1.669 4.202 4.009 7.925 7.016 11.169 3.007 3.246 6.609 5.799 10.811 7.66 4.199 1.861 8.828 2.792 13.89 2.792 3.913 0 7.804-.955 11.669-2.863 3.866-1.908 6.849-4.533 8.949-7.875v9.021h15.607V78.182h-15.607v9.02zm-1.431 32.503c-.955 2.578-2.291 4.821-4.009 6.73-1.719 1.91-3.795 3.437-6.229 4.582-2.435 1.146-5.133 1.718-8.091 1.718-2.96 0-5.633-.572-8.019-1.718-2.387-1.146-4.438-2.672-6.156-4.582-1.719-1.909-3.032-4.152-3.938-6.73-.909-2.577-1.36-5.298-1.36-8.161 0-2.864.451-5.585 1.36-8.162.905-2.577 2.219-4.819 3.938-6.729 1.718-1.908 3.77-3.437 6.156-4.582 2.386-1.146 5.059-1.718 8.019-1.718 2.958 0 5.656.572 8.091 1.718 2.434 1.146 4.51 2.674 6.229 4.582 1.718 1.91 3.054 4.152 4.009 6.729.953 2.577 1.432 5.298 1.432 8.162-.001 2.863-.479 5.584-1.432 8.161zM463.954 87.202c-2.101-3.341-5.083-5.965-8.949-7.875-3.865-1.909-7.756-2.864-11.669-2.864-5.062 0-9.69.931-13.89 2.792-4.201 1.861-7.804 4.417-10.811 7.661-3.007 3.246-5.347 6.993-7.016 11.239-1.672 4.249-2.506 8.713-2.506 13.389 0 4.774.834 9.26 2.506 13.459 1.669 4.202 4.009 7.925 7.016 11.169 3.007 3.246 6.609 5.799 10.811 7.66 4.199 1.861 8.828 2.792 13.89 2.792 3.913 0 7.804-.955 11.669-2.863 3.866-1.908 6.849-4.533 8.949-7.875v9.021h15.607V78.182h-15.607v9.02zm-1.432 32.503c-.955 2.578-2.291 4.821-4.009 6.73-1.719 1.91-3.795 3.437-6.229 4.582-2.435 1.146-5.133 1.718-8.091 1.718-2.96 0-5.633-.572-8.019-1.718-2.387-1.146-4.438-2.672-6.156-4.582-1.719-1.909-3.032-4.152-3.938-6.73-.909-2.577-1.36-5.298-1.36-8.161 0-2.864.451-5.585 1.36-8.162.905-2.577 2.219-4.819 3.938-6.729 1.718-1.908 3.77-3.437 6.156-4.582 2.386-1.146 5.059-1.718 8.019-1.718 2.958 0 5.656.572 8.091 1.718 2.434 1.146 4.51 2.674 6.229 4.582 1.718 1.91 3.054 4.152 4.009 6.729.953 2.577 1.432 5.298 1.432 8.162 0 2.863-.479 5.584-1.432 8.161zM650.772 44.676h-15.606v100.23h15.606V44.676zM365.013 144.906h15.607V93.538h26.776V78.182h-42.383v66.724zM542.133 78.182l-19.616 51.096-19.616-51.096h-15.808l25.617 66.724h19.614l25.617-66.724h-15.808zM591.98 76.466c-19.112 0-34.239 15.706-34.239 35.079 0 21.416 14.641 35.079 36.239 35.079 12.088 0 19.806-4.622 29.234-14.688l-10.544-8.158c-.006.008-7.958 10.449-19.832 10.449-13.802 0-19.612-11.127-19.612-16.884h51.777c2.72-22.043-11.772-40.877-33.023-40.877zm-18.713 29.28c.12-1.284 1.917-16.884 18.589-16.884 16.671 0 18.697 15.598 18.813 16.884h-37.402zM184.068 43.892c-.024-.088-.073-.165-.104-.25-.058-.157-.108-.316-.191-.46-.056-.097-.137-.176-.203-.265-.087-.117-.161-.242-.265-.345-.085-.086-.194-.148-.29-.223-.109-.085-.206-.182-.327-.252l-.002-.001-.002-.002-35.648-20.524a2.971 2.971 0 00-2.964 0l-35.647 20.522-.002.002-.002.001c-.121.07-.219.167-.327.252-.096.075-.205.138-.29.223-.103.103-.178.228-.265.345-.066.089-.147.169-.203.265-.083.144-.133.304-.191.46-.031.085-.08.162-.104.25-.067.249-.103.51-.103.776v38.979l-29.706 17.103V24.493a3 3 0 00-.103-.776c-.024-.088-.073-.165-.104-.25-.058-.157-.108-.316-.191-.46-.056-.097-.137-.176-.203-.265-.087-.117-.161-.242-.265-.345-.085-.086-.194-.148-.29-.223-.109-.085-.206-.182-.327-.252l-.002-.001-.002-.002L40.098 1.396a2.971 2.971 0 00-2.964 0L1.487 21.919l-.002.002-.002.001c-.121.07-.219.167-.327.252-.096.075-.205.138-.29.223-.103.103-.178.228-.265.345-.066.089-.147.169-.203.265-.083.144-.133.304-.191.46-.031.085-.08.162-.104.25-.067.249-.103.51-.103.776v122.09c0 1.063.568 2.044 1.489 2.575l71.293 41.045c.156.089.324.143.49.202.078.028.15.074.23.095a2.98 2.98 0 001.524 0c.069-.018.132-.059.2-.083.176-.061.354-.119.519-.214l71.293-41.045a2.971 2.971 0 001.489-2.575v-38.979l34.158-19.666a2.971 2.971 0 001.489-2.575V44.666a3.075 3.075 0 00-.106-.774zM74.255 143.167l-29.648-16.779 31.136-17.926.001-.001 34.164-19.669 29.674 17.084-21.772 12.428-43.555 24.863zm68.329-76.259v33.841l-12.475-7.182-17.231-9.92V49.806l12.475 7.182 17.231 9.92zm2.97-39.335l29.693 17.095-29.693 17.095-29.693-17.095 29.693-17.095zM54.06 114.089l-12.475 7.182V46.733l17.231-9.92 12.475-7.182v74.537l-17.231 9.921zM38.614 7.398l29.693 17.095-29.693 17.095L8.921 24.493 38.614 7.398zM5.938 29.632l12.475 7.182 17.231 9.92v79.676l.001.005-.001.006c0 .114.032.221.045.333.017.146.021.294.059.434l.002.007c.032.117.094.222.14.334.051.124.088.255.156.371a.036.036 0 00.004.009c.061.105.149.191.222.288.081.105.149.22.244.314l.008.01c.084.083.19.142.284.215.106.083.202.178.32.247l.013.005.011.008 34.139 19.321v34.175L5.939 144.867V29.632h-.001zm136.646 115.235l-65.352 37.625V148.31l48.399-27.628 16.953-9.677v33.862zm35.646-61.22l-29.706 17.102V66.908l17.231-9.92 12.475-7.182v33.841z" />
                                </g>
                            </svg>
                        </div>
                        config('app.name', 'Laravel')
                    </a>

                    @if (File::exists(storage_path("app/public/front_end_url.txt")))
                        @php
                            $front_url = File::get(storage_path("app/public/front_end_url.txt"));
                        @endphp
                        <a href="{{ $front_url }}">Home</a>
                    @endif
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button> --}}

                    {{-- <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        @php
                        $currentUrl = Request::url();
                        @endphp --}}
                        
                        {{-- <ul class="navbar-nav me-auto">
                        @auth
                            @if($currentUrl !== url('/admin/apartments'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('/admin/apartments') }}">{{ __('Home') }}</a>
                                </li>
                            @endif
                        @endauth
                        </ul> --}}

                        <!-- Right Side Of Navbar -->

                        {{-- <ul class="navbar-nav ml-auto">
                            <!-- Authentication Links -->
                            @guest
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('register') }}">{{ __('Registrati') }}</a>
                            </li>
                            @endif
                            @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    @auth
                                        @if(Auth::user()->name && Auth::user()->surname)
                                        {{ ucfirst(Auth::user()->name) }} {{ ucfirst(Auth::user()->surname) }}
                                        @elseif(Auth::user()->name)
                                            {{ ucfirst(Auth::user()->name) }}
                                        @elseif(Auth::user()->surname)
                                            {{ ucfirst(Auth::user()->surname) }}
                                        @elseif(Auth::user()->email)
                                            {{ Auth::user()->email }}
                                        @endif
                                    @endauth
                                </a> --}}

                                {{-- <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('admin.apartments.index') }}">{{__('Dashboard')}}</a>
                                    <a class="dropdown-item" href="{{route('message')}}">Messages</a>
                                    <a class="dropdown-item" href="{{route('admin.apartments.create')}}">Create appartment</a>
                                    <a class="dropdown-item" href="{{ url('admin/profile') }}">{{__('Profilo')}}</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>  --}}

            <nav class="navbar navbar-expand-lg bg-body-tertiary" style="background-color: rgb(29,116,101)!important;" id="navBarTop">
                <div class="container-fluid" style="background-color: rgb(29,116,101);">
                    <a class="navbar-brand text-white" href="{{ url('/') }}">BoolB&amp;B</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    @php
                        $currentPageName = 'Home'; // Assume the default page name is 'Home'
                    @endphp
                    @if(isset($store['page_name']) && !empty($store['page_name']))
                        @php
                            $currentPageName = $store['page_name'];
                        @endphp
                    @endif
                    @if (File::exists(storage_path("app/public/front_end_url.txt")))
                        @php
                            $front_url = File::get(storage_path("app/public/front_end_url.txt"));
                        @endphp
                    <a href="{{ $front_url }}" class="nav-link active text-white me-5{{ $currentPageName !== 'Home' ? ' d-none' : '' }}">
                        <i class="fa-solid fa-house"></i>
                        <span>Home</span>
                    </a>
                    @endif
                    @auth
                    @if (!Route::is('admin.apartments.index'))
                    <a href="{{ url('http://127.0.0.1:8000/admin/apartments') }}" class="nav-link active text-white me-5{{ $currentPageName !== 'Home' ? ' d-none' : '' }}">
                        <i class="fa-solid fa-table-columns"></i>
                        <span>Appartamenti</span>
                    </a>
                        
                    @endif
                    @endauth
                    <div class="collapse navbar-collapse text-white" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        
                            @auth
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-white" href="" role="button" data-bs-toggle="dropdown" aria-expanded="false">Area personale</a>
                                <ul class="dropdown-menu" style="background-color: rgb(29,116,101);">
                                    <li>
                                        <a class="dropdown-item text-white" href="{{ url('admin/profile') }}">{{__('Profilo')}}</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-white" href="{{ url('http://127.0.0.1:8000/admin/apartments/create') }}">{{__('Aggiungi il tuo Appartamento')}}</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-white" href="{{ url('http://127.0.0.1:8000/message') }}">{{__('Messaggi')}}</a>
                                    </li>
                                    @endauth
                                    {{-- <li>
                                        <a class="dropdown-item text-white" href="{{ url('http://localhost:5174/ChiSiamo') }}">Chi Siamo</a>
                                    </li> --}}
                                    <!-- <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">Profilo</a>
                                    </li> -->
                                </ul>
                            </li>
                        </ul>
                    </div>
                    
                </div>
                @guest

                <a class=" text-white text-decoration-none " href="{{ url('/login') }}">Login</a>

         
                <a class=" text-white mx-5 text-decoration-none" href="{{ url('/register') }}" >Registrazione</a>
         
                @endguest
                @auth
                    <a class="text-decoration-none text-white me-4" href="{{ url('/logout') }}" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                @endauth
            </nav>

            <main class="">
                @yield('content')
            </main>
        </div>
        <footer>
            <div class="container">
                <div class="row justify-content-between align-items-center">
                    <div class="row col-12 col-md-9">
                        <div class="col-6">
                                <ul>
                                    <li class="mt-1" id="paragrafi">Informazioni</li>
                                </ul>
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <ul class="flex-column align-items-center">
                                        <li class="mt-1">
                                            <a href="/ChiSiamo">Chi Siamo</a>
                                        </li>
                                        <li class="mt-1"></li>
                                        <li class="mt-1">Lavora con noi</li>
                                        <li class="mt-1">Marchio</li>
                                    </ul>
                                </div>
                                <!-- <div class="col-md-6 col-12">
                                    <ul class="flex-column align-items-center">
                                        <li class="mt-1">Sede</li>
                                        <li class="mt-1">Assistenza</li>
                                    </ul>       
                                </div> -->
                            </div>
                        </div>
                        <div class="col-6">
                                <ul>
                                    <li class="mt-1" id="paragrafi">Norme</li>
                                </ul>
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <ul class="flex-column align-items-center">
                                        <li class="mt-1"> Privacy</li>
                                        <li class="mt-1">Termini</li>
                                        <li class="mt-1">Sicurezza</li>
                                    </ul>
                                </div>
                                <!-- <div class="col-md-6 col-12">
                                    <ul class="flex-column align-items-center">
                                        <li class="mt-1">Licenze</li>
                                        <li class="mt-1">Cookie</li>
                                        <li class="mt-1">Piani</li>
                                    </ul>       
                                </div> -->
                            </div>
                        </div>
                    </div>
                    <div class="row col-12 col-md-3 mx-auto">
                      <div class="mt-2 d-none d-md-none d-sm-none d-lg-block d-xl-block d-xxl-block">
                        <ul>
                            <li class="mt-1 text-center" id="paragrafi">Partner</li>
                            <li class="text-center">
                                <img src="{{ asset('storage/TomTom-Logo.png') }}" alt="TomTom Logo" id="logo-partner1">
                            </li>
                            <li class="text-center">
                                <img src="{{ asset('storage/braintree-logo-black.png') }}" alt="Braintree Logo" id="logo-partner2">
                            </li>
                        </ul>
                      </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <hr>
            </div>
            <div class="container d-flex justify-content-between align-items-center">
                <div>
                    <img src={{ asset('storage/BoolBnB.png') }} alt="">
                    <span>&#169; BoolBnB 2023</span>
                </div>
                <div class="registrazione">
                    <button class="btn btn-primary" id="footer-button">
                        <a href="http://127.0.0.1:8000/register">Registrati</a>
                    </button>
                </div>
            </div>
        </footer>
    </div>
</body>

</html>
