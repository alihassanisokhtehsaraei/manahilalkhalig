<?php

namespace Modules\Inspection\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LabFee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Inspection\Http\Requests\LabFee\StoreRequest;
use Modules\Inspection\Http\Requests\LabFee\UpdateRequest;
use Yajra\DataTables\Facades\DataTables;

class LabFeeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = LabFee::select(['id', 'english_name', 'arabic_name', 'fee', 'category']);

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('actions', function ($row) {
                    $editUrl = route('labfees.edit', $row->id);
                    $deleteUrl = route('labfees.destroy', $row->id);

                    return '
                    <a href="' . $editUrl . '" class="btn btn-primary btn-sm">Edit</a>
                    <button class="btn btn-danger btn-sm delete-button" data-url="' . $deleteUrl . '">Delete</button>
                ';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('inspection::labFee.index');
    }



    public function create()
    {
        return view('inspection::labFee.create'); // Create view
    }


    public function store(StoreRequest $request)
    {
        LabFee::create($request->validated());
        return redirect()->route('labfees.index')->with('success', 'Lab Fee created successfully.');
    }


    public function edit(LabFee $labFee)
    {
        return view('inspection::labFee.edit',['labFee'=>$labFee]);
    }

    public function update(UpdateRequest $request,LabFee $labFee)
    {

        $labFee->update($request->validated());
        return redirect()->route('labfees.index')->with('success', 'Lab Fee updated successfully.');
    }

    public function destroy(LabFee $labFee)
    {
        $labFee->delete();
        return response()->json(['message' => 'Lab Fee deleted successfully.']);
    }

    public function search(Request $request)
    {
        $query = $request->get('query');

        // Search the LabFee model by English name
        $labFees = LabFee::where('english_name', 'LIKE', "%{$query}%")->get(['id', 'english_name', 'arabic_name', 'fee', 'category']);

        // Return the data as JSON
        return response()->json($labFees);
    }
}
