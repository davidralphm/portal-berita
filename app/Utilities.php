<?php

namespace App;

use App\Models\Bookmark;
use App\Models\Comment;
use App\Models\News;
use App\Models\Report;
use App\Models\UploadedFile;
use App\Models\Vote;
use ErrorException;
use Illuminate\Http\Request;

class Utilities {
    // For removing repetitions

    public static function sortedSearchEquals(
        $searchField, $searchKeyword,
        $sortFields, $sortField, $sortFieldOrder, $defaultSortField,
        $class, $static = true
    ) {
        $search = $searchKeyword ?? '';

        $sort = $sortField ?? $defaultSortField;
        $sortOrder = $sortFieldOrder ?? 'asc';

        if (!array_search($sort, $sortFields))
            $sort = $defaultSortField;

        if (!array_search($sortOrder, ['asc', 'desc']))
            $sortOrder = 'asc';

        if ($static == true)
            $class = $class::where($searchField, '=', "$search");
        else
            $class = $class->where($searchField, '=', "$search");

        return $class->orderBy($sort, $sortOrder)->paginate(20);
    }

    public static function sortedSearchLike(
        $searchField, $searchKeyword,
        $sortFields, $sortField, $sortFieldOrder, $defaultSortField,
        $class, $static = true
    ) {
        $search = $searchKeyword ?? '';

        $sort = $sortField ?? $defaultSortField;
        $sortOrder = $sortFieldOrder ?? 'asc';

        if (!array_search($sort, $sortFields))
            $sort = $defaultSortField;

        if (!array_search($sortOrder, ['asc', 'desc']))
            $sortOrder = 'asc';

        if ($static == true)
            $class = $class::where($searchField, 'like', "%$search%");
        else
            $class = $class->where($searchField, 'like', "%$search%");

        return $class->orderBy($sort, $sortOrder)->paginate(20);
    }

    // For creating pagination URLs

    public static function createPaginationURLs(Request $request, $paginatedResults) {
        $urlNoPage = $request->fullUrlWithoutQuery('page');

        if (!strstr($urlNoPage, '?'))
            $urlNoPage = $urlNoPage . '?';

        return [
            'prevPageUrl' => $urlNoPage . '&page=' . ($paginatedResults->currentPage() - 1),
            'nextPageUrl' => $urlNoPage . '&page=' . ($paginatedResults->currentPage() + 1),
        ];
    }

    // For deleting a comment along with its replies, reports, and votes

    public static function deleteComment($id) {
        $comment = Comment::find($id);
        if ($comment == null) return;

        $replies = Comment::where('comment_id', '=', $id)->get();

        foreach ($replies as $reply)
            Utilities::deleteComment($reply->id);

        $reports = Report::where('reported_comment_id', '=', $id)->get();

        foreach($reports as $report)
            $report->delete();

        $votes = Vote::where('comment_id', '=', $id)->get();

        foreach($votes as $vote)
            $vote->delete();

        $comment->delete();
    }

    // For deleting a news item, along with its bookmarks, comments, reports, uploaded files, and votes

    public static function deleteNews($id) {
        $news = News::find($id);
        if ($news == null) return;

        $bookmarks = Bookmark::where('news_id', '=', $id)->get();

        foreach($bookmarks as $bookmark)
            $bookmark->delete();

        $comments = Comment::where('news_id', '=', $id)->get();

        foreach ($comments as $comment)
            Utilities::deleteComment($comment->id);

        $reports = Report::where('reported_news_id', '=', $id)->get();

        foreach($reports as $report)
            $report->delete();

        $uploadedFiles = UploadedFile::where('news_id', '=', $id)->get();

        foreach ($uploadedFiles as $uploadedFile) {
            try {
                $delete = unlink(storage_path('/app/public/uploads/' . $uploadedFile->path));
            } catch (ErrorException) {
    
            }

            $uploadedFile->delete();
        }

        $votes = Vote::where('news_id', '=', $id)->get();

        foreach($votes as $vote)
            $vote->delete();

        $news->delete();
    }
}