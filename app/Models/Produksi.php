<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Produksi extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Get the kandang that owns the Produksi
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kandang(): BelongsTo
    {
        return $this->belongsTo(Kandang::class);
    }

    public function telur(): BelongsTo
    {
        return $this->belongsTo(Telur::class);
    }

    public function scopeFilter($q, $filter)
    {
        $q->when($filter->status ?? false, fn ($q, $status) => $q->where('status', $status));
        $q->when($filter->startDate ?? false, fn ($q, $startDate) => $q->where('tanggal', '>=', $startDate));
        $q->when($filter->endDate ?? false, fn ($q, $endDate) => $q->where('tanggal', '<=', $endDate));
        $q->when($filter->kandang_id ?? false, fn($q, $kandangId) => $q->where('kandang_id', $kandangId)); 
        $q->when($filter->telur_id ?? false, fn($q, $telurId) => $q->where('telur_id', $telurId)); 
    }
}
