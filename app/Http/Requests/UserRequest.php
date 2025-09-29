<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;
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
     * @return array<string, mixed>
     */
   public function rules(): array
{
    $userId = Auth::id() ?? 'NULL'; // 若未登录，给一个无效值（实际步骤2已拦截）

    return [
        'name' => 'required|between:3,25|regex:/^[A-Za-z0-9\-_]+$/|unique:users,name,' . $userId,
        'email' => 'required|email',
        'introduction' => 'max:80',
        'avatar' =>'mimes:jpeg,bmp,png,gif|dimensions:min_width=200,min_height=200',
    ];
}

    public function messages()
    {
        return [
            'avatar.mimes' => '头像必须是jpeg、bmp、png、gif格式的图片',
            'avatar.dimensions' => '头像的清晰度不够，宽和高需要200px以上',
            'name.required' => '用户名不能为空',
            'name.between' => '用户名必须介于3 - 25个字符之间',
            'name.regex' => '用户名只支持英文、数字、横杠和下划线。',
            'name.unique' => '用户名已被占用，请重新填写。',
            'email.required' => '邮箱不能为空',
            'email.email' => '邮箱格式不正确',
            'introduction.max' => '个人简介最多80个字符',
        ];
    }
}
