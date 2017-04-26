<?php

namespace App\Http\Requests\Backend\Role;

use App\Http\Requests\Request;

class CreateRequest extends Request
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
            'office_id' => 'required',
            'name' => 'required|between:2,10',
            'enname' => 'required|between:2,20',
            'data_scope' => 'required',
            'is_sys' => 'required',
            'menuIds' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'office_id.required' => '机构id不能为空',
            'name.required' => '角色名不能为空',
            'name.between' => '角色名在2到10个字符之间',
            'enname.required' => '角色英文名不能为空',
            'enname.between' => '角色英文名在2到20个字符之间',
            'data_scope.required' => '角色权限范围不能为空',
            'is_sys.required' => '是否是系统角色不能为空',
            'menuIds.required' => '角色菜单id不能为空'
        ];
    }
}
