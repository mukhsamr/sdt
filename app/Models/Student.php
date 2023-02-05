<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function booted()
    {
        static::addGlobalScope('tipe', function (Builder $builder) {
            $builder->where('tipe', session('tipe'));
        });
    }

    public function devices()
    {
        return $this->hasMany(Device::class);
    }

    public function pinjams()
    {
        return $this->hasMany(Pinjam::class);
    }

    // Scope
    public function latestPinjam()
    {
        return $this->hasOne(Pinjam::class)->withTrashed()->latestOfMany();
    }
}
