<?php

namespace App\Filters;

use App\Models\Role;
use Illuminate\Http\Request;

class UserFilters extends QueryFilters
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct($request);
    }

    public function sort($sort = 'desc')
    {
        return $this->builder->orderBy('id', $sort);
    }

    public function filter($term)
    {
        return $this->builder
            ->orWhere('email', 'LIKE', "%$term%")
            ->orWhere('name', 'LIKE', "%$term%");
    }
}
