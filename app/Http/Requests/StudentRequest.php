<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'uid' => 'required|unique:App\Models\Student,uid,' . $this->id,
            'nama' => 'required',
            'tipe' => 'required'
        ];
    }
}
