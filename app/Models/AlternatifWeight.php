<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlternatifWeight extends Model
{
    use HasFactory;
    protected $fillable = ['alternatif_id', 'kriteria_id', 'weight'];
}
