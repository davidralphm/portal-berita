@extends ('layouts.base')

@section('title', 'User Report List')

@section('main')
    <h1 class="my-3 p-3 text-center">User Reports</h1>
    <hr>

    <div class="container-fluid">
        <x-search-bar
            url="/reportManagement/user"
            placeholder="Search by report reason"
            :sortOptions="[
                    'id' => 'ID',
                    'created_at' => 'joined / created at',
                    'reported_user_id' => 'reported user ID',
                ]"
        />

        <table class="table table-hover">
            <tr>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Created By</th>
                        <th>Created At</th>
                        <th>Reported User ID</th>
                        <th>Reported User Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
    
                @foreach ($reports as $report)
                    <tr>
                        <td class="align-middle">{{ $report->id }}</td>
                        <td class="align-middle">{{ $report->user->name }}</td>
                        <td class="align-middle">{{ $report->created_at }}</td>
                        <td class="align-middle">{{ $report->reportedUser->id }}</td>
                        <td class="align-middle">{{ $report->reportedUser->name }}</td>
                        <td class="align-middle">
                            <div class="d-flex">
                                <a href="/reportManagement/user/{{ $report->id }}" class="btn btn-primary">View</a>
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