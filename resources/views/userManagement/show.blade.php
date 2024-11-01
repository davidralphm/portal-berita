@extends('layouts.base')

@section('title', 'User Details')

@section('main')
    <div class="container p-3">
        <h3 class="text-center ">User '{{ $user->name }}'</h3>
        <hr>

        <form action="/userManagement/{{ $user->id }}" method="post">
            @method('PATCH')
            @csrf

            <div class="my-4">
                <label for="id" class="form-label">ID</label>
                <input class="form-control" type="text" name="id" id="id" disabled value="{{ $user->id }}">
            </div>

            <div class="my-4">
                <label for="name" class="form-label">Email</label>
                <input class="form-control" type="text" name="email" id="email" disabled value="{{ $user->email }}">
            </div>

            <div class="my-4">
                <label for="name" class="form-label">Name</label>
                <input class="form-control" type="text" name="name" id="name" disabled value="{{ $user->name }}">
            </div>

            <div class="my-4">
                <label for="created_at" class="form-label">Joined / Created At</label>
                <input class="form-control" type="text" name="created_at" id="created_at" disabled value="{{ $user->created_at }}">
            </div>

            <div class="my-4">
                <label for="report_count" class="form-label">Report Count</label>
                <input class="form-control" type="text" name="report_count" id="report_count" disabled value="{{ $user->reportCount() }}">
            </div>

            <div class="my-4">
                <label for="type" class="form-label">Type</label>

                <select class="form-control" name="type" id="type">
                    <option value="user" @if($user->type == 'user') selected @endif>User</option>
                    <option value="editor" @if($user->type == 'editor') selected @endif>Editor</option>
                    <option value="admin" @if($user->type == 'admin') selected @endif>Administrator</option>
                </select>
            </div>

            <div class="my-4">
                <label for="blocked" class="form-label">Blocked</label>
                
                <select class="form-control" name="blocked" id="blocked">
                    <option value="n" @if($user->blocked == false) selected @endif>No</option>
                    <option value="y" @if($user->blocked == true) selected @endif>Yes</option>
                </select>
            </div>

            <hr>

            <input type="submit" value="Save" class="btn btn-primary">
            
            <a href="/reportManagement/user/{{ $user->id }}/reports" class="btn btn-primary">View Reports</a>
        </form>
    </div>
@endsection