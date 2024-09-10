<?php

namespace SalvaTerol\MagicLinkLogin\Controllers;

use Illuminate\Routing\Controller;
use SalvaTerol\MagicLinkLogin\Facades\MagicLinkLogin;

class AuthController extends Controller
{
    public function handleProviderCallback($service)
    {
        $user = MagicLinkLogin::handleProviderCallback($service);

        if (! $user) {
            return redirect()->route('login')->with('error', 'Error al obtener los datos del proveedor de autenticación.');
        }

        auth()->login($user);

        return redirect()->intended(config('magic-link-login.redirect_after_login', '/'));
    }

    public function loginWithToken($token)
    {
        $magicLink = MagicLinkLogin::validateToken($token);

        if (! $magicLink) {
            return redirect()->route('login')->with('error', 'El enlace de acceso no es válido o ha expirado.');
        }

        auth()->login($magicLink->user);
        $magicLink->delete();

        return redirect()->intended(config('magic-link-login.redirect_after_login', '/'));
    }
}
