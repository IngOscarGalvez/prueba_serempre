<?php

namespace App\Http\Requests\services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceRequest extends FormRequest
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
            'title' => ['required', 'max:255'],
            'description' => ['required', 'max:6000'],
            'icon' => ['required'],
            // 'iconColor' => ['required'],
            'include' => ['required', 'max:6000'],
            'not_include' => ['required', 'max:6000'],
        ];
    }
}
