<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalendarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return True;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'calendar.date' => 'required | date',
            'calendar.start_time' => 'required ',
            'calendar.finish_time' => 'required | after:calendar.start_time',
        ];
    }
    
    public function messages()
    {
        return [
            'calendar.date.required' => '勤務日を入力してください',
            'calendar.date.date' => '勤務日を入力してください',
            'calendar.start_time.required'  => '勤務開始時刻を入力してください',
            'calendar.finish_time.required'  => '勤務終了時刻を入力してください',
            'calendar.finish_time.after'  => '開始時刻より終了時刻のほうが早いです',
        ];
    }
}
