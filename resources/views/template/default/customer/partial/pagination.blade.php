@if ($paginator->hasPages())

{{-- Pagination Elements --}}
@foreach ($elements as $element)

{{-- "Three Dots" Separator --}}
@if (is_string($element))
{{ $element }}
@endif

{{-- Array Of Links --}}
@if (is_array($element))
@foreach ($element as $page => $url)
@if ($page == $paginator->currentPage())
{{ $page }}
@else
<a href="{{ $url }}">{{ $page }}</a>
@endif
@endforeach
@endif
@endforeach


@endif
