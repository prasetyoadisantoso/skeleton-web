@extends('template.default.dashboard.index')

@section('user-home')
<!-- Start Breadcrumb -->
<nav class="bg-light py-3 px-5 shadow-sm d-flex justify-content-between" aria-label="breadcrumb">
    <h5 class="my-0">{{$breadcrumb['home']}}</h5>
    <ol class="breadcrumb my-0">
        <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-dark">{{$breadcrumb['index']}}</a></li>
        <li class="breadcrumb-item active text-muted" aria-current="page">{{$breadcrumb['current_index']}}</li>
    </ol>
</nav>
<!-- End Breadcrumb -->

<!-- Start Home -->
<div class="container py-2">

    <!-- Start app -->
    <div class="card" id="user-home">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="align-self-center">Users List</h5>
                <a href="create.html" class="btn btn-success">Create</a>
            </div>
        </div>
        <div class="card-body">
            <!-- <div class="table-responsive"> -->
            <table id="user_datatable" class="table table-bordered w-100">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Image</td>
                        <td>Administrator Department</td>
                        <td>Email</td>
                        <td>Action</td>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail Users</h4>
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
                                <label for="" class="me-3">Name :</label>&nbsp;
                                <div id="user-name"></div>
                            </div>
                            <div class="form-group d-flex justify-content-start my-3">
                                <label for="" class="me-3">Email :</label>
                                <div id="user-email"></div>
                            </div>
                            <div class="form-group d-flex justify-content-start my-3">
                                <label for="" class="me-3">Phone :</label>
                                <div id="user-phone"></div>
                            </div>
                            <div class="form-group d-flex justify-content-start my-3">
                                <label for="" class="me-3">Role :</label>
                                <div id="user-role"></div>
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
                data: 'image', width: "10%", render: function (data, type, full, meta) {
                    if (data === '/storage/') {
                        return 'Image not available';
                    } else {
                        return '<img class="img-fluid w-100" src="' + data + '">';
                    }
                }
            },
            { data: 'name', name: 'name', searchable: true, orderable: true },
            { data: 'email', name: 'email', searchable: true, orderable: true },
            {
                data: 'action', name: 'action', orderable: false, searchable: false, render: function (data, type, full, meta) {
                    var id = data;
                    // Show
                    var show = "{{route('user.show', ':id')}}";
                    show = show.replace(':id', id);
                    // Edit
                    var edit = 'edit.html';
                    // edit = edit.replace(':id', id);
                    // Delete
                    var destroy = 'status.php';
                    // destroy = destroy.replace(':id', id);
                    return '<button href="' + show + '" class="btn btn-dark rad-25 mx-2 my-1" id="modal-user"><i class="fas fa-eye mx-2"></i>Show</button>' + '<a href="' + edit + '" class="btn btn-secondary rad-25 mx-2 my-1"><i class="fas fa-pen-square mx-2"></i>Edit</a>' + '<a id="destroy" href="' + destroy + '" class="btn btn-danger rad-25 my-1 mx-2"><i class="fas fa-trash mx-2"></i>Hapus</a>';
                }
            },
        ],
        "oLanguage": {
            "sSearch": "",
            "sSearchPlaceholder": "Search: ",
            "oPaginate": {
                "sPrevious": "previous",
                "sNext": "next",
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
            success: function (data) {
                let value = data;
                $("#modal-detail-user").modal('show');
                $('#user-image').html("<img src='/storage/" + value.data['user'].image + "' class='img-fluid w-25'>");
                $('#user-name').html(value.data['user'].name);
                $('#user-email').html(value.data['user'].email);
                $('#user-phone').html(value.data['user'].phone);
                $('#user-role').html(value.data['role']);
            }
        });
    });
</script>
@endpush

