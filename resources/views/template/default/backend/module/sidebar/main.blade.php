<!-- Start Main Menu -->
@can('main-sidebar')
<li class="active py-2 shadow-sm">
    <a href="{{route('dashboard.main')}}" class="btn-ripple">
        <div class="d-flex align-items-center main-list text-white">
            <span class="font-md"><i class="fa-solid fa-house me-3"></i>{{$dashboard}}</span>
        </div>
    </a>
</li>
@endcan
<!-- End Main Menu -->
