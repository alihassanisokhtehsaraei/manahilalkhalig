<?php

namespace Modules\Search\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Coc;
use App\Models\Ncr;
use App\Models\Order;
use App\Models\Rd;


class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('search::search');
    }

    public function result(Request $request)
    {
        $input = $request->all();
        switch ($input['key']) {
            case 'order':
                $data = Order::where('tracking_no','like','%'.$input['value'].'%')->get();
                break;
            case 'coc':
                $data = Order::join('cocs', 'cocs.order_id','=','orders.id')->where('certNo','like','%'.$input['value'].'%')->get();
                break;
            case 'ncr':
                $data = Order::join('ncrs', 'ncrs.order_id','=','orders.id')->where('certNo','like','%'.$input['value'].'%')->get();
                break;
            case 'rd':
                $data = Order::where('tracking_no','like','%'.$input['value'].'%')->get();
                break;
            case 'nrd':
                $data = Order::where('tracking_no','like','%'.$input['value'].'%')->get();
                break;
            case 'pi':
                $data = Order::where('tracking_no','like','%'.$input['value'].'%')->get();
                break;
        }
        return view('search::search', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('search::create');
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
        return view('search::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('search::edit');
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
