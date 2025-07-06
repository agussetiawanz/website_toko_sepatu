<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Transaksi as ModelsTransaksi;
use App\Models\DetailTransaksi;
use App\Models\Produk;
use Barryvdh\DomPDF\Facade\Pdf;

class Transaksi extends Component
{
    use WithFileUploads;

    public $kode, $jumlah = 1, $totalSemuaBelanja = 0, $bayar = 0, $kembalian = 0;
    public $transaksiAktif = null;
    public $errorMessage = null;
    public $cetakNotaSiap = false;

    public $diskon = 0; // diskon dalam persen
    public $potonganDiskon = 0;
    public $totalSetelahDiskon = 0;

    public function mount()
    {
        $this->diskon = 0;
        $this->potonganDiskon = 0;
        $this->totalSetelahDiskon = 0;
    }

    public function transaksiBaru(): void
    {
        try {
            $this->resetExcept(['diskon']);
            $this->transaksiAktif = ModelsTransaksi::create([
                'kode' => 'INV' . date('YmdHis'),
                'total' => 0,
                'status' => 'pending',
            ]);
        } catch (\Exception $e) {
            $this->errorMessage = "Gagal membuat transaksi: " . $e->getMessage();
        }
    }

    public function batalTransaksi(): void
    {
        if ($this->transaksiAktif) {
            $detilTransaksi = DetailTransaksi::where('transaksi_id', $this->transaksiAktif->id)->get();

            foreach ($detilTransaksi as $detil) {
                $produk = Produk::find($detil->produk_id);
                if ($produk) {
                    $produk->increment('stok', $detil->jumlah);
                }
                $detil->delete();
            }

            $this->transaksiAktif->delete();
            $this->transaksiAktif = null;
        }
        $this->resetExcept(['diskon']);
    }

    public function updatedKode(): void
    {
        if (!$this->transaksiAktif) {
            $this->transaksiBaru();
        }

        $produk = Produk::where('kode', $this->kode)->first();

        if (!$produk) {
            $this->errorMessage = "Kode barang tidak ditemukan!";
            return;
        }

        if ($produk->stok < $this->jumlah) {
            $this->errorMessage = "Stok tidak mencukupi!";
            return;
        }

        $detil = DetailTransaksi::firstOrNew([
            'transaksi_id' => $this->transaksiAktif->id,
            'produk_id' => $produk->id,
        ]);

        $detil->jumlah = ($detil->jumlah ?? 0) + $this->jumlah;
        $detil->save();
        $produk->decrement('stok', $this->jumlah);

        $this->reset('kode', 'jumlah', 'errorMessage');
        $this->hitungTotal();
    }

    public function hapusProduk($id)
    {
        $detil = DetailTransaksi::find($id);

        if ($detil) {
            $produk = Produk::find($detil->produk_id);
            if ($produk) {
                $produk->increment('stok', $detil->jumlah);
            }
            $detil->delete();
        }

        $this->hitungTotal();
    }

    private function hitungTotal(): void
    {
        if ($this->transaksiAktif) {
            $this->totalSemuaBelanja = DetailTransaksi::where('transaksi_id', $this->transaksiAktif->id)
                ->get()
                ->sum(fn($detil) => $detil->jumlah * $detil->produk->harga);
        } else {
            $this->totalSemuaBelanja = 0;
        }

        $this->hitungDiskon();
        $this->updatedBayar();
    }

    private function hitungDiskon(): void
    {
        // Misal: diskon otomatis 10% jika total belanja >= 100.000
        $this->diskon = $this->totalSemuaBelanja >= 100000 ? 10 : 0;

        $this->potonganDiskon = ($this->diskon / 100) * $this->totalSemuaBelanja;
        $this->totalSetelahDiskon = $this->totalSemuaBelanja - $this->potonganDiskon;
    }

    public function updatedBayar()
    {
        $this->bayar = (float) $this->bayar;
        $this->totalSetelahDiskon = (float) $this->totalSetelahDiskon;
        $this->kembalian = $this->bayar - $this->totalSetelahDiskon;
    }

    public function transaksiSelesai(): void
    {
        if (!$this->transaksiAktif) {
            return;
        }

        $this->transaksiAktif->update([
            'total' => $this->totalSetelahDiskon,
            'status' => 'selesai',
        ]);

        $this->cetakNotaSiap = true;
    }

    public function cetakNota()
    {
        if (!$this->transaksiAktif) {
            session()->flash('error', 'Tidak ada transaksi aktif!');
            return;
        }

        $transaksi = ModelsTransaksi::with('detilTransaksi.produk')->find($this->transaksiAktif->id);

        if (!$transaksi) {
            session()->flash('error', 'Transaksi tidak ditemukan!');
            return;
        }

        $bayar = $this->bayar;
        $kembalian = $this->kembalian;

        $pdf = Pdf::loadView('nota', compact('transaksi', 'bayar', 'kembalian'));

        $this->reset();
        $this->cetakNotaSiap = false;

        return response()->streamDownload(fn () => print($pdf->output()), 'Nota_Transaksi_' . $transaksi->id . '.pdf');
    }

    public function render()
    {
        $semuaProduk = $this->transaksiAktif
            ? DetailTransaksi::where('transaksi_id', $this->transaksiAktif->id)->get()
            : collect();

        return view('livewire.transaksi', compact('semuaProduk'));
    }
}
