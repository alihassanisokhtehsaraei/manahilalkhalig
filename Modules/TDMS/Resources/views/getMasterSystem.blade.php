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
                    <h3></h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">IPMS</a></li>
                        <li class="breadcrumb-item">TDMS</li>
                        <li class="breadcrumb-item active">Master List</li>
                        <li class="breadcrumb-item active">{{ $system }}</li>
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
                            <h5>Master List {{ $system }}
                                <span style="float: right; font-size: 14px">
                                    <form method="post" action="{{ route('tdms.getMasterSystem') }}">
                                        @csrf
                                        <select name="system"  style="height: 37px; border: 1px solid lightgrey">
                                            <option>select</option>
                                            <option value="17020">17020</option>
                                            <option value="17025">17025</option>
                                            <option value="9001">9001</option>
                                        </select>
                                        <input name="submit" type="submit" value="Go" style="height: 37px; background-color: #0c4128; color: white; border-radius: 3px">
                                    </form>
                                </span>
{{--                                <a href="{{ route('tdms.create') }}" class="btn btn-sm btn-primary" style="float: right">New Document</a> --}}
                            </h5>
                        </div>
                        <div class="card-body table-responsive dropdown-basic">
                            <table class="display" id="customers-datatable"  style="text-align: center">
                                <thead>
                                <tr>
                                    <th>DOC NO.</th>
                                    <th>TITLE</th>
                                    <th>VERSION</th>
                                    <th>REV. DATE</th>
                                    <th>DEPARTMENT</th>
                                    <th>DOWNLOAD</th>
                                    <th>ACTIONS</th>
                                </tr>
                                </thead>
                            </table>
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
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="{{ asset('theme/viho/assets/js/sweet-alert/sweetalert.min.js')}}"></script>

    <script src="{{ asset('theme/viho/assets/js/tooltip-init.js')}}"></script>
    <script src="{{ asset('theme/viho/assets/js/script.js')}}"></script>
    <!-- Plugins JS Ends-->
    <script src="{{ asset('theme/viho/assets/js/datatable/datatables/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript">

        $(document).ready( function () {
            $('#customers-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{!! route('tdms.getMasterSystems', $system) !!}",
                columns: [
                    { data: 'DOC', name: 'DOC' },
                    { data: 'title', name: 'title' },
                    { data: 'version', name: 'version' },
                    { data: 'releaseDate', name: 'releaseDate' },
                    { data: 'department', name: 'department' },
                    { data: 'download', name: 'download' },
                    { data: 'actions', name: 'actions' }
                ],
            });

        });
    </script>
@endsection

