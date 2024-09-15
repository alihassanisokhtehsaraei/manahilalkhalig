




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Untitled Document</title>

    <link rel="stylesheet" type="text/css" href="http://baranx.tie-co.com/css/persian-fonts.css">
    <style>
        body {
            width: 100%;
            height: 100%;
            margin: 0;
            padding: 0;
            background-color: #FAFAFA;
            font: 12pt "Tahoma";
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
            background:white;
            /*
            border: 1px #D3D3D3 solid;
            border-radius: 5px;
            background: red;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);*/

        }
        .title1{
            position:absolute;
            top:90mm;
            left:82mm;
            font-family:"persian_titr";
            font-weight:bold;
            font-size:12pt;
            border-bottom:1px solid black;}

        .title2{
            position:absolute;
            top:90mm;
            left:73mm;
            font-family:"persian_titr";
            font-weight:bold;
            font-size:12pt;
            border-bottom:1px solid black;}

        .letter_date{
            position:absolute;
            top:49mm;
            left:29mm;
            font-family:"persian_nazanin";
            font-weight:600;
            font-size:12pt;}

        .letter_no{
            position:absolute;
            top:57mm;
            left:29mm;
            font-family:"Times New Roman";
            font-weight:600;
            font-size:12pt;
            text-transform:uppercase;}

        .bank_title{
            position:absolute;
            top:73mm;
            right:28mm;
            font-family:"persian_titr";
            font-weight:600;
            font-size:14pt;
            direction:rtl;}

        .bank_text{
            position:absolute;
            top:105mm;
            right:28mm;
            width:153mm;
            direction:rtl;
            text-align:justify;
            font-family:"persian_nazanin";
            font-weight:600;
            font-size:12pt;}

        .bank_footer{
            position:absolute;
            top:242mm;
            right:28mm;
            width:153mm;
            direction:rtl;
            text-align:justify;
            font-family:"persian_nazanin";

            font-size:10pt;}


        .sign{
            position:absolute;
            text-align:center;
            top:220mm;
            left:42mm;
            font-family:"persian_titr";
            font-weight:600;
            font-size:14pt;
            text-transform:uppercase;}

        span{margin:0mm;padding:0mm;}
        .version{
            position:absolute;
            top:270mm;
            right:28mm;
            font-family:Arial, Helvetica, sans-serif;
            font-size:6pt;
            font-weight:bold;
            text-align:right;
        }
    </style>
</head>

<body>
<div class="page">
    <div class="letter_date">تاریخ: {{ $data->letterDate }}</div>
    <div class="letter_no">
        <span style="font-family:'persian_nazanin';font-size:12pt;font-weight:bold;float:right;direction:rtl">شماره:&nbsp;{{ $data->letterNo }}</span></div>


    @if($data->insType == "ASI")
        <div class="title1">موضوع: نامه پذیرش بازرسی بعد از حمل (در مقصد)</div>
    @else
    <div class="title2">موضوع: نامه پذیرش بازرسی قبل از حمل</div>
    @endif


    <div class="bank_title">ریاست محترم بانک: {{ $data->bankName }}
        &emsp;&emsp;
        شعبه: {{ $data->branch }}
    </div>

    <div class="bank_text">
        با سلام؛
        <br />
        @if($data->insType == 'ASI')
        احتراماً  بدینوسیله این شرکت، خبرگان بین المللی تهران <span style="font-family:'Times New Roman';font-size:12pt;font-weight:600;direction:ltr;text-align:left">.TIE Co</span>، ضمن رعایت ضوابط قانونی و مجموعه مقررات ارزی، آمادگی خود را نسبت به انجام بازرسی بعد از حمل (در مقصد) کالای وارداتی با مشخصات زیر را اعلام می نماید:
        @else
        احتراماً  بدینوسیله این شرکت، خبرگان بین المللی تهران <span style="font-family:'Times New Roman';font-size:12pt;font-weight:600;direction:ltr;text-align:left">.TIE Co</span>، ضمن رعایت ضوابط قانونی و مجموعه مقررات ارزی، آمادگی خود را نسبت به انجام بازرسی قبل از حمل کالای وارداتی با مشخصات زیر را اعلام می نماید:
        @endif
        <br />
        نام کالا: <br />   <span style="font-family:Arial;font-size:12pt;text-transform:uppercase;font-weight:200;"><div style="font-family:Arial;font-weight:200;direction:ltr;display:inline-block;text-transform:uppercase;text-align:left">{{ $data->goodsDesc }}</div></span>
        <br />
        تعرفه گمرکی:
        <span style="font-family:Arial;font-size:12pt;text-transform:uppercase;text-align:left;font-weight:200;">
        <div style="font-family:Arial;font-weight:200;direction:ltr;display:inline-block;text-transform:uppercase">{{ $data->customsTarrif }}</div></span><br />

        نام گمرک:
        <span style="font-family:Arial;font-size:12pt;text-transform:uppercase;text-align:left;font-weight:200;">
    <div style="font-family:Arial;font-weight:200;direction:ltr;display:inline-block;text-transform:uppercase">{{ $data->customsName }}</div></span><br />


        متعلق به شرکت / آقای / خانم:  <br />  <span style="font-family:Arial;font-size:12pt;text-transform:uppercase;text-align:left;font-weight:200;">
            <div style="font-family:Arial;font-weight:200;direction:ltr;display:inline-block;text-transform:uppercase">{{ $data->order->cName }}</div></span><br />
        پروفرما اینویس <span style="font-family:Arial;font-size:12pt;text-transform:uppercase;font-weight:200;">(P/I)</span> شماره:    <div style="font-family:Arial;font-size:10pt;font-weight:200;direction:ltr;display:inline-block;text-transform:uppercase">{{ $data->order->piNo }}</div><br />
        مورخ:  <div style="font-family:Arial;font-size:10pt;font-weight:200;direction:ltr;display:inline-block">

            {{ $data->piDate }}
        </div><br/>

        شماره ثبت سفارش:  <span style="font-family:Arial;font-size:12pt;text-transform:uppercase;font-weight:200;"></span>    <div style="font-family:Arial;font-size:10pt;font-weight:200;direction:ltr;display:inline-block;text-transform:uppercase">{{ $data->orderingNo }}</div><br />
        تاریخ ثبت سفارش:  <span style="font-family:Arial;font-size:12pt;text-transform:uppercase;font-weight:200;"></span>    <div style="font-family:Arial;font-size:10pt;font-weight:200;direction:ltr;display:inline-block;text-transform:uppercase">{{ $data->orderingDate }}</div><br />



        @if($data->insType == 'ASI')
        <div>
            بدینوسیله تایید می گردد قرارداد بازرسی طبق ضوابط ابلاغی از سوی سازمان ملی استاندارد ایران منعقد شده و بازرسی  بعد از حمل (در مقصد) و صدور گواهی بازرسی نیز بر اساس قرارداد بازرسی و ضوابط مربوطه انجام شود.
        </div>
        @else
        <div>
            بدینوسیله تایید می گردد قرارداد بازرسی طبق ضوابط ابلاغی از سوی سازمان ملی استاندارد ایران منعقد شده و بازرسی قبل از حمل و صدور گواهی بازرسی نیز بر اساس قرارداد بازرسی و ضوابط مربوطه انجام شود.
        </div>
        @endif
    </div>

    <div class="sign">
        <br />
        با تشکر
        <br />
        علیرضا توکلی
        <br />
        مدیر عامل
    </div>
</div>
</body>

</html>
