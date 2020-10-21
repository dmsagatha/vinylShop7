<!doctype html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    <title>@yield('title', 'The Vinyl Shop')</title>
    {{-- @include('shared.icons') --}}

    @yield('css_after')
  </head>
  <body>
    @include('shared.navigation')

    <main class="container mt-3">
      @yield('main', 'Página en construcción...')
    </main>

    @include('shared.footer')

    <script src="{{ mix('js/app.js') }}"></script>

    @yield('script_after')

    @if(env('APP_DEBUG'))
      <script>
        $('form').attr('novalidate', 'true');
      </script>
    @endif
  </body>
</html>