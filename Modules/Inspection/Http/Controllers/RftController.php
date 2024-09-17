<?php

namespace Modules\Inspection\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\InsDoc;
use App\Models\Order;
use App\Models\Rft;
use App\Models\RftSamples;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($slug)
    {


        switch ($slug) {
            case 'Completed':
                switch (auth()->user()->department) {
                    case 'management':
                    case 'financial':
                        $data = Rft::select('rfts.id', 'rfts.status', 'customers.fullName', 'customers.cName', 'office', 'lab', 'rfts.created_at')->join('customers', 'customers.id', '=', 'rfts.customer_id')->where('rfts.status', '=', 3)->get();
                        break;
                    case 'laboratory':
                        $data = Rft::select('rfts.id', 'rfts.status', 'customers.fullName', 'customers.cName', 'office', 'lab', 'rfts.created_at')->join('customers', 'customers.id', '=', 'rfts.customer_id')->where('rfts.status', '=', 3)->where('rfts.lab', '=', Auth()->user()->branch)->get();
                        break;
                }
                break;

            default:
                switch (auth()->user()->department) {
                    case 'management':
                    case 'financial':
                        $data = Rft::select('rfts.id', 'rfts.status', 'customers.fullName', 'customers.cName', 'office', 'lab', 'rfts.created_at')->join('customers', 'customers.id', '=', 'rfts.customer_id')->where('rfts.status', '<>', 3)->get();
                        break;
                    case 'laboratory':
                        $data = Rft::select('rfts.id', 'rfts.status', 'customers.fullName', 'customers.cName', 'office', 'lab', 'rfts.created_at')->join('customers', 'customers.id', '=', 'rfts.customer_id')->where('rfts.status', '<>', 3)->where('rfts.lab', '=', Auth()->user()->branch)->get();
                        break;
                }
                break;
        }

        if (request()->ajax()) {
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('customer', function ($row) {
                    return $row->fullName . ' - ' . $row->cName;
                })
                ->addColumn('status', function ($row) {
                    switch ($row->status) {
                        case 1:
                            return '<a style="direction: ltr;text-align: center" class="btn btn-success btn-xs">New</a>';
                        case 2:
                            return '<a style="direction: ltr;text-align: center" class="btn btn-success btn-xs">In Progress</a>';
                        case 3:
                            return '<a style="direction: ltr;text-align: center" class="btn btn-success btn-xs">Completed</a>';
                        default:
                            return '<a style="direction: ltr;text-align: center" class="btn btn-danger btn-xs">Unknown Status</a>'; // Handle unexpected status
                    }


                })
                ->addColumn('actions', function ($row) {
                    $btn = '
                    <a href="/request/showrft/' . $row->id . '" class="btn btn-warning btn-xs">OPEN Profile</a>
                    ';
                    return $btn;
                })
                ->rawColumns(['actions', 'customer', 'status'])
                ->make(true);
        }

        return view('inspection::request.rftindex');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('inspection::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($slug, Request $request): RedirectResponse
    {
        $rft = new Rft();
        $rft->fill($request->all());
        $rft->customer_id = $slug;
        $rft->user_id = Auth()->user()->id;
        $rft->ip = $request->ip();
        $rft->save();

        return redirect(route('rft.samples', $rft->id));
    }


    public function changeStatus($id, Request $request)
    {
        $rft = Rft::find($id);
        $input = $request->all();
        $rft->status = $input['status'];
        $rft->save();
        return redirect(route('request.showrft', $rft->id));

    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('inspection::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $rft = Rft::find($id);
        $customer = Customer::find($rft->customer_id);
        return view('inspection::request.editrft', ['rft' => $rft, 'customer' => $customer]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $rft = Rft::find($id);
        $rft->fill($request->all());
        $rft->save();

        return redirect(route('rft.samples', $rft->id));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

    public function samples($id)
    {
        $data = Rft::find($id);
        $samples = RftSamples::where('rft_id', $id)->get();
        return view('inspection::request.samples', ['rft' => $data, 'samples' => $samples]);
    }

    public function storeSamples($slug, Request $request)
    {
        $request->validate([
            'lab_fee_id' => ['required', 'exists:lab_fees,id'],

        ], [
            'lab_fee_id.required' => 'There is no record for this search...',
            'lab_fee_id.exists' => 'There is no record for this search...',
        ]);
        $rft = new RftSamples();
        $rft->fill($request->all());
        $rft->rft_id = $slug;
        $rft->user_id = Auth()->user()->id;
        $rft->ip = $request->ip();
        $rft->save();

        return back();
    }

    public function destroySample($id)
    {
        $order = RftSamples::find($id)->delete();
        return back();
    }

    public function editSample($id)
    {
        $sample = RftSamples::find($id);
        $rft = Rft::find($sample->rft_id);
        return view('inspection::request.updateSample', ['rft' => $rft, 'sample' => $sample]);
    }

    public function updateSample($slug, Request $request)
    {
        $request->validate([
            'lab_fee_id' => ['required', 'exists:lab_fees,id'],

        ], [
            'lab_fee_id.required' => 'There is no record for this search...',
            'lab_fee_id.exists' => 'There is no record for this search...',
        ]);
        $sample = RftSamples::find($slug);
        $sample->update($request->all());

        return redirect(route('rft.samples', $sample->rft_id));
    }

    public function uploadTestReport(Request $request, Rft $rft)
    {

      $rftSamples=  $rft->rftsample;
        $sampleId = $request->input('sample_id');
        $request->validate(['file-'.$sampleId => ['required', 'mimes:pdf']]);

        $file = $request->file('file-'.$sampleId);
        $baseFolder = "ipms/laboratory/{$rft->id}";
        $extension = $file->getClientOriginalExtension();
        $fileName = "test_report_". $sampleId."_".now()->format('Y-m-d-h-i') . "." . $extension;
        $fullPath = "{$baseFolder}/{$fileName}";
        Storage::disk('fileManager')->put($fullPath, file_get_contents($file));
        InsDoc::query()->create([
            'title' => $fileName,
            'category' => 'rft-' . $rft->id . '-' . $sampleId,
            'desc' => 'sample-' . $sampleId,
            'status' => "2",
            'url' => $fullPath,
            'userID' => Auth::user()->id,
            'ip' => $request->ip()
        ]);
        return redirect()->route('request.showrft', ['id' => $rft->id])->with('success', 'File deleted successfully.');
    }

    public function destroyTestReport(Rft $rft)
    {

        $url = \request()->input('url');

        $insDoc = InsDoc::query()
            ->where('url', $url)
            ->first();

        Storage::disk('fileManager')->delete($url);
        $insDoc->delete();
        return redirect()->route('request.showrft', ['id' => $rft->id])->with('success', 'File deleted successfully.');
    }

}
