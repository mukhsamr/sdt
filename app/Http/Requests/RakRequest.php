<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RakRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'rak' => 'required|unique:App\Models\Rak,rak,' . $this->id
        ];
    }
}
