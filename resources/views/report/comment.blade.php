@extends('layouts.base')

@section('title', 'Report Comment')

@section('main')
    <div class="container p-3">
        <h3 class="text-center ">Report Comment by user '{{ $comment->user->name }}'</h3>
        <hr>

        <form action="/report/comment/{{ $comment->id }}" method="post">
            @csrf

            <div class="my-4">
                <label for="reason" class="form-label">Comment Body</label>
                <textarea name="reason" id="reason" class="form-control" rows="8" disabled>{{ $comment->body }}</textarea>
            </div>

            <div class="my-4">
                <label for="reason" class="form-label">Reason</label>
                <textarea name="reason" id="reason" class="form-control" rows="8"></textarea>
            </div>

            <hr>

            <input type="submit" value="Report" class="btn btn-primary">
        </form>
    </div>
@endsection