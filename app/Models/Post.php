<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'thumbnail',
        'title',
        'color',
        'slug',
        'category_id',
        'content',
        'tags',
        'published',
    ];

    protected $casts = [
        'tags' => 'array',
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

}
