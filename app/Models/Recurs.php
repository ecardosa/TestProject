<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recurs extends Model
{
    use HasFactory;

    protected $table = 'recursos';
    protected $fillable = ['titol', 'contingut', 'visible', 'curs_id'];

    public function curs()
    {
        return $this->belongsTo(Curs::class);
    }
}
