<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Field extends Model implements TranslatableContract
{
    use Translatable;

    public const COMPONENT_PARAGRAPH = 'paragraph';
    public const COMPONENT_HEADER    = 'header';
    public const COMPONENT_HTML      = 'html5';
    public const COMPONENT_QUOTE     = 'quote';
    public const COMPONENT_LIST      = 'list';
    public const COMPONENT_OPINION   = 'opinion';
    public const COMPONENT_SLIDER    = 'slider';
    public const COMPONENT_READ_MORE = 'read-more';
    public const COMPONENT_SPOILER   = 'spoiler';
    public const COMPONENT_IFRAME    = 'iframe';
    public const COMPONENT_FILE       = 'file';

    protected $guarded = [];

    public $translatedAttributes = ['title', 'subtitle', 'body'];

    public $with = [
        'translations',
    ];
}
