<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['EPC', 'title', 'price', 'stock', 'description', 'image'];
    public function Categories(){
        return $this->belongsToMany(Category::class);
    }
}
