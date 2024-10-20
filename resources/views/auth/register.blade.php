@extends('layouts.base')

@section('main')
    <div class="container w-75 p-3 shadow my-5 rounded-3">
        <form action="/register" method="post">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control">
            </div>

            <div class="mt-3 mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control">
            </div>

            <div class="mt-3 mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control">
            </div>

            <div class="mt-3 mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
            </div>

            <input type="submit" value="Register" class="btn btn-primary">
        </form>

        <div class="text-center p-3">
            Already have an account? <a href="/login">Login</a> now!
        </div>
    </div>
@endsection