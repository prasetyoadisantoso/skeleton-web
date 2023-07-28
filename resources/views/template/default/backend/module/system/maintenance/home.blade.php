@extends('template.default.backend.page.index')

@section('maintenance-home')
<!-- Start Breadcrumb -->
<nav class="bg-light py-3 px-2 px-md-5 shadow-sm d-flex justify-content-between" aria-label="breadcrumb">
    <h5 class="my-0"><i class="fa-regular fa-rectangle-list me-3"></i>{{$breadcrumb['title']}}</h5>
    <ol class="breadcrumb my-0">
        <li class="breadcrumb-item"><a href="{{route('activity.index')}}"
                class="text-decoration-none text-dark">{{$breadcrumb['home']}}</a>
        </li>
        <li class="breadcrumb-item active text-muted" aria-current="page">
            {{$breadcrumb['index']}}
        </li>
    </ol>
</nav>
<!-- End Breadcrumb -->

<!-- Start Home -->
<div class="container py-3">

    <!-- Start app -->
    <div class="general-app">
        <div class="row">

            <!-- Start Site Title & Tagline -->
            <div class="col-md-12">
                <div class="card px-4 py-3 my-3">
                    <div class="card-body">
                        <h5 class="card-title text-center">{{$form['clean_cache_system']['title']}}</h5>
                        <h6 class="card-subtitle mb-4 text-muted text-center">{{$form['clean_cache_system']['description']}}
                        <hr>
                        </h6>
                        <div class="my-3 d-flex justify-content-between">
                            <label for="">{{$form['clean_cache_system']['event_clear']}}</label>
                            <a href="{{route('maintenance.event.clear')}}" class="btn btn-success"><i class="fa-solid fa-broom me-3"></i>{{$button['clear']}}</a>
                        </div>
                        <div class="my-3 d-flex justify-content-between">
                            <label for="">{{$form['clean_cache_system']['view_clear']}}</label>
                            <a href="{{route('maintenance.view.clear')}}" class="btn btn-success"><i class="fa-solid fa-broom me-3"></i>{{$button['clear']}}</a>
                        </div>
                        <div class="my-3 d-flex justify-content-between">
                            <label for="">{{$form['clean_cache_system']['cache_clear']}}</label>
                            <a href="{{route('maintenance.cache.clear')}}" class="btn btn-success"><i class="fa-solid fa-broom me-3"></i>{{$button['clear']}}</a>
                        </div>
                        <div class="my-3 d-flex justify-content-between">
                            <label for="">{{$form['clean_cache_system']['config_clear']}}</label>
                            <a href="{{route('maintenance.config.clear')}}" class="btn btn-success"><i class="fa-solid fa-broom me-3"></i>{{$button['clear']}}</a>
                        </div>
                        <div class="my-3 d-flex justify-content-between">
                            <label for="">{{$form['clean_cache_system']['route_clear']}}</label>
                            <a href="{{route('maintenance.route.clear')}}" class="btn btn-success"><i class="fa-solid fa-broom me-3"></i>{{$button['clear']}}</a>
                        </div>
                        <div class="my-3 d-flex justify-content-between">
                            <label for="">{{$form['clean_cache_system']['compile_clear']}}</label>
                            <a href="{{route('maintenance.compile.clear')}}" class="btn btn-success"><i class="fa-solid fa-broom me-3"></i>{{$button['clear']}}</a>
                        </div>
                        <div class="my-3 d-flex justify-content-between">
                            <label for="">{{$form['clean_cache_system']['optimize_clear']}}</label>
                            <a href="{{route('maintenance.optimize.clear')}}" class="btn btn-success"><i class="fa-solid fa-broom me-3"></i>{{$button['clear']}}</a>
                        </div>
                        <div class="my-3 d-flex justify-content-between">
                            <label for="">{{$form['factory_reset']}}</label>
                            <a id="reset" href="{{route('maintenance.factory.reset')}}" class="btn btn-danger"><i class="fa-solid fa-warning me-3"></i>{{$button['reset']}}</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Site Title & Tagline -->

        </div>
    </div>
    <!-- End app -->

</div>
<!-- End Home -->
@endsection

@push('maintenance-js')
<script alt="maintenance-delete">
    $(document).on('click', '#reset', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        Swal.fire({
            title: "{{$messages['ask_reset']}}",
            icon: "warning",
            showCancelButton: !0,
            cancelButtonText: "{{$button['cancel']}}",
            confirmButtonText: "{{$button['confirm']}}",
            customClass: {
                confirmButton: "btn btn-success px-5 rad-25 mx-1 my-1",
                cancelButton: "btn btn-danger px-5 rad-25 mx-1 my-1 order-sm-1",
            },
            buttonsStyling: false,
            reverseButtons: false,
        }).then(function (e) {
            if (e.value === true) {
                Swal.fire('Please wait')
                Swal.showLoading()
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: { _token: "{{csrf_token()}}" },
                    dataType: 'JSON',
                    success: function (results) {
                        if (results.success === 'success') {
                            Swal.fire({
                                title: "{{$messages['reset_success']}}",
                                text: results.message,
                                icon: "success",
                                customClass: {
                                    popup: "rad-25",
                                    confirmButton: "btn btn-success px-5 rad-25",
                                },
                                buttonsStyling: false,
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: "{{$messages['reset_failed']}}",
                                text: results.message,
                                icon: "error",
                            }).then(() => {
                                location.reload();
                            });
                        }
                    }
                });
            } else {
                e.dismiss;
            }
        }, function (dismiss) {
        })
    })
</script>
@endpush
