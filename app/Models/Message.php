<?php

namespace App\Models;

use App\Support\Enum\MessageStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;

class Message extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = $model->uuid ?? Str::uuid()->toString();
        });
    }

    protected $fillable = [
        'content',
        'status',
        'user_id',
    ];


    protected $casts = [
        'status' => MessageStatus::class,
    ];


    // Relationships
    public function user()  
    {
        return $this->belongsTo(User::class);  
    }
}
