<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Validator;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::latest()->get();
        $response = [
            'success' => true,
            'message' => 'Daftar Kategori',
            'data' => $kategori,
        ];

        return response()->json($response, 200);
    }
    
    public function store(Request $request)
    {
        // Add validation
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi Gagal',
                'errors' => $validator->errors(),
            ], 400);
        }

        $kategori = new Kategori();
        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan',
            'data' => $kategori,
        ], 201);
    }

    public function show($id)
    {
        $kategori = Kategori::find($id);
        if ($kategori) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Kategori',
                'data' => $kategori,
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
            'nama_kategori' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi Gagal',
                'errors' => $validator->errors(),
            ], 400);
        }

        $kategori = Kategori::find($id);
        if ($kategori) {
            $kategori->nama_kategori = $request->nama_kategori;
            $kategori->save();
            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Diperbarui',
                'data' => $kategori,
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
        $kategori = Kategori::find($id);
        if ($kategori) {
            $kategori->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data ' . $kategori->nama_kategori . ' Berhasil Dihapus',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data Tidak Ditemukan',
            ], 404);
        }
    }
}
