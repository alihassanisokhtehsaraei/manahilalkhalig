<?php

namespace Modules\Report\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ReleaseDocument;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReportController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('report::create');
    }

    public function result(Request $request)
    {
        $startDate = $request['start'];
        $endDate = $request['end'];

        if ($request['office'] == 'all') {
            if($request['reportType'] == 1) {
                $data = Order::join('cocs', 'orders.id', '=', 'cocs.order_id')
                    ->whereBetween('cocs.issuingDate', [$startDate, $endDate])
                    ->whereNotNull('cocs.certNo')
                    ->get();
                return view('report::cocFeeReport', ['data' => $data, 'startDate' => $startDate, 'endDate' => $endDate]);
            } elseif($request['reportType'] == 2) {
                $data = Order::join('cocs', 'orders.id', '=', 'cocs.order_id')
                    ->whereBetween('cocs.issuingDate', [$startDate, $endDate])
                    ->whereNotNull('cocs.certNo')
                    ->get();
                return view('report::borderFeeReport', ['data' => $data, 'startDate' => $startDate, 'endDate' => $endDate]);
            } elseif($request['reportType'] == 3) {
                $data = ReleaseDocument::whereBetween('issuance_date', [$startDate, $endDate])
                    ->whereNotNull('document_number')
                    ->where('issuing_office', '=', $request['office'])
                    ->get();
                return view('report::releaseDocReport', ['data' => $data, 'startDate' => $startDate, 'endDate' => $endDate]);
            }
        } else {
            if($request['reportType'] == 1) {
                $data = Order::join('cocs', 'orders.id', '=', 'cocs.order_id')
                    ->whereBetween('cocs.issuingDate', [$startDate, $endDate])
                    ->where('orders.branch', '=', $request['office'])
                    ->whereNotNull('cocs.certNo')
                    ->get();
                return view('report::cocFeeReport', ['data' => $data, 'startDate' => $startDate, 'endDate' => $endDate]);
            } elseif($request['reportType'] == 2) {
                $data = Order::join('cocs', 'orders.id', '=', 'cocs.order_id')
                    ->whereBetween('cocs.issuingDate', [$startDate, $endDate])
                    ->where('orders.branch', '=', $request['office'])
                    ->whereNotNull('cocs.certNo')
                    ->get();
                return view('report::borderFeeReport', ['data' => $data, 'startDate' => $startDate, 'endDate' => $endDate]);
            } elseif($request['reportType'] == 3) {
                $data = ReleaseDocument::whereBetween('issuance_date', [$startDate, $endDate])
                    ->whereNotNull('document_number')
                    ->get();
                return view('report::releaseDocReport', ['data' => $data, 'startDate' => $startDate, 'endDate' => $endDate]);
            }
        }
    }
}
