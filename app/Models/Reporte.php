<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    use HasFactory;

    protected $fillable = [
		'denunciante',
		'denunciado',
        'username',
        'post_id',
        'motivo',
        'estado'
	];
}
