<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Service;

class ServiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Service::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'title_ar' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'description' => $this->faker->text(),
            'description_ar' => $this->faker->text(),
            'image' => $this->faker->word(),
        ];
    }
}
