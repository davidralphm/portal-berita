<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Comment;
use App\Models\News;
use App\Models\Vote;
use App\Utilities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    // Function to show homepage

    public function index() {
        // Most recent news

        $mostRecent = News::orderByDesc('id')->limit(5)->get();

        $news = [
            ['Most recent news', $mostRecent]
        ];

        foreach (array('culinary', 'sports', 'politics', 'economy', 'automotive', 'technology', 'health') as $value) {
            $news[] = [
                'Most recent from ' . $value,
                News::where('category', '=', $value)->orderByDesc('id')->limit(5)->get()
            ];
        }

        return view('home', ['news' => $news]);
    }

    // Search page

    public function search(Request $request) {
        $category = $request->category ?? '';

        $news = News::where('category', 'like', "%$category%");

        $news = Utilities::sortedSearchLike(
            'title', $request->search,
            ['id', 'title', 'author', 'category', 'created_at'],
            $request->sort, $request->sortOrder, 'id',
            $news, false
        );

        $paginationURLs = Utilities::createPaginationURLs($request, $news);

        return view(
            'news.search',
            [
                'news' => $news,
                'prevPageUrl' => $paginationURLs['prevPageUrl'],
                'nextPageUrl' => $paginationURLs['nextPageUrl'],
            ]
        );
    }

    // Function to show a news

    public function get(Request $request, String $slug) {
        $news = News::where('slug', '=', $slug)->firstOrFail();

        $comments = Comment::where('news_id', '=', $news->id)
        ->where('comment_id', '=', 0)
        ->orderByDesc('id')
        ->paginate(20);

        $newsBody = Str::markdown($news->body);
        $newsBody = str_replace(['<', '>', '"'], ['%3c', '%3e', '%22'], $newsBody);

        $userVote = Vote::where('user_id', '=', Auth::id())->where('news_id', '=', $news->id)->first();

        return view(
            'news.show',
            [
                'news' => $news,
                'comments' => $comments,
                'newsBody' => $newsBody,
            ]
        );
    }

    // Function to like a news

    public function like(String $slug) {
        $news = News::where('slug', '=', $slug)->firstOrFail();

        $vote = Vote::where('news_id', '=', $news->id)->where('user_id', '=', Auth::id())->get()->first();

        if ($vote == null) {
            $vote = new Vote();

            $vote->user_id = Auth::id();
            $vote->news_id = intval($news->id);
            $vote->comment_id = 0;
        }

        $vote->is_like = true;

        $vote->save();

        return Redirect("/$slug");
    }

    // Function to dislike a news

    public function dislike(String $slug) {
        $news = News::where('slug', '=', $slug)->firstOrFail();

        $vote = Vote::where('news_id', '=', $news->id)->where('user_id', '=', Auth::id())->get()->first();

        if ($vote == null) {
            $vote = new Vote();

            $vote->user_id = Auth::id();
            $vote->news_id = intval($news->id);
            $vote->comment_id = 0;
        }

        $vote->is_like = false;

        $vote->save();

        return Redirect("/$slug");
    }

    // Function to remove news vote

    public function removeVote(String $slug) {
        $news = News::where('slug', '=', $slug)->firstOrFail();

        $vote = Vote::where('news_id', '=', $news->id)->where('user_id', '=', Auth::id())->get()->first();

        if ($vote != null)
            $vote->delete();

        return Redirect("/$slug");
    }

    // Function to add a news bookmark

    public function addBookmark(String $slug) {
        $news = News::where('slug', '=', $slug)->firstOrFail();

        $bookmark = Bookmark::where('user_id', '=', Auth::id())
        ->where('news_id', '=', $news->id)
        ->first();

        if ($bookmark == null) {
            $bookmark = new Bookmark();

            $bookmark->created_at = now();
            $bookmark->user_id = Auth::id();
            $bookmark->news_id = $news->id;

            $bookmark->save();
        }

        return Redirect()->back()->with('success', 'Bookmark added');
    }

    // Function to remove news bookmark

    public function removeBookmark(String $slug) {
        $news = News::where('slug', '=', $slug)->firstOrFail();

        $bookmark = Bookmark::where('user_id', '=', Auth::id())
        ->where('news_id', '=', $news->id)
        ->first();

        if ($bookmark != null)
            $bookmark->delete();

        return Redirect()->back()->with('success', 'Bookmark removed');
    }

    // Function to show bookmarks page

    public function indexBookmarks(Request $request) {
        $bookmarks = Bookmark::where('bookmarks.user_id', '=', Auth::id())
        ->join('news', 'news.id', '=', 'bookmarks.news_id');

        $bookmarks = Utilities::sortedSearchLike(
            'news.title', $request->search,
            ['news.id', 'news.created_at', 'news.author', 'news.title', 'news.category'],
            $request->sort, $request->sortOrder, 'news.id',
            $bookmarks, false
        );

        $paginationURLs = Utilities::createPaginationURLs($request, $bookmarks);

        return view(
            'news.bookmarks',
            [
                'bookmarks' => $bookmarks,
                'prevPageUrl' => $paginationURLs['prevPageUrl'],
                'nextPageUrl' => $paginationURLs['nextPageUrl'],
            ]
        );
    }
}
