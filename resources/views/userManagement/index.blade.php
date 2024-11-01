@extends ('layouts.base')

@section('title', 'User List')

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

        <a
            href="/userManagement/create"
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