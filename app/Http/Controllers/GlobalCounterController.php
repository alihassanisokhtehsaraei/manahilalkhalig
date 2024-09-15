<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GlobalCounter;
use Illuminate\Support\Facades\Auth;

class GlobalCounterController extends Controller
{
    public function new(GlobalCounter $file)
    {
        $file->save();
        $fileID = '0'.$file->id;
        /*while(strlen($fileID) != 4) {
            $fileID = '0'.$fileID;
        }*/

        $branch_alpha2 = $this->getBranch(auth()->user()->branch,3);
        $file->trackingID = 'TF/'.$branch_alpha2.'/'.'INS'.'/'.$file->part.'/'.$fileID;
        $file->save();
        return $file->id;
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
                case 'Nowshahr':
                    return 'No';
                    break;
                case 'Sari':
                    return 'SA';
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
                case 'Nowshahr':
                    return 'NOW';
                    break;
                case 'Sari':
                    return 'SAR';
                    break;
            }
        }
    }
}
