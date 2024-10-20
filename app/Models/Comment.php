<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Comment extends Model
{
    use HasFactory;

    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function news() : BelongsTo {
        return $this->belongsTo(News::class);
    }

    public function comment() : BelongsTo {
        return $this->belongsTo(Comment::class,' comment_id');
    }

    public function replyCount() {
        return Comment::where('comment_id', '=', $this->id)->count();
    }

    public function likeCount() {
        return Vote::where('comment_id', '=', $this->id)->where('is_like', '=', true)->count();
    }

    public function dislikeCount() {
        return Vote::where('comment_id', '=', $this->id)->where('is_like', '=', false)->count();
    }

    public function reportCount() {
        return Report::where('reported_comment_id', '=', $this->id)->count();
    }

    public function likedByUser() {
        $vote = Vote::where('user_id', '=', Auth::id())->where('comment_id', '=', $this->id)->first();

        return ($vote != null) ? ($vote->is_like == true) : false;
    }

    public function dislikedByUser() {
        $vote = Vote::where('user_id', '=', Auth::id())->where('comment_id', '=', $this->id)->first();

        return ($vote != null) ? ($vote->is_like == false) : false;
    }

    public function isReported() {
        return Report::where('user_id', '=', Auth::id())
        ->where('reported_comment_id', '=', $this->id)
        ->first() != null;
    }
}
