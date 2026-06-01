<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavoriteBook extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'author',
        'first_publish_year',
        'cover_url',
        'open_library_key',
    ];
}
