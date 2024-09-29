<?php

namespace Modules\UserManagement\Http\Controllers;

use App\Models\User;
use App\Policies\MenuPolicy;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserManagementController extends Controller
{

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $query = User::where('email','<>','sysadmin@tie-co.com')->get();

        //print_r($data);

        if (request()->ajax()) {
            return datatables()->of($query)
                ->addIndexColumn()
                ->addColumn('Name', function ($row) {
                    return $row->name.' '.$row->lastname;
                })
                ->addColumn('actions', function ($row) {
                    $btn = '
                    <a href="/usermanagement/edit/' . $row->id . '" class="btn btn-success btn-xs">EDIT</a>

                    <a class="btn btn-danger btn-xs" id="sweet-' . $row->id . '" type="button" onclick="_gaq.push([\'_trackEvent\', \'example\', \'try\', \'sweet-' . $row->id . '\']);">DELETE</a>
    <script>
        var SweetAlert_custom = {
            init: function() {

                document.querySelector("#sweet-' . $row->id . '").onclick = function(){
                    swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this user, all other related information will be deleted too!",
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

                                    swal("Customer Deleted!", {
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
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('usermanagement::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('usermanagement::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $user = new User();

        $user->name = $data['name'];
        $user->lastname = $data['lastName'];
        $user->department = $data['department'];
        $user->sector = $data['sector'];
        $user->level = $data['level'];
        $user->branch = $data['branch'];
        $user->email = $data['email'];
        $user->password = Hash::make($request->input('password'));
        $user->save();
        return redirect(route('user.index'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('usermanagement::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('usermanagement::edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $user = User::find($id);


        $user->name = $data['name'];
        $user->lastname = $data['lastName'];
        $user->department = $data['department'];
        $user->sector = $data['sector'];
        $user->level = $data['level'];
        $user->branch = $data['branch'];
        $user->email = $data['email'];
        if(strlen($request->input('password') > 6)) {
            $user->password = Hash::make($request->input('password'));
        }
        $user->save();
        return redirect(route('user.index'));
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $user = User::find($id)->delete();
    }
}
