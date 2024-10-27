<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\UploadedFile;
use App\Utilities;
use ErrorException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class NewsManagementController extends Controller
{
    public function index(Request $request) {
        $this->authorize('isEditorOrAdmin');
        
        $news = Utilities::sortedSearchLike(
            'title', $request->search,
            ['id', 'title', 'author', 'category', 'created_at'],
            $request->sort, $request->sortOrder, 'id',
            News::class
        );

        $paginationURLs = Utilities::createPaginationURLs($request, $news);

        return view(
            'newsManagement.index',
            [
                'news' => $news,
                'prevPageUrl' => $paginationURLs['prevPageUrl'],
                'nextPageUrl' => $paginationURLs['nextPageUrl'],
            ]
        );
    }

    public function create() {
        $this->authorize('isEditorOrAdmin');
        
        return view('newsManagement.create');
    }

    public function store(Request $request) {
        $this->authorize('isEditorOrAdmin');

        $request->validate(
            [
                'title' => 'required',
                'category' => [
                    'required',
                    Rule::in(['sports', 'culinary', 'health', 'automotive', 'technology', 'economy', 'politics'])
                ],
                'body' => 'required',
            ],

            [
                'title.required' => 'News title is required',
                'category.required' => 'News category is required',
                'category.in' => 'Invalid news category',
                'body.required' => 'News body is required',
            ]
        );

        $news = new News();

        $news->title = $request->title;
        $news->author = Auth::user()->name;
        $news->category = $request->category;
        $news->slug = Str::slug($request->title);
        $news->thumbnail_url = $request->thumbnail_url;
        $news->description = $request->description;
        $news->body = $request->body;
        $news->user_id = Auth::id();

        $news->save();

        return Redirect("newsManagement/$news->id")->with('success', 'News item created successfully');
    }

    public function show(String $id) {
        $this->authorize('isEditorOrAdmin');

        $news = News::findOrFail($id);

        $uploadedFiles = UploadedFile::where('news_id', '=', $id)->get();

        return view('newsManagement.show', ['news' => $news, 'uploadedFiles' => $uploadedFiles]);
    }

    public function update(Request $request, String $id) {
        $request->validate(
            [
                'title' => 'required',
                'category' => [
                    'required',
                    Rule::in(['sports', 'culinary', 'health', 'automotive', 'technology', 'economy', 'politics'])
                ],
                'body' => 'required',
            ],

            [
                'title.required' => 'News title is required',
                'category.required' => 'News category is required',
                'category.in' => 'Invalid news category',
                'body.required' => 'News body is required',
            ]
        );

        $news = News::findOrFail($id);

        $this->authorize('isOwner', $news);

        $news->title = $request->title;
        $news->category = $request->category;
        $news->thumbnail_url = $request->thumbnail_url;
        $news->description = $request->description;
        $news->body = $request->body;

        $news->save();

        return Redirect("/newsManagement/$id")->with('success', 'News item updated successfully');
    }

    public function delete(String $id) {
        $news = News::findOrFail($id);

        $this->authorize('isOwner', $news);

        // Delete all uploaded files
        $uploadedFiles = UploadedFile::where('news_id', '=', $id)->get();

        foreach ($uploadedFiles as $uploadedFile) {
            try {
                $delete = unlink(storage_path('/app/public/uploads/' . $uploadedFile->path));
            } catch (ErrorException) {
    
            }

            $uploadedFile->delete();
        }

        $news->delete();

        return Redirect('/newsManagement')->with('success', 'News item deleted');
    }

    public function uploadFile(Request $request, String $newsId) {
        $news = News::findOrFail($newsId);
        $this->authorize('isOwner', $news);

        $request->validate(
            [
                'file' => 'required|mimetypes:image/bmp,image/jpeg,image/png,image/webp,video/mp4'
            ],

            [
                'file.required' => 'No file chosen',
                'file.mimetypes' => 'Invalid mime type'
            ]
        );

        $filename = time() . '.' . $request->file->extension();

        $request->file->move(storage_path('/app/public/uploads'), $filename);

        // Create uploaded file

        $uploadedFile = new UploadedFile();

        $uploadedFile->user_id = Auth::id();
        $uploadedFile->news_id = $newsId;
        $uploadedFile->path = $filename;

        $uploadedFile->save();

        return Redirect()->back()->with('success', 'File uploaded successfully');
    }

    public function deleteUploadedFile(String $filename) {
        $file = UploadedFile::where('path', '=', $filename)->firstOrFail();

        $this->authorize('isOwner', $file);

        try {
            $delete = unlink(storage_path('/app/public/uploads/' . $filename));
        } catch (ErrorException) {

        }

        $file->delete();

        return Redirect()->back()->with('success', 'File deleted successfully');
    }
}
