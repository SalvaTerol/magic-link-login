<?php

namespace SalvaTerol\MagicLinkLogin;

use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use SalvaTerol\MagicLinkLogin\Models\MagicLink;

class MagicLinkLogin
{
    /**
     * Genera un enlace mágico para el usuario con el correo electrónico proporcionado.
     */
    public function generateMagicLink(string $email): ?string
    {
        $userModel = config(key: 'magic-link-login.user_model', default: \App\Models\User::class);
        $user = $userModel::firstOrCreate(['email' => $email]);
        $token = (string) Str::uuid();

        $magicLink = MagicLink::create([
            'user_id' => $user->id,
            'token' => Hash::make($token),
            'expires_at' => now()->addMinutes(config(key: 'magic-link-login.token_expiry_minutes', default: 30)),
        ]);

        $loginUrl = URL::temporarySignedRoute(
            'login.token',
            now()->addMinutes(config('magic-link-login.token_expiry_minutes', 30)),
            ['token' => $magicLink->token]
        );

        $mailClass = config('magic-link-login.mail_class', \SalvaTerol\MagicLinkLogin\Mail\LoginMagicLink::class);
        Mail::to($user->email)->send(new $mailClass($loginUrl));

        return $loginUrl;

        /*        try {


                } catch (Exception $e) {
                    report($e);
                    throw new Exception('No se pudo generar el enlace mágico. Por favor, intenta nuevamente.');
                }*/
    }

    /**
     * Valida si un token proporcionado es válido.
     */
    public function validateToken(string $token): ?MagicLink
    {
        return MagicLink::where('expires_at', '>', now())
            ->where(function ($query) use ($token) {
                $query->where('token', Hash::check($token, 'token'));
            })
            ->first();
    }

    public function handleProviderCallback(string $service)
    {
        $userData = Socialite::driver($service)->user();

        if (! $userData || ! $userData->email) {
            return false;
        }

        $userModel = config('magic-link-login.user_model', \App\Models\User::class);

        $user = $userModel::whereHas('providers', function ($query) use ($service, $userData) {
            $query->where('provider', $service)
                ->where('provider_id', $userData->id);
        })->first();

        if (! $user) {
            $user = $userModel::firstOrCreate(
                ['email' => $userData->email],
                [
                    'name' => $userData->name ?? null,
                    'avatar' => $userData->avatar ?? null,
                ]
            );

            $user->providers()->create([
                'provider' => $service,
                'provider_id' => $userData->id,
                'provider_nickname' => $userData->nickname ?? null,
            ]);

            event(new Registered($user));
        }

        return $user;
    }

    public function redirectToProvider(string $service)
    {
        return Socialite::driver($service)->redirect();
    }
}
