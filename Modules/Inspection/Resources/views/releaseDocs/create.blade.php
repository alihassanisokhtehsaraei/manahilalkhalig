@extends('layouts.viho')

@section('moreCSS')
    <!-- Plugins CSS start-->
    <link rel="stylesheet" type="text/css" href="{{ asset('viho/assets/css/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('viho/assets/css/sweetalert2.css') }}">
    <!-- Plugins CSS Ends-->
@endsection
<style>
    .custom-form-container {
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #f9f9f9;
    }

    .custom-form-group {
        margin-bottom: 20px;
    }

    .custom-label {
        font-size: 14px;
        color: #333;
        font-weight: bold;
    }

    .custom-textarea, .custom-select, .custom-input {
        border-color: #ccc;
        margin-top: 5px;
        width: 100%;
    }

    .custom-submit-button {
        background-color: #007bff;
        color: #fff;
        font-weight: bold;
        border-radius: 4px;
        border: none;
        margin-bottom: 10px;
    }
</style>

@section('body')
    <div class="custom-form-container p-3 m-3"> <!-- Add a custom container class -->
        <form action="{{ route('rdocs.store', ['order' => $order]) }}" enctype="multipart/form-data" method="post"
              accept-charset="utf-8">
            @csrf
            <div class="col-md-12">
                <br>
                <div class="form-group custom-form-group">
                    <label for="following_checks" class="custom-label"><strong>Following checks have been carried out
                            with satisfactory results:</strong></label>
                    <textarea class="form-control custom-textarea" rows="8" name="following_checks"
                              id="following_checks" required>• Authentication of the certificate attached to this release document.
• Verification of the matching between certificate, import document and goods.
• Integrity of seals (whenever applicable).
• Check the condition of the shipment (no damage of overall containers,(no damage of goods and ensuring that the chilled or frozen goods are in refrigerate containers).</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group custom-form-group">
                            <label for="containers_details_not_mentioned" class="custom-label"><strong>Containers /
                                    Packages details not mentioned on certificate (if any):</strong></label>
                            <textarea class="form-control custom-textarea" rows="3" placeholder="Enter ..."
                                      name="containers_details_not_mentioned"
                                      id="containers_details_not_mentioned"></textarea>
                        </div>

                        <div class="form-group custom-form-group">
                            <label for="import_documents_not_mentioned" class="custom-label"><strong>Import Documents
                                    not mentioned on certificate (if any):</strong></label>
                            <textarea class="form-control custom-textarea" rows="3" placeholder="Enter ..."
                                      name="import_documents_not_mentioned"
                                      id="import_documents_not_mentioned"></textarea>
                        </div>

                        <div class="form-group custom-form-group">
                            <label for="number_of_items" class="custom-label"><strong>Number of line
                                    items:</strong></label>
                            <textarea class="form-control custom-textarea" rows="3" placeholder="Enter ..."
                                      name="number_of_items" id="number_of_items"></textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group custom-form-group">
                            <label for="shipment_type" class="custom-label"><strong>Shipment type:</strong></label>
                            <select class="form-control custom-select" name="shipment_type" id="shipment_type">
                                <option value="Full Container">Full Container</option>
                                <option value="Partial Container">Partial Container</option>
                                <option value="Trucks">Trucks</option>
                                <option value="Packages">Packages</option>
                            </select>
                        </div>

                        <div class="form-group custom-form-group">
                            <label for="shipment_details" class="custom-label"><strong>Shipment
                                    details:</strong></label>
                            <select class="form-control custom-select" name="shipment_details" id="shipment_details">
                                <optgroup label="Select one">
                                    <option value="Complete">Complete</option>
                                    <option value="Partial">Partial</option>
                                </optgroup>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group custom-form-group">
                                    <label for="total_quantity" class="custom-label"><strong>Total
                                            Quantity:</strong></label>
                                    <input type="number" readonly name="total_quantity" class="custom-input"
                                           value="{{ $order->container }}" id="total_quantity"
                                           style="text-align:center">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group custom-form-group">
                                    <label for="incoming_quantity" class="custom-label"><strong>Incoming
                                            Quantity:</strong></label>
                                    <input type="number" name="incoming_quantity" id="incoming_quantity"
                                           class="custom-input" style="text-align:center">
                                    @error('incoming_quantity')
                                    <span class="text-danger bold">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group custom-form-group">
                                    <label for="remaining_quantity" class="custom-label"><strong>Remaining
                                            Quantity:</strong></label>
                                    <input type="number" readonly name="remaining_quantity" id="remaining_quantity"
                                           class="custom-input" style="text-align:center">
                                </div>
                            </div>
                        </div>

                        <div class="form-group custom-form-group">
                            <label for="comments" class="custom-label"><strong>Comments:</strong></label>
                            <textarea class="form-control custom-textarea" rows="3" placeholder="Enter ..."
                                      name="comments" id="comments"></textarea>
                        </div>
                    </div>
                </div>

                <input type="submit" style="float:right" class=" mb-3 btn btn-primary custom-submit-button"
                       name="submit" value="Submit">
            </div>
        </form>
    </div>
@endsection

@section('moreJs')
    <script>
        // Function to calculate and update remaining quantity
        function calculateRemainingQuantity() {
            // Get the incoming quantity from input field
            let incomingQuantity = parseFloat(document.getElementById('incoming_quantity').value) || 0;

            // Get total container quantity from input field
            let totalQuantity = parseFloat(document.getElementById('total_quantity').value) || 0;

            // Get the sum of previously added incoming quantities (from backend)
            let sumPreviousIncoming = {{ $order->releaseDocuments->map(fn($doc) => $doc->incoming_quantity)->sum() + $order->nonReleaseDocuments->map(fn($doc) => $doc->incoming_quantity)->sum() }};

            // Calculate the remaining quantity
            let remainingQuantity = totalQuantity - (sumPreviousIncoming + incomingQuantity);

            // Update the remaining quantity field
            document.getElementById('remaining_quantity').value = remainingQuantity >= 0 ? remainingQuantity : 0;
        }

        // Calculate remaining quantity on page load
        document.addEventListener('DOMContentLoaded', function () {
            calculateRemainingQuantity(); // Initial calculation on load
        });

        // Recalculate remaining quantity whenever incoming quantity changes
        document.getElementById('incoming_quantity').addEventListener('input', function () {
            calculateRemainingQuantity(); // Recalculate on input change
        });
    </script>
@endsection
