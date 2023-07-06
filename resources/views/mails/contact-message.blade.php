@component('mail::message')
<h3 style="text-align: left;">Full Name : {!!$message['name'] !!}</h3>
<h3 style="text-align: left;">Email : {!!$message['email']!!}</h3>
<h3 style="text-align: left;">Email : {!!$message['phone']!!}</h3>
<h3 style="text-align: left;">Message : {!!$message['message']!!}</h5>
@endcomponent
