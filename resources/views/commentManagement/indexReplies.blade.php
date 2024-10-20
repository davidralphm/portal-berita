@extends ('layouts.base')

@section('main')
    <h1 class="my-3 p-3 text-center">Replies for comment ID {{ $comment->id }}</h1>
    <hr>

    <div class="container-fluid">
        <x-search-bar
            url="/commentManagement/{{ $comment->id }}/replies"
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
                        <th>Reports</th>
                        <th>Actions</th>
                    </tr>
                </thead>
    
                @foreach ($replies as $reply)
                    <tr>
                        <td class="align-middle">{{ $reply->id }}</td>
                        <td class="align-middle">{{ $reply->user->name }}</td>
                        <td class="align-middle">{{ $reply->created_at }}</td>
                        <td class="align-middle">{{ $reply->likeCount() }}</td>
                        <td class="align-middle">{{ $reply->dislikeCount() }}</td>
                        <td class="align-middle">{{ $reply->reportCount() }}</td>
                        <td class="align-middle">
                            <div class="d-flex">
                                <a href="/commentManagement/{{ $reply->id }}" class="btn btn-primary">View</a>

                                <form class="mx-2" action="/commentManagement/{{ $reply->id }}" method="post">
                                    @method('DELETE')
                                    @csrf

                                    <input type="submit" class="btn btn-danger" value="Delete">
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tr>
        </table>

        <x-pagination
            :currentPage="$replies->currentPage()"
            :onFirstPage="$replies->onFirstPage()"
            :onLastPage="$replies->onLastPage()"
            :prevPageUrl="$prevPageUrl"
            :nextPageUrl="$nextPageUrl"
        />
    </div>

@endsection