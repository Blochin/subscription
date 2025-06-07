<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Money implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes): object
    {
        return (object) [
            'raw' => (int) $value,
            'readable' => number_format($value / 100, 2, '.', ' ') . ' €',
        ];
    }

    public function set($model, string $key, $value, array $attributes): int
    {
        if (is_array($value)) {
            return (int) $value['raw'];
        }

        if (is_object($value) && property_exists($value, 'raw')) {
            return (int) $value->raw;
        }

        return (int) $value;
    }
}
