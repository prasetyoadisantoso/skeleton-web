@extends('template.default.dashboard.index')

@section('meta-form')

@include('template.default.dashboard.partial.breadcrumb')

<!-- Start Home -->
<div class="container py-3 w-100 w-md-75">

    <!-- Start app -->
    <div class="card" id="role-create">
        <div class="card-header pt-3">
            <div class="d-flex justify-content-center">
                @if ($type == 'create')
                <h5 class="align-self-center">{{$form['create_title']}}</h5>
                @endif
                @if ($type == 'edit')
                <h5 class="align-self-center">{{$form['edit_title']}}</h5>
                @endif
            </div>
        </div>
        <div class="card-body">
            <!-- Start Create Meta -->
            <div class="container-fluid">
                @if ($type == 'create')
                <form action="{{route('meta.store')}}" method="POST" id="meta-store-form">
                @endif

                @if ($type == 'edit')
                <form action="{{route('meta.update', $meta->id)}}" method="POST" id="meta-update-form">
                @method('PUT')
                @endif

                    @csrf
                    <div class="form-group mx-3 my-3">
                        <label for="inputName" class="">{{$form['name']}}</label>
                        <div class="mb-3">
                            <input name="name" type="text" class="form-control" id="name"
                                placeholder="{{$form['name_placeholder']}}" value="{{$type == "edit" &&
                                isset($meta) ? $meta->name : ''}}" required>
                            <div class="error-name"></div>
                        </div>
                        <label for="inputRobot" class="">{{$form['robot']}}</label>
                        <div class="mb-3">
                            <input name="robot" type="text" class="form-control" id="robot"
                                placeholder="{{$form['robot_placeholder']}}" value="{{$type == "edit" &&
                                isset($meta) ? $meta->robot : ''}}" required>
                            <div class="error-robot"></div>
                        </div>
                        <label for="inputDescription" class="">{{$form['description']}}</label>
                        <div class="mb-3">
                            <textarea class="form-control" placeholder="{{$form['description_placeholder']}}"
                                id="description" style="height: 100px" name="description">{{$type == "edit" &&
                                isset($meta) ? $meta->description : ''}}</textarea>
                            <div class="error-description"></div>
                        </div>
                        <label for="inputKeyword" class="">{{$form['keyword']}}</label>
                        <div class="mb-3">
                            <textarea class="form-control" placeholder="{{$form['keyword_placeholder']}}" id="keyword"
                                style="height: 100px" name="keyword">{{$type == "edit" &&
                                isset($meta) ? $meta->keyword : ''}}</textarea>
                            <div class="error-keyword"></div>
                        </div>
                        <div class="mb-3">
                            @if ($type == 'create')
                            @can ("meta-store")
                            <button id="meta-store-submit" type="submit" class="btn btn-success w-100">
                                {{$button['store']}}<i class="fas fa-save ms-2"></i>
                            </button>
                            @endcan
                            @endif

                            @if ($type == 'edit')
                            @can ("meta-update")
                            <button id="meta-update-submit" type="submit" class="btn btn-success w-100">
                                {{$button['update']}}<i class="fas fa-save ms-2"></i>
                            </button>
                            @endcan
                            @endif
                        </div>
                    </div>
                </form>
            </div>
            <!-- End Create Meta -->
        </div>
        <div class="card-footer py-4">
        </div>
    </div>
    <!-- End app -->

</div>
<!-- End Home -->
@endsection

@push('meta-form-js')
<script>
    let current_id = document.querySelector("form").id;
    $("#" + current_id).validate({
        rules: {
            name: {
                required: true
            },
            robot: {
                required: true
            },
            description: {
                required: true
            },
            keyword: {
                required: true
            },
        },
        messages: {
            name: "<small style='color: red;'>{{$validation['name_required']}}</small>",
            robot: "<small style='color: red;'>{{$validation['robot_required']}}</small>",
            description: "<small style='color: red;'>{{$validation['description_required']}}</small>",
            keyword: "<small style='color: red;'>{{$validation['keyword_required']}}</small>",
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == "name") {
                error.appendTo(".error-name");
            }
            if (element.attr("name") == "robot") {
                error.appendTo(".error-robot");
            }
            if (element.attr("name") == "description") {
                error.appendTo(".error-description");
            }
            if (element.attr("name") == "keyword") {
                error.appendTo(".error-keyword");
            }
        },
    });

    $('#meta-store-submit').click(function () {
        let a = $("#meta-store-form").valid();
        if (a === true) {
            $("#meta-store-form").submit();
        } else {
            return false;
        }
    });

    $('#meta-update-submit').click(function () {
        let a = $("#meta-update-form").valid();
        if (a === true) {
            $("#meta-update-form").submit();
        } else {
            return false;
        }
    });
</script>
@endpush
