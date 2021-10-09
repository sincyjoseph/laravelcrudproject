<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laravelcrud extends Model
{
    use HasFactory;
    protected $fillable=['username','password','email','gender','address','declaration'];
}
