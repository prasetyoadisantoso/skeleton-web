@extends('template.default.backend.page.index')

@section('component-form') {{-- Pastikan nama section ini unik atau sesuai --}}

{{-- Start Breadcrumb (Bootstrap 5 Style) --}}
<nav class="bg-light py-3 px-2 px-md-5 shadow-sm d-flex justify-content-between" aria-label="breadcrumb">
    <h5 class="my-0"><i class="fa-solid fa-puzzle-piece me-3"></i>{{ $breadcrumb['title'] ?? 'Components'
        }}</h5>
    <ol class="breadcrumb my-0">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard.main') }}" class="text-decoration-none text-dark">
                {{ $breadcrumb['home'] ?? 'Home' }}
            </a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('component.index') }}" class="text-decoration-none text-dark">
                {{ $breadcrumb['title'] ?? 'Components' }}
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

{{-- Start Form Content --}}
<div class="container py-3">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0 text-center">
                @if ($type == 'create')
                {{ $form['create_title'] ?? 'Create Component' }}
                @else
                {{ $form['edit_title'] ?? 'Edit Component' }}
                @endif
            </h5>
        </div>
        <div class="card-body">
            {{-- Start Form --}}
            <form
                action="{{ $type == 'create' ? route('component.store') : route('component.update', $componentData->id) }}"
                method="POST" id="component-form"> {{-- Beri ID unik --}}
                @csrf
                @if ($type == 'edit')
                @method('PUT')
                @endif

                <div class="row">
                    {{-- Input Name --}}
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">{{ $form['name'] ?? 'Name :' }} <span
                                class="text-danger">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $componentData->name ?? '') }}"
                            class="form-control @error('name') is-invalid @enderror"
                            placeholder="{{ $form['name_placeholder'] ?? 'Insert name...' }}" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Input Is Active (Pindah ke kolom kedua agar sejajar) --}}
                    <div class="col-md-6 mb-3 d-flex align-items-center pt-md-3"> {{-- Adjust alignment --}}
                        <div class="form-check form-switch form-switch-lg"> {{-- Gunakan form-switch untuk tampilan
                            toggle --}}
                            <input class="form-check-input" type="checkbox" role="switch" id="is_active"
                                name="is_active" value="on" {{ old('is_active', $componentData->is_active ?? false) ?
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
                        <label for="description" class="form-label">{{ $form['description'] ?? 'Description
                            :' }}</label>
                        <textarea id="description" name="description" rows="4"
                            class="form-control @error('description') is-invalid @enderror"
                            placeholder="{{ $form['description_placeholder'] ?? 'Insert description...' }}">{{ old('description', $componentData->description ?? '') }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Kolom Gambar Tersedia -->
                    <div class="col-md-5">
                        <h5>{{ $contentimage_trans['title'] ?? 'Available Images' }}</h5>
                        <input type="text" id="image-search" class="form-control mb-2" placeholder="Search images...">
                        <div id="available-images"
                            style="height: 300px; overflow-y: auto; border: 1px solid #ccc; padding: 10px;">
                            @foreach($availableImages as $image)
                            <div class="image-item mb-1 p-1 border" data-id="{{ $image->id }}">
                                {{ $image->name }}
                                <button type="button" class="btn btn-sm btn-success float-end add-image-btn">+</button>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Kolom Gambar Terpilih (Bisa Diurutkan) -->
                    <div class="col-md-7">
                        <h5>{{ $component['form']['selected_content_images'] ?? 'Selected Images (Drag to Reorder)' }}
                        </h5>
                        <div id="selected-images-list" class="list-group"
                            style="min-height: 300px; border: 1px solid #ccc; padding: 10px;">
                            {{-- Gambar terpilih akan ditambahkan di sini oleh JS --}}
                            {{-- Untuk Edit: Loop $selectedImages dan render di sini saat load --}}
                            @if(isset($selectedImages) && !$selectedImages->isEmpty())
                            @foreach($selectedImages as $image)
                            <div class="list-group-item selected-image-item" data-id="{{ $image->id }}">
                                {{ $image->name }}
                                <button type="button"
                                    class="btn btn-sm btn-danger float-end remove-image-btn">-</button>
                                <span class="handle" style="cursor: move; margin-left: 10px;">&#x2630;</span> {{--
                                Handle Drag --}}
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>

                    <input type="hidden" name="content_images_order" id="content_images_order_input"
                        value="{{ old('content_images_order', $initialImageOrderJson ?? '[]') }}">
                    {{-- End Content Image Relation --}}


                    {{-- --- START CONTENT TEXT RELATION --- --}}
                    <div class="col-12 mt-4 mb-2">
                        <hr>
                        <h5>{{ $contenttext_trans['relation_title'] ?? 'Manage Content Texts' }}</h5>
                    </div>
                    <!-- Kolom Text Tersedia -->
                    <div class="col-md-5">
                        <h6>{{ $contenttext_trans['available_title'] ?? 'Available Texts' }}</h6>
                        <input type="text" id="text-search" class="form-control mb-2" placeholder="Search texts...">
                        {{-- Struktur dan style disamakan dengan available-images --}}
                        <div id="available-texts"
                            style="height: 300px; overflow-y: auto; border: 1px solid #ccc; padding: 10px;">
                            @foreach($availableTexts as $text)
                            {{-- Struktur dan class disamakan dengan image-item --}}
                            <div class="text-item mb-1 p-1 border" data-id="{{ $text->id }}">
                                {{-- Tampilkan preview text --}}
                                <small><i>[{{ $text->type }}]</i></small> - {{
                                \Illuminate\Support\Str::limit(strip_tags($text->content), 50) }}
                                {{-- Tombol Add --}}
                                <button type="button" class="btn btn-sm btn-success float-end add-text-btn">+</button>
                                {{-- Class unik --}}
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- Kolom Text Terpilih (Bisa Diurutkan) -->
                    <div class="col-md-7">
                        <h6>{{ $component['form']['selected_content_texts'] ?? 'Selected Texts (Drag to Reorder)' }}
                        </h6>
                        {{-- Struktur dan style disamakan dengan selected-images-list --}}
                        <div id="selected-texts-list" class="list-group"
                            style="min-height: 300px; border: 1px solid #ccc; padding: 10px;">
                            @if(isset($selectedTexts) && !$selectedTexts->isEmpty())
                            @foreach($selectedTexts as $text)
                            {{-- Struktur dan class disamakan dengan selected-image-item --}}
                            <div class="list-group-item selected-text-item" data-id="{{ $text->id }}"> {{-- Class unik
                                --}}
                                {{-- Tampilkan preview text --}}
                                <small><i>[{{ $text->type }}]</i></small> - {{
                                \Illuminate\Support\Str::limit(strip_tags($text->content), 50) }}
                                {{-- Tombol Remove --}}
                                <button type="button" class="btn btn-sm btn-danger float-end remove-text-btn">-</button>
                                {{-- Class unik --}}
                                {{-- Handle Drag (disamakan) --}}
                                <span class="handle" style="cursor: move; margin-left: 10px;">&#x2630;</span>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                    {{-- Input Hidden untuk Text --}}
                    <input type="hidden" name="content_texts_order" id="content_texts_order_input"
                        value="{{ old('content_texts_order', $initialTextOrderJson ?? '[]') }}"> {{-- ID & variable unik
                    --}}
                    {{-- --- END CONTENT TEXT RELATION --- --}}



                    {{-- Button --}}
                    <div class="col-12 mt-5">
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('component.index') }}" class="btn btn-danger w-100 w-md-25">
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


@endsection @push('component-form-js')
@include('template.default.backend.module.template.component.script.form-js')
@endpush
