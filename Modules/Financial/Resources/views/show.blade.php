@extends('layouts.viho')
@section('body')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Financial Management</h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">{{ __('common.home') }}</a></li>
                        <li class="breadcrumb-item">Financial Management</li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ol>
                </div>
                <div class="col-sm-6">
                    <!-- Bookmark Start-->
                    <div class="bookmark">
                        <ul>
                            <li><a href="{{ route('user.index') }}" data-container="body" data-bs-toggle="popover" data-placement="top" title="" data-original-title="Tables"><i data-feather="inbox"></i></a></li>
                        </ul>
                    </div>
                    <!-- Bookmark Ends-->
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">

            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h5>Order Fee Calculation #{{ $order->tracking_no }}</h5><span>All values are automatically generated base on table of fees</span>
                    </div>
                    <form class="theme-form" method="post" action="{{ route('financial.store', $order->id) }}"  enctype="multipart/form-data">
                        @csrf
                    <div class="card-body">
                            <div class="row col-md-12">
                                <div class="col-md-6">
                                    <label class="col-form-label pt-0" for="in">Invoice No.</label>
                                    <input class="form-control" id="in" name="in" type="text" disabled value="{{ $order->piNo }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label pt-0" for="ia">Invoice Amount</label>
                                    <input class="form-control" id="ia" name="ia" type="text"  disabled value="{{ $order->invoiceValue }}">
                                </div>
                            </div>

                            <br>

                        <div class="row col-md-12">
                            <div class="col-md-6">
                                <label class="col-form-label pt-0" for="sd">No. of Shipments</label>
                                <input class="form-control" id="sd" name="sd" type="text"  disabled value="{{ $order->container }}">
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label pt-0" for="ipc">Invoice Amount per Shipment</label>
                                <input class="form-control" id="ipc" name="ipc" type="text"  disabled value="{{ $order->invoiceValue/$order->container }}" />
                            </div>
                        </div>


                        <br>
                        @php
                            // calculating coc fee
                                $ci = floatval(str_replace(',','',$order->invoiceValue));
                                $ci = intval(str_replace(',','',$ci));

                                if($ci<=80000) {
                                $cf = 320;
                                } elseif($ci>80000 and $ci<=200000) {
                                    $cf = 320+(0.004*($ci-80000));
                                } elseif($ci>200000 and $ci<=1000000) {
                                    $cf = 800+(0.003*($ci-200000));
                                } elseif($ci>1000000) {
                                    $cf = 3200+(0.0015*($ci-1000000));
                                }

                                if($order->shipmentType =='Bulk') {
                			            $x = 250;
                			            $bf = $order->container*$x;
                			         //   echo $bf;
                			        }

                			        elseif($order->shipmentType =='Packages' and $order->shipmentMethod =='Ship') {
                			             $x = 250;
                			            $bf = $order->container*$x;
                			        }
                			        else {
                			                $pc = floatval(str_replace(',','',$order->invoiceValue))/$order->container;

                    			            if($pc<=5000) {
                    			                $x = 50;
                        			        } elseif($pc>5000 and $pc<=10000) {
                        			            $x = 75;
                        			        } elseif($pc>10000) {
                        			            $x = 100;
                        			        }


                			            $bf = $order->container*$x;

                			          //  echo $bf;
                			        }
                        @endphp

                        <div class="row col-md-12" style="background: #24695C; padding-top: 10px;padding-bottom: 20px">
                            <div class="col-md-6">
                                <label class="col-form-label pt-0" for="" style="color:white">Estimated COC Fee</label>
                                <input class="form-control" type="text" value="{{ $cf }} USD" disabled>
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label pt-0" for="" style="color:white">Estimated Release Document Fee</label>
                                <input class="form-control" type="text" value="Total: {{ $bf }}, Each Part: {{ $x }}" disabled>
                                <input class="form-control" type="text" value="Total: {{ $bf }}, Each Part: {{ $x }}" disabled>
                            </div>
                        </div>

                        <br>

                        <div class="row col-md-12">
                                <div class="col-md-6">
                                    <label class="col-form-label pt-0" for="insFeePlace">COC Fee Paid at:</label>
                                    <select class="form-control" name="insFeePlace" id="insFeePlace" {{ $disabled }}>
                                        @if($order->insFeePlace)<option value="{{ $order->insFeePlace }}">{{ $order->insFeePlace }}</option>@endif
                                            <option value="Branch">Branch</option>
                                            <option value="Baghdad">Baghdad</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label pt-0" for="borderFeePlace">Release Document Fee Paid at:</label>
                                    <select class="form-control" name="borderFeePlace" id="borderFeePlace" {{ $disabled }}>
                                        @if($order->borderFeePlace)<option value="{{ $order->borderFeePlace }}">{{ $order->borderFeePlace }}</option>@endif
                                            <option value="Branch">Branch</option>
                                            <option value="Baghdad">Baghdad</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="col-form-label pt-0" for="cocPaymentMethod">COC Fee Payment Method:</label>
                                    <select class="form-control" name="cocPaymentMethod" id="cocPaymentMethod" {{ $disabled }}>
                                        @if($order->cocPaymentMethod)<option value="{{ $order->cocPaymentMethod }}">{{ $order->cocPaymentMethod }}</option>@endif
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Cash">Cash</option>
                                        <option value="Customer Credit">Customer Credit</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label pt-0" for="borderPaymentMethod">Release Document Fee Payment Method:</label>
                                    <select class="form-control" name="borderPaymentMethod" id="borderPaymentMethod" {{ $disabled }}>
                                        @if($order->borderPaymentMethod)<option value="{{ $order->borderPaymentMethod }}">{{ $order->borderPaymentMethod }}</option>@endif
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Cash">Cash</option>
                                        <option value="Customer Credit">Customer Credit</option>
                                    </select>
                                </div>
                            </div>

                        <div class="row col-md-12">
                            <label class="col-form-label pt-0" for="transactionNo">Transaction No.:</label>
                            <textarea name="transactionNo" class="form-control" {{ $disabled }}>{{ $order->transactionNo }}</textarea>
                        </div>

                            <br>


                            <div class="row col-md-12">
                                <label class="col-form-label pt-0" for="borderFeePlace">Notes:</label>
                                <textarea name="note" class="form-control" {{ $disabled }}>@if($order->finNote) {{ $order->finNote }} @elseif(auth()->user()->sector = 'financial' or auth()->user()->level = 'manager')Approved By {{ auth()->user()->name.' '.auth()->user()->lastname }}@endif</textarea>
                            </div>
                    </div>

                    <div class="card-footer">
                        @if($disabled == 'disabled')
                            <a href="{{ route('inspection.show', $order->id) }}" class="btn btn-success">Go Back</a>
                            <a href="{{ route('financial.receipt', $order->id) }}" class="btn btn-warning" target="_blank">Print Receipt</a>
                        @else
                            <input type="submit" class="btn btn-primary" value="Submit">
                            <a href="{{ route('financial.receipt', $order->id) }}" class="btn btn-warning" target="_blank">Print Receipt</a>
                        @endif
                    </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection
@section('moreJs')
    <!-- Plugins JS start-->
    <script src="{{ asset('theme/viho/assets/js/form-wizard/form-wizard.js')}}"></script>
    <script>
        document.getElementById('level').addEventListener('change', function() {
            var sector = document.getElementById('sector');
            var levelValue = this.value;

            // Clear existing options
            sector.innerHTML = '';

            // Determine options for the second select based on the first select value
            if (levelValue === 'br' || levelValue === 'brr') {
                appendOptgroups(sector, [
                    { label: 'Air Ports', options: ['Baghdad International Airport', 'Basrah International Airport', 'Najaf International Airport'] },
                    { label: 'Sea Ports', options: ['North Umm Al-Qasr Port', 'Middle Umm Al-Qasr Port', 'South Umm Al-Qasr Port', 'Abu Flous Port', 'Al-Maqal Port', 'Khor Al-Zubair Port'] },
                    { label: 'LAND', options: ['Rabia', 'Trebil', 'Zurbatiyah', 'Mandali', 'Arar', 'Shalamcheh', 'Muntheria', 'Sheep', 'Safwan', 'Ibrahim Al-Khaleel', 'Haj Imran', 'Bashmakh', 'Parviz Khan', 'Al Qaim'] }
                ]);
            } else if (levelValue === 'brn') {
                // Populate the list of all countries in the second select
                populateCountries(sector);
            }
        });

        function appendOptgroups(select, optgroups) {
            optgroups.forEach(optgroup => {
                var optgroupElem = document.createElement('optgroup');
                optgroupElem.label = optgroup.label;
                optgroup.options.forEach(optionValue => {
                    var optionElem = document.createElement('option');
                    optionElem.value = optionValue;
                    optionElem.text = optionValue;
                    optgroupElem.appendChild(optionElem);
                });
                select.appendChild(optgroupElem);
            });
        }

        function populateCountries(select) {
            // Here you can populate the list of all countries
            // For the purpose of this example, let's just add a few countries
            var countries = [
                "Afghanistan",
                "Albania",
                "Algeria",
                "Andorra",
                "Angola",
                "Antigua and Barbuda",
                "Argentina",
                "Armenia",
                "Australia",
                "Austria",
                "Azerbaijan",
                "Bahamas",
                "Bahrain",
                "Bangladesh",
                "Barbados",
                "Belarus",
                "Belgium",
                "Belize",
                "Benin",
                "Bhutan",
                "Bolivia",
                "Bosnia and Herzegovina",
                "Botswana",
                "Brazil",
                "Brunei",
                "Bulgaria",
                "Burkina Faso",
                "Burundi",
                "Côte d'Ivoire",
                "Cabo Verde",
                "Cambodia",
                "Cameroon",
                "Canada",
                "Central African Republic",
                "Chad",
                "Chile",
                "China",
                "Colombia",
                "Comoros",
                "Congo (Congo-Brazzaville)",
                "Costa Rica",
                "Croatia",
                "Cuba",
                "Cyprus",
                "Czechia (Czech Republic)",
                "Democratic Republic of the Congo",
                "Denmark",
                "Djibouti",
                "Dominica",
                "Dominican Republic",
                "Ecuador",
                "Egypt",
                "El Salvador",
                "Equatorial Guinea",
                "Eritrea",
                "Estonia",
                "Eswatini",
                "Ethiopia",
                "Fiji",
                "Finland",
                "France",
                "Gabon",
                "Gambia",
                "Georgia",
                "Germany",
                "Ghana",
                "Greece",
                "Grenada",
                "Guatemala",
                "Guinea",
                "Guinea-Bissau",
                "Guyana",
                "Haiti",
                "Holy See",
                "Honduras",
                "Hungary",
                "Iceland",
                "India",
                "Indonesia",
                "Iran",
                "Iraq",
                "Ireland",
                "Israel",
                "Italy",
                "Jamaica",
                "Japan",
                "Jordan",
                "Kazakhstan",
                "Kenya",
                "Kiribati",
                "Kuwait",
                "Kyrgyzstan",
                "Laos",
                "Latvia",
                "Lebanon",
                "Lesotho",
                "Liberia",
                "Libya",
                "Liechtenstein",
                "Lithuania",
                "Luxembourg",
                "Madagascar",
                "Malawi",
                "Malaysia",
                "Maldives",
                "Mali",
                "Malta",
                "Marshall Islands",
                "Mauritania",
                "Mauritius",
                "Mexico",
                "Micronesia",
                "Moldova",
                "Monaco",
                "Mongolia",
                "Montenegro",
                "Morocco",
                "Mozambique",
                "Myanmar (formerly Burma)",
                "Namibia",
                "Nauru",
                "Nepal",
                "Netherlands",
                "New Zealand",
                "Nicaragua",
                "Niger",
                "Nigeria",
                "North Korea",
                "North Macedonia",
                "Norway",
                "Oman",
                "Pakistan",
                "Palau",
                "Palestine State",
                "Panama",
                "Papua New Guinea",
                "Paraguay",
                "Peru",
                "Philippines",
                "Poland",
                "Portugal",
                "Qatar",
                "Romania",
                "Russia",
                "Rwanda",
                "Saint Kitts and Nevis",
                "Saint Lucia",
                "Saint Vincent and the Grenadines",
                "Samoa",
                "San Marino",
                "Sao Tome and Principe",
                "Saudi Arabia",
                "Senegal",
                "Serbia",
                "Seychelles",
                "Sierra Leone",
                "Singapore",
                "Slovakia",
                "Slovenia",
                "Solomon Islands",
                "Somalia",
                "South Africa",
                "South Korea",
                "South Sudan",
                "Spain",
                "Sri Lanka",
                "Sudan",
                "Suriname",
                "Sweden",
                "Switzerland",
                "Syria",
                "Tajikistan",
                "Tanzania",
                "Thailand",
                "Timor-Leste",
                "Togo",
                "Tonga",
                "Trinidad and Tobago",
                "Tunisia",
                "Turkey",
                "Turkmenistan",
                "Tuvalu",
                "Uganda",
                "Ukraine",
                "United Arab Emirates",
                "United Kingdom",
                "United States of America",
                "Uruguay",
                "Uzbekistan",
                "Vanuatu",
                "Venezuela",
                "Vietnam",
                "Yemen",
                "Zambia",
                "Zimbabwe"
            ];
            countries.forEach(country => {
                var optionElem = document.createElement('option');
                optionElem.value = country;
                optionElem.text = country;
                select.appendChild(optionElem);
            });
        }
    </script>
    <!-- Plugins JS Ends-->
@endsection
