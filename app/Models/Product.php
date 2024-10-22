<?php

namespace App\Models;

use App\Models\File;
use App\Models\Order;
use App\Models\Quota;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Livewire\Features\SupportAttributes\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'name',
        'price',
        'description',
        'quantity',
        'thumbnail',
    ];
    protected $appends=['images'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'order_id' => 'integer',
        'price' => 'decimal:2',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
    public function quota(): BelongsTo
    {
        return $this->belongsTo(Quota::class,'quota_id','id');
    }
    public function files() :MorphMany {
        return $this->morphMany(File::class, 'fileable'); 
    }
    public function getImagesAttribute()
    {
               return $this->files()->get()->pluck('file');
    }
}
