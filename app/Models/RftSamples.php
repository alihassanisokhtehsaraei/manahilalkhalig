<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RftSamples extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'desc',
        'quantity',
        'seal',
        'standard',
        'user_id',
        'rft_id',
        'lab_fee_id',
        'ip'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rft()
    {
        return $this->belongsTo(Rft::class);
    }

    public function labFee()
    {
        return $this->belongsTo(LabFee::class);
    }
}
