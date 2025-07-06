<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Produk as ModelProduk;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\Produk as ImportProduk;
use Illuminate\Support\Facades\Auth;

class Produk extends Component
{
    use WithFileUploads;

    public $pilihanMenu = 'lihat';
    public $kode, $nama, $harga, $stok;
    public $produkTerpilih;
    public $fileExcel;

    public function importExcel()
    {
        Excel::import(new ImportProduk, $this->fileExcel);
        $this->reset();
    }


    public function pilihMenu($menu): void
    {
        $this->pilihanMenu = $menu;
        $this->resetExcept('pilihanMenu'); // Reset semua kecuali pilihanMenu
    }

    public function render()
    {
        return view('livewire.produk', [
            'semuaProduk' => ModelProduk::all()
        ]);
    }

    public function simpan(): void
    {
        $validatedData = $this->validate([
            'kode'  => 'required|unique:produks,kode',
            'nama'  => 'required',
            'harga' => 'required|integer|min:1',
            'stok'  => 'required|integer|min:0',
        ]);

        ModelProduk::create($validatedData);

        $this->resetExcept('pilihanMenu');
        $this->pilihMenu('lihat');
    }

    public function pilihEdit($id): void
    {
        $this->produkTerpilih = ModelProduk::find($id);

        if (!$this->produkTerpilih) {
            return;
        }

        $this->kode  = $this->produkTerpilih->kode;
        $this->nama  = $this->produkTerpilih->nama;
        $this->harga = $this->produkTerpilih->harga;
        $this->stok  = $this->produkTerpilih->stok;
        $this->pilihanMenu = 'edit';
    }

    public function simpanEdit(): void
    {
        if (!$this->produkTerpilih) {
            return;
        }

        $validatedData = $this->validate([
            'kode'  => 'required|unique:produks,kode,' . $this->produkTerpilih->id,
            'nama'  => 'required',
            'harga' => 'required|integer|min:1',
            'stok'  => 'required|integer|min:0',
        ]);

        $this->produkTerpilih->update($validatedData);

        $this->resetExcept('pilihanMenu');
        $this->pilihMenu('lihat');
    }

    public function pilihHapus($id): void
    {
        $this->produkTerpilih = ModelProduk::find($id);

        if ($this->produkTerpilih) {
            $this->pilihanMenu = 'hapus';
        }
    }

    public function hapus(): void
    {
        if ($this->produkTerpilih) {
            $this->produkTerpilih->delete();
        }

        $this->resetExcept('pilihanMenu');
        $this->pilihMenu('lihat');
    }

    public function batal(): void
    {
        $this->resetExcept('pilihanMenu');
        $this->pilihMenu('lihat');
    }

    public function imporExcel(): void
    {
        $this->validate([
            'fileExcel' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(new ImportProduk, $this->fileExcel);
        $this->resetExcept('pilihanMenu');
    }
    public function mount(): void
{
    if (Auth::user()->role !== 'admin') {
        abort(403);
    }
}

}