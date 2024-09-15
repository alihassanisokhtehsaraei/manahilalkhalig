<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\StoreBankAcceptance;
use App\Http\Requests\UpdateBankAcceptance;
use App\Models\Letter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\BankAcceptanceResource;

class BankAcceptanceApi extends Controller
{
    public function index() {
        return BankAcceptanceResource::collection(Letter::all());
    }

    public function show(Letter $letter) {
        return BankAcceptanceResource::make($letter);
    }

    public function store(StoreBankAcceptance $request) {
        if($request->key == '6755b67a6b8186366bc1c874d56d08ef30cc481e7897935be4a1493e2c992bc0') {

            #$letter = Letter::create($request->validated());

            $new = Letter::where('type',2)->max('regNo');
            $newRegNo = $new+1;

            $input = $request->all();

            $letter = new Letter();
            $letter->type = 2;
            $letter->regNo = $newRegNo;
            $letter->branch = 'tehran';
            $letter->ip = $request->ip();
            $letter->user = $request->user;
            $letter->save();

            $branch_2digit = $this->getBranch('tehran', 2);

            $letter->title = $input['title'];
            $letter->letNo = 'TIE/'.$branch_2digit.'/'.sprintf('%06d',$letter->regNo);
            $letter->letDate = \Morilog\Jalali\CalendarUtils::strftime('Y/m/d', date('Y-m-d'));;
            $letter->regDate = date('Y-m-d H:i:s');
            $letter->letRef = $input['letRef'];
            $letter->letText = $input['letText'];
            $letter->signee = $input['signee'];
            $letter->secLevel = 'public';
            $letter->sender = $input['signee'];
            $letter->from = $input['from'];
            $letter->recipientDept = $input['recipientDept'];
            $letter->recipient = $input['recipient'];
            $letter->save();

            return response()->json([
                'data' => BankAcceptanceResource::make($letter),
                'message' => 'Letter created successfully',
                Response::HTTP_CREATED]);
        } else {
            return response()->json([
                'error' => 'Failed to create letter',
                'message' => 'An error occurred',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public function update(UpdateBankAcceptance $request, Letter $letter) {
        $letter->update($request->validated());
        return BankAcceptanceResource::make($letter);
    }

    public function destroy(Letter $letter) {
        $letter->delete();
        return response()->noContent();
    }



    public function getBranch($branch, $type) {
        if($type == 2) {
            switch($branch) {
                case 'tehran':
                    return 'TH';
                    break;
                case 'zanjan':
                    return 'ZJ';
                    break;
                case 'tabriz':
                    return 'TB';
                    break;
                case 'mashhad':
                    return 'MH';
                    break;
                case 'isfahan':
                    return 'IS';
                    break;
                case 'shiraz':
                    return 'SH';
                    break;
                case 'bushehr':
                    return 'BU';
                    break;
                case 'bandar abbas':
                    return 'BN';
                    break;
                case 'genaveh':
                    return 'GN';
                    break;
                case 'Qeshm':
                    return 'QS';
                    break;
            }
        } elseif ($type == 3) {
            switch($branch) {
                case 'tehran':
                    return 'THR';
                    break;
                case 'zanjan':
                    return 'ZJN';
                    break;
                case 'tabriz':
                    return 'TBZ';
                    break;
                case 'mashhad':
                    return 'MHD';
                    break;
                case 'isfahan':
                    return 'ISF';
                    break;
                case 'shiraz':
                    return 'SHZ';
                    break;
                case 'bushehr':
                    return 'BUH';
                    break;
                case 'bandar abbas':
                    return 'BND';
                    break;
                case 'genaveh':
                    return 'GNV';
                    break;
                case 'Qeshm':
                    return 'QSM';
                    break;
            }
        }
    }
}
