
# Magic Link Login

**Magic Link Login** es un package de autenticación para Laravel que permite a los usuarios iniciar sesión en tu aplicación utilizando enlaces mágicos enviados por correo electrónico o proveedores externos como Google, Facebook, etc.

## Requisitos

- PHP 8.2 o superior
- Laravel 10.x o 11.x

## Instalación

Puedes instalar el package mediante Composer:

```bash
composer require salvaterol/magic-link-login
```

### Publicación de Archivos

Después de instalar el package, debes publicar el archivo de configuración y las migraciones:

```bash
php artisan vendor:publish --provider="SalvaTerol\MagicLinkLogin\MagicLinkLoginServiceProvider" --tag="config"
php artisan vendor:publish --provider="SalvaTerol\MagicLinkLogin\MagicLinkLoginServiceProvider" --tag="migrations"
```

Luego, ejecuta las migraciones:

```bash
php artisan migrate
```

## Configuración

En el archivo de configuración `config/magic-link-login.php`, puedes personalizar varios aspectos del comportamiento de los enlaces mágicos:

```php
return [
    'user_model' => \App\Models\User::class,  // Modelo de usuario
    'token_expiry_minutes' => 15,             // Tiempo de expiración de los enlaces mágicos
    'redirect_after_login' => '/',            // Redirección después del login exitoso
    'max_attempts' => 3,                      // Intentos máximos para usar un token (si es aplicable)
];
```

## Uso

### Generar Enlace Mágico

Para enviar un enlace mágico al correo electrónico de un usuario, puedes hacer lo siguiente:

```php
use SalvaTerol\MagicLinkLogin\Facades\MagicLinkLogin;

MagicLinkLogin::sendMagicLink($user);
```

El enlace mágico será enviado al correo electrónico del usuario y, cuando lo use, podrá iniciar sesión sin necesidad de ingresar una contraseña.

### Autenticación con Proveedores Externos

También puedes permitir que los usuarios se autentiquen mediante proveedores externos como Google o Facebook. Para esto, el package utiliza [Laravel Socialite](https://github.com/laravel/socialite).

Configura los proveedores en tu archivo `.env`:

```dotenv
GOOGLE_CLIENT_ID=your-google-client-id
GOOGLE_CLIENT_SECRET=your-google-client-secret
FACEBOOK_CLIENT_ID=your-facebook-client-id
FACEBOOK_CLIENT_SECRET=your-facebook-client-secret
```

Después de configurar los proveedores, puedes redirigir a los usuarios a la página de autenticación con el siguiente código:

```php
return Socialite::driver('google')->redirect();
```

### Limpieza de Enlaces Mágicos Expirados

Este package incluye un comando para eliminar automáticamente los enlaces mágicos expirados de la base de datos.

#### Ejecutar Manualmente

Puedes ejecutar el comando manualmente con:

```bash
php artisan magic-links:cleanup
```

#### Configuración del Scheduler

Si deseas que este comando se ejecute automáticamente en tu aplicación, puedes añadirlo al **scheduler** de Laravel. Abre el archivo `app/Console/Kernel.php` de tu aplicación Laravel y añade la siguiente línea en el método `schedule`:

```php
protected function schedule(Schedule $schedule)
{
    $schedule->command('magic-links:cleanup')->weekly();
}
```

Esto hará que el comando se ejecute automáticamente una vez a la semana.

## Tests

El package incluye pruebas básicas para garantizar su correcto funcionamiento. Puedes ejecutar las pruebas utilizando:

```bash
vendor/bin/pest
```

## Contribuciones

¡Las contribuciones son bienvenidas! Si encuentras algún problema o tienes sugerencias, siéntete libre de abrir un _issue_ o enviar un _pull request_.

## Licencia

Este package está bajo la licencia MIT. Para más detalles, consulta el archivo `LICENSE.md`.
```
