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

                    <h3>New Request</h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">{{ __('common.home') }}</a></li>
                        <li class="breadcrumb-item active">New Request</li>
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
                            <h5>Applicant: {{ $customer->fullName.' - '.$customer->cName }}</h5><span>The First step is to fill the request form.</span>
                        </div>
                        <form class="theme-form" method="post" action="{{ route('request.store', Request::segment(3)) }}" id="requestNew">
                            @csrf
                        <div class="card-body">
                            <ul class="nav nav-tabs nav-right" id="right-tab" role="tablist">
                                <li class="nav-item"><a class="nav-link active" id="right-home-tab" data-bs-toggle="tab" href="tab-bootstrap.html#right-home" role="tab" aria-controls="right-home" aria-selected="true"><i class="icofont icofont-ui-home"></i>General</a></li>
                                <li class="nav-item"><a class="nav-link" id="profile-right-tab" data-bs-toggle="tab" href="tab-bootstrap.html#right-profile" role="tab" aria-controls="profile-icon" aria-selected="false"><i class="icofont icofont-man-in-glasses"></i>Importer / Exporter</a></li>
                                <li class="nav-item"><a class="nav-link" id="labs-right-tab" data-bs-toggle="tab" href="tab-bootstrap.html#right-labs" role="tab" aria-controls="contact-icon" aria-selected="false"><i class="icofont icofont-contacts"></i>Payer & Inspection Day</a></li>
                            </ul>
                            <div class="tab-content" id="right-tabContent">
                                <div class="tab-pane fade show active" id="right-home" role="tabpanel" aria-labelledby="right-home-tab">
                                    <br>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="exporter">Request Type:</label>
                                                <select class="form-control" name="requestType">
                                                    <option value="RFI">RFI</option>
                                                    <option value="RFC">RFC</option>
                                                    <option value="RFT">RFT</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="applicationType">Type of Application</label>
                                                <select class="form-control" name="applicationType" id="applicationType">
                                                    <option value="Single Shipment">Single Shipment</option>
                                                    <option value="Multiple Shipment">Multiple Shipment</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="applicantType">Applicant Type</label>
                                                <select class="form-control" name="applicantType" id="applicantType">
                                                    <option value="Importer">Importer</option>
                                                    <option value="Exporter">Exporter</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="transportMode">Mode of Transport</label>
                                                <select class="form-control" name="transportMode" id="transportMode">
                                                    <option value="Road">Road</option>
                                                    <option value="Sea">Sea</option>
                                                    <option value="Air">Air</option>
                                                    <option value="Rail">Rail</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="shipmentMode">Mode of Shipment</label>
                                                <select class="form-control" name="shipmentMode" id="shipmentMode">
                                                    <option value="FCL">FCL</option>
                                                    <option value="LCL">LCL</option>
                                                    <option value="Truck">Truck</option>
                                                    <option value="Bulk">Bulk</option>
                                                    <option value="Package">Package</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="dischargePort">Port of Discharge</label>
                                                <select class="form-control" name="dischargePort" id="dischargePort">
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
                                                <label class="col-form-label pt-0" for="loadingPort">Port of Loading</label>
                                                <input class="form-control" name="loadingPort" id="loadingPort" type="text" >
                                            </div>

                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="descGoods">Desciption of Goods:</label>
                                                <textarea class="form-control" name="descGoods" id="descGoods" rows="5" ></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="piNo">Proforma Invoice No. & Date</label>
                                                <div class="row row-cols-sm-2 theme-form mt-2 form-bottom">
                                                    <div class="mb-2 d-flex">
                                                        <input class="form-control" type="text" name="piNo" >
                                                    </div>
                                                    <div class="mb-2 d-flex">
                                                        <input class="datepicker-here form-control digits" type="text" data-language="en" data-bs-original-title="" title="" name="piDate" id="piDate">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3 ui-draggable-handle" style="position: static;">
                                                <label for="importerReg">Importer and Product Registration with the government?</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <input class="me-0" type="checkbox" name="importerReg" data-bs-original-title="" title="">
                                                    </span>
                                                    <input class="form-control btn-square" id="importerRegDesc" name="importerRegDesc" type="text" placeholder="if Yes, Please Specify" data-bs-original-title="" title="">
                                                </div>
                                            </div>
                                            <div class="mb-3 ui-draggable-handle" style="position: static;">
                                                <label for="expoterReg">Exporter/Importer registration with the government?</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <input class="me-0" type="checkbox" name="exporterReg" data-bs-original-title="" title="">
                                                    </span>
                                                    <input class="form-control btn-square" id="exporterRegDesc" name="exporterRegDesc" type="text" placeholder="if Yes, Please Specify" data-bs-original-title="" title="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane fade" id="right-profile" role="tabpanel" aria-labelledby="profile-right-tab">
                                    <br>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="exporterName">Exporter Name:</label>
                                                <input type="text"  class="form-control" name="exporterName" id="exporterName" >
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="exporterAddress">Exporter Address:</label>
                                                <textarea class="form-control" name="exporterAddress" id="exporterAddress" rows="5" ></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="exporterContact">Exporter Contact Person:</label>
                                                <input type="text"  class="form-control" name="exporterContact" id="exporterContact" >
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="exporterEmail">Exporter Email:</label>
                                                <input type="text"  class="form-control" name="exporterEmail" id="exporterEmail" >
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="exporterTel">Exporter Phone No.:</label>
                                                <input type="text"  class="form-control" name="exporterTel" id="exporterTel" >
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="importerName">Importer Name:</label>
                                                <input type="text"  class="form-control" name="importerName" id="importerName" >
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="importerAddress">Importer Address:</label>
                                                <textarea class="form-control" name="importerAddress" id="importerAddress" rows="5" ></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="importerContact">Importer Contact Person:</label>
                                                <input type="text"  class="form-control" name="importerContact" id="importerContact" >
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="importerEmail">Importer Email:</label>
                                                <input type="text"  class="form-control" name="importerEmail" id="importerEmail" >
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="importerTel">Importer Phone No.:</label>
                                                <input type="text"  class="form-control" name="importerTel" id="importerTel" >
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="right-labs" role="tabpanel" aria-labelledby="labs-right-tab">
                                    <br>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="inspectionPlace">Inspection Place</label>
                                                <textarea class="form-control" name="inspectionPlace" id="inspectionPlace"></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="inspectionDate">Estimated Inspection Date</label>
                                                <input class="form-control" name="inspectionDate" id="inspectionDate" type="text">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="containerType">Container Type</label>
                                                <select class="form-control" name="containerType" id="containerType">
                                                    <option>Select</option>
                                                    <option value="Dry storage 40 feet">Dry storage 40 feet</option>
                                                    <option value="Dry storage 20 feet<">Dry storage 20 feet</option>
                                                    <option value="Dry storage 45 feet">Dry storage 45 feet</option>
                                                    <option value="Open top container">Open top container</option>
                                                    <option value="Open side storage container">Open side storage container</option>
                                                    <option value="Refrigerated ISO containers">Refrigerated ISO containers</option>
                                                    <option value="ISO Tanks<">ISO Tanks</option>
                                                    <option value="Half height containers">Half height containers</option>
                                                    <option value="Special purpose containers">Special purpose containers</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="containerCount">Number of Containers</label>
                                                <input class="form-control" name="containerCount" id="containerCount" type="text">
                                            </div>
                                            <div class="mb-3">
                                                <button class="btn btn-primary">Submit</button>
                                                <button class="btn btn-secondary">Cancel</button>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="payerName">Payer (if different from applicant)</label>
                                                <input class="form-control" name="payerName" id="payerName" type="text">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="payerAddress">Payer Address</label>
                                                <textarea class="form-control" name="payerAddress" id="payerAddress"></textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="payerTel">Contact Number</label>
                                                <input class="form-control" name="payerTel" id="payerTel" type="text">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="payerEmail">Payer Email</label>
                                                <input class="form-control" name="payerEmail" id="payerEmail" type="email">
                                            </div>

                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="ContractorName">Contractor’s Name</label>
                                                <input  class="form-control" name="ContractorName" id="ContractorName" type="text" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
