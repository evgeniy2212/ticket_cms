<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class FieldItem extends Model implements TranslatableContract
{
    use Translatable;

    protected $guarded = [];

    public $timestamps = false;

    public $translatedAttributes = ['title', 'subtitle', 'body'];

    public $with = [
        'translations',
    ];
}
