<?php
namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Produk as ModelProduk;
use Maatwebsite\Excel\Concerns\WithStartRow;

class Produk implements ToCollection, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection): void
    {
        foreach ($collection as $col) {
            $kodebd = ModelProduk::where(column: 'kode', operator: $col[0])->first();
            if (!$kodebd) {
                $impan = new ModelProduk;
                $impan->kode = $col[1];
                $impan->nama = $col[2];
                $impan->harga = $col[3];
                $impan->stok = 10;
                $impan->save();
            }
        }
    }
}