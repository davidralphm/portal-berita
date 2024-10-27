@extends('layouts.base')

@section('main')
    <div class="container p-3">
        <h3 class="text-center ">Report for news '{{ $report->reportedNews->title }}'</h3>
        <hr>

        <form action="/reportManagement/news/{{ $report->id }}" method="post">
            @method('DELETE')
            @csrf

            <div class="my-4">
                <label for="reason" class="form-label">Reason</label>
                <textarea name="reason" id="reason" class="form-control" rows="8" disabled>{{ $report->reason }}</textarea>
            </div>

            <hr>

            <input type="submit" value="Delete" class="btn btn-danger">
        </form>
    </div>
@endsection