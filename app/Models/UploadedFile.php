<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UploadedFile extends Model
{
    use HasFactory;

    public function user() : BelongsTo {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

    public function news() : BelongsTo {
        return $this->belongsTo(News::class, 'id', 'news_id');
    }
}
