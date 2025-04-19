@extends('template.default.backend.page.index')

@section('page-home')

{{-- Start Breadcrumb (Menggunakan variabel langsung) --}}
<nav class="bg-light py-3 px-2 px-md-5 shadow-sm d-flex justify-content-between" aria-label="breadcrumb">
    {{-- Ganti ikon dan teks --}}
    <h5 class="my-0"><i class="fa-solid fa-layer-group me-3"></i>{{ $breadcrumb['title'] ?? 'Sections' }}</h5>
    <ol class="breadcrumb my-0">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard.main') }}" class="text-decoration-none text-dark">
                {{ $breadcrumb['home'] ?? 'Home' }}
            </a>
        </li>
        <li class="breadcrumb-item active text-muted" aria-current="page">
            {{-- Ganti teks --}}
            {{ $breadcrumb['index'] ?? 'Index' }}
        </li>
    </ol>
</nav>
{{-- End Breadcrumb --}}


<!-- Start Home -->
<div class="container py-3">
    <div class="card" id="page-home">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="align-self-center">{{ $datatable['header']['title'] }}</h5>
                @can('page-create')
                <a href="{{ route('page.create') }}" class="btn btn-success">{{ $button['create'] }}
                    <i class="fa-solid fa-plus ms-3"></i></a>
                @endcan
            </div>
        </div>
        <div class="card-body">
            <table id="page_datatable" class="table table-bordered w-100">
                <thead>
                    <tr>
                        <th>{{ $datatable['table']['number'] }}</th>
                        <th>{{ $datatable['table']['title'] }}</th>
                        <th>{{ $datatable['table']['slug'] }}</th>
                        <th>{{ $datatable['table']['action'] }}</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be loaded here by DataTables -->
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- End Home -->
@endsection

@push('page-home-js')
<script>
    $(document).ready(function() {
        $('#page_datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('page.datatable') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'title', name: 'title' },
                { data: 'slug', name: 'slug' },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        // Assuming `data` contains the page ID
                        var editUrl = "{{ route('page.edit', ':id') }}".replace(':id', data);
                        var deleteUrl = "{{ route('page.destroy', ':id') }}".replace(':id', data);

                        return `
                            <a href="${editUrl}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a>
                            <button data-url="${deleteUrl}" class="btn btn-danger btn-sm delete-page"><i class="fas fa-trash"></i> Delete</button>
                        `;
                    }
                }
            ]
        });

        // Delete action
        $('#page_datatable').on('click', '.delete-page', function() {
            var deleteUrl = $(this).data('url');

            Swal.fire({
                title: '{{ $messages['ask_delete'] }}',
                text: "{{ $messages['delete_warning'] }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '{{ __('backend/button.button.delete') }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: deleteUrl,
                        type: 'DELETE',
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire(
                                    '{{ __('backend/notification.success') }}',
                                    '{{ $messages['delete_success'] }}',
                                    'success'
                                );
                                $('#page_datatable').DataTable().ajax.reload();
                            } else {
                                Swal.fire(
                                    '{{ __('backend/notification.error') }}',
                                    '{{ $messages['delete_failed'] }}',
                                    'error'
                                );
                            }
                        }
                    });
                }
            });
        });
    });
</script>
@endpush
