<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Rak extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];

    protected function rak(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => strtoupper($value)
        );
    }

    public function device()
    {
        return $this->hasMany(Device::class);
    }
}
