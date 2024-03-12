<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matche extends Model
{
    use HasFactory;
    protected $fillable = [
        "uuid","when","status","plan","channel","round","play_ground","seasone_id","club1_id","club2_id",
    ];
    protected $cast = [
        "uuid" => "string",
        "when" => "string",
        "status" => "string",
        "plan" => "string",
        "channel" => "string",
        "round" => "string",
        "play_ground" => "string",
    ];
    protected $hidden = [
       "id","seasone_id","club1_id","club2_id",
    ];
    public function seasone() : object {
        return $this->belongsTo(Seasone::class);
    }
    public function firstClub() : object {
        return $this->belongsTo(Club::class,"club1_id");
    }
    public function secondClub(): object {
        return $this->belongsTo(Club::class,"club2_id");
    }
    public function players() : object {
        return $this->belongsToMany(Player::class,"plans")->withPivot("status");
    }
    public function replacements() : object {
        return $this->hasMany(Replacment::class);
    }
    public function statistics() : object {
        return $this->hasMany(Statistic::class);
    }
    public function news() : object {
        return $this->morphMany(Information::class,"information_able");
    }
    public function videos():object{
        return $this->morphMany(Video::class,"video_able");
    }
}
