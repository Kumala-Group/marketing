<?php

namespace App\Http\Controllers\Carimobilku;

use App\Http\Controllers\Controller;
use App\Models\UnitModel;
use Illuminate\Http\Request;

class GarasiController extends Controller
{
    private static $website = 'carimobilku';
    public function index(Request $request)
    {
        if ($request->exists('getfilter')) {
            $result = UnitModel::select('brand')->groupBy('brand')->get();
            foreach ($result as $key => $value) {
                $data['brand'][] = [
                    "id" => $value->brand,
                    "text" => $value->brand
                ];
            }
            $result = UnitModel::select('transmisi')->groupBy('transmisi')->get();
            foreach ($result as $key => $value) {
                $data['transmisi'][] = [
                    "id" => $value->transmisi,
                    "text" => $value->transmisi
                ];
            }
            $result = UnitModel::select('lokasi')->groupBy('lokasi')->get();
            foreach ($result as $key => $value) {
                $data['lokasi'][] = [
                    "id" => $value->lokasi,
                    "text" => $value->lokasi
                ];
            }
            $result = UnitModel::select('bahan_bakar')->groupBy('bahan_bakar')->get();
            foreach ($result as $key => $value) {
                $data['bahan_bakar'][] = [
                    "id" => $value->bahan_bakar,
                    "text" => $value->bahan_bakar
                ];
            }
            $result = UnitModel::select('tempat_duduk')->groupBy('tempat_duduk')->get();
            foreach ($result as $key => $value) {
                $data['tempat_duduk'][] = [
                    "id" => $value->tempat_duduk,
                    "text" => $value->tempat_duduk
                ];
            }
            $result = UnitModel::select('warna')->groupBy('warna')->get();
            foreach ($result as $key => $value) {
                $data['warna'][] = [
                    "id" => $value->warna,
                    "text" => $value->warna
                ];
            }
            return response()->json([
                'status' => true,
                'data'   => $data
            ]);
        }

        $inventories = UnitModel::orderBy('created_at', 'desc');
        if (isset($request->brand)) {
            $inventories = $inventories->whereBrand($request->brand);
        }
        if (isset($request->harga_awal)) {
            $inventories = $inventories->where('harga', '>=', $request->harga_awal);
        }
        if (isset($request->harga_akhir)) {
            $inventories = $inventories->where('harga', '<=', $request->harga_akhir);
        }
        if (isset($request->harga_awal) && isset($request->harga_akhir)) {
            $inventories = $inventories->whereBetween('harga', [$request->harga_awal, $request->harga_akhir]);
        }
        if (isset($request->transmisi)) {
            $inventories = $inventories->whereTransmisi($request->transmisi);
        }
        if (isset($request->kilometer)) {
            if ($request->kilometer < 200000) {
                $inventories = $inventories->where('kilometer', '<', $request->kilometer);
            } else {
                $inventories = $inventories->where('kilometer', '>=', $request->kilometer);
            }
        }
        if (isset($request->lokasi)) {
            $inventories = $inventories->whereLokasi($request->lokasi);
        }
        if (isset($request->bahan_bakar)) {
            $inventories = $inventories->whereBahan_bakar($request->bahan_bakar);
        }
        if (isset($request->tempat_duduk)) {
            $inventories = $inventories->whereTempat_duduk($request->tempat_duduk);
        }
        if (isset($request->warna)) {
            $inventories = $inventories->whereWarna($request->warna);
        }
        if (isset($request->tahun_awal)) {
            $inventories = $inventories->where('tahun', '>=', $request->tahun_awal);
        }
        if (isset($request->tahun_akhir)) {
            $inventories = $inventories->where('tahun', '<=', $request->tahun_akhir);
        }
        if (isset($request->tahun_awal) && isset($request->tahun_akhir)) {
            $inventories = $inventories->whereBetween('tahun', [$request->tahun_awal, $request->tahun_akhir]);
        }
        $inventories = $inventories->paginate(6);

        return response()->json([
            'status' => true,
            'data' => [
                'inventories' => $inventories->items(),
                'links' => (string) $inventories->links(),
                'uri' => '?' . http_build_query($request->all())
            ],
        ]);
    }

    public function detail($slug)
    {
        $inventory = UnitModel::with(['toGaleri' => function ($query) {
            $query->whereJenis(self::$website);
        }])
            ->whereSlug($slug)
            ->first();
        $related = UnitModel::where('slug', '!=', $slug)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return response()->json([
            'status' => true,
            'data' => [
                'inventory' => $inventory,
                'related' => $related
            ]
        ]);
    }
}
