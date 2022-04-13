<?php

namespace App\Http\Controllers\Mazda;

use App\Http\Controllers\Controller;
use App\Models\BeritaModel;
use App\Models\MazdaUnit;
use App\Models\SliderModel;

class MazdaBeranda extends Controller
{
    private static $website = 'mazda';
    public function index()
    {
        $sliders = SliderModel::Where('kategori','like','%'.self::$website)
            ->orderBy('created_at', 'desc')
            ->get();
        $inventories = MazdaUnit::with(array('toModels'))
            ->whereBrand('4')
            ->whereisDeleted('0')
            ->orderBy('created_at', 'desc')
            ->get();
        $blogs = BeritaModel::where('type', '!=', 'promo')
            ->whereWebsite(self::$website)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return response()->json([
            'status' => true,
            'data' => [
                'sliders'     => $sliders,
                'inventories' => $inventories,
                'blogs'       => $blogs
            ]
        ]);
    }
}
