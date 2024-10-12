<?php

namespace Modules\Inspection\Http\Requests\RD;

use Illuminate\Foundation\Http\FormRequest;

class UploadLetterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'letter' => ['required','mimes:jpeg,png,pdf'],
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
