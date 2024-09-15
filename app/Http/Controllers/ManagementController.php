<?php


namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

class ManagementController extends Controller
{
    public function index() {
        return view('dashboard');
    }
    
    
     public function viewPdf()
    {
        $filePath = storage_path('app/TDMSBOX/game.pdf');

        // Check if the file exists
        if (Storage::exists($filePath)) {
            // Read the file contents
            $fileContents = Storage::get($filePath);

            // Set the response content type as PDF
            $headers = [
                'Content-Type' => 'application/pdf',
            ];

            // Prevent the file from being downloaded
            $disposition = 'inline';

            // Return the response with file contents and headers
            return (new Response($fileContents, 200, $headers))
                ->header('Content-Disposition', $disposition);
        }

        // If the file does not exist, you may decide how to handle the error
        abort(404, '...File not found');
    }
}
