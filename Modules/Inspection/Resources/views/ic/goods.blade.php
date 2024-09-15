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

                    <h3>Tracking No.: {{ $order->globalcounter->trackingID }}</h3>
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
                            <li><a href="{{ route('coi.showIC', $order->id) }}" data-container="body" data-bs-toggle="popover" data-placement="top" title="BACK" data-original-title="call"><i data-feather="chevron-left"></i></a></li>
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
                        <form class="theme-form" method="post" action="{{ route('coi.icgoodsStore', Request::segment(3)) }}" id="coi">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="col-form-label pt-0" for="desc">Description:</label>
                                            <textarea class="form-control" name="desc" id="desc" rows="4" @if($coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="col-form-label pt-0" for="quantity">Quantity:</label>
                                            <input class="form-control" name="quantity" id="quantity" type="text"  value="" @if($coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="col-form-label pt-0" for="packing">Packing Type:</label>
                                            <input class="form-control" name="packing" id="packing" type="text"  value="" @if($coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif>
                                        </div>
                                        <div class="mb-3">
                                            <label class="col-form-label pt-0" for="size">Goods Size:</label>
                                            <input class="form-control" name="size" id="size" type="text"  value="" @if($coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button class="btn btn-primary m-r-15" type="submit" @if($coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif>Add Item</button>
                            </div>
                        </form>
                    </div>

                    @if($coigoods->count() > 0)
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
                                                <th scope="col">Packing Type</th>
                                                <th scope="col">Size</th>
                                                <th scope="col">Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($coigoods as $goods)
                                                <tr>
                                                    <th  scope="row">{{ $loop->iteration }}</th>
                                                    <td>{{ $goods->desc }}</td>
                                                    <td>{{ $goods->quantity }}</td>
                                                    <td>{{ $goods->packing }}</td>
                                                    <td>{{ $goods->size }}</td>
                                                    <td>
                                                        @if($coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager')
                                                            <a style="margin: 1px"  class="btn btn-xs btn-success">Edit</a> <a style="margin: 1px"  class="btn btn-xs btn-danger">Delete</a>
                                                        @else
                                                            <a style="margin: 1px" href="{{ route('coi.iceditGoods', $goods->id) }}" class="btn btn-xs btn-success">Edit</a> <a style="margin: 1px" href="{{ route('coi.destroyGoods', $goods->id) }}" class="btn btn-xs btn-danger">Delete</a>
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
                                    <form class="theme-form" method="post" action="{{ route('coi.changeStatusIC', Request::segment(3)) }}" id="ic">
                                    @csrf
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label class="col-form-label pt-0" for="status">Change Status (Current Status:
                                                        @switch($coi->statusIC)
                                                            @case(0)
                                                                <a class="btn btn-xs btn-success">Draft</a>
                                                                @break
                                                            @case(1)
                                                                <a class="btn btn-xs btn-success">Ask for Approval</a>
                                                                @break
                                                            @case(2)
                                                                <a class="btn btn-xs btn-danger">Rejected</a>
                                                                @break
                                                            @case(3)
                                                                <a class="btn btn-xs btn-success">Approved</a>
                                                                @break

                                                        @endswitch
                                                        )</label>
                                                    <select class="form-control" name="status"  @if($coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif>
                                                        @if(Auth()->user()->level == 'supervisor' and  Auth()->user()->department == 'Inspection' or Auth()->user()->level == 'manager' and  Auth()->user()->department == 'Inspection')
                                                            <option value="0">Draft</option>
                                                            <option value="2">Reject</option>
                                                            <option value="3">Approve</option>
                                                        @elseif(Auth()->user()->level == 'expert' and  Auth()->user()->department == 'Inspection' or Auth()->user()->level == 'head' and  Auth()->user()->department == 'Inspection')
                                                            <option value="0">Draft</option>
                                                            <option value="1">Ask for Approval</option>
                                                        @endif
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="col-form-label pt-0" for="submit"> </label>
                                                    <button class="btn btn-primary m-r-15" type="submit" @if($coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif>Submit</button>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label class="col-form-label pt-0" for="ICPaper">Cert Paper Serial (if more than 1 pages, separate them by comma like: 2002, 2003, 2004)</label>
                                                    <input class="form-control" name="ICPaper" type="text" value="{{ $coi->ICPaper }}" @if($coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif>
                                                </div>
                                            </div>
                                        </div>
                                  </form>
                            </div>
                            <div class="card-footer text-end">

                            </div>
                        </div>
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
