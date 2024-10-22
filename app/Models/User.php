<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Client;
use Laravel\Sanctum\HasApiTokens;
use Firefly\FilamentBlog\Traits\HasBlog;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use SolutionForest\FilamentAccessManagement\Concerns\FilamentUserHelpers;

class User extends Authenticatable
{
    
    use FilamentUserHelpers;
    use HasApiTokens, HasFactory, Notifiable;
    use HasBlog;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function canComment(): bool
    {
        // your conditional logic here
        return true;
    }
    public function client(): HasOne     
    {
        return $this->hasOne(Client::class);
    }
}
