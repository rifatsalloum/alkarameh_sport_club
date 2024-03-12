<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seasone extends Model
{
    use HasFactory;
    protected $fillable = [
        "uuid","name","start_date","end_date",
    ];
    protected $cast = [
        "uuid" => "string",
        "name" => "string",
        "start_date" => "string",
        "end_date"=> "string",
    ];
    protected $hidden = [
        "id",
    ];
    public function standings() : object {
        return $this->hasMany(Standing::class);
    }
    public function wears() : object {
        return $this->hasMany(Wear::class);
    }
    public function news() : object {
        return $this->morphMany(Information::class,"information_able");
    }
}
