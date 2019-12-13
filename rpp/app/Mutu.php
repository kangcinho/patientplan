<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mutu extends Model
{
    protected $table = "mutu";
    protected $fillable = ['mutuUmum', 'mutuIKS', 'mutuBPJS', 'isAktif'];
    protected $primaryKey = 'id';
    protected $casts = [
        'isAktif' => 'boolean',
    ];
}
