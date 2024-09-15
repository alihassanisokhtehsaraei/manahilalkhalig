<?php

namespace Modules\Inspection\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LabFee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LabFeeController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('query');

        // Search the LabFee model by English name
        $labFees = LabFee::where('english_name', 'LIKE', "%{$query}%")->get(['id', 'english_name', 'arabic_name', 'fee', 'category']);

        // Return the data as JSON
        return response()->json($labFees);
    }
}
