@extends('template.default.backend.page.index')

@section('schema-form')

<!-- Start Breadcrumb -->
<nav class="bg-light py-3 px-2 px-md-5 shadow-sm d-flex justify-content-between" aria-label="breadcrumb">
    <h5 class="my-0"><i class="fa-solid fa-signs-post me-3"></i>{{$breadcrumb['title']}}</h5>
    <ol class="breadcrumb my-0">
        <li class="breadcrumb-item"><a href="{{route($url)}}"
                class="text-decoration-none text-dark">{{$breadcrumb['home']}}</a>
        </li>
        <li class="breadcrumb-item active text-muted" aria-current="page">
            {{$type == 'index' ? $breadcrumb['index'] : ''}}
            {{$type == 'create' ? $breadcrumb['create'] : ''}}
            {{$type == 'edit' ? $breadcrumb['edit'] : ''}}
        </li>
    </ol>
</nav>
<!-- End Breadcrumb -->

<!-- Start Home -->
<div class="container py-3 w-100">

    <!-- Start app -->
    <div class="card" id="category-create">
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
            <!-- Start Create Post -->
            <div class="container-fluid">
                @if ($type == 'create')
                <form action="{{route('schema.store')}}" method="POST" id="schema-store-form">
                    @endif

                    @if ($type == 'edit')
                    <form action="{{route('schema.update', $schema->id)}}" method="POST" id="schema-update-form">
                        @method('PUT')
                        @endif

                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="mb-3">
                                        <label for="schema_type" class="form-label">{{$form['schema_name'] ?? 'Schema
                                            Name'}}</label>
                                        <input name="schema_name" type="text" class="form-control" id="schema_name"
                                            placeholder="{{$form['schema_name_placeholder'] ?? 'Enter schema name...'}}"
                                            value="{{$type == 'edit' ? $schema->schema_name : ''}}" required>
                                        <div class="error-schema-name"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="schema_type" class="form-label">{{$form['schema_type'] ?? 'Schema
                                            Type'}}</label>
                                        <input name="schema_type" type="text" class="form-control" id="schema_type"
                                            placeholder="{{$form['schema_type_placeholder'] ?? 'Enter schema type'}}"
                                            value="{{$type == 'edit' ? $schema->schema_type : ''}}" required>
                                        <div class="error-schema-type"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="schema_content" class="form-label">{{$form['schema_content'] ??
                                            'Schema Content'}}</label>

                                        <textarea class="form-control" id="schema_content" name="schema_content"
                                            rows="10"
                                            placeholder="{{$form['schema_content_placeholder'] ?? 'Enter JSON-LD schema content'}}"
                                            required>{{$type == 'edit' ? $schema->schema_content : ''}}</textarea>
                                        <div class="error-schema-content"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
            </div>
            <!-- End Create Post -->
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-center">
                @if ($type == 'create')
                @can ("schema-store")
                <button id="schema-store-submit" type="submit" class="btn btn-success w-100 w-md-25">
                    {{$button['store']}}<i class="fas fa-save ms-2"></i>
                </button>
                @endcan
                @endif

                @if ($type == 'edit')
                @can ("schema-update")
                <button id="schema-update-submit" type="submit" class="btn btn-success w-100 w-md-25">
                    {{$button['update']}}<i class="fas fa-save ms-2"></i>
                </button>
                @endcan
                @endif
            </div>
        </div>
    </div>
    <!-- End app -->

</div>
<!-- End Home -->

@endsection

@push('schema-form-js')

<script alt="jquery-validation">
    let current_id = document.querySelector("form").id;

    $("#" + current_id).validate({
        rules: {
            schema_name: {
                required: true
            },
            schema_type: {
                required: true
            },
            schema_content: {
                required: true,
                json: true // Add custom JSON validation rule (see below)
            }
        },
        messages: {
            title: "<small style='color: red;'>Title is required</small>",
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == "schema_name") {
                error.appendTo(".error-schema-name");
            }

            if (element.attr("name") == "schema_type") {
                error.appendTo(".error-schema-type");
            } else if (element.attr("name") == "schema_content") {
                error.appendTo(".error-schema-content");
            }

        }
    });

    // Custom JSON validation method
    $.validator.addMethod("json", function(value, element) {
        try {
            JSON.parse(value);
            return true;
        } catch (e) {
            return false;
        }
    }, "Please enter valid JSON.");

    $('#schema-store-submit').click(function() {
        let a = $("#schema-store-form").valid();
        console.log(a);
        if (a === true) {
            $("#schema-store-form").submit();
        } else {
            return false;
        }
    });

    $('#schema-update-submit').click(function() {
        let a = $("#schema-update-form").valid();
        if (a === true) {
            $("#schema-update-form").submit();
        } else {
            return false;
        }
    });

</script>
@endpush
