<?php

namespace Modules\Inspection\Http\Requests\RD;

use Illuminate\Foundation\Http\FormRequest;

class StoreReleaseDocumentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $order = $this->route('order'); // Get the order from route parameters
        $sumPreviousIncoming = $order->releaseDocuments->sum('incoming_quantity') + $order->nonReleaseDocuments->sum('incoming_quantity');
        $maxIncomingQuantity = $order->container - $sumPreviousIncoming;

        return [
            'incoming_quantity' => 'required|numeric|min:1|max:' . $maxIncomingQuantity, // Ensure incoming quantity does not exceed the remaining quantity
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
