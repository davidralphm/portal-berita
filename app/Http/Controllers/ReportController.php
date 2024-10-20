<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\News;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    // For users

    public function getReportUser(String $id) {
        $user = User::findOrFail($id);

        $report = Report::where('user_id', '=', Auth::id())
        ->where('reported_user_id', '=', $id)
        ->first();

        return view('report.user', ['user' => $user, 'report' => $report]);
    }

    public function postReportUser(Request $request, String $id) {
        $request->validate(
            ['reason' => 'required'],
            ['reason.required' => 'Reporting reason is required']
        );

        $user = User::findOrFail($id);
        $report = Report::where('reported_user_id', '=', $user->id)->first();

        if ($report == null)
            $report = new Report();

        $report->created_at = now();

        $report->user_id = Auth::id();
        $report->reported_user_id = $id;
        $report->reported_news_id = 0;
        $report->reported_comment_id = 0;
        $report->reason = $request->reason;

        $report->save();

        return Redirect("/report/user/$id")->with('success', 'Report created successfully');
    }

    public function deleteReportUser(String $id) {
        $user = User::findOrFail($id);
        $report = Report::where('reported_user_id', '=', $user->id)->first();

        $this->authorize('isOwner', $report);

        if ($report != null)
            $report->delete();

        return Redirect("/report/user/$id")->with('success', 'Report deleted successfully');
    }

    // For news

    public function getReportNews(String $id) {
        $news = News::findOrFail($id);

        $report = Report::where('user_id', '=', Auth::id())
        ->where('reported_news_id', '=', $id)
        ->first();

        return view('report.news', ['news' => $news, 'report' => $report]);
    }

    public function postReportNews(Request $request, String $id) {
        $news = News::findOrFail($id);
        $report = Report::where('reported_news_id', '=', $news->id)->first();

        if ($report == null)
            $report = new Report();

        $report->created_at = now();

        $report->user_id = Auth::id();
        $report->reported_user_id = 0;
        $report->reported_news_id = $id;
        $report->reported_comment_id = 0;
        $report->reason = $request->reason;

        $report->save();

        return Redirect("/report/news/$id")->with('success', 'Report created successfully');
    }

    public function deleteReportNews(String $id) {
        $news = News::findOrFail($id);
        $report = Report::where('reported_news_id', '=', $news->id)->first();

        $this->authorize('isOwner', $report);

        if ($report != null)
            $report->delete();

        return Redirect("/report/news/$id")->with('success', 'Report deleted successfully');
    }

    // For comments

    public function getReportComment(String $id) {
        $comment = Comment::findOrFail($id);

        $report = Report::where('user_id', '=', Auth::id())
        ->where('reported_comment_id', '=', $id)
        ->first();

        return view('report.comment', ['comment' => $comment, 'report' => $report]);
    }

    public function postReportComment(Request $request, String $id) {
        $comment = Comment::findOrFail($id);
        $report = Report::where('reported_comment_id', '=', $comment->id)->first();

        if ($report == null)
            $report = new Report();

        $report->created_at = now();

        $report->user_id = Auth::id();
        $report->reported_user_id = 0;
        $report->reported_news_id = 0;
        $report->reported_comment_id = $id;
        $report->reason = $request->reason;

        $report->save();

        return Redirect("/report/comment/$id")->with('success', 'Report created successfully');
    }

    public function deleteReportComment(String $id) {
        $comment = Comment::findOrFail($id);
        $report = Report::where('reported_comment_id', '=', $comment->id)->first();

        $this->authorize('isOwner', $report);
        
        if ($report != null)
            $report->delete();

        return Redirect("/report/comment/$id")->with('success', 'Report deleted successfully');
    }
}
