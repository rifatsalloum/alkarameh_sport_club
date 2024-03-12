<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prime extends Model
{
    use HasFactory;
    protected $fillable = [
        "uuid","name","description","image","type","seasone_id","sport_id",
    ];
    protected $cast = [
        "uuid"=>"string",
        "name"=>"string",
        "description"=>"string",
        "image"=>"string",
        "type"=>"string",
    ];
    protected $hidden = [
        "id","seasone_id","sport_id",
    ];
    public function seasone() : object {
        return $this->belongsTo(Seasone::class);
    }
    public function sport() : object {
        return $this->belongsTo(Sport::class);
    }
}
