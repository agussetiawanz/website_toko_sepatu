<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembelian</title>
    <style>
        body {
            font-family: monospace;
            max-width: 300px;
            margin: auto;
            padding: 10px;
            border: 1px dashed black;
        }
        .center {
            text-align: center;
        }
        .separator {
            border-top: 1px dashed black;
            margin: 5px 0;
        }
        .right {
            text-align: right;
        }
        .bold {
            font-weight: bold;
        }
    </style>
</head>
<body onload="print()">
    <div class="center bold">TOKO FreshFruitsHaven</div>
    <div class="center">Jl. Bandung Barat No. 123, Kota</div>
    <div class="center">Telp: 0821-1618-9002</div>
    <div class="separator"></div>
    <div><strong>No Invoice:</strong> {{ $transaksiAktif->kode }}</div>
    <div><strong>Tanggal:</strong> {{ $transaksiAktif->created_at->setTimezone('Asia/Jakarta')->format('d/m/Y H:i:s') }}</div>
    <div class="separator"></div>
    <div>
        @if($transaksiAktif->detailTransaksi && count($transaksiAktif->detailTransaksi) > 0)
            @foreach($transaksiAktif->detailTransaksi as $item)
                {{ optional($item->produk)->nama ?? '-' }}
                <br>
                {{ $item->jumlah }} x Rp. {{ number_format(optional($item->produk)->harga ?? 0, 0, ',', '.') }}
                <span class="right">Rp. {{ number_format(($item->jumlah ?? 0) * (optional($item->produk)->harga ?? 0), 0, ',', '.') }}</span>
                <br>
            @endforeach
        @endif
    </div>
    <div class="separator"></div>
    <div class="bold right">Total: Rp. {{ number_format($transaksiAktif->total, 0, ',', '.') }}</div>
    <div class="bold right">Bayar: Rp. {{ number_format($transaksiAktif->bayar, 0, ',', '.') }}</div>
    <div class="bold right">Kembalian: Rp. {{ number_format($transaksiAktif->bayar - $transaksiAktif->total, 0, ',', '.') }}</div>
    <div class="separator"></div>
    <div class="center">*** TERIMA KASIH ***</div>
    <div class="center">Barang yang sudah dibeli</div>
    <div class="center">tidak dapat dikembalikan</div>
</body>
</html>
