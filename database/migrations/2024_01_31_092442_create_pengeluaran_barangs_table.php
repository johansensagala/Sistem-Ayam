<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengeluaran_barangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('kandang_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->date('waktu')->nullable();
            $table->integer('jumlah_awal_barang')->nullable();
            $table->integer('jumlah_pengeluaran')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengeluaran_barangs');
    }
};
