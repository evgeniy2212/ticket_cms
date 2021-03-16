<?php

namespace App\Http\Requests\Backend\Template;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class CreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
//        dd(request()->all());
        return [
            'fields.*.body'               => [
                'nullable',
                'string',
                'max:65535',
            ],
            'fields.*.title'              => [
                'nullable',
                'string',
                'max:255',
            ],
            'fields.*.subtitle'           => [
                'nullable',
                'string',
                'max:255',
            ],
            'fields.*.field_items.*.name' => [
                'nullable',
                'string',
                'max:255',
            ],
        ];
    }
}
