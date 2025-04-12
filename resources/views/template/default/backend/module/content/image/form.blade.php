@extends('template.default.backend.page.index')

@section('contentimage-form')

{{-- Start Breadcrumb (Menggunakan variabel langsung) --}}
<nav class="bg-light py-3 px-2 px-md-5 shadow-sm d-flex justify-content-between" aria-label="breadcrumb">
    {{-- Ikon bisa disesuaikan --}}
    <h5 class="my-0"><i class="fa-solid fa-image me-3"></i>{{ $breadcrumb['title'] }}</h5>
    <ol class="breadcrumb my-0">
        <li class="breadcrumb-item">
            {{-- $url harusnya berisi route name dashboard.main --}}
            <a href="{{ route($url) }}" class="text-decoration-none text-dark">
                {{ $breadcrumb['home'] }}
            </a>
        </li>
        <li class="breadcrumb-item active text-muted" aria-current="page">
            {{-- Menampilkan breadcrumb sesuai tipe halaman --}}
            @if ($type == 'create')
            {{ $breadcrumb['create'] }}
            @elseif ($type == 'edit')
            {{ $breadcrumb['edit'] }}
            @endif
        </li>
    </ol>
</nav>
{{-- End Breadcrumb --}}

{{-- Start Form --}}
<div class="container py-3"> {{-- Tambahkan container --}}
    <div class="card">
        <div class="card-header">
            {{-- Menggunakan $form --}}
            <h5 class="card-title mb-0 text-center"> {{-- Tambahkan text-center jika perlu --}}
                @if ($type == 'create')
                {{ $form['create_title'] }}
                @elseif ($type == 'edit')
                {{ $form['edit_title'] }}
                @endif
            </h5>
        </div>
        <div class="card-body">
            <form
                action="{{ $type == 'create' ? route('content-image.store') : route('content-image.update', $contentImageData->id) }}"
                method="POST" enctype="multipart/form-data" id="contentimage-form"> {{-- Beri ID pada form --}}
                @csrf
                @if ($type == 'edit')
                @method('PUT')
                @endif

                <div class="row">
                    {{-- Image File Input --}}
                    <div class="col-md-6 mb-3">
                        {{-- Menggunakan $form --}}
                        <label for="media_file" class="form-label">{{ $form['media_file'] }}
                            @if($type == 'create')<span class="text-danger">*</span>@endif</label>
                        <input type="file" class="form-control @error('media_file') is-invalid @enderror"
                            id="media_file" name="media_file"
                            accept="image/png, image/jpeg, image/jpg, image/webp, image/gif">
                        {{-- Menggunakan $form --}}
                        <small class="form-text text-muted">{{ $form['media_file_note'] }}</small>
                        @error('media_file')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                        {{-- Image Preview for Edit --}}
                        @if ($type == 'edit' && isset($contentImageData) && $contentImageData->mediaLibrary)
                        <div class="mt-3">
                            {{-- Menggunakan $form --}}
                            <label class="form-label">{{ $form['current_image'] }}</label><br>
                            <img src="{{ Storage::url($contentImageData->mediaLibrary->media_files) }}"
                                alt="{{ $contentImageData->alt_text }}"
                                style="max-width: 200px; max-height: 200px; border: 1px solid #ddd; padding: 5px;">
                        </div>
                        @endif
                        {{-- Container untuk preview saat create/edit --}}
                        <div id="image-preview-container" class="mt-3"></div>
                    </div>

                    {{-- Name Input (BARU) --}}
                    <div class="col-md-6 mb-3"> {{-- Atau col-12 jika ingin full width --}}
                        {{-- Menggunakan $form (pastikan key 'name' dan 'name_placeholder' ada di translation) --}}
                        <label for="name" class="form-label">{{ $form['name'] ?? 'Name' }} <span
                                class="text-danger">*</span></label> {{-- Tambahkan * jika required --}}
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" placeholder="{{ $form['name_placeholder'] ?? 'Insert name...' }}"
                            value="{{ old('name', $contentImageData->name ?? '') }}">
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    {{-- Alt Text Input --}}
                    <div class="col-md-6 mb-3">
                        {{-- Menggunakan $form --}}
                        <label for="alt_text" class="form-label">{{ $form['alt_text'] }} <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('alt_text') is-invalid @enderror" id="alt_text"
                            name="alt_text" placeholder="{{ $form['alt_text_placeholder'] }}" {{-- Menggunakan $form
                            --}} value="{{ old('alt_text', $contentImageData->alt_text ?? '') }}">
                        @error('alt_text')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    {{-- Caption Input --}}
                    <div class="col-12 mb-3">
                        {{-- Menggunakan $form --}}
                        <label for="caption" class="form-label">{{ $form['caption'] }}</label>
                        <textarea class="form-control @error('caption') is-invalid @enderror" id="caption"
                            name="caption" rows="3"
                            placeholder="{{ $form['caption_placeholder'] }}">{{ old('caption', $contentImageData->caption ?? '') }}</textarea>
                        {{-- Menggunakan $form --}}
                        @error('caption')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    {{-- Submit Buttons --}}
                    <div class="col-lg-12">
                        {{-- Menggunakan style button seperti medialibrary/form --}}
                        <div class="d-flex justify-content-center gap-2"> {{-- Ganti hstack & justify-content-end --}}
                            <a href="{{ route('content-image.index') }}" class="btn btn-danger w-100 w-md-25"> {{--
                                Ganti btn-light & style --}}
                                {{ $button['cancel'] }} <i class="fas fa-times ms-2"></i> {{-- Menggunakan $button &
                                ikon --}}
                            </a>
                            @if ($type == 'create')
                            @can('contentimage-store') {{-- Tambahkan can --}}
                            <button type="submit" class="btn btn-success w-100 w-md-25"> {{-- Ganti btn-primary & style
                                --}}
                                {{ $button['store'] }} <i class="fas fa-save ms-2"></i> {{-- Menggunakan $button & ikon
                                --}}
                            </button>
                            @endcan
                            @elseif ($type == 'edit')
                            @can('contentimage-update') {{-- Tambahkan can --}}
                            <button type="submit" class="btn btn-success w-100 w-md-25"> {{-- Ganti btn-primary & style
                                --}}
                                {{ $button['update'] }} <i class="fas fa-save ms-2"></i> {{-- Menggunakan $button & ikon
                                --}}
                            </button>
                            @endcan
                            @endif
                        </div>
                    </div>
                </div>
                <!--end row-->
            </form>
        </div>
        {{-- Hapus card-footer jika tidak diperlukan --}}
    </div>
</div>
{{-- End Form --}}

@endsection

@push('contentimage-form-js')
<script type="text/javascript">
    // Optional: Tambahkan preview gambar saat file dipilih
$(document).ready(function() {
    $('#media_file').on('change', function(event) {
        const file = event.target.files[0];
        const previewContainer = $('#image-preview-container'); // Cache selector

        // Hapus preview lama
        previewContainer.empty();

        if (file && file.type.startsWith('image/')) { // Pastikan itu file gambar
            const reader = new FileReader();
            reader.onload = function(e) {
                // Buat elemen img baru untuk preview
                const imgPreview = $('<img>')
                    .attr('src', e.target.result)
                    .css({
                        'max-width': '200px',
                        'max-height': '200px',
                        'border': '1px solid #ddd',
                        'padding': '5px',
                        'margin-top': '10px' // Sesuaikan margin
                    });
                // Tambahkan label dan gambar ke container
                previewContainer.append('<label class="form-label d-block">Image Preview:</label>').append(imgPreview); // Tambahkan d-block ke label
            }
            reader.readAsDataURL(file);
        }
        // Jika file bukan gambar atau tidak ada file, container tetap kosong
    });

    // Optional: Tambahkan validasi JQuery jika diperlukan (mirip medialibrary/form)
    // $("#contentimage-form").validate({
    //     rules: {
    //         media_file: {
    //             required: {{ $type == 'create' ? 'true' : 'false' }}, // Wajib saat create
    //             accept: "image/*" // Validasi tipe file
    //         },
    //         alt_text: {
    //             required: true,
    //             maxlength: 255
    //         },
    //         caption: {
    //             maxlength: 1000
    //         }
    //     },
    //     messages: {
    //         // Ambil pesan dari variabel $validation jika ada
    //         media_file: {
    //              required: @json($validation['media_file_required'] ?? 'Image file is required.'),
    //              accept: @json($validation['media_file_image'] ?? 'Please select a valid image file.')
    //         },
    //         alt_text: {
    //             required: @json($validation['alt_text_required'] ?? 'Alt text is required.'),
    //             maxlength: @json($validation['alt_text_max'] ?? 'Alt text cannot exceed 255 characters.')
    //         },
    //         caption: {
    //             maxlength: @json($validation['caption_max'] ?? 'Caption cannot exceed 1000 characters.')
    //         }
    //     },
    //     // errorPlacement: function (error, element) { ... } // Sesuaikan penempatan error jika perlu
    // });

    // // Trigger submit jika validasi JQuery lolos (jika menggunakan JQuery Validate)
    // $('#contentimage-form button[type="submit"]').click(function (e) {
    //     if (!$("#contentimage-form").valid()) {
    //         e.preventDefault(); // Hentikan submit jika tidak valid
    //         return false;
    //     }
    //     // Jika valid, form akan tersubmit secara normal
    // });

});

</script>
@endpush
