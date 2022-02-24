<?php

namespace App\Http\Controllers\Mazda;

use App\Http\Controllers\Controller;
use App\Models\MazdaUnit;
use App\Models\MazdaUnitsDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class MazdaProduk extends Controller
{   
    public static $brand = 4;
    public function detail($item)
    {
        $id = $item;   
        $product = MazdaUnit::with(['toModels' => function ($query) {
            $query->whereBrand(self::$brand);
        }])
        ->whereId($id)
        ->first();

        $Detail_tambahan = MazdaUnitsDetail::selectRaw('units_detail.deskripsi as detailTambahan')
                                       ->leftJoin('units','units.id','=','units_detail.unit')
                                       ->where('units.id','=',$id)
                                       ->where('units_detail.detail','=','detail')
                                       ->where('units.brand','=',self::$brand)->get();

        $Detail_warna = MazdaUnitsDetail::selectRaw('units_detail.deskripsi,units_detail.gambar,colors.nama_warna,units.deskripsi as detailProduk')
                                       ->leftJoin('colors','colors.id','=','units_detail.nama_detail')
                                       ->leftJoin('units','units.id','=','units_detail.unit')
                                       ->where('units.id','=',$id)
                                       ->where('units_detail.detail','=','warna')
                                       ->where('units.brand','=',self::$brand)->get();

        return response()->json([
            'status' => true,
            'data' => [
                'product' => $product,
                'warna'=>$Detail_warna,
                'detail_tambahan' => $Detail_tambahan
            ]
        ]);
    }
}
