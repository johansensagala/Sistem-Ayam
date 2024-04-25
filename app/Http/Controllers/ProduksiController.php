<?php

namespace App\Http\Controllers;

use App\Models\Kandang;
use App\Models\Produksi;
use App\Models\Telur;
use Illuminate\Http\Request;

class ProduksiController extends Controller
{
    public function create()
    {
        $kandang = Kandang::all();
        $telur = Telur::all();

        // dd($kandang);
        return view('produksi.create', [
            'kandang' => $kandang,
            'telur' => $telur
        ]);
    }

    public function store(Request $request)
    {
        if ($request['status_normal']) {
            Produksi::create([
                'kandang_id' => $request->kandang_id,
                'telur_id' => $request->telur_id,
                'tanggal' => $request->tanggal,
                'kuantitas' => $request->status_normal,
                'status' => 'Normal'
            ]);
        }
        if ($request['status_busuk']) {
            Produksi::create([
                'kandang_id' => $request->kandang_id,
                'telur_id' => $request->telur_id,
                'tanggal' => $request->tanggal,
                'kuantitas' => $request->status_busuk,
                'status' => 'Busuk'
            ]);
        }
        if ($request['status_pecah']) {
            Produksi::create([
                'kandang_id' => $request->kandang_id,
                'telur_id' => $request->telur_id,
                'tanggal' => $request->tanggal,
                'kuantitas' => $request->status_pecah,
                'status' => 'Pecah'
            ]);
        }
        if ($request['status_terjual']) {
            Produksi::create([
                'kandang_id' => $request->kandang_id,
                'telur_id' => $request->telur_id,
                'tanggal' => $request->tanggal,
                'kuantitas' => $request->status_terjual,
                'status' => 'Terjual'
            ]);
        }

        return redirect()->back()->withSuccess('Data berhasil ditambahkan');
        
    }

    
}
