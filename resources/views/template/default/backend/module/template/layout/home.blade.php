@extends('template.default.backend.page.index')

@section('layout-home')

<nav class="bg-light py-3 px-2 px-md-5 shadow-sm d-flex justify-content-between" aria-label="breadcrumb">
    <h5 class="my-0"><i class="fa-solid fa-layer-group me-3"></i>{{ $breadcrumb['title'] ?? 'Layouts' }}</h5>
    <ol class="breadcrumb my-0">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard.main') }}" class="text-decoration-none text-dark">
                {{ $breadcrumb['home'] ?? 'Home' }}
            </a>
        </li>
        <li class="breadcrumb-item active text-muted" aria-current="page">
            {{ $breadcrumb['index'] ?? 'Index' }}
        </li>
    </ol>
</nav>

<div class="container py-3">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <div class="align-self-center">
                    @can('layout-destroy')
                    <button type="button" class="btn btn-danger" id="bulkDeleteLayoutButton" style="display: none;">
                        <i class="fas fa-trash me-2"></i> {{ $button['delete_selected'] ?? 'Delete Selected' }}
                    </button>
                    @endcan
                </div>
                <h5 class="align-self-center my-0">{{ $datatable['header']['title'] ?? 'Layout Management' }}</h5>
                @can('layout-create')
                <a href="{{ route('layout.create') }}" class="btn btn-success">
                    {{ $button['create'] ?? 'Create' }} <i class="fa-solid fa-plus ms-2"></i>
                </a>
                @endcan
            </div>
        </div>
        <div class="card-body">
            <table id="layoutTable" class="table table-bordered dt-responsive nowrap table-striped align-middle w-100">
                <thead>
                    <tr>
                        <th scope="col" style="width: 10px;">
                            <div class="form-check">
                                <input class="form-check-input fs-15" type="checkbox" id="checkAllLayouts"
                                    value="option">
                            </div>
                        </th>
                        <th>{{ $datatable['table']['number'] ?? 'No' }}</th>
                        <th>{{ $datatable['table']['name'] ?? 'Name' }}</th>
                        <th>{{ $datatable['table']['type'] ?? 'Type' }}</th>
                        <th>{{ $datatable['table']['action'] ?? 'Action' }}</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('layout-home-js')
<script>
    $(document).ready(function () {
        var table = $('#layoutTable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('layout.datatable') }}",
            columns: [{
                data: 'id',
                name: 'id',
                orderable: false,
                searchable: false,
                className: 'text-center',
                render: function (data, type, row) {
                    return '<div class="form-check"><input class="form-check-input fs-15 layout-checkbox" type="checkbox" name="layout_ids[]" value="' +
                        data + '"></div>';
                }
            },
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false,
                className: 'text-center'
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'type',
                name: 'type'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                className: 'text-center',
                render: function (data, type, row) {
                    let editUrl = "{{ route('layout.edit', ':id') }}".replace(':id', data);
                    let deleteUrl = "{{ route('layout.destroy', ':id') }}".replace(':id', data);
                    let actions = '';

                    @can('layout-edit')
                    actions +=
                        '<a href="' + editUrl +
                        '" class="btn btn-sm btn-primary me-1"><i class="fas fa-edit"></i></a>';
                    @endcan

                    @can('layout-destroy')
                    actions +=
                        '<button type="button" class="btn btn-sm btn-danger delete-btn" data-url="' +
                        deleteUrl + '"><i class="fas fa-trash"></i></button>';
                    @endcan

                    return actions || 'N/A';
                }
            },
            ],
            language: {
                search: "{{ $translation->layout['datatable']['search'] ?? 'Search:' }}",
                lengthMenu: "{{ $translation->layout['datatable']['length_menu'] ?? 'Show _MENU_ entries' }}",
                info: "{{ $translation->layout['datatable']['info'] ?? 'Showing _START_ to _END_ of _TOTAL_ entries' }}",
                paginate: {
                    previous: "{{ $translation->layout['datatable']['previous'] ?? 'Previous' }}",
                    next: "{{ $translation->layout['datatable']['next'] ?? 'Next' }}"
                }
            }
        });

        // Check All Functionality
        $('#checkAllLayouts').on('click', function () {
            var isChecked = $(this).prop('checked');
            $('.layout-checkbox').prop('checked', isChecked);
            toggleBulkDeleteButton();
        });

        // Single Checkbox Functionality
        $('#layoutTable tbody').on('click', '.layout-checkbox', function () {
            if (!$(this).prop('checked')) {
                $('#checkAllLayouts').prop('checked', false);
            }
            // Check if all checkboxes are checked
            var allChecked = true;
            $('.layout-checkbox').each(function () {
                if (!$(this).prop('checked')) {
                    allChecked = false;
                    return false; // exit loop early
                }
            });
            $('#checkAllLayouts').prop('checked', allChecked);
            toggleBulkDeleteButton();
        });

        // Toggle Bulk Delete Button
        function toggleBulkDeleteButton() {
            var anyChecked = false;
            $('.layout-checkbox').each(function () {
                if ($(this).prop('checked')) {
                    anyChecked = true;
                    return false; // exit loop early
                }
            });
            if (anyChecked) {
                $('#bulkDeleteLayoutButton').show();
            } else {
                $('#bulkDeleteLayoutButton').hide();
            }
        }

        // Delete Button Handler
        $('#layoutTable tbody').on('click', '.delete-btn', function (e) {
            e.preventDefault();
            var url = $(this).data('url');
            var CSRF_TOKEN = "{{ csrf_token() }}";
            Swal.fire({
                title: "{{ $translation->layout['messages']['ask_delete'] ?? 'Are you sure?' }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: "{{ $translation->layout['button']['confirm_delete'] ?? 'Yes, delete it!' }}",
                cancelButtonText: "{{ $translation->layout['button']['cancel_delete'] ?? 'Cancel' }}"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            _token: CSRF_TOKEN
                        },
                        dataType: 'JSON',
                        success: function (response) {
                            if (response.status === 'success') {
                                Swal.fire(
                                    "{{ $translation->layout['notification']['success'] ?? 'Success' }}",
                                    response.message ||
                                    "{{ $translation->layout['messages']['delete_success'] ?? 'Layout deleted successfully.' }}",
                                    'success'
                                );
                                table.ajax.reload(null, false); // Reload DataTable without resetting page
                            } else {
                                Swal.fire(
                                    "{{ $translation->layout['notification']['error'] ?? 'Error' }}",
                                    response.message ||
                                    "{{ $translation->layout['messages']['delete_failed'] ?? 'Layout failed to delete.' }}",
                                    'error'
                                );
                            }
                        },
                        error: function (xhr) {
                            // Handle AJAX errors (e.g., network issues, server errors)
                            let errorMsg =
                                "{{ $translation->layout['messages']['delete_failed'] ?? 'Layout failed to delete.' }}";
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMsg = xhr.responseJSON.message;
                            }
                            Swal.fire(
                                "{{ $translation->layout['notification']['error'] ?? 'Error' }}",
                                errorMsg,
                                'error'
                            );
                        }
                    });
                }
            });
        });

        // Bulk Delete Button Handler
        $('#bulkDeleteLayoutButton').on('click', function () {
            var ids = [];
            $('.layout-checkbox:checked').each(function () {
                ids.push($(this).val());
            });

            if (ids.length === 0) {
                Swal.fire("{{ $translation->layout['notification']['error'] ?? 'Error' }}",
                    "{{ $translation->layout['messages']['select_item_first'] ?? 'Please select at least one item first!' }}",
                    'warning');
                return;
            }

            Swal.fire({
                title: "{{ $translation->layout['messages']['ask_bulk_delete'] ?? 'Are you sure?' }}",
                text: "{{ $translation->layout['messages']['bulk_delete_warning'] ?? 'You won\'t be able to revert this!' }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: "{{ $translation->layout['button']['confirm_delete'] ?? 'Yes, delete it!' }}",
                cancelButtonText: "{{ $translation->layout['button']['cancel_delete'] ?? 'Cancel' }}"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('layout.bulk-destroy') }}",
                        type: 'POST',
                        data: {
                            ids: ids,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            if (response.status === 'success') {
                                Swal.fire(
                                    "{{ $translation->layout['notification']['success'] ?? 'Success' }}",
                                    response.message ||
                                    "{{ $translation->layout['messages']['bulk_delete_success'] ?? 'Selected items deleted successfully.' }}",
                                    'success'
                                );
                                table.ajax.reload(null, false); // Reload DataTable
                                $('#checkAllLayouts').prop('checked', false); // Uncheck header checkbox
                                $('#bulkDeleteLayoutButton').hide(); // Hide bulk delete button
                            } else {
                                Swal.fire(
                                    "{{ $translation->layout['notification']['error'] ?? 'Error' }}",
                                    response.message ||
                                    "{{ $translation->layout['messages']['bulk_delete_failed'] ?? 'Failed to delete selected items.' }}",
                                    'error'
                                );
                            }
                        },
                        error: function (xhr) {
                            let errorMsg =
                                "{{ $translation->layout['messages']['bulk_delete_failed'] ?? 'Failed to delete selected items.' }}";
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMsg = xhr.responseJSON.message;
                            }
                            Swal.fire(
                                "{{ $translation->layout['notification']['error'] ?? 'Error' }}",
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
@endpush
