<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PinjamRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'required|exists:App\Models\User,id',
            'student_id' => 'required|exists:App\Models\Student,id',
            'device_id' => 'required|exists:App\Models\Device,id',
            'peminjam_id' => 'nullable|exists:App\Models\Student,id',
        ];
    }
}
