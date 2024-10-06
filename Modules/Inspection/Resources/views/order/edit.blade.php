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

                    <h3>Inspection Order</h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">{{ __('common.home') }}</a></li>
                        <li class="breadcrumb-item">Inspection Department</li>
                        <li class="breadcrumb-item active">New Order</li>
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
                            <h5>Edit Order for {{ $order->customer->fullName.' - '.$order->customer->cName }}</h5><span>The First step is to fill the inspection order form.</span>
                        </div>
                        <form class="theme-form" method="post" action="{{ route('order.update', ['slug' => $order->id]) }}" id="orderUpdate">
                            @csrf
                            <div class="card-body">
                                <ul class="nav nav-tabs nav-right" id="right-tab" role="tablist">
                                    <li class="nav-item"><a class="nav-link active" id="right-home-tab" data-bs-toggle="tab" href="tab-bootstrap.html#right-home" role="tab" aria-controls="right-home" aria-selected="true"><i class="icofont icofont-ui-home"></i>General</a></li>
                                    <li class="nav-item"><a class="nav-link" id="profile-right-tab" data-bs-toggle="tab" href="tab-bootstrap.html#right-profile" role="tab" aria-controls="profile-icon" aria-selected="false"><i class="icofont icofont-man-in-glasses"></i>Expoter / Importer</a></li>
{{--                                    <li class="nav-item"><a class="nav-link" id="labs-right-tab" data-bs-toggle="tab" href="tab-bootstrap.html#right-labs" role="tab" aria-controls="contact-icon" aria-selected="false"><i class="icofont icofont-contacts"></i>Standards & Laboratory</a></li>--}}
{{--                                    <li class="nav-item"><a class="nav-link" id="contact-right-tab" data-bs-toggle="tab" href="tab-bootstrap.html#right-contact" role="tab" aria-controls="contact-icon" aria-selected="false"><i class="icofont icofont-contacts"></i>Scope of Inspection</a></li>--}}
                                </ul>
                                <div class="tab-content" id="right-tabContent">
                                    <div class="tab-pane fade show active" id="right-home" role="tabpanel" aria-labelledby="right-home-tab">
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label class="col-form-label pt-0" for="service">Inspection Service</label>
                                                    <select class="form-control" name="service" id="service"  @if($order->technicalStatus > 4 and Auth()->user()->sector != 'management' and Auth()->user()->level != 'technical') disabled @endif>
                                                        <option value="{{ $order->service }}">{{ $order->service }}</option>
{{--                                                        <option value="COI">COI</option>--}}
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="col-form-label pt-0" for="piNo">PI No.</label>
                                                    <input type="text"  class="form-control" name="piNo" id="piNo"  value="{{ $order->piNo }}"  {{ $disabled }}>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="col-form-label pt-0" for="country_origin">Country of Origin</label>
                                                    <input type="text"  class="form-control" name="country_origin" id="country_origin"  value="{{ $order->country_origin }}"  {{ $disabled }}>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="col-form-label pt-0" for="category">Goods Category</label>
                                                    <select class="form-control" name="category" id="category"  @if($order->technicalStatus > 4 and Auth()->user()->sector != 'management' and Auth()->user()->level != 'technical') disabled @endif>
                                                        <option value="{{ $order->category }}">{{ $order->category }}</option>
                                                        <option value="chemical">chemical</option>
                                                        <option value="construction">construction</option>
                                                        <option value="engineering">engineering</option>
                                                        <option value="food">food</option>
                                                        <option value="safety">safety</option>
                                                        <option value="textile">textile</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label class="col-form-label pt-0" for="shipmentMethod">Shipment Method</label>
                                                    <select class="form-control" name="shipmentMethod" id="shipmentMethod"  @if($order->technicalStatus > 4 and Auth()->user()->sector != 'management' and Auth()->user()->level != 'technical') disabled @endif>
                                                        <option value="{{ $order->shipmentMethod }}">{{ $order->shipmentMethod }}</option>
                                                        <optgroup label="Air Ports" style="font-weight:bold;">Select
                                                            <option value="Road">Road</option>
                                                            <option value="Sea">Sea</option>
                                                            <option value="Air">Air</option>
                                                        </optgroup>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="col-form-label pt-0" for="shipmentType">Shipment Type</label>
                                                    <select class="form-control" name="shipmentType" id="shipmentType"  @if($order->technicalStatus > 4 and Auth()->user()->sector != 'management' and Auth()->user()->level != 'technical') disabled @endif>
                                                        <option value="{{ $order->shipmentType }}">{{ $order->shipmentType }}</option>
                                                        <optgroup label="Air Ports" style="font-weight:bold;">Select
                                                            <option value="Full Container">Full Container</option>
                                                            <option value="Partial Container">Partial Container</option>
                                                            <option value="Truck">Truck</option>
                                                            <option value="Bulk">Bulk</option>
                                                            <option value="Package">Package</option>
                                                        </optgroup>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="col-form-label pt-0" for="border">Entry Point</label>
                                                    <select class="form-control" name="border" id="border"  @if($order->technicalStatus > 4 and Auth()->user()->sector != 'management' and Auth()->user()->level != 'technical') disabled @endif>
                                                        <option value="{{ $order->border }}">{{ $order->border }}</option>
                                                        <optgroup label="Air Ports" style="font-weight:bold;">Air Ports
                                                            <option value="Basrah International Airport">Basrah International Airport</option>
                                                        </optgroup>
                                                        <optgroup label="Sea Ports" style="font-weight:bold;">Sea Ports
                                                            <option value="North Umm Al-Qasr Port">North Umm Al-Qasr Port</option>
                                                            <option value="Middle Umm Al-Qasr Port">Middle Umm Al-Qasr Port</option>
                                                            <option value="South Umm Al-Qasr Port">South Umm Al-Qasr Port</option>
                                                            <option value="Abu Flous Port">Abu Flous Port</option>
                                                            <option value="Al-Maqal Port">Al-Maqal Port</option>
                                                            <option value="Khor Al-Zubair Port">Khor Al-Zubair Port</option>
                                                        </optgroup>
                                                        <optgroup label="LAND" style="font-weight:bold;">
                                                            <option value="Rabia">Rabia</option>
                                                            <option value="Trebil">Trebil</option>
                                                            <option value="Zurbatiyah">Zurbatiyah</option>
                                                            <option value="Mandali">Mandali</option>
                                                            <option value="Arar">Arar</option>
                                                            <option value="Shalamcheh">Shalamcheh</option>
                                                            <option value="Muntheria">Muntheria</option>
                                                            <option value="Sheep">Sheep</option>
                                                            <option value="Safwan">Safwan</option>
                                                        </optgroup>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="col-form-label pt-0" for="container">Total Shipments / Containers</label>
                                                    <input class="form-control" name="container" id="container" type="number"  value="{{ $order->container }}"  {{ $disabled }}>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="desc">Description of Goods</label>
                                                <textarea class="form-control" name="desc" id="desc" rows="5"  {{ $disabled }} >{{ $order->desc }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="right-profile" role="tabpanel" aria-labelledby="profile-right-tab">
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label class="col-form-label pt-0" for="exporter">Exporter Company</label>
                                                    <input type="text"  class="form-control" name="exporter" id="exporter" {{ $disabled }} value="{{ $order->exporter }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="col-form-label pt-0" for="exporter_contact_person_name">Contact Person</label>
                                                    <input type="text"  class="form-control" name="exporter_contact_person_name" id="exporter_contact_person_name"  {{ $disabled }} value="{{ $order->exporter_contact_person_name }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="col-form-label pt-0" for="exporter_city_country">City - Country</label>
                                                    <input type="text"  class="form-control" name="exporter_city_country" id="exporter_city_country"  {{ $disabled }} value="{{ $order->exporter_city_country }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="col-form-label pt-0" for="exporter_address">Address</label>
                                                    <textarea  class="form-control" name="exporter_address" id="exporter_address"  {{ $disabled }}>{{ $order->exporter_address }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="col-form-label pt-0" for="exporter_phone">Phone</label>
                                                    <input type="text"  class="form-control" name="exporter_phone" id="exporter_phone" {{ $disabled }} value="{{ $order->exporter_phone }}">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label class="col-form-label pt-0" for="importer_company_name">Importer Company</label>
                                                    <input type="text"  class="form-control" name="importer_company_name" id="importer_company_name" {{ $disabled }} value="{{ $order->importer_company_name }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="col-form-label pt-0" for="importer_contact_person_name">Contact Person</label>
                                                    <input type="text"  class="form-control" name="importer_contact_person_name" id="importer_contact_person_name" {{ $disabled }} value="{{ $order->importer_contact_person_name }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="col-form-label pt-0" for="importer_city_country">City - Country</label>
                                                    <input type="text"  class="form-control" name="importer_city_country" id="importer_city_country" {{ $disabled }} value="{{ $order->importer_city_country }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="col-form-label pt-0" for="importer_address">Address</label>
                                                    <textarea  class="form-control" name="importer_address" id="importer_address"  {{ $disabled }}>{{ $order->importer_address }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="col-form-label pt-0" for="importer_phone">Phone</label>
                                                    <input type="text"  class="form-control" name="importer_phone" id="importer_phone" {{ $disabled }} value="{{ $order->importer_phone }}">
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                @if($disabled == null)
                                                    <button class="btn btn-primary">Submit</button>
                                                @else
                                                    <a href="{{ route('coc.show', $order->id) }}" class="btn btn-warning btn-xs">Back</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

{{--                                    <div class="tab-pane fade" id="right-labs" role="tabpanel" aria-labelledby="labs-right-tab">--}}
{{--                                        <br>--}}
{{--                                        <div class="row">--}}
{{--                                            <div class="col-sm-6">--}}
{{--                                                <div class="mb-3">--}}
{{--                                                    <label class="col-form-label pt-0" for="applicableStandardSampling">Applicable Standard for Sampling</label>--}}
{{--                                                    <textarea disabled  class="form-control" style="white-space: pre-wrap" name="applicableStandardSampling" id="applicableStandardSampling" rows="5">{{ $order->applicableStandardSampling }}</textarea>--}}
{{--                                                </div>--}}
{{--                                                <div class="mb-3">--}}
{{--                                                    <label class="col-form-label pt-0" for="safetyEquipment">Safety Equipment</label>--}}
{{--                                                    <textarea disabled  class="form-control" name="safetyEquipment" id="safetyEquipment"  >{{ $order->safetyEquipment }}</textarea>--}}
{{--                                                </div>--}}
{{--                                                <div class="mb-3">--}}
{{--                                                    <label class="col-form-label pt-0" for="InspectionEquipment">Inspection Equipment</label>--}}
{{--                                                    <textarea disabled  class="form-control" name="InspectionEquipment" id="InspectionEquipment"  >{{ $order->InspectionEquipment }}</textarea>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-sm-6">--}}
{{--                                                <div class="mb-3">--}}
{{--                                                    <label class="col-form-label pt-0" for="applicableStandardTesting">Applicable Standard(s) for Testing</label>--}}
{{--                                                    <textarea disabled  class="form-control" name="applicableStandardTesting" id="applicableStandardTesting"  >{{ $order->applicableStandardTesting }}</textarea>--}}
{{--                                                </div>--}}
{{--                                                <div class="mb-3">--}}
{{--                                                    <label class="col-form-label pt-0" for="labStatus">Status Of Lab (IEC/ISO 17025:2017 Certificate)</label>--}}
{{--                                                    <input disabled  class="form-control" name="labStatus" id="labStatus" type="text" value="{{ $order->labStatus }}">--}}
{{--                                                </div>--}}

{{--                                                <div class="mb-3">--}}
{{--                                                    <label class="col-form-label pt-0" for="labCertNo">Accreditation Certificate’s No.</label>--}}
{{--                                                    <input disabled  class="form-control" name="labCertNo" id="labCertNo" type="text" value="{{ $order->labCertNo }}">--}}
{{--                                                </div>--}}

{{--                                                <div class="mb-3">--}}
{{--                                                    <label class="col-form-label pt-0" for="labName">Lab’s Name</label>--}}
{{--                                                    <input disabled  class="form-control" name="labName" id="labName" type="text" value="{{ $order->labName }}">--}}
{{--                                                </div>--}}

{{--                                                <div class="mb-3">--}}
{{--                                                    <label class="col-form-label pt-0" for="contractorName">Contractor’s Name</label>--}}
{{--                                                    <input disabled  class="form-control" name="contractorName" id="contractorName" type="text"  value="{{ $order->contractorName }}">--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-sm-12">--}}
{{--                                                <div class="mb-3">--}}
{{--                                                    <label class="col-form-label pt-0" for="remark2">Remark</label>--}}
{{--                                                    <textarea disabled  class="form-control" style="white-space: pre-wrap" name="remark2" id="remark2" rows="5">{{ $order->remark2 }}</textarea>--}}
{{--                                                </div>--}}

{{--                                                <div class="mb-3">--}}
{{--                                                    <label class="col-form-label pt-0" for="note1">Note 1</label>--}}
{{--                                                    <textarea disabled  class="form-control" name="note1" id="note1"  >{{ $order->note1 }}</textarea>--}}
{{--                                                </div>--}}
{{--                                                <div class="mb-3">--}}
{{--                                                    <label class="col-form-label pt-0" for="note2">Note 2</label>--}}
{{--                                                    <textarea disabled  class="form-control" name="note2" id="note2"  >{{ $order->note2 }}</textarea>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="tab-pane fade" id="right-contact" role="tabpanel" aria-labelledby="contact-right-tab">--}}
{{--                                        <br>--}}
{{--                                        <div class="row">--}}
{{--                                            <div class="col-sm-3">--}}
{{--                                                <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                    <input disabled  class="color-test form-check-input" id="scopeVI" name="scopeVI" type="checkbox" @if($order->scopeVI == 1) checked @endif>--}}
{{--                                                    <label class="form-check-label" for="scopeVI">Visual Inspection</label>--}}
{{--                                                </div>--}}

{{--                                                <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                    <input disabled  class="form-check-input" id="scopeQCR" name="scopeQCR" type="checkbox" @if($order->scopeQCR == 1) checked @endif>--}}
{{--                                                    <label class="form-check-label" for="scopeQCR">Quantity check at random</label>--}}
{{--                                                </div>--}}

{{--                                                <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                    <input  disabled class="form-check-input" id="scopeQVB" name="scopeQVB" type="checkbox" @if($order->scopeQVB == 1) checked @endif>--}}
{{--                                                    <label class="form-check-label" for="scopeQVB">Quality on Visual Basis</label>--}}
{{--                                                </div>--}}

{{--                                                <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                    <input disabled  class="form-check-input" id="scopeSample" name="scopeSample" type="checkbox" @if($order->scopeSample == 1) checked @endif>--}}
{{--                                                    <label class="form-check-label" for="scopeSample">Sampling</label>--}}
{{--                                                </div>--}}

{{--                                                <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                    <input disabled  class="form-check-input" id="scopeMD" name="scopeMD" type="checkbox" @if($order->scopeMD == 1) checked @endif>--}}
{{--                                                    <label class="form-check-label" for="scopeMD">Moisture Determination</label>--}}
{{--                                                </div>--}}

{{--                                                <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                    <input disabled  class="form-check-input" id="scopeSS" name="scopeSS" type="checkbox" @if($order->scopeSS == 1) checked @endif>--}}
{{--                                                    <label class="form-check-label" for="scopeSS">Sealing Samples</label>--}}
{{--                                                </div>--}}

{{--                                                <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                    <input  disabled class="form-check-input" id="scopeWT" name="scopeWT" type="checkbox" @if($order->scopeWT == 1) checked @endif>--}}
{{--                                                    <label class="form-check-label" for="scopeWT">Witness of Testing</label>--}}
{{--                                                </div>--}}

{{--                                            </div>--}}
{{--                                            <div class="col-sm-3">--}}
{{--                                                <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                    <input disabled  class="form-check-input" id="scopeSOL" name="scopeSOL" type="checkbox" @if($order->scopeSOL == 1) checked @endif>--}}
{{--                                                    <label class="form-check-label" for="scopeSOL">Supervision of Loading</label>--}}
{{--                                                </div>--}}

{{--                                                <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                    <input disabled  class="form-check-input" id="scopeSOD" name="scopeSOD" type="checkbox" @if($order->scopeSOD == 1) checked @endif>--}}
{{--                                                    <label class="form-check-label" for="scopeSOD">Supervision of Discharging</label>--}}
{{--                                                </div>--}}

{{--                                                <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                    <input disabled  class="form-check-input" id="scopePacking" name="scopePacking" type="checkbox" @if($order->scopePacking == 1) checked @endif>--}}
{{--                                                    <label class="form-check-label" for="scopePacking">Packing</label>--}}
{{--                                                </div>--}}

{{--                                                <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                    <input disabled  class="form-check-input" id="scopeMarking" name="scopeMarking" type="checkbox" @if($order->scopeMarking == 1) checked @endif>--}}
{{--                                                    <label class="form-check-label" for="scopeMarking">Marking</label>--}}
{{--                                                </div>--}}

{{--                                                <div class="form-check form-check-inline checkbox checkbox-primary">--}}
{{--                                                    <input disabled  class="form-check-input" id="scopeCI" name="scopeCI" type="checkbox" @if($order->scopeCI == 1) checked @endif>--}}
{{--                                                    <label class="form-check-label" for="scopeCI">Container Inspection</label>--}}
{{--                                                </div>--}}

{{--                                                <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                    <input disabled  class="form-check-input" id="scopeSC" name="scopeSC" type="checkbox" @if($order->scopeSC == 1) checked @endif>--}}
{{--                                                    <label class="form-check-label" for="scopeSC">Sealing Container</label>--}}
{{--                                                </div>--}}

{{--                                                <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                    <input disabled  class="form-check-input" id="scopeDS" name="scopeDS" type="checkbox" @if($order->scopeDS == 1) checked @endif>--}}
{{--                                                    <label class="form-check-label" for="scopeDS">Damage Survey</label>--}}
{{--                                                </div>--}}


{{--                                            </div>--}}

{{--                                            <div class="col-sm-3">--}}
{{--                                                <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                    <input disabled  class="form-check-input" id="scopeHT" name="scopeHT" type="checkbox" @if($order->scopeHT == 1) checked @endif>--}}
{{--                                                    <label class="form-check-label" for="scopeHT">Hold / Tank Inspection</label>--}}
{{--                                                </div>--}}

{{--                                                <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                    <input disabled  class="form-check-input" id="scopeDSU" name="scopeDSU" type="checkbox" @if($order->scopeDSU == 1) checked @endif>--}}
{{--                                                    <label class="form-check-label" for="scopeDSU">Draft Survey</label>--}}
{{--                                                </div>--}}

{{--                                                <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                    <input disabled  class="form-check-input" id="scopeUS" name="scopeUS" type="checkbox" @if($order->scopeUS == 1) checked @endif>--}}
{{--                                                    <label class="form-check-label" for="scopeUS">Ullage Survey</label>--}}
{{--                                                </div>--}}

{{--                                                <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                    <input disabled  class="form-check-input" id="scopeBS" name="scopeBS" type="checkbox" @if($order->scopeBS == 1) checked @endif>--}}
{{--                                                    <label class="form-check-label" for="scopeBS">Bunker Survey</label>--}}
{{--                                                </div>--}}

{{--                                                <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                    <input  disabled class="form-check-input" id="scopeTA" name="scopeTA" type="checkbox" @if($order->scopeTA == 1) checked @endif>--}}
{{--                                                    <label class="form-check-label" for="scopeTA">Testing and Analysis</label>--}}
{{--                                                </div>--}}

{{--                                                <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                    <input disabled  class="form-check-input" id="scopeOFF" name="scopeOFF" type="checkbox" @if($order->scopeOFF == 1) checked @endif>--}}
{{--                                                    <label class="form-check-label" for="scopeOFF">ON/OFF Hire Survey</label>--}}
{{--                                                </div>--}}

{{--                                                <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                    <input disabled  class="form-check-input" id="scopeCS" name="scopeCS" type="checkbox" @if($order->scopeCS == 1) checked @endif>--}}
{{--                                                    <label class="form-check-label" for="scopeCS">Crane Survey</label>--}}
{{--                                                </div>--}}


{{--                                            </div>--}}

{{--                                            <div class="col-sm-3">--}}
{{--                                                <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                    <input disabled  class="form-check-input" id="scopeBSU" name="scopeBSU" type="checkbox" @if($order->scopeBSU == 1) checked @endif>--}}
{{--                                                    <label class="form-check-label" for="scopeBSU">Barge Survey</label>--}}
{{--                                                </div>--}}

{{--                                                <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                    <input  disabled class="form-check-input" id="scopePhoto" name="scopePhoto" type="checkbox" @if($order->scopePhoto == 1) checked @endif>--}}
{{--                                                    <label class="form-check-label" for="scopePhoto">Photography</label>--}}
{{--                                                </div>--}}

{{--                                                <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                    <input  disabled class="form-check-input" id="scopeLC" name="scopeLC" type="checkbox" @if($order->scopeLC == 1) checked @endif>--}}
{{--                                                    <label class="form-check-label" for="scopeLC">Lashing / Choking</label>--}}
{{--                                                </div>--}}

{{--                                                <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                    <input  disabled class="form-check-input" id="scopeRM" name="scopeRM" type="checkbox" @if($order->scopeRM == 1) checked @endif>--}}
{{--                                                    <label class="form-check-label" for="scopeRM">Raw Material Inspection</label>--}}
{{--                                                </div>--}}

{{--                                                <div class="form-check form-check-inline checkbox checkbox-primary">--}}
{{--                                                    <input  disabled class="form-check-input" id="scopeRSD" name="scopeRSD" type="checkbox" @if($order->scopeRSD == 1) checked @endif>--}}
{{--                                                    <label class="form-check-label" for="scopeRSD">Review of shipping Documents</label>--}}
{{--                                                </div>--}}

{{--                                                <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                    <input  disabled class="form-check-input" id="scopeCIS" name="scopeCIS" type="checkbox" @if($order->scopeCIS == 1) checked @endif>--}}
{{--                                                    <label class="form-check-label" for="scopeCIS">Coating Inspection</label>--}}
{{--                                                </div>--}}


{{--                                                <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                    <input  disabled class="form-check-input" id="video" name="video" type="checkbox" @if($order->video == 1) checked @endif>--}}
{{--                                                    <label class="form-check-label" for="video">Video</label>--}}
{{--                                                </div>--}}

{{--                                                <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                    <input  disabled class="form-check-input" id="scopeRT" name="scopeRT" type="checkbox"  @if($order->scopeRT == 1) checked @endif>--}}
{{--                                                    <label class="form-check-label" for="scopeRT">Review of Testing Result / Quality Docs</label>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="mb-3">--}}
{{--                                                <label class="col-form-label pt-0" for="other" name="other">Other Scope</label>--}}
{{--                                                <input disabled  class="form-control" name="other" id="other" type="text" value="{{ $order->other }}">--}}
{{--                                            </div>--}}

{{--                                            <div class="mb-3">--}}
{{--                                                <label class="col-form-label pt-0" for="remark" name="remark">Remark on scope</label>--}}
{{--                                                <textarea  disabled class="form-control" name="remark" id="remark" >{{ $order->remark }}</textarea>--}}
{{--                                            </div>--}}

{{--                                        </div>--}}
{{--                                    </div>--}}
                                </div>
                                <div class="card-footer">

                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
    </div>
@endsection

<!-- Container-fluid Ends-->
@section('moreJs')
@endsection
