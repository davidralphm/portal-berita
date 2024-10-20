@extends('layouts.base')

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
                <textarea name="reason" id="reason" class="form-control" rows="8">@if ($report != null) {{ $report->reason }} @endif</textarea>
            </div>

            <hr>

            <input type="submit" value="Report Comment" class="btn btn-primary">
        </form>

        @if ($report != null)
            <form class="mt-3" action="/report/comment/{{ $comment->id }}" method="post">
                @csrf
                @method('DELETE')

                <input type="submit" value="Delete Report" class="btn btn-danger">
            </form>
        @endif
    </div>
@endsection