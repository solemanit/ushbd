<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>@yield('title', 'Admin | UpSkill Academia')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Favicons --}}
    <link rel="icon" href="{{ asset('img/favicon/favicon.svg') }}" type="image/svg+xml">
    <link rel="shortcut icon" href="{{ asset('img/favicon/favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/favicon/apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('img/favicon/site.webmanifest') }}">

    {{-- Static Vendor CSS (third-party, not processed by Vite) --}}
    <link rel="stylesheet" href="{{ asset('assets/backend/css/tom-select.bootstrap5.min.css') }}">

    {{-- Rich Text Editor CSS (third-party) --}}
    <link rel="stylesheet" href="{{ asset('richtexteditor/rte_theme_default.css') }}">

    {{-- Vite Processed CSS (your custom styles) --}}
    @vite([
        'resources/assets/backend/css/theme.css',
        'resources/assets/backend/css/jquery-ui.css',
        'resources/assets/backend/css/back-style.css',
        'resources/assets/backend/css/back-vendors.css'
    ])
    <!-- Axios CDN -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    {{-- Page Specific Styles --}}
    @stack('styles')
</head>

<body>
    {{-- Authenticated User Layout --}}
    @if (Auth::check())
        @include('admin.layouts.partials.header')
    @endif

    {{-- Main Content --}}
    @yield('content')

    {{-- Footer (only for authenticated users) --}}
    @if (Auth::check())
        @include('admin.layouts.partials.footer')
    @endif

    {{-- Static Vendor JS (must load before Vite processed files) --}}
    <script src="{{ asset('assets/backend/js/jquery-min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/tom-select.complete.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/list.min.js') }}"></script>

    {{-- Rich Text Editor JS (third-party) --}}
    <script src="{{ asset('richtexteditor/rte.js') }}"></script>
    <script src="{{ asset('richtexteditor/plugins/all_plugins.js') }}"></script>

    {{-- Vite Processed JS (your custom scripts with automatic chunk loading) --}}
    @vite([
        'resources/assets/backend/js/main.js',
        'resources/assets/backend/js/dashboard.js'
    ])

    {{-- Global JavaScript Variables & Initialization --}}
    <script>
        // Set panel prefix for routing
        window.panelPrefix = "{{ request()->is('admin/*') ? 'admin' : (request()->is('instructor/*') ? 'instructor' : '') }}";

        // Initialize Rich Text Editor
        document.addEventListener('DOMContentLoaded', function() {
            // Check if editor element exists
            const editorElement = document.getElementById('editor');
            if (editorElement) {
                var editor1 = new RichTextEditor("#editor");
            }

            // Additional global initializations can go here
            console.log('Backend layout initialized');
        });
    </script>
    {{-- Page Specific Scripts --}}
    @stack('scripts')
</body>

</html>
