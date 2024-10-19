<?php

namespace Modules\Inspection\Http\Controllers;

use App\Models\Coc;
use App\Models\Ncr;
use App\Models\NonReleaseDocument;
use App\Models\Order;
use App\Models\ReleaseDocument;
use Dompdf\Dompdf;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\TemplateProcessor;
use NcJoes\OfficeConverter\OfficeConverter;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Color\Color;

class WordController extends Controller
{
    public function generateDocumentCoc(Coc $coc)
    {
        \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true);
        $templatePath = storage_path('words/coc.docx'); // Adjust the path to your template
        $templateProcessor = new TemplateProcessor($templatePath);
        $order = $coc->order;

        // Setting template values
        $templateProcessor->setValue('certNo', $coc->certNo ?? '-');
        $templateProcessor->setValue('issuingDate', $coc->issuingDate ?? '-');
        $templateProcessor->setValue('expDate', $coc->expDate ?? '-');
        $templateProcessor->setValue('regNo', $coc->regNo ?? '-');
        $templateProcessor->setValue('refNo', $coc->refNo ?? '-');
        $templateProcessor->setValue('importerName', $coc->importerName ?? '-');
        $templateProcessor->setValue('exporterName', $coc->exporterName ?? '-');
        $templateProcessor->setValue('importerAdd', $coc->importerAdd ?? '-');
        $templateProcessor->setValue('exporterAdd', $coc->exporterAdd ?? '-');
        $templateProcessor->setValue('importerCityCountry', $coc->importerCityCountry ?? '-');
        $templateProcessor->setValue('exporterCityCountry', $coc->exporterCityCountry ?? '-');
        $templateProcessor->setValue('importerLicence', $coc->importerLicence ?? '-');
        $templateProcessor->setValue('importerLicenceDate', $coc->importerLicenceDate ?? '-');
        $templateProcessor->setValue('invNo', $coc->invNo ?? '-');
        $templateProcessor->setValue('invDate', $coc->invDate ?? '-');
        $templateProcessor->setValue('invAmount', $coc->invAmount ?? '-');
        $templateProcessor->setValue('invCurrency', $coc->invCurrency ?? '-');
        $templateProcessor->setValue('shipmentCountry', $coc->shipmentCountry ?? '-');
        $templateProcessor->setValue('blNo', $coc->blNo ?? '-');
        $templateProcessor->setValue('blDate', $coc->blDate ?? '-');
        $templateProcessor->setValue('packingDetails', $coc->packingDetails ?? '-');
        $templateProcessor->setValue('containerDetails', $coc->containerDetails ?? '-');
        $templateProcessor->setValue('numTypePacking', $coc->numTypePacking ?? '-');
        $templateProcessor->setValue('sealNo', $coc->sealNo ?? '-');
        $templateProcessor->setValue('remark', $coc->remark ?? '-');
        $templateProcessor->setValue('assessment', $coc->assessment ?? '-');
        $templateProcessor->setValue('invUSD', $coc->invUSD ?? '-');
        $templateProcessor->setValue('invValPerTruck', $coc->invValPerTruck ?? '-');
        $templateProcessor->setValue('signee', $coc->signee ?? '-');
        $templateProcessor->setValue('issuingPlace', $coc->issuingPlace ?? '-');
        $templateProcessor->setValue('OshipmentMethod', $order->shipmentMethod ?? '-');
        $templateProcessor->setValue('Oborder', $order->border ?? '-');

        // Generate the table and QR code
        $this->generateDocxTable($templateProcessor, $coc);
        $signedUrl = URL::signedRoute('words.coc', ['coc' => $coc->id]);
        $qrCode = new QrCode($signedUrl);
        $qrCode->setSize(80);
        $qrCode->setMargin(0);
        $backgroundColor = new Color(255, 255, 255); // Black color
        $foregroundColor = new Color(153, 0, 0); // RGB(153, 0, 0) which is the hex color #900
        $qrCode->setForegroundColor($foregroundColor);
        $qrCode->setBackgroundColor($backgroundColor);

        // Write QR code to a string
        $writer = new PngWriter();
        $qrCodeImageData = $writer->write($qrCode)->getString();

        // Save the QR code to a file
        $qrCodePath = storage_path('app/qr_code.png');
        file_put_contents($qrCodePath, $qrCodeImageData);
        $templateProcessor->setImageValue('qr_code', array('path' => $qrCodePath, 'width' => 100, 'height' => 100));
        $outputWordPath = storage_path('outputs/coc-' . $coc->id . '.docx');
        $templateProcessor->saveAs($outputWordPath);

        // Determine the platform and set the LibreOffice path accordingly
        if (PHP_OS_FAMILY === 'Windows') {
            $libreOfficePath = 'C:\\Program Files\\LibreOffice\\program\\soffice.exe';
            $command = "\"$libreOfficePath\" --headless --convert-to pdf --outdir \"" . storage_path('outputs') . "\" \"$outputWordPath\"";
        } else {
            $libreOfficePath = '/usr/bin/libreoffice';
            $command = "$libreOfficePath --headless --convert-to pdf --outdir " . escapeshellarg(storage_path('outputs')) . " " . escapeshellarg($outputWordPath);
        }

        // Execute the command
        $output = [];
        $returnVar = null;
        exec($command . ' 2>&1', $output, $returnVar);

        // Log the command output for debugging
        Log::info('Command executed: ' . $command);
        Log::info('Command output: ' . implode("\n", $output));

        // Check if the conversion was successful
        if ($returnVar !== 0) {
            $errorOutput = implode("\n", $output);
            throw new \Exception("Conversion failed with error code $returnVar. Output: $errorOutput");
        }

        return response()->download(storage_path('outputs/coc-' . $coc->id . '.pdf'))->deleteFileAfterSend(true);
    }
    public function generateDocumentDraftCoc(Coc $coc)
    {
        \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true);

        $order = $coc->order;
        $templatePath = storage_path('words/coc-draft.docx');
        $templateProcessor = new TemplateProcessor($templatePath);
        // Setting template values
        $templateProcessor->setValue('certNo', $coc->certNo ?? '-');
        $templateProcessor->setValue('issuingDate', $coc->issuingDate ?? '-');
        $templateProcessor->setValue('expDate', $coc->expDate ?? '-');
        $templateProcessor->setValue('regNo', $coc->regNo ?? '-');
        $templateProcessor->setValue('refNo', $coc->refNo ?? '-');
        $templateProcessor->setValue('importerName', $coc->importerName ?? '-');
        $templateProcessor->setValue('exporterName', $coc->exporterName ?? '-');
        $templateProcessor->setValue('importerAdd', $coc->importerAdd ?? '-');
        $templateProcessor->setValue('exporterAdd', $coc->exporterAdd ?? '-');
        $templateProcessor->setValue('importerCityCountry', $coc->importerCityCountry ?? '-');
        $templateProcessor->setValue('exporterCityCountry', $coc->exporterCityCountry ?? '-');
        $templateProcessor->setValue('importerLicence', $coc->importerLicence ?? '-');
        $templateProcessor->setValue('importerLicenceDate', $coc->importerLicenceDate ?? '-');
        $templateProcessor->setValue('invNo', $coc->invNo ?? '-');
        $templateProcessor->setValue('invDate', $coc->invDate ?? '-');
        $templateProcessor->setValue('invAmount', $coc->invAmount ?? '-');
        $templateProcessor->setValue('invCurrency', $coc->invCurrency ?? '-');
        $templateProcessor->setValue('shipmentCountry', $coc->shipmentCountry ?? '-');
        $templateProcessor->setValue('blNo', $coc->blNo ?? '-');
        $templateProcessor->setValue('blDate', $coc->blDate ?? '-');
        $templateProcessor->setValue('packingDetails', $coc->packingDetails ?? '-');
        $templateProcessor->setValue('containerDetails', $coc->containerDetails ?? '-');
        $templateProcessor->setValue('numTypePacking', $coc->numTypePacking ?? '-');
        $templateProcessor->setValue('sealNo', $coc->sealNo ?? '-');
        $templateProcessor->setValue('remark', $coc->remark ?? '-');
        $templateProcessor->setValue('assessment', $coc->assessment ?? '-');
        $templateProcessor->setValue('invUSD', $coc->invUSD ?? '-');
        $templateProcessor->setValue('invValPerTruck', isset($coc->invValPerTruck) ? number_format((float)$coc->invValPerTruck, 2, '.', ',') : '-');
        $templateProcessor->setValue('signee', $coc->signee ?? '-');
        $templateProcessor->setValue('issuingPlace', $coc->issuingPlace ?? '-');
        $templateProcessor->setValue('OshipmentMethod', $order->shipmentMethod ?? '-');
        $templateProcessor->setValue('Oborder', $order->border ?? '-');
        $templateProcessor->setValue('borderFeePlace', $order->borderFeePlace=="Branch" ? ' (P)' : ' (UP)' );

        // Generate the table and QR code
        $this->generateDocxTable($templateProcessor, $coc);
        $signedUrl = URL::signedRoute('words.coc', ['coc' => $coc->id]);
        $qrCode = new QrCode($signedUrl);
        $qrCode->setSize(100);
        $qrCode->setMargin(0);
        $backgroundColor = new Color(255, 255, 255); // Black color
        $foregroundColor = new Color(153, 0, 0); // RGB(153, 0, 0) which is the hex color #900
        $qrCode->setForegroundColor($foregroundColor);
        $qrCode->setBackgroundColor($backgroundColor);

        // Write QR code to a string
        $writer = new PngWriter();
        $qrCodeImageData = $writer->write($qrCode)->getString();

        // Save the QR code to a file
        $qrCodePath = storage_path('app/qr_code.png');
        file_put_contents($qrCodePath, $qrCodeImageData);
        $templateProcessor->setImageValue('qr_code', array('path' => $qrCodePath, 'width' => 60, 'height' => 60));
        $outputWordPath = storage_path('outputs/coc-draft-' . $coc->id . '.docx');
        $templateProcessor->saveAs($outputWordPath);

        // Determine the platform and set the LibreOffice path accordingly
        if (PHP_OS_FAMILY === 'Windows') {
            $libreOfficePath = 'C:\\Program Files\\LibreOffice\\program\\soffice.exe';
            $command = "\"$libreOfficePath\" --headless --convert-to pdf --outdir \"" . storage_path('outputs') . "\" \"$outputWordPath\"";
        } else {
            $libreOfficePath = '/usr/bin/libreoffice';
            $command = "$libreOfficePath --headless --convert-to pdf --outdir " . escapeshellarg(storage_path('outputs')) . " " . escapeshellarg($outputWordPath);
        }

        // Execute the command
        $output = [];
        $returnVar = null;
        exec($command . ' 2>&1', $output, $returnVar);

        // Log the command output for debugging
        Log::info('Command executed: ' . $command);
        Log::info('Command output: ' . implode("\n", $output));

        // Check if the conversion was successful
        if ($returnVar !== 0) {
            $errorOutput = implode("\n", $output);
            throw new \Exception("Conversion failed with error code $returnVar. Output: $errorOutput");
        }

        return response()->download(storage_path('outputs/coc-draft-' . $coc->id. '.pdf'))->deleteFileAfterSend(true);
    }


    public function generateDocumentNcr(Ncr $ncr)
    {
        \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true);
        $templatePath = storage_path('words/ncr.docx'); // Adjust the path to your template
        $templateProcessor = new TemplateProcessor($templatePath);
        // Setting template values
        $templateProcessor->setValue('certNo', $ncr->certNo ?? '-');
        $templateProcessor->setValue('issuingDate', $ncr->issuingDate ?? '-');
        $templateProcessor->setValue('expDate', $ncr->expDate ?? '-');
        $templateProcessor->setValue('regNo', $ncr->regNo ?? '-');
        $templateProcessor->setValue('rfiNo', $ncr->rfi ?? '-');
        $templateProcessor->setValue('importerName', $ncr->importer ?? '-');
        $templateProcessor->setValue('exporterName', $ncr->exporter ?? '-');
        $templateProcessor->setValue('importerAdd', $ncr->importerAdd ?? '-');
        $templateProcessor->setValue('exporterAdd', $ncr->exporterAdd ?? '-');
        $templateProcessor->setValue('invNo', $ncr->invNo ?? '-');
        $templateProcessor->setValue('invDate', $ncr->invDate ?? '-');
        $templateProcessor->setValue('invAmount', $ncr->invAmount ?? '-');
        $templateProcessor->setValue('invCurrency', $ncr->invCurrency ?? '-');
        $templateProcessor->setValue('reason', $ncr->reason ?? '-');
        $templateProcessor->setValue('signee', $ncr->signee ?? '-');
        $templateProcessor->setValue('issuingPlace', $ncr->issuingPlace ?? '-');

        // Generate the table and QR code
        $this->generateNcrTable($templateProcessor, $ncr);
        $signedUrl = URL::signedRoute('words.ncr', ['ncr' => $ncr->id]);

        // Generate the QR code with the signed URL
        $qrCode = new QrCode($signedUrl);
        $qrCode->setMargin(0);
        $backgroundColor = new Color(255, 255, 255); // Black color
        $foregroundColor = new Color(153, 0, 0); // RGB(153, 0, 0) which is the hex color #900
        $qrCode->setForegroundColor($foregroundColor);
        $qrCode->setBackgroundColor($backgroundColor);

        // Write QR code to a string
        $writer = new PngWriter();
        $qrCodeImageData = $writer->write($qrCode)->getString();

        // Save the QR code to a file
        $qrCodePath = storage_path('app/qr_code.png');
        file_put_contents($qrCodePath, $qrCodeImageData);
        $templateProcessor->setImageValue('qr_code', array('path' => $qrCodePath, 'width' => 100, 'height' => 100));
        $outputWordPath = storage_path('outputs/ncr-' . $ncr->id . '.docx');
        $templateProcessor->saveAs($outputWordPath);

        // Determine the platform and set the LibreOffice path accordingly
        if (PHP_OS_FAMILY === 'Windows') {
            $libreOfficePath = 'C:\\Program Files\\LibreOffice\\program\\soffice.exe';
            $command = "\"$libreOfficePath\" --headless --convert-to pdf --outdir \"" . storage_path('outputs') . "\" \"$outputWordPath\"";
        } else {
            $libreOfficePath = '/usr/bin/libreoffice';
            $command = "$libreOfficePath --headless --convert-to pdf --outdir " . escapeshellarg(storage_path('outputs')) . " " . escapeshellarg($outputWordPath);
        }

        // Execute the command
        $output = [];
        $returnVar = null;
        exec($command . ' 2>&1', $output, $returnVar);

        // Log the command output for debugging
        Log::info('Command executed: ' . $command);
        Log::info('Command output: ' . implode("\n", $output));

        // Check if the conversion was successful
        if ($returnVar !== 0) {
            $errorOutput = implode("\n", $output);
            throw new \Exception("Conversion failed with error code $returnVar. Output: $errorOutput");
        }

        return response()->download(storage_path('outputs/ncr-' . $ncr->id . '.pdf'))->deleteFileAfterSend(true);
    }
    public function generateDocumentDraftNcr(Ncr $ncr)
    {
        \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true);
        $templatePath = storage_path('words/ncr-draft.docx'); // Adjust the path to your template
        $templateProcessor = new TemplateProcessor($templatePath);
        // Setting template values
        $templateProcessor->setValue('certNo', $ncr->certNo ?? '-');
        $templateProcessor->setValue('issuingDate', $ncr->issuingDate ?? '-');
        $templateProcessor->setValue('expDate', $ncr->expDate ?? '-');
        $templateProcessor->setValue('regNo', $ncr->regNo ?? '-');
        $templateProcessor->setValue('rfiNo', $ncr->rfi ?? '-');
        $templateProcessor->setValue('importerName', $ncr->importer ?? '-');
        $templateProcessor->setValue('exporterName', $ncr->exporter ?? '-');
        $templateProcessor->setValue('importerAdd', $ncr->importerAdd ?? '-');
        $templateProcessor->setValue('exporterAdd', $ncr->exporterAdd ?? '-');
        $templateProcessor->setValue('invNo', $ncr->invNo ?? '-');
        $templateProcessor->setValue('invDate', $ncr->invDate ?? '-');
        $templateProcessor->setValue('invAmount', $ncr->invAmount ?? '-');
        $templateProcessor->setValue('invCurrency', $ncr->invCurrency ?? '-');
        $templateProcessor->setValue('reason', $ncr->reason ?? '-');
        $templateProcessor->setValue('signee', $ncr->signee ?? '-');
        $templateProcessor->setValue('issuingPlace', $ncr->issuingPlace ?? '-');

        // Generate the table and QR code
        $this->generateNcrTable($templateProcessor, $ncr);
        $signedUrl = URL::signedRoute('words.ncr', ['ncr' => $ncr->id]);

        // Generate the QR code with the signed URL
        $qrCode = new QrCode($signedUrl);
        $qrCode->setMargin(0);
        $backgroundColor = new Color(255, 255, 255); // Black color
        $foregroundColor = new Color(153, 0, 0); // RGB(153, 0, 0) which is the hex color #900
        $qrCode->setForegroundColor($foregroundColor);
        $qrCode->setBackgroundColor($backgroundColor);

        // Write QR code to a string
        $writer = new PngWriter();
        $qrCodeImageData = $writer->write($qrCode)->getString();

        // Save the QR code to a file
        $qrCodePath = storage_path('app/qr_code.png');
        file_put_contents($qrCodePath, $qrCodeImageData);
        $templateProcessor->setImageValue('qr_code', array('path' => $qrCodePath, 'width' => 100, 'height' => 100));
        $outputWordPath = storage_path('outputs/ncr-draft-' . $ncr->id . '.docx');
        $templateProcessor->saveAs($outputWordPath);

        // Determine the platform and set the LibreOffice path accordingly
        if (PHP_OS_FAMILY === 'Windows') {
            $libreOfficePath = 'C:\\Program Files\\LibreOffice\\program\\soffice.exe';
            $command = "\"$libreOfficePath\" --headless --convert-to pdf --outdir \"" . storage_path('outputs') . "\" \"$outputWordPath\"";
        } else {
            $libreOfficePath = '/usr/bin/libreoffice';
            $command = "$libreOfficePath --headless --convert-to pdf --outdir " . escapeshellarg(storage_path('outputs')) . " " . escapeshellarg($outputWordPath);
        }

        // Execute the command
        $output = [];
        $returnVar = null;
        exec($command . ' 2>&1', $output, $returnVar);

        // Log the command output for debugging
        Log::info('Command executed: ' . $command);
        Log::info('Command output: ' . implode("\n", $output));

        // Check if the conversion was successful
        if ($returnVar !== 0) {
            $errorOutput = implode("\n", $output);
            throw new \Exception("Conversion failed with error code $returnVar. Output: $errorOutput");
        }

        return response()->download(storage_path('outputs/ncr-draft-' . $ncr->id . '.pdf'))->deleteFileAfterSend(true);
    }

    public function generateDocumentRelease(ReleaseDocument $releaseDocument)
    {
        \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true);
        $templatePath = storage_path('words/rd.docx'); // Adjust the path to your template
        $templateProcessor = new TemplateProcessor($templatePath);
        // Setting template values
        $templateProcessor->setValue('certNo', $releaseDocument->coc->certNo ?? '-');
        $templateProcessor->setValue('Oborder', $releaseDocument->coc->order->border ?? '-');
        $templateProcessor->setValue('expDate', $releaseDocument->coc->expDate ?? '-');
        $templateProcessor->setValue('importerName', $releaseDocument->coc->importerName ?? '-');
        $templateProcessor->setValue('following_checks', $releaseDocument->following_checks ?? '-');
        $templateProcessor->setValue('containers_details_not_mentioned', $releaseDocument->containers_details_not_mentioned ?? '-');
        $templateProcessor->setValue('import_documents_not_mentioned', $releaseDocument->import_documents_not_mentioned ?? '-');
        $templateProcessor->setValue('number_of_items', $releaseDocument->number_of_items ?? '-');
        $templateProcessor->setValue('shipment_type', $releaseDocument->shipment_type ?? '-');
        $templateProcessor->setValue('shipment_details', $releaseDocument->shipment_details ?? '-');
        $templateProcessor->setValue('remaining_quantity', $releaseDocument->remaining_quantity ?? '-');
        $templateProcessor->setValue('incoming_quantity', $releaseDocument->incoming_quantity ?? '-');
        $templateProcessor->setValue('total_quantity', $releaseDocument->total_quantity ?? '-');
        $templateProcessor->setValue('comments', $releaseDocument->comments ?? '-');
        $templateProcessor->setValue('full_name', Auth::user()->name . " " . Auth::user()->lastname ?? '-');
        $templateProcessor->setValue('document_number', $releaseDocument->document_number ?? '-');
        $templateProcessor->setValue('issuance_date', $releaseDocument->issuance_date ?? '-');
        $templateProcessor->setValue('issuing_office', $releaseDocument->issuing_office ?? '-');

        $signedUrl = URL::signedRoute('words.rd', ['releaseDocument' => $releaseDocument->id]);

        // Generate the QR code with the signed URL
        $qrCode = new QrCode($signedUrl);
        $qrCode->setMargin(0);
        $backgroundColor = new Color(255, 255, 255); // Black color
        $foregroundColor = new Color(153, 0, 0); // RGB(153, 0, 0) which is the hex color #900
        $qrCode->setForegroundColor($foregroundColor);
        $qrCode->setBackgroundColor($backgroundColor);

        // Write QR code to a string
        $writer = new PngWriter();
        $qrCodeImageData = $writer->write($qrCode)->getString();

        // Save the QR code to a file
        $qrCodePath = storage_path('app/qr_code.png');
        file_put_contents($qrCodePath, $qrCodeImageData);
        $templateProcessor->setImageValue('qr_code', array('path' => $qrCodePath, 'width' => 100, 'height' => 100));
        $outputWordPath = storage_path('outputs/rd-' . $releaseDocument->id . '.docx');
        $templateProcessor->saveAs($outputWordPath);

        // Determine the platform and set the LibreOffice path accordingly
        if (PHP_OS_FAMILY === 'Windows') {
            $libreOfficePath = 'C:\\Program Files\\LibreOffice\\program\\soffice.exe';
            $command = "\"$libreOfficePath\" --headless --convert-to pdf --outdir \"" . storage_path('outputs') . "\" \"$outputWordPath\"";
        } else {
            $libreOfficePath = '/usr/bin/libreoffice';
            $command = "$libreOfficePath --headless --convert-to pdf --outdir " . escapeshellarg(storage_path('outputs')) . " " . escapeshellarg($outputWordPath);
        }

        // Execute the command
        $output = [];
        $returnVar = null;
        exec($command . ' 2>&1', $output, $returnVar);

        // Log the command output for debugging
        Log::info('Command executed: ' . $command);
        Log::info('Command output: ' . implode("\n", $output));

        // Check if the conversion was successful
        if ($returnVar !== 0) {
            $errorOutput = implode("\n", $output);
            throw new \Exception("Conversion failed with error code $returnVar. Output: $errorOutput");
        }

        return response()->download(storage_path('outputs/rd-' . $releaseDocument->id . '.pdf'))->deleteFileAfterSend(true);
    }

    public function generateDocumentNonRelease(NonReleaseDocument $nonReleaseDocument)
    {
        \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true);
        \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true);
        $templatePath = storage_path('words/nrd.docx'); // Adjust the path to your template
        $templateProcessor = new TemplateProcessor($templatePath);
        // Setting template values
        $templateProcessor->setValue('certNo', $nonReleaseDocument->coc->certNo ?? '-');
        $templateProcessor->setValue('Oborder', $nonReleaseDocument->coc->order->border ?? '-');
        $templateProcessor->setValue('expDate', $nonReleaseDocument->coc->expDate ?? '-');
        $templateProcessor->setValue('importerName', $nonReleaseDocument->coc->importerName ?? '-');
        $templateProcessor->setValue('description', $nonReleaseDocument->description ?? '-');
        $templateProcessor->setValue('containers_details_not_mentioned', $nonReleaseDocument->containers_details_not_mentioned ?? '-');
        $templateProcessor->setValue('import_documents_not_mentioned', $nonReleaseDocument->import_documents_not_mentioned ?? '-');
        $templateProcessor->setValue('number_of_items', $nonReleaseDocument->number_of_items ?? '-');
        $templateProcessor->setValue('shipment_type', $nonReleaseDocument->shipment_type ?? '-');
        $templateProcessor->setValue('shipment_details', $nonReleaseDocument->shipment_details ?? '-');
        $templateProcessor->setValue('remaining_quantity', $nonReleaseDocument->remaining_quantity ?? '-');
        $templateProcessor->setValue('incoming_quantity', $nonReleaseDocument->incoming_quantity ?? '-');
        $templateProcessor->setValue('total_quantity', $nonReleaseDocument->total_quantity ?? '-');
        $templateProcessor->setValue('comments', $nonReleaseDocument->comments ?? '-');
        $templateProcessor->setValue('full_name', Auth::user()->name . " " . Auth::user()->lastname ?? '-');
        $templateProcessor->setValue('document_number', $nonReleaseDocument->document_number ?? '-');
        $templateProcessor->setValue('issuance_date', $nonReleaseDocument->issuance_date ?? '-');
        $templateProcessor->setValue('issuing_office', $nonReleaseDocument->issuing_office ?? '-');

        $signedUrl = URL::signedRoute('words.nrd', ['nonReleaseDocument' => $nonReleaseDocument->id]);

        // Generate the QR code with the signed URL
        $qrCode = new QrCode($signedUrl);
        $qrCode->setMargin(0);
        $backgroundColor = new Color(255, 255, 255); // Black color
        $foregroundColor = new Color(153, 0, 0); // RGB(153, 0, 0) which is the hex color #900
        $qrCode->setForegroundColor($foregroundColor);
        $qrCode->setBackgroundColor($backgroundColor);

        // Write QR code to a string
        $writer = new PngWriter();
        $qrCodeImageData = $writer->write($qrCode)->getString();

        // Save the QR code to a file
        $qrCodePath = storage_path('app/qr_code.png');
        file_put_contents($qrCodePath, $qrCodeImageData);
        $templateProcessor->setImageValue('qr_code', array('path' => $qrCodePath, 'width' => 100, 'height' => 100));
        $outputWordPath = storage_path('outputs/nrd-' . $nonReleaseDocument->id . '.docx');
        $templateProcessor->saveAs($outputWordPath);

        // Determine the platform and set the LibreOffice path accordingly
        if (PHP_OS_FAMILY === 'Windows') {
            $libreOfficePath = 'C:\\Program Files\\LibreOffice\\program\\soffice.exe';
            $command = "\"$libreOfficePath\" --headless --convert-to pdf --outdir \"" . storage_path('outputs') . "\" \"$outputWordPath\"";
        } else {
            $libreOfficePath = '/usr/bin/libreoffice';
            $command = "$libreOfficePath --headless --convert-to pdf --outdir " . escapeshellarg(storage_path('outputs')) . " " . escapeshellarg($outputWordPath);
        }

        // Execute the command
        $output = [];
        $returnVar = null;
        exec($command . ' 2>&1', $output, $returnVar);

        // Log the command output for debugging
        Log::info('Command executed: ' . $command);
        Log::info('Command output: ' . implode("\n", $output));

        // Check if the conversion was successful
        if ($returnVar !== 0) {
            $errorOutput = implode("\n", $output);
            throw new \Exception("Conversion failed with error code $returnVar. Output: $errorOutput");
        }

        return response()->download(storage_path('outputs/nrd-' . $nonReleaseDocument->id . '.pdf'))->deleteFileAfterSend(true);
    }

    public function generateSample(Order $order)
    {
        \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true);
        $rft = $order->rft->first();
        $templatePath = storage_path('words/sample.docx');
        $templateProcessor = new TemplateProcessor($templatePath);
        // Setting template values
        $templateProcessor->setValue('Oborder', $order->border ?? '-');
        $templateProcessor->setValue('rft.ref', $rft->ref ?? '-');
        $templateProcessor->setValue('rft.inspectionCompany', $rft->inspectionCompany ?? '-');
        $templateProcessor->setValue('rft.date', $rft->date ?? '-');
        $templateProcessor->setValue('rft.cocNoOtherCompany', $rft->cocNoOtherCompany?? '-');
        $templateProcessor->setValue('rft.note', $rft->note ?? '-');
        $templateProcessor->setValue('rft.cosqcName', $rft->cosqcName ?? '-');
        $templateProcessor->setValue('rft.insName', $rft->insName ?? '-');
        $templateProcessor->setValue('rft.customsName', $rft->customsName ?? '-');
        $templateProcessor->setValue('rft.brokerName', $rft->brokerName ?? '-');
        $this->generateSampleTable($templateProcessor, $rft);
        $outputWordPath = storage_path('outputs/sample-' . $rft->id . '.docx');
        $templateProcessor->saveAs($outputWordPath);

        // Determine the platform and set the LibreOffice path accordingly
        if (PHP_OS_FAMILY === 'Windows') {
            $libreOfficePath = 'C:\\Program Files\\LibreOffice\\program\\soffice.exe';
            $command = "\"$libreOfficePath\" --headless --convert-to pdf --outdir \"" . storage_path('outputs') . "\" \"$outputWordPath\"";
        } else {
            $libreOfficePath = '/usr/bin/libreoffice';
            $command = "$libreOfficePath --headless --convert-to pdf --outdir " . escapeshellarg(storage_path('outputs')) . " " . escapeshellarg($outputWordPath);
        }

        // Execute the command
        $output = [];
        $returnVar = null;
        exec($command . ' 2>&1', $output, $returnVar);

        // Log the command output for debugging
        Log::info('Command executed: ' . $command);
        Log::info('Command output: ' . implode("\n", $output));

        // Check if the conversion was successful
        if ($returnVar !== 0) {
            $errorOutput = implode("\n", $output);
            throw new \Exception("Conversion failed with error code $returnVar. Output: $errorOutput");
        }

        return response()->download(storage_path('outputs/sample-' . $rft->id . '.pdf'))->deleteFileAfterSend(true);
    }

    private function generateDocxTable(TemplateProcessor $templateProcessor, $coc)
    {

        $tableRows = [];

        foreach ($coc->goods as $index => $good) {
            $tableRows[] = [
                'tableRow.ITEM' => htmlspecialchars($index + 1),
                'tableRow.QUANTITY_UNIT' => htmlspecialchars($good->quantity),
                'tableRow.GOODS' => htmlspecialchars($good->value),
                'tableRow.COUNTRY_OF_ORIGIN' => htmlspecialchars($good->origin),
                'tableRow.GOOD_DESCRIPTION' => htmlspecialchars($good->desc),
                'tableRow.STANDARD_REF_NO' => htmlspecialchars($good->standard)
            ];
        }


        $templateProcessor->cloneRowAndSetValues('tableRow.ITEM', $tableRows);
    }


    private function generateNcrTable(TemplateProcessor $templateProcessor, $ncr)
    {

        $tableRows = [];

        foreach ($ncr->ncrGoods as $index => $good) {
            $tableRows[] = [
                'tableRow.ITEM' => htmlspecialchars($index + 1),
                'tableRow.QUANTITY_UNIT' => htmlspecialchars($good->quantity),
                'tableRow.COUNTRY_OF_ORIGIN' => htmlspecialchars($good->origin),
                'tableRow.GOOD_DESCRIPTION' => htmlspecialchars($good->desc),
                'tableRow.STANDARD_REF_NO' => htmlspecialchars($good->standard)
            ];
        }


        $templateProcessor->cloneRowAndSetValues('tableRow.ITEM', $tableRows);
    }

    private function generateSampleTable(TemplateProcessor $templateProcessor, $rft)
    {

        $tableRows = [];
        foreach ($rft->rftsample as $index => $good) {
            $tableRows[] = [
                'tableRow.ITEM' => htmlspecialchars($index + 1),
                'tableRow.SAMPLE' => htmlspecialchars($good->desc),
                'tableRow.QUANTITY' => htmlspecialchars($good->quantity),
                'tableRow.SEAL_NO' => htmlspecialchars($good->desc),
            ];
        }


        $templateProcessor->cloneRowAndSetValues('tableRow.ITEM', $tableRows);
    }

}
