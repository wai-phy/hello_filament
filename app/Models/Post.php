<?php

namespace App\Models;

use App\Models\User;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function authors():BelongsToMany
    {
        return $this->belongsToMany(User::class,'post_user')->withPivot(['order'])->withTimestamps();
    }

    public function comments(){
        return $this->morphMany(Comment::class,'commentable');
    }

}
