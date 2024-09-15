<?php

namespace Modules\Inspection\Http\Controllers;

use App\Models\CertificateCounter;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CertificateCounterController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('inspection::index');
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
    public function certCounter($certType,$branch,$user,$order)
    {
        $cert = new CertificateCounter();
        $cert->certType = $certType;
        $cert->branch = $branch;
        $cert->user_id = $user;
        $cert->order_id = $order;
        $cert->save();
        $cert->certNo = 'TIE/000'.$cert->id;
        $cert->issuingDate = date('Y-m-d');
        $cert->save();
        return $cert->certNo;

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('inspection::show');
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
        //
    }
}
