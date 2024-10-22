<?php

namespace App\Models;

use App\Models\Message;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Discussion extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'discussable_id',
        'discussable_type',
        'is_open',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'is_open' => 'boolean',
    ];
    public function scopeOpen()
    {
        return $this->whereIsOpen(true); 
    }
    public function messages():HasMany
    {
        return $this->hasMany(Message::class); 
    }
}
