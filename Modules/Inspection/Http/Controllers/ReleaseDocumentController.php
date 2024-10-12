<?php

namespace Modules\Inspection\Http\Controllers;

use App\Models\InsDoc;
use App\Models\Order;
use App\Models\ReleaseDocument;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Modules\Inspection\Http\Requests\RD\StoreReleaseDocumentRequest;
use Modules\Inspection\Http\Requests\RD\UpdateReleaseDocumentRequest;
use Modules\Inspection\Http\Requests\Rd\UploadCertificateRequest;
use Modules\Inspection\Http\Requests\Rd\UploadDocRequest;
use Modules\Inspection\Http\Requests\Rd\UploadLetterRequest;

class ReleaseDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Order $order)
    {
        return view('inspection::releaseDocs.index', [
            'order' => $order
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Order $order)
    {
        return view('inspection::releaseDocs.create', [
            'order' => $order
        ]);
    }


    public function store(StoreReleaseDocumentRequest $request, Order $order)
    {
        ReleaseDocument::query()->create([
            'coc_id' => $order->coc->id,
            'following_checks' => $request->input('following_checks'),
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
            "status" => Auth::user()->sector === "management" || Auth::user()->level === "technical" ? "2" : "1",
            'issuance_date'=>Auth::user()->sector === 'management' || Auth::user()->level === "technical" ? now()->format('Y-m-d') : null,
            'document_number'=>Auth::user()->sector === 'management' || Auth::user()->level === "technical" ? $this->getNewDocNumber() : null,
        ]);

        return redirect()->route('rdocs.index', ['order' => $order]);
    }


    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Order $order, ReleaseDocument $releaseDocument)
    {
        $readOnly = $this->readOnly($releaseDocument);
        return view('inspection::releaseDocs.edit', ['order' => $order, 'releaseDocument' => $releaseDocument, 'readOnly' => $readOnly]);
    }

    private function readOnly($releaseDocument)
    {
//        if (Auth::user()->sector === "management" or Auth::user()->level === 'technical')
        if ( (Auth::user()->department === "management" || Auth::user()->department === "inspection") and (Auth::user()->level==="manager" || Auth::user()->level === 'head' ))
            return "";
        elseif ($releaseDocument->status == "2")
            return "readonly";
    }

    public function update(UpdateReleaseDocumentRequest $request, Order $order, ReleaseDocument $releaseDocument)
    {

        $releaseDocument->update([
            'following_checks' => $request->input('following_checks'),
            'containers_details_not_mentioned' => $request->input('containers_details_not_mentioned'),
            'import_documents_not_mentioned' => $request->input('import_documents_not_mentioned'),
            'number_of_items' => $request->input('number_of_items'),
            'shipment_type' => $request->input('shipment_type'),
            'shipment_details' => $request->input('shipment_details'),
            'remaining_quantity' => $request->input('remaining_quantity'),
            'incoming_quantity' => $request->input('incoming_quantity'),
            'total_quantity' => $request->input('total_quantity'),
            'comments' => $request->input('comments'),
            'status' => Auth::user()->sector === "management" || Auth::user()->level === 'technical' ? "2" : "1",
            'issuance_date'=>Auth::user()->sector === 'management' && is_null($releaseDocument->issuance_date) || Auth::user()->level === "technical" && is_null($releaseDocument->issuance_date) ? now()->format('Y-m-d') : $releaseDocument->issuance_date,
            'issuing_office'=>Auth::user()->sector === 'management' && is_null($releaseDocument->issuing_office) || Auth::user()->level === "technical" && is_null($releaseDocument->issuing_office) ? $order->border :$releaseDocument->issuing_office,
            'document_number'=>Auth::user()->sector === 'management' && is_null($releaseDocument->document_number) || Auth::user()->level === "technical" && is_null($releaseDocument->document_number) ? $this->getNewDocNumber() :$releaseDocument->document_number,
        ]);

        return redirect()->route('rdocs.index', ['order' => $order]);
    }


    public function destroy(Order $order, ReleaseDocument $releaseDocument)
    {
        $releaseDocument->delete();
        return redirect()->route('rdocs.index', ['order' => $order]);
    }

    public function showUpload(Order $order, ReleaseDocument $releaseDocument)
    {
        $readOnly = $this->readOnly($releaseDocument);
        $certificateUrl = InsDoc::query()->where(['desc' => 'certificate'],)->where(['category' => 'rd-' . $releaseDocument->id])->latest()->first()?->url;
        $letterUrl = InsDoc::query()->where(['desc' => 'commitment'],)->where(['category' => 'rd-' . $releaseDocument->id])->latest()->first()?->url;
        $documentUrls = InsDoc::query()->where(['desc' => 'other'],)->where(['category' => 'rd-' . $releaseDocument->id])?->get()
            ->map(fn($insDoc) => $insDoc->url
            );
        return view("inspection::releaseDocs.uploadManager", [
            'order' => $order,
            'releaseDocument' => $releaseDocument,
            'readOnly' => $readOnly,
            'certificateUrl' => $certificateUrl,
            'letterUrl' => $letterUrl,
            'documentUrls' => $documentUrls
        ]);
    }

    public function uploadCertificate(Order $order, ReleaseDocument $releaseDocument, UploadCertificateRequest $request)
    {
        $file = $request->file('certificate');
        $baseFolder = "ipms/inspectionFiles/{$order->id}/rd/{$releaseDocument->id}/certificate";
        $extension = $file->getClientOriginalExtension();
        $fileName = "certificate_" . now()->format('Y-m-d-h-i') . "." . $extension;
        $fullPath = "{$baseFolder}/{$fileName}";
        Storage::disk('fileManager')->put($fullPath, file_get_contents($file));
        InsDoc::query()->create([
            'title' => $fileName,
            'category' => 'rd-' . $releaseDocument->id,
            'desc' => 'certificate',
            'status' => "2",
            'url' => $fullPath,
            'userID' => Auth::user()->id,
            'orderID' => $order->id,
            'ip' => $request->ip()
        ]);
        return redirect()->route('rdocs.showUpload', ['order' => $order, 'releaseDocument' => $releaseDocument])->with('success', 'File deleted successfully.');
    }

    public function uploadLetter(Order $order, ReleaseDocument $releaseDocument, UploadLetterRequest $request)
    {
        $file = $request->file('letter');
        $baseFolder = "ipms/inspectionFiles/{$order->id}/rd/{$releaseDocument->id}/letter";
        $extension = $file->getClientOriginalExtension();
        $fileName = "letter_" . now()->format('Y-m-d-h-i') . "." . $extension;
        $fullPath = "{$baseFolder}/{$fileName}";
        Storage::disk('fileManager')->put($fullPath, file_get_contents($file));
        InsDoc::query()->create([
            'title' => $fileName,
            'category' => 'rd-' . $releaseDocument->id,
            'desc' => 'commitment',
            'status' => "2",
            'url' => $fullPath,
            'userID' => Auth::user()->id,
            'orderID' => $order->id,
            'ip' => $request->ip()
        ]);
        return redirect()->route('rdocs.showUpload', ['order' => $order, 'releaseDocument' => $releaseDocument])->with('success', 'File deleted successfully.');
    }

    public function uploadDocument(Order $order, ReleaseDocument $releaseDocument, UploadDocRequest $request)
    {
        $files = $request->file('documents'); // Retrieve the array of files
        $baseFolder = "ipms/inspectionFiles/{$order->id}/rd/{$releaseDocument->id}/document";
        foreach ($files as $file) {
            $extension = $file->getClientOriginalExtension();
            $fileName = "document_" . now()->format('Y-m-d-h-i') . "_" . uniqid() . "." . $extension;
            $fullPath = "{$baseFolder}/{$fileName}";
            Storage::disk('fileManager')->put($fullPath, file_get_contents($file));
            InsDoc::query()->create([
                'title' => $fileName,
                'category' => 'rd-' . $releaseDocument->id,
                'desc' => 'other',
                'status' => "2",
                'url' => $fullPath,
                'userID' => Auth::user()->id,
                'orderID' => $order->id,
                'ip' => $request->ip()
            ]);
        }

        return redirect()->route('rdocs.showUpload', ['order' => $order, 'releaseDocument' => $releaseDocument])
            ->with('success', 'Files uploaded successfully.');
    }

    public function deleteFile(Order $order, ReleaseDocument $releaseDocument)
    {
        $url = \request()->input('url');
        $insDoc = InsDoc::query()
            ->where('url', $url)
            ->first();
        Storage::disk('fileManager')->delete($url);
        $insDoc->delete();
        return redirect()->route('rdocs.showUpload', ['order' => $order, 'releaseDocument' => $releaseDocument])->with('success', 'File deleted successfully.');
    }

    private function getNewDocNumber() {
        $maxCertNo = ReleaseDocument::max('document_number');

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
        return 'ART/RD/' . str_pad($newCertNo, 6, '0', STR_PAD_LEFT);
    }
}
