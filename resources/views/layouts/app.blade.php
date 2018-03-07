<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('layouts.partials.head')
    @yield('css')
</head>
<body>
    <div id="app">
        @include('layouts.partials.nav')

        <modal-change-password></modal-change-password>
        <main class="py-4">
            @yield('content')
        </main>
        @include('layouts.partials.footer')
    </div>
    @yield('contentwo')

    {{-- Scripts --}}
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('js')
</body>
</html>
