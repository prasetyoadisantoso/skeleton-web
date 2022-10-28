@extends('template.default.dashboard.index')

@section('main-home')
<!-- Start Breadcrumb -->
<nav class="bg-light py-3 px-5 shadow-sm d-flex justify-content-between" aria-label="breadcrumb">
    <h5 class="my-0">{{$breadcrumb['home']}}</h5>
    <ol class="breadcrumb my-0">
        <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-dark">{{$breadcrumb['index']}}</a></li>
        <li class="breadcrumb-item active text-muted" aria-current="page">{{$breadcrumb['current_index']}}</li>
    </ol>
</nav>
<!-- End Breadcrumb -->

<!-- Start Home -->
<div class="container">

    <!-- Start app -->
    <div class="card mx-3 my-3 rounded-3 border-0 shadow-md" style="background-image: url('https://c4.wallpaperflare.com/wallpaper/895/252/989/4k-material-red-light-wallpaper-preview.jpg'); background-size: cover;
    background-position: center;">
        <div class="card-body">
            <div class="p-5 mb-4 rounded-3">
                <div class="container-fluid py-5">
                    <h1 class="display-5 fw-bold">{{$content['card_1']['title']}}</h1>
                    <p class="col-md-8 fs-4">{{$content['card_1']['subtitle']}}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row align-items-md-stretch mx-1 mb-3">
        <div class="col-md-6 my-3">
            <div class="h-100 p-5 bg-light border rounded-3">
                <img src="https://laravel.com/img/logomark.min.svg" alt="" height="50" class="my-2">
                <h2>{{$content['card_2']['title']}}</h2>
                <p>{{$content['card_2']['subtitle']}}</p>
                <a href="https://laravel.com" class="btn btn-danger">{{$content['card_2']['button']}}</a>
            </div>
        </div>
        <div class="col-md-6 my-3">
            <div class="h-100 p-5 text-white bg-dark rounded-3">
                <img src="https://getbootstrap.com/docs/5.0/assets/brand/bootstrap-logo.svg" alt="" height="50"
                    class="my-2">
                <h2>{{$content['card_3']['title']}}</h2>
                <p>{{$content['card_3']['subtitle']}}.</p>
                <a class="btn btn-primary">{{$content['card_3']['button']}}</a>
            </div>
        </div>
    </div>
    <!-- End app -->

</div>
<!-- End Home -->
@endsection
