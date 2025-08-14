<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class pendaftaran extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    protected $fillable = [
        'name',
        'address',
        'parents_name',
        'coordinates',
        'pdf'
    ];
}
