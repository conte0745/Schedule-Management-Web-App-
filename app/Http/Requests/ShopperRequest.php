<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

class ShopperRequest extends FormRequest
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
            'shop' => ['required',Rule::unique('shops')->ignore($this->id)],
            'shop_name' => 'required',
        ];
    }
    
    public function messages()
    {
        return [
            'shop.unique'  => '入力された店名は既に存在します',
            'shop.required'  => '検索用の店名を入力してください',
            'shop_name.required'  => '表示用の店名を入力してください',
            
        ];
    }
}
