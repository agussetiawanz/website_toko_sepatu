<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            background-color: #ffffff;
        }
        .navbar {
            background-color: #1e3a8a !important; /* Biru gelap */
        }
        .navbar-brand, .nav-link {
            color: white !important; /* Teks putih untuk navbar */
        }
        .btn-primary {
            background-color: #1e3a8a !important; /* Biru gelap untuk tombol */
            border-color: #1e3a8a !important;
            color: white !important;
        }
        .btn-outline-primary {
            color: #1e3a8a !important; /* Biru untuk tombol outline */
            border-color: #1e3a8a !important;
        }
        .btn-outline-primary:hover {
            background-color: #1e3a8a !important; /* Biru untuk hover */
            color: white !important;
        }
        .btn-primary:hover {
            background-color: #1e3a8a !important; /* Biru untuk hover */
            color: white !important;
        }
        .dropdown-menu {
            background-color: #1e3a8a;
        }
        .dropdown-item {
            color: white !important;
        }
        .dropdown-item:hover {
            background-color: #3b6dd4;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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

        <main class="py-4">
            <div class="container mb-3">
                <div class="row">
                    <div class="col-12 d-flex flex-wrap gap-2">
                        <a href="{{ route('home') }}" wire:navigate class="btn {{ request()->routeIs('home') ? 'btn-primary' : 'btn-outline-primary' }}">
                            Beranda
                        </a>

                        @auth
                            @switch(Auth::user()->role)
                                @case('admin')
                                    <a href="{{ route('user') }}" wire:navigate class="btn {{ request()->routeIs('user') ? 'btn-primary' : 'btn-outline-primary' }}">
                                        Pengguna
                                    </a>
                                    <a href="{{ route('produk') }}" wire:navigate class="btn {{ request()->routeIs('produk') ? 'btn-primary' : 'btn-outline-primary' }}">
                                        Produk
                                    </a>
                                    @break

                                @case('kasir')
                                    <a href="{{ route('transaksi') }}" wire:navigate class="btn {{ request()->routeIs('transaksi') ? 'btn-primary' : 'btn-outline-primary' }}">
                                        Transaksi
                                    </a>
                                    @break

                                @case('manager')
                                    <a href="{{ route('laporan') }}" wire:navigate class="btn {{ request()->routeIs('laporan') ? 'btn-primary' : 'btn-outline-primary' }}">
                                        Laporan
                                    </a>
                                    @break
                            @endswitch
                        @endauth
                    </div>
                </div>
            </div>

            {{ $slot }}
        </main>
    </div>
</body>
</html>
