<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../scss/app.scss">

    <!-- Usando Vite -->
    @vite(['resources/js/app.js'])
</head>

<body>
    <div id="app">


        <nav class="navbar navbar-expand-md navbar-light shadow-sm">
            <div class="container-fluid">

                <a class="title navbar-brand text-white" href="http://localhost:5173/">BoolB&amp;B</a>

                <a class="text-decoration-none text-white" href="http://localhost:5173/">Ritorna alla homepage</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    @php
                    $currentUrl = Request::url();
                    @endphp
                    
                    <ul class="navbar-nav me-auto">
                    @auth
                        @if($currentUrl !== url('/admin/apartments'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/admin/apartments') }}">{{ __('Home') }}</a>
                            </li>
                        @endif
                    @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->

                    <ul class="navbar-nav ml-auto">
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
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
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
        </nav>

        <main class="">
            @yield('content')
        </main>
    </div>
</body>

</html>
