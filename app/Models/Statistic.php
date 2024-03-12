<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    use HasFactory;
    protected $fillable = [
        "uuid","name","value","matche_id"
    ];
    protected $cast = [
        "uuid"=>"string",
        "name"=>"string",
        "value"=>"array",
    ];
    protected $hidden = [
        "id","matche_id",
    ];
    public function matche() : object {
        return $this->belongsTo(Matche::class);
    }
}
