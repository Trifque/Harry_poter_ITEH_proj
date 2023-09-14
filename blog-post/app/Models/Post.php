<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public function category(){ return $this->belongsTo(Category::class); }
    public function user(){ return $this->belongsTo(User::class); }

    public function awarded_tos(){ return $this->hasMany(Awarded_to::class); }
    public function interactions(){ return $this->hasMany(Interaction::class); }
    public function comments(){ return $this->hasMany(Comment::class); }

    protected $primaryKey = 'post_id';

    protected $fillable = 
    [
        'user_id',
        'category_id',
        'title',
        'content',
        'date',
        'time',
        'popularity'
    ];
}
