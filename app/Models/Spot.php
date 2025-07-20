<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Spot extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public function getImageAsset()
    {
        if($this->image) {
            return asset('upload/spots/'.$this->image);
        }
        return 'https://placehold.co/150x200?text=Hello+World';
    }
    // public function getDokuemAsset()
    // {
    //     if($this->dokumen) {
    //         return asset('upload/dokumen/'.$this->dokumen);
    //     }
    // }
}
