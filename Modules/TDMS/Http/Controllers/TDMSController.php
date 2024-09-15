<?php

namespace Modules\TDMS\Http\Controllers;

use Auth;
use Session;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TDMS;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class TDMSController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public $level = '';
    public function index()
    {
        return view('tdms::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $users = User::All();
        $managers = User::where('level','Manager')->get();
        return view('tdms::create', ['users' => $users, 'managers' => $managers]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {


        $input = $request->all();


        // get instance of \Carbon\Carbon
        $carbon = \Morilog\Jalali\CalendarUtils::createCarbonFromFormat('Y/m/d', $input['releaseDate']);



        $path = 'TDMSBOX/'.$input['docType'] . '-' . $input['mgmtCode'] . '-' .$input['actCode'].'-'. $input['no'].'/'.$input['version'].'/';

        if (!Storage::disk('local')->exists($path))
        {
            Storage::disk('local')->makeDirectory($path);
        }


        if($request->file('native')) {

            $fileName1 = $request->file('native')->getClientOriginalName();
            $request->file('native')->storeAs($path, $fileName1, 'local');
        }


        if($request->file('pdf')) {

            $fileName2 = $request->file('pdf')->getClientOriginalName();
            $request->file('pdf')->storeAs($path, $fileName2, 'local');
        }
//
//        $pdf = $request->file($input['pdf'])->store($path, 'local');
//        $native = $request->file($input['native'])->store($path, 'local');


        $document = new TDMS();

        $document->no = $input['no'];
        $document->docType = $input['docType'];
        $document->mgmtCode = $input['mgmtCode'];
        $document->actCode = $input['actCode'];
        $document->version = $input['version'];
        $document->title = $input['title'];
        $document->modDesc = $input['modDesc'];
        $document->s17020 = $request->s17020 ? 1 : 0 ?? 0;
        $document->s17025 = $request->s17025 ? 1 : 0 ?? 0;
        $document->s9001 = $request->s9001 ? 1 : 0 ?? 0;
//        $document->s14001 = $request->s14001 ? 1 : 0 ?? 0;
//        $document->s45001 = $request->s45001 ? 1 : 0 ?? 0;
        $document->pages = $input['pages'];
        $document->userLevel1 = $request->userLevel1 ? 1 : 0 ?? 0;
        $document->userLevel2 = $request->userLevel2 ? 1 : 0 ?? 0;
        #$document->userLevel3 = $request->userLevel3 ? 1 : 0 ?? 0;
        $document->releaseDate = $input['releaseDate'];
        $document->releaseDateGregorian = $carbon;
        $document->status = $input['status'];
        $document->place1 = $request->pmg ? 1 : 0 ?? 0;
        $document->place2 = $request->pmd ? 1 : 0 ?? 0;
        $document->place3 = $request->pfi ? 1 : 0 ?? 0;
        $document->place4 = $request->phr ? 1 : 0 ?? 0;
        $document->place5 = $request->pst ? 1 : 0 ?? 0;
        $document->place6 = $request->ppr ? 1 : 0 ?? 0;
        $document->place7 = $request->pqd ? 1 : 0 ?? 0;
        $document->place8 = $request->ict ? 1 : 0 ?? 0;
        $document->place9 = $request->pgc ? 1 : 0 ?? 0;
        $document->place10 = $request->pti ? 1 : 0 ?? 0;
        $document->place11 = $request->pes ? 1 : 0 ?? 0;
        $document->place12 = $request->pup ? 1 : 0 ?? 0;
        $document->place13 = $request->pnd ? 1 : 0 ?? 0;
        $document->place14 = $request->psl ? 1 : 0 ?? 0;
        $document->place15 = $request->pml ? 1 : 0 ?? 0;
        $document->place16 = $request->pws ? 1 : 0 ?? 0;
        $document->place17 = $request->ptl ? 1 : 0 ?? 0;
        $document->branch1 = $request->thr ? 1 : 0 ?? 0;
        $document->branch2 = $request->shz ? 1 : 0 ?? 0;
        $document->branch3 = $request->bnd ? 1 : 0 ?? 0;
        $document->branch4 = $request->qsm ? 1 : 0 ?? 0;
        $document->branch5 = $request->zjn ? 1 : 0 ?? 0;
        $document->branch6 = $request->mhd ? 1 : 0 ?? 0;
        $document->branch7 = $request->tbz ? 1 : 0 ?? 0;
        $document->branch8 = $request->isf ? 1 : 0 ?? 0;
        $document->branch9 = $request->buh ? 1 : 0 ?? 0;
        $document->branch10 = $request->gnv ? 1 : 0 ?? 0;
        $document->creator = Auth()->user()->id;
        #$document->userInCharge1 = $input['prepare'];
        #$document->userInCharge1Date = date('Y/m/d H:i:s');
        #$document->userInCharge2 = $input['validation'];
        #$document->userInCharge2Date = $input[''];
        #$document->userInCharge4 = $input['approve'];
        #$document->userInCharge4Date = $input[''];

        if($request->file('pdf')) {
            $document->pdfUrl = $fileName2;
        }

        if($request->file('native')) {
            $document->nativeUrl = $fileName1;
        }
        $document->ip = $request->ip();
        $document->save();

        return redirect(route('tdms.index'));

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $users = User::All();
        $managers = User::where('level','Manager')->get();
        $data = TDMS::find($id);
        $related_docs = TDMS::where('no',$data->no)->where('status', 2)->get();
        return view('tdms::show', ['data' => $data,'users' => $users, 'managers' => $managers, 'docs' => $related_docs]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $users = User::All();
        $managers = User::where('level','Manager')->get();
        $data = TDMS::find($id);
        return view('tdms::edit', ['data' => $data,'users' => $users, 'managers' => $managers]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $document = TDMS::find($id);

        // get instance of \Carbon\Carbon
        $carbon = \Morilog\Jalali\CalendarUtils::createCarbonFromFormat('Y/m/d', $input['releaseDate']);



        $path = 'TDMSBOX/'.$document->docType. '-' .$document->mgmtCode. '-' .$document->actCode.'-'.$document->no.'/'.$document->version.'/';

        if (!Storage::disk('local')->exists($path))
        {
            Storage::disk('local')->makeDirectory($path);
        }

        if($request->file('native')) {
            $fileName1 = $request->file('native')->getClientOriginalName();
            $request->file('native')->storeAs($path, $fileName1, 'local');
            $document->nativeUrl = $fileName1;
        }

        if($request->file('pdf')) {
            $fileName2 = $request->file('pdf')->getClientOriginalName();
            $request->file('pdf')->storeAs($path, $fileName2, 'local');
            $document->pdfUrl = $fileName2;
        }



//
//        $pdf = $request->file($input['pdf'])->store($path, 'local');
//        $native = $request->file($input['native'])->store($path, 'local');


        $document->title = $input['title'];
        $document->modDesc = $input['modDesc'];
        $document->s17020 = $request->s17020 ? 1 : 0 ?? 0;
        $document->s17025 = $request->s17025 ? 1 : 0 ?? 0;
        $document->s9001 = $request->s9001 ? 1 : 0 ?? 0;
//        $document->s14001 = $request->s14001 ? 1 : 0 ?? 0;
//        $document->s45001 = $request->s45001 ? 1 : 0 ?? 0;
        $document->pages = $input['pages'];
        $document->userLevel1 = $request->userLevel1 ? 1 : 0 ?? 0;
        $document->userLevel2 = $request->userLevel2 ? 1 : 0 ?? 0;
        #$document->userLevel3 = $request->userLevel3 ? 1 : 0 ?? 0;
        $document->releaseDate = $input['releaseDate'];
        $document->releaseDateGregorian = $carbon;
        $document->status = $input['status'];
        $document->place1 = $request->pmg ? 1 : 0 ?? 0;
        $document->place2 = $request->pmd ? 1 : 0 ?? 0;
        $document->place3 = $request->pfi ? 1 : 0 ?? 0;
        $document->place4 = $request->phr ? 1 : 0 ?? 0;
        $document->place5 = $request->pst ? 1 : 0 ?? 0;
        $document->place6 = $request->ppr ? 1 : 0 ?? 0;
        $document->place7 = $request->pqd ? 1 : 0 ?? 0;
        $document->place8 = $request->ict ? 1 : 0 ?? 0;
        $document->place9 = $request->pgc ? 1 : 0 ?? 0;
        $document->place10 = $request->pti ? 1 : 0 ?? 0;
        $document->place11 = $request->pes ? 1 : 0 ?? 0;
        $document->place12 = $request->pup ? 1 : 0 ?? 0;
        $document->place13 = $request->pnd ? 1 : 0 ?? 0;
        $document->place14 = $request->psl ? 1 : 0 ?? 0;
        $document->place15 = $request->pml ? 1 : 0 ?? 0;
        $document->place16 = $request->pws ? 1 : 0 ?? 0;
        $document->place17 = $request->ptl ? 1 : 0 ?? 0;
        $document->branch1 = $request->thr ? 1 : 0 ?? 0;
        $document->branch2 = $request->shz ? 1 : 0 ?? 0;
        $document->branch3 = $request->bnd ? 1 : 0 ?? 0;
        $document->branch4 = $request->qsm ? 1 : 0 ?? 0;
        $document->branch5 = $request->zjn ? 1 : 0 ?? 0;
        $document->branch6 = $request->mhd ? 1 : 0 ?? 0;
        $document->branch7 = $request->tbz ? 1 : 0 ?? 0;
        $document->branch8 = $request->isf ? 1 : 0 ?? 0;
        $document->branch9 = $request->buh ? 1 : 0 ?? 0;
        $document->branch10 = $request->gnv ? 1 : 0 ?? 0;
        $document->creator = Auth()->user()->id;
        #$document->userInCharge1 = $input['prepare'];
        #$document->userInCharge1Date = date('Y/m/d H:i:s');
        #$document->userInCharge2 = $input['validation'];
        #$document->userInCharge2Date = $input[''];
        #$document->userInCharge4 = $input['approve'];
        #$document->userInCharge4Date = $input[''];
        $document->ip = $request->ip();
        $document->save();

        return redirect(route('tdms.index'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $document = TDMS::find($id);

        $path_original = 'TDMSBOX/'.$document->docType. '-' .$document->mgmtCode. '-' .$document->actCode.'-'. $document->no.'/'.$document->version.'/';

        $path_trash = 'TDMSBOX/Trash/'.$document->docType. '-' .$document->mgmtCode. '-' .$document->actCode.'-'. $document->no.'/'.$document->version.'/';

        if (!Storage::disk('local')->exists($path_trash))
        {
            Storage::disk('local')->makeDirectory($path_trash);
        }

        Storage::disk('local')->move($path_original.$document->nativeUrl, $path_trash.$document->nativeUrl);
        Storage::disk('local')->move($path_original.$document->pdfUrl, $path_trash.$document->pdfUrl);
        Storage::disk('local')->deleteDirectory($path_original);
        $document->delete();

    }

    public function withdraw()
    {
        return view('tdms::withdraw');
    }


    public function getWithdrawList()
    {
        global $level;
        $level .= Auth()->user()->level;
        if(Auth()->user()->department == 'Quality Development') {
            $query = TDMS::where('status',2)->get();
        } else {
            if($level == 'manager') {
                if(Auth()->user()->branch == 'tehran') {
                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch1', 1)->where('place1',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch1', 1)->where('place2',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch1', 1)->where('place3',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch1', 1)->where('place4',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch1', 1)->where('place5',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch1', 1)->where('place6',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch1', 1)->where('place7',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch1', 1)->where('place8',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch1', 1)->where('place9',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch1', 1)->where('place10',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch1', 1)->where('place11',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch1', 1)->where('place12',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch1', 1)->where('place13',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch1', 1)->where('place14',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch1', 1)->where('place15',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch1', 1)->where('place16',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch1', 1)->where('place17',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                    }
                }
                if(Auth()->user()->branch == 'shiraz') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch1', 1)->where('place1',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch2', 1)->where('place2',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch2', 1)->where('place3',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch2', 1)->where('place4',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch2', 1)->where('place5',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch2', 1)->where('place6',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch2', 1)->where('place7',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch2', 1)->where('place8',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch2', 1)->where('place9',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch2', 1)->where('place10',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch2', 1)->where('place11',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch2', 1)->where('place12',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch2', 1)->where('place13',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch2', 1)->where('place14',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch2', 1)->where('place15',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch2', 1)->where('place16',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch2', 1)->where('place17',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                    }
                }
                if(Auth()->user()->branch == 'bandarabbas') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch3', 1)->where('place1',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch3', 1)->where('place2',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch3', 1)->where('place3',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch3', 1)->where('place4',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch3', 1)->where('place5',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch3', 1)->where('place6',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch3', 1)->where('place7',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch3', 1)->where('place8',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch3', 1)->where('place9',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch3', 1)->where('place10',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch3', 1)->where('place11',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch3', 1)->where('place12',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch3', 1)->where('place13',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch3', 1)->where('place14',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch3', 1)->where('place15',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch3', 1)->where('place16',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch3', 1)->where('place17',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                    }
                }
                if(Auth()->user()->branch == 'qeshm') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch4', 1)->where('place1',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch4', 1)->where('place2',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch4', 1)->where('place3',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch4', 1)->where('place4',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch4', 1)->where('place5',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch4', 1)->where('place6',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch4', 1)->where('place7',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch4', 1)->where('place8',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch4', 1)->where('place9',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch4', 1)->where('place10',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch4', 1)->where('place11',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch4', 1)->where('place12',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch4', 1)->where('place13',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch4', 1)->where('place14',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch4', 1)->where('place15',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch4', 1)->where('place16',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch4', 1)->where('place17',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                    }
                }
                if(Auth()->user()->branch == 'zanjan') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch5', 1)->where('place1',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch5', 1)->where('place2',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch5', 1)->where('place3',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch5', 1)->where('place4',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch5', 1)->where('place5',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch5', 1)->where('place6',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch5', 1)->where('place7',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch5', 1)->where('place8',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch5', 1)->where('place9',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch5', 1)->where('place10',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch5', 1)->where('place11',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch5', 1)->where('place12',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch5', 1)->where('place13',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch5', 1)->where('place14',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch5', 1)->where('place15',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch5', 1)->where('place16',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch5', 1)->where('place17',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                    }
                }
                if(Auth()->user()->branch == 'mashhad') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch6', 1)->where('place1',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch6', 1)->where('place2',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch6', 1)->where('place3',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch6', 1)->where('place4',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch6', 1)->where('place5',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch6', 1)->where('place6',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch6', 1)->where('place7',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch6', 1)->where('place8',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch6', 1)->where('place9',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch6', 1)->where('place10',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch6', 1)->where('place11',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch6', 1)->where('place12',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch6', 1)->where('place13',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch6', 1)->where('place14',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch6', 1)->where('place15',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch6', 1)->where('place16',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch6', 1)->where('place17',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                    }
                }
                if(Auth()->user()->branch == 'tabriz') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch7', 1)->where('place1',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch7', 1)->where('place2',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch7', 1)->where('place3',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch7', 1)->where('place4',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch7', 1)->where('place5',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch7', 1)->where('place6',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch7', 1)->where('place7',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch7', 1)->where('place8',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch7', 1)->where('place9',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch7', 1)->where('place10',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch7', 1)->where('place11',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch7', 1)->where('place12',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch7', 1)->where('place13',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch7', 1)->where('place14',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch7', 1)->where('place15',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch7', 1)->where('place16',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch7', 1)->where('place17',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                    }
                }
                if(Auth()->user()->branch == 'isfahan') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch8', 1)->where('place1',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch8', 1)->where('place2',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch8', 1)->where('place3',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch8', 1)->where('place4',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch8', 1)->where('place5',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch8', 1)->where('place6',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch8', 1)->where('place7',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch8', 1)->where('place8',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch8', 1)->where('place9',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch8', 1)->where('place10',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch8', 1)->where('place11',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch8', 1)->where('place12',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch8', 1)->where('place13',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch8', 1)->where('place14',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch8', 1)->where('place15',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch8', 1)->where('place16',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch8', 1)->where('place17',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                    }
                }
                if(Auth()->user()->branch == 'bushehr') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch9', 1)->where('place1',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch9', 1)->where('place2',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch9', 1)->where('place3',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch9', 1)->where('place4',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch9', 1)->where('place5',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch9', 1)->where('place6',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch9', 1)->where('place7',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch9', 1)->where('place8',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch9', 1)->where('place9',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch9', 1)->where('place10',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch9', 1)->where('place11',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch9', 1)->where('place12',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch9', 1)->where('place13',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch9', 1)->where('place14',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch9', 1)->where('place15',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch9', 1)->where('place16',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch9', 1)->where('place17',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                    }
                }
                if(Auth()->user()->branch == 'genaveh') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch10', 1)->where('place1',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch10', 1)->where('place2',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch10', 1)->where('place3',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch10', 1)->where('place4',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch10', 1)->where('place5',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch10', 1)->where('place6',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch10', 1)->where('place7',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch10', 1)->where('place8',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch10', 1)->where('place9',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch10', 1)->where('place10',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch10', 1)->where('place11',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch10', 1)->where('place12',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch10', 1)->where('place13',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch10', 1)->where('place14',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch10', 1)->where('place15',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch10', 1)->where('place16',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch10', 1)->where('place17',1)->where('userLevel2',1)->where('status',2)->get();
                            break;
                    }
                }
            } elseif ($level == 'expert' or $level == 'head' or $level == 'supervisor') {
                if(Auth()->user()->branch == 'tehran') {
                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch1', 1)->where('place1',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch1', 1)->where('place2',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch1', 1)->where('place3',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch1', 1)->where('place4',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch1', 1)->where('place5',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch1', 1)->where('place6',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch1', 1)->where('place7',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch1', 1)->where('place8',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch1', 1)->where('place9',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch1', 1)->where('place10',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch1', 1)->where('place11',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch1', 1)->where('place12',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch1', 1)->where('place13',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch1', 1)->where('place14',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch1', 1)->where('place15',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch1', 1)->where('place16',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch1', 1)->where('place17',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                    }
                }
                if(Auth()->user()->branch == 'shiraz') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch1', 1)->where('place1',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch2', 1)->where('place2',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch2', 1)->where('place3',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch2', 1)->where('place4',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch2', 1)->where('place5',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch2', 1)->where('place6',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch2', 1)->where('place7',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch2', 1)->where('place8',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch2', 1)->where('place9',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch2', 1)->where('place10',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch2', 1)->where('place11',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch2', 1)->where('place12',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch2', 1)->where('place13',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch2', 1)->where('place14',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch2', 1)->where('place15',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch2', 1)->where('place16',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch2', 1)->where('place17',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                    }
                }
                if(Auth()->user()->branch == 'bandarabbas') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch3', 1)->where('place1',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch3', 1)->where('place2',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch3', 1)->where('place3',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch3', 1)->where('place4',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch3', 1)->where('place5',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch3', 1)->where('place6',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch3', 1)->where('place7',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch3', 1)->where('place8',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch3', 1)->where('place9',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch3', 1)->where('place10',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch3', 1)->where('place11',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch3', 1)->where('place12',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch3', 1)->where('place13',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch3', 1)->where('place14',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch3', 1)->where('place15',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch3', 1)->where('place16',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch3', 1)->where('place17',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                    }
                }
                if(Auth()->user()->branch == 'qeshm') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch4', 1)->where('place1',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch4', 1)->where('place2',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch4', 1)->where('place3',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch4', 1)->where('place4',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch4', 1)->where('place5',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch4', 1)->where('place6',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch4', 1)->where('place7',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch4', 1)->where('place8',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch4', 1)->where('place9',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch4', 1)->where('place10',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch4', 1)->where('place11',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch4', 1)->where('place12',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch4', 1)->where('place13',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch4', 1)->where('place14',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch4', 1)->where('place15',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch4', 1)->where('place16',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch4', 1)->where('place17',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                    }
                }
                if(Auth()->user()->branch == 'zanjan') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch5', 1)->where('place1',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch5', 1)->where('place2',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch5', 1)->where('place3',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch5', 1)->where('place4',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch5', 1)->where('place5',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch5', 1)->where('place6',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch5', 1)->where('place7',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch5', 1)->where('place8',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch5', 1)->where('place9',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch5', 1)->where('place10',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch5', 1)->where('place11',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch5', 1)->where('place12',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch5', 1)->where('place13',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch5', 1)->where('place14',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch5', 1)->where('place15',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch5', 1)->where('place16',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch5', 1)->where('place17',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                    }
                }
                if(Auth()->user()->branch == 'mashhad') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch6', 1)->where('place1',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch6', 1)->where('place2',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch6', 1)->where('place3',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch6', 1)->where('place4',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch6', 1)->where('place5',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch6', 1)->where('place6',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch6', 1)->where('place7',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch6', 1)->where('place8',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch6', 1)->where('place9',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch6', 1)->where('place10',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch6', 1)->where('place11',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch6', 1)->where('place12',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch6', 1)->where('place13',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch6', 1)->where('place14',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch6', 1)->where('place15',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch6', 1)->where('place16',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch6', 1)->where('place17',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                    }
                }
                if(Auth()->user()->branch == 'tabriz') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch7', 1)->where('place1',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch7', 1)->where('place2',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch7', 1)->where('place3',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch7', 1)->where('place4',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch7', 1)->where('place5',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch7', 1)->where('place6',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch7', 1)->where('place7',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch7', 1)->where('place8',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch7', 1)->where('place9',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch7', 1)->where('place10',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch7', 1)->where('place11',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch7', 1)->where('place12',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch7', 1)->where('place13',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch7', 1)->where('place14',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch7', 1)->where('place15',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch7', 1)->where('place16',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch7', 1)->where('place17',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                    }
                }
                if(Auth()->user()->branch == 'isfahan') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch8', 1)->where('place1',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch8', 1)->where('place2',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch8', 1)->where('place3',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch8', 1)->where('place4',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch8', 1)->where('place5',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch8', 1)->where('place6',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch8', 1)->where('place7',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch8', 1)->where('place8',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch8', 1)->where('place9',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch8', 1)->where('place10',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch8', 1)->where('place11',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch8', 1)->where('place12',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch8', 1)->where('place13',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch8', 1)->where('place14',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch8', 1)->where('place15',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch8', 1)->where('place16',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch8', 1)->where('place17',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                    }
                }
                if(Auth()->user()->branch == 'bushehr') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch9', 1)->where('place1',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch9', 1)->where('place2',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch9', 1)->where('place3',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch9', 1)->where('place4',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch9', 1)->where('place5',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch9', 1)->where('place6',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch9', 1)->where('place7',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch9', 1)->where('place8',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch9', 1)->where('place9',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch9', 1)->where('place10',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch9', 1)->where('place11',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch9', 1)->where('place12',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch9', 1)->where('place13',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch9', 1)->where('place14',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch9', 1)->where('place15',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch9', 1)->where('place16',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch9', 1)->where('place17',1)->where('userLevel1',1)->where('status',2)->get();
                            break;
                    }
                }
                if(Auth()->user()->branch == 'genaveh') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch10', 1)->where('place1', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch10', 1)->where('place2', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch10', 1)->where('place3', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch10', 1)->where('place4', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch10', 1)->where('place5', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch10', 1)->where('place6', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch10', 1)->where('place7', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch10', 1)->where('place8', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch10', 1)->where('place9', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch10', 1)->where('place10', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch10', 1)->where('place11', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch10', 1)->where('place12', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch10', 1)->where('place13', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch10', 1)->where('place14', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch10', 1)->where('place15', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch10', 1)->where('place16', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch10', 1)->where('place17', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                    }
                }
            }
        }

        if(request()->ajax()) {
            return datatables()->of($query)
                ->addIndexColumn()
                ->addColumn('DOC', function($row){
                    return $row->docType.'-'.$row->mgmtCode.'-'.$row->actCode.'-'.$row->no;
                })
                ->addColumn('actions', function($row){
                    global $level;
                    $btn = '';
                    if($level == 'manager') {
                        $btn = $btn.'<a class="btn btn-xs btn-success" href="'.route('tdms.edit',$row->id).'"  style="margin:2px">EDIT</a> ';
                        $btn = $btn.'<a class="btn btn-xs btn-warning" href="'.route('tdms.revision',$row->id).'"  style="margin:2px">Revision</a>';
                        $btn = $btn.'
                                    <a  style="margin:2px" class="btn btn-danger btn-xs" id="sweet-'.$row->id.'" type="button" onclick="_gaq.push([\'_trackEvent\', \'example\', \'try\', \'sweet-'.$row->id.'\']);">DELETE</a>
                    <script>
                        var SweetAlert_custom = {
                            init: function() {

                                document.querySelector("#sweet-'.$row->id.'").onclick = function(){
                                    swal({
                                        title: "Are you sure?",
                                        text: "Once deleted, you will not be able to recover this Tracking Code, all other related information will be deleted too!",
                                        icon: "warning",
                                        buttons: true,
                                        dangerMode: true,
                                    })
                                        .then((willDelete) => {
                                            if (willDelete) {
                                                     $.ajax({
                                                         url: \'/tdms/destroy/'.$row->id.'\',
                                                         type: \'get\',
                                                         dataType: \'json\'
                                                      });

                                                    swal("Document Deleted!", {
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
                                    ';


                    }
                    else {
                        $btn = '----';
                    }
                    return $btn;
                })
                ->addColumn('department', function($row){
                    $department = '';
                    if($row->place1 == 1) { $department .= '<span class="btn btn-xs btn-success" style="margin:2px">Management</span>'; }
                    if($row->place2 == 1) { $department .= '<span class="btn btn-xs btn-warning" style="margin:2px">Market Development</span>'; }
                    if($row->place3 == 1) { $department .= '<span class="btn btn-xs btn-info" style="margin:2px">Financial</span>'; }
                    if($row->place4 == 1) { $department .= '<span class="btn btn-xs btn-primary" style="margin:2px">Human Resources</span>'; }
                    if($row->place5 == 1) { $department .= '<span class="btn btn-xs btn-danger" style="margin:2px">Strategy</span>'; }
                    if($row->place6 == 1) { $department .= '<span class="btn btn-xs btn-success" style="margin:2px">Procurment</span>'; }
                    if($row->place7 == 1) { $department .= '<span class="btn btn-xs btn-warning" style="margin:2px">Quality Development</span>'; }
                    if($row->place8 == 1) { $department .= '<span class="btn btn-xs btn-danger" style="margin:2px">ICT</span>'; }
                    if($row->place9 == 1) { $department .= '<span class="btn btn-xs btn-primary" style="margin:2px">General Cargo</span>'; }
                    if($row->place10 == 1) { $department .= '<span class="btn btn-xs btn-danger" style="margin:2px">Technical Inspection</span>'; }
                    if($row->place11 == 1) { $department .= '<span class="btn btn-xs btn-success" style="margin:2px">Escalator</span>'; }
                    if($row->place12 == 1) { $department .= '<span class="btn btn-xs btn-warning" style="margin:2px">Under Pressure</span>'; }
                    if($row->place13 == 1) { $department .= '<span class="btn btn-xs btn-info" style="margin:2px">NDT</span>'; }
                    if($row->place14 == 1) { $department .= '<span class="btn btn-xs btn-primary" style="margin:2px">Structural Lab</span>'; }
                    if($row->place15 == 1) { $department .= '<span class="btn btn-xs btn-danger" style="margin:2px">Mineral Lab</span>'; }
                    if($row->place16 == 1) { $department .= '<span class="btn btn-xs btn-success" style="margin:2px">Weight & Scales Lab</span>'; }
                    if($row->place17 == 1) { $department .= '<span class="btn btn-xs btn-warning" style="margin:2px">Textile Lab</span>'; }


                    return $department;
                })

                ->addColumn('download', function($row){
                    global $level;
                    if($level == 'manager') {
                        return "<a download href='".route('tdms.getPdf', $row['id'])."' target='_blank' class='btn btn-warning btn-xs'  style='margin:2px'>PDF</a>&nbsp;<a download style='margin:2px' href='".route('tdms.getNative', $row['id'])."' target='_blank' class='btn btn-success btn-xs'>NATIVE</a>";
                    } else {
                        return "<a download href='".route('tdms.getPdf', $row['id'])."' target='_blank' class='btn btn-warning btn-xs'  style='margin:2px'>PDF</a>";
                    }
                })
                ->rawColumns(['DOC','actions','department','download'])
                ->make(true);
        }

        return view('tdms::index');
    }

    public function getMasterList()
    {
        global $level;
        $level .= Auth()->user()->level;

        if (Auth()->user()->department == 'Quality Development') {
                $query = TDMS::where('status', 1)->get();
        } else {
            if ($level == 'manager') {
                if (Auth()->user()->branch == 'tehran') {
                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch1', 1)->where('place1', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch1', 1)->where('place2', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch1', 1)->where('place3', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch1', 1)->where('place4', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch1', 1)->where('place5', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch1', 1)->where('place6', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch1', 1)->where('place7', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch1', 1)->where('place8', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch1', 1)->where('place9', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch1', 1)->where('place10', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch1', 1)->where('place11', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch1', 1)->where('place12', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch1', 1)->where('place13', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch1', 1)->where('place14', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch1', 1)->where('place15', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch1', 1)->where('place16', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch1', 1)->where('place17', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                    }
                }
                if (Auth()->user()->branch == 'shiraz') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch1', 1)->where('place1', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch2', 1)->where('place2', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch2', 1)->where('place3', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch2', 1)->where('place4', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch2', 1)->where('place5', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch2', 1)->where('place6', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch2', 1)->where('place7', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch2', 1)->where('place8', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch2', 1)->where('place9', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch2', 1)->where('place10', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch2', 1)->where('place11', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch2', 1)->where('place12', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch2', 1)->where('place13', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch2', 1)->where('place14', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch2', 1)->where('place15', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch2', 1)->where('place16', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch2', 1)->where('place17', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                    }
                }
                if (Auth()->user()->branch == 'bandarabbas') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch3', 1)->where('place1', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch3', 1)->where('place2', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch3', 1)->where('place3', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch3', 1)->where('place4', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch3', 1)->where('place5', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch3', 1)->where('place6', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch3', 1)->where('place7', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch3', 1)->where('place8', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch3', 1)->where('place9', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch3', 1)->where('place10', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch3', 1)->where('place11', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch3', 1)->where('place12', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch3', 1)->where('place13', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch3', 1)->where('place14', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch3', 1)->where('place15', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch3', 1)->where('place16', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch3', 1)->where('place17', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                    }
                }
                if (Auth()->user()->branch == 'qeshm') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch4', 1)->where('place1', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch4', 1)->where('place2', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch4', 1)->where('place3', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch4', 1)->where('place4', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch4', 1)->where('place5', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch4', 1)->where('place6', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch4', 1)->where('place7', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch4', 1)->where('place8', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch4', 1)->where('place9', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch4', 1)->where('place10', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch4', 1)->where('place11', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch4', 1)->where('place12', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch4', 1)->where('place13', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch4', 1)->where('place14', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch4', 1)->where('place15', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch4', 1)->where('place16', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch4', 1)->where('place17', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                    }
                }
                if (Auth()->user()->branch == 'zanjan') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch5', 1)->where('place1', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch5', 1)->where('place2', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch5', 1)->where('place3', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch5', 1)->where('place4', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch5', 1)->where('place5', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch5', 1)->where('place6', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch5', 1)->where('place7', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch5', 1)->where('place8', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch5', 1)->where('place9', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch5', 1)->where('place10', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch5', 1)->where('place11', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch5', 1)->where('place12', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch5', 1)->where('place13', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch5', 1)->where('place14', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch5', 1)->where('place15', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch5', 1)->where('place16', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch5', 1)->where('place17', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                    }
                }
                if (Auth()->user()->branch == 'mashhad') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch6', 1)->where('place1', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch6', 1)->where('place2', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch6', 1)->where('place3', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch6', 1)->where('place4', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch6', 1)->where('place5', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch6', 1)->where('place6', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch6', 1)->where('place7', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch6', 1)->where('place8', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch6', 1)->where('place9', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch6', 1)->where('place10', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch6', 1)->where('place11', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch6', 1)->where('place12', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch6', 1)->where('place13', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch6', 1)->where('place14', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch6', 1)->where('place15', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch6', 1)->where('place16', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch6', 1)->where('place17', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                    }
                }
                if (Auth()->user()->branch == 'tabriz') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch7', 1)->where('place1', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch7', 1)->where('place2', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch7', 1)->where('place3', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch7', 1)->where('place4', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch7', 1)->where('place5', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch7', 1)->where('place6', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch7', 1)->where('place7', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch7', 1)->where('place8', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch7', 1)->where('place9', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch7', 1)->where('place10', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch7', 1)->where('place11', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch7', 1)->where('place12', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch7', 1)->where('place13', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch7', 1)->where('place14', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch7', 1)->where('place15', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch7', 1)->where('place16', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch7', 1)->where('place17', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                    }
                }
                if (Auth()->user()->branch == 'isfahan') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch8', 1)->where('place1', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch8', 1)->where('place2', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch8', 1)->where('place3', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch8', 1)->where('place4', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch8', 1)->where('place5', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch8', 1)->where('place6', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch8', 1)->where('place7', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch8', 1)->where('place8', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch8', 1)->where('place9', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch8', 1)->where('place10', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch8', 1)->where('place11', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch8', 1)->where('place12', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch8', 1)->where('place13', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch8', 1)->where('place14', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch8', 1)->where('place15', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch8', 1)->where('place16', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch8', 1)->where('place17', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                    }
                }
                if (Auth()->user()->branch == 'bushehr') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch9', 1)->where('place1', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch9', 1)->where('place2', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch9', 1)->where('place3', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch9', 1)->where('place4', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch9', 1)->where('place5', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch9', 1)->where('place6', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch9', 1)->where('place7', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch9', 1)->where('place8', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch9', 1)->where('place9', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch9', 1)->where('place10', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch9', 1)->where('place11', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch9', 1)->where('place12', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch9', 1)->where('place13', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch9', 1)->where('place14', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch9', 1)->where('place15', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch9', 1)->where('place16', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch9', 1)->where('place17', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                    }
                }
                if (Auth()->user()->branch == 'genaveh') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch10', 1)->where('place1', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch10', 1)->where('place2', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch10', 1)->where('place3', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch10', 1)->where('place4', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch10', 1)->where('place5', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch10', 1)->where('place6', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch10', 1)->where('place7', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch10', 1)->where('place8', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch10', 1)->where('place9', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch10', 1)->where('place10', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch10', 1)->where('place11', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch10', 1)->where('place12', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch10', 1)->where('place13', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch10', 1)->where('place14', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch10', 1)->where('place15', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch10', 1)->where('place16', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch10', 1)->where('place17', 1)->where('userLevel2', 1)->where('status', 1)->get();
                            break;
                    }
                }
            } elseif ($level == 'expert' or $level == 'head' or $level == 'supervisor') {
                if (Auth()->user()->branch == 'tehran') {
                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch1', 1)->where('place1', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch1', 1)->where('place2', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch1', 1)->where('place3', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch1', 1)->where('place4', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch1', 1)->where('place5', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch1', 1)->where('place6', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch1', 1)->where('place7', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch1', 1)->where('place8', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch1', 1)->where('place9', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch1', 1)->where('place10', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch1', 1)->where('place11', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch1', 1)->where('place12', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch1', 1)->where('place13', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch1', 1)->where('place14', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch1', 1)->where('place15', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch1', 1)->where('place16', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch1', 1)->where('place17', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Head Technical Inspection';
                            $query = TDMS::where('place10', 1)->where('branch1', 1)->where('userLevel1', 1)->where('status', 1)->orWhere('place11', 1)->where('branch1', 1)->where('userLevel1', 1)->where('status', 1)->orWhere('place12', 1)->where('branch1', 1)->where('userLevel1', 1)->where('status', 1)->orWhere('place13', 1)->where('branch1', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                    }
                }
                if (Auth()->user()->branch == 'shiraz') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch1', 1)->where('place1', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch2', 1)->where('place2', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch2', 1)->where('place3', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch2', 1)->where('place4', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch2', 1)->where('place5', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch2', 1)->where('place6', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch2', 1)->where('place7', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch2', 1)->where('place8', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch2', 1)->where('place9', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch2', 1)->where('place10', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch2', 1)->where('place11', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch2', 1)->where('place12', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch2', 1)->where('place13', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch2', 1)->where('place14', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch2', 1)->where('place15', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch2', 1)->where('place16', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch2', 1)->where('place17', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                    }
                }
                if (Auth()->user()->branch == 'bandarabbas') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch3', 1)->where('place1', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch3', 1)->where('place2', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch3', 1)->where('place3', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch3', 1)->where('place4', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch3', 1)->where('place5', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch3', 1)->where('place6', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch3', 1)->where('place7', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch3', 1)->where('place8', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch3', 1)->where('place9', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch3', 1)->where('place10', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch3', 1)->where('place11', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch3', 1)->where('place12', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch3', 1)->where('place13', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch3', 1)->where('place14', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch3', 1)->where('place15', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch3', 1)->where('place16', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch3', 1)->where('place17', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                    }
                }
                if (Auth()->user()->branch == 'qeshm') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch4', 1)->where('place1', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch4', 1)->where('place2', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch4', 1)->where('place3', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch4', 1)->where('place4', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch4', 1)->where('place5', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch4', 1)->where('place6', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch4', 1)->where('place7', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch4', 1)->where('place8', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch4', 1)->where('place9', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch4', 1)->where('place10', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch4', 1)->where('place11', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch4', 1)->where('place12', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch4', 1)->where('place13', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch4', 1)->where('place14', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch4', 1)->where('place15', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch4', 1)->where('place16', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch4', 1)->where('place17', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                    }
                }
                if (Auth()->user()->branch == 'zanjan') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch5', 1)->where('place1', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch5', 1)->where('place2', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch5', 1)->where('place3', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch5', 1)->where('place4', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch5', 1)->where('place5', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch5', 1)->where('place6', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch5', 1)->where('place7', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch5', 1)->where('place8', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch5', 1)->where('place9', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch5', 1)->where('place10', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch5', 1)->where('place11', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch5', 1)->where('place12', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch5', 1)->where('place13', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch5', 1)->where('place14', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch5', 1)->where('place15', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch5', 1)->where('place16', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch5', 1)->where('place17', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                    }
                }
                if (Auth()->user()->branch == 'mashhad') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch6', 1)->where('place1', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch6', 1)->where('place2', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch6', 1)->where('place3', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch6', 1)->where('place4', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch6', 1)->where('place5', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch6', 1)->where('place6', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch6', 1)->where('place7', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch6', 1)->where('place8', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch6', 1)->where('place9', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch6', 1)->where('place10', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch6', 1)->where('place11', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch6', 1)->where('place12', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch6', 1)->where('place13', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch6', 1)->where('place14', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch6', 1)->where('place15', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch6', 1)->where('place16', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch6', 1)->where('place17', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                    }
                }
                if (Auth()->user()->branch == 'tabriz') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch7', 1)->where('place1', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch7', 1)->where('place2', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch7', 1)->where('place3', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch7', 1)->where('place4', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch7', 1)->where('place5', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch7', 1)->where('place6', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch7', 1)->where('place7', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch7', 1)->where('place8', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch7', 1)->where('place9', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch7', 1)->where('place10', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch7', 1)->where('place11', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch7', 1)->where('place12', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch7', 1)->where('place13', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch7', 1)->where('place14', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch7', 1)->where('place15', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch7', 1)->where('place16', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch7', 1)->where('place17', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                    }
                }
                if (Auth()->user()->branch == 'isfahan') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch8', 1)->where('place1', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch8', 1)->where('place2', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch8', 1)->where('place3', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch8', 1)->where('place4', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch8', 1)->where('place5', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch8', 1)->where('place6', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch8', 1)->where('place7', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch8', 1)->where('place8', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch8', 1)->where('place9', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch8', 1)->where('place10', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch8', 1)->where('place11', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch8', 1)->where('place12', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch8', 1)->where('place13', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch8', 1)->where('place14', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch8', 1)->where('place15', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch8', 1)->where('place16', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch8', 1)->where('place17', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                    }
                }
                if (Auth()->user()->branch == 'bushehr') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch9', 1)->where('place1', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch9', 1)->where('place2', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch9', 1)->where('place3', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch9', 1)->where('place4', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch9', 1)->where('place5', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch9', 1)->where('place6', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch9', 1)->where('place7', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch9', 1)->where('place8', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch9', 1)->where('place9', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch9', 1)->where('place10', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch9', 1)->where('place11', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch9', 1)->where('place12', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch9', 1)->where('place13', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch9', 1)->where('place14', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch9', 1)->where('place15', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch9', 1)->where('place16', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch9', 1)->where('place17', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                    }
                }
                if (Auth()->user()->branch == 'genaveh') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch10', 1)->where('place1', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch10', 1)->where('place2', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch10', 1)->where('place3', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch10', 1)->where('place4', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch10', 1)->where('place5', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch10', 1)->where('place6', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch10', 1)->where('place7', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch10', 1)->where('place8', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch10', 1)->where('place9', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch10', 1)->where('place10', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch10', 1)->where('place11', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch10', 1)->where('place12', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch10', 1)->where('place13', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch10', 1)->where('place14', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch10', 1)->where('place15', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch10', 1)->where('place16', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch10', 1)->where('place17', 1)->where('userLevel1', 1)->where('status', 1)->get();
                            break;
                    }
                }
            }
        }

        if (request()->ajax()) {
            return datatables()->of($query)
                ->addIndexColumn()
                ->addColumn('DOC', function ($row) {
                    return $row->docType . '-' . $row->mgmtCode . '-' . $row->actCode . '-' . $row->no;
                })
                ->addColumn('actions', function ($row) {
                    global $level;
                    $btn = '';
                    if ($level == 'manager' && Auth()->user()->sector == 'Quality Development') {
                        $btn = $btn . '<a class="btn btn-xs btn-light" href="' . route('tdms.show', $row->id) . '"  style="margin:2px">SHOW</a> ';
                        $btn = $btn . '<a class="btn btn-xs btn-success" href="' . route('tdms.edit', $row->id) . '"  style="margin:2px">EDIT</a> ';
                        $btn = $btn . '<a class="btn btn-xs btn-warning" href="' . route('tdms.revision', $row->id) . '"  style="margin:2px">Revision</a>';
                        $btn = $btn . '
                                    <a  style="margin:2px" class="btn btn-danger btn-xs" id="sweet-' . $row->id . '" type="button" onclick="_gaq.push([\'_trackEvent\', \'example\', \'try\', \'sweet-' . $row->id . '\']);">DELETE</a>
                    <script>
                        var SweetAlert_custom = {
                            init: function() {

                                document.querySelector("#sweet-' . $row->id . '").onclick = function(){
                                    swal({
                                        title: "Are you sure?",
                                        text: "Once deleted, you will not be able to recover this Tracking Code, all other related information will be deleted too!",
                                        icon: "warning",
                                        buttons: true,
                                        dangerMode: true,
                                    })
                                        .then((willDelete) => {
                                            if (willDelete) {
                                                     $.ajax({
                                                         url: \'/tdms/destroy/' . $row->id . '\',
                                                         type: \'get\',
                                                         dataType: \'json\'
                                                      });

                                                    swal("Document Deleted!", {
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
                                    ';


                    } else {
                        $btn = '----';
                    }
                    return $btn;
                })
                ->addColumn('department', function ($row) {
                    $department = '';
                    if ($row->place1 == 1) {
                        $department .= '<span class="btn btn-xs btn-success" style="margin:2px">Management</span>';
                    }
                    if ($row->place2 == 1) {
                        $department .= '<span class="btn btn-xs btn-warning" style="margin:2px">Market Development</span>';
                    }
                    if ($row->place3 == 1) {
                        $department .= '<span class="btn btn-xs btn-info" style="margin:2px">Financial</span>';
                    }
                    if ($row->place4 == 1) {
                        $department .= '<span class="btn btn-xs btn-primary" style="margin:2px">Human Resources</span>';
                    }
                    if ($row->place5 == 1) {
                        $department .= '<span class="btn btn-xs btn-danger" style="margin:2px">Strategy</span>';
                    }
                    if ($row->place6 == 1) {
                        $department .= '<span class="btn btn-xs btn-success" style="margin:2px">Procurment</span>';
                    }
                    if ($row->place7 == 1) {
                        $department .= '<span class="btn btn-xs btn-warning" style="margin:2px">Quality Development</span>';
                    }
                    if ($row->place8 == 1) {
                        $department .= '<span class="btn btn-xs btn-danger" style="margin:2px">ICT</span>';
                    }
                    if ($row->place9 == 1) {
                        $department .= '<span class="btn btn-xs btn-primary" style="margin:2px">General Cargo</span>';
                    }
                    if ($row->place10 == 1) {
                        $department .= '<span class="btn btn-xs btn-danger" style="margin:2px">Technical Inspection</span>';
                    }
                    if ($row->place11 == 1) {
                        $department .= '<span class="btn btn-xs btn-success" style="margin:2px">Escalator</span>';
                    }
                    if ($row->place12 == 1) {
                        $department .= '<span class="btn btn-xs btn-warning" style="margin:2px">Under Pressure</span>';
                    }
                    if ($row->place13 == 1) {
                        $department .= '<span class="btn btn-xs btn-info" style="margin:2px">NDT</span>';
                    }
                    if ($row->place14 == 1) {
                        $department .= '<span class="btn btn-xs btn-primary" style="margin:2px">Structural Lab</span>';
                    }
                    if ($row->place15 == 1) {
                        $department .= '<span class="btn btn-xs btn-danger" style="margin:2px">Mineral Lab</span>';
                    }
                    if ($row->place16 == 1) {
                        $department .= '<span class="btn btn-xs btn-success" style="margin:2px">Weight & Scales Lab</span>';
                    }
                    if ($row->place17 == 1) {
                        $department .= '<span class="btn btn-xs btn-warning" style="margin:2px">Textile Lab</span>';
                    }


                    return $department;
                })
                ->addColumn('download', function ($row) {
                    global $level;
                    if ($level == 'manager'  && Auth()->user()->sector == 'Quality Development') {
                        return "<a download href='" .route('tdms.getPdf', $row['id']). "' target='_blank' class='btn btn-warning btn-xs'  style='margin:2px'>PDF</a>&nbsp;<a download style='margin:2px' href='" .route('tdms.getNative', $row['id']). "' target='_blank' class='btn btn-success btn-xs'>NATIVE</a>";
                    } else {
                        return "<a download href='" .route('tdms.getPdf', $row['id']). "' target='_blank' class='btn btn-warning btn-xs'  style='margin:2px'>PDF</a>";
                    }
                })
                ->rawColumns(['DOC', 'actions', 'department', 'download'])
                ->make(true);
        }

        return view('tdms::index');

    }

    public function revision($id) {
        $users = User::All();
        $managers = User::where('level','Manager')->get();
        $data = TDMS::find($id);
        return view('tdms::revision', ['data' => $data,'users' => $users, 'managers' => $managers]);
    }

    public function revisions($id, Request $request) {

        $input = $request->all();
        $current = TDMS::find($id);
        $new = new TDMS();

        // get instance of \Carbon\Carbon
        $carbon = \Morilog\Jalali\CalendarUtils::createCarbonFromFormat('Y/m/d', $input['releaseDate']);



        $path = 'TDMSBOX/'.$current['docType'] . '-' . $current['mgmtCode'] . '-' .$current['actCode'].'-'. $current['no'].'/'.$input['version'].'/';

        if (!Storage::disk('local')->exists($path))
        {
            Storage::disk('local')->makeDirectory($path);
        }

        if($request->file('native')) {
            $fileName1 = $request->file('native')->getClientOriginalName();
            $request->file('native')->storeAs($path, $fileName1, 'local');
            $new->nativeUrl = $fileName1;
        }

        if($request->file('pdf')) {
            $fileName2 = $request->file('pdf')->getClientOriginalName();
            $request->file('pdf')->storeAs($path, $fileName2, 'local');
            $new->pdfUrl = $fileName2;
        }



//
//        $pdf = $request->file($input['pdf'])->store($path, 'local');
//        $native = $request->file($input['native'])->store($path, 'local');



        $new->no = $current['no'];
        $new->docType = $current['docType'];
        $new->mgmtCode = $current['mgmtCode'];
        $new->actCode = $current['actCode'];
        $new->version = $input['version'];
        $new->title = $input['title'];
        $new->modDesc = $input['modDesc'];
        $new->s17020 = $request->s17020 ? 1 : 0 ?? 0;
        $new->s17025 = $request->s17025 ? 1 : 0 ?? 0;
        $new->s9001 = $request->s9001 ? 1 : 0 ?? 0;
//        $new->s14001 = $request->s14001 ? 1 : 0 ?? 0;
//        $new->s45001 = $request->s45001 ? 1 : 0 ?? 0;
        $new->pages = $input['pages'];
        $new->userLevel1 = $request->userLevel1 ? 1 : 0 ?? 0;
        $new->userLevel2 = $request->userLevel2 ? 1 : 0 ?? 0;
        #$new->userLevel3 = $request->userLevel3 ? 1 : 0 ?? 0;
        $new->releaseDate = $input['releaseDate'];
        $new->releaseDateGregorian = $carbon;
        $new->status = $input['status'];
        $new->place1 = $request->pmg ? 1 : 0 ?? 0;
        $new->place2 = $request->pmd ? 1 : 0 ?? 0;
        $new->place3 = $request->pfi ? 1 : 0 ?? 0;
        $new->place4 = $request->phr ? 1 : 0 ?? 0;
        $new->place5 = $request->pst ? 1 : 0 ?? 0;
        $new->place6 = $request->ppr ? 1 : 0 ?? 0;
        $new->place7 = $request->pqd ? 1 : 0 ?? 0;
        $new->place8 = $request->ict ? 1 : 0 ?? 0;
        $new->place9 = $request->pgc ? 1 : 0 ?? 0;
        $new->place10 = $request->pti ? 1 : 0 ?? 0;
        $new->place11 = $request->pes ? 1 : 0 ?? 0;
        $new->place12 = $request->pup ? 1 : 0 ?? 0;
        $new->place13 = $request->pnd ? 1 : 0 ?? 0;
        $new->place14 = $request->psl ? 1 : 0 ?? 0;
        $new->place15 = $request->pml ? 1 : 0 ?? 0;
        $new->place16 = $request->pws ? 1 : 0 ?? 0;
        $new->place17 = $request->ptl ? 1 : 0 ?? 0;
        $new->branch1 = $request->thr ? 1 : 0 ?? 0;
        $new->branch2 = $request->shz ? 1 : 0 ?? 0;
        $new->branch3 = $request->bnd ? 1 : 0 ?? 0;
        $new->branch4 = $request->qsm ? 1 : 0 ?? 0;
        $new->branch5 = $request->zjn ? 1 : 0 ?? 0;
        $new->branch6 = $request->mhd ? 1 : 0 ?? 0;
        $new->branch7 = $request->tbz ? 1 : 0 ?? 0;
        $new->branch8 = $request->isf ? 1 : 0 ?? 0;
        $new->branch9 = $request->buh ? 1 : 0 ?? 0;
        $new->branch10 = $request->gnv ? 1 : 0 ?? 0;
        $new->creator = Auth()->user()->id;
        #$new->userInCharge1 = $input['prepare'];
        #$new->userInCharge1Date = date('Y/m/d H:i:s');
        #$new->userInCharge2 = $input['validation'];
        #$new->userInCharge2Date = $input[''];
        #$new->userInCharge4 = $input['approve'];
        #$new->userInCharge4Date = $input[''];
        $new->ip = $request->ip();
        $new->save();

        $current->status = 2;
        $current->save();

        return redirect(route('tdms.index'));
    }

    public function getMasterSystem(Request $request) {
        return view('tdms::getMasterSystem', ['system' => $request->system]);
    }

    public function getMasterSystems($slug) {
        if (Auth()->user()->department == 'Quality Development') {
            if($slug == 17020) {
                $query = TDMS::where('status', 1)->where('s17020',1)->get();
            } elseif($slug == 17025) {
                $query = TDMS::where('status', 1)->where('s17025',1)->get();
            } else if($slug == 9001) {
                $query = TDMS::where('status', 1)->where('s9001',1)->get();
            }

            if (request()->ajax()) {
                return datatables()->of($query)
                    ->addIndexColumn()
                    ->addColumn('DOC', function ($row) {
                        return $row->docType . '-' . $row->mgmtCode . '-' . $row->actCode . '-' . $row->no;
                    })
                    ->addColumn('actions', function ($row) {
                        $btn = '';
                        $btn = $btn . '<a class="btn btn-xs btn-success" href="' . route('tdms.edit', $row->id) . '"  style="margin:2px">EDIT</a> ';
                        $btn = $btn . '<a class="btn btn-xs btn-warning" href="' . route('tdms.revision', $row->id) . '"  style="margin:2px">Revision</a>';
                        $btn = $btn . '
                                    <a  style="margin:2px" class="btn btn-danger btn-xs" id="sweet-' . $row->id . '" type="button" onclick="_gaq.push([\'_trackEvent\', \'example\', \'try\', \'sweet-' . $row->id . '\']);">DELETE</a>
                    <script>
                        var SweetAlert_custom = {
                            init: function() {

                                document.querySelector("#sweet-' . $row->id . '").onclick = function(){
                                    swal({
                                        title: "Are you sure?",
                                        text: "Once deleted, you will not be able to recover this Tracking Code, all other related information will be deleted too!",
                                        icon: "warning",
                                        buttons: true,
                                        dangerMode: true,
                                    })
                                        .then((willDelete) => {
                                            if (willDelete) {
                                                     $.ajax({
                                                         url: \'/tdms/destroy/' . $row->id . '\',
                                                         type: \'get\',
                                                         dataType: \'json\'
                                                      });

                                                    swal("Document Deleted!", {
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
                                    ';

                        return $btn;
                    })
                    ->addColumn('department', function ($row) {
                        $department = '';
                        if ($row->place1 == 1) {
                            $department .= '<span class="btn btn-xs btn-success" style="margin:2px">Management</span>';
                        }
                        if ($row->place2 == 1) {
                            $department .= '<span class="btn btn-xs btn-warning" style="margin:2px">Market Development</span>';
                        }
                        if ($row->place3 == 1) {
                            $department .= '<span class="btn btn-xs btn-info" style="margin:2px">Financial</span>';
                        }
                        if ($row->place4 == 1) {
                            $department .= '<span class="btn btn-xs btn-primary" style="margin:2px">Human Resources</span>';
                        }
                        if ($row->place5 == 1) {
                            $department .= '<span class="btn btn-xs btn-danger" style="margin:2px">Strategy</span>';
                        }
                        if ($row->place6 == 1) {
                            $department .= '<span class="btn btn-xs btn-success" style="margin:2px">Procurment</span>';
                        }
                        if ($row->place7 == 1) {
                            $department .= '<span class="btn btn-xs btn-warning" style="margin:2px">Quality Development</span>';
                        }
                        if ($row->place8 == 1) {
                            $department .= '<span class="btn btn-xs btn-danger" style="margin:2px">ICT</span>';
                        }
                        if ($row->place9 == 1) {
                            $department .= '<span class="btn btn-xs btn-primary" style="margin:2px">General Cargo</span>';
                        }
                        if ($row->place10 == 1) {
                            $department .= '<span class="btn btn-xs btn-danger" style="margin:2px">Technical Inspection</span>';
                        }
                        if ($row->place11 == 1) {
                            $department .= '<span class="btn btn-xs btn-success" style="margin:2px">Escalator</span>';
                        }
                        if ($row->place12 == 1) {
                            $department .= '<span class="btn btn-xs btn-warning" style="margin:2px">Under Pressure</span>';
                        }
                        if ($row->place13 == 1) {
                            $department .= '<span class="btn btn-xs btn-info" style="margin:2px">NDT</span>';
                        }
                        if ($row->place14 == 1) {
                            $department .= '<span class="btn btn-xs btn-primary" style="margin:2px">Structural Lab</span>';
                        }
                        if ($row->place15 == 1) {
                            $department .= '<span class="btn btn-xs btn-danger" style="margin:2px">Mineral Lab</span>';
                        }
                        if ($row->place16 == 1) {
                            $department .= '<span class="btn btn-xs btn-success" style="margin:2px">Weight & Scales Lab</span>';
                        }
                        if ($row->place17 == 1) {
                            $department .= '<span class="btn btn-xs btn-warning" style="margin:2px">Textile Lab</span>';
                        }


                        return $department;
                    })
                    ->addColumn('download', function ($row) {
                        return "<a download href='" . route('tdms.getPdf', $row['id']) . "' target='_blank' class='btn btn-warning btn-xs'  style='margin:2px'>PDF</a>&nbsp;<a download style='margin:2px' href='" . route('tdms.getNative', $row['id']) . "' target='_blank' class='btn btn-success btn-xs'>NATIVE</a>";

                    })
                    ->rawColumns(['DOC', 'actions', 'department', 'download'])
                    ->make(true);
            }

            return view('tdms::getMasterSystem');
        }


    }

    public function getExternalPdf($id)
    {
        $row = TDMS::find($id);
        return Storage::download('TDMSBOX/ExternalDocuments/' . $row->no . '/' . $row->version . '/' . $row->pdfUrl);
    }

    public function getPdf($id)
    {
        $row = TDMS::find($id);
        return Storage::download('TDMSBOX/' . $row->docType . '-' . $row->mgmtCode . '-' . $row->actCode . '-' . $row->no . '/' . $row->version . '/' . $row->pdfUrl);
        #return view('tdms::iframe', ['url' => $url]);
        #return '<iframe frameborder="0" scrolling="no" style="border:0px" src="'.$url.'" width="500" height=500></iframe>';
    }
    
    
    public function streamPdf($id)
    {
        $row = TDMS::find($id);
        $url = Storage::path('TDMSBOX/' . $row->docType . '-' . $row->mgmtCode . '-' . $row->actCode . '-' . $row->no . '/' . $row->version . '/' . $row->pdfUrl);
        return view('tdms::iframe', ['url' => $url, 'row' => $row]);
        #return Storage::download('TDMSBOX/' . $row->docType . '-' . $row->mgmtCode . '-' . $row->actCode . '-' . $row->no . '/' . $row->version . '/' . $row->pdfUrl);
        #return view('tdms::iframe', ['url' => $url]);
        #return '<iframe frameborder="0" scrolling="no" style="border:0px" src="'.$url.'" width="500" height=500></iframe>';
    }
    
    public function viewPdf()
    {
        $filePath = storage_path('app/TDMSBOX/game.pdf');

        // Check if the file exists
        if (Storage::exists($filePath)) {
            // Read the file contents
            $fileContents = Storage::get($filePath);

            // Set the response content type as PDF
            $headers = [
                'Content-Type' => 'application/pdf',
            ];

            // Prevent the file from being downloaded
            $disposition = 'inline';

            // Return the response with file contents and headers
            return (new Response($fileContents, 200, $headers))
                ->header('Content-Disposition', $disposition);
        }

        // If the file does not exist, you may decide how to handle the error
        abort(404, '...File not found');
    }
    
    public function streamPdf2($id)
    {
        $row = TDMS::find($id);
        $url = Storage::url('TDMSBOX/' . $row->docType . '-' . $row->mgmtCode . '-' . $row->actCode . '-' . $row->no . '/' . $row->version . '/' . $row->pdfUrl);
        return response()->make($data, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$url.'"'
        ]);  
    }

    public function getNative($id)
    {
        $row = TDMS::find($id);
        return Storage::download('TDMSBOX/' . $row->docType . '-' . $row->mgmtCode . '-' . $row->actCode . '-' . $row->no . '/' . $row->version . '/' . $row->nativeUrl);
    }

    public function createExternalDocument() {
        $users = User::All();
        $managers = User::where('level','Manager')->get();
        return view('tdms::createExternalDocument', ['users' => $users, 'managers' => $managers]);
    }

    public function storeExternalDocument(Request $request)
    {


        $input = $request->all();


        // get instance of \Carbon\Carbon
        $carbon = \Morilog\Jalali\CalendarUtils::createCarbonFromFormat('Y/m/d', $input['releaseDate']);



        $path = 'TDMSBOX/ExternalDocuments/'.$input['no'].'/'.$input['version'].'/';

        if (!Storage::disk('local')->exists($path))
        {
            Storage::disk('local')->makeDirectory($path);
        }

        if($request->file('pdf')) {

            $fileName2 = $request->file('pdf')->getClientOriginalName();
            $request->file('pdf')->storeAs($path, $fileName2, 'local');
        }
//
//        $pdf = $request->file($input['pdf'])->store($path, 'local');
//        $native = $request->file($input['native'])->store($path, 'local');


        $document = new TDMS();

        $document->no = $input['no'];
        $document->docType = 'external';
        $document->version = $input['version'];
        $document->title = $input['title'];
        $document->modDesc = $input['modDesc'];
        $document->s17020 = $request->s17020 ? 1 : 0 ?? 0;
        $document->s17025 = $request->s17025 ? 1 : 0 ?? 0;
        $document->s9001 = $request->s9001 ? 1 : 0 ?? 0;
//        $document->s14001 = $request->s14001 ? 1 : 0 ?? 0;
//        $document->s45001 = $request->s45001 ? 1 : 0 ?? 0;
        $document->pages = $input['pages'];
        $document->userLevel1 = $request->userLevel1 ? 1 : 0 ?? 0;
        $document->userLevel2 = $request->userLevel2 ? 1 : 0 ?? 0;
        #$document->userLevel3 = $request->userLevel3 ? 1 : 0 ?? 0;
        $document->releaseDate = $input['releaseDate'];
        $document->releaseDateGregorian = $input['releaseDateGregorian'];
        $document->status = $input['status'];
        $document->place1 = $request->pmg ? 1 : 0 ?? 0;
        $document->place2 = $request->pmd ? 1 : 0 ?? 0;
        $document->place3 = $request->pfi ? 1 : 0 ?? 0;
        $document->place4 = $request->phr ? 1 : 0 ?? 0;
        $document->place5 = $request->pst ? 1 : 0 ?? 0;
        $document->place6 = $request->ppr ? 1 : 0 ?? 0;
        $document->place7 = $request->pqd ? 1 : 0 ?? 0;
        $document->place8 = $request->ict ? 1 : 0 ?? 0;
        $document->place9 = $request->pgc ? 1 : 0 ?? 0;
        $document->place10 = $request->pti ? 1 : 0 ?? 0;
        $document->place11 = $request->pes ? 1 : 0 ?? 0;
        $document->place12 = $request->pup ? 1 : 0 ?? 0;
        $document->place13 = $request->pnd ? 1 : 0 ?? 0;
        $document->place14 = $request->psl ? 1 : 0 ?? 0;
        $document->place15 = $request->pml ? 1 : 0 ?? 0;
        $document->place16 = $request->pws ? 1 : 0 ?? 0;
        $document->place17 = $request->ptl ? 1 : 0 ?? 0;
        $document->branch1 = $request->thr ? 1 : 0 ?? 0;
        $document->branch2 = $request->shz ? 1 : 0 ?? 0;
        $document->branch3 = $request->bnd ? 1 : 0 ?? 0;
        $document->branch4 = $request->qsm ? 1 : 0 ?? 0;
        $document->branch5 = $request->zjn ? 1 : 0 ?? 0;
        $document->branch6 = $request->mhd ? 1 : 0 ?? 0;
        $document->branch7 = $request->tbz ? 1 : 0 ?? 0;
        $document->branch8 = $request->isf ? 1 : 0 ?? 0;
        $document->branch9 = $request->buh ? 1 : 0 ?? 0;
        $document->branch10 = $request->gnv ? 1 : 0 ?? 0;
        $document->creator = Auth()->user()->id;
        #$document->userInCharge1 = $input['prepare'];
        #$document->userInCharge1Date = date('Y/m/d H:i:s');
        #$document->userInCharge2 = $input['validation'];
        #$document->userInCharge2Date = $input[''];
        #$document->userInCharge4 = $input['approve'];
        #$document->userInCharge4Date = $input[''];

        if($request->file('pdf')) {
            $document->pdfUrl = $fileName2;
        }

        $document->ip = $request->ip();
        $document->save();

        return redirect(route('tdms.indexExternalDocument'));

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function showExternalDocument($id)
    {
        $users = User::All();
        $managers = User::where('level','Manager')->get();
        $data = TDMS::find($id);
        $related_docs = TDMS::where('no',$data->no)->where('status', 2)->get();
        return view('tdms::showExternalDocument', ['data' => $data,'users' => $users, 'managers' => $managers, 'docs' => $related_docs]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function editExternalDocument($id)
    {
        $users = User::All();
        $managers = User::where('level','Manager')->get();
        $data = TDMS::find($id);
        return view('tdms::editExternalDocument', ['data' => $data,'users' => $users, 'managers' => $managers]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function updateExternalDocument(Request $request, $id)
    {
        $input = $request->all();
        $document = TDMS::find($id);

        // get instance of \Carbon\Carbon
        $carbon = \Morilog\Jalali\CalendarUtils::createCarbonFromFormat('Y/m/d', $input['releaseDate']);



        $path = 'TDMSBOX/ExternalDocuments/'.$document->no.'/'.$document->version.'/';

        if (!Storage::disk('local')->exists($path))
        {
            Storage::disk('local')->makeDirectory($path);
        }

        if($request->file('pdf')) {
            $fileName2 = $request->file('pdf')->getClientOriginalName();
            $request->file('pdf')->storeAs($path, $fileName2, 'local');
            $document->pdfUrl = $fileName2;
        }



//
//        $pdf = $request->file($input['pdf'])->store($path, 'local');
//        $native = $request->file($input['native'])->store($path, 'local');


        $document->title = $input['title'];
        $document->modDesc = $input['modDesc'];
        $document->s17020 = $request->s17020 ? 1 : 0 ?? 0;
        $document->s17025 = $request->s17025 ? 1 : 0 ?? 0;
        $document->s9001 = $request->s9001 ? 1 : 0 ?? 0;
//        $document->s14001 = $request->s14001 ? 1 : 0 ?? 0;
//        $document->s45001 = $request->s45001 ? 1 : 0 ?? 0;
        $document->pages = $input['pages'];
        $document->userLevel1 = $request->userLevel1 ? 1 : 0 ?? 0;
        $document->userLevel2 = $request->userLevel2 ? 1 : 0 ?? 0;
        #$document->userLevel3 = $request->userLevel3 ? 1 : 0 ?? 0;
        $document->releaseDate = $input['releaseDate'];
        $document->releaseDateGregorian = $input['releaseDateGregorian'];
        $document->status = $input['status'];
        $document->place1 = $request->pmg ? 1 : 0 ?? 0;
        $document->place2 = $request->pmd ? 1 : 0 ?? 0;
        $document->place3 = $request->pfi ? 1 : 0 ?? 0;
        $document->place4 = $request->phr ? 1 : 0 ?? 0;
        $document->place5 = $request->pst ? 1 : 0 ?? 0;
        $document->place6 = $request->ppr ? 1 : 0 ?? 0;
        $document->place7 = $request->pqd ? 1 : 0 ?? 0;
        $document->place8 = $request->ict ? 1 : 0 ?? 0;
        $document->place9 = $request->pgc ? 1 : 0 ?? 0;
        $document->place10 = $request->pti ? 1 : 0 ?? 0;
        $document->place11 = $request->pes ? 1 : 0 ?? 0;
        $document->place12 = $request->pup ? 1 : 0 ?? 0;
        $document->place13 = $request->pnd ? 1 : 0 ?? 0;
        $document->place14 = $request->psl ? 1 : 0 ?? 0;
        $document->place15 = $request->pml ? 1 : 0 ?? 0;
        $document->place16 = $request->pws ? 1 : 0 ?? 0;
        $document->place17 = $request->ptl ? 1 : 0 ?? 0;
        $document->branch1 = $request->thr ? 1 : 0 ?? 0;
        $document->branch2 = $request->shz ? 1 : 0 ?? 0;
        $document->branch3 = $request->bnd ? 1 : 0 ?? 0;
        $document->branch4 = $request->qsm ? 1 : 0 ?? 0;
        $document->branch5 = $request->zjn ? 1 : 0 ?? 0;
        $document->branch6 = $request->mhd ? 1 : 0 ?? 0;
        $document->branch7 = $request->tbz ? 1 : 0 ?? 0;
        $document->branch8 = $request->isf ? 1 : 0 ?? 0;
        $document->branch9 = $request->buh ? 1 : 0 ?? 0;
        $document->branch10 = $request->gnv ? 1 : 0 ?? 0;
        $document->creator = Auth()->user()->id;
        #$document->userInCharge1 = $input['prepare'];
        #$document->userInCharge1Date = date('Y/m/d H:i:s');
        #$document->userInCharge2 = $input['validation'];
        #$document->userInCharge2Date = $input[''];
        #$document->userInCharge4 = $input['approve'];
        #$document->userInCharge4Date = $input[''];
        $document->ip = $request->ip();
        $document->save();

        return redirect(route('tdms.indexExternalDocument'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */


    public function indexExternalDocument()
    {
        return view('tdms::indexExternalDocument');
    }

    public function getExternalDocumentMasterList()
    {
        global $level;
        $level .= Auth()->user()->level;

        if (Auth()->user()->department == 'Quality Development') {
            $query = TDMS::where('status', 3)->get();
        } else {
            if ($level == 'manager') {
                if (Auth()->user()->branch == 'tehran') {
                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch1', 1)->where('place1', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch1', 1)->where('place2', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch1', 1)->where('place3', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch1', 1)->where('place4', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch1', 1)->where('place5', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch1', 1)->where('place6', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch1', 1)->where('place7', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch1', 1)->where('place8', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch1', 1)->where('place9', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch1', 1)->where('place10', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch1', 1)->where('place11', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch1', 1)->where('place12', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch1', 1)->where('place13', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch1', 1)->where('place14', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch1', 1)->where('place15', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch1', 1)->where('place16', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch1', 1)->where('place17', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                    }
                }
                if (Auth()->user()->branch == 'shiraz') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch1', 1)->where('place1', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch2', 1)->where('place2', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch2', 1)->where('place3', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch2', 1)->where('place4', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch2', 1)->where('place5', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch2', 1)->where('place6', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch2', 1)->where('place7', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch2', 1)->where('place8', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch2', 1)->where('place9', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch2', 1)->where('place10', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch2', 1)->where('place11', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch2', 1)->where('place12', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch2', 1)->where('place13', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch2', 1)->where('place14', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch2', 1)->where('place15', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch2', 1)->where('place16', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch2', 1)->where('place17', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                    }
                }
                if (Auth()->user()->branch == 'bandarabbas') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch3', 1)->where('place1', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch3', 1)->where('place2', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch3', 1)->where('place3', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch3', 1)->where('place4', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch3', 1)->where('place5', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch3', 1)->where('place6', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch3', 1)->where('place7', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch3', 1)->where('place8', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch3', 1)->where('place9', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch3', 1)->where('place10', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch3', 1)->where('place11', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch3', 1)->where('place12', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch3', 1)->where('place13', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch3', 1)->where('place14', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch3', 1)->where('place15', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch3', 1)->where('place16', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch3', 1)->where('place17', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                    }
                }
                if (Auth()->user()->branch == 'qeshm') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch4', 1)->where('place1', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch4', 1)->where('place2', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch4', 1)->where('place3', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch4', 1)->where('place4', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch4', 1)->where('place5', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch4', 1)->where('place6', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch4', 1)->where('place7', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch4', 1)->where('place8', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch4', 1)->where('place9', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch4', 1)->where('place10', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch4', 1)->where('place11', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch4', 1)->where('place12', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch4', 1)->where('place13', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch4', 1)->where('place14', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch4', 1)->where('place15', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch4', 1)->where('place16', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch4', 1)->where('place17', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                    }
                }
                if (Auth()->user()->branch == 'zanjan') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch5', 1)->where('place1', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch5', 1)->where('place2', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch5', 1)->where('place3', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch5', 1)->where('place4', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch5', 1)->where('place5', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch5', 1)->where('place6', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch5', 1)->where('place7', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch5', 1)->where('place8', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch5', 1)->where('place9', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch5', 1)->where('place10', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch5', 1)->where('place11', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch5', 1)->where('place12', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch5', 1)->where('place13', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch5', 1)->where('place14', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch5', 1)->where('place15', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch5', 1)->where('place16', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch5', 1)->where('place17', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                    }
                }
                if (Auth()->user()->branch == 'mashhad') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch6', 1)->where('place1', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch6', 1)->where('place2', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch6', 1)->where('place3', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch6', 1)->where('place4', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch6', 1)->where('place5', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch6', 1)->where('place6', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch6', 1)->where('place7', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch6', 1)->where('place8', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch6', 1)->where('place9', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch6', 1)->where('place10', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch6', 1)->where('place11', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch6', 1)->where('place12', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch6', 1)->where('place13', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch6', 1)->where('place14', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch6', 1)->where('place15', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch6', 1)->where('place16', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch6', 1)->where('place17', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                    }
                }
                if (Auth()->user()->branch == 'tabriz') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch7', 1)->where('place1', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch7', 1)->where('place2', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch7', 1)->where('place3', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch7', 1)->where('place4', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch7', 1)->where('place5', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch7', 1)->where('place6', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch7', 1)->where('place7', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch7', 1)->where('place8', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch7', 1)->where('place9', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch7', 1)->where('place10', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch7', 1)->where('place11', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch7', 1)->where('place12', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch7', 1)->where('place13', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch7', 1)->where('place14', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch7', 1)->where('place15', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch7', 1)->where('place16', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch7', 1)->where('place17', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                    }
                }
                if (Auth()->user()->branch == 'isfahan') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch8', 1)->where('place1', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch8', 1)->where('place2', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch8', 1)->where('place3', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch8', 1)->where('place4', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch8', 1)->where('place5', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch8', 1)->where('place6', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch8', 1)->where('place7', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch8', 1)->where('place8', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch8', 1)->where('place9', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch8', 1)->where('place10', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch8', 1)->where('place11', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch8', 1)->where('place12', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch8', 1)->where('place13', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch8', 1)->where('place14', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch8', 1)->where('place15', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch8', 1)->where('place16', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch8', 1)->where('place17', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                    }
                }
                if (Auth()->user()->branch == 'bushehr') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch9', 1)->where('place1', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch9', 1)->where('place2', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch9', 1)->where('place3', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch9', 1)->where('place4', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch9', 1)->where('place5', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch9', 1)->where('place6', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch9', 1)->where('place7', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch9', 1)->where('place8', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch9', 1)->where('place9', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch9', 1)->where('place10', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch9', 1)->where('place11', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch9', 1)->where('place12', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch9', 1)->where('place13', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch9', 1)->where('place14', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch9', 1)->where('place15', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch9', 1)->where('place16', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch9', 1)->where('place17', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                    }
                }
                if (Auth()->user()->branch == 'genaveh') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch10', 1)->where('place1', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch10', 1)->where('place2', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch10', 1)->where('place3', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch10', 1)->where('place4', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch10', 1)->where('place5', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch10', 1)->where('place6', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch10', 1)->where('place7', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch10', 1)->where('place8', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch10', 1)->where('place9', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch10', 1)->where('place10', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch10', 1)->where('place11', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch10', 1)->where('place12', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch10', 1)->where('place13', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch10', 1)->where('place14', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch10', 1)->where('place15', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch10', 1)->where('place16', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch10', 1)->where('place17', 1)->where('userLevel2', 1)->where('status', 3)->get();
                            break;
                    }
                }
            } elseif ($level == 'expert' or $level == 'head') {
                if (Auth()->user()->branch == 'tehran') {
                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch1', 1)->where('place1', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch1', 1)->where('place2', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch1', 1)->where('place3', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch1', 1)->where('place4', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch1', 1)->where('place5', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch1', 1)->where('place6', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch1', 1)->where('place7', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch1', 1)->where('place8', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch1', 1)->where('place9', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch1', 1)->where('place10', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch1', 1)->where('place11', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch1', 1)->where('place12', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch1', 1)->where('place13', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch1', 1)->where('place14', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch1', 1)->where('place15', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch1', 1)->where('place16', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch1', 1)->where('place17', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Head Technical Inspection';
                            $query = TDMS::where('place10', 1)->where('branch1', 1)->where('userLevel1', 1)->where('status', 3)->orWhere('place11', 1)->where('branch1', 1)->where('userLevel1', 1)->where('status', 3)->orWhere('place12', 1)->where('branch1', 1)->where('userLevel1', 1)->where('status', 3)->orWhere('place13', 1)->where('branch1', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                            
                    }
                }
                if (Auth()->user()->branch == 'shiraz') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch1', 1)->where('place1', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch2', 1)->where('place2', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch2', 1)->where('place3', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch2', 1)->where('place4', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch2', 1)->where('place5', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch2', 1)->where('place6', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch2', 1)->where('place7', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch2', 1)->where('place8', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch2', 1)->where('place9', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch2', 1)->where('place10', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch2', 1)->where('place11', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch2', 1)->where('place12', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch2', 1)->where('place13', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch2', 1)->where('place14', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch2', 1)->where('place15', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch2', 1)->where('place16', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch2', 1)->where('place17', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                    }
                }
                if (Auth()->user()->branch == 'bandarabbas') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch3', 1)->where('place1', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch3', 1)->where('place2', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch3', 1)->where('place3', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch3', 1)->where('place4', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch3', 1)->where('place5', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch3', 1)->where('place6', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch3', 1)->where('place7', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch3', 1)->where('place8', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch3', 1)->where('place9', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch3', 1)->where('place10', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch3', 1)->where('place11', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch3', 1)->where('place12', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch3', 1)->where('place13', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch3', 1)->where('place14', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch3', 1)->where('place15', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch3', 1)->where('place16', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch3', 1)->where('place17', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                    }
                }
                if (Auth()->user()->branch == 'qeshm') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch4', 1)->where('place1', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch4', 1)->where('place2', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch4', 1)->where('place3', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch4', 1)->where('place4', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch4', 1)->where('place5', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch4', 1)->where('place6', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch4', 1)->where('place7', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch4', 1)->where('place8', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch4', 1)->where('place9', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch4', 1)->where('place10', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch4', 1)->where('place11', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch4', 1)->where('place12', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch4', 1)->where('place13', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch4', 1)->where('place14', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch4', 1)->where('place15', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch4', 1)->where('place16', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch4', 1)->where('place17', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                    }
                }
                if (Auth()->user()->branch == 'zanjan') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch5', 1)->where('place1', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch5', 1)->where('place2', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch5', 1)->where('place3', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch5', 1)->where('place4', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch5', 1)->where('place5', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch5', 1)->where('place6', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch5', 1)->where('place7', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch5', 1)->where('place8', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch5', 1)->where('place9', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch5', 1)->where('place10', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch5', 1)->where('place11', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch5', 1)->where('place12', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch5', 1)->where('place13', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch5', 1)->where('place14', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch5', 1)->where('place15', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch5', 1)->where('place16', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch5', 1)->where('place17', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                    }
                }
                if (Auth()->user()->branch == 'mashhad') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch6', 1)->where('place1', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch6', 1)->where('place2', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch6', 1)->where('place3', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch6', 1)->where('place4', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch6', 1)->where('place5', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch6', 1)->where('place6', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch6', 1)->where('place7', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch6', 1)->where('place8', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch6', 1)->where('place9', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch6', 1)->where('place10', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch6', 1)->where('place11', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch6', 1)->where('place12', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch6', 1)->where('place13', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch6', 1)->where('place14', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch6', 1)->where('place15', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch6', 1)->where('place16', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch6', 1)->where('place17', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                    }
                }
                if (Auth()->user()->branch == 'tabriz') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch7', 1)->where('place1', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch7', 1)->where('place2', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch7', 1)->where('place3', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch7', 1)->where('place4', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch7', 1)->where('place5', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch7', 1)->where('place6', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch7', 1)->where('place7', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch7', 1)->where('place8', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch7', 1)->where('place9', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch7', 1)->where('place10', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch7', 1)->where('place11', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch7', 1)->where('place12', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch7', 1)->where('place13', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch7', 1)->where('place14', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch7', 1)->where('place15', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch7', 1)->where('place16', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch7', 1)->where('place17', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                    }
                }
                if (Auth()->user()->branch == 'isfahan') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch8', 1)->where('place1', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch8', 1)->where('place2', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch8', 1)->where('place3', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch8', 1)->where('place4', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch8', 1)->where('place5', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch8', 1)->where('place6', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch8', 1)->where('place7', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch8', 1)->where('place8', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch8', 1)->where('place9', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch8', 1)->where('place10', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch8', 1)->where('place11', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch8', 1)->where('place12', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch8', 1)->where('place13', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch8', 1)->where('place14', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch8', 1)->where('place15', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch8', 1)->where('place16', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch8', 1)->where('place17', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                    }
                }
                if (Auth()->user()->branch == 'bushehr') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch9', 1)->where('place1', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch9', 1)->where('place2', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch9', 1)->where('place3', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch9', 1)->where('place4', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch9', 1)->where('place5', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch9', 1)->where('place6', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch9', 1)->where('place7', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch9', 1)->where('place8', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch9', 1)->where('place9', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch9', 1)->where('place10', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch9', 1)->where('place11', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch9', 1)->where('place12', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch9', 1)->where('place13', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch9', 1)->where('place14', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch9', 1)->where('place15', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch9', 1)->where('place16', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch9', 1)->where('place17', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                    }
                }
                if (Auth()->user()->branch == 'genaveh') {

                    switch (Auth()->user()->sector) {
                        case 'management':
                            $query = TDMS::where('branch10', 1)->where('place1', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'market development':
                            $query = TDMS::where('branch10', 1)->where('place2', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Financial':
                            $query = TDMS::where('branch10', 1)->where('place3', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Human Resources':
                            $query = TDMS::where('branch10', 1)->where('place4', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Strategy':
                            $query = TDMS::where('branch10', 1)->where('place5', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Procurment':
                            $query = TDMS::where('branch10', 1)->where('place6', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Quality Development':
                            $query = TDMS::where('branch10', 1)->where('place7', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'ICT':
                            $query = TDMS::where('branch10', 1)->where('place8', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'General Cargo':
                            $query = TDMS::where('branch10', 1)->where('place9', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Technical Inspection':
                            $query = TDMS::where('branch10', 1)->where('place10', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Esclator':
                            $query = TDMS::where('branch10', 1)->where('place11', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Under Pressure':
                            $query = TDMS::where('branch10', 1)->where('place12', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'NDT':
                            $query = TDMS::where('branch10', 1)->where('place13', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Structural Lab':
                            $query = TDMS::where('branch10', 1)->where('place14', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Weight & Scales Lab':
                            $query = TDMS::where('branch10', 1)->where('place15', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Mineral Lab':
                            $query = TDMS::where('branch10', 1)->where('place16', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                        case 'Textile Lab':
                            $query = TDMS::where('branch10', 1)->where('place17', 1)->where('userLevel1', 1)->where('status', 3)->get();
                            break;
                    }
                }
            }
        }

        if (request()->ajax()) {
            return datatables()->of($query)
                ->addIndexColumn()
                ->addColumn('DOC', function ($row) {
                    return $row->no;
                })
                ->addColumn('actions', function ($row) {
                    global $level;
                    $btn = '';
                    if ($level == 'manager') {
                        $btn = $btn . '<a class="btn btn-xs btn-light" href="' . route('tdms.showExternalDocument', $row->id) . '"  style="margin:2px">SHOW</a> ';
                        $btn = $btn . '<a class="btn btn-xs btn-success" href="' . route('tdms.editExternalDocument', $row->id) . '"  style="margin:2px">EDIT</a> ';;
                        $btn = $btn . '
                                    <a  style="margin:2px" class="btn btn-danger btn-xs" id="sweet-' . $row->id . '" type="button" onclick="_gaq.push([\'_trackEvent\', \'example\', \'try\', \'sweet-' . $row->id . '\']);">DELETE</a>
                    <script>
                        var SweetAlert_custom = {
                            init: function() {

                                document.querySelector("#sweet-' . $row->id . '").onclick = function(){
                                    swal({
                                        title: "Are you sure?",
                                        text: "Once deleted, you will not be able to recover this Tracking Code, all other related information will be deleted too!",
                                        icon: "warning",
                                        buttons: true,
                                        dangerMode: true,
                                    })
                                        .then((willDelete) => {
                                            if (willDelete) {
                                                     $.ajax({
                                                         url: \'/tdms/destroy/' . $row->id . '\',
                                                         type: \'get\',
                                                         dataType: \'json\'
                                                      });

                                                    swal("Document Deleted!", {
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
                                    ';


                    } else {
                        $btn = '----';
                    }
                    return $btn;
                })
                ->addColumn('department', function ($row) {
                    $department = '';
                    if ($row->place1 == 1) {
                        $department .= '<span class="btn btn-xs btn-success" style="margin:2px">Management</span>';
                    }
                    if ($row->place2 == 1) {
                        $department .= '<span class="btn btn-xs btn-warning" style="margin:2px">Market Development</span>';
                    }
                    if ($row->place3 == 1) {
                        $department .= '<span class="btn btn-xs btn-info" style="margin:2px">Financial</span>';
                    }
                    if ($row->place4 == 1) {
                        $department .= '<span class="btn btn-xs btn-primary" style="margin:2px">Human Resources</span>';
                    }
                    if ($row->place5 == 1) {
                        $department .= '<span class="btn btn-xs btn-danger" style="margin:2px">Strategy</span>';
                    }
                    if ($row->place6 == 1) {
                        $department .= '<span class="btn btn-xs btn-success" style="margin:2px">Procurment</span>';
                    }
                    if ($row->place7 == 1) {
                        $department .= '<span class="btn btn-xs btn-warning" style="margin:2px">Quality Development</span>';
                    }
                    if ($row->place8 == 1) {
                        $department .= '<span class="btn btn-xs btn-danger" style="margin:2px">ICT</span>';
                    }
                    if ($row->place9 == 1) {
                        $department .= '<span class="btn btn-xs btn-primary" style="margin:2px">General Cargo</span>';
                    }
                    if ($row->place10 == 1) {
                        $department .= '<span class="btn btn-xs btn-danger" style="margin:2px">Technical Inspection</span>';
                    }
                    if ($row->place11 == 1) {
                        $department .= '<span class="btn btn-xs btn-success" style="margin:2px">Escalator</span>';
                    }
                    if ($row->place12 == 1) {
                        $department .= '<span class="btn btn-xs btn-warning" style="margin:2px">Under Pressure</span>';
                    }
                    if ($row->place13 == 1) {
                        $department .= '<span class="btn btn-xs btn-info" style="margin:2px">NDT</span>';
                    }
                    if ($row->place14 == 1) {
                        $department .= '<span class="btn btn-xs btn-primary" style="margin:2px">Structural Lab</span>';
                    }
                    if ($row->place15 == 1) {
                        $department .= '<span class="btn btn-xs btn-danger" style="margin:2px">Mineral Lab</span>';
                    }
                    if ($row->place16 == 1) {
                        $department .= '<span class="btn btn-xs btn-success" style="margin:2px">Weight & Scales Lab</span>';
                    }
                    if ($row->place17 == 1) {
                        $department .= '<span class="btn btn-xs btn-warning" style="margin:2px">Textile Lab</span>';
                    }


                    return $department;
                })
                ->addColumn('download', function ($row) {
                    global $level;
                    if ($level == 'manager') {
                        return "<a download href='" .route('tdms.getExternalPdf', $row['id']). "' target='_blank' class='btn btn-warning btn-xs'  style='margin:2px'>PDF</a>";
                    } else {
                        return "<a download href='" .route('tdms.getExternalPdf', $row['id']). "' target='_blank' class='btn btn-warning btn-xs'  style='margin:2px'>PDF</a>";
                    }
                })
                ->rawColumns(['DOC', 'actions', 'department', 'download'])
                ->make(true);
        }

        return view('tdms::indexExternalDocument');

    }

}


