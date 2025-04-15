{{-- Menggunakan layout yang sama dengan Component --}}
@extends('template.default.backend.page.index')

{{-- Menggunakan nama section yang sama polanya dengan Component --}}
@section('section-form')

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
        <li class="breadcrumb-item">
            {{-- Ganti route dan teks --}}
            <a href="{{ route('section.index') }}" class="text-decoration-none text-dark">
                {{ $breadcrumb['title'] ?? 'Sections' }}
            </a>
        </li>
        <li class="breadcrumb-item active text-muted" aria-current="page">
            @if ($type == 'create')
            {{ $breadcrumb['create'] ?? 'Create' }}
            @else
            {{ $breadcrumb['edit'] ?? 'Edit' }}
            @endif
        </li>
    </ol>
</nav>
{{-- End Breadcrumb --}}

{{-- Start Form Content (Copy dari Component) --}}
<div class="container py-3">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0 text-center">
                @if ($type == 'create')
                {{-- Ganti teks --}}
                {{ $form['create_title'] ?? 'Create Section' }}
                @else
                {{-- Ganti teks --}}
                {{ $form['edit_title'] ?? 'Edit Section' }}
                @endif
            </h5>
        </div>
        <div class="card-body">
            {{-- Start Form (Copy dari Component) --}}
            <form action="{{ $type == 'create' ? route('section.store') : route('section.update', $sectionData->id) }}"
                method="POST" id="section-form"> {{-- ID unik untuk Section --}}
                @csrf
                @if ($type == 'edit')
                @method('PUT')
                @endif

                <div class="row">
                    {{-- Input Name --}}
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">{{ $form['name'] ?? 'Name :' }} <span
                                class="text-danger">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $sectionData->name ?? '') }}"
                            class="form-control @error('name') is-invalid @enderror"
                            placeholder="{{ $form['name_placeholder'] ?? 'Insert name...' }}" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Input Is Active (Pindah ke kolom kedua agar sejajar) --}}
                    <div class="col-md-6 mb-3 d-flex align-items-center pt-md-3"> {{-- Adjust alignment --}}
                        <div class="form-check form-switch form-switch-lg"> {{-- Gunakan form-switch --}}
                            {{-- Default ke false seperti Component --}}
                            <input class="form-check-input" type="checkbox" role="switch" id="is_active"
                                name="is_active" value="on" {{ old('is_active', $sectionData->is_active ?? false) ?
                            'checked' : '' }}>
                            <label class="form-check-label" for="is_active">{{ $form['is_active'] ??
                                'Active Status' }}</label>
                        </div>
                        @error('is_active') {{-- Error message di bawah switch --}}
                        <div class="text-danger ms-3">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Input Description --}}
                    <div class="col-12 mb-3">
                        <label for="description" class="form-label">{{ $form['description'] ?? 'Description :'
                            }}</label>
                        <textarea id="description" name="description" rows="4"
                            class="form-control @error('description') is-invalid @enderror"
                            placeholder="{{ $form['description_placeholder'] ?? 'Insert description...' }}">{{ old('description', $sectionData->description ?? '') }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Input Layout Type (Jumlah Kolom) --}}
                    <div class="col-md-6 mb-3">
                        {{-- Gunakan key translasi yang diperbarui --}}
                        <label for="layout_type" class="form-label">{{ $section_trans['form']['column_layout'] ?? 'Column Layout' }} <span class="text-danger">*</span></label>
                        <select class="form-select @error('layout_type') is-invalid @enderror" id="layout_type" name="layout_type" required>
                            {{-- Gunakan key translasi yang diperbarui --}}
                            <option value="" disabled {{ old('layout_type', $sectionData->layout_type ?? null) == null ? 'selected' : '' }}>{{ $section_trans['form']['select_column_layout'] ?? 'Select column layout...' }}</option>
                            {{-- Loop melalui $columnLayouts dari controller --}}
                            @foreach ($columnLayouts as $key => $value)
                                <option value="{{ $key }}" {{ old('layout_type', $sectionData->layout_type ?? null) == $key ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                        @error('layout_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    {{-- --- START COMPONENT RELATION --- --}}
                    <div class="col-12 mt-4 mb-2">
                        <hr>
                        {{-- Ganti judul --}}
                        <h5>{{ $section_trans['form']['selected_components'] ?? 'Manage Components' }}</h5>
                    </div>

                    <!-- Kolom Komponen Tersedia -->
                    <div class="col-md-5">
                        {{-- Ganti judul --}}
                        <h6>{{ $section_trans['form']['select_components'] ?? 'Available Components' }}</h6>
                        {{-- Ganti ID search --}}
                        <input type="text" id="component-search" class="form-control mb-2"
                            placeholder="Search components...">
                        {{-- Ganti ID container --}}
                        <div id="available-components"
                            style="height: 300px; overflow-y: auto; border: 1px solid #ccc; padding: 10px;">
                            @foreach($availableComponents as $component)
                            {{-- Ganti class item dan tombol --}}
                            <div class="component-item mb-1 p-1 border" data-id="{{ $component->id }}">
                                {{ $component->name }}
                                <button type="button"
                                    class="btn btn-sm btn-success float-end add-component-btn">+</button>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Kolom Komponen Terpilih (Bisa Diurutkan) -->
                    <div class="col-md-7">
                        {{-- Ganti judul --}}
                        <h6>{{ $section_trans['form']['selected_components'] ?? 'Selected Components (Drag to Reorder)'
                            }}</h6>
                        {{-- Ganti ID container --}}
                        <div id="selected-components-list" class="list-group"
                            style="min-height: 300px; border: 1px solid #ccc; padding: 10px;">
                            {{-- Untuk Edit: Loop $selectedComponents --}}
                            @if(isset($selectedComponents) && !$selectedComponents->isEmpty())
                            @foreach($selectedComponents as $component)
                            {{-- Ganti class item dan tombol --}}
                            <div class="list-group-item selected-component-item" data-id="{{ $component->id }}">
                                {{ $component->name }}
                                <button type="button"
                                    class="btn btn-sm btn-danger float-end remove-component-btn">-</button>
                                <span class="handle" style="cursor: move; margin-left: 10px;">&#x2630;</span> {{--
                                Handle Drag --}}
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>

                    {{-- Ganti nama dan ID input hidden --}}
                    <input type="hidden" name="components_order" id="components_order_input"
                        value="{{ old('components_order', $initialComponentOrderJson ?? '[]') }}">
                    {{-- --- END COMPONENT RELATION --- --}}


                    {{-- Button (Copy dari Component) --}}
                    <div class="col-12 mt-5">
                        <div class="d-flex justify-content-center gap-2">
                            {{-- Ganti route --}}
                            <a href="{{ route('section.index') }}" class="btn btn-danger w-100 w-md-25">
                                {{ $button['cancel'] ?? 'Cancel' }} <i class="fas fa-times ms-2"></i>
                            </a>
                            <button type="submit" class="btn btn-success w-100 w-md-25">
                                @if ($type == 'create')
                                {{ $button['create'] ?? 'Create' }} <i class="fas fa-save ms-2"></i>
                                @else
                                {{ $button['update'] ?? 'Update' }} <i class="fas fa-save ms-2"></i>
                                @endif
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            {{-- End Form --}}
        </div>
    </div>
</div>
{{-- End Form Content --}}

@endsection

{{-- Menggunakan stack yang sama polanya dengan Component --}}
@push('section-form-js')
{{-- Include file JS yang sesuai untuk Section --}}
@include('template.default.backend.module.template.section.script.form-js')
@endpush
