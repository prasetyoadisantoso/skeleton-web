@extends('template.default.backend.page.index')

@section('contenttext-form') {{-- Ganti section name --}}

{{-- Start Breadcrumb --}}
<nav class="bg-light py-3 px-2 px-md-5 shadow-sm d-flex justify-content-between" aria-label="breadcrumb">
    <h5 class="my-0"><i class="fa-solid fa-file-alt me-3"></i>{{ $breadcrumb['title'] }}</h5> {{-- Ganti ikon & var --}}
    <ol class="breadcrumb my-0">
        <li class="breadcrumb-item">
            <a href="{{ route($url) }}" class="text-decoration-none text-dark">
                {{ $breadcrumb['home'] }}
            </a>
        </li>
        <li class="breadcrumb-item active text-muted" aria-current="page">
            @if ($type == 'create') {{ $breadcrumb['create'] }}
            @elseif ($type == 'edit') {{ $breadcrumb['edit'] }}
            @endif
        </li>
    </ol>
</nav>
{{-- End Breadcrumb --}}

{{-- Start Form --}}
<div class="container py-3">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0 text-center">
                @if ($type == 'create') {{ $form['create_title'] }}
                @elseif ($type == 'edit') {{ $form['edit_title'] }}
                @endif
            </h5>
        </div>
        <div class="card-body">
            <form
                action="{{ $type == 'create' ? route('content-text.store') : route('content-text.update', $contentTextData->id) }}" {{-- Ganti route & var data --}}
                method="POST" id="contenttext-form"> {{-- Ganti ID form --}}
                @csrf
                @if ($type == 'edit')
                @method('PUT')
                @endif

                <div class="row">
                    {{-- Type Select (BARU) --}}
                    <div class="col-md-6 mb-3">
                        <label for="type" class="form-label">{{ $form['type'] ?? 'Type' }} <span class="text-danger">*</span></label>
                        <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                            <option value="" disabled {{ old('type', $contentTextData->type ?? '') == '' ? 'selected' : '' }}>{{ $form['select_type'] ?? 'Select Type...' }}</option>
                            <option value="h1" {{ old('type', $contentTextData->type ?? '') == 'h1' ? 'selected' : '' }}>Heading 1</option>
                            <option value="h2" {{ old('type', $contentTextData->type ?? '') == 'h2' ? 'selected' : '' }}>Heading 2</option>
                            <option value="h3" {{ old('type', $contentTextData->type ?? '') == 'h3' ? 'selected' : '' }}>Heading 3</option>
                            <option value="h4" {{ old('type', $contentTextData->type ?? '') == 'h4' ? 'selected' : '' }}>Heading 4</option>
                            <option value="h5" {{ old('type', $contentTextData->type ?? '') == 'h5' ? 'selected' : '' }}>Heading 5</option>
                            <option value="h6" {{ old('type', $contentTextData->type ?? '') == 'h6' ? 'selected' : '' }}>Heading 6</option>
                            <option value="paragraph" {{ old('type', $contentTextData->type ?? 'paragraph') == 'paragraph' ? 'selected' : '' }}>Paragraph</option>
                        </select>
                        @error('type')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    {{-- Content Textarea (BARU) --}}
                    <div class="col-12 mb-3">
                        <label for="content" class="form-label">{{ $form['content'] ?? 'Content' }} <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="5" placeholder="{{ $form['content_placeholder'] ?? 'Insert text content...' }}" required>{{ old('content', $contentTextData->content ?? '') }}</textarea>
                        @error('content')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    {{-- Hapus Input Image, Alt Text, Name, Caption --}}

                    {{-- Submit Buttons --}}
                    <div class="col-lg-12 mt-3">
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('content-text.index') }}" class="btn btn-danger w-100 w-md-25"> {{-- Ganti route --}}
                                {{ $button['cancel'] }} <i class="fas fa-times ms-2"></i>
                            </a>
                            @if ($type == 'create')
                            @can('contenttext-store') {{-- Ganti permission --}}
                            <button type="submit" class="btn btn-success w-100 w-md-25">
                                {{ $button['store'] }} <i class="fas fa-save ms-2"></i>
                            </button>
                            @endcan
                            @elseif ($type == 'edit')
                            @can('contenttext-update') {{-- Ganti permission --}}
                            <button type="submit" class="btn btn-success w-100 w-md-25">
                                {{ $button['update'] }} <i class="fas fa-save ms-2"></i>
                            </button>
                            @endcan
                            @endif
                        </div>
                    </div>
                </div>
                <!--end row-->
            </form>
        </div>
    </div>
</div>
{{-- End Form --}}

@endsection

@push('contenttext-form-js') {{-- Ganti push name --}}
<script type="text/javascript">

</script>
@endpush
