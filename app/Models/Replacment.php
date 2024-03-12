<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Replacment extends Model
{
    use HasFactory;
    protected $fillable = [
        "uuid","inplayer_id","outplayer_id","matche_id",
    ];
    protected $cast = [
        "uuid" => "string",
    ];
    protected $hidden = [
        "uuid","inplayer_id","outplayer_id","matche_id","id",
    ];
    public function matche() : object {
        return $this->belongsTo(Matche::class);
    }
    public function outPlayer() : object {
        return $this->belongsTo(Player::class,"outplayer_id");
    }
    public function inPlayer() : object {
        return $this->belongsTo(Player::class,"inplayer_id");
    }
}
