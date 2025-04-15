@extends('template.default.backend.page.index')

@section('component-home') {{-- Pastikan nama section ini unik atau sesuai --}}

{{-- Start Breadcrumb (Bootstrap 5 Style) --}}
<nav class="bg-light py-3 px-2 px-md-5 shadow-sm d-flex justify-content-between" aria-label="breadcrumb">
    <h5 class="my-0"><i class="fa-solid fa-puzzle-piece me-3"></i>{{ $breadcrumb['title'] ?? 'Components' }}</h5>
    <ol class="breadcrumb my-0">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard.main') }}" class="text-decoration-none text-dark">
                {{ $breadcrumb['home'] ?? 'Home' }}
            </a>
        </li>
        <li class="breadcrumb-item active text-muted" aria-current="page">
            {{ $breadcrumb['index'] ?? 'Index' }}
        </li>
    </ol>
</nav>
{{-- End Breadcrumb --}}

{{-- Start Home Content --}}
<div class="container py-3">

    {{-- Start Card --}}
    <div class="card" id="component-home-card"> {{-- Beri ID unik jika perlu --}}
        <div class="card-header">
            <div class="d-flex justify-content-between">
                {{-- Grup Tombol Kiri (Bulk Delete) --}}
                <div class="align-self-center">
                    @can('component-destroy')
                    <button type="button" class="btn btn-danger" id="bulkDeleteButton" style="display: none;">
                        <i class="fas fa-trash me-2"></i> {{ $button['delete_selected'] ?? 'Delete Selected' }}
                    </button>
                    @endcan
                </div>
                {{-- Judul Card --}}
                <h5 class="align-self-center my-0">{{ $datatable['header']['title'] ?? 'Component Management' }}</h5>
                {{-- Tombol Create --}}
                @can('component-create')
                <a href="{{ route('component.create') }}" class="btn btn-success">
                    {{ $button['create'] ?? 'Create' }} <i class="fa-solid fa-plus ms-2"></i> {{-- Ganti ikon jika perlu --}}
                </a>
                @endcan
            </div>
        </div>
        <div class="card-body">
            {{-- Start Table --}}
            <table id="componentTable" class="table table-bordered dt-responsive nowrap table-striped align-middle w-100">
                <thead>
                    <tr>
                        {{-- Checkbox Column --}}
                        <th scope="col" style="width: 10px;">
                            <div class="form-check">
                                {{-- ID diubah agar unik jika ada tabel lain --}}
                                <input class="form-check-input fs-15" type="checkbox" id="checkAllComponents" value="option">
                            </div>
                        </th>
                        {{-- Data Columns --}}
                        <th>{{ $datatable['table']['number'] ?? 'No' }}</th>
                        <th>{{ $datatable['table']['name'] ?? 'Name' }}</th>
                        <th>{{ $datatable['table']['description'] ?? 'Description' }}</th>
                        <th>{{ $datatable['table']['status'] ?? 'Status' }}</th>
                        <th>{{ $datatable['table']['action'] ?? 'Action' }}</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- DataTable will populate this --}}
                </tbody>
            </table>
            {{-- End Table --}}
        </div>
    </div>
    {{-- End Card --}}

</div>
{{-- End Home Content --}}

@endsection

@push('component-home-js')
    {{-- Pastikan path include benar --}}
    @include('template.default.backend.module.template.component.script.home-js')
@endpush
