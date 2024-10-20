@extends('layouts.base')

@section('main')
    <h1 class="my-3 p-3 text-center">Welcome back, {{ $user->name }}!</h1>

    <hr>

    <div class="container w-75 shadow my-5 p-4 rounded-3">
        <form action="/dashboard" method="post">
            @method('PATCH')
            
            <h3>Change Name</h3>
            <hr>

            @csrf
    
            <div class="mb-5">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" value="{{ $user->name }}" class="form-control">
            </div>

            <h3>Change Password</h3>
            <hr>
    
            <div class="mb-3">
                <label for="current_password" class="form-label">Current Password</label>
                <input type="password" name="current_password" id="current_password" class="form-control">
            </div>
    
            <div class="my-3">
                <label for="password" class="form-label">New Password</label>
                <input type="password" name="password" id="password" class="form-control">
            </div>
    
            <div class="my-3">
                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
            </div>
    
            <input type="submit" value="Update Account" class="btn btn-primary">
        </form>
    </div>

    <div class="container w-75 shadow my-5 p-4 rounded-3">
        <form action="/dashboard" method="post">
            @method('DELETE')
            
            @csrf

            <h3>Delete Account</h3>
            <hr>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control">
            </div>

            <input type="submit" value="Delete Account" class="btn btn-danger">
        </form>
    </div>

    <hr>
@endsection