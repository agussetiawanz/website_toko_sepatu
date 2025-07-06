<div class="container py-4" style="background-color: #ffffff; min-height: 100vh; border-radius: 10px;">
    <div class="row mt-3">
        <div class="col-12 text-center">
            @if($transaksiAktif)
                <button class="btn btn-danger px-4 py-2" wire:click='batalTransaksi' style="font-weight: bold;">❌ Batalkan Transaksi</button>
            @else
                <button class="btn btn-primary text-white px-4 py-2" wire:click='transaksiBaru' style="font-weight: bold;">➕ Transaksi Baru</button>
            @endif
            <button class="btn btn-outline-primary px-4 py-2" wire:loading>⏳ Loading...</button>
        </div>
    </div>

    @if(!$transaksiAktif)
        <div class="row mt-2">
            <div class="col-12 text-center">
                <p class="text-primary fw-bold">Klik <strong>"Transaksi Baru"</strong> untuk memulai transaksi.</p>
            </div>
        </div>
    @endif

    @if($transaksiAktif)
        <div class="row mt-4">
            <div class="col-lg-8">
                <div class="card border-primary mb-3">
                    <div class="card-body">
                        <h4 class="card-title text-primary fw-bold">No Invoice: {{ $transaksiAktif->kode }}</h4>
                        <p class="mb-0">👤 Kasir: <strong>{{ auth()->user()->name }}</strong></p>

                        <div class="mb-3 mt-3">
                            <label class="form-label text-primary fw-bold">Kode Barang</label>
                            <input type="text" class="form-control" placeholder="Masukkan Kode Barang" wire:model.lazy="kode">
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-primary fw-bold">Jumlah Barang</label>
                            <input type="number" class="form-control" placeholder="Masukkan Jumlah" wire:model.lazy="jumlah">
                        </div>

                        <button class="btn btn-primary w-100" wire:click="tambahProduk" style="font-weight: bold;">
                            ➕ Tambah Barang
                        </button>

                        <table class="table table-bordered text-center mt-4">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>No</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Sub Total</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($semuaProduk as $produk)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $produk->produk->kode }}</td>
                                        <td>{{ $produk->produk->nama }}</td>
                                        <td>Rp {{ number_format($produk->produk->harga, 2, ',', '.') }}</td>
                                        <td>{{ $produk->jumlah }}</td>
                                        <td>Rp {{ number_format($produk->produk->harga * $produk->jumlah, 2, ',', '.') }}</td>
                                        <td>
                                            <button class="btn btn-danger btn-sm" wire:click="hapusProduk({{ $produk->id }})">🗑 Hapus</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">Belum ada barang yang ditambahkan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-primary mb-3">
                    <div class="card-body">
                        <h5 class="fw-bold text-primary">Total dan Diskon</h5>
                        <div class="d-flex justify-content-between">
                            <p>Total:</p>
                            <p class="text-primary">Rp {{ number_format($totalSemuaBelanja, 2, ',', '.') }}</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p>Diskon Otomatis:</p>
                            <p class="text-warning">{{ $diskon }}%</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p>Potongan Harga:</p>
                            <p class="text-danger">- Rp {{ number_format($potonganDiskon, 2, ',', '.') }}</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p>Total Setelah Diskon:</p>
                            <p class="text-success">Rp {{ number_format($totalSetelahDiskon, 2, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <div class="card border-primary mb-3">
                    <div class="card-body">
                        <h5 class="fw-bold text-primary">Bayar</h5>
                        <input type="number" class="form-control text-center" placeholder="Masukkan Nominal" wire:model.lazy="bayar">
                    </div>
                </div>

                <div class="card border-primary text-center mb-3">
                    <div class="card-body">
                        <h5 class="fw-bold text-primary">Kembalian</h5>
                        <h2 class="fw-bold text-success">Rp {{ number_format($kembalian, 2, ',', '.') }}</h2>
                    </div>
                </div>

                @if (!is_null($bayar))
                    @if ($kembalian < 0)
                        <div class="alert alert-danger mt-2 text-center" role="alert">
                            Uang kurang!
                        </div>
                    @else
                        <button class="btn btn-success w-100 mt-3" wire:click="transaksiSelesai">
                            Bayar Sekarang
                        </button>
                        <button class="btn btn-info w-100 mt-2" wire:click="cetakNota">Cetak Nota</button>
                    @endif
                @endif
            </div>
        </div>
    @endif
</div>
