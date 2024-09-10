<?php

namespace SalvaTerol\MagicLinkLogin\Models;

use Illuminate\Database\Eloquent\Model;

class UserProvider extends Model
{
    protected $fillable = ['user_id', 'provider', 'provider_id', 'provider_nickname'];

    public function user()
    {
        return $this->belongsTo(config('magic-link-login.user_model', \App\Models\User::class));
    }
}
