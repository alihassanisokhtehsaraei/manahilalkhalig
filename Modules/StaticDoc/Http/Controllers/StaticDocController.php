<?php

namespace Modules\StaticDoc\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StaticDocController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('staticdoc::index');
    }

    public function download($index)
    {
        $filePath = storage_path('docs/' . $index);
        if (file_exists($filePath)) {
            return response()->download($filePath,'');
        }
        return abort(404, 'File not found.');
    }

}
