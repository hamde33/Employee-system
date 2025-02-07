<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('messages.dashboard') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            direction: {{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }};
            text-align: {{ app()->getLocale() === 'ar' ? 'right' : 'left' }};
        }
    </style>
    @livewireStyles
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">{{ __('messages.system_name') }}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        {{ __('messages.language') }}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="languageDropdown">
                        <li><a class="dropdown-item" href="{{ url('lang/ar') }}">العربية</a></li>
                        <li><a class="dropdown-item" href="{{ url('lang/en') }}">English</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="container py-4">
    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@livewireScripts
</body>
</html>
