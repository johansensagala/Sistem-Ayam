<?php

namespace Database\Seeders;

use App\Models\Ayam;
use App\Models\PemasukanAyam;
use App\Models\PemasukanInventaris;
use App\Models\PengeluaranAyam;
use App\Models\PengeluaranInventaris;
use App\Models\Produksi;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataDummy extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $startDate = new DateTime('2023-01-01');
        $endDate = new DateTime();
        $interval = new DateInterval('P1D');

        $period = new DatePeriod($startDate, $interval, $endDate);

        foreach ($period as $date) {

            $randomPemasukanAyam = (bool) rand(0, 1);
            $randomPengeluaranAyam = (bool) rand(0, 1);
            $randomPemasukanInventaris1 = (bool) rand(0, 1);
            $randomPemasukanInventaris2 = (bool) rand(0, 1);
            $randomPemasukanInventaris3 = (bool) rand(0, 1);
            $randomPengeluaranInventaris1 = (bool) rand(0, 1);
            $randomPengeluaranInventaris2 = (bool) rand(0, 1);
            $randomPengeluaranInventaris3 = (bool) rand(0, 1);
            $randomTelur = (bool) rand(0, 1);

            if ($randomPemasukanAyam) {
                $kuantitas = rand(10, 100);
                
                PemasukanAyam::create([
                    'kandang_id' => rand(1, 10),
                    'kode_ayam' => 1,
                    'kuantitas' => $kuantitas,
                    'harga' => $kuantitas * 50000 + rand(-100000, 100000),
                    'tanggal_masuk' => $date->format('Y-m-d'),
                ]);
            }
            
            if ($randomPengeluaranAyam) {
                PengeluaranAyam::create([
                    'kandang_id' => rand(1, 10),
                    'tanggal_keluar' => $date->format('Y-m-d'),
                    'jumlah_keluar' => rand(1, 70),
                    'keterangan' => array_values(['mati', 'mati', 'mati', 'terjual'])[array_rand(['mati', 'terjual', 'terjual', 'terjual'])],
                ]);
            }
            
            if ($randomPemasukanInventaris1) {

                $inventaris_id = array_values([1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 3, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14])[array_rand([1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 3, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14])];
                
                if (in_array($inventaris_id, [1, 2])) {
                    $kuantitas = mt_rand(2000, 10000) / 100;
                    $satuan = 'kg';
                } else if (in_array($inventaris_id, [3, 4, 5, 6, 7, 8, 9])) {
                    $kuantitas = rand(2, 10);
                    $satuan = 'botol';
                } else {
                    $kuantitas = rand(1, 4);
                    $satuan = 'unit';
                }

                PemasukanInventaris::create([
                    'inventaris_id' => $inventaris_id,
                    'kandang_id' => rand(1, 10),
                    'waktu' => $date->format('Y-m-d'),
                    'kuantitas' => $kuantitas,
                    'satuan' => $satuan,
                ]);
            }
            
            if ($randomPemasukanInventaris2) {

                $inventaris_id = array_values([1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 3, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14])[array_rand([1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 3, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14])];
                
                if (in_array($inventaris_id, [1, 2])) {
                    $kuantitas = mt_rand(2000, 10000) / 100;
                    $satuan = 'kg';
                } else if (in_array($inventaris_id, [3, 4, 5, 6, 7, 8, 9])) {
                    $kuantitas = rand(2, 10);
                    $satuan = 'botol';
                } else {
                    $kuantitas = rand(1, 4);
                    $satuan = 'unit';
                }
                
                PemasukanInventaris::create([
                    'inventaris_id' => $inventaris_id,
                    'kandang_id' => rand(1, 10),
                    'waktu' => $date->format('Y-m-d'),
                    'kuantitas' => $kuantitas,
                    'satuan' => $satuan,
                ]);
            }
            
            if ($randomPemasukanInventaris3) {
                
                $inventaris_id = array_values([1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 3, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14])[array_rand([1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 3, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14])];
                
                if (in_array($inventaris_id, [1, 2])) {
                    $kuantitas = mt_rand(2000, 10000) / 100;
                    $satuan = 'kg';
                } else if (in_array($inventaris_id, [3, 4, 5, 6, 7, 8, 9])) {
                    $kuantitas = rand(2, 10);
                    $satuan = 'botol';
                } else {
                    $kuantitas = rand(1, 4);
                    $satuan = 'unit';
                }

                PemasukanInventaris::create([
                    'inventaris_id' => $inventaris_id,
                    'kandang_id' => rand(1, 10),
                    'waktu' => $date->format('Y-m-d'),
                    'kuantitas' => $kuantitas,
                    'satuan' => $satuan,
                ]);
            }

            if ($randomPengeluaranInventaris1) {
            
                $inventaris_id = array_values([1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 3, 3, 4, 5, 6, 7, 8, 9])[array_rand([1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 3, 3, 4, 5, 6, 7, 8, 9])];
                
                if (in_array($inventaris_id, [1, 2])) {
                    $kuantitas = mt_rand(1000, 4000) / 100;
                    $satuan = 'kg';
                } else if (in_array($inventaris_id, [3, 4, 5, 6, 7, 8, 9])) {
                    $kuantitas = rand(1, 3);
                    $satuan = 'botol';
                } else {
                    $kuantitas = rand(1, 3);
                    $satuan = 'unit';
                }
            
                PengeluaranInventaris::create([
                    'inventaris_id' => $inventaris_id,
                    'kandang_id' => rand(1, 10),
                    'waktu' => $date->format('Y-m-d'),
                    'kuantitas' => $kuantitas,
                    'satuan' => $satuan,
                ]);
            }

            if ($randomPengeluaranInventaris2) {
            
                $inventaris_id = array_values([1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 3, 3, 4, 5, 6, 7, 8, 9])[array_rand([1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 3, 3, 4, 5, 6, 7, 8, 9])];
                
                if (in_array($inventaris_id, [1, 2])) {
                    $kuantitas = mt_rand(1000, 4000) / 100;
                    $satuan = 'kg';
                } else if (in_array($inventaris_id, [3, 4, 5, 6, 7, 8, 9])) {
                    $kuantitas = rand(1, 3);
                    $satuan = 'botol';
                } else {
                    $kuantitas = rand(1, 3);
                    $satuan = 'unit';
                }
            
                PengeluaranInventaris::create([
                    'inventaris_id' => $inventaris_id,
                    'kandang_id' => rand(1, 10),
                    'waktu' => $date->format('Y-m-d'),
                    'kuantitas' => $kuantitas,
                    'satuan' => $satuan,
                ]);
            }

            if ($randomPengeluaranInventaris3) {
            
                $inventaris_id = array_values([1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 3, 3, 4, 5, 6, 7, 8, 9])[array_rand([1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 3, 3, 4, 5, 6, 7, 8, 9])];
                
                if (in_array($inventaris_id, [1, 2])) {
                    $kuantitas = mt_rand(1000, 4000) / 100;
                    $satuan = 'kg';
                } else if (in_array($inventaris_id, [3, 4, 5, 6, 7, 8, 9])) {
                    $kuantitas = rand(1, 3);
                    $satuan = 'botol';
                } else {
                    $kuantitas = rand(1, 3);
                    $satuan = 'unit';
                }
            
                PengeluaranInventaris::create([
                    'inventaris_id' => $inventaris_id,
                    'kandang_id' => rand(1, 10),
                    'waktu' => $date->format('Y-m-d'),
                    'kuantitas' => $kuantitas,
                    'satuan' => $satuan,
                ]);
            }
            
            if ($randomTelur) {            
                Produksi::create([
                    'kandang_id' => rand(1, 10),
                    'telur_id' => rand(1, 3),
                    'tanggal' => $date->format('Y-m-d'),
                    'status' => array_values(['Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Busuk', 'Pecah', 'Terjual'])[array_rand(['Normal', 'Normal', 'Normal', 'Normal', 'Normal', 'Busuk', 'Pecah', 'Terjual'])],
                    'kuantitas' => rand(50, 0),
                ]);
            }
        }
    }
}
