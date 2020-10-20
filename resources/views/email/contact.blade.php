@component('mail::message')
# Estimado(a) {{ $request->name }},
Gracias por su mensaje.<br>
Nos pondremos en contacto con usted lo mas pronto posible.

<hr>
<p>
<b>Su nombre:</b> {{ $request->name }}<br>
<b>Su correo electrónico:</b> {{ $request->email }}
</p>
<p>
<b>Su mensaje:</b><br>{!! nl2br($request->message) !!}
</p>
Gracias,<br>
{{ env('APP_NAME') }}
@endcomponent