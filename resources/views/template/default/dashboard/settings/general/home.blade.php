@extends('template.default.dashboard.index')

@section('general-home')
<!-- Start Breadcrumb -->
<nav class="bg-light py-3 px-5 shadow-sm d-flex justify-content-between" aria-label="breadcrumb">
    <h5 class="my-0"><i class="fa-solid fa-gear me-3"></i>{{$breadcrumb['title']}}</h5>
    <ol class="breadcrumb my-0">
        <li class="breadcrumb-item active text-muted" aria-current="page">{{$breadcrumb['index']}}</li>
    </ol>
</nav>
<!-- End Breadcrumb -->

<!-- Start Home -->
<div class="container py-3">

    <!-- Start app -->
    <div class="general-app">
        <div class="row">

            <!-- Start Site Title & Tagline -->
            <div class="col-md-6">
                <div class="card px-4 py-3 my-3">
                    <div class="card-body">
                        <h5 class="card-title text-center">{{$form['site_description']['title']}}</h5>
                        <h6 class="card-subtitle mb-4 text-muted text-center">
                            {{$form['site_description']['description']}}</h6>
                        <form action="{{route('general.update.description')}}" method="POST" id="site-description-form">
                            @csrf
                            <input type="hidden" name="id" id="site_id" value="{{$data->id}}">
                            <div class="my-3">
                                <input type="text" class="form-control" id="site-title"
                                    placeholder="{{$form['site_description']['site_title']}}"
                                    value="{{$data->site_title}}" name="site_title">
                            </div>
                            <div class="my-3">
                                <input type="text" class="form-control" id="site-tagline"
                                    placeholder="{{$form['site_description']['site_tagline']}}"
                                    value="{{$data->site_tagline}}" name="site_tagline">
                            </div>
                            <div class="my-3">
                                <input type="text" class="form-control" id="url-address"
                                    placeholder="{{$form['site_description']['site_url']}}"
                                    value="{{$data->url_address}}" name="url_address">
                            </div>
                            <div class="my-3">
                                <input type="text" class="form-control" id="copyright"
                                    placeholder="{{$form['site_description']['site_copyright']}}"
                                    value="{!!$data->copyright!!}" name="copyright">
                            </div>
                            <div class="my-3">
                                <textarea class="form-control"
                                    placeholder="{{$form['site_description']['site_cookies']}}" id="cookies-concern"
                                    style="height: 100px" name="cookies_concern">{{$data->cookies_concern}}</textarea>
                            </div>
                            <div class="d-flex justify-content-center">
                                @can ("general-update")
                                <button type="submit" class="btn btn-success text-center " id="site-description-submit"><i class="fa fa-save me-3"
                                        aria-hidden="true"></i>{{$button['update']}}</button>
                                @endcan
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- End Site Title & Tagline -->

            <!-- Start Site Logo & Favicon -->
            <div class="col-md-6">
                <div class="card px-4 py-3 my-3">
                    <div class="card-body">
                        <h5 class="card-title text-center ">{{$form['site_logo_favicon']['title']}}</h5>
                        <h6 class="card-subtitle mb-4 text-muted text-center ">
                            {{$form['site_logo_favicon']['description']}}</h6>
                        <form action="{{route('general.update.logo.favicon')}}" method="POST" id="site-logo-favicon-form" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" id="site_id" value="{{$data->id}}">
                            <div class="container py-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="text-center mb-3">
                                            <img class="img-fluid rounded-circle"
                                                src="{{Storage::url($data->site_logo)}}"
                                                alt="Logo picture" id="logoImage" style="width: 128px;">
                                            <i class="fa fa-camera upload-button"></i>
                                            <input type="file" name="site_logo" onchange="readImage1(this);"
                                                id="logoUpload" hidden accept="image/png, image/jpeg" />
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="text-center mb-3">
                                            <img class="img-fluid rounded-circle"
                                                src="{{Storage::url($data->site_favicon)}}"
                                                alt="Favicon picture" id="faviconImage" style="width: 128px;">
                                            <i class="fa fa-camera upload-button"></i>
                                            <input type="file" name="site_favicon" onchange="readImage2(this);"
                                                id="faviconUpload" hidden accept="image/png, image/jpeg" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                @can ("general-update")
                                <button type="submit" class="btn btn-success text-center " id="site-logo-favicon-submit"><i class="fa fa-save me-3"
                                        aria-hidden="true"></i>{{$button['update']}}</button>
                                @endcan
                            </div>
                        </form>
                        <h5 class="font-weight-light text-center mt-3" style="font-size: 8pt;">
                            {{$form['site_logo_favicon']['note']}}
                        </h5>
                    </div>
                </div>
            </div>
            <!-- End Site Logo & Favicon -->

        </div>
    </div>
    <!-- End app -->

</div>
<!-- End Home -->
@endsection

@push('general-js')
<script>
    $("#logoImage").click(function (e) {
        $("#logoUpload").click();
    });

    //Preview Image
    function readImage1(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
                reader.onload = function (e) {
                    let my_input = input.id;
                    let i = my_input.substr(-1)
                    $('#logoImage')
                        .attr('src', e.target.result)
                };
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#faviconImage").click(function (e) {
        $("#faviconUpload").click();
    });

    //Preview Image
    function readImage2(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
                reader.onload = function (e) {
                    let my_input = input.id;
                    let i = my_input.substr(-1)
                    $('#faviconImage').attr('src', e.target.result)
                };
            reader.readAsDataURL(input.files[0]);
        }
    }

    $('#site-description-submit').click(function () {
        $("#site-description-form").submit();
    });

    $('#site-logo-favicon-submit').click(function () {
        $("#site-logo-favicon-form").submit();
    });


</script>
@endpush
