@extends('template.default.dashboard.index')

@section('message-home')

<!-- Start Breadcrumb -->
<nav class="bg-light py-3 px-2 px-md-5 shadow-sm d-flex justify-content-between" aria-label="breadcrumb">
    <h5 class="my-0"><i class="fa-regular fa-comment-dots me-3"></i>{{$breadcrumb['title']}}</h5>
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
    <div class="card" id="meta-home">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="align-self-center">{{$datatable['header']['title']}}</h5>
            </div>
        </div>
        <div class="card-body">
            <table id="message_datatable" class="table table-bordered w-100">
                <thead>
                    <tr>
                        <th>{{$datatable['table']['number']}}</th>
                        <th>{{$datatable['table']['name']}}</th>
                        <th>{{$datatable['table']['email']}}</th>
                        <th>{{$datatable['table']['read_at']}}</th>
                        <th>{{$datatable['table']['action']}}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$datatable['table']['number']}}</td>
                        <td>{{$datatable['table']['name']}}</td>
                        <th>{{$datatable['table']['email']}}</th>
                        <th>{{$datatable['table']['read_at']}}</th>
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
<div class="modal fade" id="modal-detail-message">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body w-100">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="mb-3">
                                <label for="" class="fw-bold form-label">{{$detail['name']}}</label>
                                <div id="message-id" style="display: none;"></div>
                                <div id="message-name" style="font-weight: 200"></div>
                            </div>
                            <div class="mb-3">
                                <label for="" class="fw-bold form-label">{{$detail['email']}}</label>
                                <div id="message-email" style="font-weight: 200"></div>
                            </div>
                            <div class="mb-3">
                                <label for="" class="fw-bold form-label">{{$detail['phone']}}</label>
                                <div id="message-phone" style="font-weight: 200"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <div class="mb-3">
                                <label for="" class="fw-bold form-label">{{$detail['message']}}</label><br>
                                <div id="message-message" style="font-weight: 200"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="readSwitch">
                        <label class="form-check-label" for="readSwitch">{{$detail['switch']}}</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->

@endsection

@push('message-home-js')
<script type="text/javascript" alt="datatable">
    $("#message_datatable").DataTable({
        scrollX: true,
        processing: true,
        ajax: "{{route('message.datatable')}}",
        dom: 'lfrtip',
        paging: true,
        pageLength: 5,
        lengthMenu: [ 5, 10, 25 ],
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: true },
            { data: 'name', name: 'name',  searchable: true, orderable: true },
            { data: 'email', name: 'email',  searchable: true, orderable: true },
            { data: 'read_at', name: 'read_at',  searchable: true, orderable: true },
            {
                data: 'action', name: 'action', orderable: false, searchable: false, render: function (data, type, full, meta) {
                    var id = data;
                    // Show
                    var show = "{{route('message.show', ':id')}}";
                    show = show.replace(':id', id);
                    // Delete
                    var destroy = "{{route('message.destroy', ':id')}}";
                    destroy = destroy.replace(':id', id);
                    return "" +
                    // Show Button
                    '<button href="' + show + '" class="btn btn-secondary my-1 w-100" id="modal-message"><i class="fas fa-eye me-2"></i>{{$button["show"]}}</button>' +
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

<script alt="message-delete">
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
                                var dataTable = $('#message_datatable').DataTable();
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
                                var dataTable = $('#message_datatable').DataTable();
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

<script type="text/javascript">
    $(document).on('click', '#modal-message', function () {
        var link = $(this).attr('href');
        $.ajax({
            type: 'GET',
            url: link,
            cache: false,
            success: function (result) {
                let tags = '';
                $("#modal-detail-message").modal('show');
                $('#message-id').val(result.data['message'].id);
                $('#message-name').html(result.data['message'].name);
                $('#message-email').html(result.data['message'].email);
                $('#message-phone').html(result.data['message'].phone);
                $('#message-message').html(result.data['message'].message);

                if(result.data['message'].read_at !== null){
                    $('#readSwitch').prop('checked', true);
                } else {
                    $('#readSwitch').prop('checked', false);
                }

            }
        });
    });
</script>

<script type="text/javascript">
    $('#readSwitch').on('change', function() {
        const getid = $('#message-id').val();
        const isChecked = $(this).is(':checked');
        if (isChecked) {
            let read_on = '{{route("message.read.on")}}'
            $.ajax({
                    type: 'POST',
                    url: read_on,
                    data: { _token: "{{csrf_token()}}", id: getid },
                    dataType: 'JSON',
                    success: function (results) {
                        $('#readSwitch').prop('checked', true);
                        var dataTable = $('#message_datatable').DataTable();

                        // Reload the DataTable
                        function reloadDataTable() {
                            dataTable.ajax.reload(null, false);
                        }

                        reloadDataTable();

                        function reloadNotificationCount(){
                            $.ajax({
                                type: 'GET',
                                url: "{{route('message.notification.count')}}",
                                cache: false,
                                success: function (result) {
                                    $('#notification_count').html(result["message_notification_count"]);
                                    var myArray = result["message_notification"]

                                    // Display the array elements
                                    function displayArray() {
                                        var container = $('#list-message');
                                        container.empty(); // Clear previous content
                                        container.append("<small class='text-muted mb-1'>{{$navigation_message_notification}}</small>");
                                        for (var i = 0; i < myArray.length; i++) {
                                            var element = "<a class='dropdown-item' href='{{route('message.index')}}'>from: " + myArray[i].name + "</a>";
                                            container.append(element);
                                        }
                                    }

                                    // Call the displayArray function
                                    displayArray();
                                }
                            });
                        }

                        reloadNotificationCount();
                    }
                });
        } else {
            var read_off = '{{route("message.read.off")}}'
                    $.ajax({
                        type: 'POST',
                        url: read_off,
                        data: { _token: "{{csrf_token()}}", id: getid },
                        dataType: 'JSON',
                        success: function (results) {
                            $('#readSwitch').prop('checked', false);
                            var dataTable = $('#message_datatable').DataTable();

                            // Reload the DataTable
                            function reloadDataTable() {
                                dataTable.ajax.reload(null, false);
                            }

                            reloadDataTable();

                            function reloadNotificationCount(){
                                $.ajax({
                                    type: 'GET',
                                    url: "{{route('message.notification.count')}}",
                                    cache: false,
                                    success: function (result) {
                                        var myArray = result["message_notification"]
                                        $('#notification_count').html(result["message_notification_count"]);
                                        var myArray = result["message_notification"]

                                        // Display the array elements
                                        function displayArray() {
                                            var container = $('#list-message');
                                            container.empty();
                                            container.append("<small class='text-muted mb-1'>{{$navigation_message_notification}}</small>");
                                            for (var i = 0; i < myArray.length; i++) {
                                                var element = "<a class='dropdown-item' href='{{route('message.index')}}'>" + myArray[i].name + "</a>";
                                                container.append(element);
                                            }
                                        }

                                        // Call the displayArray function
                                        displayArray();
                                    }
                                });
                            }

                            reloadNotificationCount();
                    }
                });

        }
    });
</script>
@endpush
