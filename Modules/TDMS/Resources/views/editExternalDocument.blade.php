<?php
use \Illuminate\Foundation\Jdate;
$Jdate = new Jdate(); ?>

@extends('layouts.viho')
@section('moreCSS')
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{ asset('viho/assets/css/datatables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('viho/assets/css/sweetalert2.css')}}">
    <link type="text/css" rel="stylesheet" href="{{ asset('pdatepicker/css/persianDatepicker.css') }}" />
    <!-- Plugins css Ends-->
@endsection
@section('body')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-6">
                    <h3></h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">IPMS</a></li>
                        <li class="breadcrumb-item">TMDS</li>
                        <li class="breadcrumb-item active">Edit External Document</li>
                    </ol>
                </div>
                <div class="col-sm-6">
                    <!-- Bookmark Start-->
                    <div class="bookmark">
                        <ul>
                            <li><a href="javascript:void(0)" data-container="body" data-bs-toggle="popover" data-placement="top" title="BACK" data-original-title="call"><i data-feather="chevron-left"></i></a></li>
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
                            <h5>Edit External Document: {{ $data->docTitle }}</h5><span>Here you can modify all information related to this document.</span>
                        </div>
                        <form class="theme-form" method="post" action="{{ route('tdms.updateExternalDocument',$data->id) }}" id="baNew" enctype="multipart/form-data">
                            <div class="card-body">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="col-form-label pt-0" for="exampleInputEmail1">Document Number</label>
                                            <br>
                                            <input  disabled class="form-control" name="no"  tabindex="3" value="{{ $data->no }}">
                                        </div>

                                        <div class="mb-3">
                                            <label class="col-form-label pt-0" for="title">Title</label>
                                            <input class="form-control" name="title" id="title" type="text" placeholder="Document Title" tabindex="5" value="{{ $data->title }}">
                                        </div>




                                        <div class="mb-3">
                                            <label class="col-form-label pt-0" for="distro">Distribution Places</label>
                                            <table style="width: 100%;">
                                                <tr>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input class="checkbox_animated" id="pmg" name="pmg" value="1" type="checkbox" @if($data->place1 == 1) checked @endif>
                                                            <label for="pmg">Management</label>
                                                        </div>
                                                    </td>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input class="checkbox_animated" id="pmd" name="pmd" value="1" type="checkbox" @if($data->place2 == 1) checked @endif>
                                                            <label for="pmd">Market Development</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>

                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input class="checkbox_animated" id="pfi" name="pfi" value="1" type="checkbox" @if($data->place3 == 1) checked @endif>
                                                            <label for="pfi">Financial</label>
                                                        </div>
                                                    </td>

                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input class="checkbox_animated" id="phr" name="phr" value="1" type="checkbox" @if($data->place4 == 1) checked @endif>
                                                            <label for="phr">Human Resources</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input class="checkbox_animated" id="pst" name="pst" value="1" type="checkbox" @if($data->place5 == 1) checked @endif>
                                                            <label for="pst">Strategy</label>
                                                        </div>
                                                    </td>

                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input class="checkbox_animated" id="ppr"  name="ppr" value="1" type="checkbox" @if($data->place6 == 1) checked @endif>
                                                            <label for="ppr">Procurement</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input class="checkbox_animated" id="pqd" name="pqd" value="1" type="checkbox" @if($data->place7 == 1) checked @endif>
                                                            <label for="pqd">Quality Development</label>
                                                        </div>
                                                    </td>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input class="checkbox_animated" id="ict" name="ict" value="1" type="checkbox" @if($data->place8 == 1) checked @endif>
                                                            <label for="ict">ICT</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input class="checkbox_animated" id="pgc" name="pgc" value="1" type="checkbox" @if($data->place9 == 1) checked @endif>
                                                            <label for="pgc">General Cargo</label>
                                                        </div>
                                                    </td>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input class="checkbox_animated" id="pti" name="pti" value="1" type="checkbox" @if($data->place10 == 1) checked @endif>
                                                            <label for="pti">Technical Inspection</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input class="checkbox_animated" id="pes" name="pes" value="1" type="checkbox" @if($data->place11 == 1) checked @endif>
                                                            <label for="pes">Escalator</label>
                                                        </div>
                                                    </td>

                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input class="checkbox_animated" id="pup" name="pup" value="1" type="checkbox" @if($data->place12 == 1) checked @endif>
                                                            <label for="pup">Under Pressure</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input class="checkbox_animated" id="pnd" name="pnd" value="1" type="checkbox" @if($data->place13 == 1) checked @endif>
                                                            <label for="pnd">Non Destructive Test</label>
                                                        </div>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input class="checkbox_animated" id="psl" name="psl" value="1" type="checkbox" @if($data->place14 == 1) checked @endif>
                                                            <label for="psl">Structural Lab</label>
                                                        </div>
                                                    </td>

                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input class="checkbox_animated" id="pml" name="pml" value="1" type="checkbox" @if($data->place15 == 1) checked @endif>
                                                            <label for="pml">Mineral Lab</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input class="checkbox_animated" id="pws" name="pws" value="1" type="checkbox" @if($data->place16 == 1) checked @endif>
                                                            <label for="pws">Weight & Scales Lab</label>
                                                        </div>
                                                    </td>

                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input class="checkbox_animated" id="ptl" name="ptl" value="1" type="checkbox" @if($data->place17 == 1) checked @endif>
                                                            <label for="ptl">Textile Lab</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">Branches:</td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input class="checkbox_animated" id="thr" name="thr" value="1" type="checkbox" @if($data->branch1 == 1) checked @endif>
                                                            <label for="thr">Tehran</label>
                                                        </div>
                                                    </td>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input class="checkbox_animated" id="shz" name="shz" value="1" type="checkbox" @if($data->branch2 == 1) checked @endif>
                                                            <label for="shz">Shiraz</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input class="checkbox_animated" id="bnd" name="bnd" type="checkbox" @if($data->branch3 == 1) checked @endif>
                                                            <label for="bnd">Bandar Abbas</label>
                                                        </div>
                                                    </td>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input class="checkbox_animated" id="qsm" name="qsm" value="1" type="checkbox" @if($data->branch4 == 1) checked @endif>
                                                            <label for="qsm">Qeshm</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input class="checkbox_animated" id="zjn" name="zjn" type="checkbox" @if($data->branch5 == 1) checked @endif>
                                                            <label for="zjn">Zanjan</label>
                                                        </div>
                                                    </td>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input class="checkbox_animated" id="mhd" name="mhd" type="checkbox" @if($data->branch6 == 1) checked @endif>
                                                            <label for="mhd">Mashhad</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input class="checkbox_animated" id="tbz" name="tbz" type="checkbox" @if($data->branch7 == 1) checked @endif>
                                                            <label for="tbz">Tabriz</label>
                                                        </div>
                                                    </td>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input class="checkbox_animated" id="isf" name="isf" type="checkbox" @if($data->branch8 == 1) checked @endif>
                                                            <label for="isf">Isfahan</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input class="checkbox_animated" id="buh" name="buh" type="checkbox" @if($data->branch9 == 1) checked @endif>
                                                            <label for="buh">Bushehr</label>
                                                        </div>
                                                    </td>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input class="checkbox_animated" id="gnv" name="gnv" type="checkbox" @if($data->branch10 == 1) checked @endif>
                                                            <label for="gnv">Genaveh</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">

                                        <div class="mb-3">
                                            <div class="form-group m-t-15 mb-0">
                                                <label class="col-form-label pt-0" for="bankName">User Level</label><br>
                                                <div class="checkbox checkbox-solid-success" style="display: inline">
                                                    <input id="userLevel1" name="userLevel1" type="checkbox" tabindex="7" @if($data->userLevel1 == 1) checked @endif >
                                                    <label for="userLevel1">Experts</label>
                                                </div>
                                                <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                    <input id="userLevel2" name="userLevel2" type="checkbox"  tabindex="8" @if($data->userLevel2 == 1) checked @endif>
                                                    <label for="userLevel2">Managers</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="col-form-label pt-0" for="version">Document Version</label>
                                            <input class="form-control" name="version" id="version" type="text" disabled  placeholder="Document version like: 001" tabindex="4" value="{{ $data->version }}">
                                        </div>


                                        <div class="mb-3">
                                            <label class="col-form-label pt-0" for="releaseDate">Release Date</label>
                                            <input class="form-control" name="releaseDate" id="releaseDate" type="text" value="{{ $data->releaseDate }}">
                                            <span id="span1"></span>

                                        </div>
                                        
                                        
                                        <div class="mb-3">
                                            <label class="col-form-label pt-0" for="releaseDateGregorian">Gregorian Release Date</label>
                                            <input class="form-control" name="releaseDateGregorian" id="releaseDateGregorian" type="text" value="{{ $data->releaseDateGregorian }}">
                                            

                                        </div>


                                        <div class="mb-3">
                                            <div class="form-group m-t-15 mb-0">
                                                <label class="col-form-label pt-0" for="bankName">Quality Control Systems</label><br>
                                                <div class="checkbox checkbox-solid-success" style="display: inline">
                                                    <input id="s17020" name="s17020" value="1"  type="checkbox" tabindex="7" @if($data->s17020 == 1) checked @endif>
                                                    <label for="s17020">17020</label>
                                                </div>
                                                <div class="checkbox checkbox-solid-success" style="display: inline">
                                                    <input id="s17025" name="s17025" value="1"  type="checkbox" tabindex="7" @if($data->s17025 == 1) checked @endif>
                                                    <label for="s17025">17025</label>
                                                </div>
                                                <div class="checkbox checkbox-solid-success" style="display: inline">
                                                    <input id="s9001" name="s9001" value="1"  type="checkbox" tabindex="7" @if($data->s9001 == 1) checked @endif>
                                                    <label for="s9001">9001</label>
                                                </div>
                                                {{-- <div class="checkbox checkbox-solid-success" style="display: inline">
                                                    <input id="s14001" name="s14001" value="1" type="checkbox" tabindex="7"  @if($data->s14001 == 1) checked @endif>
                                                    <label for="s14001">14001</label>
                                                </div>
                                                <div class="checkbox checkbox-solid-success" style="display: inline">
                                                    <input id="s45001" name="s45001"  value="1"  type="checkbox" tabindex="7" @if($data->s45001 == 1) checked @endif>
                                                    <label for="s45001">45001</label>
                                                </div> --}}
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="col-form-label pt-0" for="pages">Number of Pages</label>
                                            <input class="form-control" name="pages" id="pages" type="number" value="{{ $data->pages }}">
                                        </div>

                                        <div class="mb-3">
                                            <label class="col-form-label pt-0" for="modDesc">Modification Desc</label>
                                            <textarea class="form-control" name="modDesc" id="modDesc" rows="10">{{ $data->modDesc }}</textarea>
                                        </div>

{{--                                        <div class="mb-3">--}}
{{--                                            <label class="col-form-label pt-0" for="prepare">Prepared By:</label>--}}
{{--                                            <select class="form-control" name="prepare" id="prepare">--}}
{{--                                                <option>Select From list</option>--}}
{{--                                                @foreach($users as $person)--}}
{{--                                                    <option value="{{ $person['id'] }}">{{ $person['name'].' '.$person['lastname'] }}</option>--}}
{{--                                                @endforeach--}}
{{--                                            </select>--}}
{{--                                        </div>--}}

{{--                                        <div class="mb-3">--}}
{{--                                            <label class="col-form-label pt-0" for="validation1">Validated By:</label>--}}
{{--                                            <select class="form-control" name="validation" id="validation">--}}
{{--                                                <option>Select From list</option>--}}
{{--                                                @foreach($managers as $person)--}}
{{--                                                    <option value="{{ $person['id'] }}">{{ $person['name'].' '.$person['lastname'] }}</option>--}}
{{--                                                @endforeach--}}
{{--                                            </select>--}}
{{--                                        </div>--}}


{{--                                        <div class="mb-3">--}}
{{--                                            <label class="col-form-label pt-0" for="approve">Approved By:</label>--}}
{{--                                            <select class="form-control" name="approve" id="approve">--}}
{{--                                                <option value="0">CEO</option>--}}
{{--                                                <option value="2">Mr Ganji</option>--}}
{{--                                            </select>--}}
{{--                                        </div>--}}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="col-form-label pt-0" for="status">Status:</label>
                                            <select class="form-control" name="status" id="status">
                                                <option value="3">Issue</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="col-form-label pt-0" for="pdf">PDF File <a class="btn btn-success btn-xs" href="{{ route('tdms.getPdf', $data->id) }}" target='_blank'>Download File</a>
                                            </label>
                                            <input class="form-control"  name="pdf" id="pdf" type="file" >

                                         </div>
                                        <div class="mb-3">

                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-primary">Submit</button>
                                <button class="btn btn-secondary">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection

<!-- Container-fluid Ends-->
@section('moreJs')

    <script type="text/javascript" src="{{ asset('pdatepicker/js/persianDatepicker.min.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            $("#releaseDate").persianDatepicker({
                months: ["فروردین", "اردیبهشت", "خرداد", "تیر", "مرداد", "شهریور", "مهر", "آبان", "آذر", "دی", "بهمن", "اسفند"],
                dowTitle: ["شنبه", "یکشنبه", "دوشنبه", "سه شنبه", "چهارشنبه", "پنج شنبه", "جمعه"],
                shortDowTitle: ["ش", "ی", "د", "س", "چ", "پ", "ج"],
                showGregorianDate: !1,
                persianNumbers: !0,
                formatDate: "YYYY/0M/0D",
                selectedBefore: !1,
                selectedDate: null,
                startDate: null,
                endDate: null,
                prevArrow: '\u25c4',
                nextArrow: '\u25ba',
                theme: 'default',
                alwaysShow: !1,
                selectableYears: null,
                selectableMonths: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                cellWidth: 25, // by px
                cellHeight: 20, // by px
                fontSize: 13, // by px
                isRTL: !1,
                calendarPosition: {
                    x: 0,
                    y: 0,
                },
                onShow: function () { },
                onHide: function () { },
                onSelect: function () { },
                onRender: function () { }
            });
        });
    </script>
@endsection
