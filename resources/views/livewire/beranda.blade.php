@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="hero-image d-flex align-items-center justify-content-center text-center text-white">
                    <div class="overlay p-4 rounded">
                        <h1 class="display-4 fw-bold mb-3 animate__animated animate__fadeInDown">
                            Selamat Datang di <span class="text-warning">D'KATOS</span> Agus Setiawan
                        </h1>
                        <p class="lead animate__animated animate__fadeInUp">
                            Toko sepatu pria & wanita, model lengkap dan harga bersahabat!
                        </p>
                        <a href="#produk" class="btn btn-warning btn-lg mt-3 shadow-sm">Temukan Koleksi mu</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Produk Section -->
    <div class="container my-5" id="produk">
        <h2 class="text-center fw-bold text-primary mb-4">Koleksi Sepatu Kami</h2>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach (['sport', 'casual', 'formal'] as $jenis)
                <div class="col" data-aos="zoom-in">
                    <div class="card h-100 border-0 shadow-sm hover-shadow transition">
                        <div class="card-body text-center">
                            <h5 class="card-title text-primary">Sepatu {{ ucfirst($jenis) }}</h5>
                            <p class="card-text">Nyaman, stylish, dan cocok untuk aktivitas harianmu.</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Testimoni Section -->
    <section class="bg-light py-5">
        <div class="container text-center">
            <h3 class="fw-bold text-primary mb-4">Apa Kata Pelanggan Kami?</h3>
            <div class="row justify-content-center g-4">
                <div class="col-md-4" data-aos="fade-right">
                    <div class="card p-4 shadow-sm h-100">
                        <i class="bi bi-chat-quote fs-1 text-primary mb-3"></i>
                        <p class="fst-italic">"Sepatunya nyaman banget, kualitas oke dan pengirimannya cepat!"</p>
                        <h6 class="mt-3 text-primary">Andi Kurniawan</h6>
                        <small class="text-muted">Pelanggan Setia</small>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-left">
                    <div class="card p-4 shadow-sm h-100">
                        <i class="bi bi-heart fs-1 text-danger mb-3"></i>
                        <p class="fst-italic">"Modelnya lucu, cocok banget buat jalan-jalan atau kuliah."</p>
                        <h6 class="mt-3 text-primary">Siti Rahmawati</h6>
                        <small class="text-muted">Pelanggan Setia</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-primary text-white text-center py-4 mt-5">
        <div class="container">
            <p class="mb-0">&copy; {{ now()->year }} Toko Sepatu D'KATOS. Semua Hak Dilindungi.</p>
        </div>
    </footer>

    <!-- Custom CSS -->
    <style>
        .hero-image {
            background: linear-gradient(to bottom, rgba(0,0,0,0.5), rgba(0,0,0,0.6)), url('{{ asset('storage/sepatu/sepaturunn.jpg') }}') no-repeat center center;
            background-size: cover;
            height: 90vh;
        }

        .overlay {
            background-color: rgba(0, 0, 0, 0.5);
        }

        .hover-shadow:hover {
            transform: translateY(-5px);
            transition: all 0.3s ease-in-out;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }
    </style>

    <!-- AOS (Animate On Scroll) -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
@endsection
