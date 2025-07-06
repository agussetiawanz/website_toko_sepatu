<div class="container">
    <style>
        .btn-primary, .bg-primary {
            background-color: #007bff !important;
            border-color: #007bff !important;
        }

        .btn-outline-primary {
            border-color: #007bff;
            color: #007bff;
            background-color: white;
        }

        .btn-outline-primary:hover {
            background-color: #007bff;
            color: white;
        }

        .table-bordered th,
        .table-bordered td {
            border-color: #cce5ff !important;
        }

        .card.border-primary {
            border-color: #007bff !important;
        }

        .card-header.bg-primary {
            background-color: #007bff !important;
            border-color: #007bff !important;
            color: white !important;
        }

        .btn-info {
            background-color: #cce5ff;
            border-color: #cce5ff;
            color: #004085;
        }
    </style>

    <div class="row my-2">
        <div class="col-12">
            <button wire:click="pilihMenu('lihat')" class="btn {{ $pilihanMenu == 'lihat' ? 'btn-primary' : 'btn-outline-primary' }}">
                Semua Produk
            </button>
            <button wire:click="pilihMenu('tambah')" class="btn {{ $pilihanMenu == 'tambah' ? 'btn-primary' : 'btn-outline-primary' }}">
                Tambah Produk
            </button>
            <button wire:click="pilihMenu('excel')" class="btn {{ $pilihanMenu == 'excel' ? 'btn-primary' : 'btn-outline-primary' }}">
                Impor Produk
            </button>
            <button wire:loading class="btn btn-info">
                Loading ...
            </button>
        </div>
    </div>

    <div class="row my-2">
        <div class="col-12">
            @if ($pilihanMenu == 'lihat')
                <!-- Tampilan Semua Produk -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($semuaProduk as $produk)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $produk->gambar }}</td>
                                <td>{{ $produk->kode }}</td>
                                <td>{{ $produk->nama }}</td>
                                <td>{{ $produk->harga }}</td>
                                <td>{{ $produk->stok }}</td>
                                <td>
                                    <button wire:click="pilihEdit({{ $produk->id }})"
                                        class="btn {{ $pilihanMenu == 'edit' ? 'btn-primary' : 'btn-outline-primary' }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button wire:click="pilihHapus({{ $produk->id }})" class="btn btn-danger">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            @elseif ($pilihanMenu == 'tambah')
                <!-- Tambah Produk -->
                <h4>Tambah Produk</h4>
                <form wire:submit='simpan' method="post">
                    <label for="kode">Kode</label>
                    <input type="text" class="form-control" wire:model='kode'>
                    @error('kode') <span class="text-danger">{{ $message }}</span> @enderror
                    <br>

                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" wire:model='nama'>
                    @error('nama') <span class="text-danger">{{ $message }}</span> @enderror
                    <br>

                    <label for="harga">Harga</label>
                    <input type="number" class="form-control" wire:model='harga'>
                    @error('harga') <span class="text-danger">{{ $message }}</span> @enderror
                    <br>

                    <label for="stok">Stok</label>
                    <input type="number" class="form-control" wire:model='stok'>
                    @error('stok') <span class="text-danger">{{ $message }}</span> @enderror
                    <br>

                    <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                </form>

            @elseif ($pilihanMenu == 'edit')
                <!-- Edit Produk -->
                <h4>Edit Produk</h4>
                <form wire:submit='simpanEdit' method="post">
                    <label for="kode">Kode</label>
                    <input type="text" class="form-control" wire:model='kode'>
                    @error('kode') <span class="text-danger">{{ $message }}</span> @enderror
                    <br>

                    <label for="nama">Nama</label>
                    <input type="text" class="form-control" wire:model='nama'>
                    @error('nama') <span class="text-danger">{{ $message }}</span> @enderror
                    <br>

                    <label for="harga">Harga</label>
                    <input type="number" class="form-control" wire:model='harga'>
                    @error('harga') <span class="text-danger">{{ $message }}</span> @enderror
                    <br>

                    <label for="stok">Stok</label>
                    <input type="number" class="form-control" wire:model='stok'>
                    @error('stok') <span class="text-danger">{{ $message }}</span> @enderror
                    <br>

                    <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                    <button type="button" wire:click="pilihMenu('lihat')" class="btn btn-secondary mt-3">Batal</button>
                </form>

            @elseif ($pilihanMenu == 'hapus' && isset($produkTerpilih))
                <!-- Konfirmasi Hapus -->
                <div class="card border-primary mt-2">
                    <div class="card-header bg-danger text-white">
                        Hapus Produk
                    </div>
                    <div class="card-body">
                        <p>Anda yakin ingin menghapus produk ini?</p>
                        <p>Nama: {{ $produkTerpilih->nama }}</p>
                        <button class="btn btn-danger" wire:click='hapus'>HAPUS</button>
                        <button class="btn btn-secondary" wire:click='batal'>BATAL</button>
                    </div>
                </div>

            @elseif ($pilihanMenu == 'excel')
                <!-- Import Excel -->
                <div class="card border-primary">
                    <div class="card-header bg-primary text-white">
                        Import Produk
                    </div>
                    <div class="card-body">
                        <form wire:submit="importExcel">
                            <input type="file" class="form-control" wire:model="fileExcel">
                            <br>
                            <button class="btn btn-primary" type="submit">Kirim</button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
