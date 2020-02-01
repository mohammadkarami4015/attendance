<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShiftRequest extends FormRequest
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
        if ($this->method() =='post') {
            return [
                'title' => 'required|min:4|max:20|unique:units,title|regex:/^[\pL\s\-]+$/u',
                'days' => 'required'
            ];
        }else
            return [
                'title' => 'required|min:4|max:20|unique:units,title|regex:/^[\pL\s\-]+$/u',
            ];
    }
    public function messages()
    {
        return [
            'title.required' => 'عنوان اجباری است',
            'title.min' => 'عنوان وارد شده باید بیشتر از 4 کاراکتر باشد',
            'title.max' => 'عنوان وارد شده باید کمتر از 20 کاراکتر باشد',
            'title.unique' => 'عنوان وارد شده  تکراری می باشد',
            'title.regex' => 'عنوان وارد شده صحیح نمی باشد',

        ];
    }
}
