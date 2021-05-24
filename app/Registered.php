<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registered extends Model
{
    protected $table = "registered";
    protected $fillable = [
        'name',
        'email',
        'password'
    ];
}
