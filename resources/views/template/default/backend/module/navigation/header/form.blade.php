@extends('template.default.backend.page.index')

@section('headermenu-form')

<!-- Start Breadcrumb -->
<nav class="bg-light py-3 px-2 px-md-5 shadow-sm d-flex justify-content-between" aria-label="breadcrumb">
    <h5 class="my-0"><i class="fa-solid fa-signs-post me-3"></i>{{$breadcrumb['title'] ?? "Header Menu Management"}}
    </h5>
    <ol class="breadcrumb my-0">
        <li class="breadcrumb-item"><a href="{{route($url)}}"
                class="text-decoration-none text-dark">{{$breadcrumb['home'] ?? "Home"}}</a>
        </li>
        <li class="breadcrumb-item active text-muted" aria-current="page">
            {{$type == 'index' ? $breadcrumb['index'] ?? "Index" : ''}}
            {{$type == 'create' ? $breadcrumb['create'] ?? "Create" : ''}}
            {{$type == 'edit' ? $breadcrumb['edit'] ?? "Edit" : ''}}
        </li>
    </ol>
</nav>
<!-- End Breadcrumb -->

<!-- Start Home -->
<div class="container py-3 mw-100 mx-0">

    <!-- Start app -->
    <div class="card" id="category-create">
        <div class="card-header pt-3">
            <div class="d-flex justify-content-center">
                @if ($type == 'create')
                <h5 class="align-self-center">{{$form['create_title'] ?? "Create Menu"}}</h5>
                @endif
                @if ($type == 'edit')
                <h5 class="align-self-center">{{$form['edit_title'] ?? "Edit Menu"}}</h5>
                @endif
            </div>
        </div>
        <div class="card-body">
            <!-- Start Create Post -->
            <div class="container-fluid">

                <form action="{{ $type == 'edit' ? route('headermenu.update', $menu) : route('headermenu.store') }}"
                    method="POST" id={{ $type=='create' ? 'headermenu-store-form' : 'headermenu-update-form' }}>
                    @csrf
                    @if($type == 'edit')
                    @method('PUT')
                    @endif

                    <div class="mb-3">
                        <label for="name" class="form-label">{{$form['name'] ?? 'Nama'}} <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="{{$form['name_placeholder'] ?? 'Masukkan nama menu...'}}"
                            value="{{ old('name', isset($menu) ? $menu->name : '') }}" required>
                        <small class="text-muted">{{$form['name_help'] ?? 'Nama unik untuk identifikasi
                            internal.'}}</small>
                    </div>

                    <div class="mb-3">
                        <label for="label" class="form-label">{{$form['label'] ?? 'Label'}} <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="label" name="label"
                            placeholder="{{$form['label_placeholder'] ?? 'Masukkan label...'}}"
                            value="{{ old('label', isset($menu) ? $menu->label : '') }}" required>
                        <small class="text-muted">{{$form['label_help'] ?? 'Teks yang ditampilkan di menu.'}}</small>
                    </div>

                    <div class="mb-3">
                        <label for="url" class="form-label">{{$form['url'] ?? 'URL'}}</label>
                        <input type="text" class="form-control" id="url" name="url"
                            placeholder="{{$form['url_placeholder'] ?? 'Masukkan URL...'}}"
                            value="{{ old('url', isset($menu) ? $menu->url : '') }}">
                        <small class="text-muted">{{$form['url_help'] ?? 'URL yang dituju (bisa eksternal atau
                            internal).'}}</small>
                    </div>

                    <div class="mb-3">
                        <label for="icon" class="form-label">{{$form['icon'] ?? 'Icon'}}</label>
                        <input type="text" class="form-control" id="icon" name="icon"
                            placeholder="{{$form['icon_placeholder'] ?? 'Masukkan kelas ikon...'}}"
                            value="{{ old('icon', isset($menu) ? $menu->icon : '') }}">
                        <small class="text-muted">{{$form['icon_help'] ?? 'Class CSS untuk icon (misalnya
                            FontAwesome).'}}</small>
                    </div>

                    <div class="mb-3">
                        <label for="parent_id" class="form-label">{{$form['parent'] ?? 'Parent'}}</label>
                        <select class="form-select" id="parent_id" name="parent_id">
                            <option value="">{{$form['parent_placeholder'] ?? '- Atas -'}}</option>
                            @foreach($menus as $parentMenu)
                            <option value="{{ $parentMenu->id }}" {{ old('parent_id', isset($menu) ? $menu->parent_id :
                                '') == $parentMenu->id ? 'selected' : '' }}>{{ $parentMenu->label }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted">{{$form['parent_help'] ?? 'Pilih parent menu jika ini adalah
                            submenu.'}}</small>
                    </div>

                    <div class="mb-3">
                        <label for="order" class="form-label">{{$form['order'] ?? 'Urutan'}} <span
                                class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="order" name="order"
                            placeholder="{{$form['order_placeholder'] ?? 'Masukkan nomor urutan...'}}"
                            value="{{ old('order', isset($menu) ? $menu->order : 0) }}" required>
                        <small class="text-muted">{{$form['order_help'] ?? 'Urutan menu ditampilkan.'}}</small>
                    </div>

                    <div class="mb-3">
                        <label for="target" class="form-label">{{$form['target'] ?? 'Target'}}</label>
                        <select class="form-select" id="target" name="target">
                            <option value="_self" {{ old('target', isset($menu) ? $menu->target : '_self') == '_self' ?
                                'selected' : '' }}>{{$form['target_self'] ?? '_self (Tab Sama)'}}</option>
                            <option value="_blank" {{ old('target', isset($menu) ? $menu->target : '') == '_blank' ?
                                'selected' : '' }}>{{$form['target_blank'] ?? '_blank (Tab Baru)'}}</option>
                        </select>
                        <small class="text-muted">{{$form['target_help'] ?? 'Target untuk link menu.'}}</small>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" {{
                            old('is_active', isset($menu) ? $menu->is_active : false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">{{$form['active_label'] ?? 'Aktif'}}</label>
                    </div>

                </form>
            </div>
            <!-- End Create Post -->
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-center">
                @if ($type == 'create')
                @can ("headermenu-store")
                <button id="headermenu-store-submit" type="submit" class="btn btn-success w-100 w-md-25">
                    {{$button['store'] ?? "Save"}}<i class="fas fa-save ms-2"></i>
                </button>
                @endcan
                @endif

                @if ($type == 'edit')
                @can ("headermenu-update")
                <button id="headermenu-update-submit" type="submit" class="btn btn-success w-100 w-md-25">
                    {{$button['update'] ?? "Update"}}<i class="fas fa-save ms-2"></i>
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

@push('headermenu-form-js')
<script alt="jquery-validation">
    let current_id = document.querySelector("form").id;
    console.log(current_id)

    $("#" + current_id).validate({
        rules: {
            name: {
                required: true
            },
        },
        messages: {
            name: "<small style='color: red;'>{{ $validation['name_required'] ?? 'Name is required' }}</small>",
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == "title") {
                error.appendTo(".error-title");
            }
        },
    });

    $('#headermenu-store-submit').click(function () {
        let a = $("#headermenu-store-form").valid();
        if (a === true) {
            $("#headermenu-store-form").submit();
        } else {
            return false;
        }
    });

    $('#headermenu-update-submit').click(function () {
        let a = $("#headermenu-update-form").valid();
        if (a === true) {
            $("#headermenu-update-form").submit();
        } else {
            return false;
        }
    });

</script>
@endpush
