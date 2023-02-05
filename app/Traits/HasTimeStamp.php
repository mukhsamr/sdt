<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * TimeStamp
 */
trait HasTimeStamp
{
    protected function diBuat(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->created_at?->format('H:i:s'),
        );
    }

    protected function diEdit(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->updated_at?->format('H:i:s'),
        );
    }

    protected function diHapus(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->deleted_at?->format('H:i:s'),
        );
    }
}
