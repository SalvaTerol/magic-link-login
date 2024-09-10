<x-mail::message>
    # Inicia sesión en {{ config('app.name') }}

    Has solicitado un enlace de inicio de sesión para tu cuenta en {{ config('app.name') }}. Haz clic en el botón de abajo para iniciar sesión:

    <x-mail::button :url="$loginUrl">
        Iniciar sesión
    </x-mail::button>

    Este enlace es válido por 30 minutos y solo se puede usar una vez.

    Si no solicitaste este enlace, puedes ignorar este correo electrónico de forma segura.

    Gracias,<br>
    {{ config('app.name') }}

    Si tienes problemas para hacer clic en el botón "Iniciar sesión", copia y pega la siguiente URL en tu navegador web: [{{ $loginUrl }}]({{ $loginUrl }})
</x-mail::message>
