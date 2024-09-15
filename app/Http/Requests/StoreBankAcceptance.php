<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBankAcceptance extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'recipientDept' => 'required|string|max:255',
            'recipient' => 'required|string|max:255',
            'letText' => 'required|string',
            'letRef' => 'required|string|max:255',
            'user' => 'required|string|max:255',
            'branch' => 'required|string|max:255',
            'signee' => 'required|string|max:255',
            'from' => 'required|string|max:255',
            'type' => 'required|integer|max:11'
        ];
    }
}
