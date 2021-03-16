<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Field extends Model
{
    protected $guarded = [];

    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    public function fieldItems(): HasMany
    {
        return $this->hasMany(FieldItem::class);
    }

    public function type()
    {
        return $this->belongsTo(FieldType::class, 'field_type_id');
    }
}
