<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Complaint extends Model
{
    use HasFactory, SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'reason',
        'content',
        'status',
        'resolution_summary',
        'resolved_by',
        'user_id', 
        'documents', 
        'assigned_to', 
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'order_id' => 'integer',
        'resolved_by' => 'integer',
        'user_id' => 'integer',
        'assigned_to' => 'integer',
    ];
    // protected $appends=['documents'];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function resolvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    // public function documents(): Attribute
    // {
    //     return Attribute::make(
    //         get: function ($value) {
    //             return         File::where('fileable_type' , Complaint::class)->where('type', 'document')->where('fileable_id' , $this->id)->pluck('file')->toArray();
    //         }
    //     );
    // }
}
