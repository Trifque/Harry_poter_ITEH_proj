<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public function post(){ return $this->belongsTo(Post::class); }
    public function user(){ return $this->belongsTo(User::class); }

    protected $primaryKey = 'comment_id';

    protected $fillable = 
    [
        'post_id',
        'user_id',
        'text'
    ];
}
