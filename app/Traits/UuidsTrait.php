<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait UuidsTrait
{
    protected static function bootUuidsTrait()
    {
        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }

    public function getUuid()
    {
        return (string) Str::uuid();
    }
}
