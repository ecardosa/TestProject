<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curs extends Model
{
    use HasFactory;

    protected $table = 'cursos';
    protected $fillable = ['nom', 'etapa', 'descripcio', 'visible'];

    public function recursos()
    {
        return $this->hasMany(Recurs::class);
    }
}
