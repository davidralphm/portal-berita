@extends('layouts.base')

@section('main')
    <div class="container p-3">
        <h3 class="text-center ">Report for comment by user '{{ $report->reportedComment->user->name }}'</h3>
        <hr>

        <form action="/reportManagement/comment/{{ $report->id }}" method="post">
            @method('DELETE')
            @csrf

            <div class="my-4">
                <label for="reason" class="form-label">Comment Body</label>
                <textarea name="reason" id="reason" class="form-control" rows="8" disabled>{{ $report->reportedComment->body }}</textarea>
            </div>

            <div class="my-4">
                <label for="reason" class="form-label">Reason</label>
                <textarea name="reason" id="reason" class="form-control" rows="8" disabled>{{ $report->reason }}</textarea>
            </div>

            <hr>

            <input type="submit" value="Delete Report" class="btn btn-danger">
        </form>
    </div>
@endsection