<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade\Pdf;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home');
    }

    // Cetak laporan berdasarkan filter dan langsung download PDF
    public function cetak(Request $request)
    {
        $query = Transaksi::query();

        if ($request->filter == 'bulan' && $request->bulan) {
            $query->whereMonth('created_at', date('m', strtotime($request->bulan)))
                  ->whereYear('created_at', date('Y', strtotime($request->bulan)));
        }

        if ($request->filter == 'rentang' && $request->tanggal_awal && $request->tanggal_akhir) {
            $query->whereBetween('created_at', [$request->tanggal_awal, $request->tanggal_akhir]);
        }

        $semuaTransaksi = $query->get();

        $pdf = Pdf::loadView('cetak', [
            'semuaTransaksi' => $semuaTransaksi
        ])->setPaper('A4', 'portrait');

        return $pdf->download('laporan-transaksi-' . now()->format('Ymd-His') . '.pdf');
    }
}