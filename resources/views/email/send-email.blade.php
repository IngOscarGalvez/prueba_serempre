@component('mail::message')
    # {{ $title }}

    Para final tú registro debes diligenciar el siguiente formulario con los datos solicitados e ingresar la siguiente
    contraseña para validar que eres tú.

    # Token de autenticación:
    - {{ $password }}

    @component('mail::button', ['url' => env('APP_URL') . '/register_user'])
        Confirmar Registro
    @endcomponent

@endcomponent
