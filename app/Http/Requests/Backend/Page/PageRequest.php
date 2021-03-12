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
            $rules['alias']  = [
                'nullable',
                'max:255',
                'regex:/[' . config('app.alias_chars') . ']*/',
                'unique:pages,alias,' . request()->page . ',id',
            ];
            $rules['title']  = 'required';
            $rules['active'] = 'required|boolean';

            return $rules;
        }
    }
