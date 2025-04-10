@component('mail::message')
<h1 style="text-align: center;">{!!$title!!}</h1>
<h5 style="text-align: center;">{!!$messages!!}</h5>
<a href="{{route('verify', $token)}}" style="background-color: #008CBA;
border: none;
color: white;
padding: 15px 32px;
text-align: center;
text-decoration: none;
display: block;
margin-left: auto;
margin-right: auto;
font-size: 16px;
margin: 4px 2px;
cursor: pointer;">{!!$button!!}</a>
<a href="{{route('verify', $token)}}"
    style="display: block; text-align: center; margin: 2em 0;">{!!$additional['second']!!}</a>
<small style="display: block; text-align: center; margin: 2em 0">{!!$additional['first']!!}</small>
@endcomponent
