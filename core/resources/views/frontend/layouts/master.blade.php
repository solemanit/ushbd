<!doctype html>
<html lang="en" class="light-theme">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('img/favicon/favicon.svg') }}" type="image/svg+xml">
    <link rel="shortcut icon" href="{{ asset('img/favicon/favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/favicon/apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('img/favicon/site.webmanifest') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">

    <!-- External CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.13.1/font/bootstrap-icons.min.css"
        rel="stylesheet"
        integrity="sha512-t7Few9xlddEmgd3oKZQahkNI4dS6l80+eGEzFQiqtyVYdvcSG2D3Iub77R20BdotfRPA9caaRkg1tyaJiPmO0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Static frontend CSS (from staticFiles.frontend) -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/bootstrap.min.css') }}">

    <!-- Your own frontend CSS (buildInputs.frontend) via Vite -->
    @vite(['resources/assets/frontend/css/style.css', 'resources/assets/frontend/css/dark-theme.css', 'resources/assets/frontend/css/icons.css', 'resources/assets/frontend/plugins/slick/slick.css', 'resources/assets/frontend/plugins/slick/slick-theme.css'])

    <title>@yield('meta_title', 'Website')</title>
    @stack('styles')
</head>

<body>
    @include('frontend.layouts.partials.header')

    @yield('content')

    @include('frontend.layouts.partials.footer')

    <!-- Static frontend JS (from staticFiles.frontend) -->
    <script src="{{ asset('assets/frontend/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/plugins/slick/slick.min.js') }}"></script>

    <!-- Your own frontend JS (buildInputs.frontend) via Vite -->
    @vite(['resources/assets/frontend/js/main.js', 'resources/assets/frontend/js/index.js', 'resources/assets/frontend/js/loader.js'])
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        const API_BASE = '{{ rtrim(env("APP_URL"), "/") }}/api';

        const divisionSelect = document.getElementById('division_id');
        const districtSelect = document.getElementById('district_id');
        const searchBtn = document.getElementById('searchBtn');

        // Load Divisions
        axios.get(`${API_BASE}/divisions`)
            .then(res => {
                divisionSelect.innerHTML = `<option value="">Select</option>`;
                res.data.data.forEach(d => {
                    divisionSelect.innerHTML += `<option value="${d.id}">${d.name}</option>`;
                });
                divisionSelect.disabled = false;
            })
            .catch(err => {
                divisionSelect.innerHTML = `<option value="">Failed to load divisions</option>`;
                console.error(err);
            });

        // Load Districts on Division change
        divisionSelect.addEventListener('change', function() {
            districtSelect.innerHTML = `<option value="">Loading...</option>`;
            districtSelect.disabled = true;

            if (!this.value) {
                districtSelect.innerHTML = `<option value="">Select District</option>`;
                return;
            }

            axios.get(`${API_BASE}/districts/${this.value}`)
                .then(res => {
                    districtSelect.innerHTML = `<option value="">Select District</option>`;
                    res.data.data.forEach(d => {
                        districtSelect.innerHTML += `<option value="${d.id}">${d.name}</option>`;
                    });
                    districtSelect.disabled = false;
                })
                .catch(err => {
                    districtSelect.innerHTML = `<option value="">Failed to load districts</option>`;
                    console.error(err);
                });
        });

        // Search Products
        searchBtn.addEventListener('click', function() {
            axios.get("{{ route('cards.filter') }}", {
                    params: {
                        category_id: document.getElementById('category_id').value,
                        division_id: divisionSelect.value,
                        district_id: districtSelect.value
                    }
                })
                .then(res => {
                    document.getElementById('productList').innerHTML = res.data;
                })
                .catch(err => {
                    console.error('Filter Error:', err);
                    alert('Filter failed. Check console for details.');
                });
        });
    </script>
    @stack('scripts')
</body>

</html>
