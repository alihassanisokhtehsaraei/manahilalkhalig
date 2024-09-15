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

<h1>نموذج رقم 8</h1>
<h3>تقرير الفحص داخل العراق</h3>
<h4>Border Fee Report</h4>
<h4>From {{ $startDate }} to {{ $endDate }}</h4>

<table>
    <thead>
    <tr>
        <th>No.</th>
        <th>COC No.</th>
        <th>Date of Issuance</th>
        <th>Shipment cost in USD (Invoice Value)</th>
        <th>No. of Container or Trucks</th>
        <th>Declared Value per Container or truck </th>
        <th>Unit Fee</th>
        <th>Levied Wages (Total Border Fee)</th>
        <th>COSQC SHARE</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->certNo }}</td>
            <td>{{ $item->issuingDate }}</td>
            <td>{{ $item->invUSD }}</td>
            <td>{{ $item->containerDetails }}</td>
            <td>{{ $item->invValPerTruck }}</td>

            <!-- Use optional() to avoid errors -->
            <td>{{ optional($item)->borderFeeEach ?? 'N/A' }}</td>
            <td>{{ optional($item)->borderFeeTotal ?? 'N/A' }}</td>

            <td>-</td>
        </tr>
    @endforeach
    <!-- Add more rows as needed -->
    </tbody>
</table>


</body>
</html>
