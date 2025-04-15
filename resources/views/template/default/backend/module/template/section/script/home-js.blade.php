<script>
    $(document).ready(function() {

        // --- Translations ---
        // Mengambil terjemahan dari variabel Blade yang di-pass dari controller
        const t_section_ask_delete = "{{ $section_trans['messages']['ask_delete'] ?? 'Do you want to delete this Section?' }}";
        const t_section_delete_success = "{{ $section_trans['messages']['delete_success'] ?? 'Section deleted successfully' }}";
        const t_section_delete_failed = "{{ $section_trans['messages']['delete_failed'] ?? 'Section failed to delete' }}";
        const t_button_confirm_delete = "{{ $section_trans['button']['confirm_delete'] ?? 'Yes, delete it!' }}";
        const t_button_cancel_delete = "{{ $section_trans['button']['cancel_delete'] ?? 'Cancel' }}";
        const t_button_ok = "{{ $section_trans['button']['ok'] ?? 'OK' }}";
        const t_notification_success = "{{ $notification_trans['success'] ?? 'Success' }}";
        const t_notification_error = "{{ $notification_trans['error'] ?? 'Error' }}";
        const t_bulk_ask = "{{ $section_trans['messages']['ask_bulk_delete'] ?? 'Are you sure?' }}";
        const t_bulk_warning = "{{ $section_trans['messages']['bulk_delete_warning'] ?? 'You won\'t be able to revert this!' }}";
        const t_bulk_select_first = "{{ $section_trans['messages']['select_item_first'] ?? 'Please select at least one item first!' }}";
        const t_bulk_success = "{{ $section_trans['messages']['bulk_delete_success'] ?? 'Selected items deleted successfully' }}";
        const t_bulk_failed = "{{ $section_trans['messages']['bulk_delete_failed'] ?? 'Failed to delete selected items' }}";

        // --- DataTable Initialization ---
        var table = $('#sectionTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('section.datatable') }}", // Ganti route
            columns: [
                { data: 'id', name: 'id', orderable: false, searchable: false, className: 'text-center',
                    // Checkbox Column
                    render: function(data, type, row) {
                        return '<div class="form-check"><input class="form-check-input fs-15 section-checkbox" type="checkbox" name="section_ids[]" value="' + data + '"></div>';
                    }
                },
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' }, // Index Column
                { data: 'name', name: 'name' },
                { data: 'description', name: 'description' },
                { data: 'layout_type', name: 'layout_type' }, // Kolom baru
                { data: 'is_active', name: 'is_active', className: 'text-center',
                    // Status Column
                    render: function(data, type, row) {
                        // Data 'is_active' sekarang adalah object {text, class, active}
                        if (data && typeof data === 'object') {
                            return '<span class="badge ' + data.class + '">' + data.text + '</span>';
                        }
                        return '<span class="badge bg-secondary">Unknown</span>'; // Fallback
                    }
                },
                { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center',
                    // Action Column
                    render: function(data, type, row) {
                        // Data 'action' sekarang adalah ID
                        let editUrl = "{{ route('section.edit', ':id') }}".replace(':id', data);
                        let deleteUrl = "{{ route('section.destroy', ':id') }}".replace(':id', data);
                        let actions = '';

                        @can('section-edit')
                        actions += '<a href="' + editUrl + '" class="btn btn-sm btn-primary me-1"><i class="fas fa-edit"></i></a>';
                        @endcan

                        @can('section-destroy')
                        actions += '<button type="button" class="btn btn-sm btn-danger delete-btn" data-url="' + deleteUrl + '"><i class="fas fa-trash"></i></button>';
                        @endcan

                        return actions || 'N/A'; // Tampilkan N/A jika tidak ada aksi
                    }
                },
            ],
            // Order by 'created_at' descending (kolom ke-1 jika tidak ada index)
            // Sesuaikan index jika kolom berubah
            // order: [[1, 'desc']], // Biasanya dihandle server-side
            language: { // Sesuaikan dengan bahasa jika perlu
                search: "{{ $section_trans['datatable']['search'] ?? 'Search:' }}",
                lengthMenu: "{{ $section_trans['datatable']['length_menu'] ?? 'Show _MENU_ entries' }}",
                info: "{{ $section_trans['datatable']['info'] ?? 'Showing _START_ to _END_ of _TOTAL_ entries' }}",
                paginate: {
                    previous: "{{ $section_trans['datatable']['previous'] ?? 'Previous' }}",
                    next: "{{ $section_trans['datatable']['next'] ?? 'Next' }}"
                }
            }
        });

        // --- Check All Functionality ---
        $('#checkAllSections').on('click', function() {
            var isChecked = $(this).prop('checked');
            $('.section-checkbox').prop('checked', isChecked);
            toggleBulkDeleteButton();
        });

        // --- Single Checkbox Functionality ---
        $('#sectionTable tbody').on('click', '.section-checkbox', function() {
            if (!$(this).prop('checked')) {
                $('#checkAllSections').prop('checked', false);
            }
            // Check if all checkboxes are checked
            var allChecked = true;
            $('.section-checkbox').each(function() {
                if (!$(this).prop('checked')) {
                    allChecked = false;
                    return false; // exit loop early
                }
            });
            $('#checkAllSections').prop('checked', allChecked);
            toggleBulkDeleteButton();
        });

        // --- Toggle Bulk Delete Button ---
        function toggleBulkDeleteButton() {
            var anyChecked = false;
            $('.section-checkbox').each(function() {
                if ($(this).prop('checked')) {
                    anyChecked = true;
                    return false; // exit loop early
                }
            });
            if (anyChecked) {
                $('#bulkDeleteSectionButton').show();
            } else {
                $('#bulkDeleteSectionButton').hide();
            }
        }

        // --- Delete Button Handler ---
        $('#sectionTable tbody').on('click', '.delete-btn', function(e) {
            e.preventDefault();
            var url = $(this).data('url');
            var CSRF_TOKEN = "{{ csrf_token() }}";
            Swal.fire({
                title: t_section_ask_delete,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: t_button_confirm_delete,
                cancelButtonText: t_button_cancel_delete
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: { _token: CSRF_TOKEN },
                        dataType: 'JSON',
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire(
                                    t_notification_success,
                                    response.message || t_section_delete_success,
                                    'success'
                                );
                                table.ajax.reload(null, false); // Reload DataTable without resetting page
                            } else {
                                Swal.fire(
                                    t_notification_error,
                                    response.message || t_section_delete_failed,
                                    'error'
                                );
                            }
                        },
                        error: function(xhr) {
                            // Handle AJAX errors (e.g., network issues, server errors)
                            let errorMsg = t_section_delete_failed;
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMsg = xhr.responseJSON.message;
                            }
                            Swal.fire(
                                t_notification_error,
                                errorMsg,
                                'error'
                            );
                        }
                    });
                }
            });
        });

        // --- Bulk Delete Button Handler ---
        $('#bulkDeleteSectionButton').on('click', function() {
            var ids = [];
            $('.section-checkbox:checked').each(function() {
                ids.push($(this).val());
            });

            if (ids.length === 0) {
                Swal.fire(t_notification_error, t_bulk_select_first, 'warning');
                return;
            }

            Swal.fire({
                title: t_bulk_ask,
                text: t_bulk_warning,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: t_button_confirm_delete,
                cancelButtonText: t_button_cancel_delete
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('section.bulk-destroy') }}", // Ganti route
                        type: 'POST',
                        data: {
                            ids: ids,
                            _token: '{{ csrf_token() }}' // Pastikan token CSRF dikirim
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire(
                                    t_notification_success,
                                    response.message || t_bulk_success,
                                    'success'
                                );
                                table.ajax.reload(null, false); // Reload DataTable
                                $('#checkAllSections').prop('checked', false); // Uncheck header checkbox
                                $('#bulkDeleteSectionButton').hide(); // Hide bulk delete button
                            } else {
                                Swal.fire(
                                    t_notification_error,
                                    response.message || t_bulk_failed,
                                    'error'
                                );
                            }
                        },
                        error: function(xhr) {
                            let errorMsg = t_bulk_failed;
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMsg = xhr.responseJSON.message;
                            }
                            Swal.fire(
                                t_notification_error,
                                errorMsg,
                                'error'
                            );
                        }
                    });
                }
            });
        });

    });
</script>
