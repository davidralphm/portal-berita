@extends('layouts.base')

@section('title', 'Reset Password')

@section('main')
    <div class="container w-75 p-3 shadow my-5 rounded-3">
        <form action="/resetPassword" method="post">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            <div class="mt-3 mb-3">
                <label for="password" class="form-label">New Password</label>
                <input type="password" name="password" id="password" class="form-control">
            </div>

            <div class="mt-3 mb-3">
                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
            </div>

            <input type="submit" value="Reset Password" class="btn btn-primary">
        </form>

        <div class="text-center p-3">
            Already have an account? <a href="/login">Login</a> now!
        </div>
    </div>
@endsection