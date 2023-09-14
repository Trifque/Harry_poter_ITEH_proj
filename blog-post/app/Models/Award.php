<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    use HasFactory;

    public function awarded_tos(){ return $this->hasMany(Awarded_to::class); }

    protected $primaryKey = 'award_id';

    protected $fillable = 
    [
        'award_type',
        'award_name',
        'description'
    ];
}
