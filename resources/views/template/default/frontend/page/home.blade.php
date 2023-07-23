@extends('template.default.frontend.layout.main')

@section('home')

<style>
    body {
        height: 100vh;
        overflow: hidden;
    }
</style>


<!-- Main Page -->
<div class="containerize">

    <!-- Briefing Page -->
    @include('template.default.frontend.section.briefing')

    <!-- Feature -->
    @include('template.default.frontend.section.feature')


    <!-- Framework -->
    @include('template.default.frontend.section.advantage')

    <!-- Conclusion -->
    @include('template.default.frontend.section.conclusion')

    <!-- Developer -->
    @include('template.default.frontend.section.developer')
</div>

<!-- Scroll Bar Bottom -->
<div class="scroll"></div>

<!-- Prev & Next -->
<div class="zoom">
    <a class="zoom-fab zoom-btn-large" id="zoomBtn"><i class="fa-solid fa-angles-left"></i></a>
    <ul class="zoom-menu">
        <li id="prev">
            <a class="zoom-fab zoom-btn-sm zoom-btn scale-transition scale-out" id="prev">
                <i class="fa fa-chevron-left text-dark" aria-hidden="true"></i>
            </a>
        </li>
        <li id="next">
            <a class="zoom-fab zoom-btn-sm zoom-btn scale-transition scale-out" id="next">
                <i class="fa fa-chevron-right text-dark" aria-hidden="true"></i>
            </a>
        </li>
    </ul>
</div>

<div class="preloader">
    <img src="{{$site_logo}}" class="rotate" width="100" height="100" />
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        init();
    });
</script>


@endsection
