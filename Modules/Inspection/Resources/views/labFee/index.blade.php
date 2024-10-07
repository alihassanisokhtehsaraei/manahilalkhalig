@extends('layouts.viho')

@section('moreCSS')
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/viho/assets/css/datatables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/viho/assets/css/sweetalert2.css')}}">
    <!-- Plugins css Ends-->
@endsection

@section('body')
    <!-- Lab Fees List Starts-->
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Lab Fees List</h5>
                <!-- Create Button -->
                <a href="{{ route('labfees.create') }}" class="btn btn-success">Create New Lab Fee</a>
            </div>

            <div class="card-body table-responsive">
                <!-- Success Flash Message -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <table class="display" id="labfees-datatable">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>English Name</th>
                        <th>Arabic Name</th>
                        <th>Fee</th>
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <!-- Lab Fees List Ends-->
@endsection

@section('moreJs')
    <!-- Plugins JS start-->
    <script src="{{ asset('theme/viho/assets/js/datatable/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('theme/viho/assets/js/tooltip-init.js')}}"></script>
    <script src="{{ asset('theme/viho/assets/js/script.js')}}"></script>
    <!-- Plugins JS Ends-->

    <script type="text/javascript">
        $(document).ready(function () {
            const table = $('#labfees-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{!! route('labfees.index') !!}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'english_name', name: 'english_name' },
                    { data: 'arabic_name', name: 'arabic_name' },
                    { data: 'fee', name: 'fee' },
                    { data: 'category', name: 'category' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false }
                ],
            });

            // Handle delete button click
            $('#labfees-datatable').on('click', '.delete-button', function (e) {
                e.preventDefault();

                const deleteButton = $(this);
                const deleteUrl = deleteButton.data('url');

                // SweetAlert2 Confirmation
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Perform the AJAX request to delete the lab fee
                        $.ajax({
                            url: deleteUrl,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}',
                            },
                            success: function (response) {
                                // Reload DataTable
                                table.ajax.reload(null, false); // Reload without resetting pagination
                                // Show success message
                                Swal.fire(
                                    'Deleted!',
                                    response.message,
                                    'success'
                                );
                            },
                            error: function (xhr) {
                                // Show error message
                                Swal.fire(
                                    'Error!',
                                    'There was an error deleting the record. Please try again.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection

