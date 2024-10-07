<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Table</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
        }
        .header-details {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            font-size: 16px;
        }
        .signature-section {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
        }
        .signature {
            border-top: 1px solid #000;
            width: 200px;
            text-align: center;
            margin-top: 10px;
        }
        .stamp {
            border: 2px dashed #000;
            width: 120px;
            height: 120px;
            margin-top: 10px;
            text-align: center;
            line-height: 120px;
            font-size: 16px;
            color: #888;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>FINANCIAL RECEIPT RFT #{{ $rft->id }}</h1>
</div>

<div class="header-details">
    <div><strong>Applicant:</strong> {{ $rft->applicantName }}</div>
    <div><strong>Date:</strong> {{ $rft->finAppDate }}</div>
</div>

<table>
    <thead>
    <tr>
        <th>Item No.</th>
        <th>Sample Desc</th>
        <th>Quantity</th>
        <th>Fee Price</th>
        <th>Total Price</th>
    </tr>
    </thead>
    <tbody>
    @php
        $taxPercent = 10;
    @endphp
    @foreach($samples as $sample)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $sample->arabic_name.' - '.$sample->english_name }}<br>{{ $sample->desc }}</td>
            <td>{{ $sample->quantity }}</td>
            <td>{{ $sample->fee }}</td>
            <td>{{ $sample->fee * $sample->quantity }}</td>
        </tr>
    @endforeach
    <tr>
        <td colspan="4" style="text-align: right;"><strong>Subtotal:</strong></td>
        <td>{{ $rft->subSum }}</td>
    </tr>
    <tr>
        <td colspan="4" style="text-align: right;"><strong>Tax ({{ $taxPercent }}%):</strong></td>
        <td>{{ ($rft->subSum*$taxPercent)/100 }}</td>
    </tr>
    <tr>
        <td colspan="4" style="text-align: right;"><strong>Total:</strong></td>
        <td>{{ $rft->totalFee }}</td>
    </tr>
    </tbody>
</table>

<div class="payment-info">
    <p><strong>Place of Payment:</strong> {{ $rft->labFeePlace }} - @if($rft->labFeePlace == 'Branch') {{ $rft->office }} @elseif ($rft->labFeePlace == 'Laboratory') {{ $rft->lab }}@endif</p>
    <p><strong>Method of Payment:</strong> {{ $rft->labPaymentMethod }}</p>
    <p><strong>Transaction No.:</strong> {{ $rft->transactionNo }}</p>
</div>

<div class="signature-section">
    <div>
        <div>Name:</div>
        <div class="signature">Signature</div>
    </div>
    <div>
        <div class="stamp">STAMP</div>
    </div>
</div>

</body>
</html>
