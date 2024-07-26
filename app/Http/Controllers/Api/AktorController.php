<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\aktor;
use Illuminate\Http\Request;
use Validator;

class AktorController extends Controller
{
    public function index()
    {
        $aktor = aktor::latest()->get();
        $response = [
            'success' => true,
            'message' => 'Daftar aktor',
            'data' => $aktor,
        ];

        return response()->json($response, 200);
    }
    
    public function store(Request $request)
    {
        // Add validation
        $validator = Validator::make($request->all(), [
            'nama_aktor' => 'required|max:255',
            'bio' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi Gagal',
                'errors' => $validator->errors(),
            ], 400);
        }

        $aktor = new aktor();
        $aktor->nama_aktor = $request->nama_aktor;
        $aktor->bio = $request->bio;
        $aktor->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan',
            'data' => $aktor,
        ], 201);
    }

    public function show($id)
    {
        $aktor = aktor::find($id);
        if ($aktor) {
            return response()->json([
                'success' => true,
                'message' => 'Detail aktor',
                'data' => $aktor,
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
            'nama_aktor' => 'required|max:255',
            'bio' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi Gagal',
                'errors' => $validator->errors(),
            ], 400);
        }

        $aktor = aktor::find($id);
        if ($aktor) {
            $aktor->nama_aktor = $request->nama_aktor;
            $aktor->bio = $request->bio;
            $aktor->save();
            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Diperbarui',
                'data' => $aktor,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data Tidak Ditemukan',
            ], 404);
        }
    }

    public function destroy($id)
    {
        $aktor = aktor::find($id);
        if ($aktor) {
            $aktor->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data ' . $aktor->nama_aktor . ' Berhasil Dihapus',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data Tidak Ditemukan',
            ], 404);
        }
    }
}
