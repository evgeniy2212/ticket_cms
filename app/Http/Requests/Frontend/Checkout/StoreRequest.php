<?php

	namespace App\Http\Requests\Frontend\Checkout;

	use Illuminate\Foundation\Http\FormRequest;

	class StoreRequest extends FormRequest
	{
		/**
		 * Determine if the user is authorized to make this request.
		 *
		 * @return bool
		 */
		public function authorize ()
		{
			return true;
		}

		/**
		 * Get the validation rules that apply to the request.
		 *
		 * @return array
		 */
		public function rules ()
		{
			return [
				'name'        => 'required|string|max:255',
				'email'       => 'required|unique:clients,email,' . (auth()->user() ? auth()->user()->id : null) . ',id,deleted_at,NULL|max:255',
				'phone'       => 'required|string|max:255',
				'region_id'   => 'nullable|exists:regions,id',
				'city'        => 'required_without:place_id|string|max:255',
				'address'     => 'required_without:place_id|string|max:255',
                'place_id'    => 'required_without:address|string|max:255',
				'delivery_id' => 'required|exists:deliveries,id',
				'payment_id'  => 'required|exists:payments,id',
			];
		}
	}
