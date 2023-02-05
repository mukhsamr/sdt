<?php

namespace App\Models;

use App\Traits\HasTimeStamp;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pinjam extends Model
{
    use HasFactory,
        SoftDeletes,
        HasTimeStamp;

    protected $guarded = ['id'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    protected $appends = ['di_buat', 'di_edit', 'di_hapus'];


    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A&M
    protected function status(): Attribute
    {
        return Attribute::make(
            get: function () {

                $limit = $this->created_at->addHours(2);

                // Jika belum dikembalikan
                if (!$this->deleted_at) {
                    $now = now();

                    if ($now > $limit) {
                        $diffMenit = $limit->diffInMinutes($now);

                        if ($diffMenit) {
                            return [
                                'color' => 'danger',
                                'message' => "Terlambat $diffMenit menit"
                            ];
                        }
                    }
                }

                // Jika sudah dikembalikan
                if ($deleted = $this->deleted_at) {

                    if ($deleted > $limit) {
                        $diffMenit = $limit->diffInMinutes($deleted);

                        if ($diffMenit) {
                            return [
                                'color' => 'danger',
                                'message' => "Terlambat $diffMenit menit"
                            ];
                        }
                    }

                    return [
                        'color' => 'dark',
                        'message' => "Sudah kembali"
                    ];
                }
            }
        );
    }
}
