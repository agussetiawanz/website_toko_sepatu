<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi - Toko Sepatu</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJv+2zHq32IN8kq4zvDbj06TiVZ7mnfsjlGR4l1i6/5XhZ8s3MfsygHXXIBS" crossorigin="anonymous">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }
        .card-header {
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 1rem;
        }
        .card-body {
            padding: 2rem;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h4.card-title {
            font-size: 26px;
            font-weight: bold;
            margin-bottom: 1.5rem;
            color: #007bff;
        }
        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }
        .table th {
            background-color: #e9ecef;
            color: #333;
            font-weight: bold;
        }
        .table-bordered {
            border: 1px solid #dee2e6;
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid #dee2e6;
        }
        .btn-print {
            margin-top: 20px;
            background-color: #28a745;
            color: white;
            font-size: 16px;
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }
        .btn-print:hover {
            background-color: #218838;
        }
        .footer-text {
            text-align: center;
            margin-top: 2rem;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body onload="window.print()">

    <div class="container">
        <div class="row mt-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Toko Sepatu RF - Laporan Transaksi</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>No. Inv.</th>
                                    <th>Kasir</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($semuaTransaksi as $transaksi)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ \Carbon\Carbon::parse($transaksi->created_at)->format('d M Y') }}</td>
                                        <td>{{ $transaksi->kode }}</td>
                                        <td>{{ $transaksi->user->name ?? '-' }}</td>
                                        <td>Rp. {{ number_format($transaksi->total, 2, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>                        </table>

                        <!-- Print Button -->
                        <div class="text-center mt-4">
                            <button class="btn btn-print" onclick="window.print()">Cetak Laporan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-text">
        <p>&copy; 2025 Toko Sepatu - Semua hak cipta dilindungi.</p>
    </div>

    <!-- Optional: Add Bootstrap JS for additional features if necessary -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0GcmFfJ95jRX6K3gf0bmbszt4QjoLyfNp6vZgx0x8p2h0RZV" crossorigin="anonymous"></script>
</body>
</html>
