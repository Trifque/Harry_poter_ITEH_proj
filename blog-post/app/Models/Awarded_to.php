<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Awarded_to extends Model
{
    use HasFactory;

    public function award(){ return $this->belongsTo(Award::class); }
    public function user(){ return $this->belongsTo(User::class); }
    public function post(){ return $this->belongsTo(Post::class); }

    protected $fillable = 
    [
        'award_id',
        'user_id',
        'post_id'
    ];
}
