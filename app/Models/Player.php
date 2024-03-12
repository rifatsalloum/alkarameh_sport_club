<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;
    protected $fillable = [
        "uuid","name","high","play","number","born","from","first_club","career","image","sport_id",
    ];
    protected $cast = [
        "uuid" => "string",
        "name" => "string",
        "high" => "string",
        "play" => "string",
        "number" => "string",
        "born" => "string",
        "from" => "string",
        "first_club" => "string",
        "career" => "string",
        "image" => "string",
    ];
    protected $hidden = [
        "id","sport_id",
    ];
    public function sport(): object {
        return $this->belongsTo(Sport::class);
    }
    public function matches() : object {
        return $this->belongsToMany(Matche::class,"plans")->withPivot("status");
    }
    public function plans() : object {
        return $this->hasMany(Plan::class);
    }
}
