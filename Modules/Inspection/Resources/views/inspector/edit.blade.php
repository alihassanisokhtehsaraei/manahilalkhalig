@extends('layouts.viho')
@section('body')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Inspector Database</h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">{{ __('common.home') }}</a></li>
                        <li class="breadcrumb-item">Inspection Department</li>
                        <li class="breadcrumb-item active">Inspectors</li>
                    </ol>
                </div>
                <div class="col-sm-6">
                    <!-- Bookmark Start-->
                    <div class="bookmark">
                        <ul>
                            <li><a href="{{ route('inspector.index') }}" data-container="body" data-bs-toggle="popover" data-placement="top" title="" data-original-title="Tables"><i data-feather="inbox"></i></a></li>
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
                        <h5>Edit Inspector</h5><span>As the owner of this file you are allowed to modify it in any way you want, just keep the integrity of data and be careful about filling all items</span>
                    </div>
                    <form class="theme-form persian-fonts dir-rtl" method="post" action="{{ route('inspector.update', $inspector->id) }}"  enctype="multipart/form-data">
                        @csrf
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger dir-ltr">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if ($message = Session::get('success'))
                            <div class="alert alert-success dir-ltr">
                                <strong>{{ $message }}</strong>
                            </div>
                        @endif
                            <div class="row col-md-12">
                                <div class="col-md-6">
                                    <label class="col-form-label pt-0" for="name">نام</label>
                                    <input class="form-control" id="name" name="name" type="text"  value="{{ $inspector->name }}" >
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label pt-0" for="lastName">نام خانوادگی</label>
                                    <input class="form-control" id="lastName" name="lastName" type="text"  value="{{ $inspector->lastName }}" >
                                </div>

                            </div>

                            <br>

                            <div class="row col-md-12">
                                <div class="col-md-6">
                                    <label class="col-form-label pt-0" for="degree">مقطع تحصیلات</label>
                                    <select class="form-control" id="degree" name="degree">
                                        <option value="{{ $inspector->degree }}">
                                            @switch($inspector->degree)
                                                @case('BS')
                                                    {{ 'Bachelor of Science (BS) کارشناسی رشته های علمی و فنی' }}
                                                    @break
                                                @case('MS')
                                                    {{ 'Master of Science (MS) کارشناس ارشد رشته های علمی و فنی' }}
                                                    @break
                                                @case(PhD)
                                                    {{ 'Doctor of Philosophy (Ph.D)  دکتری در همه رشته های تحصیلی' }}
                                                    @break
                                            @endswitch
                                        </option>
                                        <optgroup label="Others">
                                            <option value="BS">Bachelor of Science (BS) کارشناسی رشته های علمی و فنی</option>
                                            <option value="MS">Master of Science (MS) کارشناس ارشد رشته های علمی و فنی</option>
                                            <option value="PhD">Doctor of Philosophy (Ph.D)  دکتری در همه رشته های تحصیلی</option>
                                        </optgroup>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label pt-0" for="fieldOfStudy">رشته تحصیلی</label>
                                    <input class="form-control" id="fieldOfStudy" name="fieldOfStudy" type="text"  value="{{ $inspector->fieldOfStudy }}" >
                                </div>
                            </div>

                            <br>

                            <div class="row col-md-12">
                                <div class="col-md-6">
                                    <label class="col-form-label pt-0" for="experties">سمت / تخصص</label>
                                    <input class="form-control" id="experties" name="experties" type="text"  value="{{ $inspector->experties }}" >
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label pt-0" for="workExperience">سابقه کار (سال)</label>
                                    <input class="form-control" id="workExperience" name="workExperience" type="number"  value="{{ $inspector->workExperience }}"  />
                                </div>
                            </div>

                            <br>

                            <div class="row col-md-12">
                                <div class="col-md-6">
                                    <label class="col-form-label pt-0" for="mobile">تلفن همراه</label>
                                    <input class="form-control" id="mobile" name="mobile" type="text"  value="{{ $inspector->mobile }}" >
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label pt-0" for="email">ایمیل</label>
                                    <input class="form-control" id="email" name="email" type="email"  value="{{ $inspector->email }}" />
                                </div>
                            </div>

                            <br>

                            <div class="row col-md-12">
                                <div class="col-md-6">
                                    <label class="col-form-label pt-0" for="city">شهر</label>
                                    <input class="form-control" id="city" name="city" type="city" value="{{ $inspector->city }}"  />
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label pt-0" for="cv">آپلود رزومه</label>
                                    <input class="form-control" id="cv" name="cv" type="file">
                                </div>
                            </div>
                    </div>
                    <div class="card-footer">
                        <input type="submit" class="btn btn-primary" value="Submit">
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
    <!-- Plugins JS Ends-->
@endsection
