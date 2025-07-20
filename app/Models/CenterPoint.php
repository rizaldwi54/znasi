<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CenterPoint extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    protected $fillable = ['coordinates'];
}
