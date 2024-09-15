<?php

namespace Modules\Inspection\Http\Requests\Rd;

use Illuminate\Foundation\Http\FormRequest;

class UploadDocRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'documents.*' => ['required', 'mimes:jpeg,png,pdf'],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
