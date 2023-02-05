<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeviceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'uid' => 'required|unique:App\Models\Device,uid,' . $this->id,
            'jenis' => 'required',
            'rak_id' => 'nullable|required'
        ];
    }
}
