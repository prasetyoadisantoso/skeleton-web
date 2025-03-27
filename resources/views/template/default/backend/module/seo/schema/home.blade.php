@extends('template.default.backend.page.index')

@section('schema-home')

<style>
    table td pre{
        word-break: break-word !important;
        text-wrap: auto;
    }

    .word-wrap {
        word-break: break-word !important;
    }
</style>

<!-- Start Breadcrumb -->
<nav class="bg-light py-3 px-2 px-md-5 shadow-sm d-flex justify-content-between" aria-label="breadcrumb">
    <h5 class="my-0"><i class="fa-solid fa-signs-post me-3"></i>{{$breadcrumb['title'] ?? 'Schemas'}}</h5>
    <ol class="breadcrumb my-0">
        <li class="breadcrumb-item"><a href="{{route('schema.index')}}"
                class="text-decoration-none text-dark">{{$breadcrumb['home'] ?? 'Dashboard'}}</a>
        </li>
        <li class="breadcrumb-item active text-muted" aria-current="page">
            {{$type == 'index' ? $breadcrumb['index'] : ''}}
            {{$type == 'create' ? $breadcrumb['create'] : ''}}
            {{$type == 'edit' ? $breadcrumb['edit'] : ''}}
        </li>
    </ol>
</nav>
<!-- End Breadcrumb -->

<!-- Start Home -->
<div class="container py-2">

    <!-- Start app -->
    <div class="card" id="schema-home">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="align-self-center">{{$datatable['header']['title'] ?? 'Schema List'}}</h5>
                <a href="{{route('schema.create')}}" class="btn btn-success">{{$button['create'] ?? 'Create Schema'}}<i
                        class="fa-solid fa-plus ms-3"></i></a>
            </div>
        </div>
        <div class="card-body">
            <table id="schema_datatable" class="table table-bordered w-100">
                <thead>
                    <tr>
                        <th>{{$datatable['table']['number'] ?? '#'}}</th>
                        <th>{{$datatable['table']['name'] ?? 'Schema Name'}}</th>
                        <th>{{$datatable['table']['type'] ?? 'Schema Type'}}</th>
                        <th>{{$datatable['table']['content'] ?? 'Schema Content'}}</th>
                        <th>{{$datatable['table']['action'] ?? 'Action'}}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$datatable['table']['number'] ?? '#'}}</td>
                        <td>{{$datatable['table']['name'] ?? 'Schema Name'}}</td>
                        <td>{{$datatable['table']['type'] ?? 'Schema Type'}}</td>
                        <td>{{$datatable['table']['content'] ?? 'Schema Content'}}</td>
                        <td>{{$datatable['table']['action'] ?? 'Action'}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- End app -->

</div>
<!-- End Home -->
@endsection

@push('schema-home-js')
<script type="text/javascript" alt="datatable">
    $("#schema_datatable").DataTable({
        scrollX: true,
        processing: true,
        ajax: "{{route('schema.datatable')}}",
        dom: 'lfrtip',
        paging: true,
        pageLength: 5,
        lengthMenu: [5, 10, 25],
        columns: [{
                data: 'DT_RowIndex',
                width: '10%',
                name: 'DT_RowIndex',
                searchable: false,
                orderable: true,
                className: 'dt-center'
            },
            {
                data: 'schema_name',
                name: 'schema_name',
                searchable: true,
                orderable: true
            },
            {
                data: 'schema_type',
                name: 'schema_type',
                searchable: true,
                orderable: true
            },
            {
                data: 'schema_content',
                name: 'schema_content',
                className: 'word-wrap',
                searchable: false,
                orderable: false,
                render: function(data, type, full, meta) {
                   // Decode HTML entities
                    var decodedContent = $("<div/>").html(data).text();
                    console.log(decodedContent);
                    try {
                        // Parse JSON data
                        var jsonData = JSON.parse(decodedContent);

                        // Format JSON content for display (customize as needed)
                        var formattedContent = '<pre>' + JSON.stringify(jsonData, null, 2) + '</pre>';
                        return formattedContent;

                        // Atau, jika Anda ingin menampilkan properti tertentu dari JSON:
                        // return jsonData.name; // Contoh: Menampilkan properti "name"
                    } catch (e) {
                        console.error("Error parsing JSON:", e);
                        return "Invalid JSON";
                    }
                }
            },
            {
                data: 'action',
                width: '25%',
                name: 'action',
                orderable: false,
                searchable: false,
                render: function(data, type, full, meta) {
                    var id = data;
                    // Edit
                    var edit = "{{route('schema.edit', ':id')}}";
                    edit = edit.replace(':id', id);
                    // Delete
                    var destroy = "{{route('schema.destroy', ':id')}}";
                    destroy = destroy.replace(':id', id);
                    return "" +
                        // Edit Button
                        '<a href="' + edit +
                        '" class="btn btn-primary my-1 w-100"><i class="fas fa-pen-square me-2"></i>{{$button["edit"] ?? "Edit"}}</a>' +
                        // Destroy Button
                        '<a id="destroy" href="' + destroy +
                        '" class="btn btn-danger my-1 w-100"><i class="fas fa-trash me-2"></i>{{$button["delete"] ?? "Delete"}}</a>';
                }
            },
        ],
        "language": {
            "search": "",
            "lengthMenu": "{{$datatable['length_menu'] ?? 'Show _MENU_ entries'}}",
            "searchPlaceholder": "{{$datatable['search'] ?? 'Search'}}",
            "info": "{{$datatable['info'] ?? 'Showing _START_ to _END_ of _TOTAL_ entries'}}",
            "paginate": {
                "previous": "{{$datatable['previous'] ?? 'Previous'}}",
                "next": "{{$datatable['next'] ?? 'Next'}}",
            }
        }
    });
</script>

<script alt="schema-delete">
    $(document).on('click', '#destroy', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        Swal.fire({
            title: "{{$messages['ask_delete'] ?? 'Are you sure?'}}",
            icon: "warning",
            showCancelButton: !0,
            cancelButtonText: "{{$button['cancel'] ?? 'Cancel'}}",
            confirmButtonText: "{{$button['confirm'] ?? 'Confirm'}}",
            customClass: {
                confirmButton: "btn btn-success px-5 rad-25 mx-1 my-1",
                cancelButton: "btn btn-danger px-5 rad-25 mx-1 my-1 order-sm-1",
            },
            buttonsStyling: false,
            reverseButtons: false,
        }).then(function(e) {
            var CSRF_TOKEN = "{{csrf_token()}}";
            if (e.value === true) {
                $.ajax({
                    type: 'DELETE',
                    url: url,
                    data: {
                        _token: CSRF_TOKEN
                    },
                    dataType: 'JSON',
                    success: function(results) {
                        if (results.status === 'success') {
                            Swal.fire({
                                title: "{{$messages['delete_success'] ?? 'Deleted!'}}",
                                text: results.message,
                                icon: "success",
                                customClass: {
                                    popup: "rad-25",
                                    confirmButton: "btn btn-success px-5 rad-25",
                                },
                                buttonsStyling: false,
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: "{{$messages['delete_failed'] ?? 'Failed!'}}",
                                text: results.message,
                                icon: "error",
                            }).then(() => {
                                location.reload();
                            });
                        }
                    }
                });
            } else {
                e.dismiss;
            }
        }, function(dismiss) {})
    })
</script>
@endpush
