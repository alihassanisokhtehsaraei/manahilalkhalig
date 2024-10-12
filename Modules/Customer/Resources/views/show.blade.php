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
                            <li><a href="{{ route('order.create',$customer->id) }}" data-container="body" data-bs-toggle="popover" data-placement="top" title="{{ __('customers.newjob') }}" data-original-title="call"><i data-feather="plus-square"></i></a></li>
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
                                </div>
                                    <h5 style="float: left; direction: ltr;text-align: left" class="card-title mb-0">{{ $customer->cName }}</h5>
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

                                <div class="mb-3">
                                    <h6 class="sub-title text-uppercase">Other Data</h6>
                                    <div class="success-color">
                                        <ul class="m-b-30">
                                            <li style="text-align: center;color: white">TAX INFORMATION</li>
                                            <li style="text-align: center;color: white;background: #eb2067;">OTHER RELATED COMPANIES</li>
                                        </ul>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8">

                    <div class="row">
                        <div class="col-xl-4 col-sm-6 box-col-4 chart_data_right">
                            <div class="card income-card card-secondary">
                                <div class="card-body align-items-center">
                                    <div class="round-progress knob-block text-center">
                                        <div class="progress-circle">

                                        </div>
                                        <h5> {{ $totalOrders }} </h5>
                                        <p>RFI</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-sm-6 box-col-4 chart_data_right second">
                            <div class="card income-card card-primary">
                                <div class="card-body">
                                    <div class="round-progress knob-block text-center">
                                        <div class="progress-circle">

                                        </div>
                                        <h5>{{ $totalCoc }}</h5>
                                        <p>COC Files</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-sm-6 box-col-4 chart_data_right">
                            <div class="card income-card card-secondary">
                                <div class="card-body align-items-center">
                                    <div class="round-progress knob-block text-center">
                                        <div class="progress-circle">

                                        </div>
                                        <h5>{{ $totalNcr }}</h5>
                                        <p>NCR Files</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(auth()->user()->department == 'management' or auth()->user()->department == 'inspection' or auth()->user()->department == 'financial')
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Recent Jobs</h5><span>From<code>{{ $customer->fullName.' - '.$customer->cName }}</code> for any service.</span>
                             </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">RFI No.</th>
                                        <th scope="col">Desc</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Office</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($orders as $order)
                                    <tr>
                                        <th scope="row"> <a href="{{ route('inspection.show', $order->id) }}">{{ $order->tracking_no }}</a></th>
                                        <td><a href="{{ route('inspection.show', $order->id) }}">Pi No.: {{ $order->piNo }} - {{ $order->desc }}</a></td>
                                        <td><a href="{{ route('inspection.show', $order->id) }}">{{ $order->created_at->format('Y-m-d') }}</a></td>
                                        <td><a href="{{ route('inspection.show', $order->id) }}">{{ $order->branch }}</a></td>
                                        <td>@switch($order->technicalStatus)
                                                @case(0)
                                                    <a class="btn btn-xs btn-success">New</a>
                                                    @break
                                                @case(1)
                                                    <a class="btn btn-xs btn-success">COC Draft</a>
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
                                                    <a class="btn btn-xs btn-success">COC Approved</a>
                                                    @break
                                                @case(6)
                                                    <a class="btn btn-xs btn-danger">NCR Approved</a>
                                                    @break
                                            @endswitch</td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif
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
                                swal("Customer deleted!", {
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
