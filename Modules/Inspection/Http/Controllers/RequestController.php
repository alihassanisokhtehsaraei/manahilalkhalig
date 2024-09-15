<?php

namespace Modules\Inspection\Http\Controllers;

use App\Models\Customer;
use App\Models\Rfc;
use App\Models\Rft;
use App\Models\RftSamples;
use App\Models\User;
use App\Models\Order;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class RequestController extends Controller
{

    public function index($type, $status)
    {
        switch (auth()->user()->level) {
            case 'manager':
                $data = Rfc::select('rfcs.id','customers.fullName','customers.cName','descGoods','dischargePort','rfcs.created_at','orders.id as ordre_id')->join('customers','customers.id','=','rfcs.customer_id')->join('orders','orders.rfc','=','rfcs.id')->where('rfcs.status','=',$status)->where('rfcs.requestType','=',$type)->get();
                break;
            case 'supervisor':
                $data = Rfc::select('rfcs.id','customers.fullName','customers.cName','descGoods','dischargePort','rfcs.created_at','orders.id as ordre_id')->join('customers','customers.id','=','rfcs.customer_id')->join('orders','orders.rfc','=','rfcs.id')->where('rfcs.status','=',$status)->where('rfcs.requestType','=',$type)->get();
                break;
            case 'expert':
                $data = Rfc::select('rfcs.id','customers.fullName','customers.cName','descGoods','dischargePort','rfcs.created_at','orders.id as ordre_id')->join('customers','customers.id','=','rfcs.customer_id')->join('orders','orders.rfc','=','rfcs.id')->where('rfcs.status','=',$status)->where('rfcs.requestType','=',$type)->where('rfcs.dischargePort','=',Auth()->user()->branch)->get();
                break;
        }

        if (request()->ajax()) {
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('customer', function ($row) {
                    return $row->fullName.' - '.$row->cName;
                })
                ->addColumn('actions', function ($row) {
                    $btn = '
                    <a href="/request/showrfc/' . $row->ordre_id . '" class="btn btn-warning btn-xs">OPEN Profile</a>
                    ';
                    return $btn;
                })
                ->rawColumns(['actions','customer'])
                ->make(true);
        }
        return view('inspection::request.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create($slug=null, Request $request=null)
    {
        if($slug === null)
        {
            return view('inspection::request.searchCustomer');
        }
        else
        {
            $customer = Customer::find($slug);
            if(Auth()->user()->branch == 'tehran') {
                $coordinators = User::where('level','=','expert')->get();
            }
            else{
                $coordinators = User::where('level','=','expert')->where('branch', '=', Auth()->user()->branch)->get();
            }
            return view('inspection::request.create', ['customer' => $customer, 'coordinators' => $coordinators]);
        }

    }

    public function createrft($slug=null, Request $request=null)
    {
        if($slug === null)
        {
            return view('inspection::request.searchCustomer');
        }
        else
        {
            $customer = Customer::find($slug);
            if(Auth()->user()->branch == 'tehran') {
                $coordinators = User::where('level','=','expert')->get();
            }
            else{
                $coordinators = User::where('level','=','expert')->where('branch', '=', Auth()->user()->branch)->get();
            }
            return view('inspection::request.createrft', ['customer' => $customer, 'coordinators' => $coordinators]);
        }

    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store($slug, Request $request)
    {

        $rfc = new Rfc();
        $rfc->fill($request->all());
        $rfc->customer_id = $slug;
        $rfc->user_id = Auth()->user()->id;
        $rfc->ip = $request->ip();
        $rfc->save();

        $input = $request->all();

        $order = new Order();
        $order->customer_id = $slug;
        $order->exporter = $input['exporterName'];
        $order->desc = $input['descGoods'];
        $order->service = $input['requestType'];
        $order->piNo = $input['piNo'];
        $order->country_origin = $input['loadingPort'];
        $order->container = $input['containerCount'];
        $order->shipmentMethod = $input['shipmentMode'];
        $order->shipmentType = $input['transportMode'];
        $order->border = $input['dischargePort'];
        $order->user_id = auth()->user()->id;
        $order->branch = auth()->user()->branch;
        $order->technicalStatus = 0;
        $order->financialStatus = 0;
        $order->rfc = $rfc->id;
        $order->rft = null;
        $order->ip = request()->ip();
        $order->save();
        $order->tracking_no = $order->service.'/'.date('y').'/000'.$order->id;
        $order->save();


        return redirect(route('request.showrfc',$order->id));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function showrfc($id)
    {
        $order = Order::find($id);
        $request = Rfc::find($order->rfc);
        return view('inspection::inspection.show', ['request' => $request, 'order' =>$order]);
    }

    public function showrft($id)
    {
        $rft = Rft::find($id);
        $samples = RftSamples::where('rft_id',$id)->get();
        return view('inspection::inspection.showrft', ['rft' => $rft, 'samples' => $samples]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $order = Request::find($id);
        if(Auth()->user()->branch == 'tehran') {
            $coordinators = User::where('level','=','expert')->get();
        }
        else{
            $coordinators = User::where('level','=','expert')->where('branch', '=', Auth()->user()->branch)->get();
        }
        return view('inspection::request.edit', ['order' => $order, 'coordinators' => $coordinators]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $slug)
    {
        $input = $request->all();
        $order = Request::find($slug);

        $order->exporter = $input['exporter'];
        $order->desc = $input['desc'];
        $order->service = $input['service'];
        $order->piNo = $input['piNo'];
        $order->country_origin = $input['country_origin'];
        $order->container = $input['container'];
        $order->shipmentMethod = $input['shipmentMethod'];
        $order->shipmentType = $input['shipmentType'];
        $order->border = $input['border'];
        $order->ip = request()->ip();
        $order->save();

        return redirect(route('inspection.show', $order->id));
    }

    public function continue(Request $request, $slug)
    {
        $input = $request->all();
        $order = Request::find($slug);

        $order->invoiceValue = $input['invoiceValue'];
        if($input['status'] == 'COC') {
            $order->technicalStatus = 1;
        } elseif ( $input['status'] == 'NCR') {
            $order->technicalStatus = 2;
        }
        $order->save();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $order = Request::find($id)->delete();
    }

    public function searchResult(Request $request)
    {
        $searchkey = $request->searchkey;
        $customers = Customer::where('fullName','like','%'.$searchkey.'%')->where('branch',Auth()->user()->branch)->orWhere('cName','like','%'.$searchkey.'%')->where('branch',Auth()->user()->branch)->orWhere('email','like','%'.$searchkey.'%')->where('branch',Auth()->user()->branch)->orWhere('mobile','like','%'.$searchkey.'%')->where('branch',Auth()->user()->branch)->get();
        return view('inspection::request.searchCustomer', ['customers' => $customers]);
    }

}
