@extends('template.default.layout.dashboard')

@section('dashboard')

@include('template.default.dashboard.partial.flash')

@include('template.default.dashboard.partial.sidebar')

<!-- Start Content Wrapper -->
<div id="page-content-wrapper">

    @include('template.default.dashboard.partial.header')

    <!-- Start App/Module -->
    @yield('main-home')
    @foreach ($module as $item)
    @yield($item)
    @endforeach
    <!-- End App/Module -->

    @include('template.default.dashboard.partial.footer')

</div>
<!-- End Content Wrapper -->
@endsection
