@extends('template.default.backend.page.index')

@section('activity-home')

<!-- Start Breadcrumb -->
<nav class="bg-light py-3 px-2 px-md-5 shadow-sm d-flex justify-content-between" aria-label="breadcrumb">
    <h5 class="my-0"><i class="fa-regular fa-rectangle-list me-3"></i>{{$breadcrumb['title']}}</h5>
    <ol class="breadcrumb my-0">
        <li class="breadcrumb-item"><a href="{{route('activity.index')}}"
                class="text-decoration-none text-dark">{{$breadcrumb['home']}}</a>
        </li>
        <li class="breadcrumb-item active text-muted" aria-current="page">
            {{$breadcrumb['index']}}
        </li>
    </ol>
</nav>
<!-- End Breadcrumb -->

<!-- Start Home -->
<div class="container py-2" id="myElement">

    <!-- Start app -->
    <div class="card" id="meta-home">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="align-self-center">{{$datatable['header']['title']}}</h5>
                <a href="{{route('activity.empty')}}" class="btn btn-dark" id='empty'>{{$button['empty']}}
                    <i class="fa-solid fa-triangle-exclamation ms-3"></i></a>
            </div>
        </div>
        <div class="card-body">
            <table id="activity_datatable" class="table table-bordered w-100">
                <thead>
                    <tr>
                        <th>{{$datatable['table']['ip_address']}}</th>
                        <th>{{$datatable['table']['user']}}</th>
                        <th>{{$datatable['table']['activity']}}</th>
                        <th>{{$datatable['table']['model']}}</th>
                        <th>{{$datatable['table']['date']}}/{{$datatable['table']['time']}}</th>
                        <th>{{$datatable['table']['action']}}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$datatable['table']['ip_address']}}</td>
                        <td>{{$datatable['table']['user']}}</td>
                        <td>{{$datatable['table']['activity']}}</td>
                        <td>{{$datatable['table']['model']}}</td>
                        <td>{{$datatable['table']['date']}}/{{$datatable['table']['time']}}</td>
                        <td>{{$datatable['table']['action']}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- End app -->

</div>
<!-- End Home -->

@endsection

@push('activity-home-js')
<script type="text/javascript" alt="datatable" id="script-1">
    $("#activity_datatable").DataTable({
        scrollX: true,
        processing: true,
        ajax: "{{route('activity.datatable')}}",
        dom: 'tp',
        order: [[ 4, 'desc' ]],
        paging: true,
        pageLength: 10,
        columns: [
            { data: 'ip_address', name: 'ip_address', searchable: false, orderable: true, render: function (data, type, full, meta) {
                var props = JSON.parse(data);
                if(props === null){
                    return "-";
                } else {
                    return props.ip;
                }
            }},
            { data: 'user', name: 'user', searchable: true, orderable: true, render: function (data, type, full, meta) {
                var users = JSON.parse(data);
                if(users === null){
                    return "guest";
                } else {
                    return users.name;
                }
            }},
            { data: 'activity', name: 'activity', searchable: true, orderable: true },
            { data: 'model', name: 'model', searchable: true, orderable: true },
            { data: 'date', name: 'date', searchable: true, orderable: true },
            {
                data: 'action', name: 'action', width: "15%", orderable: false, searchable: false, render: function (data, type, full, meta) {
                    var id = data;
                    // Delete
                    var destroy = "{{route('activity.destroy', ':id')}}";
                    destroy = destroy.replace(':id', id);
                    return "" +
                    // Destroy Button
                    '<a id="destroy" href="' + destroy + '" class="btn btn-danger my-1 w-100"><i class="fas fa-trash me-2"></i>{{$button["delete"]}}</a>';
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
                "next": "{{$datatable['next']}}",
            }
        }
    });
</script>

<script alt="delete" id="script-2">
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
                confirmButton: "btn btn-success px-5 rad-25 mx-1 my-1",
                cancelButton: "btn btn-danger px-5 rad-25 mx-1 my-1 order-sm-1",
            },
            buttonsStyling: false,
            reverseButtons: false,
        }).then(function (e) {
            if (e.value === true) {
                $.ajax({
                    type: 'GET',
                    url: url,
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

                                var dataTable = $('#activity_datatable').DataTable();

                                // Reload the DataTable
                                function reloadDataTable() {
                                    dataTable.ajax.reload(null, false);
                                }

                                reloadDataTable();


                            });
                        } else {
                            Swal.fire({
                                title: "{{$messages['delete_failed']}}",
                                text: results.message,
                                icon: "error",
                            }).then(() => {
                                var dataTable = $('#activity_datatable').DataTable();

                                // Reload the DataTable
                                function reloadDataTable() {
                                    dataTable.ajax.reload(null, false);
                                }

                                reloadDataTable();
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

<script alt="empty">
    $(document).on('click', '#empty', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        Swal.fire({
            title: "{{$messages['ask_empty']}}",
            icon: "warning",
            showCancelButton: !0,
            cancelButtonText: "{{$button['cancel']}}",
            confirmButtonText: "{{$button['confirm']}}",
            customClass: {
                confirmButton: "btn btn-success px-5 rad-25 mx-1 my-1",
                cancelButton: "btn btn-danger px-5 rad-25 mx-1 my-1 order-sm-1",
            },
            buttonsStyling: false,
            reverseButtons: false,
        }).then(function (e) {
            if (e.value === true) {
                $.ajax({
                    type: 'GET',
                    url: url,
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
                                var dataTable = $('#activity_datatable').DataTable();

                                // Reload the DataTable
                                function reloadDataTable() {
                                    dataTable.ajax.reload(null, false);
                                }

                                reloadDataTable();
                                });
                        } else {
                            Swal.fire({
                                title: "{{$messages['delete_failed']}}",
                                text: results.message,
                                icon: "error",
                            }).then(() => {
                                var dataTable = $('#activity_datatable').DataTable();

                                // Reload the DataTable
                                function reloadDataTable() {
                                    dataTable.ajax.reload(null, false);
                                }

                                reloadDataTable();
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
