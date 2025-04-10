@extends('template.default.backend.layout.dashboard')

@section('dashboard')

@include('template.default.backend.partial.alert')

@include('template.default.backend.partial.sidebar')

<!-- Start Content Wrapper -->
<div id="page-content-wrapper">

    @include('template.default.backend.partial.header')

    <!-- Start App/Module -->
    @foreach ($module as $item)
    @yield($item)
    @endforeach
    <!-- End App/Module -->

    @include('template.default.backend.partial.footer')

</div>
<!-- End Content Wrapper -->
@endsection
