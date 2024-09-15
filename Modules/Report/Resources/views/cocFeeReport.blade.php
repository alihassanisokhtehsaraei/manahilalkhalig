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
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            text-align: center;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
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

<h1>نموذج رقم 7</h1>
<h3>التقرير المالي الصدار الشهادات</h3>
<h4>COC Fee Report</h4>
<h4>From {{ $startDate }} to {{ $endDate }}</h4>

<table>
    <thead>
    <tr>
        <th>No.</th>
        <th>COC No.</th>
        <th>Date of Issuance</th>
        <th>Invoice Cost Original Currency</th>
        <th>Invoice Cost USD</th>
        <th>Levied Wages (COC Fee) USD</th>
        <th>COSQC Share 32% USD</th>
        <th>Issuing Country</th>
        <th>Type of Goods</th>
        <th>No. of Container or Trucks</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->certNo }}</td>
            <td>{{ $item->issuingDate }}</td>
            <td>{{ $item->invAmount.' '.$item->invCurrency }}</td>
            <td>{{ $item->invUSD }}</td>
            <td>{{ optional($item)->insFee ?? 'N/A' }}</td>
            <td>{{ optional($item)->insFee ? ($item->insFee * 32 / 100) : 'N/A' }}</td>
            <td>{{ $item->issuingPlace }}</td>
            <td>{{ $item->category }}</td>
            <td>{{ $item->containerDetails }}</td>
        </tr>
    @endforeach
    <!-- Add more rows as needed -->
    </tbody>
</table>


</body>
</html>
