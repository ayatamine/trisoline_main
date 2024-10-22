<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'discussion_id',
        'sender_id',
        'receiver_id',
        'content',
        'attachments',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'discussion_id' => 'integer',
        'sender_id' => 'integer',
        'receiver' => 'integer',
        'attachments' => 'array',
    ];
    public function discussion()
    {
        return $this->belongsTo(Discussion::class); 
    }
}
