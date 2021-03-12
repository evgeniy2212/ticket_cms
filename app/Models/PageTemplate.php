<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

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
}
