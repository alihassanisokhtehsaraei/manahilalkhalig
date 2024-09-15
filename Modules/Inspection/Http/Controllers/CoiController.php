<?php

namespace Modules\Inspection\Http\Controllers;

use App\Models\CoiGood;
use App\Models\Customer;
use App\Models\Inspector;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Order;
use App\Models\Coi;
use Illuminate\Support\Facades\Auth;

class CoiController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('inspection::coi.index');
    }

    public function indexIC()
    {
        switch (auth()->user()->level) {
            case 'manager':
                $data = Coi::select('cois.id','cois.order_id','global_counters.trackingID','customers.fullName','customers.cName','orders.goods','orders.branch', 'orders.piNo')->join('orders','orders.id','=','cois.order_id')->join('global_counters','global_counters.id','=','orders.counterID')->join('customers','customers.id','=','orders.customerID')->where('cois.statusIC','<>',null)->get();
                break;
            case 'supervisor':
                $data = Coi::select('cois.id','cois.order_id','global_counters.trackingID','customers.fullName','customers.cName','orders.goods','orders.branch', 'orders.piNo')->join('orders','orders.id','=','cois.order_id')->join('global_counters','global_counters.id','=','orders.counterID')->join('customers','customers.id','=','orders.customerID')->where('cois.statusIC','<>',null)->get();
                break;
            case 'expert':
                $data = Coi::select('cois.id','cois.order_id','global_counters.trackingID','customers.fullName','customers.cName','orders.goods','orders.branch', 'orders.piNo')->join('orders','orders.id','=','cois.order_id')->join('global_counters','global_counters.id','=','orders.counterID')->join('customers','customers.id','=','orders.customerID')->where('cois.statusIC','<>',null)->where('orders.branch','=',Auth()->user()->branch)->get();
                break;
        }
        //print_r($data);

        if (request()->ajax()) {
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('customer', function ($row) {
                    return $row->fullName.' - '.$row->cName;
                })
                ->addColumn('actions', function ($row) {
                    $btn = '
                    <a href="/coi/showIC/' . $row->order_id . '" class="btn btn-warning btn-xs">IC Profile</a>
                    <a href="/inspection/show/' . $row->order_id . '" class="btn btn-primary btn-xs">Order</a>
                    <a href="/reports/ic/' . $row->id . '" class="btn btn-info btn-xs">Print</a>
                    ';
                    return $btn;
                })
                ->rawColumns(['actions','customer'])
                ->make(true);
        }
        return view('inspection::ic.index');
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $order_id)
    {
        $request->validate([
            'signDateCOI' => 'date_format:Y-M-d',
        ]);

        $coi = COI::where('order_id', $order_id)->first();
        $order = Order::where('id', $order_id)->first();

        if ($coi) {
            // COI already exists, update it
            $coi->fill($request->all());
            $coi->signDateCOI = \Carbon\Carbon::createFromFormat('Y-M-d', $request->input('signDateCOI'))->format('Y-m-d');
            $coi->signeeCOI = 'Alireza Tavakkoli / Managing Director';
            $coi->save();
            $message = 'COI updated successfully';
        } else {
            // COI does not exist, insert it as a new record

            $order->piNo = $request->input('piNo');
            $order->lcNo = $request->input('lcNo');
            $order->origin = $request->input('origin');
            $order->inspectorID = $request->input('inspectorNameCOI');
            $order->save();

            $coi = new COI();
            $coi->order_id = $order_id;
            $coi->buyer_name = $request->input('buyer_name');
            $coi->buyer_tel = $request->input('buyer_tel');
            $coi->buyer_fax = $request->input('buyer_fax');
            $coi->buyer_address = $request->input('buyer_address');
            $coi->seller_name = $request->input('seller_name');
            $coi->seller_tel = $request->input('seller_tel');
            $coi->seller_fax = $request->input('seller_fax');
            $coi->seller_address = $request->input('seller_address');
            $coi->manufacturer_name = $request->input('manufacturer_name');
            $coi->manufacturer_tel = $request->input('manufacturer_tel');
            $coi->manufacturer_fax = $request->input('manufacturer_fax');
            $coi->manufacturer_address = $request->input('manufacturer_address');
            $coi->piDate = $request->input('piDate');
            $coi->invoiceNo = $request->input('invoiceNo');
            $coi->invoiceDate = $request->input('invoiceDate');
            $coi->blNo = $request->input('blNo');
            $coi->blDate = $request->input('blDate');
            $coi->insuranceCompany = $request->input('insuranceCompany');
            $coi->insurancePolicy = $request->input('insurancePolicy');
            $coi->mdsd = $request->input('mdsd');
            $coi->portDischarge = $request->input('portDischarge');
            $coi->serialGoods = $request->input('serialGoods');
            $coi->totalQuantityCOI = $request->input('totalQuantityCOI');
            $coi->inspectionPlace = $request->input('inspectionPlace');
            $coi->inspectionDate = $request->input('inspectionDate');
            $coi->samplingDateCOI = $request->input('samplingDateCOI');
            $coi->testingPlaceCOI = $request->input('testingPlaceCOI');
            $coi->testingDateCOI = $request->input('testingDateCOI');
            $coi->labNameCOI = $request->input('labNameCOI');
            $coi->labNoCOI = $request->input('labNoCOI');
            $coi->testReportNoCOI = $request->input('testReportNoCOI');
            $coi->testReportDateCOI = $request->input('testReportDateCOI');
            $coi->conclusionCOI = $request->input('conclusionCOI');
            $coi->otherCommentCOI = $request->input('otherCommentCOI');
            $coi->signeeCOI = 'Alireza Tavakkoli / Managing Director';
            $coi->issuingPlaceCOI = $request->input('issuingPlaceCOI');
            $coi->signDateCOI = \Carbon\Carbon::createFromFormat('Y-M-d', $request->input('signDateCOI'))->format('Y-m-d');
            $coi->user_id = Auth()->user()->id;
            $coi->ip = $request->ip();
            $coi->statusCOI = 0;
            $coi->save();
            $message = 'COI created successfully';
        }

        return redirect()->route('coi.coiGoods', $order_id)->with('message', $message);
    }

    public function storeIC(Request $request, $order_id)
    {
            $request->validate([
                'signDateCOI' => 'date_format:Y-M-d',
            ]);

            $coi = COI::where('order_id', $order_id)->first();
            $order = Order::where('id', $order_id)->first();

        if ($coi) {
            // COI already exists, update it
            $coi->fill($request->all());
            $coi->signDateIC = \Carbon\Carbon::createFromFormat('Y-M-d', $request->input('signDateIC'))->format('Y-m-d');
            $coi->signeeIC = 'Alireza Tavakkoli / Managing Director';
            $coi->save();
            $message = 'IC updated successfully';
        } else {
            $order->piNo = $request->input('piNo');
            $order->lcNo = $request->input('lcNo');
            $order->origin = $request->input('origin');
            $order->inspectorID = $request->input('inspectorID');
            $order->vessel = $request->input('vessel');
            $order->save();

            // COI does not exist, insert it as a new record
            $coi = new COI();
            $coi->order_id = $order_id;
            $coi->buyer_name = $request->input('buyer_name');
            $coi->buyer_tel = $request->input('buyer_tel');
            $coi->buyer_fax = $request->input('buyer_fax');
            $coi->buyer_address = $request->input('buyer_address');
            $coi->seller_name = $request->input('seller_name');
            $coi->seller_tel = $request->input('seller_tel');
            $coi->seller_fax = $request->input('seller_fax');
            $coi->seller_address = $request->input('seller_address');
            $coi->manufacturer_name = $request->input('manufacturer_name');
            $coi->manufacturer_tel = $request->input('manufacturer_tel');
            $coi->manufacturer_fax = $request->input('manufacturer_fax');
            $coi->manufacturer_address = $request->input('manufacturer_address');
            $coi->piDate = $request->input('piDate');
            $coi->invoiceNo = $request->input('invoiceNo');
            $coi->invoiceDate = $request->input('invoiceDate');
            $coi->blNo = $request->input('blNo');
            $coi->blDate = $request->input('blDate');
            $coi->insuranceCompany = $request->input('insuranceCompany');
            $coi->insurancePolicy = $request->input('insurancePolicy');
            $coi->orderReg = $request->input('orderReg');
            $coi->portLoading = $request->input('portLoading');
            $coi->portDischarge = $request->input('portDischarge');
            $coi->portDelivery = $request->input('portDelivery');
            $coi->totalQuantityIC = $request->input('totalQuantityIC');;
            $coi->netWeightIC = $request->input('netWeightIC');
            $coi->grossWeightIC = $request->input('grossWeightIC');
            $coi->customsTarrifIC = $request->input('customsTarrifIC');
            $coi->issuingBankIC = $request->input('issuingBankIC');
            $coi->cbIC = $request->input('cbIC');
            $coi->manifestIC = $request->input('manifestIC');
            $coi->manifestDateIC = $request->input('manifestDateIC');
            $coi->ttIC = $request->input('ttIC');
            $coi->packingmarkingIC = $request->input('packingmarkingIC');
            $coi->findingsIC = $request->input('findingsIC');
            $coi->inspectionPlace = $request->input('inspectionPlace');
            $coi->inspectionDate = $request->input('inspectionDate');
            $coi->conclusionIC = $request->input('conclusionIC');
            //$coi->signeeIC = $request->input('signeeIC');
            $coi->signeeIC = 'Alireza Tavakkoli / Managing Director';
            $coi->issuingPlaceIC = $request->input('issuingPlaceIC');
            $coi->signDateIC = \Carbon\Carbon::createFromFormat('Y-M-d', $request->input('signDateIC'))->format('Y-m-d');
            $coi->user_id = Auth()->user()->id;
            $coi->statusIC = 0;
            $coi->ip = $request->ip();
            $coi->save();
            $message = 'IC created successfully';
        }

        return redirect()->route('coi.icGoods', $order_id)->with('message', $message);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $order = Order::find($id);
        $customer = Customer::find($order->customerID);
        $coi = Coi::where('order_id', '=', $id)->first();
        return view('inspection::coi.show', ['order' => $order, 'customer' => $customer, 'coi'=>$coi]);
    }

    public function showIC($id)
    {
        $order = Order::find($id);
        $customer = Customer::find($order->customerID);
        $coi = Coi::where('order_id', '=', $id)->first();
        return view('inspection::ic.show', ['order' => $order, 'customer' => $customer, 'coi'=>$coi]);
    }

    public function coigoods($id)
    {
        $order = Order::find($id);
        $customer = Customer::find($order->customerID);
        $coi = Coi::where('order_id', '=', $id)->first();
        $coigoods = CoiGood::where('order_id', '=', $id)->where('certType','=','coi')->get();
        return view('inspection::coi.goods', ['order' => $order, 'customer' => $customer, 'coi'=>$coi, 'coigoods'=>$coigoods]);
    }

    public function icgoods($id)
    {
        $order = Order::find($id);
        $customer = Customer::find($order->customerID);
        $coi = Coi::where('order_id', '=', $id)->first();
        $coigoods = CoiGood::where('order_id', '=', $id)->where('certType','=','ic')->get();
        return view('inspection::ic.goods', ['order' => $order, 'customer' => $customer, 'coi'=>$coi, 'coigoods'=>$coigoods]);
    }

    public function editGoods($id)
    {
        $coigood = CoiGood::where('id',$id)->first();
        $coi = Coi::where('order_id', '=', $coigood->order_id)->first();
        return view('inspection::coi.updategoods', ['coi'=>$coi, 'coigood'=>$coigood]);
    }
    public function iceditGoods($id)
    {
        $coigood = CoiGood::find($id);
        $coi = Coi::where('order_id', '=', $coigood->order_id)->first();
        return view('inspection::ic.updategoods', ['coi'=>$coi, 'coigood'=>$coigood]);
    }

    public function goodsUpdate(Request $request, $id)
    {
        $good = CoiGood::find($id);
        $good->desc = $request->input('desc');
        $good->quantity = $request->input('quantity');
        $good->packing = $request->input('packing');
        $good->netWeight = $request->input('netWeight');
        $good->grossWeight = $request->input('grossWeight');
        $good->HSCode = $request->input('HSCode');
        $good->standards = $request->input('standards');
        $good->user_id = Auth()->user()->id;
        $good->ip = $request->ip();
        $good->save();
        $message = "Item '{$good->desc}' modified successfully.";
        return redirect()->route('coi.coiGoods', $good->order_id)->with('message', $message);
    }

    public function icgoodsUpdate(Request $request, $id)
    {
        $good = CoiGood::find($id);
        $good->desc = $request->input('desc');
        $good->quantity = $request->input('quantity');
        $good->packing = $request->input('packing');
        $good->size = $request->input('size');
        $good->user_id = Auth()->user()->id;
        $good->ip = $request->ip();
        $good->save();
        $message = "Item '{$good->desc}' modified successfully.";
        return redirect()->route('coi.icGoods', $good->order_id)->with('message', $message);
    }

    public function goodsStore(Request $request, $id)
    {
        $coi = Coi::where('order_id', $id)->first();
        $good = new CoiGood();
        $good->order_id = $id;
        $good->coi_id = $coi->id;
        $good->desc = $request->input('desc');
        $good->certType = 'coi';
        $good->quantity = $request->input('quantity');
        $good->packing = $request->input('packing');
        $good->netWeight = $request->input('netWeight');
        $good->grossWeight = $request->input('grossWeight');
        $good->HSCode = $request->input('HSCode');
        $good->standards = $request->input('standards');
        $good->user_id = Auth()->user()->id;
        $good->ip = $request->ip();
        $good->save();
        $message = "Item '{$good->desc}' added successfully.";
        return back()->with('message', $message);
    }

    public function icgoodsStore(Request $request, $id)
    {
        $coi = Coi::where('order_id', $id)->first();
        $good = new CoiGood();
        $good->order_id = $id;
        $good->coi_id = $coi->id;
        $good->desc = $request->input('desc');
        $good->certType = 'ic';
        $good->quantity = $request->input('quantity');
        $good->packing = $request->input('packing');
        $good->size = $request->input('size');
        $good->user_id = Auth()->user()->id;
        $good->ip = $request->ip();
        $good->save();
        $message = "Item '{$good->desc}' added successfully.";
        return back()->with('message', $message);
    }

    public function changeStatus(Request $request, $id) {
        $coi = Coi::where('order_id','=',$id)->first();

        switch ($request->input('status')) {
            case 0:
                $coi->statusCOI = '0';
                break;
            case 1:
                $coi->statusCOI = '1';
                break;
            case 2:
                $coi->statusCOI = '2';
                $coi->COI_reviewer_id = Auth()->user()->id;
                $coi->COI_reviewDate = date('Y-m-d');
                $coi->rejectNoteCOI = $request->input('note');
                break;
            case 3:
                $coi->statusCOI = '3';
                $coi->COI_reviewer_id = Auth()->user()->id;
                $coi->COI_reviewDate = date('Y-m-d');
                break;
            case 4:
                $coi->statusCOI = '4';
                break;
            case 5:
                $coi->statusCOI = '5';
                break;
        }
        $coi->COIPaper = $request->input('COIpaper');
        $coi->save();
        return back();
    }

    public function changeStatusIC(Request $request, $id) {
        $coi = Coi::where('order_id','=',$id)->first();

        switch ($request->input('status')) {
            case 0:
                $coi->statusIC = '0';
                break;
            case 1:
                $coi->statusIC = '1';
                break;
            case 2:
                $coi->statusIC = '2';
                $coi->IC_reviewer_id = Auth()->user()->id;
                $coi->IC_reviewDate = date('Y-m-d');
                $coi->rejectNoteIC = $request->input('note');
                break;
            case 3:
                $coi->statusIC = '3';
                $coi->IC_reviewer_id = Auth()->user()->id;
                $coi->IC_reviewDate = date('Y-m-d');
                break;
            case 4:
                $coi->statusIC = '4';
                break;
            case 5:
                $coi->statusIC = '5';
                break;
        }
        $coi->ICPaper = $request->input('ICPaper');
        $coi->save();
        return back();
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
    public function destroyGoods($id)
    {
        $goods = CoiGood::find($id)->delete();
        return back();
    }

}
