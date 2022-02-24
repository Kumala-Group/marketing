<?php

namespace App\Http\Controllers\Carimobilku;

use App\Http\Controllers\Controller;
use App\Models\KontakModel;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;

class HubungiController extends Controller
{
    public function index(Request $request, KontakModel $kontak)
    {
        $request->validate([
            'nama' => 'required|string',
            'email' => 'required|email',
            'telepon' => 'required|numeric',
            'pesan' => 'required|string',
            'website' => 'required|string',
        ]);

        try {
            $kontak->create($request->all());

            return response()->json(['status' => true, 'msg' => 'Data successfully created'], 201);
        } catch (JWTException $exception) {
            return response()->json(['status' => false, 'msg' => $exception]);
        }
    }
}
