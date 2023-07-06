@extends('template.default.layout.customer')

@section('contact')

@include('template.default.customer.partial.header')

<!-- Main Page -->
<div class="container-fluid">

    <div class="container px-md-5 px-3 pt-5">
        <h1>{{$contact_us['title']}}</h1>
        <h6 style="font-weight: 300">{{$contact_us['description']}}</h6>
    </div>
    <form action="{{route('site.contact.message')}}" method="post">
        @csrf
        <div class="container px-md-5 px-3 py-3 py-md-5">
            <div class="row">
                <div class="col-lg-6">
                    <div class="container">
                        <div class="mb-3">
                            <label for="" class="form-label">{{$form['label']['name']}}</label>
                            <input type="text" class="form-control" name="name" id="" aria-describedby="helpId"
                                placeholder="{{$form['placeholder']['name']}}">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">{{$form['label']['email']}}</label>
                            <input type="email" class="form-control" name="email" id="" aria-describedby="emailHelpId"
                                placeholder="{{$form['placeholder']['email']}}">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">{{$form['label']['phone']}}</label>
                            <input type="text" class="form-control" name="phone" id="" aria-describedby="helpId"
                                placeholder="{{$form['placeholder']['phone']}}">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="container">
                        <div class="mb-3">
                            <label for="" class="form-label">{{$form['label']['message']}}</label>
                            <textarea class="form-control" name="message" id="" rows="6"
                                placeholder="{{$form['placeholder']['message']}}"></textarea>
                        </div>
                    </div>
                    <div class="container">
                        <button type="submit" class="btn btn-success w-100"><i class="fa fa-paper-plane me-3"
                                aria-hidden="true"></i>{{$button['send']}}</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="container px-md-5 px-3">
        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{Session::get('message')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{Session::get('message')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
    </div>
</div>

@include('template.default.customer.partial.footer')
@endsection
