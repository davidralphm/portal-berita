<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Report extends Model
{
    use HasFactory;

    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function reportedUser() : HasOne {
        return $this->hasOne(User::class, 'id', 'reported_user_id');
    }

    public function reportedNews() : HasOne {
        return $this->hasOne(News::class, 'id', 'reported_news_id');
    }

    public function reportedComment() : HasOne {
        return $this->hasOne(Comment::class, 'id', 'reported_comment_id');
    }
}
