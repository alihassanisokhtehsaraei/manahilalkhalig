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
                            <h5>New Order for {{ $customer->fullName.' - '.$customer->cName }}</h5><span>The First step is to fill the inspection order form.</span>
                        </div>
                        <form class="theme-form" method="post" action="{{ route('order.store', Request::segment(3)) }}" id="orderNew">
                            @csrf
                        <div class="card-body">
                            <ul class="nav nav-tabs nav-right" id="right-tab" role="tablist">
                                <li class="nav-item"><a class="nav-link active" id="right-home-tab" data-bs-toggle="tab" href="tab-bootstrap.html#right-home" role="tab" aria-controls="right-home" aria-selected="true"><i class="icofont icofont-ui-home"></i>General</a></li>

                                <li class="nav-item"><a class="nav-link" id="profile-right-tab" data-bs-toggle="tab" href="tab-bootstrap.html#right-profile" role="tab" aria-controls="profile-icon" aria-selected="false"><i class="icofont icofont-man-in-glasses"></i>Exporter / Importer</a></li>
{{--                                <li class="nav-item"><a class="nav-link" id="labs-right-tab" data-bs-toggle="tab" href="tab-bootstrap.html#right-labs" role="tab" aria-controls="contact-icon" aria-selected="false"><i class="icofont icofont-contacts"></i>Standards & Laboratory</a></li>--}}
{{--                                <li class="nav-item"><a class="nav-link" id="contact-right-tab" data-bs-toggle="tab" href="tab-bootstrap.html#right-contact" role="tab" aria-controls="contact-icon" aria-selected="false"><i class="icofont icofont-contacts"></i>Scope of Inspection</a></li>--}}

                            </ul>
                            <div class="tab-content" id="right-tabContent">
                                <div class="tab-pane fade show active" id="right-home" role="tabpanel" aria-labelledby="right-home-tab">
                                    <br>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="service">Inspection Service</label>
                                                <select class="form-control" name="service" id="service">
                                                    <option value="COC" {{ old('service') == 'COC' ? 'selected' : '' }}>COC</option>
                                                    {{-- <option value="COI" {{ old('service') == 'COI' ? 'selected' : '' }}>COI</option> --}}
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="piNo">PI No.</label>
                                                <input type="text" class="form-control" name="piNo" id="piNo" value="{{ old('piNo') }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="country_origin">Country of Origin</label>
                                                <select class="form-control" name="country_origin" id="country_origin">
                                                    @foreach ($countries as $country)
                                                        <option value="{{ $country->name }}" {{ old('country_origin') == $country->name ? 'selected' : '' }}>
                                                            {{ $country->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="category">Goods Category</label>
                                                <select class="form-control" name="category" id="category">
                                                    <option value="chemical" {{ old('category') == 'chemical' ? 'selected' : '' }}>chemical</option>
                                                    <option value="construction" {{ old('category') == 'construction' ? 'selected' : '' }}>construction</option>
                                                    <option value="engineering" {{ old('category') == 'engineering' ? 'selected' : '' }}>engineering</option>
                                                    <option value="food" {{ old('category') == 'food' ? 'selected' : '' }}>food</option>
                                                    <option value="safety" {{ old('category') == 'safety' ? 'selected' : '' }}>safety</option>
                                                    <option value="textile" {{ old('category') == 'textile' ? 'selected' : '' }}>textile</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="shipmentMethod">Shipment Method</label>
                                                <select class="form-control" name="shipmentMethod" id="shipmentMethod">
                                                    <option value="Road" {{ old('shipmentMethod') == 'Road' ? 'selected' : '' }}>Road</option>
                                                    <option value="Sea" {{ old('shipmentMethod') == 'Sea' ? 'selected' : '' }}>Sea</option>
                                                    <option value="Air" {{ old('shipmentMethod') == 'Air' ? 'selected' : '' }}>Air</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="shipmentType">Shipment Type</label>
                                                <select class="form-control" name="shipmentType" id="shipmentType">
                                                    <option value="Full Container" {{ old('shipmentType') == 'Full Container' ? 'selected' : '' }}>Full Container</option>
                                                    <option value="Partial Container" {{ old('shipmentType') == 'Partial Container' ? 'selected' : '' }}>Partial Container</option>
                                                    <option value="Truck" {{ old('shipmentType') == 'Truck' ? 'selected' : '' }}>Truck</option>
                                                    <option value="Bulk" {{ old('shipmentType') == 'Bulk' ? 'selected' : '' }}>Bulk</option>
                                                    <option value="Package" {{ old('shipmentType') == 'Package' ? 'selected' : '' }}>Package</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="border">Entry Point</label>
                                                <select class="form-control" name="border" id="border">
                                                    <optgroup label="Air Ports" style="font-weight:bold;">
                                                        <option value="Basrah International Airport" {{ old('border') == 'Basrah International Airport' ? 'selected' : '' }}>Basrah International Airport</option>
                                                    </optgroup>
                                                    <optgroup label="Sea Ports" style="font-weight:bold;">
                                                        <option value="North Umm Al-Qasr Port" {{ old('border') == 'North Umm Al-Qasr Port' ? 'selected' : '' }}>North Umm Al-Qasr Port</option>
                                                        <option value="Middle Umm Al-Qasr Port" {{ old('border') == 'Middle Umm Al-Qasr Port' ? 'selected' : '' }}>Middle Umm Al-Qasr Port</option>
                                                    </optgroup>
                                                    <optgroup label="LAND" style="font-weight:bold;">
                                                        <option value="Rabia" {{ old('border') == 'Rabia' ? 'selected' : '' }}>Rabia</option>
                                                        <option value="Trebil" {{ old('border') == 'Trebil' ? 'selected' : '' }}>Trebil</option>
                                                    </optgroup>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="container">Total Shipments / Containers</label>
                                                <input class="form-control" name="container" id="container" type="number" value="{{ old('container') }}">
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="col-form-label pt-0" for="desc">Description of Goods</label>
                                            <textarea class="form-control" name="desc" id="desc" rows="5">{{ old('desc') }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="right-profile" role="tabpanel" aria-labelledby="profile-right-tab">
                                    <br>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="exporter">Exporter Company</label>
                                                <input type="text" class="form-control" name="exporter" id="exporter" value="{{ old('exporter', $customer->cName) }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="exporter_contact_person_name">Contact Person</label>
                                                <input type="text" class="form-control" name="exporter_contact_person_name" id="exporter_contact_person_name" value="{{ old('exporter_contact_person_name', $customer->fullName) }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="exporter_city_country">City - Country</label>
                                                <input type="text" class="form-control" name="exporter_city_country" id="exporter_city_country" value="{{ old('exporter_city_country', $customer->stateCity.' - '.$customer->country) }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="exporter_address">Address</label>
                                                <textarea class="form-control" name="exporter_address" id="exporter_address">{{ old('exporter_address', $customer->address) }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="exporter_phone">Phone</label>
                                                <input type="text" class="form-control" name="exporter_phone" id="exporter_phone" value="{{ old('exporter_phone', $customer->tel) }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="importer_company_name">Importer Company</label>
                                                <input type="text" class="form-control" name="importer_company_name" id="importer_company_name" value="{{ old('importer_company_name') }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="importer_contact_person_name">Contact Person</label>
                                                <input type="text" class="form-control" name="importer_contact_person_name" id="importer_contact_person_name" value="{{ old('importer_contact_person_name') }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="importer_city_country">City - Country</label>
                                                <input type="text" class="form-control" name="importer_city_country" id="importer_city_country" value="{{ old('importer_city_country') }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="importer_address">Address</label>
                                                <textarea class="form-control" name="importer_address" id="importer_address">{{ old('importer_address') }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="importer_phone">Phone</label>
                                                <input type="text" class="form-control" name="importer_phone" id="importer_phone" value="{{ old('importer_phone') }}">
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <button class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </div>

                                {{--                                <div class="tab-pane fade" id="right-labs" role="tabpanel" aria-labelledby="labs-right-tab">--}}
{{--                                    <br>--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-sm-6">--}}
{{--                                            <div class="mb-3">--}}
{{--                                                <label class="col-form-label pt-0" for="applicableStandardSampling">Applicable Standard for Sampling</label>--}}
{{--                                                <textarea disabled  class="form-control" style="white-space: pre-wrap" name="applicableStandardSampling" id="applicableStandardSampling" rows="5"></textarea>--}}
{{--                                            </div>--}}
{{--                                            <div class="mb-3">--}}
{{--                                                <label class="col-form-label pt-0" for="safetyEquipment">Safety Equipment</label>--}}
{{--                                                <textarea disabled  class="form-control" name="safetyEquipment" id="safetyEquipment"  ></textarea>--}}
{{--                                            </div>--}}
{{--                                            <div class="mb-3">--}}
{{--                                                <label class="col-form-label pt-0" for="InspectionEquipment">Inspection Equipment</label>--}}
{{--                                                <textarea disabled  class="form-control" name="InspectionEquipment" id="InspectionEquipment"  ></textarea>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-sm-6">--}}
{{--                                            <div class="mb-3">--}}
{{--                                                <label class="col-form-label pt-0" for="applicableStandardTesting">Applicable Standard(s) for Testing</label>--}}
{{--                                                <textarea disabled  class="form-control" name="applicableStandardTesting" id="applicableStandardTesting"  ></textarea>--}}
{{--                                            </div>--}}
{{--                                            <div class="mb-3">--}}
{{--                                                <label class="col-form-label pt-0" for="labStatus">Status Of Lab (IEC/ISO 17025:2017 Certificate)</label>--}}
{{--                                                <input disabled  class="form-control" name="labStatus" id="labStatus" type="text">--}}
{{--                                            </div>--}}

{{--                                            <div class="mb-3">--}}
{{--                                                <label class="col-form-label pt-0" for="labCertNo">Accreditation Certificate’s No.</label>--}}
{{--                                                <input disabled  class="form-control" name="labCertNo" id="labCertNo" type="text">--}}
{{--                                            </div>--}}

{{--                                            <div class="mb-3">--}}
{{--                                                <label class="col-form-label pt-0" for="labName">Lab’s Name</label>--}}
{{--                                                <input disabled  class="form-control" name="labName" id="labName" type="text">--}}
{{--                                            </div>--}}

{{--                                            <div class="mb-3">--}}
{{--                                                <label class="col-form-label pt-0" for="contractorName">Contractor’s Name</label>--}}
{{--                                                <input disabled  class="form-control" name="contractorName" id="contractorName" type="text" >--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-sm-12">--}}
{{--                                            <div class="mb-3">--}}
{{--                                                <label class="col-form-label pt-0" for="remark2">Remark</label>--}}
{{--                                                <textarea disabled  class="form-control" style="white-space: pre-wrap" name="remark2" id="remark2" rows="5"></textarea>--}}
{{--                                            </div>--}}

{{--                                            <div class="mb-3">--}}
{{--                                                <label class="col-form-label pt-0" for="note1">Note 1</label>--}}
{{--                                                <textarea disabled  class="form-control" name="note1" id="note1"  ></textarea>--}}
{{--                                            </div>--}}
{{--                                            <div class="mb-3">--}}
{{--                                                <label class="col-form-label pt-0" for="note2">Note 2</label>--}}
{{--                                                <textarea  disabled class="form-control" name="note2" id="note2"  ></textarea>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="tab-pane fade" id="right-contact" role="tabpanel" aria-labelledby="contact-right-tab">--}}
{{--                                    <br>--}}
{{--                                    <div class="row">--}}
{{--                                        <div class="col-sm-3">--}}
{{--                                            <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                <input disabled  class="color-test form-check-input" id="scopeVI" name="scopeVI" type="checkbox">--}}
{{--                                                <label disabled  class="form-check-label" for="scopeVI">Visual Inspection</label>--}}
{{--                                            </div>--}}

{{--                                            <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                <input disabled  class="form-check-input" id="scopeQCR" name="scopeQCR" type="checkbox">--}}
{{--                                                <label disabled  class="form-check-label" for="scopeQCR">Quantity check at random</label>--}}
{{--                                            </div>--}}

{{--                                            <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                <input disabled  class="form-check-input" id="scopeQVB" name="scopeQVB" type="checkbox">--}}
{{--                                                <label disabled  class="form-check-label" for="scopeQVB">Quality on Visual Basis</label>--}}
{{--                                            </div>--}}

{{--                                            <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                <input disabled  class="form-check-input" id="scopeSample" name="scopeSample" type="checkbox">--}}
{{--                                                <label disabled  class="form-check-label" for="scopeSample">Sampling</label>--}}
{{--                                            </div>--}}

{{--                                            <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                <input disabled  class="form-check-input" id="scopeMD" name="scopeMD" type="checkbox">--}}
{{--                                                <label disabled  class="form-check-label" for="scopeMD">Moisture Determination</label>--}}
{{--                                            </div>--}}

{{--                                            <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                <input disabled  class="form-check-input" id="scopeSS" name="scopeSS" type="checkbox">--}}
{{--                                                <label disabled  class="form-check-label" for="scopeSS">Sealing Samples</label>--}}
{{--                                            </div>--}}

{{--                                            <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                <input disabled  class="form-check-input" id="scopeWT" name="scopeWT" type="checkbox">--}}
{{--                                                <label disabled  class="form-check-label" for="scopeWT">Witness of Testing</label>--}}
{{--                                            </div>--}}

{{--                                        </div>--}}
{{--                                        <div class="col-sm-3">--}}
{{--                                            <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                <input disabled  class="form-check-input" id="scopeSOL" name="scopeSOL" type="checkbox">--}}
{{--                                                <label disabled  class="form-check-label" for="scopeSOL">Supervision of Loading</label>--}}
{{--                                            </div>--}}

{{--                                            <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                <input disabled  class="form-check-input" id="scopeSOD" name="scopeSOD" type="checkbox">--}}
{{--                                                <label disabled  class="form-check-label" for="scopeSOD">Supervision of Discharging</label>--}}
{{--                                            </div>--}}

{{--                                            <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                <input disabled  class="form-check-input" id="scopePacking" name="scopePacking" type="checkbox">--}}
{{--                                                <label disabled  class="form-check-label" for="scopePacking">Packing</label>--}}
{{--                                            </div>--}}

{{--                                            <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                <input disabled  class="form-check-input" id="scopeMarking" name="scopeMarking" type="checkbox">--}}
{{--                                                <label disabled  class="form-check-label" for="scopeMarking">Marking</label>--}}
{{--                                            </div>--}}

{{--                                            <div class="form-check form-check-inline checkbox checkbox-primary">--}}
{{--                                                <input disabled  class="form-check-input" id="scopeCI" name="scopeCI" type="checkbox">--}}
{{--                                                <label disabled  class="form-check-label" for="scopeCI">Container Inspection</label>--}}
{{--                                            </div>--}}

{{--                                            <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                <input disabled  class="form-check-input" id="scopeSC" name="scopeSC" type="checkbox">--}}
{{--                                                <label disabled  class="form-check-label" for="scopeSC">Sealing Container</label>--}}
{{--                                            </div>--}}

{{--                                            <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                <input disabled  class="form-check-input" id="scopeDS" name="scopeDS" type="checkbox">--}}
{{--                                                <label disabled  class="form-check-label" for="scopeDS">Damage Survey</label>--}}
{{--                                            </div>--}}


{{--                                        </div>--}}

{{--                                        <div class="col-sm-3">--}}
{{--                                            <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                <input disabled  class="form-check-input" id="scopeHT" name="scopeHT" type="checkbox">--}}
{{--                                                <label class="form-check-label" for="scopeHT">Hold / Tank Inspection</label>--}}
{{--                                            </div>--}}

{{--                                            <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                <input disabled  class="form-check-input" id="scopeDSU" name="scopeDSU" type="checkbox">--}}
{{--                                                <label class="form-check-label" for="scopeDSU">Draft Survey</label>--}}
{{--                                            </div>--}}

{{--                                            <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                <input disabled  class="form-check-input" id="scopeUS" name="scopeUS" type="checkbox">--}}
{{--                                                <label class="form-check-label" for="scopeUS">Ullage Survey</label>--}}
{{--                                            </div>--}}

{{--                                            <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                <input  disabled class="form-check-input" id="scopeBS" name="scopeBS" type="checkbox">--}}
{{--                                                <label class="form-check-label" for="scopeBS">Bunker Survey</label>--}}
{{--                                            </div>--}}

{{--                                            <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                <input disabled  class="form-check-input" id="scopeTA" name="scopeTA" type="checkbox">--}}
{{--                                                <label class="form-check-label" for="scopeTA">Testing and Analysis</label>--}}
{{--                                            </div>--}}

{{--                                            <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                <input  disabled class="form-check-input" id="scopeOFF" name="scopeOFF" type="checkbox">--}}
{{--                                                <label class="form-check-label" for="scopeOFF">ON/OFF Hire Survey</label>--}}
{{--                                            </div>--}}

{{--                                            <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                <input  disabled class="form-check-input" id="scopeCS" name="scopeCS" type="checkbox">--}}
{{--                                                <label class="form-check-label" for="scopeCS">Crane Survey</label>--}}
{{--                                            </div>--}}


{{--                                        </div>--}}

{{--                                        <div class="col-sm-3">--}}
{{--                                            <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                <input disabled  class="form-check-input" id="scopeBSU" name="scopeBSU" type="checkbox">--}}
{{--                                                <label class="form-check-label" for="scopeBSU">Barge Survey</label>--}}
{{--                                            </div>--}}

{{--                                            <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                <input disabled  class="form-check-input" id="scopePhoto" name="scopePhoto" type="checkbox">--}}
{{--                                                <label class="form-check-label" for="scopePhoto">Photography</label>--}}
{{--                                            </div>--}}

{{--                                            <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                <input  disabled class="form-check-input" id="scopeLC" name="scopeLC" type="checkbox">--}}
{{--                                                <label class="form-check-label" for="scopeLC">Lashing / Choking</label>--}}
{{--                                            </div>--}}

{{--                                            <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                <input disabled  class="form-check-input" id="scopeRM" name="scopeRM" type="checkbox">--}}
{{--                                                <label class="form-check-label" for="scopeRM">Raw Material Inspection</label>--}}
{{--                                            </div>--}}

{{--                                            <div class="form-check form-check-inline checkbox checkbox-primary">--}}
{{--                                                <input  disabled class="form-check-input" id="scopeRSD" name="scopeRSD" type="checkbox">--}}
{{--                                                <label class="form-check-label" for="scopeRSD">Review of shipping Documents</label>--}}
{{--                                            </div>--}}

{{--                                            <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                <input disabled  class="form-check-input" id="scopeCIS" name="scopeCIS" type="checkbox">--}}
{{--                                                <label class="form-check-label" for="scopeCIS">Coating Inspection</label>--}}
{{--                                            </div>--}}


{{--                                            <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                <input disabled  class="form-check-input" id="video" name="video" type="checkbox">--}}
{{--                                                <label class="form-check-label" for="video">Video</label>--}}
{{--                                            </div>--}}

{{--                                            <div class="mb-3 form-check checkbox checkbox-primary">--}}
{{--                                                <input disabled  class="form-check-input" id="scopeRT" name="scopeRT" type="checkbox">--}}
{{--                                                <label class="form-check-label" for="scopeRT">Review of Testing Result / Quality Docs</label>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="mb-3">--}}
{{--                                            <label  disabled class="col-form-label pt-0" for="other" name="other">Other Scope</label>--}}
{{--                                            <input disabled  class="form-control" name="other" id="other" type="text">--}}
{{--                                        </div>--}}

{{--                                        <div class="mb-3">--}}
{{--                                            <label class="col-form-label pt-0" for="remark" name="remark">Remark on scope</label>--}}
{{--                                            <textarea  disabled class="form-control" name="remark" id="remark" ></textarea>--}}
{{--                                        </div>--}}

{{--                                    </div>--}}
{{--                                </div>--}}
                            </div>
                        <div class="card-footer">
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
