<?php

namespace Modules\Inspection\Http\Controllers;

use App\Imports\CocGoodsImport;
use App\Models\Coc;
use App\Models\CocGood;
use App\Models\Order;
use App\Models\Customer;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Maatwebsite\Excel\Facades\Excel;

class CocController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        switch (auth()->user()->sector) {
//            case 'management':
            case 'universal':
                $data = Order::select('orders.tracking_no','orders.id','customers.fullName','customers.cName','orders.desc','orders.service','orders.technicalStatus','orders.financialStatus','orders.branch','cocs.certNo')->join('customers','customers.id','=','orders.customer_id')->join('cocs','cocs.order_id','=','orders.id')->where('technicalStatus','=',5)->get();
                break;
            case 'branch':
                $data = Order::select('orders.tracking_no','orders.id','customers.fullName','customers.cName','orders.desc','orders.service','orders.technicalStatus','orders.financialStatus','orders.branch','cocs.certNo')->join('customers','customers.id','=','orders.customer_id')->join('cocs','cocs.order_id','=','orders.id')->where('technicalStatus','=',5)->where('orders.branch',auth()->user()->branch)->get();
                break;
        }
        //print_r($data);

        if (request()->ajax()) {
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    switch ($row->technicalStatus) {
                        case 0:
                            $btn = '<a class="btn btn-xs btn-primary">New</a>';
                            break;
                        case 1:
                            $btn = '<a class="btn btn-xs btn-primary">COC Draft</a>';
                            break;
                        case 2:
                            $btn = '<a class="btn btn-xs btn-warning">NCR Draft</a>';
                            break;
                        case 3:
                            $btn = '<a class="btn btn-xs btn-danger">COC Rejected</a>';
                            break;
                        case 4:
                            $btn = '<a class="btn btn-xs btn-danger">NCR Rejected</a>';
                            break;
                        case 5:
                            $btn = '<a class="btn btn-xs btn-primary">COC Approved</a>';
                            break;
                        case 6:
                            $btn = '<a class="btn btn-xs btn-warning">NCR Approved</a>';
                            break;
                    }

                    switch ($row->financialStatus) {
                        case 0:
                            $btn = $btn.' / <a class="btn btn-xs btn-info"> FIN New </a>';
                            break;
                        case 1:
                            $btn = $btn.' / <a class="btn btn-xs btn-info"> FIN New </a>';
                            break;
                        case 2:
                            $btn = $btn.' / <a class="btn btn-xs btn-warning"> FIN Rejected </a>';
                            break;
                        case 3:
                            $btn = $btn.' / <a class="btn btn-xs btn-primary"> FIN Approved </a>';
                            break;
                    }
                    return $btn;
                })
                ->addColumn('customer', function ($row) {
                    return $row->fullName.' - '.$row->cName;
                })
                ->addColumn('actions', function ($row) {
                    $btn = '
                    <a href="/inspection/show/' . $row->id . '" class="btn btn-primary btn-xs">OPEN</a>';

                    if(Auth()->user()->level == 'technical' or Auth()->user()->level == 'manager' or $row->technicalStatus < 5) {
                        $btn = $btn . ' <a href="/order/edit/' . $row->id . '" class="btn btn-secondary btn-xs">EDIT</a>'; }

                    return $btn;
                })
                ->rawColumns(['actions','customer','status'])
                ->make(true);
        }
        return view('inspection::coc.index');
    }

    public function archive()
    {
        switch (auth()->user()->sector) {
//            case 'management':
//            case 'cosqc':
//                $data = Order::select('orders.tracking_no','orders.id','customers.fullName','customers.cName','orders.desc','orders.service','orders.technicalStatus','orders.financialStatus','orders.branch','cocs.certNo')->join('customers','customers.id','=','orders.customer_id')->join('cocs','cocs.order_id','=','orders.id')->where('technicalStatus','=',7)->get();
//                break;
//            case 'border':
//            case 'customs':
//                $data = Order::select('orders.tracking_no','orders.id','customers.fullName','customers.cName','orders.desc','orders.service','orders.technicalStatus','orders.financialStatus','orders.branch','cocs.certNo')->join('customers','customers.id','=','orders.customer_id')->join('cocs','cocs.order_id','=','orders.id')->where('technicalStatus','=',7)->where('orders.border',auth()->user()->branch)->get();
//                break;
//            case 'branch':
//                $data = Order::select('orders.tracking_no','orders.id','customers.fullName','customers.cName','orders.desc','orders.service','orders.technicalStatus','orders.financialStatus','orders.branch','cocs.certNo')->join('customers','customers.id','=','orders.customer_id')->join('cocs','cocs.order_id','=','orders.id')->where('technicalStatus','=',7)->where('orders.branch',auth()->user()->branch)->get();
//                break;


            case 'universal':
                $data = Order::select('orders.tracking_no','orders.id','customers.fullName','customers.cName','orders.desc','orders.service','orders.technicalStatus','orders.financialStatus','orders.branch','cocs.certNo')->join('customers','customers.id','=','orders.customer_id')->join('cocs','cocs.order_id','=','orders.id')->where('technicalStatus','=',7)->get();
                break;
            case 'branch':
                $data = Order::select('orders.tracking_no','orders.id','customers.fullName','customers.cName','orders.desc','orders.service','orders.technicalStatus','orders.financialStatus','orders.branch','cocs.certNo')->join('customers','customers.id','=','orders.customer_id')->join('cocs','cocs.order_id','=','orders.id')->where('technicalStatus','=',7)->where('orders.branch',auth()->user()->branch)->get();
                break;
        }
        //print_r($data);

        if (request()->ajax()) {
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    switch ($row->technicalStatus) {
                        case 0:
                            $btn = '<a class="btn btn-xs btn-primary">New</a>';
                            break;
                        case 1:
                            $btn = '<a class="btn btn-xs btn-primary">COC Draft</a>';
                            break;
                        case 2:
                            $btn = '<a class="btn btn-xs btn-warning">NCR Draft</a>';
                            break;
                        case 3:
                            $btn = '<a class="btn btn-xs btn-danger">COC Rejected</a>';
                            break;
                        case 4:
                            $btn = '<a class="btn btn-xs btn-danger">NCR Rejected</a>';
                            break;
                        case 5:
                            $btn = '<a class="btn btn-xs btn-primary">COC Approved</a>';
                            break;
                        case 6:
                            $btn = '<a class="btn btn-xs btn-warning">NCR Approved</a>';
                            break;
                        case 7:
                            $btn = '<a class="btn btn-xs btn-primary">Archive</a>';
                            break;
                    }

                    switch ($row->financialStatus) {
                        case 0:
                            $btn = $btn.' / <a class="btn btn-xs btn-info"> FIN New </a>';
                            break;
                        case 1:
                            $btn = $btn.' / <a class="btn btn-xs btn-info"> FIN New </a>';
                            break;
                        case 2:
                            $btn = $btn.' / <a class="btn btn-xs btn-warning"> FIN Rejected </a>';
                            break;
                        case 3:
                            $btn = $btn.' / <a class="btn btn-xs btn-primary"> FIN Approved </a>';
                            break;
                    }
                    return $btn;
                })
                ->addColumn('customer', function ($row) {
                    return $row->fullName.' - '.$row->cName;
                })
                ->addColumn('actions', function ($row) {
                    $btn = '<a href="/inspection/show/' . $row->id . '" class="btn btn-primary btn-xs">OPEN</a>';
                    return $btn;
                })
                ->rawColumns(['actions','customer','status'])
                ->make(true);
        }
        return view('inspection::coc.archive');
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
    public function store(Request $request, $id)
    {
        $coc = Coc::where('order_id', $id)->first();
        $order = Order::find($id);

        if ($coc) {
            // COI already exists, update it
            $coc->fill($request->all());
            $coc->save();

            $order->piNo = $request->input('invNo');
            $order->save();

            $message = 'COI updated successfully';
        } else {
            // COI does not exist, insert it as a new record


            $order->piNo = $request->input('invNo');
            $order->save();

            $coc = new Coc();
            $coc->fill($request->all());
            $coc->order_id = $id;
            $coc->user_id = Auth()->user()->id;
            $coc->ip = $request->ip();
            $coc->save();
            $message = 'COC created successfully';
        }

        return redirect()->route('coc.Goods', $id)->with('message', $message);

    }

    public function Goods($id)
    {
        $order = Order::find($id);
        $customer = Customer::find($order->customer_id);
        $coc = Coc::where('order_id', '=', $id)->first();
// ($order->technicalStatus > 4 and Auth()->user()->level != 'technical' and Auth()->user()->sector != 'management')
        if($order->technicalStatus > 4 and (auth()->user()->department == 'inspection' or auth()->user()->departmant == 'management') and auth()->user()->level=='manager')
        {
            $disabled = null;
        } else {
            $disabled ='readonly';
        }

        $goods = CocGood::where('coc_id', '=', $coc->id)->get();
        return view('inspection::coc.goods', ['order' => $order, 'customer' => $customer, 'coc'=>$coc, 'goods'=>$goods, 'disabled' => $disabled]);
    }

    public function storeGoods(Request $request, $id)
    {
        $coc = Coc::find($id);
        $good = new CocGood();
        $good->fill($request->all());
        $good->coc_id = $coc->id;
        $good->user_id = Auth()->user()->id;
        $good->ip = $request->ip();
        $good->save();
        $message = "Item '{$good->desc}' added successfully.";
        return back()->with('message', $message);
    }

    public function editGoods($id)
    {
        $cocgood = CocGood::find($id);
        $coc = Coc::find($cocgood->coc_id);
        return view('inspection::coc.updategoods', ['coc'=>$coc, 'cocgood'=>$cocgood]);
    }

    public function updateGoods(Request $request, $id)
    {
        $good = CocGood::find($id);
        $good->fill($request->all());
        $good->save();
        $message = "Item '{$good->desc}' modified successfully.";
        return redirect()->route('coc.Goods', $good->coc->order_id)->with('message', $message);
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
        $coc = Coc::where('order_id', '=', $id)->first();

//        if($order->technicalStatus > 4 and Auth()->user()->level != 'technical' and Auth()->user()->sector != 'management')
//        {
//            $disabled = 'readonly';
//        } else {
//            $disabled = null;
//        }

        if($order->technicalStatus > 4 and (auth()->user()->department == 'inspection' or auth()->user()->departmant == 'management') and auth()->user()->level=='manager')
        {
            $disabled = null;
        } else {
            $disabled ='readonly';
        }

        // @if(isset($order->technicalStatus) && $order->technicalStatus > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif

        return view('inspection::coc.show', ['order' => $order, 'customer' => $customer, 'coc'=>$coc, 'disabled' => $disabled]);
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


    public function destroyGoods($id)
    {
        $goods = CocGood::find($id)->delete();
        return back();
    }

    public function changeTechnicalStatus(Request $request, $id) {
        $input = $request->all();
        $order = Order::find($id);
        $coc = Coc::where('order_id', $id)->first();
        $order->technicalStatus = $input['status'];
        $order->save();
        if($input['status'] == 5 && is_null($coc->certNo) && $order->financialStatus == 3) {
            // Generate the new certNo based on maximum existing values
            $newCertNo = $this->getNewCertNo();
            // Assign the new certificate number
            $coc->certNo = $newCertNo;
            $coc->issuingDate = date('Y-m-d');
            $coc->save();
        }

        return back();
    }

    private function getNewCertNo() {
        // Get the maximum existing certNo from Ncr
        $maxCertNo = Coc::max('certNo');

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
        return 'ART/COC/' . str_pad($newCertNo, 6, '0', STR_PAD_LEFT);
    }

    public function downloadCocGood()
    {
        $filePath = storage_path('excels/imports/coc-goods.xlsx');
        return response()->download($filePath);
    }

    public function uploadCocGoods(Request $request,Coc $coc)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        // Assuming you have an import class for handling the file data
        Excel::import(new CocGoodsImport($coc), $request->file('file'));

        return redirect()->back()->with('message', 'COC goods uploaded successfully!');
    }
}
