<?php

namespace SalvaTerol\MagicLinkLogin\Http\Livewire;

use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Livewire\Component;
use SalvaTerol\MagicLinkLogin\Facades\MagicLinkLogin;

class Login extends Component implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    public function magicLinkModalAction(): Action
    {
        return Action::make('magicLinkModal')->label('Acceder con el mail')->icon('heroicon-o-envelope')->extraAttributes(['class' => 'w-full'])
            ->form([
                Section::make()->schema([
                    TextInput::make('email')
                        ->required()->email()->label('Email'),
                ])->label('Send Magic Link'),
            ])->action(function (array $data) {
                $magicLinkLogin = MagicLinkLogin::generateMagicLink($data['email']);
                if ($magicLinkLogin) {
                    Notification::make()->title('Magic Link enviado')->color('success')->seconds(5)
                        ->body('Revisa tu correo electrónico para acceder a tu cuenta.')->send();
                } else {
                    Notification::make()->title('Error al enviar el enlace mágico')->color('error')->seconds(5)
                        ->body('Ha ocurrido un error, vuelva a intentarlo más tarde.')->send();

                }
            });
    }

    public function authGithubAction(): Action
    {
        return Action::make('authGithub')->label('Acceder con Github')->icon('github')
            ->extraAttributes(['class' => 'w-full'])
            ->action(function () {
                return redirect()->route('login.redirect', 'github');
            });
    }

    public function authTwitterAction(): Action
    {
        return Action::make('authTwitter')->label('Acceder con Twitter')->icon('twitter')
            ->extraAttributes(['class' => 'w-full'])
            ->action(function () {
                return redirect()->route('login.redirect', 'twitter');
            });
    }

    public function render()
    {
        return view('magic-link-login::livewire.login');
    }
}
