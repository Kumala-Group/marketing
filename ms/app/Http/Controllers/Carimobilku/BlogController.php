<?php

namespace App\Http\Controllers\Carimobilku;

use App\Http\Controllers\Controller;
use App\Models\BeritaModel;

class BlogController extends Controller
{
    private static $website = 'carimobilku';
    public function index()
    {
        $blogs = BeritaModel::where('type', '!=', 'promo')
            ->whereWebsite(self::$website)
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
            ->first();
        $related = BeritaModel::where('slug', '!=', $slug)
            ->where('type', '!=', 'promo')
            ->whereWebsite(self::$website)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return response()->json([
            'status' => true,
            'data' => [
                'blog' => $blog,
                'related' => $related
            ]
        ]);
    }
}
