<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Utilities;
use Illuminate\Http\Request;

class ReportManagementController extends Controller
{
    // Show user reports

    public function indexUser(Request $request, String $id = "0") {
        $this->authorize('isAdmin');

        if ($id == "0")
            $reports = Report::where('reported_user_id', '!=', 0);
        else
            $reports = Report::where('reported_user_id', '=', $id);

        $reports = Utilities::sortedSearchLike(
            'reason', $request->search,
            ['id', 'created_at', 'reported_user_id'],
            $request->sort, $request->sortOrder, 'id',
            $reports, false
        );

        $paginationURLs = Utilities::createPaginationURLs($request, $reports);

        return view(
            'reportManagement.user',
            [
                'reports' => $reports,
                'prevPageUrl' => $paginationURLs['prevPageUrl'],
                'nextPageUrl' => $paginationURLs['nextPageUrl'],
            ]
        );
    }

    // Show reports for a user

    public function showUserReports(Request $request, String $id) {
        return $this->indexUser($request, $id);
    }

    // Show one user report

    public function showUser(String $id) {
        $this->authorize('isAdmin');

        $report = Report::findOrFail($id);

        return view('reportManagement.showUser', ['report' => $report]);
    }

    // Delete a user report

    public function deleteUser(String $id) {
        $this->authorize('isAdmin');

        $report = Report::findOrFail($id);

        $report->delete();

        return Redirect('/reportManagement/user')->with('success', 'Report deleted');
    }

    // Show news reports

    public function indexNews(Request $request, String $id = "0") {
        $this->authorize('isAdmin');

        if ($id == "0")
            $reports = Report::where('reported_news_id', '!=', 0);
        else
            $reports = Report::where('reported_news_id', '=', $id);

        $reports = Utilities::sortedSearchLike(
            'reason', $request->search,
            ['id', 'created_at', 'reported_news_id'],
            $request->sort, $request->sortOrder, 'id',
            $reports, false
        );

        $paginationURLs = Utilities::createPaginationURLs($request, $reports);

        return view(
            'reportManagement.news',
            [
                'reports' => $reports,
                'prevPageUrl' => $paginationURLs['prevPageUrl'],
                'nextPageUrl' => $paginationURLs['nextPageUrl'],
            ]
        );
    }

    // Show reports for a news

    public function showNewsReports(Request $request, String $id) {
        return $this->indexNews($request, $id);
    }

    // Show one news report

    public function showNews(String $id) {
        $this->authorize('isAdmin');

        $report = Report::findOrFail($id);

        return view('reportManagement.showNews', ['report' => $report]);
    }

    // Delete a news report

    public function deleteNews(String $id) {
        $this->authorize('isAdmin');

        $report = Report::findOrFail($id);

        $report->delete();

        return Redirect('/reportManagement/news')->with('success', 'Report deleted');
    }



    // Show comment reports

    public function indexComment(Request $request, String $id = "0") {
        $this->authorize('isAdmin');

        if ($id == "0")
            $reports = Report::where('reported_comment_id', '!=', 0);
        else
            $reports = Report::where('reported_comment_id', '=', $id);
        
        $reports = Utilities::sortedSearchLike(
            'reason', $request->search,
            ['id', 'created_at', 'reported_commnet_id'],
            $request->sort, $request->sortOrder, 'id',
            $reports, false
        );

        $paginationURLs = Utilities::createPaginationURLs($request, $reports);

        return view(
            'reportManagement.comment',
            [
                'reports' => $reports,
                'prevPageUrl' => $paginationURLs['prevPageUrl'],
                'nextPageUrl' => $paginationURLs['nextPageUrl'],
            ]
        );
    }

    // Show one comment report

    public function showComment(String $id) {
        $this->authorize('isAdmin');

        $report = Report::findOrFail($id);

        return view('reportManagement.showComment', ['report' => $report]);
    }

    // Show reports for a comment

    public function showCommentReports(Request $request, String $id) {
        return $this->indexComment($request, $id);
    }

    // Delete a comment report

    public function deleteComment(String $id) {
        $this->authorize('isAdmin');

        $report = Report::findOrFail($id);

        $report->delete();

        return Redirect('/reportManagement/comment')->with('success', 'Report deleted');
    }
}
