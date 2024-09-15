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
                        <li class="breadcrumb-item active">LC Profile</li>
                    </ol>
                </div>
                <div class="col-sm-6">
                    <!-- Bookmark Start-->
                    <div class="bookmark">
                        <ul>
                            <li><a href="javascript:void(0)" data-container="body" data-bs-toggle="popover" data-placement="top" title="BACK" data-original-title="call"><i data-feather="chevron-left"></i></a></li>
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
                            <h5>LC Profile</h5><span>Please fill all required inputs.</span>
                        </div>
                        <form class="theme-form" method="post" action="{{ route('lc.update', Request::segment(3)) }}" id="ic">
                            @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <p class="sub-title">L/C Information</p>
                                        <div class="figure d-block">
                                            <blockquote class="blockquote">
                                                <p class="mb-0">-- LC information like: LC No, PI, Invoice, Seller, Buyer and etc.</p>
                                            </blockquote>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="lcNo">LC No.:</label>
                                                <input class="form-control" name="lcNo" id="lcNo" type="text" @if(isset($lc->status) && $lc->status > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif value="{{ old('lcNo', $order->lcNo) }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="lcDate">LC Date</label>
                                                <input class="form-control" name="lcDate" id="lcDate" type="text"  @if(isset($lc->status) && $lc->status > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif value="{{ old('lcDate', optional($lc)->lcDate) }}">
                                            </div>

                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="piNo">PI No. No.:</label>
                                                <input class="form-control" name="piNo" id="piNo" type="text" @if(isset($lc->status) && $lc->status > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif value="{{ old('piNo', $order->piNo) }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="piDate">PI Date</label>
                                                <input class="form-control" name="piDate" id="piDate" type="text"  @if(isset($lc->status) && $lc->status > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif value="{{ old('piDate', optional($lc)->piDate) }}">
                                            </div>

                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="invoiceNo">Invoice No.:</label>
                                                <input class="form-control" name="invoiceNo" id="invoiceNo" type="text" @if(isset($lc->status) && $lc->status > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif value="{{ old('invoiceNo', optional($lc)->invoiceNo) }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="invoiceDate">Invoice Date</label>
                                                <input class="form-control" name="invoiceDate" id="invoiceDate" type="text"  @if(isset($lc->status) && $lc->status > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif value="{{ old('invoiceDate', optional($lc)->invoiceDate) }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="bank">Bank</label>
                                                <input class="form-control" name="bank" id="bank" type="text"  @if(isset($lc->status) && $lc->status > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif value="{{ old('bank', optional($lc)->bank) }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="seller">Seller:</label>
                                                <textarea class="form-control" name="seller" id="seller" rows="4"  @if(isset($lc->status) && $lc->status > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif>{{ old('seller', optional($lc)->seller) }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="buyer">Buyer:</label>
                                                <textarea class="form-control" name="buyer" id="buyer" rows="4"  @if(isset($lc->status) && $lc->status > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif>{{ old('buyer', optional($lc)->buyer) }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <p class="sub-title">Inspection information</p>
                                        <div class="figure d-block">
                                            <blockquote class="blockquote">
                                                <p class="mb-0">-- Inspection place and date, Signee, packing, marking and etc.</p>
                                            </blockquote>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="packing">Packing:</label>
                                                <input class="form-control" name="packing" id="packing" type="text" @if(isset($lc->status) && $lc->status > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif value="{{ old('packing', optional($lc)->packing) }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="marking">Marking:</label>
                                                <input class="form-control" name="marking" id="marking" type="text" @if(isset($lc->status) && $lc->status > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif value="{{ old('marking', optional($lc)->marking) }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="inspectionPlace">Inspection Place:</label>
                                                <textarea class="form-control" name="inspectionPlace" id="inspectionPlace" rows="4"  @if(isset($lc->status) && $lc->status > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif>{{ old('inspectionPlace', optional($lc)->inspectionPlace) }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="inspectionDate">Inspection Date:</label>
                                                <input class="form-control" name="inspectionDate" id="inspectionDate" type="text" @if(isset($lc->status) && $lc->status > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif value="{{ old('inspectionDate', optional($lc)->inspectionDate) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <p class="sub-title">Conclusion</p>
                                        <div class="figure d-block">
                                            <blockquote class="blockquote">
                                                <p class="mb-0">-- Finalize the LC</p>
                                            </blockquote>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="remarks">Remarks:</label>
                                                <textarea class="form-control" name="remarks" id="remarks" @if(isset($lc->status) && $lc->status > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif>{{ old('remarks', optional($lc)->remarks) }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="signee">Name and Position</label>
                                                <div class="row row-cols-sm-2 theme-form mt-2 form-bottom">
                                                    <div class="mb-2 d-flex">
                                                        <input class="form-control" type="text" name="signee" placeholder="علیرضا توکلی" value="{{ old('signee', optional($lc)->signee) }}" @if(isset($lc->status) && $lc->status > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif disabled>
                                                    </div>
                                                    <div class="mb-2 d-flex">
                                                        <input class="form-control" type="text" PLACEHOLDER="مدیر عامل" data-bs-original-title="" title="" name="position" id="position" @if(isset($lc->signDateIC)) value="{{ old('signDateIC', $formattedDate) }}" @endif @if(isset($lc->signDateIC) && $lc->signDateIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="issuingDate">Issuing Date:</label>
                                                <input class="form-control" name="issuingDate" id="issuingDate" type="text" @if(isset($lc->status) && $lc->status > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif value="{{ old('issuingDate', optional($lc)->issuingDate) }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-end">
                                    <button class="btn btn-primary m-r-15" type="submit">Next Step</button>
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
@endsection
