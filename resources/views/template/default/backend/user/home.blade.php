@extends('template.default.backend.index')

@section('user-home')
<!-- Start Breadcrumb -->
<nav class="bg-light py-3 px-2 px-md-5 shadow-sm d-flex justify-content-between" aria-label="breadcrumb">
    <h5 class="my-0"><i class="fa-solid fa-user me-3"></i>{{$breadcrumb['title']}}</h5>
    <ol class="breadcrumb my-0">
        <li class="breadcrumb-item text-muted">{{$breadcrumb['index']}}</li>
    </ol>
</nav>
<!-- End Breadcrumb -->

<!-- Start Home -->
<div class="container py-3">

    <!-- Start app -->
    <div class="card" id="user-home">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="align-self-center my-0">{{$datatable['header']['title']}}</h5>
                @can('user-create')
                <a href="{{route('user.create')}}" class="btn btn-success">{{$button['create']}}<i
                        class="fa-solid fa-plus ms-3"></i></a>
                @endcan
            </div>
        </div>
        <div class="card-body">
            <!-- <div class="table-responsive"> -->
            <table id="user_datatable" class="table table-bordered w-100">
                <thead class="table-light">
                    <tr>
                        <th>{{$datatable['table']['number']}}</th>
                        <th>{{$datatable['table']['image']}}</th>
                        <th>{{$datatable['table']['name']}}</th>
                        <th>{{$datatable['table']['email']}}</th>
                        <th>{{$datatable['table']['role']}}</th>
                        <th>{{$datatable['table']['action']}}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$datatable['table']['number']}}</td>
                        <td>{{$datatable['table']['image']}}</td>
                        <td>{{$datatable['table']['name']}}</td>
                        <td>{{$datatable['table']['email']}}</td>
                        <td>{{$datatable['table']['role']}}</td>
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

<!-- Start Modal -->
<div class="modal fade" id="modal-detail-user">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{$detail['title']}}</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="container px-3 py-3">
                            <div class="form-group d-flex justify-content-start my-3">
                                <div id="user-image"></div>
                            </div>
                            <div class="form-group d-flex justify-content-start my-3">
                                <label for="" class="fw-bold">{{$detail['name']}} :</label>&nbsp;
                                <div id="user-name"></div>
                            </div>
                            <div class="form-group d-flex justify-content-start my-3">
                                <label for="" class="fw-bold">{{$detail['email']}} :</label>&nbsp;
                                <div id="user-email"></div>
                            </div>
                            <div class="form-group d-flex justify-content-start my-3">
                                <label for="" class="fw-bold">{{$detail['phone']}} :</label>&nbsp;
                                <div id="user-phone"></div>
                            </div>
                            <div class="form-group d-flex justify-content-start my-3">
                                <label for="" class="fw-bold">{{$detail['role']}} :</label>&nbsp;
                                <div id="user-role"></div>
                            </div>
                            <div class="form-group d-flex justify-content-start my-3">
                                <label for="" class="fw-bold">{{$detail['is_verified']}} :</label>&nbsp;
                                <div id="user-verified"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->
@endsection

@push('user-home-js')
@can('user-index')
<script type="text/javascript" alt="datatable">
    $("#user_datatable").DataTable({
        scrollX: true,
        processing: true,
        serverSide: true,
        ajax: "{{route('user.datatable')}}",
        dom: 'lfrtip',
        paging: true,
        pageLength: 10,
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false },
            {
                data: 'image', render: function (data, type, full, meta) {
                    if (data === '/storage/') {
                        return '{{$messages["image_not_available"]}}';
                    } else {
                        return '<img class="img-fluid w-100" src="' + data + '">';
                    }
                }
            },
            { data: 'name', name: 'name', searchable: true, orderable: true },
            { data: 'email', name: 'email', searchable: true, orderable: true },
            { data: 'role', name: 'role', searchable: true, orderable: true },
            {
                data: 'action', name: 'action', width: '15%', orderable: false, searchable: false, render: function (data, type, full, meta) {
                    var id = data;
                    // Show
                    var show = "{{route('user.show', ':id')}}";
                    show = show.replace(':id', id);
                    // Edit
                    var edit = "{{route('user.edit', ':id')}}";
                    edit = edit.replace(':id', id);
                    // Delete
                    var destroy = '{{ route("user.destroy", ":id") }}';
                    destroy = destroy.replace(':id', id);
                    return "" +
                    // Show Button
                    '@can ("user-show")<button href="' + show + '" class="btn btn-secondary my-1 w-100" id="modal-user"><i class="fas fa-eye me-2"></i>{{$button["show"]}}</button>@endcan' +
                    // Edit Button
                    '@can ("user-edit")<a href="' + edit + '" class="btn btn-primary my-1 w-100"><i class="fas fa-pen-square me-2"></i>{{$button["edit"]}}</a>@endcan' +
                    // Destroy Button
                    '@can ("user-destroy")<a id="destroy" href="' + destroy + '" class="btn btn-danger my-1 w-100"><i class="fas fa-trash me-2"></i>{{$button["delete"]}}</a>@endcan';
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

<script type="text/javascript">
    $(document).on('click', '#modal-user', function () {
        var link = $(this).attr('href');
        $.ajax({
            type: 'GET',
            url: link,
            cache: false,
            success: function (result) {
                $("#modal-detail-user").modal('show');
                if ( result.data['user'].image !== null) {
                    $('#user-image').html("<img src='/storage/" + result.data['user'].image + "' class='img-fluid w-25'>");
                } else {
                    $('#user-image').html("{{$messages['image_not_available']}}");
                }
                $('#user-name').html(result.data['user'].name);
                $('#user-email').html(result.data['user'].email);
                $('#user-phone').html(result.data['user'].phone);
                $('#user-role').html(result.data['role']);
                $('#user-verified').html(result.data['is_verified']);
            }
        });
    });
</script>

<script alt="user-delete">
    /* Delete User */
    $(document).on('click', '#destroy', function(e){
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
                    $.ajax({
                    type: 'DELETE',
                    url: url,
                    data: {_token: "{{csrf_token()}}"},
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
                                    title: "{{$messages['delete_failed']}}",
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
@endcan
@endpush
