<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Table</title>
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
        h1 {
            text-align: center;
        }
        h3 {
            text-align: center;
            color: #555;
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

<h1>FINANCIAL RECEIPT</h1>
<h3>Date: {{ $order->finAppDate }}</h3>

<table>
    <tbody>
    <tr>
        <td><strong>RFI No.:</strong></td>
        <td>{{ $order->tracking_no }}</td>
    </tr>
    <tr>
        <td><strong>PI No.:</strong></td>
        <td>{{ $order->piNo }}</td>
    </tr>
    <tr>
        <td><strong>Customer:</strong></td>
        <td>{{ $order->customer->fullName.', '.$order->customer->cName }}</td>
    </tr>
    <tr>
        <td><strong>Exporter:</strong></td>
        <td>{{ $order->exporter }}</td>
    </tr>
    <tr>
        <td><strong>COC Fee:</strong></td>
        <td>{{ $order->insFee }}</td>
    </tr>
    <tr>
        <td><strong>COC Fee Payment Method:</strong></td>
        <td>{{ $order->cocPaymentMethod }}</td>
    </tr>
    <tr>
        <td><strong>COC Fee Payment Place:</strong></td>
        <td>{{ $order->insFeePlace }} - @if($order->insFeePlace == 'Branch') {{ $order->branch }} @endif</td>
    </tr>
    <tr>
        <td><strong>Total Border Fee:</strong></td>
        <td>{{ $order->borderFeeTotal }}</td>
    </tr>
    <tr>
        <td><strong>Border Fee Payment Method:</strong></td>
        <td>{{ $order->borderPaymentMethod }}</td>
    </tr>
    <tr>
        <td><strong>Border Fee Payment Place:</strong></td>
        <td>{{ $order->borderFeePlace }} - @if($order->borderFeePlace == 'Branch') {{ $order->branch }} @endif</td>
    </tr>
    <tr>
        <td><strong>Transaction No.:</strong></td>
        <td>{{ $order->transactionNo }}</td>
    </tr>
    </tbody>
</table>

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
