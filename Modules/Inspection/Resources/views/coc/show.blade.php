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
                        <li class="breadcrumb-item active">COC Profile</li>
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
                            <h5>COC Profile</h5><span>Please fill all required inputs.</span>
                        </div>
                        <form class="theme-form" method="post" action="{{ route('coc.store', Request::segment(3)) }}" id="coc">
                            @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <p class="sub-title">Identification Information</p>
                                        <div class="figure d-block">
                                            <blockquote class="blockquote">
                                                <p class="mb-0">-- Information for Document Identification, like COC No., Ref. No. and etc.</p>
                                            </blockquote>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="certNo">Certificate No.</label>
                                                <input class="form-control" name="certNo" id="certNo" type="text" disabled value="@if(!empty($coc)) {{ $coc->certNo }} @endif">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="issuingDate">Issuance Date</label>
                                                <input class="form-control" name="issuingDate" id="issuingDate" type="text"  disabled  value="@if(!empty($coc)) {{ $coc->issuingDate }}@endif">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="expDate">Expiry Date</label>
                                                <input class="datepicker-here form-control digits" data-language="en"  name="expDate" id="expDate" type="text"  {{ $disabled }} value="{{ old('expDate', optional($coc)->expDate) }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="regNo">Registeration No.</label>
                                                <input class="form-control" name="regNo" id="regNo" type="text"  {{ $disabled }} value="{{ old('regNo', optional($coc)->regNo) }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="refNo">RFI No.</label>
                                                <input class="form-control" name="refNo" readonly id="refNo" type="text"  value="{{ $order->tracking_no }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <p class="sub-title">Buyer / Importer Information</p>
                                        <div class="figure d-block">
                                            <blockquote class="blockquote">
                                                <p class="mb-0">-- Buyer information such as name, tel, fax, address</p>
                                            </blockquote>
                                            </blockquote>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="importerName">Buyer Name</label>
                                                <input class="form-control" name="importerName" id="importerName" type="text" {{ $disabled }} value="{{ old('importerName', optional($coc)->importerName) }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="importerCityCountry">City - Country</label>
                                                <input class="form-control" name="importerCityCountry" id="importerCityCountry" type="text" {{ $disabled }} value="{{ old('importerCityCountry', optional($coc)->importerCityCountry) }}">
                                            </div>

                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="importerLicence">Importer Licence & Date</label>
                                                <div class="row row-cols-sm-2 theme-form mt-2 form-bottom">
                                                    <div class="mb-2 d-flex">
                                                        <input class="form-control" type="text" name="importerLicence" {{ $disabled }} value="{{ old('importerLicence', optional($coc)->importerLicence) }}">
                                                    </div>
                                                    <div class="mb-2 d-flex">
                                                        <input class="datepicker-here form-control digits" {{ $disabled }} type="text" data-language="en" data-bs-original-title="" title="" name="importerLicenceDate" id="importerLicenceDate" value="{{ old('importerLicenceDate', optional($coc)->importerLicenceDate) }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="importerAdd">Buyer Address</label>
                                                <textarea class="form-control" name="importerAdd" id="importerAdd" rows="4" {{ $disabled }}>{{ old('importerAdd', optional($coc)->importerAdd) }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <p class="sub-title">Seller / Exporter Information</p>
                                        <div class="figure d-block">
                                            <blockquote class="blockquote">
                                                <p class="mb-0">-- Exporter information such as name, tel, fax, address</p>
                                            </blockquote>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="exporterName">Seller Name</label>
                                                <input class="form-control" name="exporterName" id="exporterName" type="text" {{ $disabled }} value="{{ old('exporterName', optional($coc)->exporterName) }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="exporterCityCountry">City - Country</label>
                                                <input class="form-control" name="exporterCityCountry" id="exporterCityCountry" type="text" {{ $disabled }}  value="{{ old('exporterCityCountry', optional($coc)->exporterCityCountry) }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="exporterAdd">Seller Address</label>
                                                <textarea class="form-control" name="exporterAdd" id="exporterAdd" rows="4" {{ $disabled }}>{{ old('exporterAdd', optional($coc)->exporterAdd) }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <p class="sub-title">Invoice Information</p>
                                        <div class="figure d-block">
                                            <blockquote class="blockquote">
                                                <p class="mb-0">-- Invoice Information like Invoice No., Date and Currency</p>
                                            </blockquote>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="invAmount">Invoice Amount (Original Currency)</label>
                                                <input class="form-control" name="invAmount" id="invAmount" type="text" {{ $disabled }} value="{{ old('invAmount', optional($coc)->invAmount) }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="invCurrency">Original Currency</label>
                                                <input class="form-control" name="invCurrency" id="invCurrency" type="text" {{ $disabled }} value="{{ old('invCurrency', optional($coc)->invCurrency) }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="invUSD">Invoice Amount (USD)</label>
                                                <input class="form-control" name="invUSD" id="invUSD" type="text" {{ $disabled }} value="{{ old('invUSD', optional($coc)->invUSD) }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="invNo">Invoice No.</label>
                                                <input class="form-control" type="text" name="invNo" id="invNo" {{ $disabled }} value="{{ old('invNo', optional($coc)->invNo) }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="invDate">Invoice Date</label>
                                                <input class="datepicker-here form-control digits" {{ $disabled }} type="text" data-language="en" data-bs-original-title="" title="" name="invDate" id="invDate" value="{{ old('invDate', optional($coc)->invDate) }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="invValPerTruck">Declared Value Per Container / Truck (USD)</label>
                                                <input class="form-control" name="invValPerTruck" id="invValPerTruck" type="text" {{ $disabled }} value="{{ old('invValPerTruck', optional($coc)->invValPerTruck) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <p class="sub-title">Transport Information</p>
                                        <div class="figure d-block">
                                            <blockquote class="blockquote">
                                                <p class="mb-0">-- Information for border verification purpose</p>
                                            </blockquote>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="shipmentMethod">Shipment Method</label>
                                                <input class="form-control" name="shipmentMethod" id="shipmentMethod" type="text" {{ $disabled }}  value="{{ old('shipmentMethod', optional($order)->shipmentMethod) ? old('shipmentMethod', optional($order)->shipmentMethod) : $order->shipmentMethod }}">
                                            </div>
                                            <div class="mb-3" style="margin-top: 8px;">
                                                <label class="col-form-label pt-0" for="shipmentCountry">Country of Shipment</label>
                                                <input class="form-control" name="shipmentCountry" id="shipmentCountry" type="text" {{ $disabled }}  value="{{ old('shipmentCountry', optional($coc)->shipmentCountry) }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="blNo">BL No. & Date</label>
                                                <div class="row row-cols-sm-2 theme-form mt-2 form-bottom">
                                                    <div class="mb-2 d-flex">
                                                        <input class="form-control" type="text" name="blNo" {{ $disabled }} value="{{ old('blNo', optional($coc)->blNo) }}">
                                                    </div>
                                                    <div class="mb-2 d-flex">
                                                        <input class="datepicker-here form-control digits" {{ $disabled }} type="text" data-language="en" data-bs-original-title="" title="" name="blDate" id="blDate" value="{{ old('blDate', optional($coc)->blDate) }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="border">Declared Point of Entry</label>
                                                <input class="form-control" name="border" id="border" type="text" {{ $disabled }}  value="{{ old('border', optional($order)->border) ? old('border', optional($order)->border) : $order->border }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="packingDetails">Packing Type</label>
                                                <input class="form-control" name="packingDetails" id="packingDetails" placeholder="like: Package" type="text" {{ $disabled }}  value="{{ old('packingDetails', optional($coc)->packingDetails) }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="numTypePacking">Number and type of packing</label>
                                                <input class="form-control" name="numTypePacking" id="numTypePacking" placeholder="like: 200 Packages" type="text" {{ $disabled }}  value="{{ old('numTypePacking', optional($coc)->numTypePacking) }}">
                                            </div>
                                            <div class="mb-3" style="margin-top:24px;">
                                                <label class="col-form-label pt-0" for="containerDetails">Number of Containers / Trucks</label>
                                                <input class="form-control" name="containerDetails" id="containerDetails" type="text" {{ $disabled }}  value="{{ old('containerDetails', optional($coc)->containerDetails) }}">
                                            </div>
                                            <div class="mb-3" style="margin-top:24px;">
                                                <label class="col-form-label pt-0" for="sealNo">Seal Numbers</label>
                                                <input class="form-control" name="sealNo" id="sealNo" type="text" {{ $disabled }}  value="{{ old('sealNo', optional($coc)->sealNo) }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <p class="sub-title">Other general information</p>
                                        <div class="figure d-block">
                                            <blockquote class="blockquote">
                                                <p class="mb-0">-- </p>
                                            </blockquote>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3" style="margin-top: 9px">
                                                <label class="col-form-label pt-0" for="assessment">Date of Assessment</label>
                                                <input class="datepicker-here form-control digits" type="text" data-language="en" data-bs-original-title="" title="" name="assessment" id="assessment" {{ $disabled }} value="{{ old('assessment', optional($coc)->assessment) }}">
                                            </div>
                                            <div class="mb-3" style="margin-top: 9px">
                                                <label class="col-form-label pt-0" for="signee">Name and Signature</label>
                                                <input class="form-control" name="signee" id="signee" type="text" {{ $disabled }} value="{{ old('signee', optional($coc)->signee) }}">
                                            </div>
                                            <div class="mb-3" style="margin-top: 9px">
                                                <label class="col-form-label pt-0" for="issuingPlace">Issuing Office</label>
                                                <input class="form-control" name="issuingPlace" id="issuingPlace" type="text" {{ $disabled }} value="{{ old('coc', optional($coc)->issuingPlace) ? old('coc', optional($coc)->issuingPlace) : auth()->user()->branch }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3" style="margin-top: 9px">
                                                <label class="col-form-label pt-0" for="remark">Remarks</label>
                                                <textarea class="form-control" name="remark" rows="8" id="remark" {{ $disabled }}>{{ old('remark', optional($coc)->remark)  }}</textarea>
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
