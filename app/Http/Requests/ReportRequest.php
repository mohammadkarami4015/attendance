<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportRequest extends FormRequest
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
            'user_id'=>'required',
            'start_date'=>'required',
            'end_date'=>'required'
        ];
    }

    public function messages()
    {
        return [
            'user_id.required'=>' انتخاب کاربر الزامی است',
            'start_date.required'=>' تاریخ شروع را وارد کنید',
            'end_date.required'=>' تاریخ پایان را وارد کنید',
        ];

    }
}
