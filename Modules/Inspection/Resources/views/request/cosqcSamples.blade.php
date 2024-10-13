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
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-6">
                    <!-- Bookmark Start-->
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
                <div class="back-button-container">
                    <a href="{{ route('inspection.show', $order->id) }}" class="back-button">
                        Back
                    </a>
                </div>
                <div class="col-sm-12">
                    @if($samples->count() > 0)
                    <div class="card">
                        <div class="card-header pb-0">
                            <p class="sub-title">Description of Samples</p>
                            <div class="figure d-block">
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


                                                @php
                                                    $doc = \App\Models\InsDoc::query()->where('category', 'rft-' . $rft->id . '-' . $goods->id)->latest()->first();
                                                    $url = $doc ? $doc->url : null;
                                                @endphp

                                                <tr>
                                                    <th  scope="row">{{ $loop->iteration }}</th>
                                                    <td>{{ $goods->desc }}</td>
                                                    <td>{{ $goods->quantity }}</td>
                                                    <td>{{ $goods->seal }}</td>
                                                    <td>{{ $goods->standard }}</td>
                                                    <td>
                                                        @if ($url)
                                                            <!-- Show download button if URL exists --> <a href="{{ asset('fileManager/'.$url) }}" class="btn btn-success btn-xs" download>Download</a>

                                                        @else
                                                        ---
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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
