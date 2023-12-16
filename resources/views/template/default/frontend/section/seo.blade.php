{{-- Canonical --}}
@if (isset($canonical) && $canonical != null)
@foreach ($canonical as $item)
<link rel="canonical" href="{{$item['url']}}" />
@endforeach
@endif

{{-- Meta Tag --}}
@foreach ($meta as $item)
<meta name="description" content="{{$item['description']}}">
<meta name="robots" content="{{$item['robot']}}">
@endforeach

@foreach ($opengraph as $item)
{{-- OpenGraph --}}
<meta property="og:title" content="{{$item['title']}}">
<meta property="og:description" content="{{$item['description']}}">
<meta property="og:image" content="{{url('') . Storage::url($item['image'])}}">
<meta property="og:url" content="{{$item['url']}}">
<meta property="og:type" content="{{$item['type']}}">
<meta property="og:site_name" content="{{$item['site_name']}}">
@endforeach
