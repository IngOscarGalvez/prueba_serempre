<?php

namespace App\Http\Requests\maids;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreMaidRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (bool) Auth::user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'type_doc' => ['required'],
            'doc' => ['required'],
            'description' => ['required', 'max:6000'],
            'photo' => ['required'],
            'city_id' => ['required', 'exists:App\City,id']
        ];
    }
}
