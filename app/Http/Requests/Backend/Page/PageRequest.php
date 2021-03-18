<?php

    namespace App\Http\Requests\Backend\Page;

    use Illuminate\Foundation\Http\FormRequest;
    use Setting;

    class PageRequest extends FormRequest
    {
        /**
         * Determine if the user is authorized to make this request.
         *
         * @return bool
         */
        public function authorize()
        {
            return true;
        }

        /**
         * Get the validation rules that apply to the request.
         *
         * @return array
         */
        public function rules()
        {
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
