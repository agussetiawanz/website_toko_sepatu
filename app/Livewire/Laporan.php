<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\View\View;
use App\Models\Transaksi;
use Carbon\Carbon;

class Laporan extends Component
{
    public $filterType = 'all';
    public $tanggal;
    public $bulan;
    public $tahun;
    public $results = [];
    public $showFilter = false; // Add this line
    public $searchInvoice = '';

    public function mount()
    {
        $this->tanggal = Carbon::now()->format('Y-m-d');
        $this->bulan = Carbon::now()->format('Y-m');
        $this->tahun = Carbon::now()->format('Y');
        $this->showFilter = false; // Add this line
        $this->cariData(); // Load initial data
    }

    public function updatedFilterType()
    {
        $this->resetData();
    }

    private function resetData()
    {
        $now = Carbon::now();
        switch ($this->filterType) {
            case 'daily':
                $this->tanggal = $now->format('Y-m-d');
                break;
            case 'monthly':
                $this->bulan = $now->format('Y-m');
                break;
            case 'yearly':
                $this->tahun = $now->format('Y');
                break;
        }
    }

    public function cariData()
    {
        $query = Transaksi::where('status', 'selesai');

        switch ($this->filterType) {
            case 'all':
                // Don't apply any date filters
                break;
            case 'daily':
                $query->when($this->tanggal, function($q) {
                    return $q->whereDate('created_at', $this->tanggal);
                });
                break;
            case 'monthly':
                if ($this->bulan) {
                    $date = Carbon::parse($this->bulan);
                    $query->whereYear('created_at', $date->year)
                          ->whereMonth('created_at', $date->month);
                }
                break;
            case 'yearly':
                if ($this->tahun) {
                    $query->whereYear('created_at', $this->tahun);
                }
                break;
        }

        $this->results = $query->get();
    }

    public function filter()
    {
        $this->cariData();
    }

    public function search()
    {
        $query = Transaksi::where('status', 'selesai');

        if (!empty($this->searchInvoice)) {
            // Menggunakan LIKE dengan case-insensitive
            $searchTerm = strtoupper($this->searchInvoice);
            $query->whereRaw('UPPER(kode) LIKE ?', ['%' . $searchTerm . '%']);
        }

        $this->results = $query->get();
    }

    public function getCurrentFilterParams()
    {
        $params = ['type' => $this->filterType];

        switch ($this->filterType) {
            case 'daily':
                $params['tanggal'] = $this->tanggal;
                break;
            case 'monthly':
                $params['bulan'] = $this->bulan;
                break;
            case 'yearly':
                $params['tahun'] = $this->tahun;
                break;
        }

        if ($this->searchInvoice) {
            $params['search'] = $this->searchInvoice;
        }

        return $params;
    }

    public function getDetailUrl($transaksiId)
    {
        return url("/cetak-detail/{$transaksiId}");
    }

    public function render(): View
    {
        return view('livewire.laporan', [
            'semuaTransaksi' => $this->results
        ]);
    }
}