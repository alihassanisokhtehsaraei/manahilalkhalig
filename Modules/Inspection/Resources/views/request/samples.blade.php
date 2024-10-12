@extends('layouts.viho')
@section('moreCSS')
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{ asset('viho/assets/css/datatables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('viho/assets/css/sweetalert2.css')}}">
    <!-- Plugins css Ends-->
    <style>
        /* Custom styles for the suggestion list */
        #suggestions {
            border: 1px solid #ccc;
            max-height: 200px;
            overflow-y: auto;
            background: white;
            padding: 0;
        }

        .suggestion-item {
            cursor: pointer;
            padding: 10px;
        }

        .suggestion-item:hover {
            background-color: #f0f0f0;
        }
    </style>
@endsection
@section('body')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-6">

                    <h3>Tracking No.: {{ $rft->id }}</h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">{{ __('common.home') }}</a></li>
                        <li class="breadcrumb-item">Inspection Department</li>
                        <li class="breadcrumb-item active">Inspection Order</li>
                        <li class="breadcrumb-item active">IC Profile</li>
                    </ol>
                </div>
                <div class="col-sm-6">
                    <!-- Bookmark Start-->
                    <div class="bookmark">
                        <ul>
                            <li><a href="javascript:void(0)" data-container="body" data-bs-toggle="popover" data-placement="top" title="{{ __('common.call') }}" data-original-title="call"><i data-feather="phone-call"></i></a></li>
                            <li><a href="" data-container="body" data-bs-toggle="popover" data-placement="top" title="{{ __('common.semail') }}" data-original-title="Send Email"><i data-feather="mail"></i></a></li>
                            <li><a id="sweet-id" data-container="body" data-bs-toggle="popover" data-placement="top" title="{{ __('common.delete') }}" data-original-title="Delete"><i data-feather="delete"></i></a></li>
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
                            <h5>Testing Samples Profile</h5><span>Please fill all required inputs.</span>
                        </div>
                        <form class="theme-form" method="post" action="{{ route('rft.storeSamples', Request::segment(3)) }}" id="samples">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <!-- Left Column -->
                                    <div class="col-md-6">
                                        <div class="mb-3 position-relative"> <!-- Position relative to allow absolute positioning of suggestions -->
                                            <label class="col-form-label pt-0" for="search">Search:</label>
                                            <input class="form-control" name="search" id="search" placeholder="Search with English Name...">
                                            <!-- Suggestions list -->
                                            <ul id="suggestions" class="list-group" style="width: 100%;"></ul>
                                            @error('lab_fee_id')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="col-form-label pt-0" for="desc">Description:</label>
                                            <textarea class="form-control" name="desc" id="desc" rows="4"></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="col-form-label pt-0" for="quantity">Quantity:</label>
                                            <input class="form-control" name="quantity" id="quantity" type="text" value="">
                                        </div>
                                    </div>

                                    <!-- Right Column -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="col-form-label pt-0" for="arabic_name">Arabic Name:</label>
                                            <input class="form-control" disabled name="arabic_name" id="arabic_name" type="text">
                                        </div>
                                        <div class="mb-3">
                                            <label class="col-form-label pt-0" for="fee">Fee:</label>
                                            <input class="form-control" disabled name="fee" id="fee" type="text">
                                        </div>
                                        <div class="mb-3">
                                            <label class="col-form-label pt-0" for="category">Category:</label>
                                            <input class="form-control" disabled name="category" id="category" type="text">
                                        </div>
                                        <div class="mb-3">
                                            <label class="col-form-label pt-0" for="seal">Seal No(s):</label>
                                            <input class="form-control" name="seal" id="seal" type="text" value="">
                                        </div>
                                        <div class="mb-3">
                                            <label class="col-form-label pt-0" for="standard">Required Standard for Testing:</label>
                                            <input class="form-control" name="standard" id="standard" type="text" value="">
                                        </div>
                                        <input type="hidden" name="lab_fee_id" id="lab_fee_id">
                                    </div>
                                </div>
                            </div>


                            <div class="card-footer text-end">
                                <button class="btn btn-primary m-r-15" type="submit">Add Item</button>
                            </div>
                        </form>
                    </div>
                    @if($samples->count() > 0)
                    <div class="card">
                        <div class="card-header pb-0">
                            <p class="sub-title">Description of Goods</p>
                            <div class="figure d-block">
                                <blockquote class="blockquote">
                                    <p class="mb-0">-- Description of Goods and actions related to status of IC file </p>
                                </blockquote>
                            </div>
                        </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Descripton of Sample</th>
                                                <th scope="col">Quantity</th>
                                                <th scope="col">Seal</th>
                                                <th scope="col">Standard</th>
                                                <th scope="col">Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($samples as $goods)
                                                <tr>
                                                    <th  scope="row">{{ $loop->iteration }}</th>
                                                    <td>{{ $goods->desc }}</td>
                                                    <td>{{ $goods->quantity }}</td>
                                                    <td>{{ $goods->seal }}</td>
                                                    <td>{{ $goods->standard }}</td>
                                                    <td>
                                                        @if($rft->status > 2 && auth()->user()->level != 'head' && auth()->user()->level != 'manager')
                                                            <a style="margin: 1px" href="{{ route('rft.editSample', $goods->id) }}" class="btn btn-xs btn-success">Edit</a> <a style="margin: 1px" href="{{ route('rft.destroySample', $goods->id) }}" class="btn btn-xs btn-danger">Delete</a>
                                                        @else
                                                            <a style="margin: 1px" href="{{ route('rft.editSample', $goods->id) }}" class="btn btn-xs btn-success">Edit</a> <a style="margin: 1px" href="{{ route('rft.destroySample', $goods->id) }}" class="btn btn-xs btn-danger">Delete</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">

                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header pb-0">
                                <p class="sub-title">Change Status</p>
                                <div class="figure d-block">
                                    <blockquote class="blockquote">
                                        <p class="mb-0">-- Here you can change the status of the RFT profile</p>
                                    </blockquote>
                                </div>
                            </div>
                            <div class="card-body">
                                    <form class="theme-form" method="post" action="{{ route('rft.changeStatus', $rft->id) }}" id="ic">
                                    @csrf
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <select class="form-control" name="status">
                                                        @if(Auth()->user()->department == 'laboratory')
                                                            <option value="1">Send to Lab</option>
                                                        @else
                                                            <option value="1">Send to Lab</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <input class="form-control btn btn-primary" style="color:white" type="submit" value="update">
                                                </div>
                                            </div>
                                        </div>
                                  </form>
                            </div>
                            <div class="card-footer text-end">

                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

<!-- Container-fluid Ends-->
@section('moreJs')
    @if(session('message'))
        <script>
            $.notify({
                    message:'{{ session('message') }}'
                },
                {
                    type:'primary',
                    allow_dismiss:false,
                    newest_on_top:false ,
                    mouse_over:false,
                    showProgressbar:false,
                    spacing:10,
                    timer:2000,
                    placement:{
                        from:'top',
                        align:'right'
                    },
                    offset:{
                        x:50,
                        y:230
                    },
                    delay:2000 ,
                    z_index:10000,
                    animate:{
                        enter:'animated bounceOutRight',
                        exit:'animated bounceOutDown'
                    }
                });
        </script>
    @endif

    <!-- Ajax Search Script with Suggestions -->
    <script>
        $(document).ready(function() {
            // Handle search input keyup event
            $('#search').on('keyup', function() {
                let query = $(this).val();

                if (query.length > 2) { // Only search if more than 2 characters
                    $.ajax({
                        url: "{{ route('labfees.search') }}", // URL to your search route
                        method: 'GET',
                        data: { query: query },
                        success: function(data) {
                            let suggestions = $('#suggestions');
                            suggestions.empty(); // Clear previous suggestions

                            if (data.length > 0) {
                                $.each(data, function(index, item) {
                                    suggestions.append('<li class="list-group-item suggestion-item" data-id="'+item.id+'" data-arabic="'+item.arabic_name+'" data-fee="'+item.fee+'" data-category="'+item.category+'">' + item.english_name + '</li>');
                                });
                            } else {
                                suggestions.append('<li class="list-group-item">No results found</li>');
                            }
                        }
                    });
                } else {
                    // Optionally clear suggestions if the query is too short
                    $('#suggestions').empty();
                }
            });

            // Handle click event on suggestion items
            $(document).on('click', '.suggestion-item', function() {
                let selectedId = $(this).data('id');
                let arabicName = $(this).data('arabic');
                let fee = $(this).data('fee');
                let category = $(this).data('category');
                let itemName = $(this).text(); // Get the text of the selected item

                // Fill the form fields
                $('#lab_fee_id').val(selectedId);
                $('#arabic_name').val(arabicName);
                $('#fee').val(fee);
                $('#category').val(category);

                // Set the search input value to the selected item's text
                $('#search').val(itemName);

                // Clear the suggestions list
                $('#suggestions').empty();
            });
        });
    </script>

@endsection
