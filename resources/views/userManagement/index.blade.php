@extends ('layouts.base')

@section('main')
    <h1 class="my-3 p-3 text-center">User List</h1>
    <hr>

    <div class="container-fluid">
        <x-search-bar
            url="/userManagement"
            placeholder="Search by username"
            :sortOptions="[
                    'id' => 'ID',
                    'name' => 'name',
                    'created_at' => 'joined / created at',
                    'type' => 'type',
                    'blocked' => 'blocked',
                ]"
        />

        <table class="table table-hover">
            <tr>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Joined / Created At</th>
                        <th>Type</th>
                        <th>Reports</th>
                        <th>Blocked</th>
                        <th>Actions</th>
                    </tr>
                </thead>
    
                @foreach ($users as $user)
                    <tr>
                        <td class="align-middle">{{ $user->id }}</td>
                        <td class="align-middle">{{ $user->name }}</td>
                        <td class="align-middle">{{ $user->created_at }}</td>
                        <td class="align-middle">{{ $user->type }}</td>
                        <td class="align-middle">{{ $user->reportCount() }}</td>
                        <td class="align-middle">{{ $user->blocked }}</td>
                        <td class="align-middle">
                            <div class="d-flex">
                                <a href="/userManagement/{{ $user->id }}" class="btn btn-primary">View</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tr>
        </table>
    </div>

    <x-pagination
        :currentPage="$users->currentPage()"
        :onFirstPage="$users->onFirstPage()"
        :onLastPage="$users->onLastPage()"
        :prevPageUrl="$prevPageUrl"
        :nextPageUrl="$nextPageUrl"
    />

@endsection