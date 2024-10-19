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

                    <h3><a href="{{ route('inspection.show', $order->id) }}">Tracking No.: {{ $order->tracking_no }}</a></h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">{{ __('common.home') }}</a></li>
                        <li class="breadcrumb-item">Inspection Department</li>
                        <li class="breadcrumb-item active">Inspection Order</li>
                        <li class="breadcrumb-item active">NCR Goods Profile</li>
                    </ol>
                </div>
                <div class="col-sm-6">
                    <!-- Bookmark Start-->
                    <div class="bookmark">
                        <ul>
                            <li><a href="{{ route('ncr.show', $order->id) }}" data-container="body" data-bs-toggle="popover" data-placement="top" title="BACK" data-original-title="call"><i data-feather="chevron-left"></i></a></li>
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
                        <form class="theme-form" method="post" action="{{ route('ncr.storeGoods', $ncr->id) }}" id="coi">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="quantity">Declared Quantity / Unit:</label>
                                            <input type="text" class="form-control" id="quantity" name="quantity" {{ $disabled }} required >
                                        </div>
                                        <div class="form-group">
                                            <label for="origin">Origin as marked on goods:</label>
                                            <input type="text" class="form-control" id="origin" name="origin" {{ $disabled }}  required >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="standard">IQS No. or TR:</label>
                                            <input type="text" class="form-control" id="standard" name="standard" {{ $disabled }}  required >
                                        </div>
                                        <div class="form-group">
                                            <label for="type">Category:</label>
                                            <select class="form-control" id="type" name="type" @if($order->technicalStatus > 4 and (auth()->user()->level != 'manager' and auth()->user()->level != 'head')) disabled @endif  required >
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
                                        <textarea class="form-control" rows="3" placeholder="Enter ..." name="desc" id="desc" required {{ $disabled }} ></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                @if($disabled == null)
                                    <input type="submit" class="btn btn-primary m-r-15" value="Add Item">
                                @endif
                            </div>
                        </form>
                    </div>

                    @if($goods->count() > 0)
                        <div class="card">
                            <div class="card-header pb-0">
                                <p class="sub-title">Description of Goods</p>
                                <div class="figure d-block">
                                    <blockquote class="blockquote">
                                        <p class="mb-0">-- Description of Goods and actions related to status of IC file </p>
                                    </blockquote>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Descripton of Goods</th>
                                                <th scope="col">Quantity</th>
                                                <th scope="col">Origin</th>
                                                <th scope="col">Standard</th>
                                                <th scope="col">Category</th>
                                                <th scope="col">Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($goods as $goods)
                                                <tr>
                                                    <th  scope="row">{{ $loop->iteration }}</th>
                                                    <td>{{ $goods->desc }}</td>
                                                    <td>{{ $goods->quantity }}</td>
                                                    <td>{{ $goods->origin }}</td>
                                                    <td>{{ $goods->standard }}</td>
                                                    <td>{{ $goods->type }}</td>
                                                    <td>
                                                        @if($order->technicalStatus > 4 and (auth()->user()->level != 'manager' and auth()->user()->level != 'head'))
                                                            Locked !
                                                        @else
                                                            <a style="margin: 1px" href="{{ route('ncr.editGoods', $goods->id) }}" class="btn btn-xs btn-success">Edit</a> <a style="margin: 1px" href="{{ route('ncr.destroyGoods', $goods->id) }}" class="btn btn-xs btn-danger">Delete</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">

                            </div>
                        </div>

                        @if($disabled == null)
                        <div class="card">
                            <div class="card-header pb-0">
                                <p class="sub-title">Change Status</p>
                                <div class="figure d-block">
                                    <blockquote class="blockquote">
                                        <p class="mb-0">-- Here you can change the status of the IC file</p>
                                    </blockquote>
                                </div>
                            </div>
                            <div class="card-body">
                                <form class="theme-form" method="post" action="{{ route('ncr.changeTechnicalStatus', Request::segment(3)) }}" id="ncr">
                                    @csrf
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="status">Change Status (Current Status:
                                                    @switch($order->technicalStatus)
                                                        @case(0)
                                                            <a class="btn btn-xs btn-success">New</a>
                                                            @break
                                                        @case(1)
                                                            <a class="btn btn-xs btn-success">COC Draft</a>
                                                            @break
                                                        @case(2)
                                                            <a class="btn btn-xs btn-warning">NCR Draft</a>
                                                            @break
                                                        @case(3)
                                                            <a class="btn btn-xs btn-danger">COC Rejected</a>
                                                            @break
                                                        @case(4)
                                                            <a class="btn btn-xs btn-danger">NCR Rejected</a>
                                                            @break
                                                        @case(5)
                                                            <a class="btn btn-xs btn-success">COC Approved</a>
                                                            @break
                                                        @case(6)
                                                            <a class="btn btn-xs btn-danger">NCR Approved</a>
                                                            @break


                                                    @endswitch
                                                    )</label>
                                                <select class="form-control" name="status">
                                                    @if(Auth()->user()->level == 'manager' or Auth()->user()->level == 'head')
                                                        <option value="2">Draft</option>
                                                        <option value="4">Reject</option>
                                                        <option value="6">Approve</option>
                                                    @else
                                                        <option value="2">COC Draft</option>
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="submit"> </label>
                                                <button class="btn btn-primary btn-xs" type="submit" >Submit</button>
                                                @if($order->technicalStatus == 6)<a href="{{ URL::signedRoute('words.ncr',$ncr->id) }}" class="btn btn-warning btn-xs">Print Certificate</a>@endif


                                                <a href="{{ URL::signedRoute('words.draftNcr', $order->ncr->id) }}"
                                                   class="btn btn-secondary btn-xs">Print Draft </a>

                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-end"></div>
                        </div>
                        @endif
                    @endif
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
