@if (count($errors) > 0)
@foreach ($errors->all() as $error)
{{-- Error Validation Sweetalert --}}
<script>
    Swal.fire({
            title: "{{ $failed }}",
            text:"{{ $error }}",
            icon:'error'
    });
</script>
@endforeach
@endif

@if ($message = Session::get('success'))
{{-- Success Sweetalert --}}
<script>
    Swal.fire({
            title:"{{ $success }}",
            text:"{{Session::get('success')}}",
            icon:'success',
            customClass: {
                popup: "rad-25",
                confirmButton: "btn btn-success px-5 rad-25",
            },
            buttonsStyling: false,
        });
</script>
@endif

@if (Session::has('error'))
{{-- Error Sweetalert --}}
<script type="text/javascript">
    Swal.fire({
        title:"{{ $failed }}",
        text:"{{Session::get('error')}}",
        icon:'error'
    });
</script>
@endif
