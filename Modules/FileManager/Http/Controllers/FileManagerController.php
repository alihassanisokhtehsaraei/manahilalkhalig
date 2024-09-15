<?php

namespace Modules\FileManager\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;

class FileManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index($serviceType=null,$id=null,$path=null)
    {
        if($serviceType == 'inspectionServices')
        {
            if($path == null)
            {
                $path = 'inspectionServices/'.$id;
                $order = Order::find($id);
                return view('filemanager::index', array('order' => $order, 'path' => $path));
            }
            else
            {
                $order = Order::find($id);
                $base_path = 'inspectionServices/'.$id.'/';
                return view('filemanager::index', array('order' => $order, 'path' => $base_path.$path));
            }
        }
        else
        {
            echo 'here';
            //return view('filemanager::index');
        }
    }

    public function newFolder(Request $request,$seviceType=null,$id=null)
    {
        if($seviceType== 'inspectionServices')
        {
            $path = $request->get('path');
            if(!Storage::disk('fileManager')->exists($path)) {
                Storage::disk('fileManager')->makeDirectory($path); //creates directory
            }
            if(!Storage::disk('fileManager')->exists($path.'/'.$request->get('newFolder'))) {

                Storage::disk('fileManager')->makeDirectory($path.'/'.$request->get('newFolder')); //creates directory
            }
            return back();
        }
    }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('filemanager::create');
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
        return view('filemanager::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('filemanager::edit');
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
    public function delete(Request $request)
    {
        $file = $request->get('file');
        $dest = $request->get('destination');
        if(!Storage::disk('fileManager')->exists($dest)) {
            Storage::disk('fileManager')->makeDirectory($dest);
        }
        Storage::disk('fileManager')->move($file, $dest.pathinfo($file, PATHINFO_BASENAME) );
        echo $file.'<br>'.$dest.pathinfo($file, PATHINFO_BASENAME) ;

        return back();

    }

    public function upload(Request $request)
    {
        $request->validate([
            'files' => 'required',
            'files.*' => 'required|mimes:pdf,xlx,csv,jpg,png,doc,docx,xlsx,xls,zip,rar,7z,z,tar,gz|max:204800',
        ]);

        $input = $request->all();
        $path = $input['path'];

        if ($request->file('files')) {
            foreach ($request->file('files') as $key => $file) {
                if (!Storage::disk('fileManager')->exists($path.'/'.$file->getClientOriginalName()))
                {
                    $fileName = $file->getClientOriginalName();
                    echo $fileName;
                    echo '<br>'.$path;
                }
                else
                {
                    $fileName = time() .'-'. rand(1, 99) .'-'.$file->getClientOriginalName();
                    echo $fileName;
                    echo '<br>'.$path;

                }
                $file->storeAs($path, $fileName, 'fileManager');
            }
        }

        return back();


    }
}
