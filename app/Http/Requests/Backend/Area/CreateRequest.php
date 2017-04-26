<?php

namespace App\Http\Requests\Backend\Area;

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
            'parent_id' => "required",
            'parent_ids' => "required",
            'name' => 'required|between:2,16',
            'sort' => "required",
            'code' => "required",
            'type' => "required"
        ];
    }

    public function messages()
    {
        return [
            'parent_id.required' => '父亲id必须填写',
            'parent_ids.required'      => '父亲id集合必须要填写',
            'name.required'=> '区域名必须填写',
            'name.between'=> '区域名必须是2-16个字符',
            'sort.required'=> '排序号必须填写',
            'code.required' => '邮编必须选择',
            'type.required' => '区域类型必须填写'
        ];
    }
}
