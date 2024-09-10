<?php

namespace SalvaTerol\MagicLinkLogin\Http\Livewire;

use App\Mail\LoginMagicLink;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Livewire\Component;
use SalvaTerol\MagicLinkLogin\Facades\MagicLinkLogin;
use SalvaTerol\MagicLinkLogin\Models\MagicLink;

class Login extends Component implements HasForms, HasActions
{
    use InteractsWithForms;
    use InteractsWithActions;


    public function magicLinkModalAction(): Action
    {
        return Action::make('magicLinkModal')->label('Acceder con el mail')->icon('heroicon-o-envelope')->extraAttributes(['class' => "w-full"])
            ->form([
                Section::make()->schema([
                    TextInput::make('email')
                        ->required()->email()->label('Email'),
                ])->label('Send Magic Link'),
            ])->action(function (array $data) {
                MagicLinkLogin::generateMagicLink($data['email']);
            });
    }

    public function authGithubAction(): Action
    {
        return Action::make('authGithub')->label('Acceder con Github')->icon('github')
            ->extraAttributes(['class' => "w-full"])
            ->action(fn () => Socialite::driver('github')->redirect());
    }

    public function authTwitterAction(): Action
    {
        return Action::make('authTwitter')->label('Acceder con Twitter')->icon('twitter')
            ->extraAttributes(['class' => "w-full"])
            ->action(fn () => redirect()->route('auth.redirect', ['service' => 'twitter']));
    }


    public function render()
    {
        return view('livewire.login');
    }
}
