<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = [
        "uuid","name","jop_type","work","image","sport_id"	
    ];
    protected $cast = [
        "uuid" => "string",
        "name" => "string",
        "jop_type" => "string",
        "work" => "string",
        "image"=>"string",
    ];
    protected $hidden = [
        "id","sport_id",
    ];
    public function sport() : object {
        return $this->belongsTo(Sport::class);
    }
}
