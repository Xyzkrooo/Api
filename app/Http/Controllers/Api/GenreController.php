<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;
use Validator;

class GenreController extends Controller
{
    public function index()
    {
        $genre = Genre::latest()->get();
        $response = [
            'success' => true,
            'message' => 'Daftar Genre',
            'data' => $genre,
        ];

        return response()->json($response, 200);
    }
    
    public function store(Request $request)
    {
        // Add validation
        $validator = Validator::make($request->all(), [
            'nama_Genre' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi Gagal',
                'errors' => $validator->errors(),
            ], 400);
        }

        $genre = new Genre();
        $genre->nama_Genre = $request->nama_Genre;
        $genre->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan',
            'data' => $genre,
        ], 201);
    }

    public function show($id)
    {
        $genre = Genre::find($id);
        if ($genre) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Genre',
                'data' => $genre,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data Tidak Ditemukan',
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_Genre' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi Gagal',
                'errors' => $validator->errors(),
            ], 400);
        }

        $genre = Genre::find($id);
        if ($genre) {
            $genre->nama_Genre = $request->nama_Genre;
            $genre->save();
            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Diperbarui',
                'data' => $genre,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data Tidak Ditemukan',
            ], 404);
        }
    }

    public function delete($id)
    {
        $genre = Genre::find($id);
        if ($genre) {
            $genre->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data ' . $genre->nama_Genre . ' Berhasil Dihapus',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data Tidak Ditemukan',
            ], 404);
        }
    }
}
