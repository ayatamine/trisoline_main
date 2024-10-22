<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Testimonial;

class TestimonialFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Testimonial::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'content' => $this->faker->paragraphs(3, true),
            'client_name' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'client_thumbnail' => $this->faker->word(),
            'client_country' => $this->faker->regexify('[A-Za-z0-9]{255}'),
        ];
    }
}
