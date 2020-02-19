<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        if ($this->isMethod('post'))
            return [
                'name' => ['required', 'min:3', 'max:20', 'regex:/^[\pL\s\-]+$/u'],
                'family' => ['required', 'min:3', 'max:30', 'regex:/^[\pL\s\-]+$/u'],
                'national_code' => ['required', 'digits:10', 'unique:users,national_code'],
                'personal_code' => ['required', 'digits:5', 'unique:users,personal_code'],
                'unit_id' => ['required', 'exists:units,id'],
            ];
        else
            return [
                'name' => ['required', 'min:3', 'max:20', 'regex:/^[\pL\s\-]+$/u'],
                'family' => ['required', 'min:3', 'max:30', 'regex:/^[\pL\s\-]+$/u'],
                'national_code' => ['required', 'digits:10'],
                'personal_code' => ['required', 'digits:5'],
                'unit_id' => ['required', 'exists:units,id'],
            ];
    }

    public function messages()
    {
        return [
            'name.required' => "نام اجباری است",
            'name.regex' => "نام فقط باید شامل حروف باشد",
            'name.min' => 'نام باید بیشتر از :min کاراکتر باشد',
            'name.max' => 'نام باید کمتر از :max کاراکتر باشد',
            'parent_id.exists' => 'سرپرست انتخاب شده معتبر نیست',
            'family.required' => "نام خانوادگی اجباری است",
            'family.regex' => "نام خانوادگی فقط باید شامل حروف باشد",
            'family.min' => 'نام خانوادگی باید بیشتر از :min کاراکتر باشد',
            'family.max' => 'نام باید کمتر از :max کاراکتر باشد',

            'national_code.required' => 'کدملی اجباری است',
            'national_code.digits' => 'کدملی باید :digits رقم باشد ',
            'national_code.unique' => 'کدملی باید یکتا باشد ',

            'personal_code.required' => 'کد پرسنلی اجباری است',
            'personal_code.digits' => 'کد پرسنلی باید :digits رقم باشد',
            'personal_code.unique' => 'کد پرسنلی باید یکتا باشد',

            'password.required' => "رمز عبور اجباری است",
            'password.min' => "رمز عبور باید بیشتر از :min کاراکتر باشد",
            'password.max' => "رمز عبور باید کمتر از :max کاراکتر باشد",
            'password.confirmed' => "رمز عبور جدید منطبق نیست",
            'section_id.required' => "قسمت مربوطه الزامی است",
            'roles.required' => 'نقش کاربر الزامی می باشد',
        ];
    }
}
