<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeatherCalculateRequest extends FormRequest
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
            'amount' => ['required', 'integer', 'min:1'],
            'item' => ['required', 'string'],
            'material1' => ['required', 'string', 'nullable'],
            'material2' => ['required', 'string'],
            // TODO: compare skill level to required skill level
            'skill_level' => ['required', 'integer', 'min:0', 'max:200'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     *
    public function messages()
    {
        return [
            'title.required' => 'A title is required',
            'body.required' => 'A message is required',
        ];
    } //*/
}
