<?php

namespace App\Http\Requests;

use App\Rules\Url;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveStoryRequest extends FormRequest
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
            'data.attributes.title' => ['required','min:4'],
            'data.attributes.url' => [
                'required', 
                Rule::unique('stories','url')->ignore($this->route('story')), 
                'alpha_dash',
                new Url()
            ],
            'data.attributes.content' => ['required']
        ];
    }

    /**
     * Get the validated data from the request.
     * OVERWRITTEN function to abbreaviate 
     * access of inputs.
     * @return array
     */
    public function validated()
    {
        return parent::validated()['data']['attributes'];
    }
}
