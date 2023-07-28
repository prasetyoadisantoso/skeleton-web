@if (count($errors) > 0)
@foreach ($errors->all() as $error)
{{-- Error Validation Sweetalert --}}
<script>
    Swal.fire({
            title: "{{ $error }}",
            icon:'error',
            customClass: {
                confirmButton: "btn btn-danger px-5",
            },
            buttonsStyling: false,
    });
</script>
@endforeach
@endif

@if ($message = Session::get('success'))
{{-- Success Sweetalert --}}
<script>
    Swal.fire({
            title:"{{Session::get('title')}}",
            text:"{{Session::get('content')}}",
            icon:'success',
            customClass: {
                confirmButton: "btn btn-success px-5",
            },
            buttonsStyling: false,
        });
</script>
@endif

@if (Session::has('error'))
{{-- Error Sweetalert --}}
<script type="text/javascript">
    Swal.fire({
        title:"{{Session::get('title')}}",
        text:"{{Session::get('content')}}",
        icon:'error',
        customClass: {
                confirmButton: "btn btn-danger px-5",
        },
        buttonsStyling: false,
    });
</script>
@endif
