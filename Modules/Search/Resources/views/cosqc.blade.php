@extends('layouts.viho')

@section('moreCSS')
    <!-- Plugins CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('viho/assets/css/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('viho/assets/css/sweetalert2.css') }}">
    <style>
        /* Custom Table Styling */
        .custom-table {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        .custom-table thead {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: white;
        }
        .custom-table tbody tr {
            background-color: #f8f9fa;
            transition: background-color 0.3s;
        }
        .custom-table tbody tr:hover {
            background-color: #e9ecef;
        }
        .custom-table th, .custom-table td {
            padding: 1rem;
            border-bottom: 1px solid #dee2e6;
        }
        .custom-table tbody tr:last-child td {
            border-bottom: none;
        }
    </style>
@endsection

@section('body')
    <div class="container-fluid py-4">
        <div class="page-header d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="mb-2">Search</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">{{ __('common.home') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Search</li>
                    </ol>
                </nav>
            </div>

            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-outline-secondary btn-sm" title="Back"><i data-feather="chevron-left"></i></button>
                <button class="btn btn-outline-primary btn-sm" title="{{ __('common.call') }}"><i data-feather="phone-call"></i></button>
                <button class="btn btn-outline-info btn-sm" title="{{ __('common.semail') }}"><i data-feather="mail"></i></button>
                <button class="btn btn-outline-danger btn-sm" id="sweet-id" title="{{ __('common.delete') }}"><i data-feather="trash"></i></button>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="card-title">Search</h5>
                <p class="text-muted mb-0">Fill the form to begin your search.</p>
            </div>

            <form method="POST" action="{{ route('search.result') }}" id="search" class="p-4">
                @csrf
                <div class="row g-4">
                    <div class="col-md-6">
                        <label for="value" class="form-label">Search Value</label>
                        <input type="text" name="value" id="value" class="form-control" placeholder="Enter value">
                    </div>

                    <div class="col-md-6">
                        <label for="key" class="form-label">Search For</label>
                        <select name="key" id="key" class="form-select">
                            <option value="order">Order No.</option>
                            <option value="coc">COC No.</option>
                            <option value="ncr">NCR No.</option>
                            <option value="rd">RD No.</option>
                            <option value="nrd">NRD No.</option>
                            @if(auth()->user()->department === 'management' || auth()->user()->sector === 'laboratory')
                                <option value="rft">RFT No.</option>
                            @endif
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i data-feather="search" class="me-1"></i> Search
                    </button>
                </div>
            </form>

            @isset($data)
                <div class="card-footer bg-white">
                    <div class="table-responsive">
                        <table class="table custom-table align-middle">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>No.</th>
                                <th>Customer</th>
                                <th>Branch</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $type === 'rft' ? $item->id : $item->tracking_no }}</td>
                                    <td>{{ $item->customer->fullName }} - {{ $item->customer->cName }}</td>
                                    <td>{{ $type === 'rft' ? $item->lab : $item->branch }}</td>
                                    <td>
                                        @switch($item->technicalStatus)
                                            @case(0) <span class="badge bg-primary">New</span> @break
                                            @case(1) <span class="badge bg-info">COC Draft</span> @break
                                            @case(2) <span class="badge bg-warning">NCR Draft</span> @break
                                            @case(3) <span class="badge bg-danger">COC Rejected</span> @break
                                            @case(4) <span class="badge bg-danger">NCR Rejected</span> @break
                                            @case(5) <span class="badge bg-success">COC Approved</span> @break
                                            @case(6) <span class="badge bg-success">NCR Approved</span> @break
                                            @case(7) <span class="badge bg-secondary">Archived</span> @break
                                            @default <span class="badge bg-dark">Unknown</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        <a href="{{ $type === 'rft' ? route('request.showrft', $item->id) : route('inspection.show', $item->id) }}"
                                           class="btn btn-sm btn-outline-primary">
                                            Select
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endisset
        </div>
    </div>
@endsection

@section('moreJs')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            feather.replace();
        });
    </script>
@endsection
