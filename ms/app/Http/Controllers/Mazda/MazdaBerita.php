<?php

namespace App\Http\Controllers\Mazda;

use App\Http\Controllers\Controller;
use App\Models\BeritaModel;
use Illuminate\Http\Request;

class MazdaBerita extends Controller
{
    private static $website = 'mazda';
    public function index()
    {
        $blogs = BeritaModel::whereWebsite(self::$website)
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        return response()->json([
            'status' => true,
            'data' => [
                'blogs' => $blogs->items(),
                'links' => (string) $blogs->links()
            ]
        ]);
    }

    public function detail($slug)
    {
        $blog = BeritaModel::whereSlug($slug)
            ->whereWebsite(self::$website)
            ->first();
        
        return response()->json([
            'status' => true,
            'data' => [
                'blog' => $blog
            ]
        ]);
    }
}
