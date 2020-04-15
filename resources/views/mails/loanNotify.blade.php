@component('mail::message')
# ¡Hola {{ $data['name'] }}!

Te escribimos desde nuestra tienda ya que eres uno de nuestros <b>Clientes VIP</b> que goza de crédito para consumo, para recordarte que aún posees una deuda con nosotros de: <span style="color: red;"><b>${{ number_format($data['amount'], 2) }}</b></span>

@component('mail::button', ['url' => "mailto:" . $data['store_email']])
Responder este mensaje
@endcomponent

Te invitamos a nuestra tienda para ponerte al día y conozcas todos los nuevos productos que tenemos para ti. ¡Visitanos!

Un saludo,<br>
El equipo de {{ $data['store_name'] }}
@endcomponent