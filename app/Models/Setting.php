<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'app_name',
        'app_logo',
        'phone_number',
        'turkey_phone_number',
        'address',
        'contact_email',
        'facebook_link',
        'youtube_link',
        'instagram_link',
        'linkedin_link',
        'twitter_link',
        'intro_text',
        'intro_text_ar',
        'intro_sliding_words',
        'intro_sliding_words_ar',
        'whatsapp_number',
        'video_section_link',
        'about_text',
        'about_text_ar',
        'vision_text',
        'vision_text_ar',
        'goals_text',
        'goals_text_ar',
        'values_text',
        'values_text_ar',
        'default_lang',
        'show_projects_section',
        'show_testimonials_section',
        'show_blog_section',
        'meta_title',
        'meta_image',
        'favicon',
        'meta_description',
        'meta_keywords'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'intro_sliding_words' => 'array',
        'intro_sliding_words_ar' => 'array',
        'meta_keywords' => 'array',
    ];
    public function appLogo():Attribute
    {
        return Attribute::make(
            get:fn(string $value)=> Request::segment(1) == "admin" ? $value : "storage/".$value
        );
    }
}
