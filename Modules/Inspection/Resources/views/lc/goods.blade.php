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
                        <li class="breadcrumb-item active">LC Profile</li>
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
                            <h5>LC Goods Profile</h5><span>Please fill all required inputs.</span>
                        </div>
                        <form class="theme-form" method="post" action="{{ route('lc.goodsStore', Request::segment(3)) }}" id="lc">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="col-form-label pt-0" for="goodsDescOp1">مقدار و واحد سفارش:</label>
                                            <div class="checkbox checkbox-primary">
                                                <input id="checkbox-primary-1" type="checkbox"  name="goodsDescOp1" @if($lc->goodsDescOp1 == 'on') checked @endif @if(isset($lc->status) && $lc->status > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif>
                                                <label for="checkbox-primary-1">بر اساس اعتبار اسنادی</label>
                                            </div>
                                            <div class="checkbox checkbox-primary">
                                                <input id="checkbox-primary-2" type="checkbox" name="goodsDescOp2" @if($lc->goodsDescOp2 == 'on') checked @endif @if(isset($lc->status) && $lc->status > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif>
                                                <label for="checkbox-primary-2">بر اساس پیش فاکتور ارائه شده</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="col-form-label pt-0" for="desc">مقدار و واحد تحویل شده:</label>
                                            <div class="checkbox checkbox-primary">
                                                <input id="checkbox-primary-3" type="checkbox" name="goodsDescOp3" @if($lc->goodsDescOp3 == 'on') checked @endif @if(isset($lc->status) && $lc->status > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif>
                                                <label for="checkbox-primary-3">بر اساس قبض باسکول</label>
                                            </div>
                                            <div class="checkbox checkbox-primary">
                                                <input id="checkbox-primary-4" type="checkbox" name="goodsDescOp4" @if($lc->goodsDescOp4 == 'on') checked @endif @if(isset($lc->status) && $lc->status > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif>
                                                <label for="checkbox-primary-4">بر اساس پکینگ لیست</label>
                                            </div>
                                            <div class="checkbox checkbox-primary">
                                                <input id="checkbox-primary-5" type="checkbox" name="goodsDescOp5" @if($lc->goodsDescOp5 == 'on') checked @endif @if(isset($lc->status) && $lc->status > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif>
                                                <label for="checkbox-primary-5">بر اساس فاکتور</label>
                                            </div>
                                            <div class="checkbox checkbox-primary">
                                                <input id="checkbox-primary-6" type="checkbox" name="goodsDescOp6" @if($lc->goodsDescOp6 == 'on') checked @endif @if(isset($lc->status) && $lc->status > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif>
                                                <label for="checkbox-primary-6">بر اساس سایر مدارک</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="col-form-label pt-0" for="desc">Description:</label>
                                            <textarea class="form-control" name="desc" id="desc" rows="4" @if($lc->status > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif></textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="col-form-label pt-0" for="orderedQuantity">Ordered Quantity:</label>
                                            <input class="form-control" name="orderedQuantity" id="orderedQuantity" type="text"  value="" @if($lc->status > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif>
                                        </div>
                                        <div class="mb-3">
                                            <label class="col-form-label pt-0" for="receivedQuantity">Received Quantity</label>
                                            <input class="form-control" name="receivedQuantity" id="receivedQuantity" type="text"  value="" @if($lc->status > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button class="btn btn-primary m-r-15" type="submit" @if($lc->status > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif>Add Item</button>
                            </div>
                        </form>
                    </div>

                    @if($lcGoods->count() > 0)
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
                                                <th scope="col">Ordered Quantity</th>
                                                <th scope="col">Received Type</th>
                                                <th scope="col">Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($lcGoods as $goods)
                                                <tr>
                                                    <th  scope="row">{{ $loop->iteration }}</th>
                                                    <td>{{ $goods->desc }}</td>
                                                    <td>{{ $goods->orderedQuantity }}</td>
                                                    <td>{{ $goods->receivedQuantity }}</td>
                                                    <td>
                                                        @if($lc->status > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager')
                                                            <a style="margin: 1px"  class="btn btn-xs btn-success">Edit</a> <a style="margin: 1px"  class="btn btn-xs btn-danger">Delete</a>
                                                        @else
                                                            <a style="margin: 1px" href="{{ route('lc.editGoods', $goods->id) }}" class="btn btn-xs btn-success">Edit</a> <a style="margin: 1px" href="{{ route('lc.destroyGoods', $goods->id) }}" class="btn btn-xs btn-danger">Delete</a>
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
                                        <p class="mb-0">-- Here you can change the status of the LC file</p>
                                    </blockquote>
                                </div>
                            </div>
                            <div class="card-body">
                                    <form class="theme-form" method="post" action="{{ route('lc.changeStatus', Request::segment(3)) }}" id="lcChangeStatus">
                                    @csrf
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label class="col-form-label pt-0" for="status">Change Status (Current Status:
                                                        @switch($lc->status)
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
                                                    <select class="form-control" name="status"  @if($lc->status > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif>
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
                                                    <button class="btn btn-primary m-r-15" type="submit" @if($lc->status > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif>Submit</button>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label class="col-form-label pt-0" for="paper">Cert Paper Serial (if more than 1 pages, separate them by comma like: 2002, 2003, 2004)</label>
                                                    <input class="form-control" name="paper" type="text" value="{{ $lc->paper }}" @if($lc->status > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif>
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
