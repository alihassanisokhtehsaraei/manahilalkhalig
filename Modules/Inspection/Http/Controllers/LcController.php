<?php

namespace Modules\Inspection\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Lc;
use App\Models\LcGood;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
class LcController extends Controller
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
        $order = Order::find($id);
        $lc = Lc::where('order_id', $id)->first();
        $customer = Customer::find($order->customerID);
        return view('inspection::lc.show', ['order' => $order, 'customer' => $customer, 'lc'=>$lc]);
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
        $lc = Lc::where('order_id', $id)->first();
        $order = Order::where('id', $id)->first();

        $requestData = $request->all();
        $requestData['user_id'] = auth()->user()->id;
        if ($lc) {
            // If the record already exists, update it
            $lc->update($requestData);
        } else {
            // If the record doesn't exist, create a new one
            $requestData['order_id'] = $id; // Set the order_id received from parameter
            $requestData['signee'] = 'علیرضا توکلی';
            $requestData['position'] = 'مدیر عامل';
            $requestData['status'] = '0';
            $requestData['customer_id'] = $order['customerID'];
            Lc::create($requestData);
        }

        $order->piNo = $requestData['piNo'];
        $order->lcNo = $requestData['lcNo'];
        $order->save();

        return redirect(route('lc.goods', $id));
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

    public function goods($id)
    {
        $order = Order::find($id);
        $lc = Lc::where('order_id', $id)->first();
        $customer = Customer::find($order->customerID);
        $lcGoods = LcGood::where('lc_id', '=', $lc->id)->get();
        return view('inspection::lc.goods', ['order' => $order, 'customer' => $customer, 'lc'=>$lc, 'lcGoods' => $lcGoods]);
    }

    public function goodsStore(Request $request, $id)
    {
        $lc = Lc::where('order_id', $id)->first();
        $data = $request->all();


        $lc->goodsDescOp1 = (empty($data['goodsDescOp1'])) ? 'off' : 'on';
        $lc->goodsDescOp2 = (empty($data['goodsDescOp2'])) ? 'off' : 'on';
        $lc->goodsDescOp3 = (empty($data['goodsDescOp3'])) ? 'off' : 'on';
        $lc->goodsDescOp4 = (empty($data['goodsDescOp4'])) ? 'off' : 'on';
        $lc->goodsDescOp5 = (empty($data['goodsDescOp5'])) ? 'off' : 'on';
        $lc->goodsDescOp6 = (empty($data['goodsDescOp6'])) ? 'off' : 'on';
        $lc->save();

        if(!empty($data['desc'])){
            $good = new LcGood();
            $good->desc = $data['desc'];
            $good->orderedQuantity = $data['orderedQuantity'];
            $good->receivedQuantity = $data['receivedQuantity'];
            $good->lc_id = $lc->id;
            $good->user_id = auth()->user()->id;
            $good->ip = $request->ip();
            $good->save();
        }

        return back();
    }

    public function editGoods($id)
    {
        $good = LcGood::find($id);
        return view('inspection::lc.updateGoods', ['lcGood' => $good]);
    }
    public function updateGoods(Request $request, $id)
    {
        $data = $request->all();
        $good = LcGood::find($id);
        $lc = Lc::find($good->lc_id);

        $good->desc = $data['desc'];
        $good->orderedQuantity = $data['orderedQuantity'];
        $good->receivedQuantity = $data['receivedQuantity'];
        $good->user_id = auth()->user()->id;
        $good->save();

        return redirect(route('lc.goods', $lc->order_id));

    }

    public function changeStatus(Request $request, $id)
    {
        $lc = Lc::where('order_id','=',$id)->first();
        $order = Order::find($id);

        switch ($request->input('status')) {
            case 0:
                $lc->status = '0';
                break;
            case 1:
                $lc->status = '1';
                break;
            case 2:
                $lc->status = '2';
                $lc->reviewer_id = Auth()->user()->id;
                $lc->reviewDate = date('Y-m-d');
                break;
            case 3:
                $lc->status = '3';
                $lc->reviewer_id = Auth()->user()->id;
                $lc->reviewDate = date('Y-m-d');
                $lc->certNo = app()->call('Modules\Inspection\Http\Controllers\CertificateCounterController@certCounter', ['certType'=>'lc','branch' => $order->branch, 'user' => Auth()->user()->id, 'order' => $id]);
                break;
        }
        $lc->paper = $request->input('paper');
        $lc->save();

        return back();
    }
    public function destroyGoods($id)
    {
        $goods = LcGood::find($id)->delete();
        return back();
    }
}
