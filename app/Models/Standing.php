<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Standing extends Model
{
    use HasFactory;
    protected $fillable = [
        "uuid","win","lose","draw","diff","points","play","seasone_id","club_id",
    ];
    protected $cast = [
        "uuid" => "string",
        "win" => "string",
        "lose" => "string",
        "draw" => "string",
        "diff" => "string",
        "points" => "string",
        "play" => "string",
    ];
    protected $hidden = [
        "id","seasone_id","club_id",
    ];
    public function seasone() : object {
        return $this->belongsTo(Seasone::class);
    }
    public function club() : object {
        return $this->belongsTo(Club::class);
    }
}
