<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Orchid\Attachment\Attachable;
use Orchid\Attachment\Models\Attachment;
use Orchid\Screen\AsSource;

class Post extends Model
{
    use HasFactory, AsSource, Attachable;

    protected $fillable = [
        'title',
        'body',
        'preview_image',
        'visibility',
        'preview_image',
    ];

    protected $casts = [
        'visibility' => 'boolean',
    ];

    public function previewImage(): HasOne
    {
        return $this->hasOne(Attachment::class, 'id', 'preview_image');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(PostTag::class, 'post_post_tags', 'post_id', 'post_tag_id');
    }
}
