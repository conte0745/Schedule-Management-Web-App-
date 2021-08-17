<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopRequest extends FormRequest
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
            'shop' => 'required_without:shop_id|unique:shops',
            'shop_id' => 'required_without:shop|exists:shops,shop',
            //'edit_shop' => 'required',
            //'edit_name' => 'required',
            //'shop.name' => 'required',
            
            ];
    }
    
    public function messages()
    {
        return [
            'shop.unique'  => '入力された店名は既に存在します',
            'shop_id.exists'  => '入力された店名は存在しません',
            'shop.required_without'  => '登録してない店名を入力してください',
            'shop_id.required_without'  => '登録されてある店名を入力してください',
            'edit_shop.required'  => '検索用の店名を入力してください',
            'edit_name.required'  => '表示用の店名を入力してください',
            
        ];
    }
}
