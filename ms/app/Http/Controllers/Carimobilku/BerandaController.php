<?php

namespace App\Http\Controllers\Carimobilku;

use App\Http\Controllers\Controller;
use App\Models\BeritaModel;
use App\Models\SliderModel;
use App\Models\UnitModel;

class BerandaController extends Controller
{
    private static $website = 'carimobilku';
    public function index()
    {
        $sliders = SliderModel::where('kategori','like','%'.self::$website.'%')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        $inventories = UnitModel::orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        $blogs = BeritaModel::where('type', '!=', 'promo')
            ->whereWebsite(self::$website)
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        return response()->json([
            'status' => true,
            'data' => [
                'sliders' => $sliders,
                'inventories' => $inventories,
                'blogs' => $blogs
            ]
        ]);
    }
}
