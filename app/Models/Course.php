<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'name',
        'description',
        'slug',
    ];

    public function user(){
        return $this->hasOne(User::class);
    }
}
