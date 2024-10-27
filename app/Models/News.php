<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class News extends Model
{
    use HasFactory;

    public function pages() {
        return NewsPage::where('news_id', '=', $this->id)->get();
    }

    public function comments() : HasMany {
        return $this->hasMany(Comment::class);
    }

    public function commentCount() {
        return Comment::where('news_id', '=', $this->id)->count();
    }

    public function likeCount() {
        return Vote::where('news_id', '=', $this->id)->where('is_like', '=', true)->count();
    }

    public function dislikeCount() {
        return Vote::where('news_id', '=', $this->id)->where('is_like', '=', false)->count();
    }

    public function reportCount() {
        return Report::where('reported_news_id', '=', $this->id)->count();
    }

    public function userVote() {
        return Vote::where('news_id', '=', $this->id)->where('user_id', '=', Auth::id())->first();
    }

    public function isLiked() {
        $vote = Vote::where('news_id', '=', $this->id)->where('user_id', '=', Auth::id())->first();
        
        return ($vote != null && $vote->is_like == true);
    }

    public function isDisliked() {
        $vote = Vote::where('news_id', '=', $this->id)->where('user_id', '=', Auth::id())->first();
        
        return ($vote != null && $vote->is_like == false);
    }

    public function isBookmarked() {
        return Bookmark::where('user_id', '=', Auth::id())
        ->where('news_id', '=', $this->id)
        ->first() != null;
    }
}
