@extends('template.default.backend.page.index')

@section('contenttext-home') {{-- Ganti section name --}}

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
            {{ $breadcrumb['index'] }}
        </li>
    </ol>
</nav>
{{-- End Breadcrumb --}}

{{-- Start Home --}}
<div class="container py-3">
    <div class="card" id="contenttext-home-card"> {{-- Ganti ID --}}
        <div class="card-header">
            <div class="d-flex justify-content-between">
                {{-- Grup Tombol Kiri --}}
                <div class="align-self-center">
                    @can('contenttext-destroy') {{-- Ganti permission --}}
                    <button type="button" class="btn btn-danger" id="bulk-delete-button" style="display: none;">
                        <i class="fas fa-trash me-2"></i> {{ $button['delete_selected'] ?? 'Delete Selected' }}
                    </button>
                    @endcan
                </div>
                {{-- Judul dan Tombol Create Kanan --}}
                <div class="d-flex">
                    <h5 class="align-self-center me-3">{{ $datatable['header']['title'] }}</h5> {{-- Ganti var --}}
                    @can('contenttext-create') {{-- Ganti permission --}}
                    <a href="{{ route('content-text.create') }}" class="btn btn-success"> {{-- Ganti route --}}
                        {{ $button['create'] }} <i class="fa-solid fa-plus ms-3"></i>
                    </a>
                    @endcan
                </div>
            </div>
        </div>
        <div class="card-body">
            <table id="contenttext_table" {{-- Ganti ID --}}
                class="table table-bordered dt-responsive nowrap table-striped align-middle w-100">
                <thead>
                    <tr>
                        <th scope="col" style="width: 10px;">
                            <div class="form-check">
                                <input class="form-check-input fs-15" type="checkbox" id="checkAll" value="option">
                            </div>
                        </th>
                        <th>{{ $datatable['table']['number'] }}</th>
                        <th>{{ $datatable['table']['type'] }}</th> {{-- Baru --}}
                        <th>{{ $datatable['table']['content'] }}</th> {{-- Baru --}}
                        <th>{{ $datatable['table']['action'] }}</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- DataTable will populate this --}}
                </tbody>
            </table>
        </div>
    </div>
</div>
{{-- End Home --}}

@endsection

@push('contenttext-home-js') {{-- Ganti push name --}}
<script type="text/javascript">
$(document).ready(function () {
    // --- Datatable ---
    const contentTextTable = $("#contenttext_table").DataTable({ // Ganti ID
        processing: true,
        serverSide: true,
        ajax: "{{ route('content-text.datatable') }}", // Ganti route
        scrollX: true,
        dom: 'lfrtip',
        paging: true,
        pageLength: 10, // Sesuaikan
        lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ], // Sesuaikan
        columns: [
            { // 1. Checkbox
                data: "id", name: "id", orderable: false, searchable: false,
                render: function (data, type, row, meta) {
                    return `<div class="form-check"> <input class="form-check-input fs-15 row-checkbox" type="checkbox" name="checkRow" value="${data}"> </div>`;
                },
                className: "dt-center", width: "10px",
            },
            { // 2. Nomor
                data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: true, className: 'dt-center', width: '10%'
            },
            { // 3. Type (BARU)
                data: "type", name: "type", searchable: true, orderable: true
            },
            { // 4. Content (BARU)
                data: "content", name: "content", searchable: true, orderable: true
            },
            { // 5. Aksi
                data: 'action', name: 'action', orderable: false, searchable: false, className: 'dt-center', width: '20%', // Sesuaikan width
                render: function (data, type, full, meta) {
                    var id = data;
                    var edit = "{{ route('content-text.edit', ':id') }}"; edit = edit.replace(':id', id); // Ganti route
                    var destroy = "{{ route('content-text.destroy', ':id') }}"; destroy = destroy.replace(':id', id); // Ganti route

                    // Sesuaikan style tombol jika perlu
                    return "" +
                    '<a href="' + edit + '" class="btn btn-primary my-1 w-100"><i class="fas fa-pen-square me-2"></i>{{ $button["edit"] }}</a></br>' +
                    '<a id="destroy" href="' + destroy + '" class="btn btn-danger my-1 w-100"><i class="fas fa-trash me-2"></i>{{ $button["delete"] }}</a>';
                }
            }
        ],
        // Bahasa DataTable
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
        // Checkbox & Select All
        headerCallback: function (thead, data, start, end, display) {
             $(thead).find('th').eq(0).html('<div class="form-check"><input class="form-check-input fs-15" type="checkbox" id="checkAll" value="option"></div>');
        },
        drawCallback: function () {
            function toggleBulkButton() {
                if ($('#contenttext_table tbody .row-checkbox:checked').length > 0) { // Ganti ID tabel
                    $('#bulk-delete-button').show();
                } else {
                    $('#bulk-delete-button').hide();
                }
            }
            $("#checkAll").off('change.bulk').on("change.bulk", function () {
                let isChecked = $(this).prop("checked");
                $('#contenttext_table tbody .row-checkbox').prop("checked", isChecked); // Ganti ID tabel
                toggleBulkButton();
            });
            $('#contenttext_table tbody').off('change.bulk', '.row-checkbox').on('change.bulk', '.row-checkbox', function() { // Ganti ID tabel
                if (!$(this).prop('checked')) {
                    $('#checkAll').prop('checked', false);
                }
                toggleBulkButton();
            });
            toggleBulkButton(); // Panggil saat draw
        },
    });
    // --- End Datatable ---

    // --- Delete Confirmation (Single) ---
    $(document).on('click', '#destroy', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        Swal.fire({
            title: "{{ $messages['ask_delete'] }}", icon: "warning", showCancelButton: !0,
            cancelButtonText: "{{ $button['cancel'] }}", confirmButtonText: "{{ $button['confirm'] }}",
            customClass: { confirmButton: "btn btn-success px-5 rad-25 mx-1 my-1", cancelButton: "btn btn-danger px-5 rad-25 mx-1 my-1 order-sm-1", },
            buttonsStyling: false, reverseButtons: false,
        }).then(function (e) {
            var CSRF_TOKEN = "{{ csrf_token() }}";
            if (e.value === true) {
                $.ajax({
                    type: 'DELETE', url: url, data: { _token: CSRF_TOKEN }, dataType: 'JSON',
                    success: function (results) {
                        if (results.status === 'success') {
                            Swal.fire({ title: "{{ $messages['delete_success'] }}", text: results.message, icon: "success", customClass: { popup: "rad-25", confirmButton: "btn btn-success px-5 rad-25", }, buttonsStyling: false,
                            }).then(() => {
                                contentTextTable.ajax.reload(); // Reload tabel
                            });
                        } else { Swal.fire({ title: "{{ $messages['delete_failed'] }}", text: results.message, icon: "error", }).then(() => { contentTextTable.ajax.reload(); }); }
                    },
                    error: function (xhr, status, error) {
                        let errorTitle = @json($notification['error'] ?? 'Error!'); let errorMsg = "{{ $messages['delete_failed'] }}";
                        if (xhr.responseJSON && xhr.responseJSON.message) { errorMsg = xhr.responseJSON.message; }
                        Swal.fire({ title: errorTitle, text: errorMsg, icon: "error", customClass: { confirmButton: "btn btn-danger px-5" }, buttonsStyling: false, });
                    },
                });
            } else { e.dismiss; }
        }, function (dismiss) {})
    })
    // --- End Delete Confirmation (Single) ---

     // --- Bulk Delete Confirmation ---
     $('#bulk-delete-button').on('click', function() {
        var selectedIds = $('#contenttext_table tbody .row-checkbox:checked').map(function() { return $(this).val(); }).get(); // Ganti ID tabel
        if (selectedIds.length === 0) {
            Swal.fire({ title: "{{ $messages['select_item_first'] ?? 'Please select items first!' }}", icon: 'warning', confirmButtonText: "{{ $button['ok'] ?? 'OK' }}" }); return;
        }
        Swal.fire({
            title: "{{ $messages['ask_bulk_delete'] ?? 'Delete selected items?' }}", text: "{!! $messages['bulk_delete_warning'] ?? 'You won\'t be able to revert this!' !!}", icon: "warning",
            showCancelButton: true, cancelButtonText: "{{ $button['cancel'] }}", confirmButtonText: "{{ $button['confirm_delete'] ?? 'Yes, delete them!' }}",
            customClass: { confirmButton: "btn btn-success px-5 rad-25 mx-1 my-1", cancelButton: "btn btn-danger px-5 rad-25 mx-1 my-1 order-sm-1", },
            buttonsStyling: false, reverseButtons: false,
        }).then(function (result) {
            if (result.isConfirmed) {
                var CSRF_TOKEN = "{{ csrf_token() }}";
                var bulkDeleteUrl = "{{ route('content-text.bulk-destroy') }}"; // Ganti route
                $.ajax({
                    type: 'POST', url: bulkDeleteUrl, data: { _token: CSRF_TOKEN, ids: selectedIds }, dataType: 'JSON',
                    success: function (results) {
                        if (results.status === 'success') {
                            Swal.fire({ title: "{{ $messages['bulk_delete_success'] ?? 'Items deleted!' }}", text: results.message, icon: "success", customClass: { popup: "rad-25", confirmButton: "btn btn-success px-5 rad-25", }, buttonsStyling: false,
                            }).then(() => {
                                $('#checkAll').prop('checked', false); $('#bulk-delete-button').hide();
                                contentTextTable.ajax.reload(null, false); // Reload tabel
                            });
                        } else { Swal.fire({ title: "{{ $messages['bulk_delete_failed'] ?? 'Deletion failed!' }}", text: results.message, icon: "error", customClass: { confirmButton: "btn btn-danger px-5" }, buttonsStyling: false, }); }
                    },
                    error: function (xhr, status, error) {
                        let errorTitle = @json($notification['error'] ?? 'Error!'); let errorMsg = "{{ $messages['bulk_delete_failed'] ?? 'Could not process the request.' }}";
                        if (xhr.responseJSON && xhr.responseJSON.message) { errorMsg = xhr.responseJSON.message; }
                        Swal.fire({ title: errorTitle, text: errorMsg, icon: "error", customClass: { confirmButton: "btn btn-danger px-5" }, buttonsStyling: false, });
                    },
                });
            }
        });
    });
    // --- End Bulk Delete Confirmation ---
}); // Akhir document ready
</script>
@endpush
