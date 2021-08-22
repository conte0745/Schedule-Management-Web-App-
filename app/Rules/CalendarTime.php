<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CalendarTime implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        
        $input = $this->calendar;
            $flag = 0;
            $startDate = Carbon::parse($input['date']);
            $finishDate = Carbon::parse($input['date_fin']);
            
            if($finishDate->diffInDays($startDate) > 1) $flag = 1;
            if($startDate->eq($finishDate)) if((Carbon::parse($input['start_time']))->gt(Carbon::parse($input['finish_time']))) $flag = 2;
            
            if($flag == 1) $fail('勤務開始日付勤務と終了日付は1日以内で入力してください');
            if($flag == 2) $fail('勤務開始時刻よりも勤務終了時刻のほうが早いです');
            if($flag == 0) return true;
        dd('attribute '.$attribute.' '.$value);
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
