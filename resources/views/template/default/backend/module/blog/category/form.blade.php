@extends('template.default.backend.page.index')

@section('category-form')

<!-- Start Breadcrumb -->
<nav class="bg-light py-3 px-2 px-md-5 shadow-sm d-flex justify-content-between" aria-label="breadcrumb">
    <h5 class="my-0"><i class="fa-solid fa-tags me-3"></i>{{$breadcrumb['title']}}</h5>
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
<div class="container py-3 w-100 w-md-75">

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
            <!-- Start Create Category -->
            <div class="container-fluid">
                @if ($type == 'create')
                <form action="{{route('category.store')}}" method="POST" id="category-store-form">
                @endif

                @if ($type == 'edit')
                <form action="{{route('category.update', $category->id)}}" method="POST" id="category-update-form">
                @method('PUT')
                @endif

                    @csrf
                    <div class="form-group mx-3 my-3">
                        <label for="inputName" class="">{{$form['name']}}</label>
                        <div class="mb-3">
                            <input name="name" type="text" class="form-control" id="name"
                                placeholder="{{$form['name_placeholder']}}" value="{{$type == "edit" &&
                                isset($category) ? $category->name : ''}}" required>
                            <div class="error-name"></div>
                        </div>
                        <label for="inputSlug" class="">{{$form['slug']}}</label>
                        <div class="mb-3">
                            <input name="slug" type="text" class="form-control" id="slug"
                                placeholder="{{$form['slug_placeholder']}}" value="{{$type == "edit" &&
                                isset($category) ? $category->slug : ''}}">
                            <div class="error-slug"></div>
                        </div>
                        <label for="inputParent" class="">{{$form['parent']}} </label>
                        <div class="mb-3">
                            <select name="parent" type="text" id="parent" class="form-select" aria-label="Default select example">
                                <option value="">{{$form['parent_placeholder']}}</option>

                                @foreach ($category_select as $select)

                                @if ($type == 'create')
                                <option value="{{$select->id}}" style="text-transform: capitalize;">
                                    {{$select->name}}</option>
                                @endif

                                @if ($type == 'edit')
                                <option {{ isset($category_parent) && $select->name == $category_parent->name ? 'selected' : '' }}
                                    value="{{$select->id}}" style="text-transform:
                                    capitalize;">{{$select->name}}
                                </option>
                                @endif

                                @endforeach
                            </select>
                            <div class="error-parent"></div>
                        </div>
                        <div class="mb-3">
                            @if ($type == 'create')
                            @can ("category-store")
                            <button id="category-store-submit" type="submit" class="btn btn-success w-100">
                                {{$button['store']}}<i class="fas fa-save ms-2"></i>
                            </button>
                            @endcan
                            @endif

                            @if ($type == 'edit')
                            @can ("category-update")
                            <button id="category-update-submit" type="submit" class="btn btn-success w-100">
                                {{$button['update']}}<i class="fas fa-save ms-2"></i>
                            </button>
                            @endcan
                            @endif
                        </div>
                    </div>
                </form>
            </div>
            <!-- End Create Category -->
        </div>
        <div class="card-footer py-4">
        </div>
    </div>
    <!-- End app -->

</div>
<!-- End Home -->
@endsection

@push('category-form-js')
<script>
    let current_id = document.querySelector("form").id;
    $("#" + current_id).validate({
        rules: {
            name: {
                required: true
            },
        },
        messages: {
            name: "<small style='color: red;'>{{$validation['name_required']}}</small>",
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == "name") {
                error.appendTo(".error-name");
            }
        },
    });

    $('#category-store-submit').click(function () {
        let a = $("#category-store-form").valid();
        if (a === true) {
            $("#category-store-form").submit();
        } else {
            return false;
        }
    });

    $('#category-update-submit').click(function () {
        let a = $("#category-update-form").valid();
        if (a === true) {
            $("#category-update-form").submit();
        } else {
            return false;
        }
    });
</script>
@endpush
