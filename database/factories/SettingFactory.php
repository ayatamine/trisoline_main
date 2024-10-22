<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Setting;

class SettingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Setting::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'app_name' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'app_logo' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'phone_number' => $this->faker->phoneNumber(),
            'address' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'contact_email' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'facebook_link' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'youtube_link' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'instagram_link' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'linkedin_link' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'twitter_link' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'services_section_subtitle' => $this->faker->text(),
            'contact_section_subtitle' => $this->faker->text(),
            'whatsapp_number' => $this->faker->word(),
            'video_section_link' => $this->faker->word(),
            'about_text' => $this->faker->text(),
            'about_text_ar' => $this->faker->text(),
            'vision_text' => $this->faker->text(),
            'vision_text_ar' => $this->faker->text(),
            'goals_text' => $this->faker->text(),
            'goals_text_ar' => $this->faker->text(),
            'values_text' => $this->faker->text(),
            'values_text_ar' => $this->faker->text(),
            'default_lang' => $this->faker->word(),
        ];
    }
}
