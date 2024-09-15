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
                            <h5>IC Profile</h5><span>Please fill all required inputs.</span>
                        </div>
                        <form class="theme-form" method="post" action="{{ route('coi.storeIC', Request::segment(3)) }}" id="ic">
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
                                                <input class="form-control" name="buyer_name" id="buyer_name" type="text" @if(isset($coi->statusIC) && $coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif value="{{ old('buyer_name', optional($coi)->buyer_name) }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="buyer_tel">Buyer Tel:</label>
                                                <input class="form-control" name="buyer_tel" id="buyer_tel" type="text"  @if(isset($coi->statusIC) && $coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif value="{{ old('buyer_tel', optional($coi)->buyer_tel) }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="buyer_fax">Buyer Fax:</label>
                                                <input class="form-control" name="buyer_fax" id="buyer_fax" type="text"  @if(isset($coi->statusIC) && $coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif value="{{ old('buyer_fax', optional($coi)->buyer_fax) }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="buyer_address">Buyer Address:</label>
                                                <textarea class="form-control" name="buyer_address" id="buyer_address" rows="4"  @if(isset($coi->statusIC) && $coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif>{{ old('buyer_address', optional($coi)->buyer_address) }}</textarea>
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
                                                <input class="form-control" name="seller_name" id="seller_name" type="text" @if(isset($coi->statusIC) && $coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif value="{{ old('seller_name', optional($coi)->seller_name) }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="seller_tel">Seller Tel:</label>
                                                <input class="form-control" name="seller_tel" id="seller_tel" type="text" @if(isset($coi->statusIC) && $coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif value="{{ old('seller_tel', optional($coi)->seller_tel) }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="seller_fax">Seller Fax:</label>
                                                <input class="form-control" name="seller_fax" id="seller_fax" type="text" @if(isset($coi->statusIC) && $coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif value="{{ old('seller_fax', optional($coi)->seller_fax) }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="seller_address">Seller Address:</label>
                                                <textarea class="form-control" name="seller_address" id="seller_address" rows="4" @if(isset($coi->statusIC) && $coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif>{{ old('seller_address', optional($coi)->seller_address) }}</textarea>
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
                                                <input class="form-control" name="manufacturer_name" id="manufacturer_name" type="text" @if(isset($coi->statusIC) && $coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif value="{{ old('manufacturer_name', optional($coi)->manufacturer_name) }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="manufacturer_tel">Manufacturer Tel:</label>
                                                <input class="form-control" name="manufacturer_tel" id="manufacturer_tel" type="text" @if(isset($coi->statusIC) && $coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif  value="{{ old('manufacturer_tel', optional($coi)->manufacturer_tel) }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="manufacturer_fax">Manufacturer Fax:</label>
                                                <input class="form-control" name="manufacturer_fax" id="manufacturer_fax" type="text" @if(isset($coi->statusIC) && $coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif value="{{ old('manufacturer_fax', optional($coi)->manufacturer_fax) }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="manufacturer_address">Manufacturer Address:</label>
                                                <textarea class="form-control" name="manufacturer_address" id="manufacturer_address" rows="4" @if(isset($coi->statusIC) && $coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif>{{ old('manufacturer_address', optional($coi)->manufacturer_address) }}</textarea>
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
                                                        <input class="form-control" type="text" name="piNo" @if(isset($coi->statusIC) && $coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif value="{{ old('piNo', optional($order)->piNo) ? old('piNo', optional($order)->piNo) : $order->piNo }}">
                                                    </div>
                                                    <div class="mb-2 d-flex">
                                                        <input class="datepicker-here form-control digits" @if(isset($coi->statusIC) && $coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif type="text" data-language="en" data-bs-original-title="" title="" name="piDate" id="piDate" value="{{ old('piDate', optional($coi)->piDate) }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="invoiceNo">CI No. & Date</label>
                                                <div class="row row-cols-sm-2 theme-form mt-2 form-bottom">
                                                    <div class="mb-2 d-flex">
                                                        <input class="form-control" type="text" name="invoiceNo" @if(isset($coi->statusIC) && $coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif value="{{ old('invoiceNo', optional($coi)->invoiceNo) }}">
                                                    </div>
                                                    <div class="mb-2 d-flex">
                                                        <input class="datepicker-here form-control digits" @if(isset($coi->statusIC) && $coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif type="text" data-language="en" data-bs-original-title="" title="" name="invoiceDate" id="invoiceDate" value="{{ old('invoiceDate', optional($coi)->invoiceDate) }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="blNo">BL No. & Date</label>
                                                <div class="row row-cols-sm-2 theme-form mt-2 form-bottom">
                                                    <div class="mb-2 d-flex">
                                                        <input class="form-control" type="text" name="blNo" @if(isset($coi->statusIC) && $coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif value="{{ old('blNo', optional($coi)->blNo) }}">
                                                    </div>
                                                    <div class="mb-2 d-flex">
                                                        <input class="datepicker-here form-control digits" @if(isset($coi->statusIC) && $coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif type="text" data-language="en" data-bs-original-title="" title="" name="blDate" id="blDate" value="{{ old('blDate', optional($coi)->blDate) }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="lcNo">LC No.:</label>
                                                <input class="form-control" name="lcNo" id="lcNo" type="text" @if(isset($coi->statusIC) && $coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif  value="{{ old('lcNo', optional($order)->lcNo) ? old('lcNo', optional($order)->lcNo) : $order->lcNo }}">
                                            </div>
                                            <div class="mb-3" style="margin-top: 8px;">
                                                <label class="col-form-label pt-0" for="cbIC">CB Number:</label>
                                                <input class="form-control" name="cbIC" id="cbIC" type="text" @if(isset($coi->statusIC) && $coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif placeholder="Date"  value="{{ old('cbIC', optional($coi)->cbIC) }}">
                                            </div>
                                            <div class="mb-3" style="margin-top: 8px;">
                                                <label class="col-form-label pt-0" for="orderReg">Order Registration No.:</label>
                                                <input class="form-control" name="orderReg" id="orderReg" type="text" @if(isset($coi->statusIC) && $coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif placeholder=""  value="{{ old('orderReg', optional($coi)->orderReg) }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="vessel">Vessel Name:</label>
                                                <input class="form-control" name="vessel" id="vessel" type="text" @if(isset($coi->statusIC) && $coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif placeholder="Vessel Name"  value="{{ old('vessel', optional($order)->vessel) ? old('vessel', optional($order)->vessel) : $order->vessel }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3" style="margin-top: 8px;">
                                                <label class="col-form-label pt-0" for="origin">Country of Origin:</label>
                                                <input class="form-control" name="origin" id="origin" type="text" @if(isset($coi->statusIC) && $coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif  value="{{ old('origin', optional($order)->origin) ? old('origin', optional($order)->origin) : $order->origin }}">
                                            </div>
                                            <div class="mb-3" style="margin-top: 32px;">
                                                <label class="col-form-label pt-0" for="portLoading">Port of Loading:</label>
                                                <input class="form-control" name="portLoading" id="portLoading" type="text" @if(isset($coi->statusIC) && $coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif  value="{{ old('portLoading', optional($coi)->portLoading) }}">
                                            </div>
                                            <div class="mb-3" style="margin-top: 32px;">
                                                <label class="col-form-label pt-0" for="portDischarge">Port of Discharge:</label>
                                                <input class="form-control" name="portDischarge" id="portDischarge" type="text" @if(isset($coi->statusIC) && $coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif  value="{{ old('portDischarge', optional($coi)->portDischarge) }}">
                                            </div>
                                            <div class="mb-3" style="margin-top: 23px;">
                                                <label class="col-form-label pt-0" for="portDelivery">Port of Delivery:</label>
                                                <input class="form-control" name="portDelivery" id="portDelivery" type="text" @if(isset($coi->statusIC) && $coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif  value="{{ old('portDelivery', optional($coi)->portDelivery) }}">
                                            </div>
                                            <div class="mb-3" style="margin-top: 17px;">
                                                <label class="col-form-label pt-0" for="totalQuantityIC">Total Quantity:</label>
                                                <input class="form-control" name="totalQuantityIC" id="totalQuantityIC" type="text" @if(isset($coi->statusIC) && $coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif  value="{{ old('totalQuantityIC', optional($coi)->totalQuantityIC) }}">
                                            </div>
                                            <div class="mb-3" style="margin-top: 16px;">
                                                <label class="col-form-label pt-0" for="netWeightIC">Total Net Weight</label>
                                                <input class="form-control" name="netWeightIC" id="netWeightIC" type="text" @if(isset($coi->statusIC) && $coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif  value="{{ old('netWeightIC', optional($coi)->netWeightIC) }}">
                                            </div>
                                            <div class="mb-3" style="margin-top: 10px;">
                                                <label class="col-form-label pt-0" for="grossWeightIC">Total Gross Weight:</label>
                                                <input class="form-control" name="grossWeightIC" id="grossWeightIC" type="text" @if(isset($coi->statusIC) && $coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif  value="{{ old('grossWeightIC', optional($coi)->grossWeightIC) }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <p class="sub-title">Other Documents Information</p>
                                        <div class="figure d-block">
                                            <blockquote class="blockquote">
                                                <p class="mb-0">-- Like Bank, CB, Manifest, TT, HS Codes, Insurance and etc.</p>
                                            </blockquote>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="issuingBankIC">Issuing Bank:</label>
                                                <input class="form-control" name="issuingBankIC" id="issuingBankIC" type="text" @if(isset($coi->statusIC) && $coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif value="{{ old('issuingBankIC', optional($coi)->issuingBankIC) }}">
                                            </div>
                                            <div class="mb-3" style="margin-top: 24px;">
                                                <label class="col-form-label pt-0" for="customsTarrifIC">Customs Tariff code / HS Code:</label>
                                                <input class="form-control" name="customsTarrifIC" id="customsTarrifIC" type="text"  @if(isset($coi->statusIC) && $coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif value="{{ old('customsTarrifIC', optional($coi)->customsTarrifIC) }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="manifestIC">Manifest No. and Date</label>
                                                <div class="row row-cols-sm-2 theme-form mt-2 form-bottom">
                                                    <div class="mb-2 d-flex">
                                                        <input class="form-control" type="text" name="manifestIC" placeholder="Manifest No." @if(isset($coi->statusIC) && $coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif value="{{ old('manifestIC', optional($coi)->manifestIC) }}">
                                                    </div>
                                                    <div class="mb-2 d-flex">
                                                        <input class="form-control" type="text" data-language="en" data-bs-original-title="" @if(isset($coi->statusIC) && $coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif title="" name="manifestDateIC" id="manifestDateIC" placeholder="Date(s)" value="{{ old('manifestDateIC', optional($coi)->manifestDateIC) }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="ttIC">TT:</label>
                                                <input class="form-control" type="text" data-language="en" data-bs-original-title="" @if(isset($coi->statusIC) && $coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif title="" name="ttIC" id="ttIC" value="{{ old('ttIC', optional($coi)->ttIC) }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="insuranceCompany">Insurance Company & Policy No.</label>
                                                <div class="row row-cols-sm-2 theme-form mt-2 form-bottom">
                                                    <div class="mb-2 d-flex">
                                                        <input class="form-control" type="text" name="insuranceCompany" @if(isset($coi->statusIC) && $coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif value="{{ (old('insuranceCompany', optional($coi)->insuranceCompany) !== null) ? old('insuranceCompany', optional($coi)->insuranceCompany) : 'N/A' }}">
                                                    </div>
                                                    <div class="mb-2 d-flex">
                                                        <input class="form-control digits" type="text" data-language="en" @if(isset($coi->statusIC) && $coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif data-bs-original-title="" title="" name="insurancePolicy" id="insurancePolicy" value="{{ (old('insurancePolicy', optional($coi)->insurancePolicy) !== null) ? old('insurancePolicy', optional($coi)->insurancePolicy) : 'N/A' }}">
                                                    </div>
                                                </div>
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
                                            <div class="mb-3" style="margin-top: 9px">
                                                <label class="col-form-label pt-0" for="inspectorID">Inspector Name:</label>
                                                <input class="form-control" name="inspectorID" id="inspectorID" type="text" @if(isset($coi->statusIC) && $coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif value="{{ old('inspectorID', optional($order)->inspectorID) ? old('inspectorID', optional($order)->inspectorID) : $order->inspectorID }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="inspectionPlace">Inspection Place & Date</label>
                                                <div class="row row-cols-sm-2 theme-form mt-2 form-bottom">
                                                    <div class="mb-2 d-flex">
                                                        <input class="form-control" type="text" name="inspectionPlace" placeholder="Place" @if(isset($coi->statusIC) && $coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif value="{{ old('inspectionPlace', optional($coi)->inspectionPlace) }}">
                                                    </div>
                                                    <div class="mb-2 d-flex">
                                                        <input class="form-control" type="text" data-language="en" data-bs-original-title="" @if(isset($coi->statusIC) && $coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif title="" name="inspectionDate" id="inspectionDate" placeholder="Date(s)" value="{{ old('inspectionDate', optional($coi)->inspectionDate) }}">
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
                                                <label class="col-form-label pt-0" for="packingmarkingIC">Packing Note:</label>
                                                <textarea class="form-control" name="packingmarkingIC" id="packingmarkingIC" @if(isset($coi->statusIC) && $coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif>{{ (old('packingmarkingIC', optional($coi)->packingmarkingIC) !== null) ? old('packingmarkingIC', optional($coi)->packingmarkingIC) : 'Leave it if you need an auto generated text base on laboratory information.' }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="findingsIC">Finding Note:</label>
                                                <textarea class="form-control" name="findingsIC" id="findingsIC" @if(isset($coi->statusIC) && $coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif>{{ (old('findingsIC', optional($coi)->findingsIC) !== null) ? old('findingsIC', optional($coi)->findingsIC) : 'Leave it if you need an auto generated text base on laboratory information.' }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="conclusionIC">Conclusion:</label>
                                                <textarea class="form-control" name="conclusionIC" id="conclusionIC" @if(isset($coi->statusIC) && $coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif>{{ old('conclusionIC', optional($coi)->conclusionIC) }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3" style="margin-top: 8px">
                                                <label class="col-form-label pt-0" for="signeeIC">Name and Position:</label>
                                                <input class="form-control" type="text" name="signeeIC" id="signeeIC" value="Alireza Tavakkoli / Managing Director" @if(isset($coi->statusIC) && $coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif disabled>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="issuingPlaceIC">Issuing Place & Date</label>
                                                <div class="row row-cols-sm-2 theme-form mt-2 form-bottom">
                                                    <div class="mb-2 d-flex">
                                                        <input class="form-control" type="text" name="issuingPlaceIC" placeholder="Place" value="{{ old('issuingPlaceIC', optional($coi)->issuingPlaceIC) }}" @if(isset($coi->statusIC) && $coi->statusIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif>
                                                    </div>
                                                    @php
                                                    if(isset($coi->signDateIC)) {
                                                        $date = new DateTime($coi->signDateIC);
                                                        // Format the date into Y-M-d format
                                                        $formattedDate = $date->format('Y-M-d');
                                                        }
                                                    @endphp
                                                    <div class="mb-2 d-flex">
                                                        <input class="datepicker-here form-control digits" type="text" PLACEHOLDER="Date" data-language="en" data-bs-original-title="" title="" name="signDateIC" id="signDateIC" @if(isset($coi->signDateIC)) value="{{ old('signDateIC', $formattedDate) }}" @endif @if(isset($coi->signDateIC) && $coi->signDateIC > 2 && auth()->user()->level != 'supervisor' && auth()->user()->level != 'manager') disabled @endif>
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
