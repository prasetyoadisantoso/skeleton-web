{{-- Menggunakan layout yang sama dengan Component --}}
@extends('template.default.backend.page.index')

{{-- Menggunakan nama section yang sama polanya dengan Component --}}
@section('section-home')

{{-- Start Breadcrumb (Copy dari Component) --}}
<nav class="bg-light py-3 px-2 px-md-5 shadow-sm d-flex justify-content-between" aria-label="breadcrumb">
    {{-- Ganti ikon dan teks --}}
    <h5 class="my-0"><i class="fa-solid fa-layer-group me-3"></i>{{ $breadcrumb['title'] ?? 'Sections' }}</h5>
    <ol class="breadcrumb my-0">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard.main') }}" class="text-decoration-none text-dark">
                {{ $breadcrumb['home'] ?? 'Home' }}
            </a>
        </li>
        <li class="breadcrumb-item active text-muted" aria-current="page">
            {{-- Ganti teks --}}
            {{ $breadcrumb['index'] ?? 'Index' }}
        </li>
    </ol>
</nav>
{{-- End Breadcrumb --}}

{{-- Start Home Content (Copy dari Component) --}}
<div class="container py-3">

    {{-- Start Card (Copy dari Component) --}}
    <div class="card" id="section-home-card"> {{-- ID unik untuk Section --}}
        <div class="card-header">
            <div class="d-flex justify-content-between">
                {{-- Grup Tombol Kiri (Bulk Delete) --}}
                <div class="align-self-center">
                    {{-- Ganti permission --}}
                    @can('section-destroy')
                    {{-- Ganti ID tombol --}}
                    <button type="button" class="btn btn-danger" id="bulkDeleteSectionButton" style="display: none;">
                        <i class="fas fa-trash me-2"></i> {{ $button['delete_selected'] ?? 'Delete Selected' }}
                    </button>
                    @endcan
                </div>
                {{-- Judul Card --}}
                {{-- Ganti teks --}}
                <h5 class="align-self-center my-0">{{ $datatable['header']['title'] ?? 'Section Management' }}</h5>
                {{-- Tombol Create --}}
                {{-- Ganti permission dan route --}}
                @can('section-create')
                <a href="{{ route('section.create') }}" class="btn btn-success">
                    {{ $button['create'] ?? 'Create' }} <i class="fa-solid fa-plus ms-2"></i>
                </a>
                @endcan
            </div>
        </div>
        <div class="card-body">
            {{-- Start Table (Copy dari Component) --}}
            {{-- Ganti ID tabel --}}
            <table id="sectionTable" class="table table-bordered dt-responsive nowrap table-striped align-middle w-100">
                <thead>
                    <tr>
                        {{-- Checkbox Column --}}
                        <th scope="col" style="width: 10px;">
                            <div class="form-check">
                                {{-- Ganti ID checkbox header --}}
                                <input class="form-check-input fs-15" type="checkbox" id="checkAllSections"
                                    value="option">
                            </div>
                        </th>
                        {{-- Data Columns --}}
                        <th>{{ $datatable['table']['number'] ?? 'No' }}</th>
                        <th>{{ $datatable['table']['name'] ?? 'Name' }}</th>
                        <th>{{ $datatable['table']['description'] ?? 'Description' }}</th>
                        <th>{{ $datatable['table']['column_layout'] ?? 'Columns' }}</th>
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

{{-- Menggunakan stack yang sama polanya dengan Component --}}
@push('section-home-js')
{{-- Include file JS yang sesuai untuk Section --}}
@include('template.default.backend.module.template.section.script.home-js')
@endpush
