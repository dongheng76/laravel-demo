<?php

namespace App\Http\Requests\Backend\Office;

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
            'name' => "required|between:2,16",
            'area_id' => "required",
            'type' => 'required',
            'sort' => "required",
            'code' => "required"
        ];
    }

    public function messages()
    {
        return [
            'area_id.required'      => '所属区域必须要选择',
            'name.required'=> '机构名必须填写',
            'name.between'=> '机构名必须是2-16个字符',
            'sort.required'=> '排序号必须填写',
            'type.required' => '机构类型必须选择',
            'code.required' => '邮编必须填写'
        ];
    }
}
