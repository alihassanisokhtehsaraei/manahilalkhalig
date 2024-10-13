<?php

namespace Modules\Inspection\Http\Controllers;

use App\Models\InsDoc;
use App\Models\NonReleaseDocument;
use App\Models\Order;
use App\Models\ReleaseDocument;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Modules\Inspection\Http\Requests\NRD\StoreNonReleaseDocumentRequest;
use Modules\Inspection\Http\Requests\NRD\UpdateNonReleaseDocumentRequest;
use Modules\Inspection\Http\Requests\RD\UploadCertificateRequest;
use Modules\Inspection\Http\Requests\RD\UploadDocRequest;
use Modules\Inspection\Http\Requests\RD\UploadLetterRequest;

class NonReleaseDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Order $order)
    {
        return view('inspection::nonReleaseDocs.index', [
            'order' => $order
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Order $order)
    {
        return view('inspection::nonReleaseDocs.create', [
            'order' => $order
        ]);
    }


    public function store(StoreNonReleaseDocumentRequest $request, Order $order)
    {
        NonReleaseDocument::query()->create([
            'coc_id' => $order->coc->id,
            'description' => $request->input('description'),
            'containers_details_not_mentioned' => $request->input('containers_details_not_mentioned'),
            'import_documents_not_mentioned' => $request->input('import_documents_not_mentioned'),
            'number_of_items' => $request->input('number_of_items'),
            'shipment_type' => $request->input('shipment_type'),
            'shipment_details' => $request->input('shipment_details'),
            'remaining_quantity' => $request->input('remaining_quantity'),
            'incoming_quantity' => $request->input('incoming_quantity'),
            'total_quantity' => $request->input('total_quantity'),
            'comments' => $request->input('comments'),
            'issuing_office'=> $order->border,
            "status" => Auth::user()->level === "manager" || Auth::user()->level === "head"  ? "2" : "1",
            'issuance_date'=>Auth::user()->level === 'manager' || Auth::user()->level === "head"  ? now()->format('Y-m-d') : null,
            'document_number'=>Auth::user()->level === 'manager' || Auth::user()->level === "head"  ? $this->getNewDocNumber() : null,
        ]);

        return redirect()->route('nrdocs.index', ['order' => $order]);
    }


    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Order $order,NonReleaseDocument $nonReleaseDocument)
    {
        $readOnly = $this->readOnly($nonReleaseDocument);
        return view('inspection::nonReleaseDocs.edit', ['order' => $order, 'nonReleaseDocument' => $nonReleaseDocument, 'readOnly' => $readOnly]);
    }

    private function readOnly($nonReleaseDocument)
    {
//        if (Auth::user()->sector === "management" || Auth::user()->level === "technical" )
        if ( (Auth::user()->department === "management" || Auth::user()->department === "inspection") and (Auth::user()->level==="manager" || Auth::user()->level === 'head' ))
            return "";
        elseif ($nonReleaseDocument->status == "2")
            return "readonly";
    }

    public function update(UpdateNonReleaseDocumentRequest $request, Order $order, NonReleaseDocument $nonReleaseDocument)
    {
        $nonReleaseDocument->update([
            'coc_id' => $order->coc->id,
            'description' => $request->input('description'),
            'containers_details_not_mentioned' => $request->input('containers_details_not_mentioned'),
            'import_documents_not_mentioned' => $request->input('import_documents_not_mentioned'),
            'number_of_items' => $request->input('number_of_items'),
            'shipment_type' => $request->input('shipment_type'),
            'shipment_details' => $request->input('shipment_details'),
            'remaining_quantity' => $request->input('remaining_quantity'),
            'incoming_quantity' => $request->input('incoming_quantity'),
            'total_quantity' => $request->input('total_quantity'),
            'comments' => $request->input('comments'),
            'status' => Auth::user()->level === "manager" || Auth::user()->level === "head"  ? "2" : "1",
            'issuance_date' => Auth::user()->level === 'manager' && is_null($nonReleaseDocument->issuance_date) || Auth::user()->level === "head" && is_null($nonReleaseDocument->issuance_date) ? now()->format('Y-m-d') :$nonReleaseDocument->issuance_date,
            'issuing_office' => Auth::user()->level === 'manager' && is_null($nonReleaseDocument->issuing_office) || Auth::user()->level === "head" && is_null($nonReleaseDocument->issuing_office) ? $order->border : $nonReleaseDocument->issuing_office,
            'document_number'=> Auth::user()->level === 'manager' && is_null($nonReleaseDocument->document_number) || Auth::user()->level === "head" && is_null($nonReleaseDocument->document_number) ?  $this->getNewDocNumber() :$nonReleaseDocument->document_number,
        ]);

        return redirect()->route('nrdocs.index', ['order' => $order]);
    }


    public function destroy(Order $order, NonReleaseDocument $nonReleaseDocument)
    {
        $nonReleaseDocument->delete();
        return redirect()->route('nrdocs.index', ['order' => $order]);
    }

    public function showUpload(Order $order, NonReleaseDocument $nonReleaseDocument)
    {
        $readOnly = $this->readOnly($nonReleaseDocument);
        $certificateUrl = InsDoc::query()->where(['desc' => 'certificate'],)->where(['category' => 'nrd-'.$nonReleaseDocument->id])->latest()->first()?->url;
        $letterUrl = InsDoc::query()->where(['desc' => 'commitment'],)->where(['category' => 'nrd-'.$nonReleaseDocument->id])->latest()->first()?->url;
        $documentUrls = InsDoc::query()->where(['desc' => 'other'],)->where(['category' => 'nrd-'.$nonReleaseDocument->id])?->get()
            ->map(fn($insDoc)=>$insDoc->url
            );
        return view("inspection::nonReleaseDocs.uploadManager", [
            'order' => $order,
            'nonReleaseDocument' => $nonReleaseDocument,
            'readOnly' => $readOnly,
            'certificateUrl' => $certificateUrl,
            'letterUrl'=>$letterUrl,
            'documentUrls'=>$documentUrls
        ]);
    }

    public function uploadCertificate(Order $order, NonReleaseDocument $nonReleaseDocument, UploadCertificateRequest $request)
    {
        $file = $request->file('certificate');
        $baseFolder = "ipms/inspectionFiles/{$order->id}/nrd/{$nonReleaseDocument->id}/certificate";
        $extension = $file->getClientOriginalExtension();
        $fileName = "certificate_" . now()->format('Y-m-d-h-i') . "." . $extension;
        $fullPath = "{$baseFolder}/{$fileName}";
        Storage::disk('fileManager')->put($fullPath, file_get_contents($file));
        InsDoc::query()->create([
            'title' => $fileName,
            'category' => 'nrd-'.$nonReleaseDocument->id,
            'desc' => 'certificate',
            'status' => "2",
            'url' => $fullPath,
            'userID' => Auth::user()->id,
            'orderID' => $order->id,
            'ip' => $request->ip()
        ]);
        return redirect()->route('nrdocs.showUpload', ['order' => $order, 'nonReleaseDocument' => $nonReleaseDocument])->with('success', 'File deleted successfully.');
    }

    public function uploadLetter(Order $order, NonReleaseDocument $nonReleaseDocument, UploadLetterRequest $request)
    {
        $file = $request->file('letter');
        $baseFolder = "ipms/inspectionFiles/{$order->id}/nrd/{$nonReleaseDocument->id}/letter";
        $extension = $file->getClientOriginalExtension();
        $fileName = "letter_" . now()->format('Y-m-d-h-i') . "." . $extension;
        $fullPath = "{$baseFolder}/{$fileName}";
        Storage::disk('fileManager')->put($fullPath, file_get_contents($file));
        InsDoc::query()->create([
            'title' => $fileName,
            'category' => 'nrd-'.$nonReleaseDocument->id,
            'desc' => 'commitment',
            'status' => "2",
            'url' => $fullPath,
            'userID' => Auth::user()->id,
            'orderID' => $order->id,
            'ip' => $request->ip()
        ]);
        return redirect()->route('nrdocs.showUpload', ['order' => $order, 'nonReleaseDocument' => $nonReleaseDocument])->with('success', 'File deleted successfully.');
    }
    public function uploadDocument(Order $order, NonReleaseDocument $nonReleaseDocument, UploadDocRequest $request)
    {
        $files = $request->file('documents'); // Retrieve the array of files
        $baseFolder = "ipms/inspectionFiles/{$order->id}/nrd/{$nonReleaseDocument->id}/document";
        foreach ($files as $file) {
            $extension = $file->getClientOriginalExtension();
            $fileName = "document_" . now()->format('Y-m-d-h-i') . "_" . uniqid() . "." . $extension;
            $fullPath = "{$baseFolder}/{$fileName}";
            Storage::disk('fileManager')->put($fullPath, file_get_contents($file));
            InsDoc::query()->create([
                'title' => $fileName,
                'category' => 'nrd-'.$nonReleaseDocument->id,
                'desc' => 'other',
                'status' => "2",
                'url' => $fullPath,
                'userID' => Auth::user()->id,
                'orderID' => $order->id,
                'ip' => $request->ip()
            ]);
        }

        return redirect()->route('nrdocs.showUpload', ['order' => $order, 'nonReleaseDocument' => $nonReleaseDocument])
            ->with('success', 'Files uploaded successfully.');
    }
    public function deleteFile(Order $order, NonReleaseDocument $nonReleaseDocument)
    {
        $url = \request()->input('url');
        $insDoc = InsDoc::query()
            ->where('url', $url)
            ->first();
        Storage::disk('fileManager')->delete($url);
        $insDoc->delete();
        return redirect()->route('nrdocs.showUpload', ['order' => $order, 'nonReleaseDocument' => $nonReleaseDocument])->with('success', 'File deleted successfully.');
    }
    private function getNewDocNumber() {
        $maxCertNo = NonReleaseDocument::max('document_number');

        // Initialize the newCertNo
        $newCertNo = 1; // Default to 1 if no certNo exists

        // If maxCertNo exists, increment the numeric part
        if ($maxCertNo) {
            preg_match('/(\d+)$/', $maxCertNo, $matches);
            if (!empty($matches)) {
                $newCertNo = intval($matches[0]) + 1;
            }
        }

        // Format the new certificate number with leading zeros
        return 'MNL/NRD/' . str_pad($newCertNo, 6, '0', STR_PAD_LEFT);
    }

}
