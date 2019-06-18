<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class passRequest extends Request
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
            'passwordold' => 'required|min:6',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password',
        ];
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(){
        return [
            'required'=>':attribute không được để trống',
            'min'=>':attribute không được nhỏ hơn :min ký tự',
            
        ];
    }
    /**
     * Get attributes
     *
     * @return array
     */
    public function attributes(){
        return [
            'passwordold'=>'Mật khẩu hiện tại',
            'password'=>'mật khẩu mới',
            'password_confirmation'=>'Nhập lại mật khẩu'
        ];
    }
}
