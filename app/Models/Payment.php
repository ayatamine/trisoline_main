<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id',
        'order_id',
        'transfered_at',
        'arrived_at',
        'amount',
        'bank_name',
        'account_number',
        'swift_code',
        'beneficiary_name',
        'beneficiary_address',
        'documents',
        'status',
        'approved_by',
        'approved_at',
        'received_at',
        'bank_account_type',
        'note',
        'type',
        'payment_reason',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'amount' => 'double',
        'transfered_at' => 'datetime',
        'arrived_date' => 'datetime',
        'approved_at' => 'datetime',
        'received_at' => 'datetime',
        'documents' => 'array',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'approved_by','id');
    }
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
    }
