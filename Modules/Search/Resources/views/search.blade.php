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
                        <li class="breadcrumb-item active">Search</li>
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
                            <h5>Search</h5><span>The First step is to fill the inspection order form.</span>
                        </div>
                        <form class="theme-form" method="post" action="{{ route('search.result') }}" id="search">
                            @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label class="col-form-label pt-0" for="value" name="value">Search Value</label>
                                    <input class="form-control" name="value" id="value" type="text"></div>
                                <div class="col-sm-6">
                                    <label class="col-form-label pt-0" for="key" name="key">Search For</label>
                                    <select class="form-control" name="key" id="key">
                                        <option value="order">Order No.</option>
                                        <option value="coc">COC No.</option>
                                        <option value="ncr">NCR No.</option>
                                        <option value="rd">RD No.</option>
                                        <option value="nrd">NRD No.</option>
                                        <option value="pi">Pi No.</option>
                                    </select>
                                </div>
                            </div>

                                    <br>
                                    <input class="btn btn-primary" name="submit" id="submit" type="submit" value="Search">
                        </div>
                        <div class="card-footer">
                            @isset($data)
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">No.</th>
                                            <th scope="col">Customer</th>
                                            <th scope="col">Branch</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($data as $item)
                                            <tr>
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td>{{ $item->tracking_no }}</td>
                                                <td>{{ $item->customer->fullName.' - '.$item->customer->cName }}</td>
                                                <td>{{ $item->branch}}</td>
                                                <td>
                                                    @switch($item->technicalStatus)
                                                        @case(0)
                                                            <a class="btn btn-xs btn-primary">New</a>
                                                            @break
                                                        @case(1)
                                                            <a class="btn btn-xs btn-primary">COC Draft</a>
                                                            @break
                                                        @case(2)
                                                            <a class="btn btn-xs btn-warning">NCR Draft</a>
                                                            @break
                                                        @case(3)
                                                            <a class="btn btn-xs btn-danger">COC Rejected</a>
                                                            @break
                                                        @case(4)
                                                            <a class="btn btn-xs btn-danger">NCR Rejected</a>
                                                            @break
                                                        @case(5)
                                                            <a class="btn btn-xs btn-primary">COC Approved</a>
                                                            @break
                                                        @case(6)
                                                            <a class="btn btn-xs btn-warning">NCR Approved</a>
                                                            @break
                                                        @default
                                                            <span class="btn btn-xs btn-secondary">Unknown Status</span>
                                                    @endswitch

                                                </td>
                                                <td><a href="{{ route('inspection.show', $item->id) }}" class="btn btn-xs btn-primary">Select</a> </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endisset
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
