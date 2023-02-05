<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Relation
    public function rak()
    {
        return $this->belongsTo(Rak::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function pinjams()
    {
        return $this->hasMany(Pinjam::class);
    }

    // Scope
    public function scopeWithStatus(Builder $query)
    {
        $query->addSelect([
            'status' => Pinjam::select('id')->whereColumn('device_id', 'devices.id')->take(1)
        ]);
    }
}
