@extends('layouts.base')

@section('main')
    <div class="container p-3">
        <h3 class="text-center ">News Item '{{ Str::title($news->title) }}'</h3>
        <hr>

        <form action="/newsManagement/{{ $news->id }}" method="post">
            @method('PATCH')
            @csrf

            <div class="my-4">
                <label for="id" class="form-label">ID</label>
                <input class="form-control" type="text" name="id" id="id" disabled value="{{ $news->id }}">
            </div>

            <div class="my-4">
                <label for="slug" class="form-label">Slug</label>
                <input class="form-control" type="text" name="slug" id="slug" disabled value="{{ $news->slug }}">
            </div>

            <div class="my-4">
                <label for="title" class="form-label">Title</label>
                <input class="form-control" type="text" name="title" id="title" value="{{ $news->title }}">
            </div>

            <div class="my-4">
                <label for="author" class="form-label">Author</label>
                <input class="form-control" type="text" name="author" id="author" disabled value="{{ $news->author }}">
            </div>

            <!-- <div class="my-4">
                <label for="category" class="form-label">Category</label>
                <input class="form-control" type="text" name="category" id="category" value="{{ $news->category }}">
            </div> -->

            <div class="my-4">
                <label for="category" class="form-label">Category</label>

                <select class="form-control" name="category" id="category">
                    <option value="" disabled>Pilih Kategori</option>
                    <option value="olahraga" @if($news->category == 'olahraga') selected @endif>Olahraga</option>
                    <option value="kuliner" @if($news->category == 'kuliner') selected @endif>Kuliner</option>
                    <option value="kesehatan" @if($news->category == 'kesehatan') selected @endif>Kesehatan</option>
                    <option value="otomotif" @if($news->category == 'otomotif') selected @endif>Otomotif</option>
                    <option value="teknologi" @if($news->category == 'teknologi') selected @endif>Teknologi</option>
                    <option value="ekonomi" @if($news->category == 'ekonomi') selected @endif>Ekonomi</option>
                    <option value="politik" @if($news->category == 'politik') selected @endif>Politik</option>
                </select>
            </div>

            <div class="my-4">
                <label for="created_at" class="form-label">Created At</label>
                <input class="form-control" type="text" name="created_at" id="created_at" disabled value="{{ $news->created_at }}">
            </div>

            <div class="my-4">
                <label for="likeCount" class="form-label">Like Count</label>
                <input class="form-control" type="text" name="likeCount" id="likeCount" disabled value="{{ $news->likeCount() }}">
            </div>

            <div class="my-4">
                <label for="dislikeCount" class="form-label">Dislike Count</label>
                <input class="form-control" type="text" name="dislikeCount" id="dislikeCount" disabled value="{{ $news->dislikeCount() }}">
            </div>

            <div class="my-4">
                <label for="report_count" class="form-label">Report Count</label>
                <input class="form-control" type="text" name="report_count" id="report_count" disabled value="{{ $news->reportCount() }}">
            </div>

            <div class="my-4">
                <label for="thumbnail_url" class="form-label">Thumbnail URL</label>
                <input class="form-control" type="text" name="thumbnail_url" id="thumbnail_url" value="{{ $news->thumbnail_url }}">
            </div>

            <div class="my-4">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" type="text" name="description" id="description" rows="8">{{ $news->description }}</textarea>
            </div>

            <div class="my-4">
                <label for="body" class="form-label">Body</label>
                <textarea class="form-control" type="text" name="body" id="body" rows="8">{{ $news->body }}</textarea>
            </div>

            <!-- <div class="my-4">
                <label for="type" class="form-label">Type</label>

                <select class="form-control" name="type" id="type">
                    <option value="user" @if($news->type == 'user') selected @endif>User</option>
                    <option value="editor" @if($news->type == 'editor') selected @endif>Editor</option>
                    <option value="admin" @if($news->type == 'admin') selected @endif>Administrator</option>
                </select>
            </div> -->

            <hr>

            <input type="submit" value="Update News" class="btn btn-primary">
        </form>

        <ul class="my-2">
            @foreach ($uploadedFiles as $file)
                <li>
                    <div class="d-flex justify-content-between">
                        <a class="d-block" href="/storage/uploads/{{ $file->path }}">{{ $file->path }}</a>
    
                        <a href="/newsManagement/deleteUploadedFile/{{ $file->path }}" class="d-block btn btn-danger">Delete File</a>
                    </div>
                </li>
            @endforeach
        </ul>

        <form action="/newsManagement/uploadFile/{{ $news->id }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="my-4">
                <label for="file" class="form-label">File</label>
                <input class="form-control" type="file" name="file" id="file" required>
            </div>

            <input type="submit" value="Upload File" class="btn btn-primary">
        </form>

        <div class="d-flex my-3">
            <a href="/reportManagement/news/{{ $news->id }}/reports" class="btn btn-primary">View Reports</a>
    
            <a href="/commentManagement/news/{{ $news->id }}" class="btn btn-primary mx-2">View Comments</a>
    
            <form action="/newsManagement/{{ $news->id }}" method="post">
                @method('DELETE')
                @csrf
    
                <input type="submit" value="Delete News" class="btn btn-danger">
            </form>
        </div>

    </div>
@endsection