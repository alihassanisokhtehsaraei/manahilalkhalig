<?php
use \Illuminate\Foundation\Jdate;
$Jdate = new Jdate(); ?>

@extends('layouts.viho')
@section('moreCSS')
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/viho/assets/css/datatables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('themeviho/assets/css/sweetalert2.css')}}">
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
                        <li class="breadcrumb-item active">Edit Document</li>
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
                            <h5>
                                @if($data->status == 2)
                                    <span class="btn btn-danger">Widthdraw Document</span>
                                @endif
                                {{ $data->docType.'-'.$data->mgmtCode.'-'.$data->actCode.'-'.$data->no }}</h5><span>Here you can modify all information related to this document.</span>
                        </div>
                        <form class="theme-form" method="post" id="baNew" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="col-form-label pt-0" for="exampleInputEmail1">Document Number</label>
                                            <br>
                                            <select disabled class="form-control" name="docType" style="display:inline;width:50px;" tabindex="2" >
                                                <option value="{{ $data->docType }}">{{ $data->docType }}</option>
                                                <optgroup label="Select">
                                                    <option value="CH">CH</option>
                                                    <option value="MP">MP</option>
                                                    <option value="MN">MN</option>
                                                    <option value="PR">PR</option>
                                                    <option value="WI">WI</option>
                                                    <option value="FR">FR</option>
                                                </optgroup>
                                            </select> -
                                            <select disabled class="form-control" name="mgmtCode" id="mgmtCode" style="display:inline;width:50px;" tabindex="2">
                                                <option value="{{ $data->mgmtCode }}">
                                                    @switch($data->mgmtCode)
                                                        @case('MG')
                                                            MG &nbsp;&nbsp;- MANAGEMENT
                                                            @break
                                                        @case('QA')
                                                            QA &nbsp;&nbsp;- QUALITY ASSURANCE
                                                            @break
                                                        @case('IN')
                                                            IN &nbsp;&nbsp;- INSPECTION
                                                            @break
                                                        @case('FM')
                                                            FM &nbsp;&nbsp;- FINANCIAL
                                                            @break
                                                        @case('AH')
                                                            AH &nbsp;&nbsp;- ADMINISTRATION & HUMAN RESOURCES
                                                            @break
                                                        @case('IT')
                                                            IT &nbsp;&nbsp;- INFORMATION TECHNOLOGY
                                                            @break
                                                    @endswitch
                                                </option>
                                                <optgroup label="Select">
                                                    <option value="MG">MG &nbsp;&nbsp;- MANAGEMENT</option>
                                                    <option value="QA">QA &nbsp;&nbsp;- QUALITY ASSURANCE</option>
                                                    <option value="IN">IN &nbsp;&nbsp;- INSPECTION</option>
                                                    <option value="FM">FM &nbsp;&nbsp;- FINANCIAL</option>
                                                    <option value="AH">AH &nbsp;&nbsp;- ADMINISTRATION & HUMAN RESOURCES</option>
                                                    <option value="IT">IT &nbsp;&nbsp;- INFORMATION TECHNOLOGY</option>
                                                    <option value="LB">LB &nbsp;&nbsp;- LABORATORY</option>
                                                </optgroup>
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
                                            <select disabled class="form-control" id="activity" name="actCode" style="display:inline;width:53px;" tabindex="1">
                                                <option value="{{ $data->actCode }}">{{ $data->actCode }}</option>
                                            </select> -
                                            <input  disabled class="form-control" name="no" style="display:inline;width:100px;" tabindex="3" value="{{ $data->no }}">
                                        </div>

                                        <div class="mb-3">
                                            <label class="col-form-label pt-0" for="title">Title</label>
                                            <input disabled class="form-control" name="title" id="title" type="text" placeholder="Document Title" tabindex="5" value="{{ $data->title }}">
                                        </div>




                                        <div class="mb-3">
                                            <label class="col-form-label pt-0" for="distro">Distribution Places</label>
                                            <table style="width: 100%;">
                                                <tr>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input disabled class="checkbox_animated" id="pmg" name="pmg" value="1" type="checkbox" @if($data->place1 == 1) checked @endif>
                                                            <label for="pmg">Management</label>
                                                        </div>
                                                    </td>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input disabled class="checkbox_animated" id="pmd" name="pmd" value="1" type="checkbox" @if($data->place2 == 1) checked @endif>
                                                            <label for="pmd">Market Development</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>

                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input disabled class="checkbox_animated" id="pfi" name="pfi" value="1" type="checkbox" @if($data->place3 == 1) checked @endif>
                                                            <label for="pfi">Financial</label>
                                                        </div>
                                                    </td>

                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input disabled class="checkbox_animated" id="phr" name="phr" value="1" type="checkbox" @if($data->place4 == 1) checked @endif>
                                                            <label for="phr">Human Resources</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input disabled class="checkbox_animated" id="pst" name="pst" value="1" type="checkbox" @if($data->place5 == 1) checked @endif>
                                                            <label for="pst">Strategy</label>
                                                        </div>
                                                    </td>

                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input disabled class="checkbox_animated" id="ppr"  name="ppr" value="1" type="checkbox" @if($data->place6 == 1) checked @endif>
                                                            <label for="ppr">Procurement</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input disabled class="checkbox_animated" id="pqd" name="pqd" value="1" type="checkbox" @if($data->place7 == 1) checked @endif>
                                                            <label for="pqd">Quality Development</label>
                                                        </div>
                                                    </td>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input disabled class="checkbox_animated" id="ict" name="ict" value="1" type="checkbox" @if($data->place8 == 1) checked @endif>
                                                            <label for="ict">ICT</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input disabled class="checkbox_animated" id="pgc" name="pgc" value="1" type="checkbox" @if($data->place9 == 1) checked @endif>
                                                            <label for="pgc">General Cargo</label>
                                                        </div>
                                                    </td>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input disabled class="checkbox_animated" id="pti" name="pti" value="1" type="checkbox" @if($data->place10 == 1) checked @endif>
                                                            <label for="pti">Technical Inspection</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input disabled class="checkbox_animated" id="pes" name="pes" value="1" type="checkbox" @if($data->place11 == 1) checked @endif>
                                                            <label for="pes">Escalator</label>
                                                        </div>
                                                    </td>

                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input disabled class="checkbox_animated" id="pup" name="pup" value="1" type="checkbox" @if($data->place12 == 1) checked @endif>
                                                            <label for="pup">Under Pressure</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input disabled class="checkbox_animated" id="pnd" name="pnd" value="1" type="checkbox" @if($data->place13 == 1) checked @endif>
                                                            <label for="pnd">Non Destructive Test</label>
                                                        </div>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input disabled class="checkbox_animated" id="psl" name="psl" value="1" type="checkbox" @if($data->place14 == 1) checked @endif>
                                                            <label for="psl">Structural Lab</label>
                                                        </div>
                                                    </td>

                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input disabled class="checkbox_animated" id="pml" name="pml" value="1" type="checkbox" @if($data->place15 == 1) checked @endif>
                                                            <label for="pml">Mineral Lab</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input disabled class="checkbox_animated" id="pws" name="pws" value="1" type="checkbox" @if($data->place16 == 1) checked @endif>
                                                            <label for="pws">Weight & Scales Lab</label>
                                                        </div>
                                                    </td>

                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input disabled class="checkbox_animated" id="ptl" name="ptl" value="1" type="checkbox" @if($data->place17 == 1) checked @endif>
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
                                                            <input disabled class="checkbox_animated" id="thr" name="thr" value="1" type="checkbox" @if($data->branch1 == 1) checked @endif>
                                                            <label for="thr">Tehran</label>
                                                        </div>
                                                    </td>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input disabled class="checkbox_animated" id="shz" name="shz" value="1" type="checkbox" @if($data->branch2 == 1) checked @endif>
                                                            <label for="shz">Shiraz</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input disabled class="checkbox_animated" id="bnd" name="bnd" type="checkbox" @if($data->branch3 == 1) checked @endif>
                                                            <label for="bnd">Bandar Abbas</label>
                                                        </div>
                                                    </td>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input disabled class="checkbox_animated" id="qsm" name="qsm" value="1" type="checkbox" @if($data->branch4 == 1) checked @endif>
                                                            <label for="qsm">Qeshm</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input disabled class="checkbox_animated" id="zjn" name="zjn" type="checkbox" @if($data->branch5 == 1) checked @endif>
                                                            <label for="zjn">Zanjan</label>
                                                        </div>
                                                    </td>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input disabled class="checkbox_animated" id="mhd" name="mhd" type="checkbox" @if($data->branch6 == 1) checked @endif>
                                                            <label for="mhd">Mashhad</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input disabled class="checkbox_animated" id="tbz" name="tbz" type="checkbox" @if($data->branch7 == 1) checked @endif>
                                                            <label for="tbz">Tabriz</label>
                                                        </div>
                                                    </td>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input disabled class="checkbox_animated" id="isf" name="isf" type="checkbox" @if($data->branch8 == 1) checked @endif>
                                                            <label for="isf">Isfahan</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input disabled class="checkbox_animated" id="buh" name="buh" type="checkbox" @if($data->branch9 == 1) checked @endif>
                                                            <label for="buh">Bushehr</label>
                                                        </div>
                                                    </td>
                                                    <td style="width: 50%;">
                                                        <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                            <input disabled class="checkbox_animated" id="gnv" name="gnv" type="checkbox" @if($data->branch10 == 1) checked @endif>
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
                                                    <input disabled id="userLevel1" name="userLevel1" type="checkbox" tabindex="7" @if($data->userLevel1 == 1) checked @endif >
                                                    <label for="userLevel1">Experts</label>
                                                </div>
                                                <div class="checkbox checkbox-solid-primary" style="display: inline">
                                                    <input disabled id="userLevel2" name="userLevel2" type="checkbox"  tabindex="8" @if($data->userLevel2 == 1) checked @endif>
                                                    <label for="userLevel2">Managers</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="col-form-label pt-0" for="version">Document Version</label>
                                            <input disabled class="form-control" name="version" id="version" type="text" disabled  placeholder="Document version like: 001" tabindex="4" value="{{ $data->version }}">
                                        </div>


                                        <div class="mb-3">
                                            <label class="col-form-label pt-0" for="releaseDate">Release Date</label>
                                            <input disabled class="form-control" name="releaseDate" id="releaseDate" type="text" value="{{ $data->releaseDate }}">
                                            <span id="span1"></span>

                                        </div>


                                        <div class="mb-3">
                                            <div class="form-group m-t-15 mb-0">
                                                <label class="col-form-label pt-0" for="bankName">Quality Control Systems</label><br>
                                                <div class="checkbox checkbox-solid-success" style="display: inline">
                                                    <input disabled id="s17020" name="s17020" value="1"  type="checkbox" tabindex="7" @if($data->s17020 == 1) checked @endif>
                                                    <label for="s17020">17020</label>
                                                </div>
                                                <div class="checkbox checkbox-solid-success" style="display: inline">
                                                    <input disabled id="s17025" name="s17025" value="1"  type="checkbox" tabindex="7" @if($data->s17025 == 1) checked @endif>
                                                    <label for="s17025">17025</label>
                                                </div>
                                                <div class="checkbox checkbox-solid-success" style="display: inline">
                                                    <input disabled id="s9001" name="s9001" value="1"  type="checkbox" tabindex="7" @if($data->s9001 == 1) checked @endif>
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
                                            <input disabled class="form-control" name="pages" id="pages" type="number" value="{{ $data->pages }}">
                                        </div>

                                        <div class="mb-3">
                                            <label class="col-form-label pt-0" for="modDesc">Modification Desc</label>
                                            <textarea disabled class="form-control" name="modDesc" id="modDesc" rows="10">{{ $data->modDesc }}</textarea>
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
                                            <label class="col-form-label pt-0" for="native">Native File
                                                <a class="btn btn-success btn-xs" href="{{  route('tdms.getNative', $data->id) }}" target='_blank'>Download File</a></label>

                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="col-form-label pt-0" for="pdf">PDF File <a class="btn btn-success btn-xs" href="{{ route('tdms.getPdf', $data->id) }}" target='_blank'>Download File</a>
                                            </label>


                                         </div>
                                        <div class="mb-3">

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="btn btn-danger" style="color: white">Withdraw Versions</h5>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="display" id="basic-1">
                                    <thead>
                                        <tr>
                                            <th>DOC NO.</th>
                                            <th>TITLE</th>
                                            <th>VERSION</th>
                                            <th>REV. DATE</th>
                                            <th>DEPARTMENT</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($docs as $doc)
                                        <tr>
                                            <td>{{ $doc->docType.'-'.$doc->mgmtCode.'-'.$doc->actCode.'-'.$doc->no }}</td>
                                            <td>{{ $doc->title }}</td>
                                            <td>{{ $doc->version }}</td>
                                            <td>{{ $doc->releaseDate }}</td>
                                            <td>

                                                @if($doc->place1 == 1)  <span class="btn btn-xs btn-success" style="margin:2px">Management</span> @endif
                                                @if($doc->place2 == 1)  <span class="btn btn-xs btn-warning" style="margin:2px">Market Development</span> @endif
                                                @if($doc->place3 == 1)  <span class="btn btn-xs btn-info" style="margin:2px">Financial</span> @endif
                                                @if($doc->place4 == 1)  <span class="btn btn-xs btn-primary" style="margin:2px">Human Resources</span> @endif
                                                @if($doc->place5 == 1)  <span class="btn btn-xs btn-danger" style="margin:2px">Strategy</span> @endif
                                                @if($doc->place6 == 1)  <span class="btn btn-xs btn-success" style="margin:2px">Procurment</span> @endif
                                                @if($doc->place7 == 1)  <span class="btn btn-xs btn-warning" style="margin:2px">Quality Development</span> @endif
                                                @if($doc->place8 == 1)  <span class="btn btn-xs btn-danger" style="margin:2px">ICT</span> @endif
                                                @if($doc->place9 == 1)  <span class="btn btn-xs btn-primary" style="margin:2px">General Cargo</span> @endif
                                                @if($doc->place10 == 1) <span class="btn btn-xs btn-danger" style="margin:2px">Technical Inspection</span> @endif
                                                @if($doc->place11 == 1) <span class="btn btn-xs btn-success" style="margin:2px">Escalator</span> @endif
                                                @if($doc->place12 == 1) <span class="btn btn-xs btn-warning" style="margin:2px">Under Pressure</span> @endif
                                                @if($doc->place13 == 1) <span class="btn btn-xs btn-info" style="margin:2px">NDT</span> @endif
                                                @if($doc->place14 == 1) <span class="btn btn-xs btn-primary" style="margin:2px">Structural Lab</span> @endif
                                                @if($doc->place15 == 1) <span class="btn btn-xs btn-danger" style="margin:2px">Mineral Lab</span> @endif
                                                @if($doc->place16 == 1) <span class="btn btn-xs btn-success" style="margin:2px">Weight & Scales Lab</span> @endif
                                                @if($doc->place17 == 1) <span class="btn btn-xs btn-warning" style="margin:2px">Textile Lab</span> @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection

<!-- Container-fluid Ends-->
@section('moreJs')

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="{{ asset('theme/viho/assets/js/sweet-alert/sweetalert.min.js')}}"></script>

    <script src="{{ asset('theme/viho/assets/js/tooltip-init.js')}}"></script>
    <script src="{{ asset('theme/viho/assets/js/script.js')}}"></script>

    <script src="{{ asset('theme/viho/assets/js/datatable/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('theme/viho/assets/js/datatable/datatables/datatable.custom.js')}}"></script>
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
