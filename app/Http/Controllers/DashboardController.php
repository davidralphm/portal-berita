<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Comment;
use App\Models\News;
use App\Models\Report;
use App\Models\UploadedFile;
use App\Models\Vote;
use App\Utilities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class DashboardController extends Controller
{
    public function index() {
        return view('dashboard.index', ['user' => Auth::user()]);
    }

    public function update(Request $request) {
        $request->validate(
            [ 'name' => 'required' ],
            [ 'name' => 'Name is required']
        );

        // Update name

        $user = Auth::user();
        $user->name = $request->name;

        // Update password if current password, new password, and new password
        // confirmation fields are not empty

        if ($request->current_password != '' &&
            $request->password != '' &&
            $request->password_confirmation != ''
        ) {
            // Make sure entered current password is correct

            if (!Hash::check($request->current_password, $user->password)) {
                return Redirect()->back()->with('error', 'Incorrect password');
            }

            $user->password = Hash::make($request->password);
        }

        $user->save();

        return Redirect()->back()->with('success', 'Account updated successfully');
    }

    public function delete(Request $request) {
        $request->validate(
            [ 'password' => 'required' ],
            [ 'password.required' => 'Incorrect password!' ]
        );

        $user = Auth::user();

        // Delete all bookmarks
        $del = Bookmark::where('user_id', '=', $user->id)->get();

        foreach ($del as $delete)
            $delete->delete();

        // Delete all comments
        $del = Comment::where('user_id', '=', $user->id)->get();

        foreach ($del as $delete)
            Utilities::deleteComment($delete->id);

        // Delete all news
        $del = News::where('user_id', '=', $user->id)->get();

        foreach ($del as $delete)
            Utilities::deleteNews($delete->id);

        // Delete all reports
        $del = Report::where('user_id', '=', $user->id)->get();

        foreach ($del as $delete)
            $delete->delete();

        $del = Report::where('reported_user_id', '=', $user->id)->get();

        foreach ($del as $delete)
            $delete->delete();

        // Delete votes
        $del = Vote::where('user_id', '=', $user->id)->get();

        foreach ($del as $delete)
            $delete->delete();

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $user->delete();

        return Redirect('/login')->with('success', 'Account deleted successfully!');
    }
}
