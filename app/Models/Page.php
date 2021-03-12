<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Model;

    class Page extends Model
    {

        /**
         * Types of page
         */
        const TYPE_BASIC   = 1; // basic pages

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
