<?php

namespace Modules\Inspection\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Customer;
use App\Models\User;
use App\Models\Inspector;
use Auth;
use Session;


global $branch;
class InspectorController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $GLOBALS['branch'] = auth()->user()->branch;

        if (request()->ajax()) {
            return datatables()->of(Inspector::select('id', 'name', 'lastName', 'branch', 'city', 'mobile', 'email', 'cv', 'fieldOfStudy',))
                ->addIndexColumn()
                ->addColumn('fullName', function ($row) {
                    return $row->name.' '.$row->lastName;
                })
                ->addColumn('actions', function ($row) {
                    $btn = '
                    <a href="/inspector/getcv/' . $row->id . '" class="btn btn-warning btn-xs">CV</a>
                    <a href="/inspector/show/' . $row->id . '" class="btn btn-primary btn-xs">OPEN</a>

                    ';
                    if($row->branch == $GLOBALS['branch']) {
                        $btn = $btn . '
                        <a href="/inspector/edit/' . $row->id . '" class="btn btn-secondary btn-xs">EDIT</a>
                        <a class="btn btn-danger btn-xs" id="sweet-' . $row->id . '" type="button" onclick="_gaq.push([\'_trackEvent\', \'example\', \'try\', \'sweet-' . $row->id . '\']);">DELETE</a>
    <script>
        var SweetAlert_custom = {
            init: function() {

                document.querySelector("#sweet-' . $row->id . '").onclick = function(){
                    swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this inspector, all other related information will be deleted too!",
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

                                    swal("Inspector Deleted!", {
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
                    return $btn;
                })
                ->rawColumns(['actions','fullName'])
                ->make(true);
        }
        return view('inspection::inspector.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('inspection::inspector.create');

    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {

        $path = "inspectors";

        if(!Storage::exists($path)){
            Storage::makeDirectory($path);
        }

        $request->validate([
            'cv' => 'required|mimes:PDF,doc,docx,pdf|max:10240',
        ]);


        $input = $request->all();
        $cvName = $request->cv->getClientOriginalName();
        #$cvPath = $request->File('cv')->StoreAs($path,$cvName,'public');

        $inspector = new Inspector();
        $inspector->name = $input['name'];
        $inspector->lastName = $input['lastName'];
        $inspector->degree = $input['degree'];
        $inspector->fieldOfStudy = $input['fieldOfStudy'];
        $inspector->experties = $input['experties'];
        $inspector->workExperience = $input['workExperience'];
        $inspector->mobile = $input['mobile'];
        $inspector->email = $input['email'];
        $inspector->city = $input['city'];
        $inspector->branch = auth()->user()->branch;
        $inspector->status = '1';
        $inspector->desc = null;
        $inspector->creator = auth()->user()->id;
        $inspector->ip = $request->ip();
        $inspector->save();

        $cvPath = $request->file('cv')->storeAs('inspectors', $inspector->id.'.'.$request->cv->getClientOriginalExtension());
        $cvURL = $path.'/'.$inspector->id.'.'.$request->cv->getClientOriginalExtension();
        $inspector->cv = $cvURL;
        $inspector->save();

        return back()->with('success','Inspector '.$inspector->name." ".$inspector->lastName.' Profile Added Successfully!');

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $inspector = Inspector::find($id);
        return view('inspection::inspector.show', array('inspector' => $inspector));
    }

    public function getcv($id)
    {
        $inspector = Inspector::find($id);
        return Storage::download($inspector['cv']);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $inspector = Inspector::find($id);
        return view('inspection::inspector.edit', array('inspector' => $inspector));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $inspector = Inspector::find($id);
        $input = $request->all();

        $path = "inspectors";

        if(!Storage::exists($path)){
            Storage::makeDirectory($path);
        }

        $inspector->name = $input['name'];
        $inspector->lastName = $input['lastName'];
        $inspector->degree = $input['degree'];
        $inspector->fieldOfStudy = $input['fieldOfStudy'];
        $inspector->experties = $input['experties'];
        $inspector->workExperience = $input['workExperience'];
        $inspector->mobile = $input['mobile'];
        $inspector->email = $input['email'];
        $inspector->city = $input['city'];

        if($request->file('cv')){

            $cvPath = $request->file('cv')->storeAs('inspectors', $inspector->id.'.'.$request->cv->getClientOriginalExtension());
            $cvURL = $path.'/'.$inspector->id.'.'.$request->cv->getClientOriginalExtension();
            $inspector->cv = $cvURL;
        }
        $inspector->save();
        return back()->with('success','Inspector '.$inspector->name." ".$inspector->lastName.' Profile Updated Successfully!');


    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $inspector = Inspector::find($id)->delete();
    }
}
