<?php

namespace Modules\Inspection\Http\Controllers;

use App\Models\Ncr;
use App\Models\NcrGood;
use App\Models\Order;
use App\Models\Customer;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class NCRController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        switch (auth()->user()->sector) {
//            case 'management':
//            case 'cosqc':
//                $data = Order::select('orders.tracking_no','orders.id','customers.fullName','customers.cName','orders.desc','orders.service','orders.technicalStatus','orders.financialStatus','orders.branch','ncrs.certNo')->join('customers','customers.id','=','orders.customer_id')->join('ncrs','ncrs.order_id','=','orders.id')->where('technicalStatus','=',6)->get();
//                break;
//            case 'branch':
//                $data = Order::select('orders.tracking_no','orders.id','customers.fullName','customers.cName','orders.desc','orders.service','orders.technicalStatus','orders.financialStatus','orders.branch','ncrs.certNo')->join('customers','customers.id','=','orders.customer_id')->join('ncrs','ncrs.order_id','=','orders.id')->where('technicalStatus','=',6)->where('orders.branch',auth()->user()->branch)->get();
//                break;


            case 'universal':
                $data = Order::select('orders.tracking_no','orders.id','customers.fullName','customers.cName','orders.desc','orders.service','orders.technicalStatus','orders.financialStatus','orders.branch','ncrs.certNo')->join('customers','customers.id','=','orders.customer_id')->join('ncrs','ncrs.order_id','=','orders.id')->where('technicalStatus','=',6)->get();
                break;
            case 'branch':
                $data = Order::select('orders.tracking_no','orders.id','customers.fullName','customers.cName','orders.desc','orders.service','orders.technicalStatus','orders.financialStatus','orders.branch','ncrs.certNo')->join('customers','customers.id','=','orders.customer_id')->join('ncrs','ncrs.order_id','=','orders.id')->where('technicalStatus','=',6)->where('orders.branch',auth()->user()->branch)->get();
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
                            $btn = $btn.' / <a class="btn btn-xs btn-info"> New </a>';
                            break;
                        case 1:
                            $btn = $btn.' / <a class="btn btn-xs btn-info"> New </a>';
                            break;
                        case 2:
                            $btn = $btn.' / <a class="btn btn-xs btn-warning">Rejected </a>';
                            break;
                        case 3:
                            $btn = $btn.' / <a class="btn btn-xs btn-primary">Approved </a>';
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

                    if(Auth()->user()->sector == 'management' or $row->technicalStatus < 5) {
                        $btn = $btn . ' <a href="/order/edit/' . $row->id . '" class="btn btn-secondary btn-xs">EDIT</a>
                    <a class="btn btn-danger btn-xs" id="sweet-' . $row->id . '" type="button" onclick="_gaq.push([\'_trackEvent\', \'example\', \'try\', \'sweet-' . $row->id . '\']);">DELETE</a>
    <script>
        var SweetAlert_custom = {
            init: function() {

                document.querySelector("#sweet-' . $row->id . '").onclick = function(){
                    swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this customer, all other related information will be deleted too!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                        .then((willDelete) => {
                            if (willDelete) {
                                     $.ajax({
                                         url: \'destroy/' . $row->id . '\',
                                         type: \'get\',
                                         dataType: \'json\'
                                      });

                                    swal("Customer Deleted!", {
                                        icon: "success",
                                    });

                                $(\'#customers-datatable\').DataTable().ajax.reload();
                            } else {
                                swal("Your file is safe!");
                            }
                        })
                }
                ;

            }
        };
        (function($) {
            SweetAlert_custom.init()
        })(jQuery);
    </script>
                    '; }

                    return $btn;
                })
                ->rawColumns(['actions','customer','status'])
                ->make(true);
        }
        return view('inspection::ncr.index');
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
        $ncr = Ncr::where('order_id', $id)->first();
        $order = Order::find($id);

        if ($ncr) {
            // COI already exists, update it
            $ncr->fill($request->all());
            $ncr->save();

            $order->piNo = $request->input('invNo');
            $order->save();

            $message = 'NCR updated successfully';
        } else {
            // COI does not exist, insert it as a new record


            $order->piNo = $request->input('invNo');
            $order->save();

            $ncr = new Ncr();
            $ncr->fill($request->all());
            $ncr->order_id = $id;
            $ncr->user_id = Auth()->user()->id;
            $ncr->ip = $request->ip();
            $ncr->save();
            $message = 'COC created successfully';
        }

        return redirect()->route('ncr.Goods', $id)->with('message', $message);

    }

    public function Goods($id)
    {
        $order = Order::find($id);
        $customer = Customer::find($order->customer_id);
        $ncr = Ncr::where('order_id', '=', $id)->first();
//        ($order->technicalStatus > 4 and Auth()->user()->sector != 'management' and auth()->user()->level != 'technical')
        if($order->technicalStatus > 4 and (auth()->user()->department == 'inspection' or auth()->user()->department == 'management') and auth()->user()->level=='manager')
        {
            $disabled = null;
        } else {
            $disabled = 'readonly';
        }

        $goods = NcrGood::where('ncr_id', '=', $ncr->id)->get();
        return view('inspection::ncr.goods', ['order' => $order, 'customer' => $customer, 'ncr'=>$ncr, 'goods'=>$goods, 'disabled' => $disabled]);
    }

    public function storeGoods(Request $request, $id)
    {
        $ncr = Ncr::find($id);
        $good = new NcrGood();
        $good->fill($request->all());
        $good->ncr_id = $ncr->id;
        $good->user_id = Auth()->user()->id;
        $good->ip = $request->ip();
        $good->save();
        $message = "Item '{$good->desc}' added successfully.";
        return back()->with('message', $message);
    }

    public function editGoods($id)
    {
        $ncrgood = NcrGood::find($id);
        $ncr = Ncr::find($ncrgood->ncr_id);
        return view('inspection::ncr.updategoods', ['ncr'=>$ncr, 'ncrgood'=>$ncrgood]);
    }

    public function updateGoods(Request $request, $id)
    {
        $good = NcrGood::find($id);
        $good->fill($request->all());
        $good->save();
        $message = "Item '{$good->desc}' modified successfully.";
        return redirect()->route('ncr.Goods', $good->ncr->order_id)->with('message', $message);
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
        $ncr = Ncr::where('order_id', '=', $id)->first();

//        if($order->technicalStatus > 4 and Auth()->user()->sector != 'management' and auth()->user()->level != 'technical')
//        {
//            $disabled = 'readonly';
//        } else {
//            $disabled = null;
//        }
        if($order->technicalStatus > 4 and (auth()->user()->department == 'inspection' or auth()->user()->department == 'management') and auth()->user()->level=='manager')
        {
            $disabled = null;
        } else {
            $disabled = 'readonly';
        }

        // @if(isset($order->technicalStatus) && $order->technicalStatus > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif

        return view('inspection::ncr.show', ['order' => $order, 'customer' => $customer, 'ncr'=>$ncr, 'disabled' => $disabled]);
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
        $goods = NcrGood::find($id)->delete();
        return back();
    }

    public function changeTechnicalStatus(Request $request, $id) {
        $input = $request->all();
        $order = Order::find($id);
        $ncr = Ncr::where('order_id', $id)->first();
        $order->technicalStatus = $input['status'];
        $order->save();
        if($input['status'] == 6 && is_null($ncr->certNo)) {
            // Generate the new certNo based on maximum existing values
            $newCertNo = $this->getNewCertNo();
            // Assign the new certificate number
            $ncr->certNo = $newCertNo;
            $ncr->issuingDate = date('Y-m-d');
            $ncr->save();
        }

        return back();
    }

    private function getNewCertNo() {
        // Get the maximum existing certNo from Ncr
        $maxCertNo = Ncr::max('certNo');

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
        return 'ART/NCR/' . str_pad($newCertNo, 6, '0', STR_PAD_LEFT);
    }

}
