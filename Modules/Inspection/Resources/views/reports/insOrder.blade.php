<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inspection Order {{ $data->globalcounter->trackingID }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            margin: 20px;
            line-height: 1.6;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
        }
        tr {
            page-break-inside: avoid;
        }
        .document-number {
            visibility: visible;
            font-size: 12px;
            color: #666;
            text-align: center;
            page-break-before: always;
        }

        @media print {
            .document-number {
                position: fixed;
                bottom: 0;
                left: 50%; /* Center horizontally */
                transform: translateX(-50%);
                visibility: visible;
            }

            /* Define a counter for the page number */
            body {
                counter-reset: page;
            }

            /* Increment the page counter on page breaks */
            @page {
                @bottom-center {
                    content: "Page " counter(page);
                }
            }

        }

        .heading {
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <h2 style="text-align: center">Inspection Order</h2>
    <div class="date">Date: {{ $data->date }}</div>
    <div class="heading">
        <p>
            <input type="checkbox" @if($data->insType == 'PSI') checked @endif disabled> PSI (IC)
            <input type="checkbox" @if($data->insType == 'COI') checked @endif disabled> COI
            <input type="checkbox" @if($data->insType == 'P.V.') checked @endif disabled> P.V.
            <input type="checkbox" @if($data->insType == 'Exporting Product') checked @endif disabled> Exporting Product
            <input type="checkbox" @if($data->insType == 'Mineral' or $data->insType == 'LC') checked @endif disabled> Other
        </p>
    </div>
    <table>
            <tr>
                <td><strong>File No.:</strong> {{ $data->globalcounter->trackingID }}</td>
                <td><strong>Description Of Goods:</strong> {{ $data->goods }}</td>
            </tr>
            <tr>
                <td><strong>Quantity:</strong> {{ $data->quantity }}</td>
                <td><strong>Type Of Packing:</strong> {{ $data->packing }}</td>
            </tr>
            <tr>
                <td><strong>Client No.:</strong> {{ $data->customer->id }}</td>
                <td><strong>Clients Name And Address:</strong> {!! $data->customer->fullName.', '.$data->customer->cName.' <br> '.$data->customer->address.', '.$data->customer->stateCity.' - '.$data->customer->country !!}</td>
            </tr>
            <tr>
                <td><strong>Supplier:</strong> {{ $data->supplier }}</td>
                <td><strong>Country Of Origin:</strong> {{ $data->origin }}</td>
            </tr>
            <tr>
                <td><strong>Manufacturer: </strong> {{ $data->manufacturer }}</td>
                <td><strong>Inspection Place: </strong> {{ $data->insPlace }}</td>
            </tr>
            <tr>
                <td><strong>P/I No. / Invoice No.: </strong> {{ $data->piNo }}</td>
                <td><strong>Estimated Inspection Date: </strong> {{ $data->eid }}</td>
            </tr>
            <tr>
                <td><strong>Vessel Name: </strong> {{ $data->vessel }}</td>
                <td><strong>Estimated Arrival Time Of Vessel (Eta): </strong> {{ $data->eta }}</td>
            </tr>
            <tr>
                <td><strong>Lc No.: </strong> {{ $data->lcNo }}</td>
                <td><strong>Contact Person: </strong> {{ $data->contactPerson }}</td>
            </tr>
            <tr>
                <td colspan="2"><strong>Scope of Inspection: </strong></td>
            </tr>

            <tr>
                <td><input type="checkbox" @if($data->scopeVI == 1) checked @endif disabled> Visual Inspection</td>
                <td><input type="checkbox" @if($data->scopeHT == 1) checked @endif disabled> Hold/Tank Inspection</td>
            </tr>
            <tr>
                <td><input type="checkbox" @if($data->scopeQCR == 1) checked @endif disabled> Quantity Check At Random (Unless Requested For Full Check) </td>
                <td><input type="checkbox" @if($data->scopeDSU == 1) checked @endif disabled> Draft Survey </td>
            </tr>
            <tr>
                <td><input type="checkbox" @if($data->scopeQVB == 1) checked @endif disabled> Quality On Visual Basis </td>
                <td><input type="checkbox" @if($data->scopeUS == 1) checked @endif disabled> Ullage Survey </td>
            </tr>
            <tr>
                <td><input type="checkbox" @if($data->scopeSample == 1) checked @endif disabled> Sampling</td>
                <td><input type="checkbox" @if($data->scopeBS == 1) checked @endif disabled> Bunker Survey</td>
            </tr>
            <tr>
                <td><input type="checkbox" @if($data->scopeMD == 1) checked @endif disabled> Moisture Determination</td>
                <td><input type="checkbox" @if($data->scopeTA == 1) checked @endif disabled> Testing And Analysis</td>
            </tr>
            <tr>
                <td><input type="checkbox" @if($data->scopeSS == 1) checked @endif disabled> Sealing Samples</td>
                <td><input type="checkbox" @if($data->scopeOFF == 1) checked @endif disabled> On/Off Hire Survey </td>
            </tr>
            <tr>
                <td><input type="checkbox" @if($data->scopeWT == 1) checked @endif disabled> Witness Of Testing </td>
                <td><input type="checkbox" @if($data->scopeCS == 1) checked @endif disabled> Crane Survey </td>
            </tr>
            <tr>
                <td><input type="checkbox" @if($data->scopeSOL == 1) checked @endif disabled> Supervision Of Loading </td>
                <td><input type="checkbox" @if($data->scopeBSU == 1) checked @endif disabled> Barge Survey </td>
            </tr>
            <tr>
                <td><input type="checkbox" @if($data->scopeSOD == 1) checked @endif disabled> Supervision Of Discharging </td>
                <td><input type="checkbox" @if($data->scopePhoto == 1) checked @endif disabled> Photography</td>
            </tr>
            <tr>
                <td><input type="checkbox" @if($data->scopePacking == 1) checked @endif disabled> Packing</td>
                <td><input type="checkbox" @if($data->scopeLC == 1) checked @endif disabled> Lashing/Choking </td>
            </tr>
            <tr>
                <td><input type="checkbox" @if($data->scopeMarking == 1) checked @endif disabled> Marking</td>
                <td><input type="checkbox" @if($data->scopeRM == 1) checked @endif disabled> Raw Material Inspection </td>
            </tr>
            <tr>
                <td><input type="checkbox" @if($data->scopeCI == 1) checked @endif disabled> Container Inspection </td>
                <td><input type="checkbox" @if($data->scopeRSD == 1) checked @endif disabled> Review Of Shipping Documents </td>
            </tr>
            <tr>
                <td><input type="checkbox" @if($data->scopeSC == 1) checked @endif disabled> Sealing Container </td>
                <td><input type="checkbox" @if($data->scopeCIS == 1) checked @endif disabled> Coating Inspection</td>
            </tr>
            <tr>
                <td><input type="checkbox" @if($data->scopeDS == 1) checked @endif disabled> Damage Survey</td>
                <td><input type="checkbox" @if($data->scopeRT == 1) checked @endif disabled> Review Of Testing Result/Quality Documents</td>
            </tr>
            <tr>
                <td> </td>
                <td><input type="checkbox" @if($data->video == 1) checked @endif disabled> Video</td>
            </tr>
            <tr>
                <td colspan="2"><strong>Remarks:</strong> {{ $data->remark }}</td>
            </tr>
            <tr>
                <td colspan="2"><strong>Applicable Standard for Sampling:</strong> {{ $data->applicableStandardSampling }}</td>
            </tr>
            <tr>
                <td colspan="2"><strong>Applicable Standard(s) for Testing:</strong> {{ $data->applicableStandardTesting }}</td>
            </tr>
            <tr>
                <td colspan="2"><strong>Safety Equipment:</strong> {{ $data->safetyEquipment }}</td>
            </tr>
            <tr>
                <td colspan="2"><strong>Inspection Equipment:</strong> {{ $data->InspectionEquipment }}</td>
            </tr>
            <tr>
                <td colspan="2"><strong>Status Of Lab (IEC/ISO 17025:2017 Certificate):</strong> {{ $data->labStatus }}</td>
            </tr>
            <tr>
                <td colspan="2"><strong>Accreditation Certificate’s No.:</strong> {{ $data->labCertNo }}</td>
            </tr>
            <tr>
                <td colspan="2"><strong>Lab’s Name:</strong> {{ $data->labName }}</td>
            </tr>
            <tr>
                <td colspan="2"><strong>Contractor’s Name:</strong> {{ $data->contractorName }}</td>
            </tr>
            <tr>
                <td colspan="2"><strong>Remark:</strong> {{ $data->remark2 }}</td>
            </tr>
            <tr>
                <td colspan="2"><strong>Note 1:</strong> {{ $data->note1 }}</td>
            </tr>
            <tr>
                <td colspan="2"><strong>Note 2:</strong> {{ $data->note2 }}</td>
            </tr>
        </table>
        <div class="document-number">No. :FR-IN-GE-12 Version : 04</div>
        </div>
    </body>
</html>
