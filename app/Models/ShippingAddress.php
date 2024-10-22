<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShippingAddress extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id',
        'first_name',
        'last_name',
        'phone_number',
        'country',
        'city',
        'zip_code',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'client_id' => 'integer',
        'zip_code' => 'integer',
    ];
    public $appends=['full_address'];
    protected $hidden=['created_at'];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
    public function fullAddress():Attribute
    {
        return Attribute::make(
            get: function ($value) {
             
                return " $this->first_name $this->last_name, $this->phone_number, $this->country  $this->city  $this->zip_code ";
            }
        );
    }
}
