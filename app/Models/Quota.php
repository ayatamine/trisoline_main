<?php

namespace App\Models;

use App\Models\Client;
use App\Models\Product;
use App\Models\Discussion;
use App\Models\QuotaProduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quota extends Model
{
    use HasFactory;
    
 
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'business_name',
        'legal_representative_name',
        'country',
        'full_address',
        'phone_number',
        'email',
        'commercial_register_number',
        'tax_number',
        'available_budget',
        'currency',
        'service_type',
        'products',
        'status',
        'rejection_note',
        'client_id',
        'rejected_at',
        'processing_at',
        'processed_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'client_id' => 'integer',
        'is_customs_clearance_available' => 'bool',
    ];
    public function products(): HasMany
    {
        return $this->hasMany(Product::class,'quota_id','id');
    }
    public function discussion(): HasOne
    {
        return $this->hasOne(Discussion::class,'discussable_id','id');
    }
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

}
