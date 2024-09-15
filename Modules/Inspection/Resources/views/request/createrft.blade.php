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

                    <h3>New Request for Testing</h3>
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
                        <form class="theme-form" method="post" action="{{ route('rft.store', Request::segment(3)) }}" id="requestNew">
                            @csrf
                        <div class="card-body">
                            <ul class="nav nav-tabs nav-right" id="right-tab" role="tablist">
                                <li class="nav-item"><a class="nav-link active" id="right-home-tab" data-bs-toggle="tab" href="tab-bootstrap.html#right-home" role="tab" aria-controls="right-home" aria-selected="true"><i class="icofont icofont-ui-home"></i>General</a></li>
                                <li class="nav-item"><a class="nav-link" id="profile-right-tab" data-bs-toggle="tab" href="tab-bootstrap.html#right-profile" role="tab" aria-controls="profile-icon" aria-selected="false"><i class="icofont icofont-man-in-glasses"></i>Applicant / Payer</a></li>
                            </ul>
                            <div class="tab-content" id="right-tabContent">
                                <div class="tab-pane fade show active" id="right-home" role="tabpanel" aria-labelledby="right-home-tab">
                                    <br>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="requestType">Request Type:</label>
                                                <select class="form-control" name="requestType">
                                                    <option value="RFT">RFT</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="applicationType">Type of Application</label>
                                                <select class="form-control" name="applicationType" id="applicationType">
                                                    <option value="Just Testing">Just Testing</option>
                                                </select>
                                            </div>
{{--                                            <div class="mb-3">--}}
{{--                                                <label class="col-form-label pt-0" for="rfc">Related RFC/RFI (if applicable)</label>--}}
{{--                                                <input class="form-control" name="rfc" id="rfc" type="number">--}}
{{--                                            </div>--}}
                                        </div>
                                        <div class="col-sm-6">

                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="office">Office</label>
                                                <select class="form-control" name="office" id="office">
                                                    @if(Auth()->user()->department == 'management')
                                                        <optgroup label="Air Ports" style="font-weight:bold;">Air Ports
                                                            <option value="Baghdad International Airport">Baghdad International Airport</option>
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
                                                    @else()
                                                        <option value="{{ auth()->user()->branch }}">{{ auth()->user()->branch }}</option>
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="lab">Lab</label>
                                                <select class="form-control" name="lab" id="lab">
                                                        <optgroup label="Sea Ports" style="font-weight:bold;">Sea Ports
                                                            <option value="North Umm Al-Qasr Port">North Umm Al-Qasr Port</option>
                                                            <option value="Middle Umm Al-Qasr Port">Middle Umm Al-Qasr Port</option>
                                                            <option value="South Umm Al-Qasr Port">South Umm Al-Qasr Port</option>
                                                        </optgroup>
                                                        <optgroup label="LAND" style="font-weight:bold;">
                                                            <option value="Shalamcheh">Shalamcheh</option>
                                                            <option value="Safwan">Safwan</option>
                                                        </optgroup>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane fade" id="right-profile" role="tabpanel" aria-labelledby="profile-right-tab">
                                    <br>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="applicantName">Applicant Name:</label>
                                                <input type="text"  class="form-control" name="applicantName" id="applicantName" value="{{ $customer->cName }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="applicantAddress">Applicant Address:</label>
                                                <textarea class="form-control" name="applicantAddress" id="applicantAddress" rows="5">{{ $customer->address }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="applicantContact">Applicant Contact Person:</label>
                                                <input type="text"  class="form-control" name="applicantContact" id="applicantContact"  value="{{ $customer->fullName }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="exporterEmail">Applicant Email:</label>
                                                <input type="text"  class="form-control" name="applicantEmail" id="applicantEmail"  value="{{ $customer->email }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="applicantTel">Applicant Phone No.:</label>
                                                <input type="text"  class="form-control" name="applicantTel" id="applicantTel"  value="{{ $customer->tel }}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="payerName">Payer Name:</label>
                                                <input type="text"  class="form-control" name="payerName" id="payerName"  value="{{ $customer->cName }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="payerAddress">Payer Address:</label>
                                                <textarea class="form-control" name="payerAddress" id="payerAddress" rows="5" >{{ $customer->address }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="payerContact">Importer Contact Person:</label>
                                                <input type="text"  class="form-control" name=payerContact" id="payerContact"  value="{{ $customer->fullName }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="payerEmail">Importer Email:</label>
                                                <input type="text"  class="form-control" name="payerEmail" id="payerEmail"  value="{{ $customer->email }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="col-form-label pt-0" for="payerTel">Payer Phone No.:</label>
                                                <input type="text"  class="form-control" name="payerTel" id="payerTel"  value="{{ $customer->tel }}">
                                            </div>
                                            <div class="mb-3">
                                                <button class="btn btn-primary">Submit</button>
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
