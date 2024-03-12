<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Information extends Model
{
    use HasFactory;
    protected $fillable = [
        "uuid","title","content","image","reads","type",
    ];
    protected $cast = [
        "uuid" => "string",
        "title" => "string",
        "content" => "string",
        "image" => "string",
        "reads" => "string",
        "type" => "string",
    ];
    protected $hidden = [
        "id",
    ];
    public function information_able() : MorphTo {
        return $this->morphTo();
    }
}
