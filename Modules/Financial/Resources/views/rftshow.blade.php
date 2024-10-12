@extends('layouts.viho')
@section('moreCSS')
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
@endsection
@section('body')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Financial Management</h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">{{ __('common.home') }}</a></li>
                        <li class="breadcrumb-item">Financial Management</li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </div>
                <div class="col-sm-6">
                    <!-- Bookmark Start-->
                    <div class="bookmark">
                        <ul>
                            <li><a href="{{ route('user.index') }}" data-container="body" data-bs-toggle="popover" data-placement="top" title="" data-original-title="Tables"><i data-feather="inbox"></i></a></li>
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

            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h5>RFT Financial Profile #{{ $rft->id }}</h5><span></span>
                    </div>
                    <form class="theme-form" method="post" action="{{ route('financial.rftstore', $rft->id) }}"  enctype="multipart/form-data">
                        @csrf
                    <div class="card-body">
                            <div class="row col-md-12">

                                <table>
                                    <thead>
                                    <tr>
                                        <th>Item No.</th>
                                        <th>Sample Desc</th>
                                        <th>Quantity</th>
                                        <th>Fee Price</th>
                                        <th>Total Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $subSum =0 ;
                                        $totalFeeWithoutTax = 0;
                                        $taxPercent = 10;
                                    @endphp
                                    @foreach($samples as $sample)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $sample->arabic_name.' - '.$sample->english_name }}<br>{{ $sample->desc }}</td>
                                            <td>{{ $sample->quantity }}</td>
                                            <td>{{ $sample->fee }}</td>
                                            <td>{{ $sample->fee * $sample->quantity }}</td>
                                        </tr>

                                        @php
                                            $subSum += ($sample->fee * $sample->quantity) ;
                                            $totalFeeWithoutTax += $subSum;
                                        @endphp
                                    @endforeach
                                    <tr>
                                        <td colspan="4" style="text-align: right;"><strong>Subtotal:</strong></td>
                                        <td><input name="subSum" readonly value="{{ $subSum }}" type="text"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="text-align: right;"><strong>Tax ({{ $taxPercent }}%):</strong></td>
                                        <td><input name="tax" readonly value="{{ ($totalFeeWithoutTax*$taxPercent)/100 }}" type="text"><td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="text-align: right;"><strong>Total:</strong></td>
                                        <td>
                                            @php
                                                $total = $totalFeeWithoutTax+(($totalFeeWithoutTax*10)/100);
                                            @endphp
                                        <input name="totalFee" readonly value="{{ $total }}" type="text"></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>


                        <br>

                        <div class="row col-md-12">
                                <div class="col-md-6">
                                    <label class="col-form-label pt-0" for="labFeePlace">Laboratory Fee Paid at:</label>
                                    <select class="form-control" name="labFeePlace" id="labFeePlace" {{ $disabled }}>
                                        @if($rft->labFeePlace)<option value="{{ $rft->labFeePlace }}">{{ $rft->labFeePlace }}</option>@endif
                                            <option value="Baghdad">Baghdad</option>
                                            <option value="Branch">Branch</option>
                                            <option value="Laboratory">Laboratory</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label pt-0" for="labPaymentMethod">Laboratory Fee Payment Method:</label>
                                    <select class="form-control" name="labPaymentMethod" id="labPaymentMethod" {{ $disabled }}>
                                        @if($rft->labPaymentMethod)<option value="{{ $rft->labPaymentMethod }}">{{ $rft->labPaymentMethod }}</option>@endif
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Cash">Cash</option>
                                        <option value="Customer Credit">Customer Credit</option>
                                    </select>
                                </div>
                            </div>

                        <div class="row col-md-12">
                            <label class="col-form-label pt-0" for="transactionNo">Transaction No.:</label>
                            <textarea name="transactionNo" class="form-control" {{ $disabled }}>{{ $rft->transactionNo }}</textarea>
                        </div>

                            <br>


                            <div class="row col-md-12">
                                <label class="col-form-label pt-0" for="borderFeePlace">Notes:</label>
                                <textarea name="note" class="form-control" {{ $disabled }}>@if($rft->finNote) {{ $rft->finNote }} @elseif(auth()->user()->department = 'financial' or auth()->user()->level = 'manager')Approved By {{ auth()->user()->name.' '.auth()->user()->lastname }}@endif</textarea>
                            </div>
                    </div>

                    <div class="card-footer">
                        @if($disabled == 'disabled')
                            <a href="{{ route('inspection.show', $rft->id) }}" class="btn btn-success">Go Back</a>
                            <a href="{{ route('financials.rftreceipt', $rft->id) }}" class="btn btn-warning" target="_blank">Print Receipt</a>
                        @else
                            <input type="submit" class="btn btn-primary" value="Submit">
                            <a href="{{ route('financial.rftreceipt', $rft->id) }}" class="btn btn-warning" target="_blank">Print Receipt</a>
                        @endif
                    </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection
@section('moreJs')
    <!-- Plugins JS start-->
    <script src="{{ asset('theme/viho/assets/js/form-wizard/form-wizard.js')}}"></script>
@endsection
