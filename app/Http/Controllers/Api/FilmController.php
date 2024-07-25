<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Film;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;

class FilmController extends Controller
{
    public function index()
    {
        $films = Film::with(['kategori', 'genres', 'aktors'])->get();
        return response()->json([
            'success' => true,
            'message' => 'Daftar Film',
            'data' => $films,
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|unique:films|max:255',
            'poto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'deskripsi' => 'required',
            'url_vidio' => 'required|max:255',
            'id_kategori' => 'required|exists:kategoris,id',
            'genres' => 'required|array',
            'genres.*' => 'exists:genres,id',
            'aktors' => 'required|array',
            'aktors.*' => 'exists:aktors,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi Gagal',
                'errors' => $validator->errors(),
            ], 400);
        }

        // Handle file upload
        $potoPath = $request->file('poto')->store('public/image');

        // Create film
        $film = new Film();
        $film->judul = $request->judul;
        $film->slug = Str::slug($request->judul, '-');
        $film->poto = $potoPath;
        $film->deskripsi = $request->deskripsi;
        $film->url_vidio = $request->url_vidio;
        $film->id_kategori = $request->id_kategori;
        $film->save();

        $film->genres()->sync($request->genres);
        $film->aktors()->sync($request->aktors);

        return response()->json([
            'success' => true,
            'message' => 'Film Berhasil Disimpan',
            'data' => $film,
        ], 201);
    }

    public function show($id)
    {
        $film = Film::with(['kategori', 'genres', 'aktors'])->find($id);
        if ($film) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Film',
                'data' => $film,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Film Tidak Ditemukan',
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|max:255|unique:films,judul,' . $id,
            'poto' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'deskripsi' => 'required',
            'url_vidio' => 'required|max:255',
            'id_kategori' => 'required|exists:kategoris,id',
            'genres' => 'required|array',
            'genres.*' => 'exists:genres,id',
            'aktors' => 'required|array',
            'aktors.*' => 'exists:aktors,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi Gagal',
                'errors' => $validator->errors(),
            ], 400);
        }

        $film = Film::find($id);
        if ($film) {
            $film->judul = $request->judul;
            $film->slug = Str::slug($request->judul, '-');
            $film->deskripsi = $request->deskripsi;
            $film->url_vidio = $request->url_vidio;
            $film->id_kategori = $request->id_kategori;

            if ($request->hasFile('poto')) {
                $potoPath = $request->file('poto')->store('public/image');
                $film->poto = $potoPath;
            }

            $film->save();
            $film->genres()->sync($request->genres);
            $film->aktors()->sync($request->aktors);

            return response()->json([
                'success' => true,
                'message' => 'Film Berhasil Diperbarui',
                'data' => $film,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Film Tidak Ditemukan',
            ], 404);
        }
    }

    public function destroy($id)
    {
        $film = Film::find($id);
        if ($film) {
            $film->delete();
            $film->genres()->detach();
            $film->aktors()->detach();
            return response()->json([
                'success' => true,
                'message' => 'Film Berhasil Dihapus',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Film Tidak Ditemukan',
            ], 404);
        }
    }
}