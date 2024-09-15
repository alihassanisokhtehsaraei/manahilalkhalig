<?php

namespace Modules\Inspection\Http\Controllers;

use App\Models\BankAcceptance;
use App\Models\Letter;
use App\Models\Order;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Morilog\Jalali\CalendarUtils;

class BankAcceptanceController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index($id)
    {
        $data = BankAcceptance::where('order_id', $id)->first();
        $order = Order::find($id);
        return view('inspection::bankacceptance.index', ['order' => $order, 'data' => $data]);
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
    public function store(Request $request)
    {
        //
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
        // Validate the incoming data
        $validatedData = $request->validate([
            'insType' => 'required',
            'goods' => 'required',
            'piDate' => 'nullable|date',
            'customsTarrif' => 'nullable',
            'CustomsName' => 'nullable',
            'bankName' => 'nullable',
            'branch' => 'nullable',
            'orderingNo' => 'nullable',
            'orderingDate' => 'nullable|date',
        ]);

        // Check if a record exists for the order_id
        $data = BankAcceptance::where('order_id', $id)->get();

        if ($data->isEmpty()) {
            // Create a new record
            $bankAcceptance = new BankAcceptance();
            $bankAcceptance->order_id = $id;
        } else {
            // Get the existing record
            $bankAcceptance = $data->first();
        }

        // Update or set the data for BankAcceptance
        $bankAcceptance->insType = $request->insType;
        $bankAcceptance->goodsDesc = $request->goods;
        $bankAcceptance->piDate = $request->piDate;
        $bankAcceptance->customsTarrif = $request->customsTarrif;
        $bankAcceptance->customsName = $request->customsName;
        $bankAcceptance->bankName = $request->bankName;
        $bankAcceptance->branch = $request->branch;
        $bankAcceptance->orderingNo = $request->orderingNo;
        $bankAcceptance->orderingDate = $request->orderingDate;
        $bankAcceptance->user_id = Auth()->user()->id;


        if ($data->isEmpty()) {
            // letter
            $curretNo = Letter::where('type', 2)->max('regNo');
            $new = $curretNo + 1;


            $letter = new Letter();

            $letter->type = 2;
            $letter->regNo = $new;
            $letter->branch = Auth()->user()->branch;
            $letter->ip = $request->ip();
            $letter->user = Auth()->user()->id;
            $letter->save();

            $branch_2digit = $this->getBranch(Auth()->user()->branch, 2);

            $letter->title = 'Bank Acceptance Letter';
            $letter->letNo = 'TIE/' . $branch_2digit . '/' . sprintf('%06d', $letter->regNo);
            $letter->letDate = date('Y-m-d');
            $letter->letText = 'نامه پذیرش بانک';
            $letter->signee = 'مدیرعامل';
            $letter->from = Auth()->user()->department;
            $letter->recipient = $bankAcceptance->bankName . ' - ' . $bankAcceptance->branch;
            $letter->writer = Auth()->user()->id;
            $letter->save();

            $jalaliDate = CalendarUtils::strftime('Y/m/d', $letter->letDate);


            $bankAcceptance->letterNo = $letter->letNo;
            $bankAcceptance->letterDate = $jalaliDate;
        }

        // Save the BankAcceptance record
        $bankAcceptance->save();

        // Redirect back or to another route after the update
        return back();
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


    public function getBranch($branch, $type) {
        if($type == 2) {
            switch($branch) {
                case 'tehran':
                    return 'TH';
                    break;
                case 'zanjan':
                    return 'ZJ';
                    break;
                case 'tabriz':
                    return 'TB';
                    break;
                case 'mashhad':
                    return 'MH';
                    break;
                case 'isfahan':
                    return 'IS';
                    break;
                case 'shiraz':
                    return 'SH';
                    break;
                case 'bushehr':
                    return 'BU';
                    break;
                case 'bandar abbas':
                    return 'BN';
                    break;
                case 'genaveh':
                    return 'GN';
                    break;
                case 'Qeshm':
                    return 'QS';
                    break;
                case 'Nowshahr':
                    return 'NO';
                    break;
                case 'Sari':
                    return 'SA';
                    break;
            }
        } elseif ($type == 3) {
            switch($branch) {
                case 'tehran':
                    return 'THR';
                    break;
                case 'zanjan':
                    return 'ZJN';
                    break;
                case 'tabriz':
                    return 'TBZ';
                    break;
                case 'mashhad':
                    return 'MHD';
                    break;
                case 'isfahan':
                    return 'ISF';
                    break;
                case 'shiraz':
                    return 'SHZ';
                    break;
                case 'bushehr':
                    return 'BUH';
                    break;
                case 'bandar abbas':
                    return 'BND';
                    break;
                case 'genaveh':
                    return 'GNV';
                    break;
                case 'Qeshm':
                    return 'QSM';
                    break;
                case 'Nowshahr':
                    return 'NOW';
                    break;
                case 'Sari':
                    return 'SAR';
                    break;
            }
        }
    }

}
