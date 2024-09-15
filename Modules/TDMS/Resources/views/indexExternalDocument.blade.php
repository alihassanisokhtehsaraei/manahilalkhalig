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
                        <li class="breadcrumb-item active">External Documents Master List</li>
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
                            <h5>External Documents List</h5>
                            <small>FR-QA-DM-05<br>Version: 0</small>
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
                lengthMenu: [ [25, 50, -1], [25, 50, "All"] ],
                processing: true,
                serverSide: true,
                ajax: "{!! route('tdms.getExternalDocumentMasterList') !!}",
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

