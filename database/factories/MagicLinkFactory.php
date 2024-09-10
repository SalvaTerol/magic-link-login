<?php

namespace SalvaTerol\MagicLinkLogin\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use SalvaTerol\MagicLinkLogin\Models\MagicLink;

class MagicLinkFactory extends Factory
{
    protected $model = MagicLink::class;

    public function definition()
    {
        return [
            'user_id' => 1,
            'token' => $this->faker->uuid,
            'expires_at' => now()->addMinutes(15),
        ];
    }
}
