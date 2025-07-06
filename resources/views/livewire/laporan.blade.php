<div class="container mt-4">
    <div class="card shadow-sm rounded-4 border-0" style="background-color: #e3f2fd;">
        <div class="card-body">
            <h4 class="card-title text-center mb-4 fw-bold" style="color: #1976d2;">Laporan Transaksi</h4>

            <!-- Form Filter -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <label for="month" class="form-label fw-semibold" style="color: #1565c0;">Pilih Bulan</label>
                    <select wire:model="month" class="form-control border-0 shadow-sm rounded-3" style="background-color: #ffffff;">
                        <option value="">--Pilih Bulan--</option>
                        @foreach (range(1, 12) as $m)
                            <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}">
                                {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="start_date" class="form-label fw-semibold" style="color: #1565c0;">Dari Tanggal</label>
                    <input type="date" class="form-control border-0 shadow-sm rounded-3" style="background-color: #ffffff;" wire:model="start_date">

                    <label for="end_date" class="form-label mt-3 fw-semibold" style="color: #1565c0;">Hingga Tanggal</label>
                    <input type="date" class="form-control border-0 shadow-sm rounded-3" style="background-color: #ffffff;" wire:model="end_date">
                </div>

                <div class="col-md-4 d-flex align-items-end">
                    <button class="btn rounded-pill px-4 py-2 fw-semibold shadow-sm" style="background-color: #1976d2; color: white;" wire:click="$refresh">
                        Tampilkan Laporan
                    </button>
                </div>
            </div>

            <!-- Tombol Cetak -->
            <div class="mb-3">
                <a href="{{ url('/cetak') }}" target="_blank" class="btn rounded-pill px-4 py-2 shadow-sm" style="background-color: #0d47a1; color: white;">Cetak</a>
            </div>

            <!-- Tabel Laporan -->
            <div class="table-responsive">
                <table class="table table-bordered rounded-3 overflow-hidden">
                    <thead style="background-color: #bbdefb;">
                        <tr class="text-center" style="color: #0d47a1;">
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>No. Inv.</th>
                            <th>Total</th>
                            <th>Kasir</th>
                        </tr>
                    </thead>
                    <tbody style="background-color: #ffffff;">
                        @forelse ($semuaTransaksi as $transaksi)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ \Carbon\Carbon::parse($transaksi->created_at)->format('d-m-Y') }}</td>
                                <td>{{ $transaksi->kode }}</td>
                                <td>Rp {{ number_format($transaksi->total, 2, ',', '.') }}</td>
                                <td>{{ $transaksi->kasir->name ?? 'rhena kasir' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Tidak ada transaksi ditemukan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
