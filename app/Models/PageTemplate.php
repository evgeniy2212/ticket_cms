<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class PageTemplate extends Model
{
    protected $guarded = [];

    /**
     * Filter query bu only available to frontend pages
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->whereActive(true);
    }

    public function fields(): MorphMany
    {
        return $this->morphMany(Field::class, 'model');
    }
}
