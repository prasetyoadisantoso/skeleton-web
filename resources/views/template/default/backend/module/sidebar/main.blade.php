<!-- Start Main Menu -->
<hr style="border-bottom: 0.1vh solid gray; width: 100%;" class="my-0">

@can('main-sidebar')
<li class="active py-1">
    <a href="{{route('dashboard.main')}}" class="btn-ripple">
        <div class="d-flex align-items-center main-list">
            <span class="font-md"><i class="fa-solid fa-house me-3"></i>{{$dashboard}}</span>
        </div>
    </a>
</li>
@endcan
<!-- End Main Menu -->
