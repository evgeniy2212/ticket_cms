<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageTranslation extends Model
{
    protected $fillable = [
        'name',
        'url',
        'body',
        'description',
        'seo_title',
        'seo_keywords',
        'seo_description',
        'seo_canonical',
        'seo_robots',
        'seo_content',
        'locale'
    ];

    public $timestamps = false;
}
