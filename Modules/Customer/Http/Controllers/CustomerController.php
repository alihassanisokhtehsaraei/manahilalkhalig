<?php

namespace Modules\Customer\Http\Controllers;

use Auth;
use Session;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {

//    if (auth()->user()->sector == 'management' || auth()->user()->level == 'manager') {
//        $query = Customer::select('id', 'fullName', 'cName', 'tel', 'email')->get();
//    } elseif(auth()->user()->level == 'branch') {
//        $query = Customer::select('id', 'fullName', 'cName', 'tel', 'email')->where('branch', '=', auth()->user()->branch)->get();
//    }

        switch (Auth::user()->sector) {
            case 'universal':
                $query = Customer::select('id', 'fullName', 'cName', 'tel', 'email')->get();
                break;
            case 'branch':
                $query = Customer::select('id', 'fullName', 'cName', 'tel', 'email')->where('branch', '=', auth()->user()->branch)->get();
                break;
        }



        //print_r($data);


        if (request()->ajax()) {
            return datatables()->of($query)
                ->addIndexColumn()
                ->addColumn('actions', function ($row) {
                    $btn = '
                    <a href="/customer/show/' . $row->id . '" class="btn btn-primary btn-xs">OPEN</a>
                    <a href="/customer/edit/' . $row->id . '" class="btn btn-secondary btn-xs">EDIT</a>';

                    return $btn;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('customer::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('customer::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'fName' => 'required',
        ]);

        $input = $request->all();

        $Customer = new customer;
        $Customer->fullName = $input['fName'] . ' ' . $input['lName'];
        $Customer->cName = $input['cName'];
        $Customer->email = $input['email'];
        $Customer->tel = $input['tel'];
        $Customer->mobile = $input['mobile'];
        $Customer->country = $input['country'];
        $Customer->stateCity = $input['stateCity'];
        $Customer->address = $input['address'];
        $Customer->creator = auth()->user()->id;
        $Customer->branch = auth()->user()->branch;
        $Customer->ip = $request->ip();
        $Customer->save();

        $request->session()->flash('status', 'yes');
        //echo  $Customer->id;
        return redirect()->route('customer.show', [$Customer]);
        //echo '<pre>';
        //print_r($Customer);
        //echo '</pre>';

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(customer $slug, Request $request)
    {
        $id = $slug['id'];
        $customer = customer::find($id);
        $orders = Order::where('customer_id',$id)->orderBy('created_at', 'desc')->take(5)->get();
        $totalOrders = Order::where('customer_id', $id)->count();

        $totalCoc = Order::where('customer_id', $id)->where('technicalStatus',5)
            ->withCount('coc') // Count related COCs
            ->get()
            ->sum('coc_count'); // Sum the counts

        $totalNcr = Order::where('customer_id', $id)->where('technicalStatus',6)
            ->withCount('ncr') // Count related NCRs
            ->get()
            ->sum('ncr_count'); // Sum the counts
        return view('customer::show', ['request' => $request, 'customer' => $customer, 'orders' => $orders, 'totalOrders' => $totalOrders, 'totalCoc' => $totalCoc, 'totalNcr' => $totalNcr]);


    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($slug, Request $request)
    {
        $customer = customer::find($slug);
        return view('customer::edit', ['request' => $request, 'customer' => $customer]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $slug)
    {
        $Customer = customer::find($slug);
        $input = $request->all();

        $Customer->fullName = $input['fullname'];
        $Customer->cName = $input['cName'];
        $Customer->email = $input['email'];
        $Customer->tel = $input['tel'];
        $Customer->mobile = $input['mobile'];
        $Customer->country = $input['country'];
        $Customer->stateCity = $input['stateCity'];
        $Customer->address = $input['address'];
        $Customer->save();

        return redirect()->route('customer.show', ['slug' => $slug]);
    }


    public function destroy($slug)
    {
        $customer = customer::find($slug)->delete();
    }

    /*
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */


}
