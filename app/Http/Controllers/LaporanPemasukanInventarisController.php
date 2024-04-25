<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use App\Models\Kandang;
use App\Models\PemasukanInventaris;
use App\Models\PengeluaranInventaris;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanPemasukanInventarisController extends Controller
{
    // public function index()
    // {
    //     $inventaris = Inventaris::get();

    //     return view('pemasukan-inventaris.form-tanggal', [
    //         'inventaris' => $inventaris
    //     ]);
    // }

    public function index(Request $request)
    {
        $request->validate([
            'kuantitas' => 'numeric'
        ], [
            'kuantitas.numeric' => 'Kuantitas harus berupa angka.'
        ]);
    
        $startDate = Carbon::now()->startOfDay();
        $endDate = Carbon::now()->endOfDay();
    
        $filter = (object)[
            'startDate' => $startDate,
            'endDate' => $endDate,
        ];
    
        $pemasukanInventaris = PemasukanInventaris::filter($filter)->orderBy('waktu', 'desc')->get();
        $pengeluaranInventaris = PengeluaranInventaris::filter($filter)->orderBy('waktu', 'desc')->get();
        $inventaris = Inventaris::get();
        $kandang = Kandang::get();
        $total = $pemasukanInventaris->sum('kuantitas');
        
        // Hitung stok untuk setiap produk yang ada di Inventaris
        $stok = [];
        foreach ($inventaris as $item) {
            $stok[$item->nama] = PemasukanInventaris::where('inventaris_id', $item->id)->sum('kuantitas') - PengeluaranInventaris::where('inventaris_id', $item->id)->sum('kuantitas');
        }
        
        $totalPerInventaris = [];
        $totalPengeluaranPerInventaris = [];
        foreach ($inventaris as $item) {
            $totalPerInventaris[$item->nama] = PemasukanInventaris::filter($filter)->where('inventaris_id', $item->id)->sum('kuantitas');
            $totalPengeluaranPerInventaris[$item->nama] = PengeluaranInventaris::filter($filter)->where('inventaris_id', $item->id)->sum('kuantitas');
        }

        // dd($totalPerInventaris);
        
        // dd($totalPengeluaranPerInventaris);
        
        return view('pemasukan-inventaris.report', [
            'pemasukanInventaris' => $pemasukanInventaris,
            'inventaris' => $inventaris,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'total' => $total,
            'totalPerInventaris' => $totalPerInventaris,
            'stok' => $stok,
            'kandang' => $kandang,
            
            'pengeluaranInventaris' => $pengeluaranInventaris,
            'totalPengeluaranPerInventaris' => $totalPengeluaranPerInventaris,
        ]);
    }
    
    public function data(Request $request)
    {
        $request->validate([
            'kuantitas' => 'numeric'
        ], [
            'kuantitas.numeric' => 'Kuantitas harus berupa angka.'
        ]);
        
        $filter = (object)[
            'startDate' => $request->startDate,
            'endDate' => $request->endDate,
            'inventaris_id' => $request->inventaris_id,
            'kandang_id' => $request->kandang_id
        ];
        
        $pemasukanInventaris = PemasukanInventaris::filter($filter)->orderBy('waktu', 'desc')->get();
        $pengeluaranInventaris = PengeluaranInventaris::filter($filter)->orderBy('waktu', 'desc')->get();
        $inventaris = Inventaris::get();
        $kandang = Kandang::get();
        $totalPemasukan = $pemasukanInventaris->sum('kuantitas');
        
        $stok = [];
        $totalPengeluaranPerInventaris = [];
        
        if ($request->inventaris_id) {
            // if ($request->kandang_id) {
            //     $inventaris_current = Inventaris::where('id', $request->inventaris_id)->first();
            //     $pemasukan = PemasukanInventaris::where('inventaris_id', $request->inventaris_id)->where('kandang_id', $request->kandang_id)->sum('kuantitas');
            //     $pengeluaran = PengeluaranInventaris::where('inventaris_id', $request->inventaris_id)->where('kandang_id', $request->kandang_id)->sum('kuantitas');
            //     $stok[$inventaris_current->nama] = $pemasukan - $pengeluaran;
            // } else {
                $inventaris_current = Inventaris::where('id', $request->inventaris_id)->first();

                if ($request->kandang_id) {
                    $stok[$inventaris_current->nama] = PemasukanInventaris::where('inventaris_id', $request->inventaris_id)
                        ->where('kandang_id', $request->kandang_id)
                        ->sum('kuantitas') 
                        - PengeluaranInventaris::where('inventaris_id', $request->inventaris_id)
                        ->where('kandang_id', $request->kandang_id)
                        ->sum('kuantitas');
                } else {
                    $stok[$inventaris_current->nama] = PemasukanInventaris::where('inventaris_id', $request->inventaris_id)
                        ->sum('kuantitas')
                        - PengeluaranInventaris::where('inventaris_id', $request->inventaris_id)
                        ->sum('kuantitas');
                }
            // }
            if ($request->kandang_id) {
                $inventaris_current = Inventaris::where('id', $request->inventaris_id)->first();
                $pemasukan = PemasukanInventaris::where('inventaris_id', $request->inventaris_id)->where('kandang_id', $request->kandang_id)->sum('kuantitas');
                $pengeluaran = PengeluaranInventaris::where('inventaris_id', $request->inventaris_id)->where('kandang_id', $request->kandang_id)->sum('kuantitas');
            //     $stok[$inventaris_current->nama] = $pemasukan - $pengeluaran;
            } else {
                $inventaris_current = Inventaris::where('id', $request->inventaris_id)->first();
                $pemasukan = PemasukanInventaris::where('inventaris_id', $request->inventaris_id)->sum('kuantitas');
                $pengeluaran = PengeluaranInventaris::where('inventaris_id', $request->inventaris_id)->sum('kuantitas');
            //     $stok[$inventaris_current->nama] = $pemasukan - $pengeluaran;
            }
    
            $totalPengeluaranPerInventaris[$inventaris_current->nama] = $pengeluaran;
        } else {
            foreach ($inventaris as $item) {
                if ($request->kandang_id) {
                    $pemasukan = PemasukanInventaris::where('inventaris_id', $item->id)->where('kandang_id', $request->kandang_id)->sum('kuantitas');
                    $pengeluaran = PengeluaranInventaris::where('inventaris_id', $item->id)->where('kandang_id', $request->kandang_id)->sum('kuantitas');
                    // $stok[$item->nama] = $pemasukan - $pengeluaran;                
                } else {
                    $pemasukan = PemasukanInventaris::where('inventaris_id', $item->id)->sum('kuantitas');
                    $pengeluaran = PengeluaranInventaris::where('inventaris_id', $item->id)->sum('kuantitas');
                    // $stok[$item->nama] = $pemasukan - $pengeluaran;
                }

                if ($request->kandang_id) {
                    $stok[$item->nama] = PemasukanInventaris::where('inventaris_id', $item->id)
                        ->where('kandang_id', $request->kandang_id)
                        ->sum('kuantitas') 
                        - PengeluaranInventaris::where('inventaris_id', $item->id)
                        ->where('kandang_id', $request->kandang_id)
                        ->sum('kuantitas');
                } else {
                    $stok[$item->nama] = PemasukanInventaris::where('inventaris_id', $item->id)
                        ->sum('kuantitas')
                        - PengeluaranInventaris::where('inventaris_id', $item->id)
                        ->sum('kuantitas');
                }

                    // $pemasukan = PemasukanInventaris::where('inventaris_id', $item->id)
                    //     ->whereBetween('waktu', [$request->startDate, $request->endDate])
                    //     ->sum('kuantitas');
                    // $pengeluaran = PengeluaranInventaris::where('inventaris_id', $item->id)
                    //     ->whereBetween('waktu', [$request->startDate, $request->endDate])
                    //     ->sum('kuantitas');

                    // if ($request->kandang_id) {
                    //     $stok[$item->nama] = PemasukanInventaris::where('inventaris_id', $item->id)->where('kandang_id', $request->kandang_id)->sum('kuantitas');
                    // }
                // }
                $totalPengeluaranPerInventaris[$item->nama] = $pengeluaran;
            }
        }
    
        $totalPerInventaris = [];
        if ($request->inventaris_id) {
            $inventaris_current = Inventaris::where('id', $request->inventaris_id)->first();
            $totalPerInventaris[$inventaris_current->nama] = PemasukanInventaris::filter($filter)->sum('kuantitas');
        } else {
            foreach ($inventaris as $item) {
                $totalPerInventaris[$item->nama] = PemasukanInventaris::where('inventaris_id', $item->id)
                ->whereBetween('waktu', [$request->startDate, $request->endDate])
                ->sum('kuantitas');
            }
        }
    
        return view('pemasukan-inventaris.report', [
            'pemasukanInventaris' => $pemasukanInventaris,
            'inventaris' => $inventaris,
            'startDate' => $request->startDate,
            'endDate' => $request->endDate,
            'totalPemasukan' => $totalPemasukan,
            'totalPerInventaris' => $totalPerInventaris,
            'stok' => $stok,
            'kandang' => $kandang,

            'pemasukan' => $pemasukan,
            'pengeluaran' => $pengeluaran,

            'pengeluaranInventaris' => $pengeluaranInventaris,
            'totalPengeluaranPerInventaris' => $totalPengeluaranPerInventaris,
        ]);
    }
    
    public function getChartData()
    {
        $chartData = [['Month', 'Kg', 'Botol', 'Unit', ['role' => 'annotation']]];
    
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    
        foreach ($months as $month) {
            $kgQuantity = (int) PemasukanInventaris::where('satuan', 'kg')->whereMonth('waktu', Carbon::parse($month)->month)->sum('kuantitas');
            $botolQuantity = (int) PemasukanInventaris::where('satuan', 'botol')->whereMonth('waktu', Carbon::parse($month)->month)->sum('kuantitas');
            $unitQuantity = (int) PemasukanInventaris::where('satuan', 'unit')->whereMonth('waktu', Carbon::parse($month)->month)->sum('kuantitas');
    
            $rowData = [
                $month,
                $kgQuantity,
                $botolQuantity,
                $unitQuantity,
                '',
            ];
    
            array_push($chartData, $rowData);
        }
    
        return response()->json(['data' => $chartData]);
    }
}
