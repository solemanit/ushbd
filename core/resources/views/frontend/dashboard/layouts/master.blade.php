<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin | UpSkill Academia')</title>

    {{-- Favicon & App Icons --}}
    <link rel="icon" href="{{ asset('img/favicon/favicon.svg') }}" type="image/svg+xml">
    <link rel="shortcut icon" href="{{ asset('img/favicon/favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/favicon/apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('img/favicon/site.webmanifest') }}">

    {{-- Styles --}}
    <link rel="stylesheet" href="{{ asset('assets/frontend/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/theme-app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/icons.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
</head>

<body>
    @include('frontend.dashboard.layouts.partials.header')

    @yield('content')

    @include('frontend.dashboard.layouts.partials.footer')

    {{-- Scripts --}}
    <script src="{{ asset('assets/frontend/style-app.js') }}"></script>
    <script src="{{ asset('assets/frontend/js-app.js') }}"></script>
    <script src="{{ asset('assets/frontend/theme-main.js') }}"></script>
    <script src="{{ asset('assets/frontend/handle.js') }}"></script>
    {{-- AJAX Script for Mark Complete --}}
@stack('scripts')

    {{-- <script src="{{ asset('assets/frontend/course-learn.js') }}"></script> --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const startBtn = document.getElementById('startExamBtn');
    const confirmBtn = document.getElementById('confirmStartExam');

    if (!startBtn) {
        console.warn('startExamBtn not found on page');
        return;
    }

    // Show modal when user clicks "Start Exam"
    startBtn.addEventListener('click', function () {
        const modal = new bootstrap.Modal(document.getElementById('instructionsModal'));
        modal.show();
    });

    // When user confirms in modal, open exam popup
    confirmBtn.addEventListener('click', function () {
        const modalEl = document.getElementById('instructionsModal');
        const modal = bootstrap.Modal.getInstance(modalEl);
        modal.hide();

        const url = startBtn.dataset.url;

        const features = [
            'toolbar=no','location=no','status=no','menubar=no','scrollbars=no','resizable=no',
            'width=' + screen.availWidth,
            'height=' + screen.availHeight
        ].join(',');

        const win = window.open(url, 'ExamWindow', features);
        if (!win) {
            alert('⚠️ Popup blocked. Please allow pop-ups for this site to start the exam.');
            return;
        }
        try { win.focus(); } catch (e) { /* ignore */ }
    });
});
</script>

</body>
</html>
