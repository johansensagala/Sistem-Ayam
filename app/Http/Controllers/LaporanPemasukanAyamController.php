<?php

namespace App\Http\Controllers;

use App\Models\Ayam;
use App\Models\Kandang;
use App\Models\PemasukanAyam;
use App\Models\PengeluaranAyam;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanPemasukanAyamController extends Controller
{
    // public function index()
    // {
    //     $kandang = Kandang::all();

    //     return view('pemasukan-ayam.form', [
    //         'kandang' => $kandang
    //     ]);
    // }

    public function index(Request $request)
    {
        $startDate = Carbon::now()->startOfDay();
        $endDate = Carbon::now()->endOfDay();
    
        $filter = (object)[
            'startDate' => $startDate,
            'endDate' => $endDate,
        ];

        $pemasukanAyam = PemasukanAyam::filter($filter)->orderBy('tanggal_masuk', 'desc')->get();
        $kandang = Kandang::get();
        $total = $pemasukanAyam->sum('kuantitas');
        $stok = PemasukanAyam::sum('kuantitas') - PengeluaranAyam::sum('jumlah_keluar');
        
        $pengeluaranAyam = PengeluaranAyam::filter($filter)->orderBy('tanggal_keluar', 'desc')->get();
        $totalPengeluaran = $pengeluaranAyam->where('keterangan', 'terjual')->sum('jumlah_keluar');
        // dd($pengeluaranAyam);
        $hargaAyam = Ayam::first()->harga;

        // dd($pengeluaranAyam);
        return view('pemasukan-ayam.report', [
            'pemasukanAyam' => $pemasukanAyam,
            'kandang' => $kandang,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'total' => $total,
            'stok' => $stok,

            'pengeluaranAyam' => $pengeluaranAyam,
            'totalPengeluaran' => $totalPengeluaran,

            'hargaAyam' => $hargaAyam,
        ]);
    }
    
    public function data(Request $request)
    {
        $filter = (object)[
            'startDate' => $request->startDate,
            'endDate' => $request->endDate,
            'kandang_id' => $request->kandang_id
        ];
        
        $pemasukanAyam = PemasukanAyam::filter($filter)->orderBy('tanggal_masuk', 'desc')->get();
        $kandang = Kandang::get();
        $total = $pemasukanAyam->sum('kuantitas');

        if ($request->kandang_id) {
            $stok = PemasukanAyam::where('kandang_id', $request->kandang_id)->sum('kuantitas') - PengeluaranAyam::where('kandang_id', $request->kandang_id)->sum('jumlah_keluar');
        } else {
            $stok = PemasukanAyam::sum('kuantitas') - PengeluaranAyam::sum('jumlah_keluar');
        }

        $pengeluaranAyam = PengeluaranAyam::filter($filter)->orderBy('tanggal_keluar', 'desc')->get();
        $totalPengeluaran = $pengeluaranAyam->where('keterangan', 'terjual')->sum('jumlah_keluar');

        $hargaAyam = Ayam::first()->harga;

        return view('pemasukan-ayam.report', [
            'pemasukanAyam' => $pemasukanAyam,
            'kandang' => $kandang,
            'startDate' => $request->startDate,
            'endDate' => $request->endDate,
            'total' => $total,
            'stok' => $stok,

            'pengeluaranAyam' => $pengeluaranAyam,
            'totalPengeluaran' => $totalPengeluaran,

            'hargaAyam' => $hargaAyam,
        ]);
    }

    public function getChartData()
    {
        $ayam = Ayam::pluck('jenis')->toArray();
        $chartData = [['Month', ...$ayam, ['role' => 'annotation']]];
    
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    
        $maxLength = 0;
    
        foreach ($months as $month) {
            $rowData = [
                $month,
            ];
    
            $tempLength = 0;
    
            foreach ($ayam as $jenis) {
                $count = (int) PemasukanAyam::with(['kandang.ayam'])
                    ->whereHas('kandang.ayam', function ($q) use ($jenis) {
                        return $q->where('jenis', $jenis);
                    })
                    ->whereMonth('tanggal_masuk', Carbon::parse($month)->month)
                    ->sum('kuantitas');
    
                $tempLength += $count;
    
                array_push($rowData, $count);
            }
    
            if ($tempLength > $maxLength) {
                $maxLength = $tempLength;
            }
    
            array_push($rowData, '');
            array_push($chartData, $rowData);
        }
    
        return response()->json(['data' => $chartData, 'maxLength' => $maxLength]);
    }
}
