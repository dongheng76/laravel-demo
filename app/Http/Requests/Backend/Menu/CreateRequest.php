<?php

namespace App\Http\Requests\Backend\Menu;

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
            'parent_id' => 'required',
            'name' => 'required|between:2,10',
            'sort' => 'required|between:1,100000|integer'
        ];
    }

    public function messages()
    {
        return [
            'parent_id.required' => '上级菜单不能为空',
            'name.required' => '菜单名不能为空',
            'name.between' => '菜单名在2到10个字符之间',
            'sort.required' => '排序号不能为空',
            'sort.between' => '排序号在1到100000个之间',
            'sort.integer' => '排序号必须为数字'
        ];
    }
}
