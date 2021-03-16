<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FieldItemTranslation extends Model
{
    protected $fillable = ['title', 'subtitle', 'body'];

    public $timestamps = false;
}
