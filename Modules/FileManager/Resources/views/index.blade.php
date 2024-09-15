@extends('layouts.viho')
@php
    function humanFileSize($size,$unit="") {
        totalSize($size);
      if( (!$unit && $size >= 1<<30) || $unit == "GB")
        return number_format($size/(1<<30),2)."GB";
      if( (!$unit && $size >= 1<<20) || $unit == "MB")
        return number_format($size/(1<<20),2)."MB";
      if( (!$unit && $size >= 1<<10) || $unit == "KB")
        return number_format($size/(1<<10),2)."KB";
      return number_format($size)." bytes";
    }

    global $totalSize;
    function totalSize($size)
    {
        global $totalSize;
        $totalSize += $size;

    }

    foreach (Storage::disk('fileManager')->allFiles('inspectionServices/'.$order->id) as $file) {
         totalSize(Storage::disk('fileManager')->size($file));
    }

    function fileTyper($exten)
    {
        switch(strtolower($exten)) {
            case ("jpeg");
            case ("jpg");
            case ("png");
            case ("ico");
            case ("gif");
            case ("svg");
            case ("ps");
            case ("psd");
            case ("tif");
            case ("tiff");
            case ("ai");
            case ("bmp");
                $def = 'fa-file-image-o';
                break;
            case ("aif");
            case ("cda");
            case ("mid");
            case ("midi");
            case ("mp3");
            case ("mpa");
            case ("ogg");
            case ("wav");
            case ("wma");
            case ("wpl");
                $def = 'Audio';
                break;
            case ("7z");
            case ("arj");
            case ("deb");
            case ("pkg");
            case ("rar");
            case ("gz");
            case ("tar.gz");
            case ("z");
            case ("zip");
                $def = 'fa-file-archive-o';
                break;
            case ("bin");
            case ("dmg");
            case ("iso");
            case ("toast");
            case ("vcd");
                $def = 'Disc';
                break;
            case ("csv");
            case ("dat");
            case ("db");
            case ("dbf");
            case ("log");
            case ("mdb");
            case ("sav");
            case ("sql");
            case ("tar");
            case ("xml");
                $def = 'Data';
                break;
            case ("key");
            case ("odp");
            case ("pps");
            case ("ppt");
            case ("pptx");
                $def = 'Presentation';
                break;
            case ("ods");
            case ("xlr");
            case ("xls");
            case ("xlsx");
                $def = 'fa-file-excel-o';
                break;
            case ("3g2");
            case ("3gp");
            case ("avi");
            case ("flv");
            case ("h264");
            case ("m4v");
            case ("mkv");
            case ("mov");
            case ("mp4");
            case ("mpg");
            case ("mpeg");
            case ("rm");
            case ("swf");
            case ("vob");
            case ("wmv"):
                $def = 'Video';
                break;
            case ("doc");
            case ("docx");
            case ("odt");
            case ("pdf");
            case ("rtf");
            case ("tex");
            case ("txt");
            case ("wks");
            case ("wps");
            case ("wpd"):
                $def = 'fa-file-text-o';
                break;
            default:
                $def = '';
        }

        return $def;
    }

@endphp
@section('moreCSS')
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{ asset('viho/assets/css/datatables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('viho/assets/css/sweetalert2.css')}}">
    <style>
        .visuallyhidden {
            border: 0;
            clip: rect(0 0 0 0);
            height: 1px;
            margin: -1px;
            overflow: hidden;
            padding: 0;
            position: absolute;
            width: 1px;
        }
    </style>
    <!-- Plugins css Ends-->
@endsection
@section('body')
        <div class="container-fluid">
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h3>File Manager</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                            <li class="breadcrumb-item">Apps                                     </li>
                            <li class="breadcrumb-item active">File Manager</li>
                        </ol>
                    </div>
                    <div class="col-sm-6">
                        <!-- Bookmark Start-->
                        <div class="bookmark">
                            <ul>
                                <li><a href="javascript:void(0)" data-container="body" data-bs-toggle="popover" data-placement="top" title="" data-original-title="Tables"><i data-feather="inbox"></i></a></li>
                                <li><a href="javascript:void(0)" data-container="body" data-bs-toggle="popover" data-placement="top" title="" data-original-title="Chat"><i data-feather="message-square"></i></a></li>
                                <li><a href="javascript:void(0)" data-container="body" data-bs-toggle="popover" data-placement="top" title="" data-original-title="Icons"><i data-feather="command"></i></a></li>
                                <li><a href="javascript:void(0)" data-container="body" data-bs-toggle="popover" data-placement="top" title="" data-original-title="Learning"><i data-feather="layers"></i></a></li>
                                <li><a href="javascript:void(0)"><i class="bookmark-search" data-feather="star"></i></a>
                                    <form class="form-inline search-form">
                                        <div class="form-group form-control-search">
                                            <input type="text" placeholder="Search..">
                                        </div>
                                    </form>
                                </li>
                            </ul>
                        </div>
                        <!-- Bookmark Ends-->
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-3 box-col-6 pe-0">
                    <div class="job-sidebar"><a class="btn btn-primary job-toggle" href="javascript:void(0)">file filter</a>
                        <div class="job-left-aside custom-scrollbar">
                            <div class="file-sidebar">
                                <div class="card">
                                    <div class="card-body">
                                        <ul>
                                            <li>
                                                <div class="btn btn-primary"><i data-feather="home"></i>{{ $order->tracking_no }} </div>
                                            </li>
                                            <li>
                                                <div class="btn btn-light"><i data-feather="folder"></i><a href="{{ route('file.index', 'inspectionServices/'.$order->id) }}">All</a></div>
                                            </li>
                                            @if(true==false)
                                                <li>
                                                    <div class="btn btn-light"><i data-feather="clock"></i>Recent</div>
                                                </li>
                                                <li>
                                                    <div class="btn btn-light"><i data-feather="star"></i>Starred</div>
                                                </li>
                                            @endif
                                            <li>
                                                <div class="btn btn-light"><i data-feather="trash-2"></i><a href="{{ route('file.index', 'inspectionServices/'.$order->id.'/trash%+') }}"> Deleted</a> </div>
                                            </li>
                                        </ul>
                                        <hr>
                                        <ul>
                                            <li>
                                                <div class="btn btn-outline-primary"><i data-feather="database">   </i>Storage   </div>
                                                <div class="m-t-15">
                                                    <div class="progress sm-progress-bar mb-1">
                                                        <div class="progress-bar bg-primary" role="progressbar" style="width: {{ ($totalSize/10737418240)*100 }}%" aria-valuenow="{{ $totalSize }}" aria-valuemin="0" aria-valuemax="10737418240"></div>
                                                    </div>
                                                    <h6>{{  humanFileSize($totalSize) }} of 10 GB used</h6>
                                                </div>
                                            </li>
                                        </ul>
                                        <hr>
                                        <ul>
                                            <li>
                                                <div class="btn btn-outline-primary"><i data-feather="grid">   </i>Upload Batch</div>
                                            </li>
                                            <li>
                                                <div class="pricing-plan">
                                                    <h6>Make New Folder</h6>
                                                    <form action="{{ route('file.newFolder','inspectionServices/'.$order->id) }}" method="post">
                                                        @csrf
                                                        <input type="text" class="form-control" name="newFolder" placeholder="Enter Name...">
                                                        <input type="hidden" name="path" value="{{ str_replace('%+','/',$path) }}">
                                                        <br>
                                                        <input type="submit" class="btn btn-outline-primary btn-xs" value="Create">
                                                    </form>
                                                    <img class="bg-img" src="../assets/images/dashboard/folder.png" alt="">
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-md-12 box-col-12">
                    <div class="file-content">
                        <div class="card">
                            <div class="card-header">
                                <div class="media">
                                    <form class="form-inline" action="file-manager.html#" method="get">
                                        <div class="form-group d-flex mb-0">                                      <i class="fa fa-search"></i>
                                            <input class="form-control-plaintext" type="text" placeholder="Search...">
                                        </div>
                                    </form>
                                    <div class="media-body text-end">
                                        <form class="d-inline-flex"  action="{{ route('file.upload') }}" method="POST" enctype="multipart/form-data" name="myForm">.
                                            @csrf
                                            <button class="btn btn-primary file-upload"> <i data-feather="plus-square"></i>Add New</button>
                                            <input type="file" name="files[]" id="file-input" multiple class="visuallyhidden">
                                            <input type="hidden" name='path' value="{{ str_replace('%+','/',$path) }}" >
                                            <button class="btn btn-outline-primary ms-2"><i data-feather="upload">   </i>Upload  </button>

                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body file-manager">
                                <h4>Folders</h4>
                                <h6>Folders related to the tracking code {{ $order->tracking_no }}

                                    @php
                                        $arr = explode('%+',Request::segment(5));
                                        array_pop($arr);
                                        array_pop($arr);
                                        if(count($arr) == 0) {
                                            $str = implode('%+',$arr);
                                            $arr = str_replace('%+','',$str);
                                        }
                                        else {
                                            $arr = implode('%+',$arr).'%+';
                                        }
                                    @endphp
                                    @if(Request::segment(5)) <a href="{{ route('file.index', 'inspectionServices/'.$order->id.'/'.$arr) }}" class="btn btn-success btn-xs">Go Up</a>@endif

                                    @php
                                        $path = str_replace('%+','/',$path);
                                        $directories = \Illuminate\Support\Facades\Storage::disk('fileManager')->directories($path);
                                    @endphp
                                </h6>

                                <ul class="folder">
                                    @foreach($directories as $dir)
                                        @if(substr($dir, strrpos($dir, '/') + 1) != 'trash')
                                            <li class="folder-box">
                                                <div class="media"><i class="fa fa-folder f-36 txt-warning"></i>
                                                    <div class="media-body ms-3">
                                                        <h6 class="mb-0">{{ strtoupper(substr($dir, strrpos($dir, '/') + 1)) }}</h6>
                                                        <p><a href="{{ route('file.index', 'inspectionServices/'.$order->id.'/'.Request::segment(5).substr($dir, strrpos($dir, '/') + 1)).'%+' }}">OPEN</a></p>
                                                    </div>
                                                </div>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>

                                @php
                                    $files = Storage::disk('fileManager')->files($path);
                                @endphp
                                @if($files)
                                    <h5 class="mt-4">Files</h5>
                                    <ul class="files">
                                        @foreach($files as $file)

                                            <li class="file-box">
                                                <div class="file-top"> <a href="{{ asset(storage::disk('fileManager')->url($file)) }}" >@if(pathinfo($file, PATHINFO_EXTENSION)== 'jpg') <img src="{{ asset(storage::disk('fileManager')->url($file)) }}" width="100" height="100"> @else  <i class="fa {{ fileTyper(pathinfo($file, PATHINFO_EXTENSION)) }} txt-primary"></i> @endif</a></div>
                                                <div class="file-bottom dropdown-basic">
                                                    <h6>
                                                        <a href="{{ asset(storage::disk('fileManager')->url($file)) }}" download="doc" target="_blank">
                                                            {{ pathinfo($file, PATHINFO_BASENAME) }}
                                                        </a>
                                                    </h6>
                                                    <p class="mb-1">{{ humanFileSize(Storage::disk('fileManager')->size($file)) }}</p>
                                                    <p> <b>last modified : <br></b> {{ date('Y-m-d H:i:s' ,storage::disk('fileManager')->lastModified($file)) }}</p>

                                                    @if(!str_contains($path,'trash'))
                                                        <p style="text-align: center">
                                                            <form action="{{ route('file.delete') }}" method="post">
                                                                @csrf
                                                                <input type="hidden" value="{{ $file }}" name="file">
                                                                <input type="hidden" value="{{ 'inspectionServices/'.$order->id.'/trash/' }}" name="destination">
                                                                <input class="btn btn-danger btn-xs" type="submit" value="Trash">
                                                                &nbsp;<a href="#" class="btn btn-success btn-xs" >Properties</a>
                                                            </form>
                                                        </p>
                                                    @endif

                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

<!-- Container-fluid Ends-->
@section('moreJs')
    <!-- Plugins JS start-->
    <script src="{{ asset('viho/assets/js/sweet-alert/sweetalert.min.js')}}"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script src="{{ asset('viho/assets/js/tooltip-init.js')}}"></script>
    <script src="{{ asset('viho/assets/js/script.js')}}"></script>
    <!-- Plugins JS Ends-->

    <script >
        $('.file-upload').on('click', function(e) {
            e.preventDefault();
            $('#file-input').trigger('click');
        });
    </script>
@endsection
