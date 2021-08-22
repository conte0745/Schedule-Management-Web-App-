<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CalendarTime;
use Carbon\Carbon;
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
        $checkTime = function($attribute, $value, $fail) {
            $input = $this->calendar;
            $flag = 0;
            $startDate = Carbon::parse($input['date']);
            $finishDate = Carbon::parse($input['date_fin']);
            
            if($finishDate->diffInDays($startDate) > 1) $flag = 1;
            if($startDate->eq($finishDate)) if((Carbon::parse($input['start_time']))->gte(Carbon::parse($input['finish_time']))) $flag = 2;
            
            if($flag == 1) $fail('勤務開始日付勤務と終了日付は1日以内で入力してください');
            if($flag == 2) $fail('勤務開始時刻よりも勤務終了時刻のほうが早いです');
        };
        
        return[
            'calendar.date' => ['required', 'date'],
            'calendar.date_fin' => ['required', 'date', 'after_or_equal:calendar.date', $checkTime],
            'calendar.start_time' => ['required', $checkTime],
            'calendar.finish_time' => ['required', $checkTime],
            
        ];
    }
    
    public function messages()
    {
        return [
            'calendar.date.required' => '勤務開始日を入力してください',
            'calendar.date_fin.required' => '勤務終了日を入力してください',
            'calendar.date.date' => '勤務日を入力してください',
            'calendar.date_fin.date' => '勤務日を入力してください',
            'calendar.start_time.required'  => '勤務開始時刻を入力してください',
            'calendar.finish_time.required'  => '勤務終了時刻を入力してください',
            'calendar.date_fin.after'  => '値が不正です',
        ];
    }
}
