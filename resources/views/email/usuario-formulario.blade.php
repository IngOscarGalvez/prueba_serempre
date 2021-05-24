@component('mail::message')
# Estimado Cliente,

Por favor diligencie el siguiente formulario, el cual le permite ingresar los datos para el levantamiento de requerimientos de activos de información que serán objeto de auditoría.


@component('mail::button', ['url' => env('APP_URL').'/form/'.$formulario])
Button Text
@endcomponent


Cordialmente,<br>
@endcomponent
