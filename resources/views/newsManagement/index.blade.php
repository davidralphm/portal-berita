@extends ('layouts.base')

@section('title', 'News List')

@section('main')
    <h1 class="my-3 p-3 text-center">News Item List</h1>
    <hr>

    <div class="container-fluid">
        <x-search-bar
            url="/newsManagement"
            placeholder="Search by title"
            :sortOptions="[
                    'id' => 'ID',
                    'title' => 'title',
                    'author' => 'author',
                    'category' => 'category',
                    'created_at' => 'joined / created at',
                ]"
        />

        <table class="table table-hover">
            <tr>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>Created At</th>
                        <th>Likes</th>
                        <th>Dislikes</th>
                        <th>Reports</th>
                        <th>Actions</th>
                    </tr>
                </thead>
    
                @foreach ($news as $new)
                    <tr>
                        <td class="align-middle">{{ $new->id }}</td>
                        <td class="align-middle">{{ $new->title }}</td>
                        <td class="align-middle">{{ $new->author }}</td>
                        <td class="align-middle">{{ $new->category }}</td>
                        <td class="align-middle">{{ $new->created_at }}</td>
                        <td class="align-middle">{{ $new->likeCount() }}</td>
                        <td class="align-middle">{{ $new->dislikeCount() }}</td>
                        <td class="align-middle">{{ $new->reportCount() }}</td>
                        <td class="align-middle">
                            <div class="d-flex">
                                <a href="/newsManagement/{{ $new->id }}" class="btn btn-primary">View</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tr>
        </table>

        <a
            href="/newsManagement/create"
            class="btn btn-primary rounded-circle"
            style="
                line-height: 2rem;
                font-size: 2rem;
                position: fixed;
                right: 2rem;
                bottom: 2rem;
                width: 3rem;
                height: 3rem;
                box-shadow: 0 0 5px #000000;
            "
        >
            +
        </a>
    
        <x-pagination
            :currentPage="$news->currentPage()"
            :onFirstPage="$news->onFirstPage()"
            :onLastPage="$news->onLastPage()"
            :prevPageUrl="$prevPageUrl"
            :nextPageUrl="$nextPageUrl"
        />
    </div>

@endsection