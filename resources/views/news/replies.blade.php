@extends('layouts.base')

@section('title', 'Comment Replies')

@section('main')
    <h2 class="text-center">Replies</h2>

    <div class="container">
        <hr>

        @foreach ($replies as $reply)
            <div class="p-3 rounded-3 shadow my-3">
                <div>
                    <h5>
                        {{ $reply->user->name }}
                        &nbsp;

                        <a href="/report/user/{{ $reply->user->id }}" style="color: black; text-decoration: none">
                            <i class="far fa-flag"></i>
                        </a>
                    </h5>

                    <h6>{{ $reply->created_at }}</h6>

                    <b>
                        {{ $reply->likeCount() }}

                        @if ($reply->likedByUser())
                            <a style="color: black" href="/comment/{{ $reply->id }}/removeVote"><i class="fas fa-thumbs-up"></i></a>
                        @else
                            <a style="color: black" href="/comment/{{ $reply->id }}/like"><i class="far fa-thumbs-up"></i></a>
                        @endif

                        &nbsp;

                        {{ $reply->dislikeCount() }}

                        @if ($reply->dislikedByUser())
                            <a style="color: black" href="/comment/{{ $reply->id }}/removeVote"><i class="fas fa-thumbs-down"></i></a>
                        @else
                            <a style="color: black" href="/comment/{{ $reply->id }}/dislike"><i class="far fa-thumbs-down"></i></a>
                        @endif

                        &nbsp;

                        {{ $reply->reportCount() }}

                        <a style="color: black; text-decoration: none" href="/report/comment/{{ $reply->id }}">
                            <i class="far fa-flag"></i> Report Comment
                        </a>
                    </b>
                </div>

                <p class="my-0 mt-3">{{ $reply->body }}</p>

                <br>

                <div class="d-flex">
                    @if ($reply->user_id == Auth::id())
                        <a href="/comment/{{ $reply->id }}" class="btn btn-success">Edit</a>
                        
                        <form action="/comment/{{ $reply->id }}" method="post" class="ms-3">
                            @csrf
                            @method('DELETE')

                            <input type="submit" value="Delete" class="btn btn-danger">
                        </form>
                    @endif
                </div>

                <div class="d-none" id="comment{{$reply->id}}ReplyBox"></div>
                <div class="d-none" id="comment{{$reply->id}}Replies">
                </div>
            </div>
        @endforeach

        <form action="/comment/reply/{{ $comment->id }}" method="post">
            @csrf

            <div class="my-3">
                <label for="body" class="form-label">Leave a reply</label>
                <textarea name="body" id="body" class="form-control" rows=8 @if (!Auth::check()) disabled @endif>@if (!Auth::check()) You need to login to be able to post a comment @endif</textarea>
            </div>

            <input type="submit" value="Post Reply" class="btn btn-primary">
        </form>
    </div>


    <!-- Pagination -->

    <x-pagination
        :currentPage="$replies->currentPage()"
        :onFirstPage="$replies->onFirstPage()"
        :onLastPage="$replies->onLastPage()"
        :prevPageUrl="$prevPageUrl"
        :nextPageUrl="$nextPageUrl"
    />
@endsection