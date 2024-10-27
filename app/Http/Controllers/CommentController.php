<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\News;
use App\Models\Vote;
use App\Utilities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // Return replies page for a comment

    public function commentReplies(Request $request, String $id) {
        $comment = Comment::findOrFail($id);
        $news = News::findOrFail($comment->news_id);

        $replies = Comment::where('comment_id', '=', $id)
        ->join('users', 'users.id', '=', 'comments.user_id')
        ->paginate(
            $perPage = 20,
            $columns = [
                'comments.id',
                'comments.body',
                'comments.user_id',
                'comments.created_at',
                'users.name',
            ]
        );

        $paginationURLs = Utilities::createPaginationURLs($request, $replies);

        return view(
            'news.replies',
            [
                'news' => $news,
                'comment' => $comment,
                'replies' => $replies,
                'prevPageUrl' => $paginationURLs['prevPageUrl'],
                'nextPageUrl' => $paginationURLs['nextPageUrl'],
            ]
        );
    }

    // Function to post a comment on a news item

    public function storeNews(Request $request, String $id) {
        $request->validate(
            ['body' => 'required|string'],
            
            [
                'body.required' => 'Comment cannot be empty!',
                'body.string' => 'Comment must be a string!'
            ]
        );

        $news = News::findOrFail($id);

        $comment = new Comment();

        $comment->created_at = now();
        $comment->user_id = Auth::user()->id;
        $comment->news_id = $news->id;
        $comment->body = $request->body;

        $comment->save();

        return Redirect()->back()->with('success', 'Comment posted!');
        // return Redirect("/{$news->slug}")->with('success', 'Comment posted!');
    }

    public function storeReply(Request $request, String $id) {
        $request->validate(
            ['body' => 'required|string'],
            
            [
                'body.required' => 'Reply cannot be empty!',
                'body.string' => 'Reply must be a string!'
            ]
        );

        $comment = Comment::findOrFail($id);

        $reply = new Comment();

        $reply->created_at = now();
        $reply->user_id = Auth::user()->id;
        $reply->news_id = $comment->news_id;
        $reply->comment_id = $comment->id;
        $reply->body = $request->body;

        $reply->save();

        return Redirect("/comment/$id/replies")->with('success', 'Reply posted!');
        // return Redirect()->back()->with('success', 'Reply posted!');
        // return Redirect("/{$reply->news->slug}")->with('success', 'Comment posted!');
    }

    // Function to return the page for editing a comment

    public function edit(String $commentId) {
        $comment = Comment::findOrFail($commentId);

        $this->authorize('isOwner', $comment);

        return view('comment.edit', ['comment' => $comment]);
    }

    // Function to update a comment

    public function update(Request $request, String $id) {
        $request->validate(
            ['body' => 'required|string'],
            
            [
                'body.required' => 'Comment cannot be empty!',
                'body.string' => 'Comment must be a string!'
            ]
        );

        $comment = Comment::findOrFail($id);

        $this->authorize('isOwner', $comment);

        $comment->updated_at = now();
        $comment->body = $request->body;
        $comment->save();

        return Redirect("/comment/$id")->with('success', 'Comment updated!');
    }

    // Function to delete a comment

    public function delete(String $id) {
        $comment = Comment::findOrFail($id);

        $this->authorize('isOwner', $comment);
        
        $news = $comment->news;

        $comment->delete();

        return Redirect()->back()->with('success', 'Comment deleted!');
        // return Redirect("/$news->slug")->with('success', 'Comment deleted!');
    }

    // Function to like a comment

    public function like(String $id) {
        $comment = Comment::findOrFail($id);

        $vote = Vote::where('user_id', '=', Auth::id())
        ->where('comment_id', '=', $id)
        ->first();

        if ($vote == null) {
            $vote = new Vote();

            $vote->user_id = Auth::id();
            $vote->news_id = 0;
            $vote->comment_id = $id;
        }

        $vote->is_like = true;

        $vote->save();

        return Redirect()->back();
    }

    // Function to dislike a comment

    public function dislike(String $id) {
        $comment = Comment::findOrFail($id);

        $vote = Vote::where('user_id', '=', Auth::id())
        ->where('comment_id', '=', $id)
        ->first();

        if ($vote == null) {
            $vote = new Vote();

            $vote->user_id = Auth::id();
            $vote->news_id = 0;
            $vote->comment_id = $id;
        }

        $vote->is_like = false;

        $vote->save();

        return Redirect()->back();
    }

    // Function to remove a vote from a comment

    public function removeVote($id) {
        $comment = Comment::findOrFail($id);

        $vote = Vote::where('user_id', '=', Auth::id())
        ->where('comment_id', '=', $id)
        ->first();

        if ($vote != null)
            $vote->delete();

        return Redirect()->back();
    }
}