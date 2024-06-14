<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Post extends Model
{
    use HasFactory, AsSource;

    protected $fillable = [
        'post_category_id',
        'title',
        'body',
        'preview_image',
        'visibility',
    ];

    protected $casts = [
        'visibility' => 'boolean',
    ];
}
