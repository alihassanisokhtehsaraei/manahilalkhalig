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
                    <h3>Inspection Order Profile</h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">{{ __('common.home') }}</a></li>
                        <li class="breadcrumb-item">Inspection</li>
                        <li class="breadcrumb-item active">Inspection Order Profile</li>
                    </ol>
                </div>
                <div class="col-sm-6">
                    <!-- Bookmark Start-->
                    <div class="bookmark">
                        <ul>
                            <li><a href="{{ route('order.edit', $order->id) }}" data-container="body" data-bs-toggle="popover" data-placement="top" title="Edit Inspection Order" data-original-title="Edit"><i data-feather="edit"></i></a></li>
                            <li><a href="{{ route('inspection.insdoc', $order->id) }}" data-container="body" data-bs-toggle="popover" data-placement="top" title="File Manager" data-original-title="file"><i data-feather="file"></i></a></li>
                            <li><a href="javascript:void(0)" data-container="body" data-bs-toggle="popover" data-placement="top" title="{{ __('common.call') }}" data-original-title="call"><i data-feather="phone-call"></i></a></li>
                            <li><a href="" data-container="body" data-bs-toggle="popover" data-placement="top" title="{{ __('common.semail') }}" data-original-title="Send Email"><i data-feather="mail"></i></a></li>
                        </ul>
                    </div>
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
                                    <img  style="float: right" class="img-50 rounded-circle" alt="" src="{{ asset('img/medal/golden.png') }}">
                                    <h4 style="direction: ltr;text-align: center" class="card-title mb-0">{{ $order->tracking_no }}</h4>
                                    <h6 style="direction: ltr;text-align: center" class="card-title mb-0">{{ $order->date }}</h6>
                                </div>
                            </div>

                        </div>
                        <div class="card-body">
                                <div class="mb-3">
                                    <h6 class="form-label">Description of Goods:</h6>
                                    {{ $order->desc }}
                                </div>
                                <div class="mb-3">
                                    <h6 class="form-label">Client:</h6>
                                    {{ $order->customer->fullName.' - '.$order->customer->cName }}
                                </div>
                                <div class="mb-3">
                                    <h6 class="form-label">Email:</h6>
                                    {{ $order->customer->email }}
                                </div>
                                <div class="success-color">
                                    <ul class="m-b-30">
                                        <a href="{{ route('customer.edit', ['slug' => $order->customer->id]) }}"> <li style="text-align: center;color: white;background: #7951aa;">Modify Client</li></a>
                                    </ul>
                                </div>
                            <div class="mb-3">
                                <h6 class="sub-title text-uppercase">Technical Status</h6>
                                <div class="form-group">
                                    <form action="{{route('order.updateStatus',$order->id)}}" method="POST">
                                        @method("PATCH")
                                        @csrf
                                        <select class="form-control" name="status" >
                                            <option value="1" {{$order->technicalStatus == "1" ? "selected": ""}}>COC Draft</option>
                                            <option value="2" {{$order->technicalStatus == "2" ? "selected": ""}}>NCR Draft</option>
                                            @if(auth()->user()->level == 'technical' and $order->technicalStatus == 5 and $order->financialStatus == 3)
                                                <option value="7" {{$order->technicalStatus == "7" ? "selected": ""}}>Archive</option>
                                            @endif
                                        </select>
                                        <br>
                                        <input type="submit" class="form-control btn btn-primary btn-sm text-white" value="Update">
                                    </form>
                                </div>
                            </div>
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
                                        <h5>PI/CI No.</h5>
                                        <h6>{!! $order->piNo !!}</h6>
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
                                        <h6>{{ $order->service }}</h6>
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
                                        <h5>Border</h5>
                                        <h6>{{ $order->border }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        @if($order->service == 'COC')
                            @if($order->technicalStatus == 1 or $order->technicalStatus == 3 or $order->technicalStatus == 5)
                                <div class="col-xl-4 col-sm-6 box-col-4 chart_data_right">
                                    <div class="card income-card card-secondary">
                                        <a href="{{ route('coc.show', $order->id) }}" class="btn btn-primary btn-lg">COC Profile</a>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-sm-6 box-col-4 chart_data_right">
                                    <div class="card income-card card-secondary">
                                        <a href="{{ route('financial.show', $order->id) }}" class="btn btn-warning btn-lg">Financial Profile</a>
                                    </div>
                                </div>
                            @elseif($order->technicalStatus == 2 or $order->technicalStatus == 4 or $order->technicalStatus == 6)
                                <div class="col-xl-4 col-sm-6 box-col-4 chart_data_right">
                                    <div class="card income-card card-secondary">
                                        <a href="{{ route('ncr.show', $order->id) }}" class="btn btn-danger btn-lg">NCR Profile</a>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-sm-6 box-col-4 chart_data_right">
                                    <div class="card income-card card-secondary">
                                        <a href="{{ route('financial.show', $order->id) }}" class="btn btn-warning btn-lg">Financial Profile</a>
                                    </div>
                                </div>
                            @endif
                                <div class="col-xl-4 col-sm-6 box-col-4 chart_data_right">
                                    <div class="card income-card card-secondary">
                                        <a href="{{ route('inspection.insdoc', $order->id) }}" class="btn btn-light btn-lg">File Manager</a>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-sm-6 box-col-4 chart_data_right">
                                    <div class="card income-card card-secondary">
                                        <a href="{{ route('order.edit', $order->id) }}" class="btn btn-success btn-lg">Inspection Order</a>
                                    </div>
                                </div>
                                @if($order->technicalStatus ==5 && $order->financialStatus == 3)
                                        <div class="col-xl-4 col-sm-6 box-col-4 chart_data_right">
                                            <div class="card income-card card-secondary">
                                                <a href="{{ URL::signedRoute('words.coc', $order->coc->id) }}" class="btn btn-primary btn-lg">Print COC</a>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-sm-6 box-col-4 chart_data_right">
                                            <div class="card income-card card-secondary">
                                                <a href="{{ route('rdocs.index', ['order' => $order]) }}" class="btn btn-warning btn-lg">Release Documents</a>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-sm-6 box-col-4 chart_data_right">
                                            <div class="card income-card card-secondary">
                                                <a href="{{ route('nrdocs.index', ['order' => $order]) }}" class="btn btn-danger btn-lg">Non-Release Documents</a>
                                            </div>
                                        </div>
                                @endif
                                @if($order->technicalStatus ==6)
                                    <div class="col-xl-4 col-sm-6 box-col-4 chart_data_right">
                                        <div class="card income-card card-secondary">
                                            <a href="{{ URL::signedRoute('words.ncr', $order->ncr->id) }}" class="btn btn-danger btn-lg">Print NCR</a>
                                        </div>
                                    </div>
                                @endif
                        @elseif($order->service == 'COI')
                            <div class="col-xl-4 col-sm-6 box-col-4 chart_data_right">
                                <div class="card income-card card-secondary">
                                    <a href="{{ route('coi.showIC', $order->id) }}" class="btn btn-primary btn-lg">IC Profile</a>
                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-6 box-col-4 chart_data_right">
                                <div class="card income-card card-secondary">
                                    <a href="{{ route('coi.show', $order->id) }}" class="btn btn-warning btn-lg">COI Profile</a>
                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-6 box-col-4 chart_data_right">
                                <div class="card income-card card-secondary">
                                    <a href="{{ route('inspection.insdoc', $order->id) }}" class="btn btn-light btn-lg">File Manager</a>
                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-6 box-col-4 chart_data_right">
                                <div class="card income-card card-secondary">
                                    <a href="{{ route('order.edit', $order->id) }}" class="btn btn-info btn-lg">Inspection Order</a>
                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-6 box-col-4 chart_data_right">
                                <div class="card income-card card-secondary">
                                    <a href="#" class="btn btn-success btn-lg">Inspection Report</a>
                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-6 box-col-4 chart_data_right">
                                <div class="card income-card card-secondary">
                                    <a href="{{ route('bankAcceptance.index',['id' => $order->id]) }}" class="btn btn-secondary btn-lg">Bank Acceptance Letter</a>
                                </div>
                            </div>
                        @endif
                            <div class="col-xl-4 col-sm-6 box-col-4 chart_data_right">
                                <div class="card income-card card-secondary">
                                    <a href="{{ route('order.sampling', $order->id) }}" class="btn btn-info btn-lg">Sampling Form</a>
                                </div>
                            </div>
                    </div>
                    @if($order->technicalStatus == 0 or auth()->user()->sector == 'management')
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Continue?<br></h5><span>let's do it.... </code></span>
                            </div>
                            <div class="card-body">
                                <form class="theme-form" method="post" action="{{ route('order.continue', ['slug' => $order->id]) }}" id="orderUpdate">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="col-form-label pt-0" for="invoiceValue">Invoice Value (USD)</label>
                                        <input type="text"  class="form-control" name="invoiceValue" id="invoiceValue" value="{{ $order->invoiceValue }}"  @if($order->technicalStatus > 4 and auth()->user()->sector != 'management') disabled @endif>
                                    </div>
                                    <div class="mb-3">
                                        <label class="col-form-label pt-0" for="status">Continue</label>
                                        <select class="form-control" name="status" id="status" @if($order->technicalStatus > 4 and auth()->user()->sector != 'management') disabled @endif>
                                                <option value="COC">COC</option>
                                                <option value="NCR">NCR</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <button class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif
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
