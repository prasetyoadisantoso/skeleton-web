<script>
    $(function () {
        // Translation variables (Pastikan key ada di file translation)
        let $t_component_ask_delete = "{{ $messages['ask_delete'] ?? 'Delete this item?' }}";
        let $t_component_confirm_delete = "{{ $button['confirm_delete'] ?? 'Yes, delete!' }}";
        let $t_component_cancel_delete = "{{ $button['cancel'] ?? 'Cancel' }}"; // Ambil dari $button
        let $t_component_delete_success = "{{ $messages['delete_success'] ?? 'Deleted successfully' }}";
        let $t_component_delete_failed = "{{ $messages['delete_failed'] ?? 'Delete failed' }}";
        let $t_component_select_item_first = "{{ $messages['select_item_first'] ?? 'Select item first' }}";
        let $t_component_ask_bulk_delete = "{{ $messages['ask_bulk_delete'] ?? 'Delete selected items?' }}";
        let $t_component_bulk_delete_warning = "{!! $messages['bulk_delete_warning'] ?? 'Cannot revert!' !!}";
        let $t_component_bulk_delete_success = "{{ $messages['bulk_delete_success'] ?? 'Selected deleted' }}";
        let $t_component_bulk_delete_failed = "{{ $messages['bulk_delete_failed'] ?? 'Bulk delete failed' }}";
        let $t_button_edit = "{{ $button['edit'] ?? 'Edit' }}"; // Ambil dari $button
        let $t_button_delete = "{{ $button['delete'] ?? 'Delete' }}"; // Ambil dari $button
        let $t_button_ok = "{{ $button['ok'] ?? 'OK' }}"; // Ambil dari $button
        let $t_notification_error = "{{ $notification['error'] ?? 'Error!' }}"; // Ambil dari $notification

        // DataTable initialization
        var table = $('#componentTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('component.datatable') }}",
            scrollX: true, // Aktifkan scroll horizontal jika perlu
            dom: 'lfrtip', // Struktur DOM default DataTable
            paging: true,
            pageLength: 10, // Sesuaikan jumlah item per halaman
            lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ], // Opsi jumlah item
            columns: [
                {
                    // 1. Kolom Checkbox (Bootstrap Style)
                    data: "id", name: "id", orderable: false, searchable: false,
                    render: function (data, type, row, meta) {
                        return `<div class="form-check"><input class="form-check-input fs-15 row-checkbox" type="checkbox" name="checkRowComponent" value="${data}"></div>`; // Class 'row-checkbox'
                    },
                    className: "dt-center", width: "10px",
                },
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'dt-center', }, // Buat orderable
                { data: 'name', name: 'name', orderable: true, searchable: true },
                { data: 'description', name: 'description', orderable: false, searchable: true }, // Buat searchable
                // Kolom is_active dengan render function
                {
                    data: 'is_active',
                    name: 'is_active',
                    orderable: true, // Sesuaikan jika perlu bisa di-sort
                    searchable: false, // Biasanya status tidak perlu dicari
                    render: function (data, type, row) {
                        // 'data' adalah objek { text: '...', class: '...' } dari controller
                        if (type === 'display' && data && typeof data === 'object') {
                            // Buat HTML badge di sini menggunakan data yang diterima
                            return '<span class="badge ' + data.class + '">' + data.text + '</span>';
                        }
                        // Untuk tipe lain (sort, filter), kembalikan nilai mentah atau teks
                        return data && typeof data === 'object' ? data.text : data;
                    }
                },
                {
                    // 6. Kolom Aksi (Bootstrap Style)
                    data: 'action', name: 'action', orderable: false, searchable: false, className: 'dt-center', width: '15%',
                    render: function (data, type, full, meta) {
                        var id = data; // ID dari controller
                        var editUrl = "{{ route('component.edit', ':id') }}".replace(':id', id);
                        var destroyUrl = "{{ route('component.destroy', ':id') }}".replace(':id', id);
                        var editBtn = '';
                        var deleteBtn = '';

                        @can('component-edit')
                        editBtn = `<a href="${editUrl}" class="btn btn-sm btn-primary my-1 px-2 py-1"><i class="fas fa-pen-square me-1"></i>${$t_button_edit}</a>`;
                        @endcan

                        @can('component-destroy')
                        // Gunakan ID unik untuk tombol delete jika perlu, atau class saja
                        deleteBtn = `<a id="destroyComponent" href="${destroyUrl}" class="btn btn-sm btn-danger my-1 px-2 py-1 ms-1 delete-button" data-id="${id}"><i class="fas fa-trash me-1"></i>${$t_button_delete}</a>`;
                        @endcan

                        return `<div class="d-flex justify-content-center">${editBtn}${deleteBtn}</div>`; // Bungkus dengan flex
                    }
                }
            ],
            language: { // Ambil dari variabel translation
                search: "", // Kosongkan, placeholder akan digunakan
                searchPlaceholder: "{{ $datatable['search'] ?? 'Search...' }}", // Placeholder
                lengthMenu: "{{ $datatable['length_menu'] ?? 'Show _MENU_ entries' }}",
                info: "{{ $datatable['info'] ?? 'Showing _START_ to _END_ of _TOTAL_ entries' }}",
                paginate: {
                    previous: "{{ $datatable['previous'] ?? 'Previous' }}",
                    next: "{{ $datatable['next'] ?? 'Next' }}",
                }
            },
            order: [[1, 'asc']], // Urutkan berdasarkan No (DT_RowIndex)
            headerCallback: function (thead, data, start, end, display) {
                 // Pastikan ID checkbox header unik
                 $(thead).find('th').eq(0).html('<div class="form-check"><input class="form-check-input fs-15" type="checkbox" id="checkAllComponents" value="option"></div>');
            },
            drawCallback: function () {
                // --- Logic untuk show/hide tombol Bulk Delete ---
                function toggleBulkButton() {
                    if ($('#componentTable tbody .row-checkbox:checked').length > 0) {
                        $('#bulkDeleteButton').show();
                    } else {
                        $('#bulkDeleteButton').hide();
                    }
                }

                // Saat checkbox header berubah
                $("#checkAllComponents").off('change.bulk').on("change.bulk", function () {
                    let isChecked = $(this).prop("checked");
                    $('#componentTable tbody .row-checkbox').prop("checked", isChecked);
                    toggleBulkButton();
                });

                // Saat checkbox baris berubah
                $('#componentTable tbody').off('change.bulk', '.row-checkbox').on('change.bulk', '.row-checkbox', function() {
                    if (!$(this).prop('checked')) {
                        $('#checkAllComponents').prop('checked', false);
                    }
                    // Cek jika semua checkbox di halaman ini tercentang
                    else if ($('#componentTable tbody .row-checkbox:checked').length === $('#componentTable tbody .row-checkbox').length) {
                         $('#checkAllComponents').prop('checked', true);
                    }
                    toggleBulkButton();
                });

                // Panggil sekali saat draw untuk state awal
                toggleBulkButton();
            },
        });

        // --- Delete Confirmation (Bootstrap Style SweetAlert2) ---
        // Gunakan event delegation yang lebih spesifik jika perlu
        $('#componentTable tbody').on('click', 'a.delete-button', function (e) { // Targetkan <a> dengan class delete-button
            e.preventDefault();
            var url = $(this).attr('href');
            var componentId = $(this).data('id'); // Ambil ID jika perlu

            Swal.fire({
                title: $t_component_ask_delete,
                icon: "warning",
                showCancelButton: true,
                cancelButtonText: $t_component_cancel_delete,
                confirmButtonText: $t_component_confirm_delete,
                customClass: { // Gunakan class dari alert.blade.php atau tema
                    confirmButton: "btn btn-success px-5 rad-25 mx-1 my-1",
                    cancelButton: "btn btn-danger px-5 rad-25 mx-1 my-1 order-sm-1",
                },
                buttonsStyling: false,
                reverseButtons: false, // Sesuaikan urutan tombol jika perlu
            }).then((result) => {
                if (result.isConfirmed) {
                    var CSRF_TOKEN = "{{ csrf_token() }}";
                    $.ajax({
                        type: 'DELETE',
                        url: url,
                        data: { _token: CSRF_TOKEN },
                        dataType: 'JSON',
                        success: function (results) {
                            if (results.status === 'success') {
                                Swal.fire({
                                    title: $t_component_delete_success,
                                    text: results.message || '',
                                    icon: "success",
                                    customClass: { popup: "rad-25", confirmButton: "btn btn-success px-5 rad-25" },
                                    buttonsStyling: false,
                                }).then(() => {
                                    table.ajax.reload(null, false); // Reload tanpa reset paging
                                });
                            } else {
                                Swal.fire({
                                    title: $t_component_delete_failed,
                                    text: results.message || 'An error occurred.',
                                    icon: "error",
                                    customClass: { confirmButton: "btn btn-danger px-5" },
                                    buttonsStyling: false,
                                });
                            }
                        },
                        error: function (xhr, status, error) {
                             let errorMsg = $t_component_delete_failed;
                             if (xhr.responseJSON && xhr.responseJSON.message) {
                                 errorMsg = xhr.responseJSON.message;
                             }
                             Swal.fire({
                                title: $t_notification_error, text: errorMsg, icon: "error",
                                customClass: { confirmButton: "btn btn-danger px-5" }, buttonsStyling: false,
                             });
                        },
                    });
                }
            });
        });
        // --- End Delete Confirmation ---

        // --- Bulk Delete Confirmation (Bootstrap Style SweetAlert2) ---
        $('#bulkDeleteButton').on('click', function() {
            var selectedIds = $('#componentTable tbody .row-checkbox:checked').map(function() {
                return $(this).val();
            }).get();

            if (selectedIds.length === 0) {
                Swal.fire({ title: $t_component_select_item_first, icon: 'warning', confirmButtonText: $t_button_ok });
                return;
            }

            Swal.fire({
                title: $t_component_ask_bulk_delete,
                html: $t_component_bulk_delete_warning, // Gunakan html jika ada tag HTML
                icon: "warning",
                showCancelButton: true,
                cancelButtonText: $t_component_cancel_delete,
                confirmButtonText: $t_component_confirm_delete, // Gunakan teks yang sama dengan single delete
                customClass: {
                    confirmButton: "btn btn-success px-5 rad-25 mx-1 my-1",
                    cancelButton: "btn btn-danger px-5 rad-25 mx-1 my-1 order-sm-1",
                },
                buttonsStyling: false,
                reverseButtons: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    var CSRF_TOKEN = "{{ csrf_token() }}";
                    var bulkDeleteUrl = "{{ route('component.bulk-destroy') }}";

                    $.ajax({
                        type: 'POST',
                        url: bulkDeleteUrl,
                        data: { _token: CSRF_TOKEN, ids: selectedIds },
                        dataType: 'JSON',
                        success: function (results) {
                            if (results.status === 'success') {
                                Swal.fire({
                                    title: $t_component_bulk_delete_success,
                                    text: results.message || '',
                                    icon: "success",
                                    customClass: { popup: "rad-25", confirmButton: "btn btn-success px-5 rad-25" },
                                    buttonsStyling: false,
                                }).then(() => {
                                    $('#checkAllComponents').prop('checked', false); // Uncheck header
                                    $('#bulkDeleteButton').hide(); // Sembunyikan tombol
                                    table.ajax.reload(null, false); // Reload tabel
                                });
                            } else {
                                Swal.fire({
                                    title: $t_component_bulk_delete_failed,
                                    text: results.message || 'An error occurred.',
                                    icon: "error",
                                    customClass: { confirmButton: "btn btn-danger px-5" },
                                    buttonsStyling: false,
                                });
                            }
                        },
                        error: function (xhr, status, error) {
                             let errorMsg = $t_component_bulk_delete_failed;
                             if (xhr.responseJSON && xhr.responseJSON.message) {
                                 errorMsg = xhr.responseJSON.message;
                             }
                             Swal.fire({
                                title: $t_notification_error, text: errorMsg, icon: "error",
                                customClass: { confirmButton: "btn btn-danger px-5" }, buttonsStyling: false,
                             });
                        },
                    });
                }
            });
        });
        // --- End Bulk Delete Confirmation ---

    });
</script>
