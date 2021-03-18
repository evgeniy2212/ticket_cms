<?php

    namespace App\Models;

    use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
    use Astrotomic\Translatable\Translatable;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\MorphMany;

    class Page extends Model implements TranslatableContract
    {
        use Translatable;

        protected $guarded = [];

        public $translatedAttributes = ['title', 'subtitle', 'body'];

        public $with = [
            'translations',
        ];

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

        public function fields(): MorphMany
        {
            return $this->morphMany(Field::class, 'model');
        }
    }
