<?php

namespace App\Livewire;

use App\Models\User as ModelsUser;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class User extends Component
{

    public $pilihanMenu = 'lihat';
    public $nama, $email, $password, $peran, $penggunaTerpilih;
    public $semuaPengguna = [];

    public function pilihMenu($menu){
        $this->pilihanMenu = $menu;
    }

    public function mount(){
        if (Auth::user()->role != 'admin') {
            abort(403);
        }

        $this->fetchData();
    }

    public function fetchData(){
        $this->semuaPengguna = ModelsUser::all();
    }

    // Simpan
    public function simpan(){
        $this->validate([
            'nama'      => 'required',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required',
            'peran'     => 'required',
        ],[
            'nama.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password harus diisi.',
            'peran.required' => 'Peran harus diisi.',
        ]);

        try {
            $simpan = new ModelsUser();
            $simpan->name = $this->nama;
            $simpan->email = $this->email;
            $simpan->password = bcrypt($this->password);
            $simpan->role = $this->peran;
            $simpan->save();

            $this->reset('nama', 'email', 'password', 'peran');
            $this->pilihMenu('lihat');
            $this->dispatch('alert', message: 'Data Berhasil ditambahkan', type: 'success');
            $this->fetchData();
        } catch (\Throwable $th) {
            $this->dispatch('alert', message: 'Data Gagal ditambahkan', type: 'error');
        }
    }

    // Hapus
    public  function pilihHapus($id){
        $this->penggunaTerpilih = ModelsUser::findOrFail($id);
        $this->pilihanMenu = 'hapus';
    }

    public function hapus(){
        try {
            $this->penggunaTerpilih->trashed();
            $this->pilihMenu('lihat');
            $this->dispatch('alert', message: 'Data Berhasil dihapus', type: 'success');
            $this->fetchData();
        } catch (\Throwable $th) {
            $this->dispatch('alert', message: 'Data Gagal dihapus', type: 'error');
        }
        
    }

    public function batal(){
        // Reset semua input dan data terpilih
        $this->reset();
    
        // Kembali ke tampilan "Semua Produk"
        $this->pilihanMenu = 'lihat';
    
        // Ambil ulang data produk
        $this->fetchData();
    }
    

    // Edit
    public function pilihEdit($id){
        $this->penggunaTerpilih = ModelsUser::findOrFail($id);
        $this->nama  = $this->penggunaTerpilih->name;
        $this->email = $this->penggunaTerpilih->email;
        $this->peran = $this->penggunaTerpilih->role;
        $this->pilihanMenu = 'edit';
    }

    public function simpanEdit(){
        $this->validate([
            'nama'   => 'required',
            'email'  => 'required|email|unique:users,email,'.$this->penggunaTerpilih->id,            
            'peran'   => 'required',
        ],[
            'nama.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'peran.required' => 'Peran harus diisi.',
        ]);

        try {
            $simpan = $this->penggunaTerpilih;
            $simpan->name = $this->nama;
            $simpan->email = $this->email;
            if ($this->password) {
                $simpan->password = bcrypt($this->password);
            }

            $simpan->role = $this->peran;
            $simpan->save();

            $this->reset('nama', 'email', 'penggunaTerpilih', 'peran');
            $this->pilihMenu('lihat');
            $this->dispatch('alert', message: 'Data Berhasil diperbarui', type: 'success'); 
            $this->fetchData();
        } catch (\Throwable $th) {
            $this->dispatch('alert', message: 'Data Gagal diperbarui', type: 'error'); 
        }
    }

    public function render()
    {
        return view('livewire.user');
    }
}