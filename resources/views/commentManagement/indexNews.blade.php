@extends ('layouts.base')

@section('title', 'Comment List')

@section('main')
    <h1 class="my-3 p-3 text-center">Comments for '{{ $news->title }}'</h1>
    <hr>

    <div class="container-fluid">
        <x-search-bar
            url="/commentManagement/news/{{ $news->id }}"
            placeholder="Search in comment body"
            :sortOptions="[
                    'id' => 'ID',
                    'created_at' => 'joined / created at',
                ]"
        />

        <table class="table table-hover">
            <tr>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Poster</th>
                        <th>Posted At</th>
                        <th>Likes</th>
                        <th>Dislikes</th>
                        <th>Replies</th>
                        <th>Reports</th>
                        <th>Actions</th>
                    </tr>
                </thead>
    
                @foreach ($comments as $comment)
                    <tr>
                        <td class="align-middle">{{ $comment->id }}</td>
                        <td class="align-middle">{{ $comment->user->name }}</td>
                        <td class="align-middle">{{ $comment->created_at }}</td>
                        <td class="align-middle">{{ $comment->likeCount() }}</td>
                        <td class="align-middle">{{ $comment->dislikeCount() }}</td>
                        <td class="align-middle">{{ $comment->replyCount() }}</td>
                        <td class="align-middle">{{ $comment->reportCount() }}</td>
                        <td class="align-middle">
                            <div class="d-flex">
                                <a href="/commentManagement/{{ $comment->id }}" class="btn btn-primary">View</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tr>
        </table>

        <x-pagination
            :currentPage="$comments->currentPage()"
            :onFirstPage="$comments->onFirstPage()"
            :onLastPage="$comments->onLastPage()"
            :prevPageUrl="$prevPageUrl"
            :nextPageUrl="$nextPageUrl"
        />
    </div>

@endsection