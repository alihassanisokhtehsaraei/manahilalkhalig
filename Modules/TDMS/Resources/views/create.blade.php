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
                        <li class="breadcrumb-item active">New Document</li>
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
                            <h5>NEW DOCUMENT</h5><span>Here you can prepare a new document based on our under controlled document systems.</span>
                        </div>
                        <form class="theme-form" method="post" action="{{ route('tdms.store') }}" id="baNew" enctype="multipart/form-data">
                            <div class="card-body">

                                @csrf
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="col-form-label pt-0" for="exampleInputEmail1">Document Number</label>
                                            <br>
                                            <select class="form-control" name="docType" style="display:inline;width:50px;" tabindex="2">
                                                @if (count($errors) > 0)
                                                    <option value="{{ old('docType') }}">{{ old('docType') }}</option>
                                                @endif
                                                <option value="CH">CH</option>
                                                <option value="MP">MP</option>
                                                <option value="MN">MN</option>
                                                <option value="PR">PR</option>
                                                <option value="WI">WI</option>
                                                <option value="FR">FR</option>
                                                <option value="JD">JD</option>
                                            </select> -
                                            <select class="form-control" name="mgmtCode" id="mgmtCode" style="display:inline;width:50px;" tabindex="2">
                                                @if (count($errors) > 0)
                                                    <option value="{{ old('mgmtCode') }}">{{ old('mgmtCode') }}</option>
                                                @endif
                                                <option value="MG">MG &nbsp;&nbsp;- MANAGEMENT</option>
                                                <option value="QA">QA &nbsp;&nbsp;- QUALITY ASSURANCE</option>
                                                <option value="IN">IN &nbsp;&nbsp;- INSPECTION</option>
                                                <option value="FM">FM &nbsp;&nbsp;- FINANCIAL</option>
                                                <option value="AH">AH &nbsp;&nbsp;- ADMINISTRATION & HUMAN RESOURCES</option>
                                                <option value="IT">IT &nbsp;&nbsp;- INFORMATION TECHNOLOGY</option>
                                                <option value="LB">LB &nbsp;&nbsp;- LABORATORY</option>
                                            </select> -
                                            <script type="text/javascript">
                                                var mg = ['QM', 'RM', 'SM', 'MR'];
                                                var qa = ['CI', 'DM', 'SR'];
                                                var ins = ['ES', 'UP', 'ND', 'TC', 'MI', 'FA', 'OC', 'CG', 'GE'];
                                                var fm = ['FI'];
                                                var ah = ['AD', 'HR'];
                                                var it = ['HW', 'SW'];
                                                var lb = ['ST', 'MI', 'WS', 'TX', 'GE'];

                                                document.getElementById("mgmtCode").addEventListener("change", function(e){
                                                    var select2 = document.getElementById("activity");
                                                    select2.innerHTML = "";
                                                    var aItems = [];
                                                    if(this.value == "MG"){
                                                        aItems = mg;
                                                    } else if (this.value == "QA") {
                                                        aItems = qa;
                                                    } else if(this.value == "IN") {
                                                        aItems = ins;
                                                    } else if (this.value == "FM") {
                                                        aItems = fm;
                                                    } else if(this.value == "AH") {
                                                        aItems = ah;
                                                    } else if(this.value == "IT") {
                                                        aItems = it;
                                                    } else if(this.value == "LB") {
                                                        aItems = lb;
                                                    }

                                                    for(var i=0,len=aItems.length; i<len;i++) {
                                                        var option = document.createElement("option");
                                                        var textNode = document.createTextNode(aItems[i]);
                                                        option.appendChild(textNode);
                                                        option.value= aItems[i];
                                                        select2.appendChild(option);
                                                    }

                                                }, false);
                                            </script>
                                            <select class="form-control" id="activity" name="actCode" style="display:inline;width:53px;" tabindex="1">
                                                @if (count($errors) > 0)
                                                    <option value="{{ old('actCode') }}">{{ old('actCode') }}</option>
                                                @endif
                                                <option value="QM">QM</option>
                                                <option value="RM">RM</option>
                                                <option value="SM">SM</option>
                                                <option value="MR">MR</option>
                                            </select> -
                                            <input  class="form-control" name="no" style="display:inline;width:100px;" tabindex="3" value="{{ old('no') }}">
                                        </div>

                                        <div class="mb-3">
                                            <label class="col-form-label pt-0" for="title">Title</label>
                                            <input class="form-control" name="title" id="title" type="text" placeholder="Document Title" tabindex="5" value="{{ old('title') }}">
                                        </div>

                                        <div class="mb-3">
                                            <label class="col-form-label pt-0" for="distro">Distribution Places</label>
                                            <table style="width: 100%;">
                                                <tr>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox  checkbox-solid-primary" style="display: inline">
                                                            <input class="checkbox_animated" id="pmg" name="pmg" value="1" type="checkbox" @if(old('pmg') == 1) checked @endif>
                                                            <label for="pmg">Management</label>
                                                        </div>
                                                    </td>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input class="checkbox_animated" id="pmd" name="pmd" value="1" type="checkbox" @if(old('pmd') == 1) checked @endif>
                                                            <label for="pmd">Market Development</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>

                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input class="checkbox_animated" id="pfi" name="pfi" value="1" type="checkbox" @if(old('pfi') == 1) checked @endif>
                                                            <label for="pfi">Financial</label>
                                                        </div>
                                                    </td>

                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input class="checkbox_animated" id="phr" name="phr" value="1" type="checkbox" @if(old('phr') == 1) checked @endif>
                                                            <label for="phr">Human Resources</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input class="checkbox_animated" id="pst" name="pst" value="1" type="checkbox" @if(old('pst') == 1) checked @endif>
                                                            <label for="pst">Strategy</label>
                                                        </div>
                                                    </td>

                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input class="checkbox_animated" id="ppr"  name="ppr" value="1" type="checkbox" @if(old('ppr') == 1) checked @endif>
                                                            <label for="ppr">Procurement</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input class="checkbox_animated" id="pqd" name="pqd" value="1" type="checkbox" @if(old('pqd') == 1) checked @endif>
                                                            <label for="pqd">Quality Development</label>
                                                        </div>
                                                    </td>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input class="checkbox_animated" id="ict" name="ict" value="1" type="checkbox" @if(old('ict') == 1) checked @endif>
                                                            <label for="ict">ICT</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input class="checkbox_animated" id="pgc" name="pgc" value="1" type="checkbox" @if(old('pgc') == 1) checked @endif>
                                                            <label for="pgc">General Cargo</label>
                                                        </div>
                                                    </td>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input class="checkbox_animated" id="pti" name="pti" value="1" type="checkbox" @if(old('pti') == 1) checked @endif>
                                                            <label for="pti">Technical Inspection</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input class="checkbox_animated" id="pes" name="pes" value="1" type="checkbox" @if(old('pes') == 1) checked @endif>
                                                            <label for="pes">Escalator</label>
                                                        </div>
                                                    </td>

                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input class="checkbox_animated" id="pup" name="pup" value="1" type="checkbox" @if(old('pup') == 1) checked @endif>
                                                            <label for="pup">Under Pressure</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input class="checkbox_animated" id="pnd" name="pnd" value="1" type="checkbox" @if(old('pnd') == 1) checked @endif>
                                                            <label for="pnd">Non Destructive Test</label>
                                                        </div>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input class="checkbox_animated" id="psl" name="psl" value="1" type="checkbox" @if(old('psl') == 1) checked @endif>
                                                            <label for="psl">Structural Lab</label>
                                                        </div>
                                                    </td>

                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input class="checkbox_animated" id="pml" name="pml" value="1" type="checkbox" @if(old('pml') == 1) checked @endif>
                                                            <label for="pml">Mineral Lab</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input class="checkbox_animated" id="pws" name="pws" value="1" type="checkbox" @if(old('pws') == 1) checked @endif>
                                                            <label for="pws">Weight & Scales Lab</label>
                                                        </div>
                                                    </td>

                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input class="checkbox_animated" id="ptl" name="ptl" value="1" type="checkbox" @if(old('ptl') == 1) checked @endif>
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
                                                            <input class="checkbox_animated" id="thr" name="thr" value="1" type="checkbox" @if(old('thr') == 1) checked @endif>
                                                            <label for="thr">Tehran</label>
                                                        </div>
                                                    </td>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input class="checkbox_animated" id="shz" name="shz" value="1" type="checkbox" @if(old('shz') == 1) checked @endif>
                                                            <label for="shz">Shiraz</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input class="checkbox_animated" id="bnd" name="bnd" value="1" type="checkbox" @if(old('bnd') == 1) checked @endif>
                                                            <label for="bnd">Bandar Abbas</label>
                                                        </div>
                                                    </td>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input class="checkbox_animated" id="qsm" name="qsm" value="1" type="checkbox" @if(old('qsm') == 1) checked @endif>
                                                            <label for="qsm">Qeshm</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input class="checkbox_animated" id="zjn" name="zjn" value="1" type="checkbox" @if(old('zjn') == 1) checked @endif>
                                                            <label for="zjn">Zanjan</label>
                                                        </div>
                                                    </td>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input class="checkbox_animated" id="mhd" name="mhd" value="1" type="checkbox" @if(old('mhd') == 1) checked @endif>
                                                            <label for="mhd">Mashhad</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input class="checkbox_animated" id="tbz" name="tbz" value="1" type="checkbox" @if(old('tbz') == 1) checked @endif>
                                                            <label for="tbz">Tabriz</label>
                                                        </div>
                                                    </td>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input class="checkbox_animated" id="isf" name="isf" value="1" type="checkbox" @if(old('isf') == 1) checked @endif>
                                                            <label for="isf">Isfahan</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input class="checkbox_animated" id="buh" name="buh" value="1" type="checkbox" @if(old('buh') == 1) checked @endif>
                                                            <label for="buh">Bushehr</label>
                                                        </div>
                                                    </td>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input class="checkbox_animated" id="gnv" name="gnv" value="1" type="checkbox" @if(old('gnv') == 1) checked @endif>
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
                                                    <input id="userLevel1" name="userLevel1" type="checkbox" value="1" tabindex="7" @if(old('userLevel1') == 1) checked @endif>
                                                    <label for="userLevel1">Experts</label>
                                                </div>
                                                <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                    <input id="userLevel2" name="userLevel2" type="checkbox" value="1"  tabindex="8" @if(old('userLevel2') == 1) checked @endif>
                                                    <label for="userLevel2">Managers</label>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="mb-3">
                                            <label class="col-form-label pt-0" for="version">Document Version</label>
                                            <input class="form-control" name="version" id="version" type="text"  placeholder="Document version like: 001" tabindex="4" value="{{ old('version') }}">
                                        </div>


                                        <div class="mb-3">
                                            <label class="col-form-label pt-0" for="releaseDate">Release Date</label>
                                            <input class="form-control" name="releaseDate" id="releaseDate" type="text" required value="{{ old('releaseDate') }}">
                                            <span id="span1"></span>

                                        </div>


                                        <div class="mb-3">
                                            <div class="form-group m-t-15 mb-0">
                                                <label class="col-form-label pt-0" for="bankName">Quality Control Systems</label><br>
                                                <div class="checkbox checkbox-solid-success" style="display: inline">
                                                    <input id="s17020" name="s17020" value="1"  type="checkbox" tabindex="7" @if(old('s17020') == 1) checked @endif>
                                                    <label for="s17020">17020</label>
                                                </div>
                                                <div class="checkbox checkbox-solid-success" style="display: inline">
                                                    <input id="s17025" name="s17025" value="1"  type="checkbox" tabindex="7" @if(old('s17025') == 1) checked @endif>
                                                    <label for="s17025">17025</label>
                                                </div>
                                                <div class="checkbox checkbox-solid-success" style="display: inline">
                                                    <input id="s9001" name="s9001" value="1"  type="checkbox" tabindex="7" @if(old('s9001') == 1) checked @endif>
                                                    <label for="s9001">9001</label>
                                                </div>
                                                {{-- <div class="checkbox checkbox-solid-success" style="display: inline">
                                                    <input id="s14001" name="s14001" value="1" type="checkbox" tabindex="7">
                                                    <label for="s14001">14001</label>
                                                </div>
                                                <div class="checkbox checkbox-solid-success" style="display: inline">
                                                    <input id="s45001" name="s45001"  value="1"  type="checkbox" tabindex="7">
                                                    <label for="s45001">45001</label>
                                                </div> --}}
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="col-form-label pt-0" for="pages">Number of Pages</label>
                                            <input class="form-control" name="pages" id="pages" type="number" placeholder="..." value="{{ old('pages') }}">
                                        </div>


                                        <div class="mb-3">
                                            <label class="col-form-label pt-0" for="modDesc">Modification Desc</label>
                                            <textarea class="form-control" name="modDesc" id="modDesc" rows="10" placeholder="Pls describe what is modified if its a new version of an issued document">{{ old('modDesc') }}</textarea>
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
                                            <label class="col-form-label pt-0" for="native">Native File</label>
                                            <input class="form-control"  name="native" id="native" type="file" required value="{{ old('native') }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="col-form-label pt-0" for="status">Status:</label>
                                            <select class="form-control" name="status" id="status">
                                                <option value="1">Issue</option>
                                                <option value="2">Withdraw</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="col-form-label pt-0" for="pdf">PDF File</label>
                                            <input class="form-control"  name="pdf" id="pdf" type="file" required value="{{ old('pdf') }}">
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
