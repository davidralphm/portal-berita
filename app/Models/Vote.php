<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vote extends Model
{
    use HasFactory;

    public function user() : BelongsTo {
        return $this->belongsTo('users', 'user_id');
    }

    public function news() : BelongsTo {
        return $this->belongsTo('news', 'news_id');
    }

    public function comment() : BelongsTo {
        return $this->belongsTo('comments', 'comment_id');
    }
}
