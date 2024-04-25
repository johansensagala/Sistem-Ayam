<?php

namespace App\Http\Controllers;

use App\Models\Telur;
use Illuminate\Http\Request;

class TelurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $telur = Telur::all();

        return view('telur.index', [
            'telur' => $telur
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('telur.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Telur::create([
            'nama' => $request->jenis,
            'harga' => $request->harga,
        ]);

        return redirect()->route('telur.index')->withSuccess('Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Telur $telur)
    {
        $telur = Telur::find($telur->id);

        return view('telur.edit', [
            'telur' => $telur
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Telur $telur)
    {
        $data = [
            'nama' => $request->jenis,
            'harga' => $request->harga
        ];

        Telur::where('id', $telur->id)->update($data);

        return redirect()->route('telur.index')->withSuccess('Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Telur $telur)
    {
        $telur=Telur::find($telur->id);

        $telur->delete();

        return response()->json(['success', 'Data Berhasil Dihapus']);
    }
}
