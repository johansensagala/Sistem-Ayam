<?php

namespace App\Http\Controllers;

use App\Models\Kandang;
use App\Models\Produksi;
use App\Models\Telur;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanProduksiController extends Controller
{
    // public function index()
    // {
    //     $produksi = Produksi::all();

    //     return view('produksi.form', [
    //         'produksi' => $produksi
    //     ]);
    // }

    public function index()
    {
        $startDate = Carbon::now()->startOfDay();
        $endDate = Carbon::now()->endOfDay();
    
        $filter = (object)[
            'startDate' => $startDate,
            'endDate' => $endDate,
        ];
    
        $produksi = Produksi::where('status', 'normal')->filter($filter)->get();
        $total = $produksi->sum('kuantitas');
        // $stok = Produksi::where('status', 'Normal')->sum('kuantitas') - Produksi::where('status', 'Terjual')->sum('kuantitas');
        $kandang = Kandang::get();
        $telur = Telur::get();
    
        $pengeluaran = Produksi::whereIn('status', ['Pecah', 'Terjual', 'Busuk'])->filter($filter)->get();
        $totalPengeluaran = $pengeluaran->sum('kuantitas');

        $harga_telur = Telur::first()->harga;

        $stok = [];
        foreach ($telur as $item) {
            $stok[$item->nama] = Produksi::where('status', 'Normal')->where('telur_id', $item->id)->sum('kuantitas') - Produksi::where('status', 'Terjual')->sum('kuantitas');
        }

        $total = [];
        $totalPengeluaran = [];
        $totalPengeluaranHarga = [];
        foreach ($telur as $item) {
            $total[$item->nama] = Produksi::filter($filter)->where('telur_id', $item->id)->where('status', 'Normal')->sum('kuantitas');
            $totalPengeluaran[$item->nama] = Produksi::filter($filter)->where('telur_id', $item->id)->whereIn('status', ['Pecah', 'Terjual', 'Busuk'])->sum('kuantitas');
            $totalPengeluaranHarga[$item->nama] = Produksi::filter($filter)->where('telur_id', $item->id)->whereIn('status', ['Terjual'])->sum('kuantitas');
        }

        return view('produksi.report', [
            'produksi' => $produksi,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'total' => $total,
            'stok' => $stok,
            'harga_telur' => $harga_telur,
            'kandang' => $kandang,
            'telur' => $telur,

            'pengeluaran' => $pengeluaran,
            'totalPengeluaran' => $totalPengeluaran,
            'totalPengeluaranHarga' => $totalPengeluaranHarga,
        ]);
    }
    
    public function data(Request $request)
    {
        $filter = (object)[
            'startDate' => $request->startDate,
            'endDate' => $request->endDate,
            'status' => $request->status,
            'kandang_id' => $request->kandang_id,
            'telur_id' => $request->telur_id,
        ];
        
        $produksi = Produksi::where('status', 'Normal')->filter($filter)->get();
        $total = $produksi->sum('kuantitas');
        $kandang = Kandang::get();
        $telur = Telur::get();
        $harga_telur = Telur::first()->harga;

        $stok = [];
        $total = [];
        $totalPengeluaran = [];
        $totalPengeluaranHarga = [];

        if ($request->telur_id) {
            $telur_current = Telur::where('id', $request->telur_id)->first();

            $total[$telur_current->nama] = Produksi::where('telur_id', $telur_current->id)->where('status', 'normal')->filter($filter)->sum('kuantitas');
            $totalPengeluaran[$telur_current->nama] = Produksi::where('telur_id', $telur_current->id)->whereIn('status', ['Pecah', 'Terjual', 'Busuk'])->filter($filter)->sum('kuantitas');
            $totalPengeluaranHarga[$telur_current->nama] = Produksi::where('telur_id', $telur_current->id)->whereIn('status', ['Terjual'])->filter($filter)->sum('kuantitas');

            if ($request->kandang_id) {
                $stok[$telur_current->nama] = Produksi::where('status', 'Normal')->where('telur_id', $request->telur_id)->where('kandang_id', $request->kandang_id)->sum('kuantitas') - Produksi::where('status', 'Terjual')->where('kandang_id', $request->kandang_id)->sum('kuantitas');
            } else {
                $stok[$telur_current->nama] = Produksi::where('status', 'Normal')->where('telur_id', $request->telur_id)->sum('kuantitas') - Produksi::where('status', 'Terjual')->sum('kuantitas');
            }
        } else {
            foreach ($telur as $item) {
                $total[$item->nama] = Produksi::where('telur_id', $item->id)->where('status', 'normal')->filter($filter)->sum('kuantitas');
                $totalPengeluaran[$item->nama] = Produksi::where('telur_id', $item->id)->whereIn('status', ['Pecah', 'Terjual', 'Busuk'])->filter($filter)->sum('kuantitas');
                $totalPengeluaranHarga[$item->nama] = Produksi::where('telur_id', $item->id)->whereIn('status', ['Terjual'])->filter($filter)->sum('kuantitas');
    
                if ($request->kandang_id) {
                    $stok[$item->nama] = Produksi::where('status', 'Normal')->where('telur_id', $item->id)->where('kandang_id', $request->kandang_id)->sum('kuantitas') - Produksi::where('status', 'Terjual')->where('kandang_id', $request->kandang_id)->sum('kuantitas');
                } else {
                    $stok[$item->nama] = Produksi::where('status', 'Normal')->where('telur_id', $item->id)->sum('kuantitas') - Produksi::where('status', 'Terjual')->sum('kuantitas');
                }
            }
        }

        $pengeluaran = Produksi::whereIn('status', ['Pecah', 'Terjual', 'Busuk'])->filter($filter)->get();
        // $totalPengeluaran = $pengeluaran->sum('kuantitas');
        
        return view('produksi.report', [
            'produksi' => $produksi,
            'startDate' => $request->startDate,
            'endDate' => $request->endDate,
            'total' => $total,
            'stok' => $stok,
            'harga_telur' => $harga_telur,
            'kandang' => $kandang,
            'telur' => $telur,

            'pengeluaran' => $pengeluaran,
            'totalPengeluaran' => $totalPengeluaran,
            'totalPengeluaranHarga' => $totalPengeluaranHarga,
        ]);
    }

    public function getChartData()
    {
        $chartData = [['Month', 'Normal', 'Pecah', 'Terjual', 'Busuk', ['role' => 'annotation']]];
        
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    
        foreach ($months as $month) {
            $rowData = [
                $month,
                (int) Produksi::where('status', 'Normal')->whereMonth('tanggal', Carbon::parse($month)->month)->sum('kuantitas'),
                (int) Produksi::where('status', 'Pecah')->whereMonth('tanggal', Carbon::parse($month)->month)->sum('kuantitas'),
                (int) Produksi::where('status', 'Terjual')->whereMonth('tanggal', Carbon::parse($month)->month)->sum('kuantitas'),
                (int) Produksi::where('status', 'Busuk')->whereMonth('tanggal', Carbon::parse($month)->month)->sum('kuantitas'),
                '',
            ];
    
            array_push($chartData, $rowData);
        }
    
        return response()->json(['data' => $chartData]);
    }
}
