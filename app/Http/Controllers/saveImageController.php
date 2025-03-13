<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class saveImageController extends Controller
{
    public function upload(Request $request)  {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:1040',
        ]);

        // Ambil file dari request
        $image = $request->file('image');

        // Buat nama unik untuk file
        $filename = time() . '_' . $image->getClientOriginalName();

        // Pindahkan file ke folder public/images/
        $image->move(public_path('img/content'), $filename);

        // Buat URL gambar
        $url = asset('img/content/' . $filename);

        return response()->json(['url' => $url], 200);
    }
}
