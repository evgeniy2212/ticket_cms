<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FieldType extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    /**
     * Scope filter by active
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeOnlyActive($query)
    {
        return $query->whereIsActive(true);
    }
}
