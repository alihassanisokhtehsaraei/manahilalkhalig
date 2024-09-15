<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NonReleaseDocument extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function coc()
    {
        return $this->belongsTo(Coc::class);
    }

    public function order()
    {
        return $this->hasOneThrough(Order::class, Coc::class);
    }
}
