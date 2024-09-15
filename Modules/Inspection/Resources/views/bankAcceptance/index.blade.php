@extends('layouts.viho')
@section('moreCSS')
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/viho/assets/css/datatables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/viho/assets/css/sweetalert2.css')}}">
    <!-- Plugins css Ends-->
@endsection
@section('body')
    <!-- Footer callback Starts-->
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Bank Acceptance for Order No.: {{ $order->globalcounter->trackingID }}</h5>
            </div>
            <form class="theme-form" method="post" action="{{ route('bankAcceptance.update', $order->id) }}" id="bankAcceptance">
                @csrf
            <div class="card-body table-responsive">
               <div class="row">
                   <div class="col-sm-6">
                       <div class="mb-3">
                           <label class="col-form-label pt-0" for="quantity">Customer</label>
                           <input class="form-control" name="customer" id="customer" type="text"  value="{{ $order->customer->cName }}" disabled>
                       </div>
                       <div class="mb-3">
                           <label class="col-form-label pt-0" for="insType">Inspection Type</label>
                           <select class="form-control" name="insType" id="insType">
                               @if(isset($data->insType))
                                   <option value="{{ $data->insType }}">
                                       @switch($data->insType)
                                           @case('ASI')
                                                After Shippment Inspection
                                                @break
                                           @case('PSI')
                                                Pre Shippment Inspection (PSI)
                                       @endswitch
                                   </option>
                               @endif
                               <option value="ASI">After Shippment Inspection</option>
                               <option value="PSI">Pre Shippment Inspection (PSI)</option>
                           </select>
                       </div>

                       <div class="mb-3">
                           <label class="col-form-label pt-0" for="goods">Description of Goods</label>
                           <textarea class="form-control" name="goods" id="goods" rows="4" >@if(isset($data->goodsDesc)) {{ $data->goodsDesc }} @else {{ $order->goods }} @endif</textarea>
                       </div>

                       <div class="mb-3">
                           <label class="col-form-label pt-0" for="piNo">PI No.</label>
                           <input class="form-control" name="piNo" id="piNo" type="text" value="{{  $order->piNo }}" disabled>
                       </div>
                       <div class="mb-3">
                           <label class="col-form-label pt-0" for="piDate">PI Date</label>
                           <input data-language="en" class="datepicker-here form-control digits" name="piDate" id="piDate" type="text" @if(isset($data->piDate)) value="{{ $data->piDate }}"  @endif>
                       </div>
                       <div class="mb-3">
                           <label class="col-form-label pt-0" for="letterNo">Letter No.</label>
                           <input class="form-control" name="letterNo" id="letterNo" type="text" @if(isset($data->letterNo)) value="{{ $data->letterNo }}"  @endif disabled>
                       </div>
                       <div class="mb-3">
                           <label class="col-form-label pt-0" for="letterDate">Letter Date</label>
                           <input class="form-control" name="letterDate" id="letterDate" type="text" @if(isset($data->letterDate)) value="{{ $data->letterDate }}"  @endif disabled>
                       </div>
                   </div>
                   <div class="col-sm-6">
                       <div class="mb-3">
                           <label class="col-form-label pt-0" for="customsTarrif">Customs Tarrif</label>
                           <input class="form-control" name="customsTarrif" id="customsTarrif" type="text" @if(isset($data->customsTarrif)) value="{{ $data->customsTarrif }}"  @endif>
                       </div>
                       <div class="mb-3">
                           <label class="col-form-label pt-0" for="customsName">Customs Name</label>
                           <input class="form-control" name="customsName" id="customsName" type="text" @if(isset($data->customsName)) value="{{ $data->customsName }}"  @endif>
                       </div>
                       <div class="mb-3">
                           <label class="col-form-label pt-0" for="bankName">Bank Name</label>
                           <input class="form-control" name="bankName" id="bankName" type="text" @if(isset($data->bankName)) value="{{ $data->bankName }}"  @endif>
                       </div>
                       <div class="mb-3">
                           <label class="col-form-label pt-0" for="branch">Branch Name</label>
                           <input class="form-control" name="branch" id="branch" type="text" @if(isset($data->branch)) value="{{ $data->branch }}"  @endif>
                       </div>
                       <div class="mb-3">
                           <label class="col-form-label pt-0" for="orderingNo">Ordering No.</label>
                           <input class="form-control" name="orderingNo" id="orderingNo" type="text" @if(isset($data->orderingNo)) value="{{ $data->orderingNo }}"  @endif>
                       </div>
                       <div class="mb-3">
                           <label class="col-form-label pt-0" for="orderingDate">Ordering Date</label>
                           <input data-language="en" class="datepicker-here form-control digits" name="orderingDate" id="orderingDate" type="text" @if(isset($data->orderingDate)) value="{{ $data->orderingDate }}"  @endif>
                       </div>
                       <div class="mb-3">
                           <input class="btn btn-success" name="submit" id="submit" type="submit">
                           @if(isset($data->order_id)) <a href="{{ route('reports.bankAcceptanceFormat1', $data->id) }}" class="btn btn-warning">Print Format 1</a> @endif
                           @if(isset($data->order_id)) <a href="{{ route('reports.bankAcceptanceFormat2', $data->id) }}" class="btn btn-info">Print Format 2</a> @endif
                       </div>
                   </div>
               </div>
            </div>
            </form>
        </div>
    </div>
    <!-- Footer callback Ends-->

@endsection
@section('moreJs')
    <!-- Plugins JS start-->

    <script src="{{ asset('theme/viho/assets/js/datatable/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('theme/viho/assets/js/sweet-alert/sweetalert.min.js')}}"></script>

    <script src="{{ asset('theme/viho/assets/js/tooltip-init.js')}}"></script>
    <script src="{{ asset('theme/viho/assets/js/script.js')}}"></script>
    <!-- Plugins JS Ends-->

@endsection
