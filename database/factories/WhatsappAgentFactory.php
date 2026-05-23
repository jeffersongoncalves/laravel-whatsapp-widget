<?php

namespace JeffersonGoncalves\WhatsappWidget\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use JeffersonGoncalves\WhatsappWidget\Models\WhatsappAgent;

class WhatsappAgentFactory extends Factory
{
    protected $model = WhatsappAgent::class;

    public function definition(): array
    {
        return [
            'active' => true,
            'name' => $this->faker->name(),
            'phone' => $this->faker->numerify('+55119########'),
            'text' => $this->faker->sentence(),
            'image' => null,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn () => ['active' => false]);
    }

    public function withImage(string $path = 'agents/image.jpg'): static
    {
        return $this->state(fn () => ['image' => $path]);
    }
}
