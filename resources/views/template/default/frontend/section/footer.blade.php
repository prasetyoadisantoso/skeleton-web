@if (isset($type) && $type == "home")
<!-- Copyright -->
<div class="text-center p-3 text-dark fixed-bottom">
    {{$footer_translation['copyright']}} © 2023 - Skeleton Web
</div>
<!-- Copyright -->
@else
<!-- Copyright -->
<div class="text-center p-3 text-dark">
    {{$footer_translation['copyright']}} © 2023 - Skeleton Web
</div>
<!-- Copyright -->
@endif
