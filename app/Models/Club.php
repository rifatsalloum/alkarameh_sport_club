<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use HasFactory;
    protected $fillable = [
        "uuid","name","address","logo","sport_id",
    ];
    protected $cast = [
        "uuid" => "string",
        "name" => "string",
        "address" => "string",
        "logo" => "string",
    ];
    protected $hidden = [
        "id","sport_id",
    ];
    public function standings() : object {
        return $this->hasMany(Standing::class);
    }
    public function informations() : object {
        return $this->morphMany(Information::class,"information_able");
    }
    public function videos() : object {
        return $this->morphMany(Video::class,"video_able");
    }
    public function sport() : object {
        return $this->belongsTo(Sport::class);
    }
}
