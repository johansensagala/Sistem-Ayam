<?php

namespace App\Http\Controllers;

use App\Models\PemasukanAyam;
use App\Models\PengeluaranAyam;
use App\Models\Produksi;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $jumlah_telur = Produksi::where('status', 'Normal')->sum('kuantitas') - Produksi::where('status', 'Terjual')->sum('kuantitas');
        $jumlah_ayam = PemasukanAyam::sum('kuantitas') - PengeluaranAyam::sum('jumlah_keluar');
        
        return view('home', [
            'jumlah_telur' => $jumlah_telur,
            'jumlah_ayam' => $jumlah_ayam
        ]);
    }
}
