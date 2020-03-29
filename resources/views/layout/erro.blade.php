<!DOCTYPE html>
<html lang="pt-br">
<head>
    @yield('before_css')
    @include('layout.styles')
    @yield('after_css')
</head>

<body>
<div id="app">
    @yield('content')
</div>

@yield('before_scripts')
@include('layout.scripts')
@yield('after_scripts')

</body>
</html>
