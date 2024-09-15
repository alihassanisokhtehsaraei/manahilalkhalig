@extends('layouts.viho')
@section('body')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-6">
                    <h3>{{ __('messages.createCustomersTitle') }}</h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">{{ __('common.home') }}</a></li>
                        <li class="breadcrumb-item">{{ __('messages.customers') }}</li>
                        <li class="breadcrumb-item active">{{ __('messages.create') }}</li>
                    </ol>
                </div>
                <div class="col-sm-6">
                    <!-- Bookmark Start-->
                    <div class="bookmark">
                        <ul>
                            <li><a href="/customer/list" data-container="body" data-bs-toggle="popover" data-placement="top" title="" data-original-title="Tables"><i data-feather="inbox"></i></a></li>
                        </ul>
                    </div>
                    <!-- Bookmark Ends-->
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h5>{{ __('messages.create').' - '.__('messages.newCustomerForm') }}</h5><span>{{ __('messages.newCustomerDesc') }}</span>
                    </div>
                    <div class="card-body">
                        <form class="form-wizard" id="regForm" action="/customer/store" method="POST">
                            @csrf
                            <div class="tab">
                                <div class="form-group">
                                    <label for="name">* First Name</label>
                                    <input class="form-control required" id="name" name="fName" type="text" placeholder="{{ __('common.fNameS') }}" value="{{ old('fName') }}">
                                </div>
                                <div class="form-group">
                                    <label for="lname">Last Name</label>
                                    <input class="form-control" id="lname" type="text" name="lName" placeholder="{{ __('common.lNameS') }}" value="{{ old('fName') }}">
                                </div>
                                <div class="form-group">
                                    <label for="lname">Company Name</label>
                                    <input class="form-control" id="cname" type="text" name="cName" placeholder="{{ __('common.cNameS') }}" value="{{ old('fName') }}">
                                </div>

                            </div>
                            <div class="tab">

                                <div class="form-group m-t-15">
                                    <label for="exampleFormControlInput1">* {{ __('common.emailAddress') }}</label>
                                    <input class="form-control required" name="email" id="exampleFormControlInput1" type="email" placeholder="name@example.com" value="{{ old('email') }}">
                                </div>

                                <div class="form-group">
                                    <label for="tel">{{ __('common.tel') }}</label>
                                    <input class="form-control" id="tel" type="text" placeholder="+982174551000" name="tel" value="{{ old('tel') }}">
                                </div>
                                <div class="form-group">
                                    <label for="mobile">{{ __('common.mobile') }}</label>
                                    <input class="form-control" id="mobile" type="text" name="mobile" placeholder="+989123456789" value="{{ old('mobile') }}">
                                </div>
                            </div>
                            <div class="tab">
                                <div class="form-group">
                                    <label for="country" class="control-label">{{ __('common.country') }}</label>
                                    <input class="form-control mt-1" type="text" id="country" name="country" placeholder="Country" value="{{ old('country') }}">
                                </div>
                                <div class="form-group">
                                    <label for="stateCity" class="control-label">{{ __('common.stateCity') }}</label>
                                    <input class="form-control mt-1" type="text" id="stateCity" placeholder="State" name="stateCity" value="{{ old('stateCity') }}">
                                </div>
                                <div class="form-group">
                                    <label for="address" class="control-label">{{ __('common.address') }}</label>
                                    <textarea class="form-control mt-1" name="address" id="address" value="{{ old('address') }}"></textarea>
                                </div>
                            </div>
                            <div>
                                <div class="text-end btn-mb">
                                    <button class="btn btn-secondary" id="prevBtn" type="button" onclick="nextPrev(-1)">Previous</button>
                                    <button class="btn btn-primary" id="nextBtn" type="button" onclick="nextPrev(1)">Next</button>
                                </div>
                            </div>
                            <!-- Circles which indicates the steps of the form:-->
                            <div class="text-center"><span class="step"></span><span class="step"></span><span class="step"></span></div>
                            <!-- Circles which indicates the steps of the form:-->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection
@section('moreJs')
    <!-- Plugins JS start-->
    <script src="{{ asset('theme/viho/assets/js/form-wizard/form-wizard.js')}}"></script>
    <!-- Plugins JS Ends-->
@endsection
