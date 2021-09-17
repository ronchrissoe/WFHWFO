<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterKerja extends Model
{
    use HasFactory;
    protected $table = 'm_kerja';
    protected $fillable = 
    [
        'kdkerja', 'kerja', 'maksimum'
    ];
}
