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

        return view('report.user', ['user' => $user]);
    }

    public function postReportUser(Request $request, String $id) {
        $request->validate(
            ['reason' => 'required'],
            ['reason.required' => 'Reporting reason is required']
        );

        $user = User::findOrFail($id);
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

    // For news

    public function getReportNews(String $id) {
        $news = News::findOrFail($id);

        return view('report.news', ['news' => $news]);
    }

    public function postReportNews(Request $request, String $id) {
        $news = News::findOrFail($id);

        $request->validate(
            ['reason' => 'required'],
            ['reason.required' => 'Reporting reason is required']
        );

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

    // For comments

    public function getReportComment(String $id) {
        $comment = Comment::findOrFail($id);

        return view('report.comment', ['comment' => $comment]);
    }

    public function postReportComment(Request $request, String $id) {
        $comment = Comment::findOrFail($id);

        $request->validate(
            ['reason' => 'required'],
            ['reason.required' => 'Reporting reason is required']
        );

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
}
