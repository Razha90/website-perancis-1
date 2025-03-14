<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class saveImageController extends Controller
{
    public function upload(Request $request)
    {
        try {
            if (!$request->hasFile('image')) {
                return response()->json(['success' => 0, 'message' => 'No file uploaded'], 400);
            }

            $file = $request->file('image');
            $path = $file->store('images', 'public'); // Simpan ke storage/app/public/uploads

            return response()->json([
                'success' => 1,
                'file' => [
                    'url' => asset("storage/$path"), // URL gambar yang diakses
                ],
            ]);
        } catch (\Throwable $th) {
            Log::error('saveImageController Upload File' . $th);
            return response()->json(['success' => 0, 'message' => 'Internal Server Error'], 500);
        }
    }

    public function uploadFile(Request $request)
    {
        try {
            if (!$request->hasFile('file')) {
                return response()->json(['success' => 0, 'message' => 'No file uploaded'], 400);
            }

            $file = $request->file('file');
            $path = $file->store('files', 'public'); // Simpan ke storage/app/public/uploads

            return response()->json([
                'success' => 1,
                'file' => [
                    'url' => asset("storage/$path"), // URL gambar yang diakses
                ],
            ]);
        } catch (\Throwable $th) {
            Log::error('saveImageController Upload File' . $th);
            return response()->json(['success' => 0, 'message' => 'Internal Server Error'], 500);
        }
    }
}
