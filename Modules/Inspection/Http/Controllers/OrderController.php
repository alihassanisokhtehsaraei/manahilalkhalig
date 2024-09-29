<?php

namespace Modules\Inspection\Http\Controllers;

use App\Models\Rft;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Controllers\GlobalCounterController;
use App\Models\Customer;
use App\Models\GlobalCounter;
use App\Models\Order;
use App\Models\User;
use App\Models\Inspector;
use Auth;
use Session;
class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        switch (auth()->user()->sector) {
            case 'management':
                $data = Order::select('orders.tracking_no','orders.id','customers.fullName','customers.cName','orders.desc','orders.service','orders.technicalStatus','orders.financialStatus','orders.branch')->join('customers','customers.id','=','orders.customer_id')->where('technicalStatus','<',5)->get();
                break;
            case 'branch':
                $data = Order::select('orders.tracking_no','orders.id','customers.fullName','customers.cName','orders.desc','orders.service','orders.technicalStatus','orders.financialStatus','orders.branch')->join('customers','customers.id','=','orders.customer_id')->where('technicalStatus','<',5)->where('orders.branch',auth()->user()->branch)->get();
                break;
        }
        //print_r($data);

        if (request()->ajax()) {
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    switch ($row->technicalStatus) {
                        case 0:
                            $btn = '<a class="btn btn-xs btn-primary"> New </a>';
                            break;
                        case 1:
                            $btn = '<a class="btn btn-xs btn-primary"> COC Draft </a>';
                            break;
                        case 2:
                            $btn = '<a class="btn btn-xs btn-warning"> NCR Draft </a>';
                            break;
                        case 3:
                            $btn = '<a class="btn btn-xs btn-danger"> COC Rejected </a>';
                            break;
                        case 4:
                            $btn = '<a class="btn btn-xs btn-danger"> NCR Rejected </a>';
                            break;
                        case 5:
                            $btn = '<a class="btn btn-xs btn-primary"> COC Approved </a>';
                            break;
                        case 6:
                            $btn = '<a class="btn btn-xs btn-warning"> NCR Approved </a>';
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
                    <a href="/inspection/show/' . $row->id . '" class="btn btn-primary btn-xs">OPEN</a>
                    <a href="/order/edit/' . $row->id . '" class="btn btn-secondary btn-xs">EDIT</a>';
                    if(Auth()->user()->sector == 'management' or $row->technicialStatus < 5) {
                        $btn = $btn . '
                    <a class="btn btn-danger btn-xs" id="sweet-' . $row->id . '" type="button" onclick="_gaq.push([\'_trackEvent\', \'example\', \'try\', \'sweet-' . $row->id . '\']);">DELETE</a>
    <script>
        var SweetAlert_custom = {
            init: function() {

                document.querySelector("#sweet-' . $row->id . '").onclick = function(){
                    swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this file, all other related information will be deleted too!",
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
        return view('inspection::order.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create($slug=null, Request $request=null)
    {
        $countries = json_decode(file_get_contents(storage_path('countries.json')));
        if($slug === null)
        {
            return view('inspection::order.searchCustomer');
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
            return view('inspection::order.create', ['customer' => $customer, 'coordinators' => $coordinators,'countries' => $countries]);
        }

    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store($slug, Request $request)
    {

        $input = $request->all();


        $order = new Order();
        $order->customer_id = $slug;
        $order->exporter = $input['exporter'];
        $order->desc = $input['desc'];
        $order->service = $input['service'];
        $order->piNo = $input['piNo'];
        $order->country_origin = $input['country_origin'];
        $order->container = $input['container'];
        $order->shipmentMethod = $input['shipmentMethod'];
        $order->shipmentType = $input['shipmentType'];
        $order->border = $input['border'];
        $order->category = $input['category'];
        $order->user_id = auth()->user()->id;
        $order->branch = auth()->user()->branch;
        $order->technicalStatus = 0;
        $order->financialStatus = 0;
        $order->ip = request()->ip();
        $order->save();
        $order->tracking_no = 'RFI/'.date('Y').'/000'.$order->id;
        $order->save();

        return redirect(route('inspection.show', $order->id));
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
        $order = Order::find($id);
        if($order->technicalStatus > 4 and Auth()->user()->sector != 'management' and Auth()->user()->level != 'technical')
        {
            $disabled = 'readonly';
        } else {
            $disabled = null;
        }

        if(Auth()->user()->branch == 'tehran') {
            $coordinators = User::where('level','=','expert')->get();
        }
        else{
            $coordinators = User::where('level','=','expert')->where('branch', '=', Auth()->user()->branch)->get();
        }
        return view('inspection::order.edit', ['order' => $order, 'coordinators' => $coordinators, 'disabled' => $disabled]);
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
        $order = Order::find($slug);

        $order->exporter = $input['exporter'];
        $order->desc = $input['desc'];
        $order->service = $input['service'];
        $order->piNo = $input['piNo'];
        $order->country_origin = $input['country_origin'];
        $order->container = $input['container'];
        $order->shipmentMethod = $input['shipmentMethod'];
        $order->shipmentType = $input['shipmentType'];
        $order->border = $input['border'];
        $order->category = $input['category'];
        $order->ip = request()->ip();
        $order->save();

        return redirect(route('inspection.show', $order->id));
    }

    public function continue(Request $request, $slug)
    {
        $input = $request->all();
        $order = Order::find($slug);

        $order->invoiceValue = $input['invoiceValue'];
        if($input['status'] == 'COC') {
            $order->technicalStatus = 1;
        } elseif ( $input['status'] == 'NCR') {
            $order->technicalStatus = 2;
        }
        $order->save();
        return back();
    }
    public function updateStatus(Request $request, $slug)
    {
        $order = Order::find($slug);
        $order->technicalStatus = $request['status'];
        $order->save();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */

    public function sampling($id)
    {
        $order = Order::find($id);
        $rft = Rft::where('order_id', $id)->first();
        if($order->technicalStatus > 4 and Auth()->user()->sector != 'management' and Auth()->user()->level != 'technical')
        {
            $disabled = 'readonly';
        } else {
            $disabled = null;
        }
        return view('inspection::inspection.sampling', ['rft' => $rft, 'order' => $order, 'disabled' => $disabled]);
    }

    public function sampleUpdate(Request $request, $id)
    {
        $rft = Rft::where('order_id', $id)->first();
        $order = Order::find($id);

        if ($rft) {
            // RFT already exists, update it
            $rft->fill($request->all());
            $rft->order_id = $id;
            $rft->user_id = Auth()->user()->id;
            $rft->customer_id = $order->customer_id;
            $rft->save();
        } else {
            $rft = new Rft();
            $rft->fill($request->all());
            $rft->order_id = $id;
            $rft->user_id = Auth()->user()->id;
            $rft->customer_id = $order->customer_id;
            $rft->ip = $request->ip();
            $rft->save();
        }

        return redirect()->route('rft.edit', $rft->id);
    }

    public function destroy($id)
    {
        $order = Order::find($id)->delete();
    }

    public function searchResult(Request $request)
    {
        $searchkey = $request->searchkey;
        switch (Auth()->user()->sector) {
            case 'management':
                $customers = Customer::where('fullName','like','%'.$searchkey.'%')->orWhere('cName','like','%'.$searchkey.'%')->orWhere('email','like','%'.$searchkey.'%')->orWhere('mobile','like','%'.$searchkey.'%')->get();
                break;
            case 'branch':
                $customers = Customer::where('fullName','like','%'.$searchkey.'%')->where('branch',Auth()->user()->branch)->orWhere('cName','like','%'.$searchkey.'%')->where('branch',Auth()->user()->branch)->orWhere('email','like','%'.$searchkey.'%')->where('branch',Auth()->user()->branch)->orWhere('mobile','like','%'.$searchkey.'%')->where('branch',Auth()->user()->branch)->get();
                break;
        }
        return view('inspection::order.searchCustomer', ['customers' => $customers]);
    }
}
