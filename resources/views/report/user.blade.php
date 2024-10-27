@extends('layouts.base')

@section('main')
    <div class="container p-3">
        <h3 class="text-center ">Report User '{{ $user->name }}'</h3>
        <hr>

        <form action="/report/user/{{ $user->id }}" method="post">
            @csrf

            <div class="my-4">
                <label for="reason" class="form-label">Reason</label>
                <textarea name="reason" id="reason" class="form-control" rows="8"></textarea>
            </div>

            <hr>

            <input type="submit" value="Report" class="btn btn-primary">
        </form>
    </div>
@endsection