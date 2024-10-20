@extends('layouts.base')

@section('main')
    <div class="container p-3">
        <h3 class="text-center ">Create User</h3>
        <hr>

        <form action="/userManagement" method="post">
            @csrf

            <div class="my-4">
                <label for="name" class="form-label">Email</label>
                <input class="form-control" type="email" name="email" id="email" required>
            </div>

            <div class="my-4">
                <label for="name" class="form-label">Password</label>
                <input class="form-control" type="password" name="password" id="password" required>
            </div>

            <div class="my-4">
                <label for="name" class="form-label">Confirm Password</label>
                <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" required>
            </div>

            <div class="my-4">
                <label for="name" class="form-label">Name</label>
                <input class="form-control" type="text" name="name" id="name" required>
            </div>

            <div class="my-4">
                <label for="type" class="form-label">Type</label>

                <select class="form-control" name="type" id="type" required>
                    <option value="user">User</option>
                    <option value="editor">Editor</option>
                    <option value="admin">Administrator</option>
                </select>
            </div>

            <!-- <div class="my-4">
                <label for="blocked" class="form-label">Blocked</label>
                
                <select class="form-control" name="blocked" id="blocked">
                    <option value="n">No</option>
                    <option value="y">Yes</option>
                </select>
            </div> -->

            <hr>

            <input type="submit" value="Create User" class="btn btn-primary">
        </form>
    </div>
@endsection