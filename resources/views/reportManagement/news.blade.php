@extends ('layouts.base')

@section('title', 'News Report List')

@section('main')
    <h1 class="my-3 p-3 text-center">News Reports</h1>
    <hr>

    <div class="container-fluid">
        <x-search-bar
            url="/reportManagement/news"
            placeholder="Search by report reason"
            :sortOptions="[
                    'id' => 'ID',
                    'created_at' => 'joined / created at',
                    'reported_news_id' => 'reported news ID',
                ]"
        />

        <table class="table table-hover">
            <tr>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Created By</th>
                        <th>Created At</th>
                        <th>Reported News ID</th>
                        <th>Reported News Title</th>
                        <th>Actions</th>
                    </tr>
                </thead>
    
                @foreach ($reports as $report)
                    <tr>
                        <td class="align-middle">{{ $report->id }}</td>
                        <td class="align-middle">{{ $report->user->name }}</td>
                        <td class="align-middle">{{ $report->created_at }}</td>
                        <td class="align-middle">{{ $report->reportedNews->id }}</td>
                        <td class="align-middle">{{ $report->reportedNews->title }}</td>
                        <td class="align-middle">
                            <div class="d-flex">
                                <a href="/reportManagement/news/{{ $report->id }}" class="btn btn-primary">View</a>
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