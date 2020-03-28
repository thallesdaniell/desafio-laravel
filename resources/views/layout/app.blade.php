<!DOCTYPE html>
<html lang="pt-br">
<head>
    @yield('before_css')
    @include('layout.styles')
    @yield('after_css')
</head>

<body>
<div id="app">
    <div class="main-wrapper">
        <div class="navbar-bg"></div>

        @include('layout.header')

        @include('layout.menu')

        @yield('content')

        @include('layout.footer')

    </div>
</div>

@yield('before_scripts')
@include('layout.scripts')
@yield('after_scripts')

</body>
</html>
