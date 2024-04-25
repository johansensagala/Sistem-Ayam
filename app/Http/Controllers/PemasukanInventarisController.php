<?php

namespace App\Http\Controllers;

use App\Http\Requests\PemasukanInventarisRequest;
use App\Models\Inventaris;
use App\Models\Kandang;
use App\Models\PemasukanInventaris;
use App\Models\PengeluaranInventaris;
use Illuminate\Http\Request;

class PemasukanInventarisController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $inventaris = Inventaris::all();
        $kandang = Kandang::all();
        return view('pemasukan-inventaris.create', [
            'kandang' => $kandang,
            'inventaris' => $inventaris,
        ]);
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(PemasukanInventarisRequest $request)
    {
        $request->validate([
            'kuantitas' => 'numeric'
        ], [
            'kuantitas.numeric' => 'Kuantitas harus berupa angka.'
        ]);
        PemasukanInventaris::create([
            'inventaris_id' => $request->inventaris_id,
            'kandang_id' => $request->kandang_id,
            'waktu' => $request->waktu,
            'kuantitas' => $request->kuantitas,
            'satuan' => $request->satuan,
        ]);
        
        return redirect()->back()->withSuccess('Data berhasil ditambahkan, silahkan lakukan tambah data ulang jika diperlukan!');
    }
    
    public function createPengeluaran()
    {
        $inventaris = Inventaris::all();
        $kandang = Kandang::all();
        return view('pemasukan-inventaris.create-pengeluaran', [
            'inventaris' => $inventaris,
            'kandang' => $kandang,
        ]);
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function storePengeluaran(PemasukanInventarisRequest $request)
    {
        $request->validate([
            'kuantitas' => 'numeric'
        ], [
            'kuantitas.numeric' => 'Kuantitas harus berupa angka.'
        ]);
        PengeluaranInventaris::create([
            'inventaris_id' => $request->inventaris_id,
            'kandang_id' => $request->kandang_id,
            'waktu' => $request->waktu,
            'kuantitas' => $request->kuantitas,
            'satuan' => $request->satuan,
        ]);
        
        return redirect()->back()->withSuccess('Data berhasil ditambahkan, silahkan lakukan tambah data ulang jika diperlukan!');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pemasukan-inventaris.index');
    }

    public function data(Request $request)
    {
        $pemasukanInventaris = PemasukanInventaris::where('waktu', $request->waktu)->get();

        return view('pemasukan-inventaris.data', [
            'pemasukanInventaris' => $pemasukanInventaris
        ]);
    }
}
