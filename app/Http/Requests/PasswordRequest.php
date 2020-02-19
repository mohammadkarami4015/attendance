<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
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
            'user_id'=>'required|numeric',
            'password'=>'required|max:10|min:4',
        ];
    }

    public function messages()
    {
        return [

            'password.required' => "رمز عبور اجباری است",
            'password.min' => "رمز عبور باید بیشتر از :min کاراکتر باشد",
            'password.max' => "رمز عبور باید کمتر از :max کاراکتر باشد",
            'password.confirmed' => "رمز عبور جدید منطبق نیست",
            'user_id.required' => "کاربر را انتخاب کنبد ",

        ];
    }
}
