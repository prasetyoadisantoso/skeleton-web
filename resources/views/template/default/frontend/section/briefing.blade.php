<div class="page page_1" id="page_1">
    <div class="home-1">
        <div class="row" id="home-row">

            <!-- Description -->
            <div class="col-md-6">
                <div class="container mb-5 descriptions">
                    <div class="description text-dark rounded text-center text-md-start">
                        <h1>{{__('home.home.title_1')}}</h1>
                        <h1>{{__('home.home.title_2')}}</h1>
                        <h1>{{__('home.home.title_3')}}</h1>
                        <h1><i class="fa-brands fa-laravel me-3" style="color: #F9322C;"></i>&<i
                                class="ms-3 fa-brands fa-bootstrap" style="color: #6610F2;"></i></h1>
                    </div>
                </div>
                <div class="social container mt-5">
                    <div class="d-flex justify-content-start">
                        <a href="{{$social_media[0]['url']}}" class="me-4">
                            <i class="fa-brands fa-instagram me-3" style="font-size: 40px; color: #6C757D;"></i>
                        </a>
                        <a href="{{$social_media[1]['url']}}" class="me-4">
                            <i class="fa-brands fa-gitlab me-3" style="font-size: 40px; color: #6C757D;"></i>
                        </a>
                        <a href="{{$social_media[2]['url']}}" class="me-4">
                            <i class="fa-brands fa-github me-3" style="font-size: 40px; color: #6C757D;"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Animation -->
            <div class="col-md-6">
                <div class="container animation">
                    <div class="container">
                        <img src="{{asset('template/default/assets/img/macbook.png')}}" alt="" class="macbook">
                    </div>
                    <canvas id="demoCanvas" width="500" height="500"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
