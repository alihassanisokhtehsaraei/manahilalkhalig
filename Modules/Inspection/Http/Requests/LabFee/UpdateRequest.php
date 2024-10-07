<?php

namespace Modules\Inspection\Http\Requests\LabFee;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'english_name' => ['required', 'string', 'max:255'],
            'arabic_name' => ['required', 'string', 'max:255'],
            'fee' => ['required', 'numeric'],
            'category' => ['required', 'string', 'in:Agriculture,Veterinary,Food,QualityControl,Construction'],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
