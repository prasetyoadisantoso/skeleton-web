@extends('template.default.backend.page.index')

@section('contentimage-home')

{{-- Start Breadcrumb (Menggunakan variabel langsung) --}}
<nav class="bg-light py-3 px-2 px-md-5 shadow-sm d-flex justify-content-between" aria-label="breadcrumb">
    {{-- Ikon bisa disesuaikan --}}
    <h5 class="my-0"><i class="fa-solid fa-image me-3"></i>{{ $breadcrumb['title'] }}</h5> {{-- Langsung panggil
    $breadcrumb --}}
    <ol class="breadcrumb my-0">
        <li class="breadcrumb-item">
            {{-- $url harusnya berisi route name dashboard.main --}}
            <a href="{{ route($url) }}" class="text-decoration-none text-dark">
                {{ $breadcrumb['home'] }} {{-- Langsung panggil $breadcrumb --}}
            </a>
        </li>
        <li class="breadcrumb-item active text-muted" aria-current="page">
            {{ $breadcrumb['index'] }} {{-- Langsung panggil $breadcrumb --}}
        </li>
    </ol>
</nav>
{{-- End Breadcrumb --}}

{{-- Start Home --}}
<div class="container py-3">

    {{-- Start Card --}}
    <div class="card" id="contentimage-home-card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                {{-- Grup Tombol Kiri (BARU) --}}
                <div class="align-self-center">
                    @can('contentimage-destroy') {{-- Permission untuk hapus --}}
                    <button type="button" class="btn btn-danger" id="bulk-delete-button" style="display: none;"> {{-- ID
                        & initially hidden --}}
                        <i class="fas fa-trash me-2"></i> {{ $button['delete_selected'] ?? 'Delete Selected' }} {{--
                        Tambahkan translation --}}
                    </button>
                    @endcan
                </div>
                <h5 class="align-self-center">{{ $datatable['header']['title'] }}</h5> {{-- Langsung panggil $datatable
                --}}
                {{-- Button Create --}}
                @can('contentimage-create')
                <a href="{{ route('content-image.create') }}" class="btn btn-success">
                    {{-- Menggunakan $button dari $translation->button --}}
                    {{ $button['create'] }} <i class="fa-solid fa-plus ms-3"></i>
                </a>
                @endcan
            </div>
        </div>
        <div class="card-body">
            <table id="contentimage_table"
                class="table table-bordered dt-responsive nowrap table-striped align-middle w-100">
                <thead>
                    <tr>
                        {{-- Checkbox Column --}}
                        <th scope="col" style="width: 10px;">
                            <div class="form-check">
                                <input class="form-check-input fs-15" type="checkbox" id="checkAll" value="option">
                            </div>
                        </th>
                        {{-- Data Columns --}}
                        <th>{{ $datatable['table']['number'] }}</th> {{-- Langsung panggil $datatable --}}
                        <th>{{ $datatable['table']['name'] }}</th> {{-- Langsung panggil $datatable --}}
                        <th>{{ $datatable['table']['image'] }}</th> {{-- Langsung panggil $datatable --}}
                        <th>{{ $datatable['table']['alt_text'] }}</th> {{-- Langsung panggil $datatable --}}
                        <th>{{ $datatable['table']['caption'] }}</th> {{-- Langsung panggil $datatable --}}
                        <th>{{ $datatable['table']['action'] }}</th> {{-- Langsung panggil $datatable --}}
                    </tr>
                </thead>
                <tbody>
                    {{-- DataTable will populate this --}}
                </tbody>
            </table>
        </div>
    </div>
    {{-- End Card --}}

</div>
{{-- End Home --}}

@endsection

@push('contentimage-home-js')
<script type="text/javascript">
    // --- Datatable ---
    // Menggunakan $("#contentimage-table") sebagai selector
    $("#contentimage_table").DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('content-image.datatable') }}",
        scrollX: true,
        dom: 'lfrtip',
        paging: true,
        // Menyamakan pageLength & lengthMenu dengan medialibrary
        pageLength: 5,
        lengthMenu: [ 5, 10, 25 ],
        columns: [
            {
                // 1. Kolom Checkbox
                data: "id", name: "id", orderable: false, searchable: false,
                render: function (data, type, row, meta) {
                    // Beri class 'row-checkbox' untuk memudahkan seleksi
                    return `<div class="form-check"> <input class="form-check-input fs-15 row-checkbox" type="checkbox" name="checkRow" value="${data}"> </div>`;
                },
                className: "dt-center", width: "10px",
            },
            {
                // Kolom Nomor (DT_RowIndex)
                data: 'DT_RowIndex',
                width: '10%', // Samakan lebar dengan medialibrary
                name: 'DT_RowIndex',
                searchable: false,
                orderable: true, // Samakan orderable dengan medialibrary
                className: 'dt-center' // Samakan className dengan medialibrary
            },
            {
                // 4. Kolom Name (BARU)
                data: "name", // Ambil data 'name' dari server
                name: "name", // Nama kolom untuk server-side processing
                searchable: true,
                orderable: true
            },
            {
                // Kolom Gambar
                data: "image",
                name: "image", // Nama kolom dari controller
                orderable: false,
                searchable: false,
                // Menyamakan className dengan kolom media_files di medialibrary
                className: "w-25 text-center"
                // Tidak perlu render custom seperti medialibrary karena gambar sudah HTML dari controller
            },
            {
                // Kolom Alt Text
                data: "alt_text",
                name: "alt_text",
                searchable: true, // Aktifkan search
                orderable: true   // Aktifkan order
            },
            {
                // Kolom Caption
                data: "caption",
                name: "caption",
                searchable: true, // Aktifkan search
                orderable: true   // Aktifkan order
            },
            { // <-- DEFINISI KOLOM KE-6 (ACTION) YANG HILANG DITAMBAHKAN DI SINI
                // 6. Kolom Aksi
                data: 'action',  // Nama kolom dari controller (berisi ID)
                width: '25%', // Samakan lebar dengan medialibrary
                name: 'action',
                orderable: false,
                searchable: false,
                // Menggunakan metode render seperti medialibrary
                render: function (data, type, full, meta) {
                    var id = data; // ID dari controller
                    // Definisikan route dengan placeholder :id
                    var edit = "{{ route('content-image.edit', ':id') }}";
                    edit = edit.replace(':id', id); // Ganti placeholder dengan ID
                    var destroy = "{{ route('content-image.destroy', ':id') }}";
                    destroy = destroy.replace(':id', id); // Ganti placeholder dengan ID

                    // Gabungkan HTML button seperti medialibrary
                    return "" +
                    // Edit Button
                    '<a href="' + edit + '" class="btn btn-primary my-1 w-100"><i class="fas fa-pen-square me-2"></i>{{ $button["edit"] }}</a></br>' +
                    // Destroy Button (Gunakan id="destroy" dan href)
                    '<a id="destroy" href="' + destroy + '" class="btn btn-danger my-1 w-100"><i class="fas fa-trash me-2"></i>{{ $button["delete"] }}</a>';
                }
            }

        ],
        // Bahasa DataTable (Mengambil dari variabel langsung)
        "language": {
            "search": "",
            "lengthMenu": "{{ $datatable['length_menu'] }}",
            "searchPlaceholder": "{{ $datatable['search'] }}",
            "info": "{{ $datatable['info'] }}",
            "paginate": {
                "previous": "{{ $datatable['previous'] }}",
                "next": "{{ $datatable['next'] }}",
            }
        },
        // Checkbox & Select All (Kita pertahankan karena kolom checkbox ada)
        headerCallback: function (thead, data, start, end, display) {
             $(thead).find('th').eq(0).html('<div class="form-check"><input class="form-check-input fs-15" type="checkbox" id="checkAll" value="option"></div>');
        },
        drawCallback: function () {
            // --- Logic untuk show/hide tombol Bulk Delete ---
            function toggleBulkButton() {
                if ($('#contentimage_table tbody .row-checkbox:checked').length > 0) {
                    $('#bulk-delete-button').show();
                } else {
                    $('#bulk-delete-button').hide();
                }
            }

            // Saat checkbox header berubah
            $("#checkAll").off('change.bulk').on("change.bulk", function () {
                let isChecked = $(this).prop("checked");
                // Gunakan selector yang benar untuk checkbox baris
                $('#contentimage_table tbody .row-checkbox').prop("checked", isChecked);
                toggleBulkButton(); // Update visibilitas tombol
            });

            // Saat checkbox baris berubah
            $('#contentimage_table tbody').off('change.bulk', '.row-checkbox').on('change.bulk', '.row-checkbox', function() {
                // Jika ada checkbox baris yang tidak tercentang, uncheck header
                if (!$(this).prop('checked')) {
                    $('#checkAll').prop('checked', false);
                }
                // Jika semua checkbox baris tercentang, check header (opsional, bisa kompleks jika ada paging)
                // else if ($('#contentimage_table tbody .row-checkbox:checked').length === $('#contentimage_table tbody .row-checkbox').length) {
                //     $('#checkAll').prop('checked', true);
                // }
                toggleBulkButton(); // Update visibilitas tombol
            });

            // Panggil sekali saat draw untuk state awal
            toggleBulkButton();
        },
    });
    // --- End Datatable ---

    // --- Delete Confirmation (Menyamakan dengan medialibrary-delete script) ---
    // Menggunakan selector dan logika event seperti medialibrary
    $(document).on('click', '#destroy', function (e) {
        e.preventDefault();
        var url = $(this).attr('href'); // Ambil URL dari href
        Swal.fire({
            title: "{{ $messages['ask_delete'] }}", // Langsung panggil $messages
            icon: "warning",
            showCancelButton: !0, // Samakan dengan medialibrary (!0)
            cancelButtonText: "{{ $button['cancel'] }}", // Pakai $button
            confirmButtonText: "{{ $button['confirm'] }}", // Pakai $button
            customClass: { // Samakan class custom dengan medialibrary
                confirmButton: "btn btn-success px-5 rad-25 mx-1 my-1",
                cancelButton: "btn btn-danger px-5 rad-25 mx-1 my-1 order-sm-1",
            },
            buttonsStyling: false,
            reverseButtons: false,
        }).then(function (e) { // Samakan parameter function(e)
            // Definisikan CSRF_TOKEN seperti medialibrary (jika belum ada global)
            var CSRF_TOKEN = "{{ csrf_token() }}"; // Ambil token CSRF
            if (e.value === true) { // Samakan kondisi if (e.value === true)
                $.ajax({
                    type: 'DELETE', // Samakan type: 'DELETE'
                    url: url,
                    data: { _token: CSRF_TOKEN }, // Samakan data: { _token: CSRF_TOKEN }
                    dataType: 'JSON',
                    success: function (results) { // Samakan parameter function(results)
                        if (results.status === 'success') {
                            Swal.fire({
                                title: "{{ $messages['delete_success'] }}", // Langsung panggil $messages
                                text: results.message,
                                icon: "success",
                                customClass: { // Samakan class custom dengan medialibrary
                                    popup: "rad-25",
                                    confirmButton: "btn btn-success px-5 rad-25",
                                },
                                buttonsStyling: false,
                            }).then(() => {
                                // Reload tabel contentimage
                                $('#contentimage_table').DataTable().ajax.reload(); // Gunakan selector tabel yang benar
                            });
                        } else {
                            Swal.fire({
                                title: "{{ $messages['delete_failed'] }}", // Langsung panggil $messages
                                text: results.message,
                                icon: "error",
                            }).then(() => {
                                // Reload tabel contentimage jika perlu saat gagal
                                $('#contentimage_table').DataTable().ajax.reload(); // Gunakan selector tabel yang benar
                            });
                        }
                    },
                    // Tambahkan error handling jika perlu (medialibrary tidak ada)
                    error: function (xhr, status, error) {
                         let errorTitle = @json($notification['error'] ?? 'Error!');
                         let errorMsg = "{{ $messages['delete_failed'] }}";
                         if (xhr.responseJSON && xhr.responseJSON.message) {
                             errorMsg = xhr.responseJSON.message;
                         }
                         Swal.fire({
                            title: errorTitle,
                            text: errorMsg,
                            icon: "error",
                            customClass: { // Gunakan class dari alert.blade.php
                                confirmButton: "btn btn-danger px-5",
                            },
                            buttonsStyling: false,
                         });
                    },
                });
            } else {
                e.dismiss; // Samakan else
            }
        }, function (dismiss) { // Samakan function dismiss
            // Tidak ada aksi di medialibrary
        })
    })
    // --- End Delete Confirmation ---

     // --- Bulk Delete Confirmation (BARU) ---
     $('#bulk-delete-button').on('click', function() {
        var selectedIds = $('#contentimage_table tbody .row-checkbox:checked').map(function() {
            return $(this).val();
        }).get();

        if (selectedIds.length === 0) {
            // Tampilkan pesan jika tidak ada yang dipilih (opsional, tombol sudah di-hide)
            Swal.fire({ title: "{{ $messages['select_item_first'] ?? 'Please select items first!' }}", icon: 'warning', confirmButtonText: "{{ $button['ok'] ?? 'OK' }}" });
            return;
        }

        // Konfirmasi bulk delete
        Swal.fire({
            title: "{{ $messages['ask_bulk_delete'] ?? 'Delete selected items?' }}", // Pesan konfirmasi bulk
            text: "{!! $messages['bulk_delete_warning'] ?? 'You won\'t be able to revert this!' !!}", // Warning
            icon: "warning",
            showCancelButton: true,
            cancelButtonText: "{{ $button['cancel'] }}",
            confirmButtonText: "{{ $button['confirm_delete'] ?? 'Yes, delete them!' }}", // Teks tombol konfirmasi
            customClass: { // Samakan class custom dengan delete single
                confirmButton: "btn btn-success px-5 rad-25 mx-1 my-1",
                cancelButton: "btn btn-danger px-5 rad-25 mx-1 my-1 order-sm-1",
            },
            buttonsStyling: false,
            reverseButtons: false,
        }).then(function (result) { // Gunakan result
            if (result.isConfirmed) { // Gunakan result.isConfirmed
                var CSRF_TOKEN = "{{ csrf_token() }}";
                var bulkDeleteUrl = "{{ route('content-image.bulk-destroy') }}"; // Route baru

                // Kirim AJAX request
                $.ajax({
                    type: 'POST', // Gunakan POST untuk mengirim array
                    url: bulkDeleteUrl,
                    data: {
                        _token: CSRF_TOKEN,
                        ids: selectedIds // Kirim array IDs
                    },
                    dataType: 'JSON',
                    success: function (results) {
                        if (results.status === 'success') {
                            Swal.fire({
                                title: "{{ $messages['bulk_delete_success'] ?? 'Items deleted!' }}", // Pesan sukses bulk
                                text: results.message,
                                icon: "success",
                                customClass: { // Samakan class custom
                                    popup: "rad-25",
                                    confirmButton: "btn btn-success px-5 rad-25",
                                },
                                buttonsStyling: false,
                            }).then(() => {
                                $('#checkAll').prop('checked', false); // Uncheck header
                                $('#bulk-delete-button').hide(); // Sembunyikan tombol lagi
                                // Reload tabel contentimage jika perlu saat gagal
                                $('#contentimage_table').DataTable().ajax.reload(); // Gunakan selector tabel yang benar
                            });
                        } else {
                            Swal.fire({
                                title: "{{ $messages['bulk_delete_failed'] ?? 'Deletion failed!' }}", // Pesan gagal bulk
                                text: results.message,
                                icon: "error",
                                customClass: { confirmButton: "btn btn-danger px-5" }, // Class dari alert.blade.php
                                buttonsStyling: false,
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                         let errorTitle = @json($notification['error'] ?? 'Error!');
                         let errorMsg = "{{ $messages['bulk_delete_failed'] ?? 'Could not process the request.' }}";
                         if (xhr.responseJSON && xhr.responseJSON.message) {
                             errorMsg = xhr.responseJSON.message;
                         }
                         Swal.fire({
                            title: errorTitle, text: errorMsg, icon: "error",
                            customClass: { confirmButton: "btn btn-danger px-5" }, buttonsStyling: false,
                         });
                    },
                });
            }
        });
    });
    // --- End Bulk Delete Confirmation ---
</script>
@endpush
