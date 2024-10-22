<?php

namespace App\Models;

use App\Models\Quota;
use App\Models\ShippingAddress;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'total_spent',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
    ];
    
    protected $hidden = ['created_at','updated_at' ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function totalSpent():Attribute
    {
        return Attribute::make(
            get: function ($value) {
             
                return $value ." $";
            }
        );
    }
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class,'client_id','id');
    }
    public function quotations(): HasMany
    {
        return $this->hasMany(Quota::class,'client_id','id');
    }
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class,'client_id','id');
    }


    public function shippingAddresses(): HasMany
    {
        return $this->hasMany(ShippingAddress::class);
    }
}
