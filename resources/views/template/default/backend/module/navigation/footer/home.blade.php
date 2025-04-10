@extends('template.default.backend.page.index')

@section('footermenu-home')

<!-- Start Breadcrumb -->
<nav class="bg-light py-3 px-2 px-md-5 shadow-sm d-flex justify-content-between" aria-label="breadcrumb">
    <h5 class="my-0"><i class="fa-solid fa-list me-3"></i>{{$breadcrumb['title'] ?? 'footer Menu' }}</h5>
    <ol class="breadcrumb my-0">
        <li class="breadcrumb-item"><a href="{{route($url)}}"
                class="text-decoration-none text-dark">{{$breadcrumb['home'] ?? 'Dashboard'}}</a>
        </li>
        <li class="breadcrumb-item active text-muted" aria-current="page">
            {{$type == 'index' ? $breadcrumb['index'] ?? 'Index' : ''}}
            {{$type == 'create' ? $breadcrumb['create'] ?? 'Create' : ''}}
            {{$type == 'edit' ? $breadcrumb['edit'] ?? 'Edit' : ''}}
        </li>
    </ol>
</nav>
<!-- End Breadcrumb -->

<!-- Start Home -->
<div class="container py-2">

    <!-- Start app -->
    <div class="card" id="footermenu-home">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="align-self-center">{{$datatable['header']['title'] ?? 'List Menu'}}</h5>
                <a href="{{route('footermenu.create')}}" class="btn btn-success">{{$button['create'] ?? 'Create'}}<i
                        class="fa-solid fa-plus ms-3"></i></a>
            </div>
        </div>
        <div class="card-body">
            <table id="footermenu_datatable" class="table table-bordered w-100">
                <thead>
                    <tr>
                        <th>{{$datatable['table']['number'] ?? "No"}}</th>
                        <th>{{$datatable['table']['name'] ?? "Name"}}</th>
                        <th>{{$datatable['table']['label'] ?? "Label"}}</th>
                        <th>{{$datatable['table']['url'] ?? "URL"}}</th>
                        <th>{{$datatable['table']['order'] ?? "Order"}}</th>
                        <th>{{$datatable['table']['target'] ?? "Target"}}</th>
                        <th>{{$datatable['table']['status'] ?? "Status"}}</th>
                        <th>{{$datatable['table']['action'] ?? "Action"}}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$datatable['table']['number'] ?? "No"}}</td>
                        <td>{{$datatable['table']['name'] ?? "Name"}}</td>
                        <td>{{$datatable['table']['label'] ?? "Label"}}</td>
                        <td>{{$datatable['table']['url'] ?? "URL"}}</td>
                        <td>{{$datatable['table']['order'] ?? "Order"}}</td>
                        <td>{{$datatable['table']['target'] ?? "Target"}}</td>
                        <td>{{$datatable['table']['status'] ?? "Status"}}</td>
                        <td>{{$datatable['table']['action'] ?? "Action"}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- End app -->

</div>
<!-- End Home -->

@endsection

@push('footermenu-home-js')
<script type="text/javascript" alt="datatable">
    $("#footermenu_datatable").DataTable({
        scrollX: true,
        processing: true,
        ajax: "{{route('footermenu.datatable')}}",
        dom: 'lfrtip',
        paging: true,
        pageLength: 5,
        lengthMenu: [ 5, 10, 25 ],
        columns: [
            { data: 'DT_RowIndex', width: '10%', name: 'DT_RowIndex', searchable: false, orderable: true, className: 'dt-center' },
            { data: 'name', name: 'name', searchable: true, orderable: true },
            { data: 'label', name: 'label', searchable: true, orderable: true },
            { data: 'url', name: 'url', searchable: true, orderable: true },
            { data: 'order', name: 'order', searchable: true, orderable: true },
            { data: 'target', name: 'target', searchable: true, orderable: true },
            { data: 'status', name: 'status', searchable: true, orderable: true },
            {
                data: 'action',  width: '25%', name: 'action', orderable: false, searchable: false, render: function (data, type, full, meta) {
                    var id = data;
                    // Show
                    var show = "{{route('footermenu.show', ':id')}}";
                    show = show.replace(':id', id);
                    // Edit
                    var edit = "{{route('footermenu.edit', ':id')}}";
                    edit = edit.replace(':id', id);
                    // Delete
                    var destroy = "{{route('footermenu.destroy', ':id')}}";
                    destroy = destroy.replace(':id', id);
                    return "" +
                    // Edit Button
                    '<a href="' + edit + '" class="btn btn-primary my-1 w-100"><i class="fas fa-pen-square me-2"></i>{{$button["edit"] ?? "Edit"}}</a>' +
                    // Destroy Button
                    '<a id="destroy" href="' + destroy + '" class="btn btn-danger my-1 w-100"><i class="fas fa-trash me-2"></i>{{$button["delete"] ?? "Delete"}}</a>';
                }
            },
        ],
        "language": {
            "search": "",
            "lengthMenu": "{{$datatable['length_menu'] ?? 'Show _MENU_ entries'}}",
            "searchPlaceholder": "{{$datatable['search'] ?? 'Search:'}}",
            "info": "{{$datatable['info'] ?? 'Showing _START_ to _END_ of _TOTAL_ entries'}}",
            "paginate": {
                "previous": "{{$datatable['previous'] ?? 'Previous'}}",
                "next": "{{$datatable['next'] ?? 'Next'}}",
            }
        }
    });
</script>

<script alt="footermenu-delete">
    $(document).on('click', '#destroy', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        Swal.fire({
            title: "{{$messages['ask_delete'] ?? 'Do you want to delete this?'}}",
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
        }).then(function (e) {
            var CSRF_TOKEN = "{{csrf_token()}}";
            if (e.value === true) {
                $.ajax({
                    type: 'DELETE',
                    url: url,
                    data: { _token: CSRF_TOKEN },
                    dataType: 'JSON',
                    success: function (results) {
                        if (results.status === 'success') {
                            Swal.fire({
                                title: "{{$messages['delete_success'] ?? 'Data deleted successfully'}}",
                                text: results.message,
                                icon: "success",
                                customClass: {
                                    popup: "rad-25",
                                    confirmButton: "btn btn-success px-5 rad-25",
                                },
                                buttonsStyling: false,
                            }).then(() => {
                                $('#footermenu_datatable').DataTable().ajax.reload();
                            });
                        } else {
                            Swal.fire({
                                title: "{{$messages['delete_failed'] ?? 'Data failed to delete'}}",
                                text: results.message,
                                icon: "error",
                            }).then(() => {
                                $('#footermenu_datatable').DataTable().ajax.reload();
                            });
                        }
                    }
                });
            } else {
                e.dismiss;
            }
        }, function (dismiss) {
        })
    })
</script>
@endpush
