@extends('layouts.base')

@section('title', 'Edit Comment')

@section('main')
    <div class="container p-3 my-5">
        <h3 class="text-center ">Edit Comment</h3>
        <hr>

        <form action="/comment/{{$comment->id}}" method="post">
            @method('PATCH')
            @csrf

            <div class="my-4">
                <label for="body" class="form-label">Comment</label>
                <textarea name="body" id="body" class="form-control" rows="8">{{ $comment->body }}</textarea>
            </div>

            <hr>

            <input type="submit" value="Save" class="btn btn-primary">
        </form>

        <form action="/comment/{{ $comment->id }}" method="post" class="mt-3">
            @csrf
            @method('DELETE')

            <input type="submit" value="Delete" class="btn btn-danger">
        </form>
    </div>
@endsection