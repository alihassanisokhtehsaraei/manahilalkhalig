<?php

namespace Modules\Inspection\Http\Controllers;

use App\Models\Inspector;
use App\Models\Order;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller;
use App\Models\InsDoc;

class InsDocController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('inspection::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request, $id)
    {
        //$doc = new InsDoc();
        //$doc->title = 'other document';
    }

    public function storeins(Request $request, $orderId)
    {
        // Validate file inputs
        $validator = Validator::make($request->all(), [
            'ir.*' => 'mimes:pdf,jpg,jpeg,png,gif,doc,docx,xls,xlsx,ppt,pptx|max:100000', // Maximum size: 100MB
            'vr.*' => 'mimes:pdf,jpeg,png,gif,doc,docx,xls,xlsx,ppt,pptx|max:100000', // Maximum size: 100MB
            'sf.*' => 'mimes:pdf,jpeg,png,gif,doc,docx,xls,xlsx,ppt,pptx|max:100000', // Maximum size: 100MB
            'photo.*' => 'mimes:pdf,jpeg,png,gif,doc,docx,xls,xlsx,ppt,pptx|max:100000', // Maximum size: 100MB
            'video.*' => 'max:100000', // Maximum size: 100MB
            'sr.*' => 'mimes:pdf,jpeg,png,gif,doc,docx,xls,xlsx,ppt,pptx|max:100000', // Maximum size: 100MB
            'pl.*' => 'mimes:pdf,jpeg,png,gif,doc,docx,xls,xlsx,ppt,pptx|max:100000', // Maximum size: 100MB
            'contract.*' => 'mimes:pdf,jpeg,png,gif,doc,docx,xls,xlsx,ppt,pptx|max:100000', // Maximum size: 100MB
            'cert.*' => 'mimes:pdf,jpeg,png,gif,doc,docx,xls,xlsx,ppt,pptx|max:100000', // Maximum size: 100MB
        ]);

        if ($validator->fails()) {
            // Handle validation errors
            // ...
        }

        // Create folder if not available
        $folderName = $orderId;
        Storage::disk('fileManager')->makeDirectory("ipms/inspectionFiles/{$folderName}");

        $irFiles = $request->file('ir');
        $vrFiles = $request->file('vr');
        $sfFiles = $request->file('sf');
        $photoFiles = $request->file('photo');
        $videoFiles = $request->file('video');
        $srFiles = $request->file('sr');
        $plFiles = $request->file('pl');
        $contractFiles = $request->file('contract');
        $certFiles = $request->file('cert');

        $this->uploadFiles($irFiles, 'Inspection Report', 'ir', $folderName, $orderId, $request);
        $this->uploadFiles($vrFiles, 'Visit Report', 'vr', $folderName, $orderId, $request);
        $this->uploadFiles($sfFiles, 'Sampling Form', 'sf', $folderName, $orderId, $request);
        $this->uploadFiles($photoFiles, 'Photo', 'photo', $folderName, $orderId, $request);
        $this->uploadFiles($videoFiles, 'Video', 'video', $folderName, $orderId, $request);
        $this->uploadFiles($srFiles, 'Sample Receipt', 'sr', $folderName, $orderId, $request);
        $this->uploadFiles($plFiles, 'Persian Letter', 'pl', $folderName, $orderId, $request);
        $this->uploadFiles($contractFiles, 'Contract', 'contract', $folderName, $orderId, $request);
        $this->uploadFiles($certFiles, 'Certificate', 'cert', $folderName, $orderId, $request);

        // Redirect or return a response
        return back();
    }

    private function uploadFiles($files, $description, $inputName, $folderName, $orderId, $request) {
        if (!empty($files)) {
            foreach ($files as $file) {
                // Get original file name
                $originalName = $file->getClientOriginalName();

                // Check if the file already exists in the storage
                $fileNameWithoutExtension = pathinfo($originalName, PATHINFO_FILENAME);
                $fileExtension = pathinfo($originalName, PATHINFO_EXTENSION);
                $counter = 1;
                $newName = $originalName;

                while (Storage::disk('fileManager')->exists("ipms/inspectionFiles/{$folderName}/{$newName}")) {
                    $newName = $fileNameWithoutExtension . '_' . $counter . '.' . $fileExtension;
                    $counter++;
                }

                // Store file into fileManager with the new name
                Storage::disk('fileManager')->putFileAs("ipms/inspectionFiles/{$folderName}", $file, $newName);

                $doc = new InsDoc();
                $doc->title = $newName;
                $doc->category = 'inspection';
                $doc->userID = Auth()->user()->id;
                $doc->orderID = $orderId;
                $doc->status = (Auth()->user()->level == 'head' || Auth()->user()->level == 'manager') ? 2 : 0;
                $doc->reviewerID = (Auth()->user()->level == 'head' || Auth()->user()->level == 'manager') ? Auth()->user()->id : null;
                $doc->reviewTime = (Auth()->user()->level == 'head' || Auth()->user()->level == 'manager') ? date('Y-m-d H:i:s') : null;
                $doc->url = "ipms/inspectionFiles/{$folderName}/{$newName}";
                $doc->ip = $request->ip();
                $doc->desc = $description;
                $doc->save();
            }
        }
    }

    public function storelab(Request $request, $orderId)
    {
        // Validate file inputs
        $validator = Validator::make($request->all(), [
            'tr.*' => 'required|mimes:pdf,jpeg,png,gif,doc,docx,xls,xlsx,ppt,pptx|max:100000', // Maximum size: 100MB
            'trv.*' => 'required|mimes:pdf,jpeg,png,gif,doc,docx,xls,xlsx,ppt,pptx|max:100000', // Maximum size: 100MB
            'trl.*' => 'required|mimes:pdf,jpeg,png,gif,doc,docx,xls,xlsx,ppt,pptx|max:100000', // Maximum size: 100MB
            'iso17025.*' => 'required|mimes:pdf,jpeg,png,gif,doc,docx,xls,xlsx,ppt,pptx|max:100000', // Maximum size: 100MB
        ]);

        if ($validator->fails()) {
            // Handle validation errors
            // ...
        }

        // Create folder if not available
        $folderName = $orderId;
        Storage::disk('fileManager')->makeDirectory("ipms/inspectionFiles/{$folderName}");

        $fileInputs = ['tr', 'trv', 'trl', 'iso17025'];

        foreach ($fileInputs as $input) {
            if ($request->hasFile($input)) {
                $files = $request->file($input);

                foreach ($files as $file) {
                    // Get original file name
                    $originalName = $file->getClientOriginalName();

                    // Check if the file already exists in the storage
                    $fileNameWithoutExtension = pathinfo($originalName, PATHINFO_FILENAME);
                    $fileExtension = pathinfo($originalName, PATHINFO_EXTENSION);
                    $counter = 1;
                    $newName = $originalName;

                    while (Storage::disk('fileManager')->exists("ipms/inspectionFiles/{$folderName}/{$newName}")) {
                        $newName = $fileNameWithoutExtension . '_' . $counter . '.' . $fileExtension;
                        $counter++;
                    }

                    // Store file into fileManager with the new name
                    Storage::disk('fileManager')->putFileAs("ipms/inspectionFiles/{$folderName}", $file, $newName);

                    $doc = new InsDoc();
                    $doc->title = $newName;
                    $doc->category = 'laboratory';
                    $doc->userID = Auth()->user()->id;
                    $doc->orderID = $orderId;
                    $doc->status = (Auth()->user()->level == 'head' || Auth()->user()->level == 'manager') ? 2 : 0;
                    $doc->reviewerID = (Auth()->user()->level == 'head' || Auth()->user()->level == 'manager') ? Auth()->user()->id : null;
                    $doc->reviewTime = (Auth()->user()->level == 'head' || Auth()->user()->level == 'manager') ? date('Y-m-d H:i:s') : null;
                    $doc->url = "ipms/inspectionFiles/{$folderName}/{$newName}";
                    $doc->ip = $request->ip();

                    // Set description based on file input
                    switch ($input) {
                        case 'tr':
                            $doc->desc = 'Test Report';
                            break;
                        case 'trv':
                            $doc->desc = 'TR Verification';
                            break;
                        case 'trl':
                            $doc->desc = 'Test Request Letter';
                            break;
                        case 'iso17025':
                            $doc->desc = 'ISO 17025 Cert.';
                            break;
                        default:
                            $doc->desc = '';
                    }

                    $doc->save();
                }
            }
        }

        // Redirect or return a response
        return back();
    }

    public function storeother(Request $request, $orderId)
    {
        // Validate file inputs
        $validator = Validator::make($request->all(), [
            'other.*' => 'required|mimes:pdf,jpeg,png,gif,doc,docx,xls,xlsx,ppt,pptx|max:100000' // Maximum size: 100MB
        ]);

        if ($validator->fails()) {
            // Handle validation errors
            // ...
        }

        // Create folder if not available
        $folderName = $orderId;
        Storage::disk('fileManager')->makeDirectory("ipms/inspectionFiles/{$folderName}");

        if ($request->hasFile('other')) {
            $files = $request->file('other');

            foreach ($files as $file) {
                // Get original file name
                $originalName = $file->getClientOriginalName();

                // Check if the file already exists in the storage
                $fileNameWithoutExtension = pathinfo($originalName, PATHINFO_FILENAME);
                $fileExtension = pathinfo($originalName, PATHINFO_EXTENSION);
                $counter = 1;
                $newName = $originalName;

                while (Storage::disk('fileManager')->exists("ipms/inspectionFiles/{$folderName}/{$newName}")) {
                    $newName = $fileNameWithoutExtension . '_' . $counter . '.' . $fileExtension;
                    $counter++;
                }

                // Store file into fileManager with the new name
                Storage::disk('fileManager')->putFileAs("ipms/inspectionFiles/{$folderName}", $file, $newName);

                $doc = new InsDoc();
                $doc->title = $newName;
                $doc->category = 'other';
                $doc->userID = Auth()->user()->id;
                $doc->orderID = $orderId;
                $doc->status = (Auth()->user()->level == 'head' or Auth()->user()->level == 'manager') ? 2 : 0;
                $doc->reviewerID =(Auth()->user()->level == 'head' or Auth()->user()->level == 'manager') ? Auth()->user()->id : null;
                $doc->reviewTime =(Auth()->user()->level == 'head' or Auth()->user()->level == 'manager') ? date('Y-m-d H:i:s') : null;
                $doc->url = "ipms/inspectionFiles/{$folderName}/{$newName}";
                $doc->ip = $request->ip();
                $doc->save();
            }
        }

        // Redirect or return a response
        return back();
    }

    public function storeclient(Request $request, $orderId)
    {
        // Validate file inputs
        $validator = Validator::make($request->all(), [
            'pi.*' => 'required|mimes:pdf,jpeg,png,gif,doc,docx,xls,xlsx,ppt,pptx|max:100000', // Maximum size: 100MB
            'ci.*' => 'required|mimes:pdf,jpeg,png,gif,doc,docx,xls,xlsx,ppt,pptx|max:100000', // Maximum size: 100MB
            'pl.*' => 'required|mimes:pdf,jpeg,png,gif,doc,docx,xls,xlsx,ppt,pptx|max:100000', // Maximum size: 100MB
            'og.*' => 'required|mimes:pdf,jpeg,png,gif,doc,docx,xls,xlsx,ppt,pptx|max:100000', // Maximum size: 100MB
            'wr.*' => 'required|mimes:pdf,jpeg,png,gif,doc,docx,xls,xlsx,ppt,pptx|max:100000', // Maximum size: 100MB
            'bl.*' => 'required|mimes:pdf,jpeg,png,gif,doc,docx,xls,xlsx,ppt,pptx|max:100000', // Maximum size: 100MB
            'co.*' => 'required|mimes:pdf,jpeg,png,gif,doc,docx,xls,xlsx,ppt,pptx|max:100000', // Maximum size: 100MB
            'in.*' => 'required|mimes:pdf,jpeg,png,gif,doc,docx,xls,xlsx,ppt,pptx|max:100000', // Maximum size: 100MB
            'cot.*' => 'required|mimes:pdf,jpeg,png,gif,doc,docx,xls,xlsx,ppt,pptx|max:100000', // Maximum size: 100MB
            'md.*' => 'required|mimes:pdf,jpeg,png,gif,doc,docx,xls,xlsx,ppt,pptx|max:100000', // Maximum size: 100MB
            'rl.*' => 'required|mimes:pdf,jpeg,png,gif,doc,docx,xls,xlsx,ppt,pptx|max:100000', // Maximum size: 100MB
        ]);

        if ($validator->fails()) {
            // Handle validation errors
            // ...
        }

        // Create folder if not available
        $folderName = $orderId;
        Storage::disk('fileManager')->makeDirectory("ipms/inspectionFiles/{$folderName}");

        $fileInputs = ['pi', 'ci', 'pl', 'og', 'wr', 'bl', 'co', 'in', 'cot', 'md', 'rl'];

        foreach ($fileInputs as $input) {
            if ($request->hasFile($input)) {
                $files = $request->file($input);

                foreach ($files as $file) {
                    // Get original file name
                    $originalName = $file->getClientOriginalName();

                    // Check if the file already exists in the storage
                    $fileNameWithoutExtension = pathinfo($originalName, PATHINFO_FILENAME);
                    $fileExtension = pathinfo($originalName, PATHINFO_EXTENSION);
                    $counter = 1;
                    $newName = $originalName;

                    while (Storage::disk('fileManager')->exists("ipms/inspectionFiles/{$folderName}/{$newName}")) {
                        $newName = $fileNameWithoutExtension . '_' . $counter . '.' . $fileExtension;
                        $counter++;
                    }

                    // Store file into fileManager with the new name
                    Storage::disk('fileManager')->putFileAs("ipms/inspectionFiles/{$folderName}", $file, $newName);

                    $doc = new InsDoc();
                    $doc->title = $newName;
                    $doc->category = 'Client';
                    $doc->userID = Auth()->user()->id;
                    $doc->orderID = $orderId;
                    $doc->status = (Auth()->user()->level == 'head' || Auth()->user()->level == 'manager') ? 2 : 0;
                    $doc->reviewerID = (Auth()->user()->level == 'head' || Auth()->user()->level == 'manager') ? Auth()->user()->id : null;
                    $doc->reviewTime = (Auth()->user()->level == 'head' || Auth()->user()->level == 'manager') ? date('Y-m-d H:i:s') : null;
                    $doc->url = "ipms/inspectionFiles/{$folderName}/{$newName}";
                    $doc->ip = $request->ip();


                    $fileInputs = ['pi', 'ci', 'pl', 'og', 'wr', 'bl', 'co', 'in', 'cot', 'md', 'rl'];

                    // Set description based on file input
                    switch ($input) {
                        case 'pi':
                            $doc->desc = 'Proforma Invoice';
                            break;
                        case 'ci':
                            $doc->desc = 'Commercial Invoice';
                            break;
                        case 'pl':
                            $doc->desc = 'Packing List';
                            break;
                        case 'og':
                            $doc->desc = 'Order Registration';
                            break;
                        case 'wr':
                            $doc->desc = 'Warehouse Receipt';
                            break;
                        case 'bl':
                            $doc->desc = 'BL';
                            break;
                        case 'co':
                            $doc->desc = 'Cert of Origin';
                            break;
                        case 'in':
                            $doc->desc = 'Insurance Cert';
                            break;
                        case 'cot':
                            $doc->desc = 'Cottage';
                            break;
                        case 'md':
                            $doc->desc = 'MD / SD';
                            break;
                        case 'rl':
                            $doc->desc = 'Commitment letter';
                            break;
                        default:
                            $doc->desc = '';
                    }

                    $doc->save();
                }
            }
        }

        // Redirect or return a response
        return back();
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id,$category=null)
    {
        $order = Order::find($id);
        $docs = match ($category) {
            'inspection' => InsDoc::with(['uploader', 'reviewer'])->where('orderID', $id)->where('category', 'inspection')->get(),
            'laboratory' => InsDoc::with(['uploader', 'reviewer'])->where('orderID', $id)->where('category', 'laboratory')->get(),
            'other' => InsDoc::with(['uploader', 'reviewer'])->where('orderID', $id)->where('category', 'other')->get(),
            'all' => InsDoc::with(['uploader', 'reviewer'])->where('orderID', $id)->get(),
            default => InsDoc::with(['uploader', 'reviewer'])->where('orderID', $id)->where('category', 'client')->get(),
        };;
        return view('inspection::inspection.InsDoc', ['order' => $order, 'docs' => $docs]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('inspection::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $insdoc = InsDoc::find($id);

        // Retrieve the necessary values before deleting the record
        $orderID = $insdoc->orderID;
        $url = $insdoc->url;
        $title = $insdoc->title;

        // Delete the record from the database
        $insdoc->delete();

        // Create folder if not available
        $folderName = "deletedFiles";
        $folderPath = "ipms/inspectionFiles/{$orderID}/{$folderName}";
        Storage::disk('fileManager')->makeDirectory($folderPath);

        // Move the file to the destination folder
        $destinationPath = "{$folderPath}/{$title}";
        Storage::disk('fileManager')->move($url, $destinationPath);

        return back();
    }

    public function changeStatus($id, $newStatus)
    {
        $doc = InsDoc::find($id);
        $doc->status = $newStatus;
        $doc->reviewerID = Auth()->user()->id;
        $doc->reviewTime = date('Y-m-d H:i:s');
        $doc->save();
        return back();
    }
}
