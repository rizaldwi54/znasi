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
            return asset('upload/image/'.$this->image);
        }
        return 'https://placehold.co/150x200?text=No+Image';
    }
}
