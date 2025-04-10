@extends('template.default.frontend.layout.main')

@section('home')


<!-- Main Page -->
<div class="container">

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

@endsection
