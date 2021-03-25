<?php

namespace App\Filters;

use Illuminate\Http\Request;

class UserFilters extends QueryFilters
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct($request);
    }

    public function sortBy($sort = 'id')
    {
        return $this->builder->orderBy($sort, str_boolean($this->request->descending) ? 'desc' : 'asc');
    }

    public function filter($term)
    {
        return $this->builder
            ->orWhere('email', 'LIKE', "%$term%")
            ->orWhere('name', 'LIKE', "%$term%");
    }

    public function trashed()
    {
        return $this->builder->onlyTrashed();
    }
}
