<?php

    namespace App\Http\Requests\Backend\Clients;

    use Illuminate\Foundation\Http\FormRequest;

    class StoreRequest extends FormRequest
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
                'first_name'       => 'required|max:255',
                'last_name'        => 'required|max:255',
                'email'            => 'required|email|unique:clients,email,' . $this->route('client') . ',id,deleted_at,NULL',
                'phone'            => 'nullable|max:30|unique:clients,phone,' . $this->route('client') . ',id,deleted_at,NULL',
                'password'         => 'nullable|min:6',
            ];
        }
    }
