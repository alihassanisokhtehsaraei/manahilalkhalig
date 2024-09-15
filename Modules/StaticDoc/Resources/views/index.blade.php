@extends('layouts.viho')

@section('moreCSS')
    <!-- Plugins CSS start-->
    <link rel="stylesheet" type="text/css" href="{{ asset('viho/assets/css/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('viho/assets/css/sweetalert2.css') }}">
    <!-- Plugins CSS Ends-->
@endsection

@section('body')

    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Documents</h5>
            </div>

            <div class="card-body">


                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Actions</th> <!-- New Actions column -->
                        </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td>1</td>
                                <td class="persian-fonts">قائمة البضائع الغذائية املستوردة الخاضعة للفحص</td>
                                <td>
                                    <a href="{{ route('staticDocs.download', 'List-of-imported-food-goods-subject-to-inspection.pdf') }}" class="btn btn-primary btn-sm">Download</a>
                                </td>
                            </tr>
                            <tr >
                                <td>2</td>
                                <td class="persian-fonts">قائمة البضائع الكيمياوية املستوردة الخاضعة للفحص</td>
                                <td>
                                    <a href="{{ route('staticDocs.download', 'List-of-imported-chemical-goods-subject-to-inspection.pdf') }}" class="btn btn-primary btn-sm">Download</a>
                                </td>
                            </tr>
                            <tr >
                                <td>3</td>
                                <td class="persian-fonts">قائمة البضائع االنشائية املستوردة الخاضعة للفحص </td>
                                <td>
                                    <a href="{{ route('staticDocs.download', 'List-of-imported-construction-goods-subject-to-inspection.pdf') }}" class="btn btn-primary btn-sm">Download</a>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>AIR 2.1 – COSMETICS AND PERFUMERY
                                    PRODUCTS</td>
                                <td>
                                    <a href="{{ route('staticDocs.download', 'air.pdf') }}" class="btn btn-primary btn-sm">Download</a>
                                </td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>CVG 2.1 – COSMETICS AND PERFUMERY
                                    PRODUCTS</td>
                                <td>
                                    <a href="{{ route('staticDocs.download', 'cvg.pdf') }}" class="btn btn-primary btn-sm">Download</a>
                                </td>
                            </tr>
                            <tr >
                                <td>6</td>
                                <td class="persian-fonts">ملحق رقم 4 هیکلیة الاجور</td>
                                <td>
                                    <a href="{{ route('staticDocs.download', 'Appendix-No-4-Wage-Structure.pdf') }}" class="btn btn-primary btn-sm">Download</a>
                                </td>
                            </tr>
                            <tr >
                                <td>7</td>
                                <td class="persian-fonts">برنامج الفحص والتفتيش قبل التوريد
                                    تعهد المستورد/المصدر</td>
                                <td>
                                    <a href="{{ route('staticDocs.download', 'Pre-Import-Inspection-Program.pdf') }}" class="btn btn-primary btn-sm">Download</a>
                                </td>
                            </tr>
                            <tr >
                                <td>8</td>
                                <td class="persian-fonts">قائمة البضائع الهندسیة املستوردة الخاضعة للفحص</td>
                                <td>
                                    <a href="{{ route('staticDocs.download', 'List-of-imported-engineering-goods-subject-to-inspection.pdf') }}" class="btn btn-primary btn-sm">Download</a>
                                </td>
                            </tr>
                            <tr >
                                <td>9</td>
                                <td class="persian-fonts">قائمة البضائع النسیجیة املستوردة الخاضعة للفحص</td>
                                <td>
                                    <a href="{{ route('staticDocs.download', 'List-of-imported-textile-goods-subject-to-inspection.pdf') }}" class="btn btn-primary btn-sm">Download</a>
                                </td>
                            </tr>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('moreJs')

@endsection
