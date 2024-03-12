<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sport extends Model
{
    use HasFactory;
    protected $fillable = [
        "uuid","name","image",
    ];
    protected $cast = [
        "uuid" => "string",
        "name" => "string",
        "image" => "string",
    ];
    protected $hidden = [
        "id",
    ];
    public function players() : object {
        return $this->hasMany(Player::class);
    }
    public function clubs() : object {
        return $this->hasMany(Club::class);
    }
}
