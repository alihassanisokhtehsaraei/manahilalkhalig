<?php

namespace Modules\Inspection\Http\Requests\RD;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReleaseDocumentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $order = $this->route('order');
        $currentDocument = $this->route('releaseDocument'); // Assuming 'rdoc' is the route parameter for the current release document

        // Sum of previous incoming quantities, excluding the current document's quantity
        $sumPreviousIncoming = $order->releaseDocuments
                ->where('id', '!=', $currentDocument->id) // Exclude the current document from the sum
                ->sum('incoming_quantity') + $order->nonReleaseDocuments->sum('incoming_quantity');

        // Calculate the maximum allowable incoming quantity
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
