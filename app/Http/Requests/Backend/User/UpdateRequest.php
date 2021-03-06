<?php

namespace App\Http\Requests\Backend\User;

use App\Http\Requests\Request;

class UpdateRequest extends Request
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
            'name' => "required|min:2",
            'password' => 'between:8,30',
            'office_id' => "required",
            'no' => "required",
            'user_type' => "required",
            'role' => "required"
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '姓名必须填写',
            'name.min'      => '姓名最小不能小于两字符',
            'password.between'=> '请填写8-30位的密码',
            'office_id.required' => '机构必须选择',
            'no.required' => '工号必须填写',
            'user_type.required' => '用户类型必须选择',
            'role.required' => '角色类型必须选择'
        ];
    }
}
