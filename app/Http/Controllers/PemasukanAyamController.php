<?php

namespace App\Http\Controllers;

use App\Http\Requests\PemasukanAyamRequest;
use App\Http\Requests\PengeluaranAyamRequest;
use App\Models\Kandang;
use App\Models\PemasukanAyam;
use App\Models\PengeluaranAyam;
use Illuminate\Http\Request;

class PemasukanAyamController extends Controller
{
    public function create()
    {
        $kandang = Kandang::all();

        return view('pemasukan-ayam.create', [
            'kandang' => $kandang
        ]);
    }

    public function store(PemasukanAyamRequest $request)
    {
        PemasukanAyam::create($request->all());
       
        return redirect()->back()->withSuccess('Data berhasil ditambahkan');
    }

    public function createPengeluaran()
    {
        $kandang = Kandang::all();

        return view('pemasukan-ayam.create-pengeluaran', [
            'kandang' => $kandang
        ]);
    }

    public function storePengeluaran(PengeluaranAyamRequest $request)
    {
        PengeluaranAyam::create($request->all());
       
        // dd($request->tanggal_keluar);
        return redirect()->back()->withSuccess('Data berhasil ditambahkan');
    }
}
