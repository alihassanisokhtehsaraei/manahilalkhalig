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
                <h5>Users List</h5>
            </div>

            <div class="card-body table-responsive">
                <table class="display persian-fonts" id="customers-datatable">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Branch</th>
                        <th>Department</th>
                        <th>Email</th>
                        <th>Actions</th>

                    </tr>
                    </thead>
                </table>
            </div>
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
    <script type="text/javascript">

        $(document).ready( function () {
            $('#customers-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('user.index') }}",
                columns: [
                    { data: 'Name', name: 'Name' },
                    { data: 'branch', name: 'branch' },
                    { data: 'department', name: 'department' },
                    { data: 'email', name: 'email' },
                    { data: 'actions', name: 'actions' },

                ],
            });

        });
    </script>
@endsection
