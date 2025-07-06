<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembelian</title>
    <style>
        body {
            font-family: "Courier New", Courier, monospace;
            font-size: 12px;
            max-width: 280px;
            margin: auto;
            text-align: center;
            padding: 10px;
        }
        hr {
            border: none;
            border-top: 1px dashed black;
            margin: 5px 0;
        }
        table {
            width: 100%;
            font-size: 12px;
            margin-top: 10px;
        }
        th, td {
            padding: 5px 0;
            text-align: left;
        }
        .center { text-align: center; }
        .right { text-align: right; }
        .title { font-weight: bold; font-size: 16px; margin-bottom: 10px; }
        .details { font-size: 12px; margin-bottom: 10px; }
        .total { font-weight: bold; font-size: 14px; text-align: right; margin-top: 10px; }
        .note { font-size: 10px; margin-top: 15px; }
        .kasir-info { margin-top: 10px; font-size: 12px; text-align: left; }
    </style>
</head>
<body>

    <div class="title">
        <h3>TOKO SEPATU D'KATOS STORE</h3>
    </div>

    <div class="details">
        <p>Jln. Soekarno Hatta - Bandung, Kota Bandung No.23</p>
        <hr>
        <p><strong>No. Transaksi:</strong> {{ $transaksi->kode }}</p>
        <p><strong>Tanggal:</strong> {{ $transaksi->created_at->format('d-m-Y H:i:s') }}</p>
        <div class="kasir-info" style="text-align: center;">
            <p><strong>Kasir:</strong> {{ $transaksi->kasir->name ?? 'Agus Setiawan' }}</p>
        </div>
        <hr>
    </div>

    <table class="items-table">
        <thead>
            <tr>
                <th>Item</th>
                <th class="center">Jml</th>
                <th class="right">Harga</th>
                <th class="right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalSebelumDiskon = 0;
            @endphp
            @foreach ($transaksi->detilTransaksi as $detil)
                @php
                    $subtotal = $detil->jumlah * $detil->produk->harga;
                    $totalSebelumDiskon += $subtotal;
                @endphp
                <tr>
                    <td>{{ $detil->produk->nama }}</td>
                    <td class="center">{{ $detil->jumlah }}</td>
                    <td class="right">Rp {{ number_format($detil->produk->harga, 0, ',', '.') }}</td>
                    <td class="right">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @php
        $diskonPersen = 0;
        if ($totalSebelumDiskon > 500000) {
            $diskonPersen = 10;
        } elseif ($totalSebelumDiskon > 200000) {
            $diskonPersen = 1;
        }
        $potongan = ($diskonPersen / 100) * $totalSebelumDiskon;
        $totalSetelahDiskon = $totalSebelumDiskon - $potongan;
    @endphp

    <hr>

    <div class="total">
        <p>Total Sebelum Diskon: Rp {{ number_format($totalSebelumDiskon, 0, ',', '.') }}</p>
        <p>Diskon: {{ $diskonPersen }}%</p>
        <p>Potongan: Rp {{ number_format($potongan, 0, ',', '.') }}</p>
        <p>Total Setelah Diskon: Rp {{ number_format($totalSetelahDiskon, 0, ',', '.') }}</p>
        <p>Bayar: Rp {{ number_format($bayar, 0, ',', '.') }}</p>
        <h5>Kembalian: Rp {{ number_format($kembalian, 0, ',', '.') }}</h5>
    </div>

    <hr>

    <div class="note">
        <p>Barang yang sudah dibeli tidak dapat dikembalikan.</p>
        <p>Terima kasih atas kunjungan Anda!</p>
    </div>

</body>
</html>
