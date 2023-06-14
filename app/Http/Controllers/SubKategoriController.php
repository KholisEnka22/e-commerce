<?php

namespace App\Http\Controllers;

use App\Models\SubKategori;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubKategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => 'index']);
    }
    public function index()
    {
        $subkategori = SubKategori::all();

        return response()->json($subkategori);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_kategori' => 'required',
            'nama_subkategori' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'required|mimes:jpg,png,jpeg,webp'
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422
            );
        }

        $input = $request->all();

        if ($request->has('gambar')) {
            $gambar = $request->file('gambar');
            $nama_gambar = time() . rand(1, 9) . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('uploads', $nama_gambar);
            $input['gambar'] = $nama_gambar;
        }

        $subkategori = SubKategori::create($input);

        return response()->json([
            'data' => $subkategori
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(SubKategori $subkategori)
    {
        return response()->json([
            'data' => $subkategori
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubKategori $subkategori)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubKategori $subkategori)
    {
        $validator = Validator::make($request->all(), [
            'id_kategori' => 'required',
            'nama_subkategori' => 'required',
            'deskripsi' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422
            );
        }


        $input = $request->all();

        if ($request->has('gambar')) {
            File::delete('uploads/' . $subkategori->gambar);
            $gambar = $request->file('gambar');
            $nama_gambar = time() . rand(1, 9) . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('uploads', $nama_gambar);
            $input['gambar'] = $nama_gambar;
        } else {
            unset($input['gambar']);
        }

        $subkategori->update($input);

        return response()->json([
            'message' => 'sukses',
            'data' => $subkategori
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubKategori $subkategori)
    {
        File::delete('uploads/' . $subkategori->gambar);
        $subkategori->delete();

        return response()->json([
            'message' => 'sukses'
        ]);
    }
}
