@extends('layouts.base')

@section('main')
    <div class="container p-3">
        <h3 class="text-center ">Comment ID '{{ $comment->id }}'</h3>
        <hr>

        <form action="/commentManagement/{{ $comment->id }}" method="post">
            @method('DELETE')
            @csrf

            <div class="my-4">
                <label for="id" class="form-label">ID</label>
                <input class="form-control" type="text" name="id" id="id" disabled value="{{ $comment->id }}">
            </div>

            <div class="my-4">
                <label for="poster" class="form-label">Poster</label>
                <input class="form-control" type="text" name="poster" id="poster" disabled value="{{ $comment->user->name }}">
            </div>

            <div class="my-4">
                <label for="created_at" class="form-label">Posted At</label>
                <input class="form-control" type="text" name="created_at" id="created_at" disabled value="{{ $comment->created_at }}">
            </div>

            <div class="my-4">
                <label for="like_count" class="form-label">Like Count</label>
                <input class="form-control" type="text" name="like_count" id="like_count" disabled value="{{ $comment->likeCount() }}">
            </div>

            <div class="my-4">
                <label for="dislike_count" class="form-label">Dislike Count</label>
                <input class="form-control" type="text" name="dislike_count" id="dislike_count" disabled value="{{ $comment->dislikeCount() }}">
            </div>

            <div class="my-4">
                <label for="reply_count" class="form-label">Reply Count</label>
                <input class="form-control" type="text" name="reply_count" id="reply_count" disabled value="{{ $comment->replyCount() }}">
            </div>

            <div class="my-4">
                <label for="report_count" class="form-label">Report Count</label>
                <input class="form-control" type="text" name="report_count" id="report_count" disabled value="{{ $comment->reportCount() }}">
            </div>

            <div class="my-4">
                <label for="body" class="form-label">Comment Body</label>
                <textarea name="body" id="body" class="form-control" disabled>{{ $comment->body }}</textarea>
            </div>

            <hr>

            <a href="/commentManagement/{{ $comment->id }}/replies" class="btn btn-primary">View Replies</a>
            <a href="/reportManagement/comment/{{ $comment->id }}/reports" class="btn btn-primary">View Reports</a>

            <input type="submit" value="Delete" class="btn btn-danger">
        </form>
    </div>
@endsection