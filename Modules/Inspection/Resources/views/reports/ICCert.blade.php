<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style>
        body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            background-color: #FAFAFA;
            font: 12pt "Calibri";
            background:white;
        }
        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }
        .main{
            position:relative;
            height:auto;
            background:white;
        }
        .page {
            width: 210mm;
            min-height: 297mm;
            padding: 20mm;
            margin: 10mm auto;
            background:white;
            /*
            border: 1px #D3D3D3 solid;
            border-radius: 5px;
            background: red;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);*/

        }
        .subpage {
            padding: 1cm;
            border: 5px red solid;
            height: 257mm;
            outline: 2cm #333 solid;
        }

        .title{
            position:absolute;
            top:42mm;
            left:68mm;
            font-family:"Calibri";
            font-weight:bold;
            font-size:14pt;}
        .box{
            position:absolute;
            top:50mm;
            left:13.5mm;
            width: 181mm;

            height:!important;
            padding-bottom:3mm;

        }

        .myfirstrow{
            position:relative;
            width:100%;
            min-height:53mm;

            border-top:0.5mm solid black;
            border-right:0.3mm solid black;
            border-left:0.3mm solid black;
        }
        @page {
            size: A4;
            margin: 0;
        }

        .pur{position:relative;
            width:180mm;
            font-family:"Calibri";
            font-size:9pt;
            line-height:12pt;
            padding:0.5mm 2mm;
            border-bottom:0.25mm solid black;
            text-align:justify}

        .left_col{
            position:relative;
            width:91mm;
            border-right:0.25mm solid black;
            min-height:53mm;
            float:left;
            font-family:"Calibri";
            font-size:9pt;
            line-height:14.5pt;}

        .right_col{
            position:relative;
            width:89mm;
            float:right;
            font-family:"Calibri";
            font-size:9pt;
            line-height:12pt;
            min-height:inherit;}

        .t1{
            position: absolute;
            font-size: 10pt;
            left:125mm;
            top:22.6mm;

        }
        .t2{
            position: absolute;
            font-size: 10pt;
            left:125mm;
            top:28.5mm;

        }

        .lr_1{
            position:absolute;
            top:45mm;
            left:17mm;
            padding:0.5mm 2mm;
            height:5mm;
            font-size:8pt;
            font-weight:bold;
            /*border-bottom:0.25mm solid black;*/
        }
        .lr_2{
            padding:0.5mm 2mm;
            min-height:15mm;
            border-bottom:0.25mm solid black;}

        .lr_3{
            padding:0.5mm 2mm;
            min-height:5mm;
            border-bottom:0.25mm solid black;
        }
        .lr_3man{
            padding:0.5mm 2mm;
            min-height:5mm;
            border-bottom:0.25mm solid black;
        }
        .lr_4{
            padding:0.5mm 2mm;
            min-height:5mm;
            border-bottom:0.25mm solid black;
        }
        .lr_5{
            padding:0.5mm 2mm;
            min-height:5mm;
            border-bottom:0.25mm solid black;
        }
        .lr_6{
            padding:0.5mm 2mm;
            min-height:5mm;
            border-bottom:0.25mm solid black;
        }
        .lr_7{
            padding:0.5mm 2mm;
            min-height:5mm;
            border-bottom:0.25mm solid black;
        }
        .lr_8{
            padding:0.5mm 2mm;
            min-height:5mm;
            /*border-bottom:0.5mm solid black;*/
        }
        .lr_9{
            padding:0.5mm 2mm;
            min-height:5mm;
        }


        .rr_1{
            padding:0.5mm 2mm;
            height:5mm;
            border-bottom:0.25mm solid black;
        }

        .rr_2{
            padding:0.5mm 2mm;
            min-height:5mm;
            border-bottom:0.25mm solid black;}

        .rr_3{
            padding:0.5mm 2mm;
            min-height:5mm;
            border-bottom:0.25mm solid black;}

        .rr_4{
            padding:0.5mm 2mm;
            min-height:5mm;
            border-bottom:0.25mm solid black;
        }

        .rr_5{
            padding:0.5mm 2mm;
            min-height:5mm;
            border-bottom:0.25mm solid black;
        }

        .rr_6{
            min-height:5mm;
            border-bottom:0.25mm solid black;
        }
        .rrinnercol6_l{
            padding:0.5mm 2mm;
            position:relative;
            width:38mm;
            float:left;
            height:5mm;
            border-right:0.25mm solid black;
        }

        .rrinnercol6_r{
            padding:0.5mm 2mm;
            position:relative;
            width:45mm;
            float:left;
        }
        .rr_7{
            padding:0.5mm 2mm;
            min-height:6mm;
            border-bottom:0.25mm solid black;
        }

        .rrinnercol7_l{
            padding:0.5mm 2mm;
            position:relative;
            width:45mm;
            float:left;
            height:4mm;
            border-right:0.25mm solid black;
        }

        .rrinnercol7_r{
            padding:0.5mm 2mm;
            position:relative;
            width:38mm;
            float:left;
        }
        .rr_8{
            padding:0.5mm 2mm;
            min-height:6mm;
            border-bottom:0.25mm solid black;
        }

        .rr_81{
            padding:0.5mm 2mm;
            min-height:6mm;
            border-bottom:0.25mm solid black;
        }
        .rr_82{
            padding:0.5mm 2mm;
            min-height:6mm;
            border-bottom:0.25mm solid black;
        }
        .rr_83{
            padding:0.5mm 2mm;
            min-height:6mm;
            border-bottom:0.25mm solid black;
        }

        .rr_9{
            padding:0.5mm 2mm;
            min-height:5mm;
            border-bottom:0.25mm solid black;
        }

        .rr_10{
            padding:0.5mm 2mm;
            min-height:5mm;
        }




        .goodsheader_row{
            position:relative;
            width: 180.0mm;
            height:1mm;
            border-top:0.5mm solid black;
            background-color:#c0c0c0;
            text-align:center;
            font-family:"Calibri";
            font-size:6.5pt;
            line-height:0pt;
            border-bottom:0mm solid black;
        }
        .ghr_c1{
            width:10mm;
            height:8mm;
            padding-top:2mm;
            border-right:0.3mm solid black;
            float:left;}
        .ghr_c2{
            width:114mm;
            height:8mm;
            padding-top:2mm;
            border-right:0.3mm solid black;
            float:left;}
        .ghr_c4{
            width:25mm;
            height:8mm;
            padding-top:2mm;
            border-right:0.3mm solid black;
            float:left;}
        .ghr_c5{
            width:30mm;
            height:8mm;
            padding-top:2mm;
            float:left;}


        .goodsheader2_row{
            position:relative;
            width: 179.25mm;
            min-height:7mm;
            border-top:0.5mm dotted black;
            text-align:center;
            font-family:"Calibri";
            font-size:9pt;
            line-height:10pt;
            text-transform:uppercase;
            vertical-align:middle;
        }

        .ghr2_c1{
            width:11mm;
            min-height:9mm;
            padding-top:2mm;
            border-right:0.5mm solid black;
            float:left;}
        .ghr2_c2{
            width:66mm;
            min-height:9mm;
            padding-top:2mm;
            border-right:0.5mm solid black;
            float:left;}
        .ghr2_c3{
            width:14mm;
            min-height:9mm;
            padding-top:2mm;
            border-right:0.5mm solid black;
            float:left;
            padding-bottom:1mm;}
        .ghr2_c4{
            width:36mm;
            min-height:9mm;
            padding-top:2mm;
            border-right:0.5mm solid black;
            float:left;}
        .ghr2_c5{
            width:52mm;
            min-height:9mm;
            padding-top:2mm;
            float:left;}

        .goodsbody_row{
            position:relative;
            width: 180mm;
            border-top:0.5mm solid black;
            /*		border-bottom:0.5mm solid black;*/
            text-align:center;
            font-family:"Calibri";
            font-size:9pt;
            line-height:16pt;}

        .gbr_c1{
            width:11mm;
            padding:2mm 0;
            border-right:0.5mm solid black;
            text-transform:uppercase;
            float:left;}
        .gbr_c2{
            width:66mm;
            padding-top:2mm;
            border-right:0.5mm solid black;
            text-transform:uppercase;
            float:left;}
        .gbr_c3{
            width:14mm;
            padding-top:2mm;
            border-right:0.5mm solid black;
            text-transform:uppercase;
            float:left;}
        .gbr_c4{
            width:36mm;
            padding-top:2mm;
            border-right:0.5mm solid black;
            text-transform:uppercase;
            float:left;}
        .gbr_c5{
            width:52mm;
            padding-top:2mm;
            text-transform:uppercase;
            float:left;}


        .fixer{clear:both;}
        @media print {
            html, body {
                width: 210mm;
                height: 250mm;
            }
            .page {
                margin: 0;
                border: initial;
                border-radius: initial;
                width: initial;
                min-height: initial;
                box-shadow: initial;
                background: initial;
                page-break-after: always;
            }



        }
        .goodstable {
            width:181mm;
            border:0.5mm solid black;
            border-collapse: collapse;
        }


        .contable {
            width:181mm;
            border-collapse: collapse;

            border-right:0.5mm solid black;
            border-left:0.5mm solid black;
            border-bottom:0.5mm solid black;
            font-family:Calibri;
        }


        .contable tr {padding:0.25mm 2mm;}
        .contable td {
            border-right: 0.5mm solid black;
            border-left: 0mm solid black;
            text-transform:uppercase;
            text-align:center;
            vertical-align:middle;
            min-height:5mm;


            font-family:"Calibri";
            font-size:9pt;
            line-height:11pt;


        }
        .contable tr td:last-child {
            border-right: 0.0mm solid black;}


        .goodstable tr {display:table-row;height:7mm}
        .goodstable td {
            border-right: 0.25mm solid black;
            border-left: 0mm solid black;
            text-transform:uppercase;
            text-align:center;
            vertical-align:middle;


            font-family:"Calibri";
            font-size:9pt;
            line-height:16pt;


        }

        .goodstable tr td:last-child {
            border-right: 0mm solid black;
            border-bottom:0mm solid black;}
        .desctable
        {width:100%;}
        .desctable td{
            text-transform:uppercase;
            text-align:center;
            vertical-align:middle;
            font-family:"Calibri";
            font-size:9pt;
            line-height:10pt;
            width:33%;
        }
        tr
        {
            border-bottom: 0.5mm solid  black ;
        }
        tr:last-child
        {
            border-bottom: none;
        }

        hr{padding:0px;margin:0px;}

        .version{
            position:absolute;
            top:270mm;
            right:1mm;
            font-family:Arial, Helvetica, sans-serif;
            font-size:6pt;
            font-weight:bold;
            text-align:right;
        }

    </style>

    <style>

        #background{
            position:absolute;
            z-index:110;
            top:65mm;
            left:10mm;
            display:block;
            min-height:50%;
            min-width:50%;
            color:yellow;
        }


        #bg-text
        {
            color:rgba(153,153,153,0.4);
            font-size:100px;
            transform:rotate(320deg);
            -webkit-transform:rotate(320deg);
        }
    </style>

</head>

<body>
    @if($output == 'draft')
    <div id="background">
        <p id="bg-text">TIE Co. IC Draft </p>
    </div>
    @endif

    <div class="main">

        <div class="t1">
            <span style="text-transform:uppercase">
                @if($output == 'draft')
                    ----
                @elseif($output == 'print')
                    Cert No.
                @endif
            </span>
        </div>
        <div class="t2">
            <span>Issuing Date</span>
        </div>
        <div class="lr_1">Certificate No.:
            <span style="text-transform:uppercase">Cert No. Again</span>
        </div>
            <!-- <div class="subpage"-->
        <div class="title">INSPECTION CERTIFICATE</div>
    </div>

<div class="box">
    <div class="myfirstrow">
        <div class="pur">


            PURSUANCE TO A REQUEST RECEIVED FROM OUR CLIENT <span style="text-transform: uppercase;"> '{{ $data->buyer_name }}' </span>AND CURRENT IMPORT REGULATIONS OF THE ISLAMIC REPUBLIC OF IRAN,THE DESCRIBED GOODS AND ITS SHIPPING DOCUMENTS WERE PRESENTED TO US FOR INSPECTION,AND SO FAR AS IT COULD BE INVESTIGATED AND ACCESSIBLE THE FOLLOWING WERE FOUND:
        </div>
        <div class="left_col">

            <div class="lr_2"><strong style="text-decoration:underline;font-size:7.5pt">Applicant/Buyer:</strong>
                <span style="text-transform:uppercase;">{{ $data->buyer_name }}</span>

                <div style="text-transform:uppercase;padding-top:1.5mm;">{{ $data->buyer_address }}</div>
                <span style="text-transform:uppercase">{{ $data->buyer_tel }}</span>
                <span style="text-transform:uppercase">{{ $data->buyer_fax }}</span>
            </div>
            <div class="lr_3"><strong style="text-decoration:underline;font-size:7.5pt">Beneficiary/Seller:</strong>
                <span style="text-transform:uppercase">{{ $data->seller_name }}</span>
                <div style="text-transform:uppercase;padding-top:1.5mm;">{{ $data->seller_address }}</div>
                <span style="text-transform:uppercase">{{ $data->seller_tel }}</span>
                <span style="text-transform:uppercase">{{ $data->seller_fax }}</span>
            </div>
            @if($data->manufacturer_name != '')
            <div class="lr_3"><strong style="text-decoration:underline;font-size:7.5pt">Producer/Supplier:</strong>
                <span style="text-transform:uppercase">{{ $data->manufacturer_name }}</span>
                <div style="text-transform:uppercase;padding-top:1.5mm;">{{ $data->manufacturer_address }}</div>
                    <span style="text-transform:uppercase">{{ $data->manufacturer_tel }}</span>
                    <span style="text-transform:uppercase">{{ $data->manufacturer_fax }}</span>
            </div>
            @endif
            <div class="lr_4"><strong style="text-decoration:underline;font-size:7.5pt">Purchasing Order Register No.:</strong>
                <span style="text-transform:uppercase">{{ $data->orderReg }}</span>
            </div>
            <div class="lr_4">
                <strong style="text-decoration:underline;font-size:7.5pt">Country Of Origin:</strong>
                <span style="text-transform:uppercase">{{ $data->order->origin }}</span>
            </div>

            <div class="lr_8">
                <strong style="text-decoration:underline;font-size:7.5pt">Iranian Custom Tariff No./HS Code:</strong>
                <span style="text-transform:uppercase">{{ $data->customsTarrifIC }}</span></div>

        </div>

        <div class="right_col">
            <div class="rr_2"><strong style="text-decoration:underline;font-size:7.5pt">Inspection Method:</strong>
                <span style="text-transform:uppercase">FULL RANDOM INSPECTION</span>
            </div>
            @if($data->invoiceNo !== "")
            <div class="rr_2"><strong style="text-decoration:underline;font-size:7.5pt">PI No./date: </strong>
                <span style="text-transform:uppercase">{{ $data->order->piNo }}, &nbsp; DD: {{ $data->order->piDate }}</span>

                <div style="padding-top:10px;">
                    <strong style="text-decoration:underline;font-size:7.5pt">Invoice No.:</strong>
                    <span style="text-transform:uppercase">{{ $data->invoiceNo }}, &nbsp; DD: {{ $data->invoiceDate }}</span>
                </div>

            </div>
            @else
            <div class="rr_2"><strong style="text-decoration:underline;font-size:7.5pt">PI No./date:</strong>
                <span style="text-transform:uppercase">{{ $data->order->piNo }}, &nbsp; DD: {{ $data->order->piDate }}</span>
            </div>
            @endif
            <div class="rr_7">
                <strong style="text-decoration:underline;font-size:7.5pt">L/C No.:</strong>
                <span style="text-transform:uppercase">{{ $data->order->lcNo }}</span>
            </div>


            @if($data->ttIC != 'N/A' or $data->ttIC != '' or $data->ttIC != null)
            <div class="rr_7">
                <strong style="text-decoration:underline;font-size:7.5pt">TT No.:</strong>
                <span style="text-transform:uppercase">{{ $data->ttIC }}</span>
            </div>
            @endif

            @if($data->manifestIC != 'N/A' or $data->manifestIC != '' or $data->manifestIC != null)
            <div class="rr_7">
                <strong style="text-decoration:underline;font-size:7.5pt">Manifest No.:</strong>
                <span style="text-transform:uppercase">{{ $data->manifestIC }}</span>,&nbsp;DD: {{ $data->manifestDateIC }} </span>
            </div>
            @endif

            @if($data->blNo != 'N/A' or $data->blNo != '' or $data->manifestIC != null)
            <div class="rr_3"><strong style="text-decoration:underline;font-size:7.5pt">B/L No.:</strong>
                <span style="text-transform:uppercase">{{ $data->blNo }},&nbsp;DD: {{ $data->blDate }}</span>
            </div>
            @endif

            <div class="rr_7">
                <strong style="text-decoration:underline;font-size:7.5pt"> CB No.:</strong>
                <span style="text-transform:uppercase">{{ $data->cbIC }}</span>
            </div>
            @if($data->refNoIC != 'N/A' or $data->refNoIC != '' or $data->refNoIC != null)
            <div class="rr_7">
                <strong style="text-decoration:underline;font-size:7.5pt">Ref No.:</strong>
                <span style="text-transform:uppercase">{{ $data->refNoIC }}</span>
            </div>
            @endif


            <div class="rr_4"><strong style="text-decoration:underline;font-size:7.5pt">Inspection Place/ Date:</strong>
                <span style="text-transform:uppercase">{{ $data->inspectionPlace }} / {{ $data->inspectionDate }}</span>
            </div>
            <div class="rr_5"><strong style="text-decoration:underline;font-size:7.5pt">Issuing Bank:</strong>
                <span style="text-transform:uppercase"> {{ $data->issuingBankIC }}</span>
            </div>

            <div class="rr_5"><strong style="text-decoration:underline;font-size:7.5pt">Insurance Policy No./ Effected by:</strong> {{ $data->insurancePolicy }}<br>by: {{ $data->insuranceCompany }}</div>
            <div class="rr_10"><strong style="text-decoration:underline;font-size:7.5pt">Vessel's Name:</strong> {{ $data->order->vessel }}</div>
        </div>

        <div class="fixer"></div>


    </div>

    <table cellpadding="2" class="goodstable">

        <tr>
            <td style="width:9.7mm;font-size:6pt;background-color:lightgray;font-weight:bold">Item</td>
            <td style="width:9.7mm;font-size:6pt;background-color:lightgray;font-weight:bold">Description Of Goods</td>
            <td style="width:9.7mm;font-size:6pt;background-color:lightgray;font-weight:bold">Quantity</td>
            <td style="width:9.7mm;font-size:6pt;background-color:lightgray;font-weight:bold">Packing</td>
        </tr>

            @foreach($goods as $good)
                <tr>
                    <td style="width:9.7mm">{{ $loop->index + 1 }}</td>
                    <td style="width:110mm">{{ $good->desc }}</td>
                    <td style="width:24.1mm">{{ $good->quantity }}</td>
                    <td style="width:30mm">{{ $good->packing }}</td>
                </tr>
            @endforeach
    </table>

    <table cellpadding="1" class="contable" >
        <tr>
            <td colspan="2"  style="font-size:8.5pt;text-align:justify;text-transform:none;">

                <strong style="text-decoration:underline;font-size:8.5pt">QUANTITY </strong> <small style="font-weight:bold">(AS PER B/L)</small>:
                Total Packages: <span style="text-transform: capitalize;">{{ $data->totalQuantityIC }}</span>, Gross weight: {{ $data->grossWeightIC }} KGS
                <br>
                <strong style="text-decoration:underline;font-size:8.5pt">PACKING AND MARKING:</strong><br>
                {{ $data->packingmarkingIC }}
                <br>
                <hr>
                <strong style="text-decoration:underline;font-size:8.5pt">FINDINGS:</strong> <br>
                {{ $data->findingsIC }}<br>
                <hr>

                <strong style="text-decoration:underline;font-size:8.5pt">CONCLUSION:</strong>
                <br>
                {{ $data->conclusionIC }}
                <br>
            </td>
        </tr>
        <tr style="border-top:0.25mm solid black;border-bottom:0.25mm solid black;padding:0.5mm 2mm;">

            <td width="50%">

                <div style="text-decoration:underline;font-size:7.5pt;text-align:left;font-weight:bold;padding:2mm">AUTHORISED SIGNATURE/ STAMP
                    @if($output == 'print')
                        <img src="https://baranx.tie-co.com/img/emza_mat.png" width="158" height="115" style="position:absolute;margin-left:1cm; text-align:left;"> </div>
                    @endif
                <div style="text-align:left;padding:2mm;font-size:7.5pt;text-transform:initial">
                    <strong style="text-decoration:underline;">Position / Name:</strong> {{ $data->signeeIC }}
                </div>


                <br>
            </td>
            <td width="50%"  style="border-right:0.25mm solid black;vertical-align:top;text-align:left">
                <div style="font-size:7pt;line-height:12pt;text-align:left;padding:2mm">

                    <strong style="text-decoration:underline;font-size:7.5pt;">PLACE/DATE OF ISSUE:</strong>

                </div>
                <span style="padding:2mm;font-size:7.5pt"> {{ $data->issuingPlaceIC }} / {{ $data->signDateIC }}</span>
            </td>

        </tr>
        <tr>
            <td colspan="2" style="font-size:6.5pt;text-align:justify;text-transform:none;text-transform:uppercase;">
                Above findings are limited to date and place of intervention only, the Company is neither an insurer nor a guarantor and disclaims any liability in such capacity. Our verification/certification does not absolve the seller from his contractual obligations towards the buyer.
            </td>
        </tr>
        <tr>
            <td colspan="2" style="font-size:10.5pt;text-align:center;text-transform:none;text-transform:uppercase;border-right:0.5mm solid white;border-left:0.5mm solid white; border-bottom:0.5mm solid white;">
                <br>Address: 4th Floor, No. 35, East Nahid St, North Africa Blvd, Tehran - Iran<br>خبرگان بین المللی تهران - Khobregan Beinolmelali Tehran Co.</td>
        </tr>
    </table>

</div>


<div class="version">ID: FR-IN-GE-10<br>Version: 2.0</div>
</div>

</body>
</html>
