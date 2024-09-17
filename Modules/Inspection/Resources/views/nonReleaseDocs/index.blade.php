@extends('layouts.viho')

@section('moreCSS')
    <!-- Plugins CSS start-->
    <link rel="stylesheet" type="text/css" href="{{ asset('viho/assets/css/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('viho/assets/css/sweetalert2.css') }}">
    <!-- Plugins CSS Ends-->
    <style>
        .back-button {
            background-color: #f1c40f; /* Yellow background */
            color: #fff; /* White text */
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 10px 0;
            cursor: pointer;
        }

        .back-button:hover {
            background-color: #f39c12; /* Darker yellow on hover */
        }

        .back-button-container {
            margin-bottom: 20px; /* Space between button and cards */
        }
    </style>
@endsection

@section('body')

    <div class="col-sm-12">
        <!-- Back Button -->
        <div class="back-button-container">
            <a href="{{ route('inspection.show', $order->id) }}" class="back-button">
                Back
            </a>
        </div>
        <div class="card">
            <div class="card-header">
                <h5>Non-Release Documents for {{ $order->tracking_no. ' - '.$order->coc->certNo }}</h5>
            </div>

            <div class="card-body">
                @if(auth()->user()->department == 'management' or auth()->user()->department == 'branch' or auth()->user()->department == 'border')
                    <div class="mb-3">
                        <a href="{{ route('nrdocs.create', ['order' => $order]) }}" class="btn btn-danger btn-sm">New Non-Release Document</a>
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Remaining Quantity</th>
                            <th>Incoming Quantity</th>
                            <th>Total Quantity</th>
                            <th>Status</th>
                            <th>Document Number</th>
                            <th>Issuance Date</th>
                            <th>Issuing Office</th>
                            <th>Actions</th> <!-- New Actions column -->
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($order?->nonReleaseDocuments as $index => $doc)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $doc->remaining_quantity }}</td>
                                <td>{{ $doc->incoming_quantity }}</td>
                                <td>{{ $doc->total_quantity }}</td>
                                <td>{{ $doc->status ==="2" ? "Approved" : "Draft" }}</td>
                                <td>{{ $doc->document_number ?? "-" }}</td>
                                <td>{{ $doc->issuance_date ?? "-" }}</td>
                                <td>{{ $doc->issuing_office ?? "-" }}</td>
                                <td>
                                    <!-- Actions column with Edit and Delete buttons -->
                                    @if(auth()->user()->department == 'management' or auth()->user()->department == 'branch' or auth()->user()->department == 'border')
                                        <a href="{{route('nrdocs.edit',['order'=>$order,'nonReleaseDocument'=>$doc])}}" class="btn btn-warning btn-xs">Open</a>
                                        @if($doc->status == "1")
                                            <button type="button" class="btn btn-danger btn-xs" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $doc->id }}">
                                                Delete
                                            </button>
                                       @endif
                                    @endif
                                    <a href="{{route('nrdocs.showUpload',['order'=>$order,'nonReleaseDocument'=>$doc])}}" class="btn btn-secondary btn-xs">Uploads</a>
                                    @if($doc->status == "2") <a href="{{URL::signedRoute('words.nrd',$doc->id)}}" class="btn btn-primary btn-xs">Print</a> @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this document?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" action="" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('moreJs')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var deleteModal = document.getElementById('deleteModal');
            deleteModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget; // Button that triggered the modal
                var id = button.getAttribute('data-id'); // Extract info from data-id attribute
                var form = deleteModal.querySelector('#deleteForm');
                var action = "{{ route('nrdocs.destroy', ['order' => $order, 'nonReleaseDocument' => ':id']) }}";
                action = action.replace(':id', id);
                form.action = action;
            });
        });
    </script>
@endsection
