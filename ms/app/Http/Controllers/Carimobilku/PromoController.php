<?php

namespace App\Http\Controllers\Carimobilku;

use App\Http\Controllers\Controller;
use App\Models\BeritaModel;

class PromoController extends Controller
{
    private static $website = 'carimobilku';
    public function index()
    {
        $promos = BeritaModel::where('type', '=', 'promo')
            ->whereWebsite(self::$website)
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        return response()->json([
            'status' => true,
            'data' => [
                'promos' => $promos->items(),
                'links' => (string) $promos->links()
            ]
        ]);
    }

    public function detail($slug)
    {
        $promo = BeritaModel::whereSlug($slug)
            ->first();

        return response()->json([
            'status' => true,
            'data' => $promo
        ]);
    }
}
