<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تقرير الفحص</title>
    <style>
        body {
            font-family: "Adobe Arabic", sans-serif;
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
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        h1, h3, h4 {
            text-align: center;
        }
    </style>
</head>
<body>

<h1>نموذج رقم 8/1</h1>
<h3>تقرير لوثائق االطالق</h3>
<h4>Report For Release Documents</h4>
<h4>From {{ $startDate }} to {{ $endDate }}</h4>

<table>
    <thead>
    <tr>
        <th>No.</th>
        <th>COC No.</th>
        <th>Date of Issuance</th>
        <th>RD No.</th>
        <th>Date of RD</th>
        <th>Country of Issuance</th>
        <th>Declared Point of Entry</th>
        <th>Shipment cost in USD (Invoice Value)</th>
        <th>Type of Goods</th>
        <th>No. of Container or Trucks</th>
        <th>No. of incoming Shipment</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->coc->certNo }}</td>
            <td>{{ $item->coc->issuingDate }}</td>
            <td>{{ $item->document_number }}</td>
            <td>{{ $item->issuance_date }}</td>
            <td>{{ $item->coc->issuingPlace }}</td>
            <td>{{ $item->issuing_office}}</td>
            <td>{{ $item->coc->invUSD }}</td>
            <td>{{ $item->coc->order->category }}</td>
            <td>{{ $item->coc->containerDetails }}</td>
            <td>{{ $item->incoming_quantity }}</td>
        </tr>
    @endforeach
    <!-- Add more rows as needed -->
    </tbody>
</table>


</body>
</html>
