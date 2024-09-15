<?php

namespace Modules\Inspection\Http\Controllers;

use App\Models\BankAcceptance;
use App\Models\Coi;
use App\Models\CoiGood;
use App\Models\Lc;
use App\Models\Order;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ReportsController extends Controller
{

    public function bankAcceptanceFormat1($id)
    {
        $data = BankAcceptance::find($id);
        return view('inspection::reports.bankAcceptanceFormat1', ['data' => $data]);
    }

    public function bankAcceptanceFormat2($id)
    {
        $data = BankAcceptance::find($id);
        return view('inspection::reports.bankAcceptanceFormat2', ['data' => $data]);

    }

    public function ic($id,$type='draft')
    {
        $data = Coi::find($id);
        $goods = CoiGood::where('coi_id',$id)->where('certType', 'ic')->get();
        $output = $type;
       return view('inspection::reports.ICCert', ['data' => $data, 'goods' => $goods, 'output' => $output]);
    }

    public function coi($id,$type='draft')
    {
        $data = Coi::find($id);
        $goods = CoiGood::where('coi_id',$id)->where('certType', 'coi')->get();
        return view('inspection::reports.COICert', ['data' => $data, 'goods' => $goods, 'type' => $type]);
    }

    public function lc($id,$type='draft')
    {
        $data = Lc::find($id);
        $goods = lcGood::where('lc_id',$id)->get();
        return view('inspection::reports.COICert', ['data' => $data, 'goods' => $goods, 'type' => $type]);
    }

    public function insOrder($id)
    {
        $data = Order::find($id);
        return view('inspection::reports.insOrder', ['data' => $data]);

    }

    public function insReport($id)
    {

    }
}
