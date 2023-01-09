@extends('template.default.dashboard.index')

@section('post-home')

<!-- Start Breadcrumb -->
<nav class="bg-light py-3 px-2 px-md-5 shadow-sm d-flex justify-content-between" aria-label="breadcrumb">
    <h5 class="my-0"><i class="fa-solid fa-signs-post me-3"></i>{{$breadcrumb['title']}}</h5>
    <ol class="breadcrumb my-0">
        <li class="breadcrumb-item"><a href="{{route($url)}}"
                class="text-decoration-none text-dark">{{$breadcrumb['home']}}</a>
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
    <div class="card" id="post-home">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="align-self-center">{{$datatable['header']['title']}}</h5>
                <a href="{{route('post.create')}}" class="btn btn-success">{{$button['create']}}<i
                        class="fa-solid fa-plus ms-3"></i></a>
            </div>
        </div>
        <div class="card-body">
            <table id="post_datatable" class="table table-bordered w-100">
                <thead>
                    <tr>
                        <th>{{$datatable['table']['number']}}</th>
                        <th>{{$datatable['table']['title']}}</th>
                        <th>{{$datatable['table']['image']}}</th>
                        <th>{{$datatable['table']['publish']}}</th>
                        <th>{{$datatable['table']['action']}}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$datatable['table']['number']}}</td>
                        <td>{{$datatable['table']['title']}}</td>
                        <td>{{$datatable['table']['image']}}</td>
                        <td>{{$datatable['table']['publish']}}</td>
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

@push('post-home-js')
<script type="text/javascript" alt="datatable">
    $("#post_datatable").DataTable({
        scrollX: true,
        processing: true,
        ajax: "{{route('post.datatable')}}",
        dom: 'lfrtip',
        paging: true,
        pageLength: 5,
        lengthMenu: [ 5, 10, 25 ],
        columns: [
            { data: 'DT_RowIndex', width: '10%', name: 'DT_RowIndex', searchable: false, orderable: true, className: 'dt-center' },
            { data: 'title', name: 'title', searchable: true, orderable: true },
            {
                data: 'image', name: 'image', className: "w-25", searchable: false, orderable: false, render: function (data, type, full, meta) {
                    if (data === '/storage/') {
                            return 'Image not available';
                    } else {
                            return '<img class="img-fluid w-75" src="' + data + '">'
                    }
                }
            },
            { data: 'publish', name: 'publish', searchable: true, orderable: true },
            {
                data: 'action',  width: '25%', name: 'action', orderable: false, searchable: false, render: function (data, type, full, meta) {
                    var id = data;
                    // Edit
                    var edit = "{{route('post.edit', ':id')}}";
                    edit = edit.replace(':id', id);
                    // Delete
                    var destroy = "{{route('post.destroy', ':id')}}";
                    destroy = destroy.replace(':id', id);
                    return "" +
                    // Edit Button
                    '<a href="' + edit + '" class="btn btn-primary my-1 w-100"><i class="fas fa-pen-square me-2"></i>{{$button["edit"]}}</a>' +
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

<script alt="tag-delete">
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
                    type: 'DELETE',
                    url: url,
                    data: { _token: "{{csrf_token()}}" },
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
@endpush
