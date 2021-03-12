<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FieldTranslation extends Model
{
    protected $fillable = ['title', 'subtitle', 'body'];
    public $timestamps = false;
}
