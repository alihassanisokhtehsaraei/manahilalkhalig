@extends('layouts.viho')
@section('moreCSS')
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{ asset('viho/assets/css/datatables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('viho/assets/css/sweetalert2.css')}}">
    <!-- Plugins css Ends-->
@endsection
@section('body')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-6">

                    <h3>Tracking No.: {{ $coi->order->globalcounter->trackingID }}</h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">{{ __('common.home') }}</a></li>
                        <li class="breadcrumb-item">Inspection Department</li>
                        <li class="breadcrumb-item active">Inspection Order</li>
                        <li class="breadcrumb-item active">IC Profile</li>
                    </ol>
                </div>
                <div class="col-sm-6">
                    <!-- Bookmark Start-->
                    <div class="bookmark">
                        <ul>
                            <li><a href="{{ route('coi.icGoods', $coigood->order_id) }}" data-container="body" data-bs-toggle="popover" data-placement="top" title="BACK" data-original-title="call"><i data-feather="chevron-left"></i></a></li>
                            <li><a href="javascript:void(0)" data-container="body" data-bs-toggle="popover" data-placement="top" title="{{ __('common.call') }}" data-original-title="call"><i data-feather="phone-call"></i></a></li>
                            <li><a href="" data-container="body" data-bs-toggle="popover" data-placement="top" title="{{ __('common.semail') }}" data-original-title="Send Email"><i data-feather="mail"></i></a></li>
                            <li><a id="sweet-id" data-container="body" data-bs-toggle="popover" data-placement="top" title="{{ __('common.delete') }}" data-original-title="Delete"><i data-feather="delete"></i></a></li>
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
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h5>IC Goods Profile</h5><span>Please fill all required inputs.</span>
                        </div>
                        <form class="theme-form" method="post" action="{{ route('coi.icgoodsUpdate', Request::segment(3)) }}" id="ic">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="col-form-label pt-0" for="desc">Description:</label>
                                            <textarea class="form-control" name="desc" id="desc" rows="4" @if($coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif>{{ $coigood->desc }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="col-form-label pt-0" for="quantity">Quantity:</label>
                                            <input class="form-control" name="quantity" id="quantity" type="text"  value="{{ $coigood->quantity }}" @if($coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="col-form-label pt-0" for="packing">Packing Type:</label>
                                            <input class="form-control" name="packing" id="packing" type="text"  value="{{ $coigood->packing }}" @if($coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif>
                                        </div>
                                        <div class="mb-3">
                                            <label class="col-form-label pt-0" for="size">Size:</label>
                                            <input class="form-control" name="size" id="size" type="text"  value="{{ $coigood->size }}" @if($coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button class="btn btn-primary m-r-15" type="submit" @if($coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif>Update Item</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<!-- Container-fluid Ends-->
@section('moreJs')
    @if(session('message'))
        <script>
            $.notify({
                    message:'{{ session('message') }}'
                },
                {
                    type:'primary',
                    allow_dismiss:false,
                    newest_on_top:false ,
                    mouse_over:false,
                    showProgressbar:false,
                    spacing:10,
                    timer:2000,
                    placement:{
                        from:'top',
                        align:'right'
                    },
                    offset:{
                        x:50,
                        y:230
                    },
                    delay:2000 ,
                    z_index:10000,
                    animate:{
                        enter:'animated bounceOutRight',
                        exit:'animated bounceOutDown'
                    }
                });
        </script>
    @endif
@endsection
