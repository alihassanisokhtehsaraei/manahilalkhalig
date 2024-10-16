<?php

namespace Modules\Financial\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Coc;
use App\Models\Order;
use App\Models\Rft;
use App\Models\RftSamples;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class FinancialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('financial::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('financial::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        $order = Order::find($id);
        $coc = Coc::where('order_id',$id)->first();

        // calculating coc fee
        $ci = floatval(str_replace(',','',$order->invoiceValue));
        $ci = intval(str_replace(',','',$ci));

        if($ci<=80000) {
            $cf = 320;
        } elseif($ci>80000 and $ci<=200000) {
            $cf = 320+(0.004*($ci-80000));
        } elseif($ci>200000 and $ci<=1000000) {
            $cf = 800+(0.003*($ci-200000));
        } elseif($ci>1000000) {
            $cf = 3200+(0.0015*($ci-1000000));
        }

        if($order->shipmentType =='Bulk') {
            $x = 250;
            $bf = $order->container*$x;
            //   echo $bf;
        }

        elseif($order->shipmentType =='Packages' and $order->shipmentMethod =='Ship') {
            $x = 250;
            $bf = $order->container*$x;
        }
        else {
            $pc = floatval(str_replace(',','',$order->invoiceValue))/$order->container;

            if($pc<=5000) {
                $xx = 50;
            } elseif($pc>5000 and $pc<=10000) {
                $xx = 75;
            } elseif($pc>10000) {
                $xx = 100;
            }
            $bf = $order->container*$xx;
        }


        $order->insFee = $cf;
        $order->borderFeeTotal = $bf;
        $order->borderFeeEach = $xx;
        $order->insFeePlace = $request['insFeePlace'];
        $order->borderFeePlace = $request['borderFeePlace'];
        $order->finNote = $request['note'];
        $order->financialStatus = 1;
//(auth()->user()->department == 'financial' or auth()->user()->sector == 'management' or auth()->user()->department == 'technical' )
        if(auth()->user()->department == 'financial' or (auth()->user()->department == 'management' and auth()->user()->level == 'manager' )) {
            $order->finAppUser = Auth::user()->id;
            $order->finAppDate = date('Y-m-d H:i:s');
            $order->financialStatus = 3;

            if($order->technicalStatus == 5 && is_null($coc->certNo)) {
                $newCertNo = $this->getNewCertNo();
                // Assign the new certificate number
                $coc->certNo = $newCertNo;
                $coc->issuingDate = date('Y-m-d');
                $coc->save();
            }
        }

        $order->transactionNo = $request['transactionNo'];
        $order->cocPaymentMethod = $request['cocPaymentMethod'];
        $order->borderPaymentMethod = $request['borderPaymentMethod'];
        $order->save();
        return redirect(route('inspection.show',$id));
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $order = Order::find($id);
        //$order->financialStatus == 3 and Auth()->user()->level != 'manager' and Auth()->user()->sector != 'financial'
        if($order->financialStatus == 3 and Auth()->user()->level != 'manager') {
            $readonly = 'readonly';
        } else {
            $readonly = null;
        }
        if($order->financialStatus == 3 and Auth()->user()->level != 'manager' ) {
            $disabled = 'disabled';
        } else {
            $disabled = null;
        }
        return view('financial::show', ['order' => $order, 'readonly' => $readonly, 'disabled' => $disabled]);
    }

    public function receipt($id)
    {
        $order = Order::find($id);
        return view('financial::receipt', ['order' => $order]);
    }


    public function rftstore(Request $request, $id)
    {
        $rft = Rft::find($id);
        $rft->finNote = $request['note'];
        $rft->transactionNo = $request['transactionNo'];
        $rft->labPaymentMethod = $request['labPaymentMethod'];
        $rft->labFeePlace = $request['labFeePlace'];
        $rft->subSum = $request['subSum'];
        $rft->tax = $request['tax'];
        $rft->totalFee = $request['totalFee'];
        $rft->financialStatus = 1;
        //auth()->user()->department == 'financial' or auth()->user()->sector == 'management'
        if(auth()->user()->department == 'financial' or( auth()->user()->department == 'management' and auth()->user()->level == 'manager' ) ) {
            $rft->finAppUser = Auth::user()->id;
            $rft->finAppDate = date('Y-m-d H:i:s');
            $rft->financialStatus = 3;
        }
        $rft->save();
        return redirect(route('request.showrft',$id));

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
    return 'MNL' . str_pad($newCertNo, 6, '0', STR_PAD_LEFT);
}


    public function rftshow($id)
    {
        $rft = Rft::find($id);
        $samples = RftSamples::where('rft_id',$id)->get();
        // $rft->financialStatus == 3 and Auth()->user()->level != 'manager' and Auth()->user()->sector != 'financial')
        if($rft->financialStatus == 3 and Auth()->user()->level != 'manager') {
            $readonly = 'readonly';
        } else {
            $readonly = null;
        }
        if($rft->financialStatus == 3 and Auth()->user()->level != 'manager') {
            $disabled = 'disabled';
        } else {
            $disabled = null;
        }
        return view('financial::rftshow', ['rft' => $rft, 'readonly' => $readonly, 'disabled' => $disabled, 'samples' => $samples]);
    }

    public function rftreceipt($id)
    {
        $rft = Rft::find($id);
        $samples = RftSamples::where('rft_id',$id)->get();
        return view('financial::rftreceipt', ['rft' => $rft, 'samples' => $samples]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('financial::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
