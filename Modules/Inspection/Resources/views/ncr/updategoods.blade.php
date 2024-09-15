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

                    <h3>Tracking No.: {{ $ncr->order->tracking_no }}</h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">{{ __('common.home') }}</a></li>
                        <li class="breadcrumb-item">Inspection Department</li>
                        <li class="breadcrumb-item active">Inspection Order</li>
                        <li class="breadcrumb-item active">NCR Profile</li>
                    </ol>
                </div>
                <div class="col-sm-6">
                    <!-- Bookmark Start-->
                    <div class="bookmark">
                        <ul>
                            <li><a href="{{ route('ncr.Goods', $ncr->order_id) }}" data-container="body" data-bs-toggle="popover" data-placement="top" title="BACK" data-original-title="call"><i data-feather="chevron-left"></i></a></li>
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
                            <h5>NCR Goods Profile</h5><span>Please fill all required inputs.</span>
                        </div>
                        <form class="theme-form" method="post" action="{{ route('ncr.updateGoods', Request::segment(3)) }}" id="ic">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="quantity">Declared Quantity / Unit:</label>
                                            <input type="text" class="form-control" id="quantity" value="{{ $ncrgood->quantity }}" name="quantity" required >
                                        </div>
                                        <div class="form-group">
                                            <label for="origin">Origin as marked on goods:</label>
                                            <input type="text" class="form-control" id="origin"  value="{{ $ncrgood->origin }}" name="origin" required >
                                        </div>

                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="standard">IQ StandardNo. or TR:</label>
                                            <input type="text" class="form-control" id="standard" value="{{ $ncrgood->standard }}" name="standard" required >
                                        </div>
                                        <div class="form-group">
                                            <label for="type">Category:</label>
                                            <select class="form-control" id="type" name="type" required >
                                                <option value="{{ $ncrgood->type }}">{{ $ncrgood->type }}</option>
                                                <option value="Food">Food</option>
                                                <option value="Chemical">Chemical</option>
                                                <option value="Construction">Construction</option>
                                                <option value="Engineering">Engineering</option>
                                                <option value="Safety">Safety</option>
                                                <option value="Textile">Textile</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="desc">Goods Description (Designation / brand / model):</label>
                                        <textarea class="form-control" rows="3" placeholder="Enter ..." name="desc" id="desc" required >{{ $ncrgood->desc }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button class="btn btn-primary m-r-15" type="submit">Update Item</button>
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
