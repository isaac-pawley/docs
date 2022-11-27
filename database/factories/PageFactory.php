<?php

namespace Database\Factories;

use App\Models\Page;
use DavidBadura\FakerMarkdownGenerator\FakerProvider;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Page>
 */
class PageFactory extends Factory
{
    public function definition()
    : array
    {
        $this->faker->addProvider(new FakerProvider($this->faker));
        return [
            'name' => $this->faker->name(),
            'markdown' => $this->faker->markdown(),
        ];
    }
}
