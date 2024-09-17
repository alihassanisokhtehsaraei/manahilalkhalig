<?php

namespace Modules\Search\Http\Controllers;

use App\Models\Rft;
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

        $type='other';
        switch ($input['key']) {
            case 'order':
                switch (auth()->user()->sector) {
                    case 'management':
                        $data = Order::where('tracking_no','like','%'.$input['value'].'%')->get();
                        break;
                    case 'branch':
                        $data = Order::where('tracking_no','like','%'.$input['value'].'%')->where('branch',auth()->user->branch)->get();
                        break;
                    case 'cosqc':
                        $data = Order::where('tracking_no','like','%'.$input['value'].'%')->where('technicalStatus','=',7)->get();
                        break;
                    case 'border':
                        $data = Order::where('tracking_no','like','%'.$input['value'].'%')->where('technicalStatus','=',7)->where('border',auth()->user->branch)->get();
                        break;
                    case 'customs':
                        $data = Order::where('tracking_no','like','%'.$input['value'].'%')->where('technicalStatus','=',7)->where('border',auth()->user->branch)->get();
                        break;
                    case 'laboratory':
                        $data = null;
                        break;
                }
                break;
            case 'coc':
                switch (auth()->user()->sector) {
                    case 'management':
                        $data = Order::join('cocs','cocs.order_id', '=', 'orders.id')->where('cocs.certNo','like','%'.$input['value'].'%')->get();
                        break;
                    case 'branch':
                        $data = Order::join('cocs','cocs.order_id', '=', 'orders.id')->where('cocs.certNo','like','%'.$input['value'].'%')->where('branch',auth()->user->branch)->get();
                        break;
                    case 'cosqc':
                        $data = Order::join('cocs','cocs.order_id', '=', 'orders.id')->where('cocs.certNo','like','%'.$input['value'].'%')->where('technicalStatus','=',7)->get();
                        break;
                    case 'border':
                        $data = Order::join('cocs','cocs.order_id', '=', 'orders.id')->where('cocs.certNo','like','%'.$input['value'].'%')->where('technicalStatus','=',7)->where('border',auth()->user->branch)->get();
                        break;
                    case 'customs':
                        $data = Order::join('cocs','cocs.order_id', '=', 'orders.id')->where('cocs.certNo','like','%'.$input['value'].'%')->where('technicalStatus','=',7)->where('border',auth()->user->branch)->get();
                        break;
                    case 'laboratory':
                        $data = null;
                        break;
                }
                break;
            case 'ncr':
                switch (auth()->user()->sector) {
                    case 'management':
                        $data = Order::join('ncrs','ncrs.order_id', '=', 'orders.id')->where('ncrs.certNo','like','%'.$input['value'].'%')->get();
                        break;
                    case 'branch':
                        $data = Order::join('ncrs','ncrs.order_id', '=', 'orders.id')->where('ncrs.certNo','like','%'.$input['value'].'%')->where('branch',auth()->user->branch)->get();
                        break;
                    case 'cosqc':
                        $data = Order::join('ncrs','ncrs.order_id', '=', 'orders.id')->where('ncrs.certNo','like','%'.$input['value'].'%')->where('technicalStatus','=',7)->get();
                        break;
                    case 'border':
                        $data = Order::join('ncrs','ncrs.order_id', '=', 'orders.id')->where('ncrs.certNo','like','%'.$input['value'].'%')->where('technicalStatus','=',7)->where('border',auth()->user->branch)->get();
                        break;
                    case 'customs':
                        $data = Order::join('ncrs','ncrs.order_id', '=', 'orders.id')->where('ncrs.certNo','like','%'.$input['value'].'%')->where('technicalStatus','=',7)->where('border',auth()->user->branch)->get();
                        break;
                    case 'laboratory':
                        $data = null;
                        break;
                }
                break;
            case 'rd':
                switch (auth()->user()->sector) {
                    case 'management':
                        $data = Order::join('cocs','cocs.order_id', '=', 'orders.id')->join('release_documents','cocs.id', '=', 'release_documents.coc_id')->where('release_documents.document_number','like','%'.$input['value'].'%')->get();
                        break;
                    case 'branch':
                        $data = Order::join('cocs','cocs.order_id', '=', 'orders.id')->join('release_documents','cocs.id', '=', 'release_documents.coc_id')->where('release_documents.document_number','like','%'.$input['value'].'%')->where('branch',auth()->user->branch)->get();
                        break;
                    case 'cosqc':
                        $data = Order::join('cocs','cocs.order_id', '=', 'orders.id')->join('release_documents','cocs.id', '=', 'release_documents.coc_id')->where('release_documents.document_number','like','%'.$input['value'].'%')->where('technicalStatus','=',7)->get();
                        break;
                    case 'border':
                        $data = Order::join('cocs','cocs.order_id', '=', 'orders.id')->join('release_documents','cocs.id', '=', 'release_documents.coc_id')->where('release_documents.document_number','like','%'.$input['value'].'%')->where('technicalStatus','=',7)->where('border',auth()->user->branch)->get();
                        break;
                    case 'customs':
                        $data = Order::join('cocs','cocs.order_id', '=', 'orders.id')->join('release_documents','cocs.id', '=', 'release_documents.coc_id')->where('release_documents.document_number','like','%'.$input['value'].'%')->where('technicalStatus','=',7)->where('border',auth()->user->branch)->get();
                        break;
                    case 'laboratory':
                        $data = null;
                        break;
                }
                break;
            case 'nrd':
                switch (auth()->user()->sector) {
                    case 'management':
                        $data = Order::join('cocs','cocs.order_id', '=', 'orders.id')->join('non_release_documents','cocs.id', '=', 'non_release_documents.coc_id')->where('non_release_documents.document_number','like','%'.$input['value'].'%')->get();
                        break;
                    case 'branch':
                        $data = Order::join('cocs','cocs.order_id', '=', 'orders.id')->join('non_release_documents','cocs.id', '=', 'non_release_documents.coc_id')->where('non_release_documents.document_number','like','%'.$input['value'].'%')->where('branch',auth()->user->branch)->get();
                        break;
                    case 'cosqc':
                        $data = Order::join('cocs','cocs.order_id', '=', 'orders.id')->join('non_release_documents','cocs.id', '=', 'non_release_documents.coc_id')->where('non_release_documents.document_number','like','%'.$input['value'].'%')->where('technicalStatus','=',7)->get();
                        break;
                    case 'border':
                        $data = Order::join('cocs','cocs.order_id', '=', 'orders.id')->join('non_release_documents','cocs.id', '=', 'non_release_documents.coc_id')->where('non_release_documents.document_number','like','%'.$input['value'].'%')->where('technicalStatus','=',7)->where('border',auth()->user->branch)->get();
                        break;
                    case 'customs':
                        $data = Order::join('cocs','cocs.order_id', '=', 'orders.id')->join('non_release_documents','cocs.id', '=', 'non_release_documents.coc_id')->where('non_release_documents.document_number','like','%'.$input['value'].'%')->where('technicalStatus','=',7)->where('border',auth()->user->branch)->get();
                        break;
                    case 'laboratory':
                        $data = null;
                        break;
                }
                break;
            case 'rft':
                switch (auth()->user()->sector) {
                    case 'management':
                        $data = Rft::where('id','like','%'.$input['value'].'%')->get();
                        $type='rft';
                        break;
                    case 'branch':
                        $data = Rft::where('id','like','%'.$input['value'].'%')->where('branch',auth()->user->branch)->get();
                        $type='rft';
                        break;
                    case 'cosqc':
                        $data = null;
                        break;
                    case 'border':
                        $data = null;
                        break;
                    case 'customs':
                        $data = null;
                        break;
                    case 'laboratory':
                        $data = Rft::where('id','like','%'.$input['value'].'%')->where('branch',auth()->user->branch)->get();
                        $type='rft';
                        break;
                }
                break;
        }
        return view('search::search', ['data' => $data, 'type' => $type]);
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
