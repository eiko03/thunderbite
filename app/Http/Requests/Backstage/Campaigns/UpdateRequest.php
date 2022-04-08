<?php

namespace App\Http\Requests\Backstage\Campaigns;

    use Illuminate\Foundation\Http\FormRequest;
    use Illuminate\Validation\Rule;

    class UpdateRequest extends FormRequest
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
                'name' => 'required|max:255|unique:campaigns,name',
                'timezone' => 'required',
                'starts_at' => 'required|date_format:d-m-Y H:i:s',
                'ends_at' => 'required|date_format:d-m-Y H:i:s',
            ];
        }
    }
