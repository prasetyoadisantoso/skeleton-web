@extends('template.default.backend.page.index')

@section('permission-home')
<!-- Start Breadcrumb -->
<nav class="bg-light py-3 px-2 px-md-5 shadow-sm d-flex justify-content-between" aria-label="breadcrumb">
    <h5 class="my-0"><i class="fa-solid fa-person-military-pointing me-3"></i>{{$breadcrumb['title']}}</h5>
    <ol class="breadcrumb my-0">
        <li class="breadcrumb-item active text-muted" aria-current="page">{{$breadcrumb['index']}}</li>
    </ol>
</nav>
<!-- End Breadcrumb -->

<!-- Start Home -->
<div class="container py-3">

    <!-- Start app -->
    <div class="card" id="permission-home">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="align-self-center">{{$datatable['header']['title']}}</h5>
                @can ("permission-create")
                <a href="{{route('permission.create')}}" class="btn btn-success">{{$button['create']}}<i
                    class="fa-solid fa-plus ms-3"></i></a>
                @endcan
            </div>
        </div>
        <div class="card-body">
            <!-- <div class="table-responsive"> -->
            <table id="permission_datatable" class="table table-bordered w-100">
                <thead>
                    <tr>
                        <th>{{$datatable['table']['number']}}</th>
                        <th>{{$datatable['table']['name']}}</th>
                        <th>{{$datatable['table']['action']}}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$datatable['table']['number']}}</td>
                        <td>{{$datatable['table']['name']}}</td>
                        <td>{{$datatable['table']['action']}}</td>
                    </tr>
                </tbody>
            </table>
            <!-- </div> -->
        </div>
    </div>
    <!-- End app -->

</div>
<!-- End Home -->
@endsection

@push('permission-home-js')
<script type="text/javascript" alt="datatable">
    $("#permission_datatable").DataTable({
        scrollX: true,
        processing: true,
        ajax: "{{route('permission.datatable')}}",
        dom: 'frtip',
        paging: true,
        pageLength: 10,
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false, width: "5%", },
            { data: 'name', name: 'name', searchable: true, orderable: true },
            {
                data: 'action', name: 'action', width: "20%", orderable: false, searchable: false, render: function (data, type, full, meta) {
                    var id = data;
                    // Edit
                    var edit = '{{route("permission.edit", ":id")}}';
                    edit = edit.replace(':id', id);
                    // Delete
                    var destroy = '{{route("permission.destroy", ":id")}}';
                    destroy = destroy.replace(':id', id);
                    return "" +
                    // Edit Button
                    '@can ("permission-edit")<a href="' + edit + '" class="btn btn-primary my-1 w-100"><i class="fas fa-pen-square me-2"></i>{{$button["edit"]}}</a>@endcan' +
                    // Destroy Button
                    '@can ("permission-destroy")<a id="destroy" href="' + destroy + '" class="btn btn-danger my-1 w-100"><i class="fas fa-trash me-2"></i>{{$button["delete"]}}</a>@endcan';
                }
            },
        ],
        "language": {
            "search": "",
            "lengthMenu": "{{$datatable['length_menu']}}",
            "searchPlaceholder": "{{$datatable['search']}}",
            "info": "{{$datatable['info']}}",
            "paginate": {
                "previous": "{{$datatable['previous']}}",
                "ext": "{{$datatable['next']}}",
            }
        }
    });
</script>

<script alt="permission-delete">
    /* Delete Permission */
    $(document).on('click', '#destroy', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        Swal.fire({
            title: "{{$messages['ask_delete']}}",
            icon: "warning",
            showCancelButton: !0,
            cancelButtonText: "{{$button['cancel']}}",
            confirmButtonText: "{{$button['confirm']}}",
            customClass: {
                popup: "rad-25",
                confirmButton: "btn btn-success px-5 rad-25 mx-1 my-1",
                cancelButton: "btn btn-danger px-5 rad-25 mx-1 my-1 order-sm-1",
            },
            buttonsStyling: false,
            reverseButtons: false,
        }).then(function (e) {
            if (e.value === true) {
                var CSRF_TOKEN = "{{csrf_token()}}";
                $.ajax({
                    type: 'DELETE',
                    url: url,
                    data: { _token: CSRF_TOKEN },
                    dataType: 'JSON',
                    success: function (results) {
                        if (results.status === 'success') {
                            Swal.fire({
                                title: "{{$messages['delete_success']}}",
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
                                title: "$messages['delete_failed']",
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
        }, function (dismiss) {
        })
    })
</script>
@endpush
