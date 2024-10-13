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
                        <li class="breadcrumb-item active">NCR Profile</li>
                    </ol>
                </div>
                <div class="col-sm-6">
                    <!-- Bookmark Start-->
                    <div class="bookmark">
                        <ul>
                            <li><a href="{{ route('inspection.show', $order->id) }}" data-container="body" data-bs-toggle="popover" data-placement="top" title="BACK" data-original-title="call"><i data-feather="chevron-left"></i></a></li>
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
                            <h5>NCR Profile</h5><span>Please fill all required inputs.</span>
                        </div>
                        <form class="theme-form" method="post" action="{{ route('ncr.store', Request::segment(3)) }}" id="ncr">
                            @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <p class="sub-title">Identification Information</p>
                                        <br>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="certNo">Certificate No.</label>
                                                <input class="form-control" name="certNo" id="certNo" type="text" disabled value="@if(!empty($ncr)) {{ $ncr->certNo }} @endif">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="issuingDate">Issuance Date</label>
                                                <input class="form-control" name="issuingDate" id="issuingDate" type="text"  disabled  value="@if(!empty($ncr)) {{ $ncr->issuingDate }}@endif">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="regNo">Registeration No.</label>
                                                <input class="form-control" name="regNo" id="regNo" type="text"  {{ $disabled }} value="{{ old('regNo', optional($ncr)->regNo) }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="rfi">RFI No.</label>
                                                <input class="form-control" name="rfi" READONLY id="rfi" type="text"  {{ $disabled }} value="{{ $order->tracking_no }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <p class="sub-title">Buyer / Importer Information</p>
                                        <br>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="importer">Buyer Name</label>
                                                <input class="form-control" name="importer" id="importer" type="text" {{ $disabled }} value="{{ old('importer', optional($ncr)->importer) }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="importerAdd">Buyer Address</label>
                                                <textarea class="form-control" name="importerAdd" id="importerAdd" rows="4" {{ $disabled }}>{{ old('importerAdd', optional($ncr)->importerAdd) }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <p class="sub-title">Seller / Exporter Information</p>
                                        <br>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="exporter">Seller Name</label>
                                                <input class="form-control" name="exporter" id="exporter" type="text" {{ $disabled }} value="{{ old('exporter', optional($ncr)->exporter) }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="exporterAdd">Seller Address</label>
                                                <textarea class="form-control" name="exporterAdd" id="exporterAdd" rows="4" {{ $disabled }}>{{ old('exporterAdd', optional($ncr)->exporterAdd) }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <p class="sub-title">Invoice Information</p>
                                        <br>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="invAmount">Invoice Amount (Original Currency)</label>
                                                <input class="form-control" name="invAmount" id="invAmount" type="text" {{ $disabled }} value="{{ old('invAmount', optional($ncr)->invAmount) }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="invCurrency">Original Currency</label>
                                                <input class="form-control" name="invCurrency" id="invCurrency" type="text" {{ $disabled }} value="{{ old('invCurrency', optional($ncr)->invCurrency) }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="invUSD">Invoice Amount (USD)</label>
                                                <input class="form-control" name="invUSD" id="invUSD" type="text" {{ $disabled }} value="{{ old('invUSD', optional($ncr)->invUSD) }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="invNo">Invoice No.</label>
                                                <input class="form-control" type="text" name="invNo" id="invNo" {{ $disabled }} value="{{ old('invNo', optional($ncr)->invNo) }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="invDate">Invoice Date</label>
                                                <input class="datepicker-here form-control digits" {{ $disabled }} type="text" data-language="en" data-bs-original-title="" title="" name="invDate" id="invDate" value="{{ old('invDate', optional($ncr)->invDate) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <p class="sub-title">Other general information</p>
                                        <br>
                                    </div>
                                    <div class="row">
                                        <div class="mb-3" style="margin-top: 9px">
                                            <label class="col-form-label pt-0" for="reason">Description of Non-Conformity</label>
                                            <textarea class="form-control" name="reason" rows="8" id="reason" {{ $disabled }}>{{ old('reason', optional($ncr)->reason)  }}</textarea>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3" style="margin-top: 9px">
                                                <label class="col-form-label pt-0" for="signee">Name and Signature</label>
                                                <input class="form-control" name="signee" id="signee" type="text" {{ $disabled }} value="{{ old('signee', optional($ncr)->signee) }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3" style="margin-top: 9px">
                                                <label class="col-form-label pt-0" for="issuingPlace">Issuing Office</label>
                                                <input class="form-control" {{ $disabled }} name="issuingPlace" id="issuingPlace" type="text" style="text-transform: uppercase" {{ $disabled }} value="{{ old('coc', optional($ncr)->issuingPlace) ? old('coc', optional($ncr)->issuingPlace) : auth()->user()->branch }}">
                                            </div>
                                        </div>
                                    </div>
                                <div class="card-footer text-end">
                                    <button class="btn btn-primary m-r-15" type="submit">Next Step</button>
                                </div>
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
