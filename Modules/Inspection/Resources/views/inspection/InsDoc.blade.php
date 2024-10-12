@php
use Illuminate\Support\Str;
@endphp
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
        <div class="row">
            <div class="col-xl-3 box-col-6 pe-0">
                <div class="job-sidebar"><a class="btn btn-primary job-toggle" href="javascript:void(0)">file filter</a>
                    <div class="job-left-aside custom-scrollbar">
                        <div class="file-sidebar">
                            <div class="card">
                                <div class="card-body">
                                    <ul>
                                        <li>
                                            <div class="btn btn-primary"><a href="{{ route('inspection.show', $order->id) }}" style="color: white"><i data-feather="home"></i>{{ $order->tracking_no }}</a></div>
                                        </li>
                                        <li>
                                            <div class="btn btn-light"><a href="{{ route('inspection.insdoc', [$order->id, 'client']) }}" ><i data-feather="folder"></i>Client Docs</a></div>
                                        </li>
                                        <li>
                                            <div class="btn btn-light"><a href="{{ route('inspection.insdoc', [$order->id, 'inspection']) }}" ><i data-feather="folder"></i>Inspection Docs</a></div>
                                        </li>
                                        <li>
                                            <div class="btn btn-light"><a href="{{ route('inspection.insdoc', [$order->id, 'laboratory']) }}" ><i data-feather="folder"></i>Laboratory Docs</a></div>
                                        </li>
                                        <li>
                                            <div class="btn btn-light"><a href="{{ route('inspection.insdoc', [$order->id, 'other']) }}" ><i data-feather="alert-circle"></i>Other Docs</a></div>
                                        </li>
                                        <li>
                                            <div class="btn btn-light"><a href="{{ route('inspection.insdoc', [$order->id, 'all']) }}" ><i data-feather="star"></i>All Docs</a></div>
                                        </li>
                                    </ul>
                                    <hr>
                                    <ul>
                                        <li>
                                            <div class="btn btn-outline-primary"><i data-feather="database">   </i>Storage   </div>
                                            <div class="m-t-15">
                                                <div class="progress sm-progress-bar mb-1">
                                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <h6>25 GB of 100 GB used</h6>
                                            </div>
                                        </li>
                                    </ul>
                                    <hr>
                                    <ul>
                                        <li>
                                            <div class="btn btn-outline-primary"><i data-feather="grid">   </i>COC Package</div>
                                        </li>
                                        <!--<li>
                                            <div class="pricing-plan">
                                                <h6>Item </h6>
                                                <h5>Problems</h5>
                                                <p> 100 GB Space</p>
                                                <div class="btn btn-outline-primary btn-xs">Selected</div><img class="bg-img" src="{{ asset('theme/viho/assets/images/dashboard/folder.png')}}" alt="">
                                            </div>
                                        </li>
                                        <li>
                                            <div class="pricing-plan">
                                                <h6>Premium</h6>
                                                <h5>$5/month</h5>
                                                <p> 200 GB Space</p>
                                                <div class="btn btn-outline-primary btn-xs">Contact Us</div><img class="bg-img" src="{{ asset('theme/viho/assets/images/dashboard/folder1.png')}}" alt="">
                                            </div>
                                        </li> -->
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
                        </div>

                        @if(request()->segment(4) === 'inspection')
                            <div class="card-body file-manager">
                                <h4>Inspection Documents</h4>
                                <h6>All inspection documents such as inspection report, visit report, photos, videos and etc.</h6>
                                <form name="upload" action="{{ route('insdoc.storeins', $order->id) }}" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                                    @csrf
                                    <ul class="files">
                                        <li class="file-box">
                                            <h6>Inspection Report</h6>
                                            <sub class="mb-1">JPG|PNG|PDF</sub>
                                            <br><br>
                                            <input class="form-control"  name="ir[]" type="file" multiple="">
                                            <div class="file-bottom"></div>
                                        </li>
                                        <li class="file-box">
                                            <h6>Visit Report</h6>
                                            <sub class="mb-1">JPG|PNG|PDF</sub>
                                            <br><br>
                                            <input class="form-control"  name="vr[]" type="file" multiple="">
                                            <div class="file-bottom"></div>
                                        </li>
                                        <li class="file-box">
                                            <h6>Sampling Form</h6>
                                            <sub class="mb-1">JPG|PNG|PDF</sub>
                                            <br><br>
                                            <input class="form-control"  name="sf[]" type="file" multiple="">
                                            <div class="file-bottom"></div>
                                        </li>
                                        <li class="file-box">
                                            <h6>Photos</h6>
                                            <sub class="mb-1">JPG|PNG|PDF</sub>
                                            <br><br>
                                            <input class="form-control"  name="photo[]" type="file" multiple="">
                                            <div class="file-bottom"></div>
                                        </li>
                                        <li class="file-box">
                                            <h6>Videos</h6>
                                            <sub class="mb-1">JPG|PNG|PDF</sub>
                                            <br><br>
                                            <input class="form-control"  name="video[]" type="file" multiple="">
                                            <div class="file-bottom"></div>
                                        </li>
                                        <li class="file-box">
                                            <h6>Sample Receipt</h6>
                                            <sub class="mb-1">JPG|PNG|PDF</sub>
                                            <br><br>
                                            <input class="form-control"  name="sr[]" type="file" multiple="">
                                            <div class="file-bottom"></div>
                                        </li>
                                        <li class="file-box">
                                            <h6>Inspection Contract</h6>
                                            <sub class="mb-1">JPG|PNG|PDF</sub>
                                            <br><br>
                                            <input class="form-control"  name="contract[]" type="file" multiple="">
                                            <div class="file-bottom"></div>
                                        </li>
                                        <li class="file-box">
                                            <h6>IC / COI Cert</h6>
                                            <sub class="mb-1">JPG|PNG|PDF</sub>
                                            <br><br>
                                            <input class="form-control"  name="cert[]" type="file" multiple="">
                                            <div class="file-bottom"></div>
                                        </li>
                                    </ul>
                                    <br>
                                    <div class="row">
                                        <div class="media">
                                            <div class="media-body text-end">
                                                @if(Auth()->user()->department == 'cosqc' or Auth()->user()->department == 'customs')
                                                @elseif($order->technicalStatus <= 4)
                                                    <button type="submit" class="btn btn-outline-primary ms-2" style="float: left"><i data-feather="upload">   </i>Upload</button>
                                                @elseif($order->technicalStatus > 4 and (auth()->user()->department == 'inspection' or auth()->user()->department == 'management') and auth()->user()->level=='manager')
                                                    <button type="submit" class="btn btn-outline-primary ms-2" style="float: left"><i data-feather="upload">   </i>Upload</button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <h5 class="mt-4">Uploaded Files</h5>
                                <ul class="files">
                                    @foreach($docs as $doc)
                                        <li class="file-box">
                                            <div class="file-top">
                                                @if (in_array(pathinfo($doc->title, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'bmp']))
                                                    <img width="100%" height="100%" src="{{ Storage::disk('fileManager')->url($doc->url) }}" alt="{{ $doc->title }}">
                                                @else
                                                    <a href="{{ Storage::disk('fileManager')->url($doc->url) }}" target="_blank">
                                                        @if (Str::endsWith($doc->title, ['.zip', '.rar']))
                                                            <i class="fa fa-file-archive-o txt-secondary"></i>
                                                        @elseif (Str::endsWith($doc->title, '.pdf'))
                                                            <i class="fa fa-file-pdf-o txt-danger"></i>
                                                        @elseif (Str::endsWith($doc->title, ['.doc', '.docx']))
                                                            <i class="fa fa-file-word-o txt-primary"></i>
                                                        @elseif (Str::endsWith($doc->title, ['.xls', '.xlsx']))
                                                            <i class="fa fa-file-excel-o txt-success"></i>
                                                        @elseif (Str::endsWith($doc->title, ['.ppt', '.pptx']))
                                                            <i class="fa fa-file-powerpoint-o txt-warning"></i>
                                                        @else
                                                            <i class="fa fa-file-o txt-secondary"></i>
                                                        @endif
                                                    </a>
                                                @endif
                                                <a href="{{ Storage::disk('fileManager')->url($doc->url) }}" target="_blank"><i class="f-14 ellips">{{  $doc->desc }}</i></a>

                                            </div>
                                            <div class="file-bottom">
                                                <a href="{{ Storage::disk('fileManager')->url($doc->url) }}" target="_blank"><h6>{{(strlen($doc->title) > 15 ? substr($doc->title, 0, 15).'...' : $doc->title) }}</h6></a>
                                                <p class="mb-1"><b>Creator:</b> {{ $doc->uploader->name." ".$doc->uploader->lastname }}</p>
                                                <p class="mb-1"><b>Reviewer:</b> @if($doc->reviewerID != null){{ $doc->reviewer->name." ".$doc->reviewer->lastname }} @else ---- @endif</p>
                                                @if(auth()->user()->department != 'cosqc') <p> <b>created at: </b> {{ $doc->created_at }}</p>@endif
                                                <p> <b>Actions: </b>
                                                    <br>
                                                    <a href="{{ Storage::disk('fileManager')->url($doc->url) }}" class="btn btn-xs btn-primary" target="_blank">Download</a>
                                                    @if($doc->status == 0 or $doc->status == 1 or Auth()->user()->level == 'head' or Auth()->user()->level == 'manager')
                                                        <a href="{{ route('insdoc.destroy', $doc->id) }}" class="btn btn-xs btn-danger" >Delete</a>
                                                    @endif
                                                </p>
                                                <p class="mb-1"><b>Status:</b>
                                                    @switch($doc->status)
                                                        @case ('0')
                                                            <button class="btn btn-xs btn-warning" type="button">waiting for review</button>
                                                            @break
                                                        @case ('1')
                                                            <button class="btn btn-xs btn-danger" type="button">Document Rejected</button>
                                                            @break
                                                        @case ('2')
                                                            <button class="btn btn-xs btn-success" type="button">Document Accepted</button>
                                                            @break
                                                    @endswitch
                                                </p>

                                                @if((auth()->user()->department == 'inspection' or auth()->user()->department == 'management') and (auth()->user()->level=='manager' or auth()->user()->level=='head'))
                                                    <div class="btn-group" style="text-align: center" role="group" aria-label="Basic example">
                                                        <a href="{{ route('insdoc.changeStatus', [$doc->id, 2]) }}" class="btn btn-xs btn-primary" type="button">Accept</a>
                                                        <a href="{{ route('insdoc.changeStatus', [$doc->id, 1]) }}" class="btn btn-xs btn-danger" type="button">Reject</a>
                                                    </div>
                                                @endif
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @elseif(request()->segment(4) === 'laboratory')
                            <div class="card-body file-manager">
                                <h4>Laboratory Documents</h4>
                                <h6>All Laboratory documents such as test reports, Lab's 17025 certificate and etc.</h6>
                                <form name="upload" action="{{ route('insdoc.storelab', $order->id) }}" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                                    @csrf
                                <ul class="files">
                                    <li class="file-box">
                                        <h6>Test Report</h6>
                                        <sub class="mb-1">JPG|PNG|PDF</sub>
                                        <br><br>
                                        <input class="form-control"  name="tr[]" type="file" multiple="">
                                        <div class="file-bottom"></div>
                                    </li>
                                    <li class="file-box">
                                        <h6>TR Verification</h6>
                                        <sub class="mb-1">JPG|PNG|PDF</sub>
                                        <br><br>
                                        <input class="form-control"  name="trv[]" type="file" multiple="">
                                        <div class="file-bottom"></div>
                                    </li>
                                    <li class="file-box">
                                        <h6>17025 Certificate</h6>
                                        <sub class="mb-1">JPG|PNG|PDF</sub>
                                        <br><br>
                                        <input class="form-control"  name="iso17025[]" type="file" multiple="">
                                        <div class="file-bottom"></div>
                                    </li>
                                    <li class="file-box">
                                        <h6>Test Request Letter</h6>
                                        <sub class="mb-1">JPG|PNG|PDF</sub>
                                        <br><br>
                                        <input class="form-control"  name="trl[]" type="file" multiple="">
                                        <div class="file-bottom"></div>
                                    </li>
                                </ul>
                                <br>
                                <div class="row">
                                    <div class="media">
                                        <div class="media-body text-end">
                                            @if(Auth()->user()->department == 'cosqc' or Auth()->user()->department == 'customs')
                                            @elseif($order->technicalStatus <= 4)
                                                <button type="submit" class="btn btn-outline-primary ms-2" style="float: left"><i data-feather="upload">   </i>Upload</button>
                                            @elseif($order->technicalStatus > 4 and (auth()->user()->department == 'inspection' or auth()->user()->department == 'management') and auth()->user()->level=='manager')
                                                <button type="submit" class="btn btn-outline-primary ms-2" style="float: left"><i data-feather="upload">   </i>Upload</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                </form>
                                <h5 class="mt-4">Uploaded Files</h5>
                                <ul class="files">
                                    @foreach($docs as $doc)
                                        <li class="file-box">
                                            <div class="file-top">
                                                @if (in_array(pathinfo($doc->title, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'bmp']))
                                                    <img width="100%" height="100%" src="{{ Storage::disk('fileManager')->url($doc->url) }}" alt="{{ $doc->title }}">
                                                @else
                                                    <a href="{{ Storage::disk('fileManager')->url($doc->url) }}" target="_blank">
                                                        @if (Str::endsWith($doc->title, ['.zip', '.rar']))
                                                            <i class="fa fa-file-archive-o txt-secondary"></i>
                                                        @elseif (Str::endsWith($doc->title, '.pdf'))
                                                            <i class="fa fa-file-pdf-o txt-danger"></i>
                                                        @elseif (Str::endsWith($doc->title, ['.doc', '.docx']))
                                                            <i class="fa fa-file-word-o txt-primary"></i>
                                                        @elseif (Str::endsWith($doc->title, ['.xls', '.xlsx']))
                                                            <i class="fa fa-file-excel-o txt-success"></i>
                                                        @elseif (Str::endsWith($doc->title, ['.ppt', '.pptx']))
                                                            <i class="fa fa-file-powerpoint-o txt-warning"></i>
                                                        @else
                                                            <i class="fa fa-file-o txt-secondary"></i>
                                                        @endif
                                                    </a>
                                                @endif
                                                <a href="{{ Storage::disk('fileManager')->url($doc->url) }}" target="_blank"><i class="f-14 ellips">{{  $doc->desc }}</i></a>

                                            </div>
                                            <div class="file-bottom">
                                                <a href="{{ Storage::disk('fileManager')->url($doc->url) }}" target="_blank"><h6>{{(strlen($doc->title) > 15 ? substr($doc->title, 0, 15).'...' : $doc->title) }}</h6></a>
                                                <p class="mb-1"><b>Creator:</b> {{ $doc->uploader->name." ".$doc->uploader->lastname }}</p>
                                                <p class="mb-1"><b>Reviewer:</b> @if($doc->reviewerID != null){{ $doc->reviewer->name." ".$doc->reviewer->lastname }} @else ---- @endif</p>
                                                @if(auth()->user()->department != 'cosqc') <p> <b>created at: </b> {{ $doc->created_at }}</p>@endif
                                                <p> <b>Actions: </b>
                                                    <br>
                                                    <a href="{{ Storage::disk('fileManager')->url($doc->url) }}" class="btn btn-xs btn-primary" target="_blank">Download</a>
                                                    @if($doc->status == 0 or $doc->status == 1 or Auth()->user()->level == 'head' or Auth()->user()->level == 'manager')
                                                        <a href="{{ route('insdoc.destroy', $doc->id) }}" class="btn btn-xs btn-danger" >Delete</a>
                                                    @endif
                                                </p>
                                                <p class="mb-1"><b>Status:</b>
                                                    @switch($doc->status)
                                                        @case ('0')
                                                            <button class="btn btn-xs btn-warning" type="button">waiting for review</button>
                                                            @break
                                                        @case ('1')
                                                            <button class="btn btn-xs btn-danger" type="button">Document Rejected</button>
                                                            @break
                                                        @case ('2')
                                                            <button class="btn btn-xs btn-success" type="button">Document Accepted</button>
                                                            @break
                                                    @endswitch
                                                </p>

                                                @if((auth()->user()->department == 'inspection' or auth()->user()->department == 'management') and (auth()->user()->level=='manager' or auth()->user()->level=='head'))
                                                    <div class="btn-group" style="text-align: center" role="group" aria-label="Basic example">
                                                        <a href="{{ route('insdoc.changeStatus', [$doc->id, 2]) }}" class="btn btn-xs btn-primary" type="button">Accept</a>
                                                        <a href="{{ route('insdoc.changeStatus', [$doc->id, 1]) }}" class="btn btn-xs btn-danger" type="button">Reject</a>
                                                    </div>
                                                @endif
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @elseif(request()->segment(4) === 'other')
                            <div class="card-body file-manager">
                                <h4>Other Documents</h4>
                                <h6>All other documents</h6>
                                <form name="upload" action="{{ route('insdoc.storeother', $order->id) }}" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                                    @csrf
                                <ul class="files">
                                    <li class="file-box">
                                        <h6>Other Document</h6>
                                        <sub class="mb-1">JPG|PNG|PDF</sub>
                                        <br><br>
                                        <input class="form-control"  name="other[]" type="file" multiple="">

                                        <div class="file-bottom">

                                        </div>
                                    </li>
                                </ul>
                                <br>
                                <div class="row">
                                    <div class="media">
                                        <div class="media-body text-end">
                                            @if(Auth()->user()->department == 'cosqc' or Auth()->user()->department == 'customs')
                                            @elseif($order->technicalStatus <= 4)
                                                <button type="submit" class="btn btn-outline-primary ms-2" style="float: left"><i data-feather="upload">   </i>Upload</button>
                                            @elseif($order->technicalStatus > 4 and (auth()->user()->department == 'inspection' or auth()->user()->department == 'management') and auth()->user()->level=='manager')
                                                <button type="submit" class="btn btn-outline-primary ms-2" style="float: left"><i data-feather="upload">   </i>Upload</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                </form>
                                <h5 class="mt-4">Uploaded Files</h5>
                                <ul class="files">
                                    @foreach($docs as $doc)
                                        <li class="file-box">
                                            <div class="file-top">
                                                @if (in_array(pathinfo($doc->title, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'bmp']))
                                                    <img width="100%" height="100%" src="{{ Storage::disk('fileManager')->url($doc->url) }}" alt="{{ $doc->title }}">
                                                @else
                                                    <a href="{{ Storage::disk('fileManager')->url($doc->url) }}" target="_blank">
                                                        @if (Str::endsWith($doc->title, ['.zip', '.rar']))
                                                            <i class="fa fa-file-archive-o txt-secondary"></i>
                                                        @elseif (Str::endsWith($doc->title, '.pdf'))
                                                            <i class="fa fa-file-pdf-o txt-danger"></i>
                                                        @elseif (Str::endsWith($doc->title, ['.doc', '.docx']))
                                                            <i class="fa fa-file-word-o txt-primary"></i>
                                                        @elseif (Str::endsWith($doc->title, ['.xls', '.xlsx']))
                                                            <i class="fa fa-file-excel-o txt-success"></i>
                                                        @elseif (Str::endsWith($doc->title, ['.ppt', '.pptx']))
                                                            <i class="fa fa-file-powerpoint-o txt-warning"></i>
                                                        @else
                                                            <i class="fa fa-file-o txt-secondary"></i>
                                                        @endif
                                                    </a>
                                                @endif
                                                <a href="{{ Storage::disk('fileManager')->url($doc->url) }}" target="_blank"><i class="f-14 ellips">{{  $doc->category }}</i></a>

                                            </div>
                                            <div class="file-bottom">
                                                <a href="{{ Storage::disk('fileManager')->url($doc->url) }}" target="_blank"><h6>{{(strlen($doc->title) > 15 ? substr($doc->title, 0, 15).'...' : $doc->title) }}</h6></a>
                                                <p class="mb-1"><b>Creator:</b> {{ $doc->uploader->name." ".$doc->uploader->lastname }}</p>
                                                <p class="mb-1"><b>Reviewer:</b> @if($doc->reviewerID != null){{ $doc->reviewer->name." ".$doc->reviewer->lastname }} @else ---- @endif</p>
                                                @if(auth()->user()->department != 'cosqc') <p> <b>created at: </b> {{ $doc->created_at }}</p>@endif
                                                <p> <b>Actions: </b>
                                                    <br>
                                                    <a href="{{ Storage::disk('fileManager')->url($doc->url) }}" class="btn btn-xs btn-primary" target="_blank">Download</a>
                                                    @if($doc->status == 0 or $doc->status == 1 or Auth()->user()->level == 'head' or Auth()->user()->level == 'manager')
                                                        <a href="{{ route('insdoc.destroy', $doc->id) }}" class="btn btn-xs btn-danger" >Delete</a>
                                                    @endif
                                                </p>
                                                <p class="mb-1"><b>Status:</b>
                                                    @switch($doc->status)
                                                        @case ('0')
                                                            <button class="btn btn-xs btn-warning" type="button">waiting for review</button>
                                                            @break
                                                        @case ('1')
                                                            <button class="btn btn-xs btn-danger" type="button">Document Rejected</button>
                                                            @break
                                                        @case ('2')
                                                            <button class="btn btn-xs btn-success" type="button">Document Accepted</button>
                                                            @break
                                                    @endswitch
                                                </p>

                                                @if((auth()->user()->department == 'inspection' or auth()->user()->department == 'management') and (auth()->user()->level=='manager' or auth()->user()->level=='head'))
                                                    <div class="btn-group" style="text-align: center" role="group" aria-label="Basic example">
                                                        <a href="{{ route('insdoc.changeStatus', [$doc->id, 2]) }}" class="btn btn-xs btn-primary" type="button">Accept</a>
                                                        <a href="{{ route('insdoc.changeStatus', [$doc->id, 1]) }}" class="btn btn-xs btn-danger" type="button">Reject</a>
                                                    </div>
                                                @endif
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @elseif(request()->segment(4) === 'all')
                            <div class="card-body file-manager">
                                <h4>All Documents</h4>
                                <ul class="files">
                                    @foreach($docs as $doc)
                                        <li class="file-box">
                                            <div class="file-top">
                                                @if (in_array(pathinfo($doc->title, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'bmp']))
                                                    <img width="100%" height="100%" src="{{ Storage::disk('fileManager')->url($doc->url) }}" alt="{{ $doc->title }}">
                                                @else
                                                    <a href="{{ Storage::disk('fileManager')->url($doc->url) }}" target="_blank">
                                                        @if (Str::endsWith($doc->title, ['.zip', '.rar']))
                                                            <i class="fa fa-file-archive-o txt-secondary"></i>
                                                        @elseif (Str::endsWith($doc->title, '.pdf'))
                                                            <i class="fa fa-file-pdf-o txt-danger"></i>
                                                        @elseif (Str::endsWith($doc->title, ['.doc', '.docx']))
                                                            <i class="fa fa-file-word-o txt-primary"></i>
                                                        @elseif (Str::endsWith($doc->title, ['.xls', '.xlsx']))
                                                            <i class="fa fa-file-excel-o txt-success"></i>
                                                        @elseif (Str::endsWith($doc->title, ['.ppt', '.pptx']))
                                                            <i class="fa fa-file-powerpoint-o txt-warning"></i>
                                                        @else
                                                            <i class="fa fa-file-o txt-secondary"></i>
                                                        @endif
                                                    </a>
                                                @endif
                                                <a href="{{ Storage::disk('fileManager')->url($doc->url) }}" target="_blank"><i class="f-14 ellips">{{  $doc->category }}</i></a>

                                            </div>
                                            <div class="file-bottom">
                                                <a href="{{ Storage::disk('fileManager')->url($doc->url) }}" target="_blank"><h6>{{(strlen($doc->title) > 15 ? substr($doc->title, 0, 15).'...' : $doc->title) }}</h6></a>
                                                <p class="mb-1"><b>Creator:</b> {{ $doc->uploader->name." ".$doc->uploader->lastname }}</p>
                                                <p class="mb-1"><b>Reviewer:</b> @if($doc->reviewerID != null){{ $doc->reviewer->name." ".$doc->reviewer->lastname }} @else ---- @endif</p>
                                                @if(auth()->user()->department != 'cosqc') <p> <b>created at: </b> {{ $doc->created_at }}</p>@endif
                                                <p> <b>Actions: </b>
                                                    <br>
                                                    <a href="{{ Storage::disk('fileManager')->url($doc->url) }}" class="btn btn-xs btn-primary" target="_blank">Download</a>
                                                    @if($doc->status == 0 or $doc->status == 1 or Auth()->user()->level == 'head' or Auth()->user()->level == 'manager')
                                                        <a href="{{ route('insdoc.destroy', $doc->id) }}" class="btn btn-xs btn-danger" >Delete</a>
                                                    @endif
                                                </p>
                                                <p class="mb-1"><b>Status:</b>
                                                    @switch($doc->status)
                                                        @case ('0')
                                                            <button class="btn btn-xs btn-warning" type="button">waiting for review</button>
                                                            @break
                                                        @case ('1')
                                                            <button class="btn btn-xs btn-danger" type="button">Document Rejected</button>
                                                            @break
                                                        @case ('2')
                                                            <button class="btn btn-xs btn-success" type="button">Document Accepted</button>
                                                            @break
                                                    @endswitch
                                                </p>

                                                @if((auth()->user()->department == 'inspection' or auth()->user()->department == 'management') and (auth()->user()->level=='manager' or auth()->user()->level=='head'))
                                                    <div class="btn-group" style="text-align: center" role="group" aria-label="Basic example">
                                                        <a href="{{ route('insdoc.changeStatus', [$doc->id, 2]) }}" class="btn btn-xs btn-primary" type="button">Accept</a>
                                                        <a href="{{ route('insdoc.changeStatus', [$doc->id, 1]) }}" class="btn btn-xs btn-danger" type="button">Reject</a>
                                                    </div>
                                                @endif
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <div class="card-body file-manager">
                                <h4>Client Documents</h4>
                                <h6>PI, Invoice, Packing list and transportation documents</h6>
                                <form name="upload" action="{{ route('insdoc.storeclient', $order->id) }}" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                                    @csrf
                                <ul class="files">
                                    <li class="file-box">
                                        <h6>Proforma Invoice</h6>
                                        <sub class="mb-1">JPG|PNG|PDF</sub>
                                        <br><br>
                                        <input class="form-control"  name="pi[]" type="file" multiple="">

                                        <div class="file-bottom">

                                        </div>
                                    </li>

                                    <li class="file-box">
                                        <h6>Commercial Invoice</h6>
                                        <sub class="mb-1">JPG|PNG|PDF</sub>
                                        <br><br>
                                        <input class="form-control"  name="ci[]" type="file" multiple="">

                                        <div class="file-bottom">

                                        </div>
                                    </li>

                                    <li class="file-box">
                                        <h6>Packing List</h6>
                                        <sub class="mb-1">JPG|PNG|PDF</sub>
                                        <br><br>
                                        <input class="form-control"  name="pl[]" type="file" multiple="">

                                        <div class="file-bottom">

                                        </div>
                                    </li>

                                    <li class="file-box">
                                        <h6>Order Registration</h6>
                                        <sub class="mb-1">JPG|PNG|PDF</sub>
                                        <br><br>
                                        <input class="form-control"  name="og[]" type="file" multiple="">

                                        <div class="file-bottom">

                                        </div>
                                    </li>

                                    <li class="file-box">
                                        <h6>Warehouse Receipt</h6>
                                        <sub class="mb-1">JPG|PNG|PDF</sub>
                                        <br><br>
                                        <input class="form-control"  name="wr[]" type="file" multiple="">

                                        <div class="file-bottom">

                                        </div>
                                    </li>

                                    <li class="file-box">
                                        <h6>BL</h6>
                                        <sub class="mb-1">JPG|PNG|PDF</sub>
                                        <br><br>
                                        <input class="form-control"  name="bl[]" type="file" multiple="">

                                        <div class="file-bottom">

                                        </div>
                                    </li>

                                    <li class="file-box">
                                        <h6>Cert of Origin</h6>
                                        <sub class="mb-1">JPG|PNG|PDF</sub>
                                        <br><br>
                                        <input class="form-control"  name="co[]" type="file" multiple="">

                                        <div class="file-bottom">

                                        </div>
                                    </li>

                                    <li class="file-box">
                                        <h6>Insurance Cert.</h6>
                                        <sub class="mb-1">JPG|PNG|PDF</sub>
                                        <br><br>
                                        <input class="form-control"  name="in[]" type="file" multiple="">

                                        <div class="file-bottom">

                                        </div>
                                    </li>

                                    <li class="file-box">
                                        <h6>Cottage</h6>
                                        <sub class="mb-1">JPG|PNG|PDF</sub>
                                        <br><br>
                                        <input class="form-control"  name="cot[]" type="file" multiple="">

                                        <div class="file-bottom">

                                        </div>
                                    </li>

                                    <li class="file-box">
                                        <h6>MD / SD</h6>
                                        <sub class="mb-1">JPG|PNG|PDF</sub>
                                        <br><br>
                                        <input class="form-control"  name="md[]" type="file" multiple="">

                                        <div class="file-bottom">

                                        </div>
                                    </li>

                                    <li class="file-box">
                                        <h6>Commitment letter</h6>
                                        <sub class="mb-1">JPG|PNG|PDF</sub>
                                        <br><br>
                                        <input class="form-control"  name="rl[]" type="file" multiple="">

                                        <div class="file-bottom">

                                        </div>
                                    </li>
                                </ul>
                                <br>
                                <div class="row">

                                    <div class="media">
                                        <div class="media-body text-end">
                                            @if(Auth()->user()->department == 'cosqc' or Auth()->user()->department == 'customs')
                                            @elseif($order->technicalStatus <= 4)
                                                <button type="submit" class="btn btn-outline-primary ms-2" style="float: left"><i data-feather="upload">   </i>Upload</button>
                                            @elseif($order->technicalStatus > 4 and (auth()->user()->department == 'inspection' or auth()->user()->department == 'management') and auth()->user()->level=='manager')
                                                <button type="submit" class="btn btn-outline-primary ms-2" style="float: left"><i data-feather="upload">   </i>Upload</button>
                                            @endif
                                    </div>
                                </div>
                                </div>
                                </form>

                                <h5 class="mt-4">Uploaded Files</h5>
                                <ul class="files">
                                    @foreach($docs as $doc)
                                        <li class="file-box">
                                            <div class="file-top">
                                                @if (in_array(pathinfo($doc->title, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'bmp']))
                                                    <img width="100%" height="100%" src="{{ Storage::disk('fileManager')->url($doc->url) }}" alt="{{ $doc->title }}">
                                                @else
                                                    <a href="{{ Storage::disk('fileManager')->url($doc->url) }}" target="_blank">
                                                        @if (Str::endsWith($doc->title, ['.zip', '.rar']))
                                                            <i class="fa fa-file-archive-o txt-secondary"></i>
                                                        @elseif (Str::endsWith($doc->title, '.pdf'))
                                                            <i class="fa fa-file-pdf-o txt-danger"></i>
                                                        @elseif (Str::endsWith($doc->title, ['.doc', '.docx']))
                                                            <i class="fa fa-file-word-o txt-primary"></i>
                                                        @elseif (Str::endsWith($doc->title, ['.xls', '.xlsx']))
                                                            <i class="fa fa-file-excel-o txt-success"></i>
                                                        @elseif (Str::endsWith($doc->title, ['.ppt', '.pptx']))
                                                            <i class="fa fa-file-powerpoint-o txt-warning"></i>
                                                        @else
                                                            <i class="fa fa-file-o txt-secondary"></i>
                                                        @endif
                                                    </a>
                                                @endif
                                                <a href="{{ Storage::disk('fileManager')->url($doc->url) }}" target="_blank"><i class="f-14 ellips">{{  $doc->desc }}</i></a>

                                            </div>
                                            <div class="file-bottom">
                                                <a href="{{ Storage::disk('fileManager')->url($doc->url) }}" target="_blank"><h6>{{(strlen($doc->title) > 15 ? substr($doc->title, 0, 15).'...' : $doc->title) }}</h6></a>
                                                <p class="mb-1"><b>Creator:</b> {{ $doc->uploader->name." ".$doc->uploader->lastname }}</p>
                                                <p class="mb-1"><b>Reviewer:</b> @if($doc->reviewerID != null){{ $doc->reviewer->name." ".$doc->reviewer->lastname }} @else ---- @endif</p>
                                                @if(auth()->user()->department != 'cosqc') <p> <b>created at: </b> {{ $doc->created_at }}</p>@endif
                                                <p> <b>Actions: </b>
                                                    <br>
                                                    <a href="{{ Storage::disk('fileManager')->url($doc->url) }}" class="btn btn-xs btn-primary" target="_blank">Download</a>
                                                    @if($doc->status == 0 or $doc->status == 1 or Auth()->user()->level == 'head' or Auth()->user()->level == 'manager')
                                                        <a href="{{ route('insdoc.destroy', $doc->id) }}" class="btn btn-xs btn-danger" >Delete</a>
                                                    @endif
                                                </p>
                                                <p class="mb-1"><b>Status:</b>
                                                    @switch($doc->status)
                                                        @case ('0')
                                                            <button class="btn btn-xs btn-warning" type="button">waiting for review</button>
                                                            @break
                                                        @case ('1')
                                                            <button class="btn btn-xs btn-danger" type="button">Document Rejected</button>
                                                            @break
                                                        @case ('2')
                                                            <button class="btn btn-xs btn-success" type="button">Document Accepted</button>
                                                            @break
                                                    @endswitch
                                                </p>
                                                @if((auth()->user()->department == 'inspection' or auth()->user()->department == 'management') and (auth()->user()->level=='manager' or auth()->user()->level=='head'))
                                                    <div class="btn-group" style="text-align: center" role="group" aria-label="Basic example">
                                                        <a href="{{ route('insdoc.changeStatus', [$doc->id, 2]) }}" class="btn btn-xs btn-primary" type="button">Accept</a>
                                                        <a href="{{ route('insdoc.changeStatus', [$doc->id, 1]) }}" class="btn btn-xs btn-danger" type="button">Reject</a>
                                                    </div>
                                                @endif
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection

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
