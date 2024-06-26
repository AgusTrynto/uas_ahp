<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KriteriaMatrix extends Model
{
    use HasFactory;
    protected $table = 'kriteriamatrix';

    protected $fillable = ['idkriteria1', 'idkriteria2', 'value'];

    public function kriteria1()
    {
        return $this->belongsTo(Kriteria::class, 'idkriteria1');
    }

    public function kriteria2()
    {
        return $this->belongsTo(Kriteria::class, 'idkriteria2');
    }
}
