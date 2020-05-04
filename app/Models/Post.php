<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded=[];

    protected $dates=[
        'published_at'
    ];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function syncTags($tags)
    {
        $tagIds = collect($tags)->map(function ($tag) {
            return Tag::find($tag) ? $tag : Tag::create(['name' => $tag])->id;
        });

        return $this->tags()->sync($tagIds);
    }
}
