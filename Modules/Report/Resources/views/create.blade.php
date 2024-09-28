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

                    <h3>Search</h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">{{ __('common.home') }}</a></li>
                        <li class="breadcrumb-item active">Reports</li>
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
                            <h5>Reports</h5><span>Select the report type and enter the start and end dates.</span>
                        </div>
                        <form class="theme-form" method="post" action="{{ route('report.result') }}" id="search">
                            @csrf
                        <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label class="col-form-label pt-0" for="start" name="start">Start Date</label>
                                        <input type="text" class="form-control" name="start" placeholder="LIKE 2024-01-01" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label pt-0" for="end" name="end">End Date</label>
                                        <input type="text" class="form-control" name="end" placeholder="LIKE 2024-02-01" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label class="col-form-label pt-0" for="reportType" name="reportType">Report Type</label>
                                        <select class="form-control" name="reportType" id="reportType">
                                            <option value="1">COC Fee Report</option>
                                            <option value="2">Border Fee Report</option>
                                            <option value="3">Release Documents Report</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="col-form-label pt-0" for="office" name="office">Office</label>
                                        <select class="form-control" name="office" id="office">
                                            <option value="all">all</option>
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
                                </div>
                        </div>
                        <div class="card-footer">
                            <div class="col-sm-12">
                                <label class="col-form-label pt-0" for="key" name="key">&nbsp</label>
                                <input class="btn btn-primary" name="submit" id="submit" type="submit" value="Search">
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
