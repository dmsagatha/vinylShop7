@component('mail::message')
# Apreciado(a) {{ Auth::user()->name }},

{!! $request !!}

Gracias,<br>
{{ config('app.name') }}
@endcomponent