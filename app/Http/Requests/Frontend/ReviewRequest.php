<?php

    namespace App\Http\Requests\Frontend;

    use App\Models\Reviews\Review;
    use Illuminate\Foundation\Http\FormRequest;
    use Illuminate\Support\Facades\App;
    use Illuminate\Support\Facades\Input;
    use Illuminate\Validation\Rule;

    class ReviewRequest extends FormRequest
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
            $lang  = App::getLocale();
            $rules = [];

            $rules['model']           = ['required', 'in' => Rule::in(array_keys(Review::MODELS))];
            $rules['rating']           = 'required|numeric|between:0,5';
            $rules['email']            = 'required|email|max:255';
            $rules[$lang . '.name']    = 'required|max:255';
            $rules[$lang . '.city']    = 'required|max:255';
            $rules[$lang . '.comment'] = 'required';

            return $rules;
        }
    }
