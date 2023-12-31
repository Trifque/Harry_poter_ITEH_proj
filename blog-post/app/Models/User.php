<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    public function posts(){ return $this->hasMany(Post::class); }
    public function awarded_tos(){ return $this->hasMany(Awarded_to::class); }
    public function interactions(){ return $this->hasMany(Interaction::class); }
    public function comments(){ return $this->hasMany(Comment::class); }

    protected $primaryKey = 'user_id';

    protected $fillable = 
    [
        'username',
        'password',
        'country',
        'gender',
        'birth_date',
        'join_date',
        'email',
        'biography',
        'role',
        'house',
        'first_name',
        'last_name'
    ];
}
