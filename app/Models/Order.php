<?php

namespace App\Models;

use App\Models\Client;
use App\Models\Payment;
use App\Models\Product;
use App\Models\OrderProduct;
use App\Models\ShippingAddress;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory, SoftDeletes;
    // use Filterable,Sortable;

    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'vendor_id',
        'client_id',
        'status',
        'payment_status',
        'expected_delivery_date',
        'real_delivery_date',
        'shipping_address_id',
        'currency_id',
        'vendor_info',
        'containers',
        'approved_at',
        'inspected_at',
        'completed_at',
        'refuned_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'vendor_id' => 'integer',
        'client_id' => 'integer',
        'expected_delivery_date' => 'date',
        'real_delivery_date' => 'date',
        'shipping_address_id' => 'integer',
        'currency_id' => 'integer',
        'payment_status' => 'boolean',
        'vendor_info' => 'array',
        'containers' => 'array',
    ];
    protected $hidden=['updated_at','deleted_at'];
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function shippingAddress(): BelongsTo
    {
        return $this->belongsTo(ShippingAddress::class,'shipping_address_id','id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }
    public function createdAt():Attribute
    {
        return Attribute::make(
            get: function ($value) {
             
                return date('Y-m-d',strtotime($value));
            }
        );
    }
    public function expectedDeliveryDate():Attribute
    {
        return Attribute::make(
            get: function ($value) {
             
                return date('Y-m-d',strtotime($value));
            }
        );
    }
    public function RealDeliveryDate():Attribute
    {
        return Attribute::make(
            get: function ($value) {
             
                return date('Y-m-d',strtotime($value));
            }
        );
    }
    public function paymentStatus():Attribute
    {
        return Attribute::make(
            get: function ($value) {
             
                return $value == true ? trans("dash.paid") : trans("dash.not_paid");
            }
        );
    }      

    public function products(): HasMany
    {
        return $this->hasMany(Product::class,'order_id','id');
    }
    public function discussion(): HasOne
    {
        return $this->hasOne(Discussion::class,'discussable_id','id');
    }

}
