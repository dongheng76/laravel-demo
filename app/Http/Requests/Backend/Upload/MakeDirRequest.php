<?php

namespace App\Http\Requests\Backend\Upload;

use App\Http\Requests\Request;
use Illuminate\Filesystem\Filesystem;

class MakeDirRequest extends Request
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
            'name' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'parent_id.required' => '父级不能为空',
            'name.required' => '目录名不能为空',
        ];
    }
}
