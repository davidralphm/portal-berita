@extends ('layouts.base')

@section('main')
    <h1 class="my-3 p-3 text-center">Comment Reports</h1>
    <hr>

    <div class="container-fluid">
        <x-search-bar
            url="/reportManagement/comment"
            placeholder="Search by report reason"
            :sortOptions="[
                    'id' => 'ID',
                    'created_at' => 'joined / created at',
                    'reported_comment_id' => 'reported comment ID',
                ]"
        />

        <table class="table table-hover">
            <tr>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Created By</th>
                        <th>Created At</th>
                        <th>Reported Comment ID</th>
                        <th>Reported Comment Poster</th>
                        <th>Actions</th>
                    </tr>
                </thead>
    
                @foreach ($reports as $report)
                    <tr>
                        <td class="align-middle">{{ $report->id }}</td>
                        <td class="align-middle">{{ $report->user->name }}</td>
                        <td class="align-middle">{{ $report->created_at }}</td>
                        <td class="align-middle">{{ $report->reportedComment->id }}</td>
                        <td class="align-middle">{{ $report->reportedComment->user->name }}</td>
                        <td class="align-middle">
                            <div class="d-flex">
                                <a href="/reportManagement/comment/{{ $report->id }}" class="btn btn-primary">View</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tr>
        </table>

        <x-pagination
            :currentPage="$reports->currentPage()"
            :onFirstPage="$reports->onFirstPage()"
            :onLastPage="$reports->onLastPage()"
            :prevPageUrl="$prevPageUrl"
            :nextPageUrl="$nextPageUrl"
        />
    </div>

@endsection