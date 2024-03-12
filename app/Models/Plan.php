<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;
    protected $fillable = [
        "uuid","player_id","matche_id","status",
    ];
    protected $cast = [
        "uuid" => "string",
        "status" => "string",
    ];
    protected $hidden = [
        "id","player_id","matche_id",
    ];
    public function player() : object {
        return $this->belongsTo(Player::class);
    }
    public function matche(): object {
        return $this->belongsTo(Matche::class);
    }
}
