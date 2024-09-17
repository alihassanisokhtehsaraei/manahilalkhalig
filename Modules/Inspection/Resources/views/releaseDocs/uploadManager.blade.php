@extends('layouts.viho')

@section('moreCSS')
    <!-- Plugins CSS start-->
    <link rel="stylesheet" type="text/css" href="{{ asset('viho/assets/css/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('viho/assets/css/sweetalert2.css') }}">
    <!-- Plugins CSS Ends-->
    <!-- Custom CSS for the Back Button -->
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
                <a href="{{ route('rdocs.index', ['order' => $order]) }}" class="back-button">
                    Back
                </a>
            </div>
        <div class="card">
            <div class="card-header">
                <h5>Release Documents Uploads for {{ $order->tracking_no. ' - '.$order->coc->certNo }} </h5>
            </div>

            <div class="card-body">
                <!-- Display Validation Errors -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row">
                    <!-- First Card with Form -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h5>Release Document</h5>
                            </div>
                            <div class="card-body">
                                @if($certificateUrl)
                                    @php
                                        $extension = pathinfo($certificateUrl, PATHINFO_EXTENSION);
                                    @endphp

                                    @if(strtolower($extension) == 'pdf')
                                        <div class="d-flex align-items-center">
                                            <i class="fa fa-file-pdf-o fa-3x text-danger"></i>
                                            <a href="{{ asset("fileManager/".$certificateUrl) }}" class="btn btn-primary ms-2" download>
                                                Download PDF
                                            </a>
                                        </div>
                                        @if(auth()->user()->department == 'management' or auth()->user()->department == 'branch' or auth()->user()->department == 'border')
                                            <!-- Delete Button -->
                                            <form action="{{ route('rdocs.deleteFile', ['order' => $order, 'releaseDocument' => $releaseDocument]) }}" method="POST" style="display: inline-block;" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="url" value="{{$certificateUrl}}">
                                                <button {{$readOnly ==='readonly' ? 'disabled' :''}} type="submit" class="btn btn-danger mt-2">Delete</button>
                                            </form>
                                        @endif

                                    @else
                                        <!-- Display Image and Download Button -->
                                        <img src="{{ asset("fileManager/".$certificateUrl) }}" alt="Certificate" class="img-fluid mb-3">
                                        <a href="{{ asset("fileManager/".$certificateUrl) }}" class="btn btn-primary" download>
                                            Download Image
                                        </a>

                                        @if(auth()->user()->department == 'management' or auth()->user()->department == 'branch' or auth()->user()->department == 'border')
                                            <!-- Delete Button -->
                                            <form action="{{ route('rdocs.deleteFile', ['order' => $order, 'releaseDocument' => $releaseDocument]) }}" method="POST" style="display: inline-block;" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="url" value="{{$certificateUrl}}">
                                                <button {{$readOnly ==='readonly' ? 'disabled' :''}} type="submit" class="btn btn-danger mt-2">Delete</button>
                                            </form>
                                        @endif
                                    @endif
                                @else

                                    @if(auth()->user()->department == 'management' or auth()->user()->department == 'branch' or auth()->user()->department == 'border')
                                        <!-- Upload Form -->
                                        <form action="{{route("rdocs.uploadCertificate",['order'=>$order, 'releaseDocument'=>$releaseDocument])}}"
                                              method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="document1" class="form-label">Choose File</label>
                                                <input class="form-control" type="file" name="certificate" id="document1" required>
                                            </div>
                                            <button {{$readOnly ==='readonly' ? 'disabled' :''}} type="submit" class="btn btn-primary">Upload</button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Second Card with Form -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h5>Commitment Letter</h5>
                            </div>
                            <div class="card-body">
                                @if($letterUrl)
                                    @php
                                        $extension = pathinfo($letterUrl, PATHINFO_EXTENSION);
                                    @endphp

                                    @if(strtolower($extension) == 'pdf')
                                        <div class="d-flex align-items-center">
                                            <i class="fa fa-file-pdf-o fa-3x text-danger"></i>
                                            <a href="{{ asset("fileManager/".$letterUrl) }}" class="btn btn-primary ms-2" download>
                                                Download PDF
                                            </a>
                                        </div>

                                        @if(auth()->user()->department == 'management' or auth()->user()->department == 'branch' or auth()->user()->department == 'border')
                                            <!-- Delete Button -->
                                            <form action="{{ route('rdocs.deleteFile', ['order' => $order, 'releaseDocument' => $releaseDocument]) }}" method="POST" style="display: inline-block;" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="url" value="{{$letterUrl}}">
                                                <button {{$readOnly ==='readonly' ? 'disabled' :''}} type="submit" class="btn btn-danger mt-2">Delete</button>
                                            </form>
                                        @endif
                                    @else
                                        <!-- Display Image and Download Button -->
                                        <img src="{{ asset("fileManager/".$letterUrl) }}" alt="Letter" class="img-fluid mb-3">
                                        <a href="{{ asset("fileManager/".$letterUrl) }}" class="btn btn-primary" download>
                                            Download Image
                                        </a>

                                        @if(auth()->user()->department == 'management' or auth()->user()->department == 'branch' or auth()->user()->department == 'border')
                                            <!-- Delete Button -->
                                            <form action="{{ route('rdocs.deleteFile', ['order' => $order, 'releaseDocument' => $releaseDocument]) }}" method="POST" style="display: inline-block;" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="url" value="{{$letterUrl}}">
                                                <button {{$readOnly ==='readonly' ? 'disabled' :''}} type="submit" class="btn btn-danger mt-2">Delete</button>
                                            </form>
                                        @endif
                                    @endif
                                @else

                                    @if(auth()->user()->department == 'management' or auth()->user()->department == 'branch' or auth()->user()->department == 'border')
                                        <!-- Upload Form -->
                                        <form action="{{route("rdocs.uploadLetter",['order'=>$order, 'releaseDocument'=>$releaseDocument])}}"
                                              method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="document2" class="form-label">Choose File</label>
                                                <input class="form-control" type="file" name="letter" id="document2" required>
                                            </div>
                                            <button {{$readOnly ==='readonly' ? 'disabled' :''}} type="submit" class="btn btn-primary">Upload</button>
                                        </form>
                                    @else
                                        Nothing Found!
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>

                    @if(auth()->user()->department == 'management' or auth()->user()->department == 'branch' or auth()->user()->department == 'border')
                        <!-- Form for Uploading Multiple Documents -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Other Documents</h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{route('rdocs.uploadDocument',['order'=>$order, 'releaseDocument'=>$releaseDocument])}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label  class="form-label">Choose Files</label>
                                            <input class="form-control" type="file" name="documents[]" multiple required>
                                            <!-- Add the `multiple` attribute to support multiple file selection -->
                                        </div>
                                        <button {{$readOnly ==='readonly' ? 'disabled' :''}} type="submit" class="btn btn-primary">Upload</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Loop through Document URLs -->
                @foreach($documentUrls->chunk(3) as $chunk)
                    <div class="row mt-3">
                        @foreach($chunk as $documentUrl)
                            @php
                                $extension = pathinfo($documentUrl, PATHINFO_EXTENSION);
                            @endphp
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Uploaded Document</h5>
                                    </div>
                                    <div class="card-body">
                                        @if(strtolower($extension) == 'pdf')
                                            <div class="d-flex align-items-center">
                                                <i class="fa fa-file-pdf-o fa-3x text-danger"></i>
                                                <a href="{{ asset("fileManager/".$documentUrl) }}" class="btn btn-primary ms-2" download>
                                                    Download PDF
                                                </a>
                                            </div>
                                        @else
                                            <img src="{{ asset("fileManager/".$documentUrl) }}" alt="Document" class="img-fluid mb-3">
                                            <a href="{{ asset("fileManager/".$documentUrl) }}" class="btn btn-primary" download>
                                                Download Image
                                            </a>
                                        @endif

                                            @if(auth()->user()->department == 'management' or auth()->user()->department == 'branch' or auth()->user()->department == 'border')
                                                <!-- Delete Button -->
                                                <form action="{{ route('rdocs.deleteFile', ['order' => $order, 'releaseDocument' => $releaseDocument]) }}" method="POST" style="display: inline-block;" class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="url" value="{{$documentUrl}}">
                                                    <button {{$readOnly ==='readonly' ? 'disabled' :''}} type="submit" class="btn btn-danger mt-2">Delete</button>
                                                </form>
                                            @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach

            </div>
        </div>
    </div>

@endsection

@section('moreJs')
    <!-- Add SweetAlert2 JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Select all delete forms
            document.querySelectorAll('.delete-form').forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    event.preventDefault(); // Prevent form from submitting immediately

                    // Show SweetAlert2 confirmation dialog
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit(); // Submit the form if confirmed
                        }
                    });
                });
            });
        });
    </script>
@endsection
