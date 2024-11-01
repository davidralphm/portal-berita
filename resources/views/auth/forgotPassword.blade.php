@extends('layouts.base')

@section('title', 'Forgot Password')

@section('main')
    <div class="container w-75 my-5 shadow rounded-3">
        <form action="/forgotPassword" method="post" class="p-4">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control">
            </div>
            
            <input type="submit" value="Send Password Reset Link" class="btn btn-primary">
        </form>

        <div class="text-center p-3">
            Already have an account? <a href="/login">Login</a> now!
        </div>
    </div>
@endsection