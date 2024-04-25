<?php

namespace App\Http\Controllers;

use App\Models\Ayam;
use App\Models\Barang;
use App\Models\Inventaris;
use App\Models\Kandang;
use App\Models\PemasukanAyam;
use App\Models\PemasukanInventaris;
use App\Models\PengeluaranAyam;
use App\Models\PengeluaranBarang;
use App\Models\PengeluaranInventaris;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengeluaranController extends Controller
{
    public function indexAyam()
    {
        $ayam = Ayam::all();

        return view('pengeluaran.index-ayam', [
            'ayam' => $ayam
        ]);
    }

    public function indexKandang($id)
    {
        $ayam = Ayam::find($id);

        $kandang = Kandang::where('ayam_id', $ayam->id)->get();

        return view('pengeluaran.index-kandang', [
            'kandang' => $kandang
        ]);
    }

    public function barangInventaris($kandangId)
    {
        $kandang = Kandang::find($kandangId);

        return view('pengeluaran.barang-inventaris', [
            'kandang' => $kandang
        ]);
    }

    /*
    * menampilkan kelola pengeluaran barang
    * index
    */
    public function pengeluaranBarang($kandangId)
    {
        $kandang = Kandang::find($kandangId);
        $pengeluaranBarang = PengeluaranBarang::where('kandang_id', $kandangId)->get();

        return view('pengeluaran.pengeluaran-barang.index', [
            'pengeluaranBarang' => $pengeluaranBarang,
            'kandang' => $kandang
        ]);
    }

    /*
    * menampilkan kelola pengeluaran barang
    * form create
    */
    public function createPengeluaranBarang($kandangId)
    {
        $kandang = Kandang::find($kandangId);
        $barang = Barang::all();

        return view('pengeluaran.pengeluaran-barang.create', [
            'kandang' => $kandang,
            'barang' => $barang
        ]);
    }

    /*
    * menampilkan kelola pengeluaran barang
    * form create (post)
    */
    public function postPengeluaranBarang(Request $request, $kandangId)
    {
        $barang = Barang::find($request->barang_id);

        if ($barang->jumlah < $request->jumlah_pengeluaran) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi');
        }
        DB::beginTransaction();

        try {
            $data = [
                'kandang_id' => $kandangId,
                'barang_id' => $request->barang_id,
                'waktu' => $request->waktu,
                'jumlah_awal_barang' => $barang->jumlah,
                'jumlah_pengeluaran' => $request->jumlah_pengeluaran,
            ];

            PengeluaranBarang::create($data);

            $newJumlah = $barang->jumlah - $request->jumlah_pengeluaran;

            Barang::where('id', $request->barang_id)->update(['jumlah' => $newJumlah]);

            DB::commit();

            return redirect()->route('pengeluaran.pengeluaran-barang', $kandangId)->with('success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()->with('error', 'Failed to update stock.');
        }
    }

    /*
    * menampilkan kelola pengeluaran barang
    * form edit
    */
    public function editPengeluaranBarang($kandangId, $pengeluaranBarangId)
    {
        $pengeluaranBarang = PengeluaranBarang::find($pengeluaranBarangId);
        $kandang = Kandang::where('id', $kandangId)->first();
        $barang = Barang::all();

        return view('pengeluaran.pengeluaran-barang.edit', [
            'pengeluaranBarang' =>  $pengeluaranBarang,
            'kandang' => $kandang,
            'barang' => $barang
        ]);
    }

    /*
    * menampilkan kelola pengeluaran barang
    * form edit (post)
    */
    public function updatePengeluaranBarang(Request $request, $kandangId, $pengeluaranBarangId)
    {
        $pengeluaran = PengeluaranBarang::findOrFail($pengeluaranBarangId);
        $newJumlahPengeluaran = $request->jumlah_pengeluaran;

        $newJumlah = $pengeluaran->jumlah_awal_barang - $newJumlahPengeluaran;

        if ($request->barang_id && $request->barang_id !== $pengeluaran->barang_id) {
            Barang::where('id', $pengeluaran->barang_id)->update(['jumlah' => $pengeluaran->jumlah_awal_barang]);

            $barangBaru = Barang::find($request->barang_id);

            if ($barangBaru) {
                $barangBaru->update(['jumlah' => $barangBaru->jumlah - $request->jumlah_pengeluaran]);
            }
        } else {
            Barang::where('id', $pengeluaran->barang_id)->update(['jumlah' => $newJumlah]);
        }
        $pengeluaran->update([
            'waktu' => $request->waktu,
            'jumlah_pengeluaran' => $newJumlahPengeluaran,
        ]);

        return redirect()->route('pengeluaran.pengeluaran-barang', $kandangId)->with('success', 'Data berhasil diubah');
    }


    /*
    * menampilkan kelola pengeluaran barang
    * destroy
    */
    public function destroyPengeluaranBarang($kandangId, $pengeluaranBarangId)
    {
        $pengeluaranBarang = PengeluaranBarang::find($pengeluaranBarangId);

        if (!$pengeluaranBarang) {
            return redirect()->route('pengeluaran.pengeluaran-barang', $kandangId)->with('error', 'Pengeluaran not found.');
        }

        $jumlahAwalBarang = $pengeluaranBarang->jumlah_awal_barang;

        $pengeluaranBarang->delete();

        $barang = Barang::find($pengeluaranBarang->barang_id);

        if ($barang) {
            $barang->update(['jumlah' => $jumlahAwalBarang]);
        }

        return redirect()->route('pengeluaran.pengeluaran-barang', $kandangId)->with('success', 'Pengeluaran deleted successfully.');
    }

    /*
    * menampilkan kelola pengeluaran inventaris
    * index
    */
    public function pengeluaranInventaris($kandangId)
    {
        $kandang = Kandang::find($kandangId);
        $pengeluaranInventaris = PengeluaranInventaris::where('kandang_id', $kandangId)->get();

        return view('pengeluaran.pengeluaran-inventaris.index', [
            'pengeluaranInventaris' => $pengeluaranInventaris,
            'kandang' => $kandang
        ]);
    }

    /*
    * menampilkan kelola pengeluaran inventaris
    * index
    */
    public function createPengeluaranInventaris($kandangId)
    {
        $kandang = Kandang::find($kandangId);
        $inventaris = Inventaris::all();

        return view('pengeluaran.pengeluaran-inventaris.create', [
            'inventaris' => $inventaris,
            'kandang' => $kandang
        ]);
    }

    /*
    * menampilkan kelola pengeluaran inventaris
    * form create (post)
    */
    public function postPengeluaranInventaris(Request $request, $kandangId)
    {
        $request->validate([
            'kuantitas' => 'numeric',
            'inventaris_id' => 'required',
            'waktu' => 'required',
        ], [
            'kuantitas.numeric' => 'Kuantitas harus berupa angka.',
            'inventaris_id.required' => 'Inventaris harus wajib diisi.',
            'waktu.required' => 'Waktu harus wajib diisi.'
        ]);
        PengeluaranInventaris::create([
            'kandang_id' => $kandangId,
            'inventaris_id' => $request->inventaris_id,
            'waktu' => $request->waktu,
            'kuantitas' => $request->kuantitas
        ]);

        return redirect()->route('pengeluaran.pengeluaran-inventaris', $kandangId)->with('success', 'Data berhasil Disimpan');
    }

    /*
    * menampilkan kelola pengeluaran inventaris
    * form edit
    */
    public function editPengeluaranInventaris($kandangId, $pengeluaranInventarisId)
    {
        $pengeluaranInventaris = PengeluaranInventaris::find($pengeluaranInventarisId);
        $kandang = Kandang::find($kandangId);
        $inventaris = Inventaris::all();

        return view('pengeluaran.pengeluaran-inventaris.edit', [
            'pengeluaranInventaris' => $pengeluaranInventaris,
            'kandang' => $kandang,
            'inventaris' => $inventaris
        ]);
    }

    /*
    * menampilkan kelola pengeluaran inventaris
    * form edit (post)
    */
    public function updatePengeluaranInventaris(Request $request, $kandangId, $pengeluaranInventarisId)
    {
        $request->validate([
            'kuantitas' => 'numeric'
        ], [
            'kuantitas.numeric' => 'Kuantitas harus berupa angka.'
        ]);
        $data = [
            'inventaris_id' => $request->inventaris_id,
            'waktu' => $request->waktu,
            'kuantitas' => $request->kuantitas
        ];

        PengeluaranInventaris::where('id', $pengeluaranInventarisId)->update($data);

        return redirect()->route('pengeluaran.pengeluaran-inventaris', $kandangId)->with('success', 'Data berhasil Diubah');
    }

    public function destroyPengeluaranInventaris($kandangId, $pengeluaranInventarisId)
    {
        $pengeluaranInventaris = PengeluaranInventaris::find($pengeluaranInventarisId);
        $pengeluaranInventaris->delete();

        // return redirect()->route('pengeluaran.pengeluaran-inventaris', $kandangId)->with('success', 'Pengeluaran deleted successfully.');
        return response()->json(['success', 'Data Berhasil Dihapus']);
    }

    public function pengeluaranAyam($kandangId)
    {
        $kandang = Kandang::find($kandangId);

        $pengeluaranAyam = PengeluaranAyam::where('kandang_id', $kandang->id)->get();

        return view('pengeluaran.pengeluaran-ayam.index', [
            'pengeluaranAyam' => $pengeluaranAyam,
            'kandang' => $kandang
        ]);
    }

    public function createPengeluaranAyam($kandangId)
    {
        $kandang = Kandang::find($kandangId);

        return view('pengeluaran.pengeluaran-ayam.create', [
            'kandang' => $kandang,
        ]);
    }

    public function storePengeluaranAyam(Request $request, $kandangId)
    {
        PengeluaranAyam::create([
            'kandang_id' => $kandangId,
            'jumlah_keluar' => $request->jumlah_keluar,
            'tanggal_keluar' => $request->tanggal_keluar,
            'keterangan' => $request->keterangan
        ]);

        return redirect()->route('pengeluaran.pengeluaran-ayam', $kandangId)->with('success', 'Data berhasil Disimpan');
    }

    public function editPengeluaranAyam($kandangId, $pengeluaranAyamId)
    {
        $pengeluaranAyam = PengeluaranAyam::find($pengeluaranAyamId);
        $kandang = Kandang::find($kandangId);

        return view('pengeluaran.pengeluaran-ayam.edit', [
            'kandang' => $kandang,
            'pengeluaranAyam' => $pengeluaranAyam
        ]);
    }

    public function updatePengeluaranAyam(Request $request, $kandangId, $pengeluaranAyamId)
    {
        PengeluaranAyam::where('id', $pengeluaranAyamId)->update([
            'jumlah_keluar' => $request->jumlah_keluar,
            'tanggal_keluar' => $request->tanggal_keluar,
            'keterangan' => $request->keterangan
        ]);

        return redirect()->route('pengeluaran.pengeluaran-ayam', $kandangId)->with('success', 'Data berhasil Diubah');
    }

    public function destroyPengeluaranAyam($pemasukanAyamId)
    {
        $pengeluaranAyam = PengeluaranAyam::find($pemasukanAyamId);

        $pengeluaranAyam->delete();

        return response()->json(['success', 'Data berhasil dihapus']);
    }
}
