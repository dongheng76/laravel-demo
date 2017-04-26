<?php

namespace App\Http\Requests\Backend\Dict;

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
            'value' => 'required|max:8',
            'label' => 'required|max:20',
            'type' => 'required|max:20',
            'sort' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'value.required' => '字典value不能为空',
            'value.max' => '字典value的长度不能大于8',
            'label.required' => '字典label不能为空',
            'label.max' => '字典label的长度不能大于20',
            'type.required' => '字典type不能为空',
            'type.max' => '字典type的长度不能大于20',
            'sort.required' => '字典排序不能为空'
        ];
    }
}
