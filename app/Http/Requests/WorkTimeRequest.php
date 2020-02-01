<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkTimeRequest extends FormRequest
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
            'days'=>'required',
            'ws'=>'required',
            'we'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'days.required' => 'انتخاب روز اجباری است',
            'ws.required' => 'انتخاب زمان شروع اجباری است',
            'we.required' => 'انتخاب زمان پایان اجباری است',
        ];

    }
}
