<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Association extends Model
{
    use HasFactory;
    protected $fillable = [
        "uuid","boss","image","description","country","sport_id",
    ];
    protected $cast = [
        "uuid" => "string",
        "boss" => "string",
        "image" => "string",
        "description" => "string",
        "country" => "string",
    ];
    protected $hidden = [
        "id","sport_id",
    ];

    public function sport() : object {
        return $this->belongsTo(Sport::class);
    }
    public function topFans() : object {
        return $this->hasMany(TopFan::class);
    }
    public function videos() : object {
        return $this->morphMany(Video::class,"video_able");
    }
}
