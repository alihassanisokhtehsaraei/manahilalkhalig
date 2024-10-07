@extends('layouts.viho')
@section('moreCSS')
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/viho/assets/css/datatables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/viho/assets/css/sweetalert2.css')}}">
    <!-- Plugins css Ends-->
@endsection
@section('body')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-6">
                    <h3>RFT Profile</h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">{{ __('common.home') }}</a></li>
                        <li class="breadcrumb-item">Laboratory</li>
                        <li class="breadcrumb-item active">Request for testing</li>
                    </ol>
                </div>
                <div class="col-sm-6">
                    <!-- Bookmark Start-->
                    @if(auth()->user()->department == 'management' or auth()->user()->department == 'laboratory')
                        <div class="bookmark">
                            <ul>
                                <li><a href="{{ route('rft.edit', $rft->id) }}" data-container="body" data-bs-toggle="popover" data-placement="top" title="Edit Inspection Order" data-original-title="Edit"><i data-feather="edit"></i></a></li>
                                {{--                            <li><a href="{{ route('inspection.insdoc', $rft->id) }}" data-container="body" data-bs-toggle="popover" data-placement="top" title="File Manager" data-original-title="file"><i data-feather="file"></i></a></li>--}}
                                <li><a href="javascript:void(0)" data-container="body" data-bs-toggle="popover" data-placement="top" title="{{ __('common.call') }}" data-original-title="call"><i data-feather="phone-call"></i></a></li>
                                <li><a href="" data-container="body" data-bs-toggle="popover" data-placement="top" title="{{ __('common.semail') }}" data-original-title="Send Email"><i data-feather="mail"></i></a></li>
                            </ul>
                        </div>
                    @endif
                    <!-- Bookmark Ends-->
                </div>
            </div>
        </div>
    </div>


    <!-- Container-fluid starts-->
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="edit-profile">
            <div class="row">
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="row mb-2">
                                <div class="profile-title">
                                    <img style="float: right" class="img-50 rounded-circle" alt=""
                                         src="{{ asset('img/medal/golden.png') }}">
                                    <h4 style="direction: ltr;text-align: center" class="card-title mb-0">RFT
                                        No.:{{ $rft->id }}</h4>
                                    <h6 style="direction: ltr;text-align: center"
                                        class="card-title mb-0">{{ $rft->created_at }}</h6>
                                </div>
                            </div>

                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <h6 class="form-label">Client:</h6>
                                {{ $rft->customer->fullName.' - '.$rft->customer->cName }}
                            </div>
                            <div class="mb-3">
                                <h6 class="form-label">Email:</h6>
                                {{ $rft->customer->email }}
                            </div>

                            @if(auth()->user()->department == 'laboratory' or auth()->user()->department == 'management')
                            <div class="success-color">
                                <ul class="m-b-30">
                                    <a href="{{ route('customer.edit', ['slug' => $rft->customer->id]) }}">
                                        <li style="text-align: center;color: white;background: #7951aa;">Modify Client
                                        </li>
                                    </a>
                                </ul>
                            </div>

                            <div class="mb-3">
                                <h6 class="sub-title text-uppercase">Technical Status</h6>
                                <div class="form-group">
                                <form action="{{route('rft.changeStatus',$rft->id)}}" method="POST">
                                    @method("PATCH")
                                    @csrf
                                    <select class="form-control" name="status" >
                                        <option value="1" {{$rft->status == "1" ? "selected": ""}}>New</option>
                                        <option value="2" {{$rft->status == "2" ? "selected": ""}}>Samples Received</option>
                                        @if($rft->financialStatus == 3)
                                            <option value="3" {{$rft->status == "3" ? "selected": ""}}>Completed</option>
                                        @endif
                                    </select>
                                    <br>
                                    <input type="submit" class="form-control btn btn-primary btn-sm text-white" value="Update">
                                </form>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-xl-8">

                    <div class="row">
                        <div class="col-xl-4 col-sm-6 box-col-4 chart_data_right">
                            <div class="card income-card card-secondary">
                                <div class="card-body align-items-center">
                                    <div class="round-progress knob-block text-center">
                                        <div class="progress-circle">

                                        </div>
                                        <h5>Office</h5>
                                        <h6>{!! $rft->office !!}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-sm-6 box-col-4 chart_data_right second">
                            <div class="card income-card card-primary">
                                <div class="card-body">
                                    <div class="round-progress knob-block text-center">
                                        <div class="progress-circle">

                                        </div>
                                        <h5>Service Type</h5>
                                        <h6>{{ $rft->applicationType }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-sm-6 box-col-4 chart_data_right">
                            <div class="card income-card card-secondary">
                                <div class="card-body align-items-center">
                                    <div class="round-progress knob-block text-center">
                                        <div class="progress-circle">

                                        </div>
                                        <h5>Lab</h5>
                                        <h6>{{ $rft->lab }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{--                                <div class="col-xl-4 col-sm-6 box-col-4 chart_data_right">--}}
                        {{--                                    <div class="card income-card card-secondary">--}}
                        {{--                                        <a href="{{ route('inspection.insdoc', $rft->id) }}" class="btn btn-light btn-lg">File Manager</a>--}}
                        {{--                                    </div>--}}
                        {{--                                </div>--}}

                        @if(auth()->user()->department == 'laboratory' or auth()->user()->department == 'management')
                            <div class="col-xl-4 col-sm-6 box-col-4 chart_data_right">
                                <div class="card income-card card-secondary">
                                    <a href="{{ route('rft.edit', $rft->id) }}" class="btn btn-success btn-lg">Edit RFT</a>
                                </div>
                            </div>

                            @if($rft->order)
                                <div class="col-xl-4 col-sm-6 box-col-4 chart_data_right">
                                    <div class="card income-card card-secondary">
                                        <a href="{{ URL::signedRoute('words.sample', $rft->order->id) }}" class="btn btn-danger btn-lg text-white">Print Sampling</a>
                                    </div>
                                </div>
                            @endif
                        @endif
                        <div class="col-xl-4 col-sm-6 box-col-4 chart_data_right">
                            <div class="card income-card card-secondary">
                                <a href="{{ route('financial.rftshow', $rft->id) }}" class="btn btn-warning btn-lg">Financial Profile</a>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">English Name</th>
                                    <th scope="col">Arabic Name</th>
                                    <th scope="col">Sample Unique Code</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Seal</th>
                                    <th scope="col">Standard</th>
                                    <th scope="col">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($rft->rftsample as $index => $sample)

                                    @php
                                        $doc = \App\Models\InsDoc::query()->where('category', 'rft-' . $rft->id . '-' . $sample->id)->latest()->first();
                                        $url = $doc ? $doc->url : null;
                                    @endphp

                                    <tr>
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>{{ $sample->english_name }}</td>
                                        <td>{{ $sample->arabic_name }}</td>
                                        <td>{{ $sample->id }}</td>
                                        <td>{{ $sample->desc }}</td>
                                        <td>{{ $sample->quantity }}</td>
                                        <td>{{ $sample->seal }}</td>
                                        <td>{{ $sample->standard }}</td>
                                        <td>

                                            @if(auth()->user()->department == 'laboratory' or auth()->user()->department == 'management')
                                                @if ($url)
                                                    <!-- Show download button if URL exists --> <a href="{{ asset('fileManager/'.$url) }}" class="btn btn-success btn-xs" download>Download</a> <form style="display:inline;" method="POST" action="{{ route('rft.destroyTestReport', ['rft' => $rft]) }}"> @csrf @method('DELETE') <input type="hidden" name="url" value="{{ $url }}"> <button class="btn btn-danger btn-xs" type="submit">Delete</button></form>

                                                @else
                                                    <!-- Show upload form if URL does not exist -->
                                                    <form method="POST" action="{{ route('rft.uploadTestReport', $rft) }}" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="d-flex align-items-center">
                                                            <input type="file" name="{{ 'file-' . $sample->id }}" class="form-control form-control-sm me-2" style="width: 100px;">
                                                            <input type="hidden" name="sample_id" value="{{ $sample->id }}">
                                                            <button class="btn btn-primary btn-xs" type="submit" style="width: 100px;">Upload</button>
                                                        </div>
                                                        @error('file-' . $sample->id)
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </form>
                                               @endif
                                            @else
                                                @if ($url)
                                                    <!-- Show download button if URL exists --> <a href="{{ asset('fileManager/'.$url) }}" class="btn btn-success btn-xs" download>Download</a>
                                                @else
                                                   TR is not ready!
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                    {{--                    @if($order->technicalStatus == 0 or auth()->user()->sector == 'management')--}}
                    {{--                    <div class="col-sm-12">--}}
                    {{--                        <div class="card">--}}
                    {{--                            <div class="card-header">--}}
                    {{--                                <h5>Continue?<br></h5><span>let's do it.... </code></span>--}}
                    {{--                            </div>--}}
                    {{--                            <div class="card-body">--}}
                    {{--                                <form class="theme-form" method="post" action="{{ route('order.continue', ['slug' => $order->id]) }}" id="orderUpdate">--}}
                    {{--                                    @csrf--}}
                    {{--                                    <div class="mb-3">--}}
                    {{--                                        <label class="col-form-label pt-0" for="invoiceValue">Invoice Value (USD)</label>--}}
                    {{--                                        <input type="text"  class="form-control" name="invoiceValue" id="invoiceValue" value="{{ $order->invoiceValue }}"  @if($order->technicalStatus > 4 and auth()->user()->sector != 'management') disabled @endif>--}}
                    {{--                                    </div>--}}
                    {{--                                    <div class="mb-3">--}}
                    {{--                                        <label class="col-form-label pt-0" for="status">Continue</label>--}}
                    {{--                                        <select class="form-control" name="status" id="status" @if($order->technicalStatus > 4 and auth()->user()->sector != 'management') disabled @endif>--}}
                    {{--                                                <option value="COC">COC</option>--}}
                    {{--                                                <option value="NCR">NCR</option>--}}
                    {{--                                        </select>--}}
                    {{--                                    </div>--}}
                    {{--                                    <div class="mb-3">--}}
                    {{--                                        <button class="btn btn-primary">Submit</button>--}}
                    {{--                                    </div>--}}
                    {{--                                </form>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}
                    {{--                    @endif--}}
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
    </div>
@endsection

<!-- Container-fluid Ends-->
@section('moreJs')
    <!-- Plugins JS start-->
    <script src="{{ asset('theme/viho/assets/js/form-wizard/form-wizard.js')}}"></script>
    <!-- Plugins JS Ends-->
    <!-- Plugins JS start-->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="{{ asset('theme/viho/assets/js/sweet-alert/sweetalert.min.js')}}"></script>

    <script src="{{ asset('theme/viho/assets/js/tooltip-init.js')}}"></script>
    <!-- Plugins JS Ends-->
    <script src="{{ asset('theme/viho/assets/js/datatable/datatables/jquery.dataTables.min.js')}}"></script>

@endsection
