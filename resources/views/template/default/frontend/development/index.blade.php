<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coming Soon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('template/default/assets/css/style.css') }}">
</head>
<body>
    <div class="coming-soon-page">
        <div class="container">
            <div class="row justify-content-center align-items-center vh-100">
                <div class="col-lg-8 text-center">
                    <h1 class="display-3 fw-bold text-white mb-4">Skeleton Web <br> is Coming Soon!</h1>
                    <p class="lead text-white-50 mb-5">Our CMS is currently under development. Stay tuned for our exciting launch!</p>

                    <div id="countdown" class="countdown mb-5">
                        <div class="countdown-item">
                            <span id="days" class="countdown-number">00</span>
                            <span class="countdown-label">Days</span>
                        </div>
                        <div class="countdown-item">
                            <span id="hours" class="countdown-number">00</span>
                            <span class="countdown-label">Hours</span>
                        </div>
                        <div class="countdown-item">
                            <span id="minutes" class="countdown-number">00</span>
                            <span class="countdown-label">Minutes</span>
                        </div>
                        <div class="countdown-item">
                            <span id="seconds" class="countdown-number">00</span>
                            <span class="countdown-label">Seconds</span>
                        </div>
                    </div>

                    <div class="social-links">
                        <a href="https://github.com/prasetyoadisantoso/prasetyoadisantoso" target="_blank" class="text-white-50 me-3" aria-label="GitHub"><i class="bi bi-github fs-4"></i></a>
                        <a href="https://www.linkedin.com/in/prasetyo-adi-santoso/" target="_blank" class="text-white-50 me-3" aria-label="LinkedIn"><i class="bi bi-linkedin fs-4"></i></a>
                        <a href="https://prasetyoadisantoso.com/" target="_blank" class="text-white-50" aria-label="Website"><i class="bi bi-globe fs-4"></i></a>
                    </div>

                    <hr class="my-5 border-white-50">

                    <p class="text-white-50 small">Copyright &copy; 2025 Skeleton Web</p>
                    <p class="text-white-50 small"><a href="{{ route('login.page') }}" class="text-decoration-underline">Login for testing purpose</a></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('template/default/assets/js/script.js') }}"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
</body>
</html>
