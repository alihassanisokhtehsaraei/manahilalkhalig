@extends('layouts.viho')

@section('body')
    <!-- Container-fluid starts-->
    <div class="container-fluid dashboard-default-sec">
        <div class="row">
            <div class="col-xl-5 box-col-12 des-xl-100">
                <div class="row">
                    Welcome {{ Auth()->user()->name.' '.Auth()->user()->lastname }}!

                </div>
            </div>

        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection
@section('moreJs')
    <script src="{{ asset('theme/viho/assets/js/notify/index.js')}}"></script>
@endsection
