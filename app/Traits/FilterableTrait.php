<?php

namespace App\Traits;

use App\Filters\QueryFilters;

trait FilterableTrait
{
    public function scopeFilter($query, QueryFilters $filters)
    {
        return $filters->apply($query);
    }
}
