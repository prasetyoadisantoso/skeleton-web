@extends('template.default.backend.page.index')

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

<!-- Start Modal -->
<div class="modal fade" id="modal-detail-post">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body w-100">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <div class="mb-3">
                                <label for="" class="fw-bold form-label">{{$detail['title']}}</label>
                                <div id="post-title" class="fw-bold" style="font-size: 30px;"></div>
                            </div>
                            <div class="mb-3">
                                <label for="" class="fw-bold form-label">{{$detail['content']}}</label>
                                <div id="post-content"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="mb-3">
                                <label for="" class="fw-bold form-label">{{$detail['category']}}</label><br>
                                <div id="post-category"></div>
                            </div>
                            <div class="mb-3">
                                <label for="" class="fw-bold form-label">{{$detail['tags']}}</label>
                                <div id="post-tag"></div>
                            </div>
                            <div class="mb-3">
                                <label for="" class="fw-bold form-label">{{$detail['meta']}}</label>
                                <div id="post-meta"></div>
                            </div>
                            <div class="mb-3">
                                <label for="" class="fw-bold form-label">{{$detail['opengraph']}}</label>
                                <div id="post-opengraph"></div>
                            </div>
                            <div class="mb-3">
                                <label for="" class="fw-bold form-label">{{$detail['canonical']}}</label>
                                <div id="post-canonical"></div>
                            </div>
                            <div class="mb-3">
                                <label for="" class="fw-bold form-label">{{$detail['schema'] ?? 'Schema'}}</label>
                                <div id="post-schema"></div>
                            </div>
                            <div class="mb-3">
                                <label for="" class="fw-bold form-label">{{$detail['feature_image']}}</label>
                                <div id="post-feature-image"></div>
                            </div>
                            <div class="mb-3">
                                <label for="" class="fw-bold form-label">{{$detail['author']}}</label>
                                <div id="post-author"></div>
                            </div>
                            <div class="mb-3">
                                <label for="" class="fw-bold form-label">{{$detail['is_published']}}</label>
                                <div id="post-published"></div>
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
                    // Show
                    var show = "{{route('post.show', ':id')}}";
                    show = show.replace(':id', id);
                    // Edit
                    var edit = "{{route('post.edit', ':id')}}";
                    edit = edit.replace(':id', id);
                    // Delete
                    var destroy = "{{route('post.destroy', ':id')}}";
                    destroy = destroy.replace(':id', id);
                    return "" +
                    // Show Button
                    '@can ("post-show")<button href="' + show + '" class="btn btn-secondary my-1 w-100" id="modal-post"><i class="fas fa-eye me-2"></i>{{$button["show"]}}</button>@endcan' +
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

<script alt="post-delete">
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

<script type="text/javascript">
    $(document).on('click', '#modal-post', function () {
        var link = $(this).attr('href');
        $.ajax({
            type: 'GET',
            url: link,
            cache: false,
            success: function (result) {
                console.log(result);
                let tags = '';
                $("#modal-detail-post").modal('show');
                $('#post-title').html(result.data['post'].title.{{LaravelLocalization::getCurrentLocale()}});
                $('#post-content').html(result.data['post'].content.{{LaravelLocalization::getCurrentLocale()}});

                if( result.data['category'] !== null || result.data['category'] === '' ){
                    $('#post-category').html(result.data['category'].name.{{LaravelLocalization::getCurrentLocale()}});
                } else {
                    $('#post-category').html('...');
                }

                result.data['tag'].forEach((item) => {
                    tags += item.name.{{LaravelLocalization::getCurrentLocale()}} + ", ";
                });
                $('#post-tag').html(tags);

                if( result.data['meta'] !== null || result.data['meta'] === '' ){
                    $('#post-meta').html(result.data['meta'].title.{{LaravelLocalization::getCurrentLocale()}});
                } else {
                    $('#post-meta').html('...');
                }

                if( result.data['opengraph'] !== null || result.data['opengraph'] === '' ){
                    $('#post-opengraph').html(result.data['opengraph'].og_title.{{LaravelLocalization::getCurrentLocale()}});
                } else {
                    $('#post-opengraph').html('...');
                }

                if( result.data['canonical'] !== null || result.data['canonical'] === '' ){
                    $('#post-canonical').html(result.data['canonical'].name);
                } else {
                    $('#post-canonical').html('...');
                }

                if( result.data['schema'] !== null || result.data['schema'] === '' ){
                    $('#post-schema').html(result.data['schema'].schema_name);
                } else {
                    $('#post-schema').html('...');
                }

                if ( result.data['image'] !== null) {
                    $('#post-feature-image').html("<img src='/storage/" + result.data['image'] + "' class='img-fluid w-50'>");
                } else {
                    $('#post-feature-image').html("{{$messages['image_not_available']}}");
                }
                $('#post-author').html(result.data['author'].name);
                if(result.data['published'] === "Yes"){
                    $('#post-published').html("{{$detail['yes']}}");
                }
                if(result.data['published'] === "No"){
                    $('#post-published').html("{{$detail['no']}}");
                }
            }
        });
    });
</script>
@endpush
