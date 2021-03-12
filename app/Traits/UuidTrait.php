<?php
    namespace App\Traits;

    use Illuminate\Support\Str;

    trait UuidTrait
    {
        protected static function boot()
        {
            parent::boot();
            static::creating(function ($model) {
                $model->{$model->getKeyName()} = $model->generateNewUuid();

                return true;
            });
        }

        public function getIdAttribute($value)
        {
            if (is_object($value)) {
                return $value->toString();
            } else {
                return $value;
            }
        }

        public function generateNewUuid()
        {
            return Str::uuid();
        }
    }
