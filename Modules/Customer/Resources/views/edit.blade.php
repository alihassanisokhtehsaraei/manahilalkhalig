@extends('layouts.viho')
@section('moreCSS')
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/viho/assets/css/datatables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/viho/assets/css/sweetalert2.css')}}">
    <!-- Plugins css Ends-->
@endsection
@section('body')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-6">
                    <h3>{{ __('customers.profile') }}</h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">{{ __('common.home') }}</a></li>
                        <li class="breadcrumb-item">{{ trans_choice('customers.customer', 2) }}</li>
                        <li class="breadcrumb-item active">{{ __('customers.profile') }}</li>
                    </ol>
                </div>
                <div class="col-sm-6">
                    <!-- Bookmark Start-->
                    <div class="bookmark">
                        <ul>
                            <li><a href="/customer/edit/{{ $customer->id }}" data-container="body" data-bs-toggle="popover" data-placement="top" title="{{ __('customers.edit') }}" data-original-title="Edit"><i data-feather="edit"></i></a></li>
                            <li><a href="/jobs/createFromProfile/{{ $customer->id }}" data-container="body" data-bs-toggle="popover" data-placement="top" title="{{ __('customers.newjob') }}" data-original-title="call"><i data-feather="plus-square"></i></a></li>
                            <li><a href="javascript:void(0)" data-container="body" data-bs-toggle="popover" data-placement="top" title="{{ __('customers.call') }}" data-original-title="call"><i data-feather="phone-call"></i></a></li>
                            <li><a href="mailto:{{ $customer->email }}" data-container="body" data-bs-toggle="popover" data-placement="top" title="{{ __('customers.email') }}" data-original-title="Send Email"><i data-feather="mail"></i></a></li>
                            <li><a id="sweet-{{ $customer->id }}" data-container="body" data-bs-toggle="popover" data-placement="top" title="{{ __('customers.delete') }}" data-original-title="Delete"><i data-feather="delete"></i></a></li>
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
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="row mb-2">
                                <div class="profile-title">
                                    <img  style="float: right" class="img-50 rounded-circle" alt="" src="{{ asset('img/medal/golden.png') }}">
                                    <h4 style="float: left; direction: ltr;text-align: left" class="card-title mb-0">{{ $customer->fullName }}</h4>
                                    <h5 style="float: left; direction: ltr;text-align: left" class="card-title mb-0">{{ $customer->cName }}</h5>
                                </div>
                            </div>

                        </div>
                        <div class="card-body">

                                <div class="mb-3">
                                    <h6 class="form-label">Email-Address:</h6>
                                    {{ $customer->email }}
                                </div>
                                <div class="mb-3">
                                    <h6 class="form-label">Tel:</h6>
                                    {{ $customer->tel }}
                                </div>
                                <div class="mb-3">
                                    <h6 class="form-label">Address:</h6>
                                    {{ $customer->address }}
                                    <br>
                                    {{ $customer->stateCity."- ".$customer->country }}
                                </div>


                        </div>
                    </div>
                </div>
                <div class="col-xl-8">

                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Edit Profile</h5>
                             </div>
                            <div class="card-body">
                                <form class="form-wizard" id="regForm" action="/customer/update/{{ $customer->id }}" method="POST">
                                    @csrf
                                <div class="row form-builder-2">
                                    <div class="col-md-12">
                                        <div class="mb-3 ui-draggable-handle" style="position: static;">
                                            <label for="input-text-1">Name</label>
                                            <input class="form-control btn-square" name="fullname" id="input-text-1" type="text" placeholder="Full Name" data-bs-original-title="" title="" value="{{ $customer->fullName }}">

                                        </div>
                                        <div class="mb-3 ui-draggable-handle" style="position: static;">
                                            <label for="input-text-2">Company Name</label>
                                            <input class="form-control btn-square" name="cName" id="input-text-2" type="text" placeholder="Company" data-bs-original-title="" title="" value="{{ $customer->cName }}">

                                        </div>
                                        <div class="mb-3 ui-draggable-handle" style="position: static;">
                                            <label for="input-text-3">Email</label>
                                            <input class="form-control btn-square" name="email" id="input-text-3" type="email" placeholder="Enter email" data-bs-original-title="" title="" value="{{ $customer->email }}">

                                        </div>
                                        <div class="mb-3 ui-draggable-handle" style="">
                                            <label for="input-text-4">Tel</label>
                                            <input class="form-control btn-square" name="tel" id="input-text-4" type="text" placeholder="Enter email" data-bs-original-title="" title=""value="{{ $customer->tel }}">

                                        </div>
                                        <div class="mb-3 ui-draggable-handle" style="position: static;">
                                            <label for="input-text-5">Mobile</label>
                                            <input class="form-control btn-square" name="mobile" id="input-text-5" type="text" placeholder="Enter email" data-bs-original-title="" title="" value="{{ $customer->mobile }}">

                                        </div>
                                        <div class="mb-3 ui-draggable-handle" style="">
                                            <label for="input-text-6">Country</label>
                                            <input class="form-control btn-square" name="country" id="input-text-6" type="text" placeholder="Country" data-bs-original-title="" title="" value="{{ $customer->country }}">

                                        </div>
                                        <div class="mb-3 ui-draggable-handle" style="position: static;">
                                            <label for="input-text-7">State/City</label>
                                            <input class="form-control btn-square" name="stateCity" id="input-text-7" type="text" placeholder="City" data-bs-original-title="" title="" value="{{ $customer->stateCity }}">

                                        </div>
                                        <div class="mb-3 ui-draggable-handle" style="position: static;">
                                            <label for="input-text-8">Address</label>
                                            <textarea class="form-control btn-square" name="address" id="input-text-8" >{{ $customer->address }}</textarea>

                                        </div>
                                        <div class="mb-3 ui-draggable-handle" style="position: static;">
                                            <input class="btn btn-primary active" type="submit" data-original-title="btn btn-dark active" title="" data-bs-original-title="" value="Submit">
                                        </div>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
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
    <!-- Plugins JS start-->
    <script src="{{ asset('theme/viho/assets/js/form-wizard/form-wizard.js')}}"></script>
    <!-- Plugins JS Ends-->
    @if($request->session()->has('status'))
        <script src="{{ asset('theme/viho/assets/js/notify/newCustomer.js')}}"></script>
    @endif

    <!-- Plugins JS start-->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="{{ asset('theme/viho/assets/js/sweet-alert/sweetalert.min.js')}}"></script>
    <script>
        var SweetAlert_custom = {
            init: function() {

                document.querySelector("#sweet-{{ $customer->id }}").onclick = function(){
                    swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this customer, all other related information will be deleted too!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                        .then((willDelete) => {
                            if (willDelete) {
                                $.ajax({
                                    url: '../destroy/{{ $customer->id }}',
                                type: 'get',
                                dataType: 'json'
                            });
                                swal("Poof! Your file has been deleted!", {
                                    icon: "success",
                                });
                                window.location.replace("../index");
                            } else {
                                swal("Your file is safe!");
                            }
                        })
                }
                ;

            }
        };
        (function($) {
            SweetAlert_custom.init()
        })(jQuery);
    </script>
    <script src="{{ asset('theme/viho/assets/js/tooltip-init.js')}}"></script>
    <!-- Plugins JS Ends-->
    <script src="{{ asset('theme/viho/assets/js/datatable/datatables/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript">

        $(document).ready( function () {
            $('#customers-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "",
                columns: [
                    { data: 'fullName', name: 'fullName' },
                    { data: 'cName', name: 'cName' },
                    { data: 'tel', name: 'tel' },
                    { data: 'email', name: 'email' },

                ]
            });
        });
    </script>
@endsection
