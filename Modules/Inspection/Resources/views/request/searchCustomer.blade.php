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
                        </div>
                        <form class="theme-form" method="post" action="{{ route('request.searchResult') }}" id="search">
                            @csrf
                        <div class="card-body">
                                    <label class="col-form-label pt-0" for="searchkey" name="searchkey">Search Customer</label>
                                    <input class="form-control" name="searchkey" id="searchkey" type="text">
                                    <br>
                                    <input class="btn btn-primary" name="submit" id="submit" type="submit" value="Search">
                                    <a class="btn btn-warning" href="{{ route('customer.create') }}" >New Customer</a>
                        </div>
                        <div class="card-footer">
                            @isset($customers)
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Name / Company Name</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Mobile / Tel</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($customers as $customer)
                                            <tr>
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td>{{ $customer->fullName.' - '.$customer->cName }}</td>
                                                <td>{{ $customer->email }}</td>
                                                <td>{{ $customer->mobile.' - '.$customer->tel }}</td>
                                                <td>
                                                    @if(Auth()->user()->department == 'Management' or Auth()->user()->department == 'Inspection')
                                                        <a href="{{ route('order.create', $customer->id) }}" class="btn btn-xs btn-primary">RFI</a>
                                                    @endif
                                                    @if(Auth()->user()->department == 'Management' or Auth()->user()->department == 'Laboratory')
                                                        <a href="{{ route('request.createrft', $customer->id) }}" class="btn btn-xs btn-danger">RFT</a>
                                                    @endif
                                                </td>
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
