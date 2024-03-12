<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopFan extends Model
{
    use HasFactory;
    protected $fillable = [
        "uuid","name","association_id",
    ];
    protected $cast = [
        "uuid" => "string",
        "name" => "string",
    ];
    protected $hidden = [
       "id","association_id",
    ];
    public function association() : object {
        return $this->belongsTo(Association::class);
    }
}
