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
                        <li class="breadcrumb-item active">COI Profile</li>
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
                            <h5>COI Profile</h5><span>Please fill all required inputs.</span>
                        </div>
                        <form class="theme-form" method="post" action="{{ route('coi.store', Request::segment(3)) }}" id="coi">
                            @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <p class="sub-title">Importer / Buyer Information</p>
                                        <div class="figure d-block">
                                            <blockquote class="blockquote">
                                                <p class="mb-0">-- Buyer information such as name, tel, fax, address</p>
                                            </blockquote>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="buyer_name">Buyer Name:</label>
                                                <input class="form-control" name="buyer_name" id="buyer_name" type="text" @if(isset($coi->statusCOI) && $coi->statusCOI > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif value="{{ old('buyer_name', optional($coi)->buyer_name) }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="buyer_tel">Buyer Tel:</label>
                                                <input class="form-control" name="buyer_tel" id="buyer_tel" type="text"  @if(isset($coi->statusCOI) && $coi->statusCOI > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif value="{{ old('buyer_tel', optional($coi)->buyer_tel) }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="buyer_fax">Buyer Fax:</label>
                                                <input class="form-control" name="buyer_fax" id="buyer_fax" type="text"  @if(isset($coi->statusCOI) && $coi->statusCOI > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif value="{{ old('buyer_fax', optional($coi)->buyer_fax) }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="buyer_address">Buyer Address:</label>
                                                <textarea class="form-control" name="buyer_address" id="buyer_address" rows="4"  @if(isset($coi->statusCOI) && $coi->statusCOI > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif>{{ old('buyer_address', optional($coi)->buyer_address) }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <p class="sub-title">Exporter / Seller Information</p>
                                        <div class="figure d-block">
                                            <blockquote class="blockquote">
                                                <p class="mb-0">-- Seller information such as name, tel, fax, address</p>
                                            </blockquote>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="seller_name">Seller Name:</label>
                                                <input class="form-control" name="seller_name" id="seller_name" type="text" @if(isset($coi->statusCOI) && $coi->statusCOI > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif value="{{ old('seller_name', optional($coi)->seller_name) }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="seller_tel">Seller Tel:</label>
                                                <input class="form-control" name="seller_tel" id="seller_tel" type="text" @if(isset($coi->statusCOI) && $coi->statusCOI > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif value="{{ old('seller_tel', optional($coi)->seller_tel) }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="seller_fax">Seller Fax:</label>
                                                <input class="form-control" name="seller_fax" id="seller_fax" type="text" @if(isset($coi->statusCOI) && $coi->statusCOI > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif value="{{ old('seller_fax', optional($coi)->seller_fax) }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="seller_address">Seller Address:</label>
                                                <textarea class="form-control" name="seller_address" id="seller_address" rows="4" @if(isset($coi->statusCOI) && $coi->statusCOI > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif>{{ old('seller_address', optional($coi)->seller_address) }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <p class="sub-title">Manufacturer / Producer Information</p>
                                        <div class="figure d-block">
                                            <blockquote class="blockquote">
                                                <p class="mb-0">-- Manufacturer information such as name, tel, fax, address</p>
                                            </blockquote>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="manufacturer_name">Manufacturer Name:</label>
                                                <input class="form-control" name="manufacturer_name" id="manufacturer_name" type="text" @if(isset($coi->statusCOI) && $coi->statusCOI > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif value="{{ old('manufacturer_name', optional($coi)->manufacturer_name) }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="manufacturer_tel">Manufacturer Tel:</label>
                                                <input class="form-control" name="manufacturer_tel" id="manufacturer_tel" type="text" @if(isset($coi->statusCOI) && $coi->statusCOI > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif  value="{{ old('manufacturer_tel', optional($coi)->manufacturer_tel) }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="manufacturer_fax">Manufacturer Fax:</label>
                                                <input class="form-control" name="manufacturer_fax" id="manufacturer_fax" type="text" @if(isset($coi->statusCOI) && $coi->statusCOI > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif value="{{ old('manufacturer_fax', optional($coi)->manufacturer_fax) }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="manufacturer_address">Manufacturer Address:</label>
                                                <textarea class="form-control" name="manufacturer_address" id="manufacturer_address" rows="4" @if(isset($coi->statusCOI) && $coi->statusCOI > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif>{{ old('manufacturer_address', optional($coi)->manufacturer_address) }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <p class="sub-title">Purchase and Transportation Information</p>
                                        <div class="figure d-block">
                                            <blockquote class="blockquote">
                                                <p class="mb-0">-- Information related to PI, CI, B/L, L/C and etc.</p>
                                            </blockquote>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="piNo">PI No. & Date</label>
                                                <div class="row row-cols-sm-2 theme-form mt-2 form-bottom">
                                                    <div class="mb-2 d-flex">
                                                        <input class="form-control" type="text" name="piNo" @if(isset($coi->statusCOI) && $coi->statusCOI > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif value="{{ old('piNo', optional($order)->piNo) ? old('piNo', optional($order)->piNo) : $order->piNo }}">
                                                    </div>
                                                    <div class="mb-2 d-flex">
                                                        <input class="datepicker-here form-control digits" @if(isset($coi->statusCOI) && $coi->statusCOI > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif type="text" data-language="en" data-bs-original-title="" title="" name="piDate" id="piDate" value="{{ old('piDate', optional($coi)->piDate) }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="invoiceNo">CI No. & Date</label>
                                                <div class="row row-cols-sm-2 theme-form mt-2 form-bottom">
                                                    <div class="mb-2 d-flex">
                                                        <input class="form-control" type="text" name="invoiceNo" @if(isset($coi->statusCOI) && $coi->statusCOI > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif value="{{ old('invoiceNo', optional($coi)->invoiceNo) }}">
                                                    </div>
                                                    <div class="mb-2 d-flex">
                                                        <input class="datepicker-here form-control digits" @if(isset($coi->statusCOI) && $coi->statusCOI > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif type="text" data-language="en" data-bs-original-title="" title="" name="invoiceDate" id="invoiceDate" value="{{ old('invoiceDate', optional($coi)->invoiceDate) }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="blNo">BL No. & Date</label>
                                                <div class="row row-cols-sm-2 theme-form mt-2 form-bottom">
                                                    <div class="mb-2 d-flex">
                                                        <input class="form-control" type="text" name="blNo" @if(isset($coi->statusCOI) && $coi->statusCOI > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif value="{{ old('blNo', optional($coi)->blNo) }}">
                                                    </div>
                                                    <div class="mb-2 d-flex">
                                                        <input class="datepicker-here form-control digits" @if(isset($coi->statusCOI) && $coi->statusCOI > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif type="text" data-language="en" data-bs-original-title="" title="" name="blDate" id="blDate" value="{{ old('blDate', optional($coi)->blDate) }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="lcNo">LC No.:</label>
                                                <input class="form-control" name="lcNo" id="lcNo" type="text" @if(isset($coi->statusCOI) && $coi->statusCOI > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif value="{{ old('lcNo', optional($order)->lcNo) ? old('lcNo', optional($order)->lcNo) : $order->lcNo }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="insuranceCompany">Insurance Company & Policy No.</label>
                                                <div class="row row-cols-sm-2 theme-form mt-2 form-bottom">
                                                    <div class="mb-2 d-flex">
                                                        <input class="form-control" type="text" name="insuranceCompany" @if(isset($coi->statusCOI) && $coi->statusCOI > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif value="{{ (old('insuranceCompany', optional($coi)->insuranceCompany) !== null) ? old('insuranceCompany', optional($coi)->insuranceCompany) : 'Company Name' }}">
                                                    </div>
                                                    <div class="mb-2 d-flex">
                                                        <input class="form-control digits" type="text" data-language="en" @if(isset($coi->statusCOI) && $coi->statusCOI > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif data-bs-original-title="" title="" name="insurancePolicy" id="insurancePolicy" value="{{ (old('insurancePolicy', optional($coi)->insurancePolicy) !== null) ? old('insurancePolicy', optional($coi)->insurancePolicy) : 'Policy No' }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3" style="margin-top: 8px;">
                                                <label class="col-form-label pt-0" for="mdsd">MD/SD Dated:</label>
                                                <input class="datepicker-here form-control digits" data-language="en" name="mdsd" id="mdsd" type="text" @if(isset($coi->statusCOI) && $coi->statusCOI > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif placeholder="Date"  value="{{ old('mdsd', optional($coi)->mdsd) }}">
                                            </div>
                                            <div class="mb-3" style="margin-top: 32px;">
                                                <label class="col-form-label pt-0" for="origin">Country of Origin:</label>
                                                <input class="form-control" name="origin" id="origin" type="text" @if(isset($coi->statusCOI) && $coi->statusCOI > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif value="{{ old('origin', optional($order)->origin) ? old('origin', optional($order)->origin) : $order->origin }}">
                                            </div>
                                            <div class="mb-3" style="margin-top: 32px;">
                                                <label class="col-form-label pt-0" for="portDischarge">Port of Discharge:</label>
                                                <input class="form-control" name="portDischarge" id="portDischarge" type="text" @if(isset($coi->statusCOI) && $coi->statusCOI > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif  value="{{ old('portDischarge', optional($coi)->portDischarge) }}">
                                            </div>
                                            <div class="mb-3" style="margin-top: 24px;">
                                                <label class="col-form-label pt-0" for="serialGoods">Serial / Code No. of Goods:</label>
                                                <input class="form-control" name="serialGoods" id="serialGoods" type="text"  @if(isset($coi->statusCOI) && $coi->statusCOI > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif value="{{ old('serialGoods', optional($coi)->serialGoods) }}">
                                            </div>
                                            <div class="mb-3" style="margin-top: 24px;">
                                                <label class="col-form-label pt-0" for="totalQuantityCOI">Quantity Shipped:</label>
                                                <input class="form-control" name="totalQuantityCOI" id="totalQuantityCOI" type="text" @if(isset($coi->statusCOI) && $coi->statusCOI > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif  value="{{ old('totalQuantityCOI', optional($coi)->totalQuantityCOI) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <p class="sub-title">Inspection Information</p>
                                        <div class="figure d-block">
                                            <blockquote class="blockquote">
                                                <p class="mb-0">-- Inspection information such as Inspection place and date, inspector name, date of sampling and etc</p>
                                            </blockquote>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="inspectorNameCOI">Inspector Name:</label>
                                                <input class="form-control" name="inspectorNameCOI" id="inspectorNameCOI" type="text" @if(isset($coi->statusCOI) && $coi->statusCOI > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif value="{{ old('inspectorID', optional($order)->inspectorID) ? old('inspectorID', optional($order)->inspectorID) : $order->inspectorID }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="inspectionPlace">Inspection Place & Date</label>
                                                <div class="row row-cols-sm-2 theme-form mt-2 form-bottom">
                                                    <div class="mb-2 d-flex">
                                                        <input class="form-control" type="text" name="inspectionPlace" placeholder="Place" @if(isset($coi->statusCOI) && $coi->statusCOI > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif value="{{ old('inspectionPlace', optional($coi)->inspectionPlace) }}">
                                                    </div>
                                                    <div class="mb-2 d-flex">
                                                        <input class="form-control" type="text" data-language="en" data-bs-original-title="" @if(isset($coi->statusCOI) && $coi->statusCOI > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif title="" name="inspectionDate" id="inspectionDate" placeholder="Date(s)" value="{{ old('inspectionDate', optional($coi)->inspectionDate) }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="samplingDateCOI">Sampling Date:</label>
                                                <input class="datepicker-here form-control digits" type="text" data-language="en" data-bs-original-title="" @if(isset($coi->statusCOI) && $coi->statusCOI > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif title="" name="samplingDateCOI" id="samplingDateCOI" value="{{ old('samplingDateCOI', optional($coi)->samplingDateCOI) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <p class="sub-title">Laboratory and Test Information</p>
                                        <div class="figure d-block">
                                            <blockquote class="blockquote">
                                                <p class="mb-0">-- Test information such as Laboratory profile, test place and date, test report number and etc</p>
                                            </blockquote>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="testingPlaceCOI">Testing Place and Date(s):</label>
                                                <div class="row row-cols-sm-2 theme-form mt-2 form-bottom">
                                                    <div class="mb-2 d-flex">
                                                        <input class="form-control" type="text" name="testingPlaceCOI" placeholder="Testing Place" @if(isset($coi->statusCOI) && $coi->statusCOI > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif value="{{ old('testingPlaceCOI', optional($coi)->testingPlaceCOI) }}">
                                                    </div>
                                                    <div class="mb-2 d-flex">
                                                        <input class="form-control" type="text" data-language="en" data-bs-original-title="" title="" @if(isset($coi->statusCOI) && $coi->statusCOI > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif name="testingDateCOI" id="testingDateCOI" placeholder="Testing Date"  value="{{ old('testingDateCOI', optional($coi)->testingDateCOI) }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="labNameCOI">Laboratory Name and No.:</label>
                                                <div class="row row-cols-sm-2 theme-form mt-2 form-bottom">
                                                    <div class="mb-2 d-flex">
                                                        <input class="form-control" type="text" name="labNameCOI" placeholder="Laboratory Name" @if(isset($coi->statusCOI) && $coi->statusCOI > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif value="{{ old('labNameCOI', optional($coi)->labNameCOI) }}">
                                                    </div>
                                                    <div class="mb-2 d-flex">
                                                        <input class="form-control" type="text" data-language="en" data-bs-original-title="" @if(isset($coi->statusCOI) && $coi->statusCOI > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif title="" name="labNoCOI" id="labNoCOI" placeholder="17025 Cert No."  value="{{ old('labNoCOI', optional($coi)->labNoCOI) }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="testReportNoCOI">Test Report No. and Date(s):</label>
                                                <div class="row row-cols-sm-2 theme-form mt-2 form-bottom">
                                                    <div class="mb-2 d-flex">
                                                        <input class="form-control" type="text" name="testReportNoCOI" placeholder="TR No." @if(isset($coi->statusCOI) && $coi->statusCOI > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif value="{{ old('testReportNoCOI', optional($coi)->testReportNoCOI) }}">
                                                    </div>
                                                    <div class="mb-2 d-flex">
                                                        <input class="form-control" type="text" data-language="en" data-bs-original-title="" @if(isset($coi->statusCOI) && $coi->statusCOI > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif title="" name="testReportDateCOI" id="testReportDateCOI" placeholder="TR Date"  value="{{ old('testReportDateCOI', optional($coi)->testReportDateCOI) }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <p class="sub-title">Conclusion</p>
                                        <div class="figure d-block">
                                            <blockquote class="blockquote">
                                                <p class="mb-0">-- Finalize the COI File</p>
                                            </blockquote>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="conclusionCOI">Conclusion:</label>
                                                <textarea class="form-control" name="conclusionCOI" id="conclusionCOI" @if(isset($coi->statusCOI) && $coi->statusCOI > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif>{{ old('conclusionCOI', optional($coi)->conclusionCOI) }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="otherCommentCOI">Other Comments:</label>
                                                <textarea class="form-control" name="otherCommentCOI" id="otherCommentCOI" @if(isset($coi->statusCOI) && $coi->statusCOI > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif>{{ (old('otherCommentCOI', optional($coi)->otherCommentCOI) !== null) ? old('otherCommentCOI', optional($coi)->otherCommentCOI) : 'Leave it if you need an auto generated text base on laboratory information.' }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3" style="margin-top: 8px">
                                                <label class="col-form-label pt-0" for="samplingDateCOI">Name and Position:</label>
                                                <input class="form-control" type="text" name="signeeCOI" id="signeeCOI" value="Alireza Tavakkoli / Managing Director" @if(isset($coi->statusCOI) && $coi->statusCOI > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif disabled>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="issuingPlaceCOI">Issuing Place & Date</label>
                                                <div class="row row-cols-sm-2 theme-form mt-2 form-bottom">
                                                    <div class="mb-2 d-flex">
                                                        <input class="form-control" type="text" name="issuingPlaceCOI" placeholder="Place" value="{{ old('issuingPlaceCOI', optional($coi)->issuingPlaceCOI) }}" @if(isset($coi->statusCOI) && $coi->statusCOI > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif>
                                                    </div>
                                                    <div class="mb-2 d-flex">
                                                        @php
                                                            $date = new DateTime($coi->signDateCOI);
                                                            // Format the date into Y-M-d format
                                                            $formattedDate = $date->format('Y-M-d');
                                                        @endphp
                                                        <input class="datepicker-here form-control digits" type="text" PLACEHOLDER="Date" data-language="en" data-bs-original-title="" title="" name="signDateCOI" id="signDateCOI" value="{{ old('signDateCOI', $formattedDate) }}" @if(isset($coi->statusCOI) && $coi->statusCOI > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif>
                                                    </div>
                                                </div>
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
