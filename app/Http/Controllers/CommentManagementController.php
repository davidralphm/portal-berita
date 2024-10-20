<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\News;
use App\Utilities;
use Illuminate\Http\Request;

class CommentManagementController extends Controller
{
    // Show list of comments for a news item

    public function indexNews(Request $request, String $newsId)
    {
        $this->authorize('isAdmin');

        $news = News::findOrFail($newsId);

        $comments = Comment::where('news_id', '=', $newsId)->where('comment_id', '=', 0);

        $comments = Utilities::sortedSearchLike(
            'body', $request->search,
            ['id', 'created_at'],
            $request->sort, $request->sortOrder, 'id',
            $comments, false
        );

        $paginationURLs = Utilities::createPaginationURLs($request, $comments);

        return view(
            'commentManagement.indexNews',
            [
                'news' => $news,
                'comments' => $comments,
                'prevPageUrl' => $paginationURLs['prevPageUrl'],
                'nextPageUrl' => $paginationURLs['nextPageUrl'],
            ]
        );
    }

    public function indexReplies(Request $request, String $commentId)
    {
        $this->authorize('isAdmin');

        $comment = Comment::findOrFail($commentId);

        $replies = Comment::where('comment_id', '=', $comment->id);

        $replies = Utilities::sortedSearchLike(
            'body', $request->search,
            ['id', 'created_at'],
            $request->sort, $request->sortOrder, 'id',
            $replies, false
        );

        $paginationURLs = Utilities::createPaginationURLs($request, $replies);

        return view(
            'commentManagement.indexReplies',
            [
                'comment' => $comment,
                'replies' => $replies,
                'prevPageUrl' => $paginationURLs['prevPageUrl'],
                'nextPageUrl' => $paginationURLs['nextPageUrl'],
            ]
        );
    }

    // Function to delete a comment

    public function delete(String $commentId) {
        $this->authorize('isAdmin');

        $comment = Comment::findOrFail($commentId);

        $comment->body = 'This comment was deleted';
        $comment->save();

        return Redirect("/commentManagement/news/$commentId")->with('success', 'Comment deleted');
    }

    // Show a comment

    public function show(String $commentId)
    {
        $this->authorize('isAdmin');

        $comment = Comment::findOrFail($commentId);

        return view('commentManagement.show', ['comment' => $comment]);
    }
}
