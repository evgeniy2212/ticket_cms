<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $guarded = [];

    /**
     * Scope filter by active
     *
     * @param $query
     *
     * @return mixed
     */
    public function scopeDefault($query)
    {
        return $query->whereIsDefault(true);
    }
}
