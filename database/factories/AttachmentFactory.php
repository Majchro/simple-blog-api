<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AttachmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'filename' => fake()->word().'.jpg',
            'content_type' => fake()->mimeType(),
            'byte_size' => fake()->randomNumber(),
            'path' => fake()->word(),
        ];
    }
}
