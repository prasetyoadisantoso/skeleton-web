@extends('template.default.backend.page.index')

@section('page-form')

{{-- Start Breadcrumb --}}
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
            <a href="{{ route('page.index') }}" class="text-decoration-none text-dark">
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

<!-- Start Home -->
<div class="container py-3">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0 text-center">
                {{ $type == 'create' ? $form['create_title'] : $form['edit_title'] }}
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ $type == 'create' ? route('page.store') : route('page.update', $page->id) }}"
                method="POST" id="page-form-multi">
                @csrf
                @if($type == 'edit')
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label for="title" class="form-label">{{ $form['title'] }}</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $page->title ?? '') }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="slug" class="form-label">{{ $form['slug'] }}</label>
                    <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug', $page->slug ?? '') }}">
                    @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">{{ $form['content'] }}</label>
                    <textarea class="form-control" id="content" name="content" rows="5">{{ old('content', $page->content ?? '') }}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="layout_id" class="form-label">{{ $form['layout'] }}</label>
                    <select class="form-select" id="layout_id" name="layout_id">
                        <option value="">{{ $form['select_layout'] }}</option>
                        @foreach ($layouts as $layout)
                            <option value="{{ $layout->id }}" {{ (isset($page) && $page->layout_id == $layout->id) ? 'selected' : '' }}>{{ $layout->name }}</option>
                        @endforeach
                    </select>
                    @error('layout_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                 <div class="mb-3">
                    <label for="meta_id" class="form-label">{{ $form['meta'] }}</label>
                    <select class="form-select" id="meta_id" name="meta_id">
                        <option value="">{{ $form['select_meta'] }}</option>
                        @foreach ($metas as $meta)
                            <option value="{{ $meta->id }}" {{ (isset($page) && $page->meta_id == $meta->id) ? 'selected' : '' }}>{{ $meta->title }}</option>
                        @endforeach
                    </select>
                    @error('meta_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="opengraph_id" class="form-label">{{ $form['opengraph'] }}</label>
                    <select class="form-select" id="opengraph_id" name="opengraph_id">
                        <option value="">{{ $form['select_opengraph'] }}</option>
                        @foreach ($opengraphs as $opengraph)
                            <option value="{{ $opengraph->id }}" {{ (isset($page) && $page->opengraph_id == $opengraph->id) ? 'selected' : '' }}>{{ $opengraph->og_title }}</option>
                        @endforeach
                    </select>
                    @error('opengraph_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="canonical_id" class="form-label">{{ $form['canonical'] }}</label>
                    <select class="form-select" id="canonical_id" name="canonical_id">
                        <option value="">{{ $form['select_canonical'] }}</option>
                        @foreach ($canonicals as $canonical)
                            <option value="{{ $canonical->id }}" {{ (isset($page) && $page->canonical_id == $canonical->id) ? 'selected' : '' }}>{{ $canonical->url }}</option>
                        @endforeach
                    </select>
                    @error('canonical_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="schema_id" class="form-label">{{ $form['schema'] }}</label>
                    <select class="form-select" id="schemadata_id" name="schemadata_id">
                        <option value="">{{ $form['select_schema'] }}</option>
                        @foreach ($schemas as $schema)
                            <option value="{{ $schema->id }}" {{ (isset($page) && $page->schemadata_id == $schema->id) ? 'selected' : '' }}>{{ $schema->schema_name }}</option>
                        @endforeach
                    </select>
                    @error('schemadata_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-success">
                        {{ $type == 'create' ? $button['create'] : "" }}
                        {{ $type == 'edit' ? $button['update'] : "" }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Home -->
@endsection

@push('page-form-js')
<script>
    // Basic form validation example
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('page-form-multi');

        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }

            form.classList.add('was-validated');
        });
    });
</script>
@endpush
