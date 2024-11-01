@extends('layouts.base')

@section('title', 'Login')

@section('main')
    <div class="container w-75 my-5 shadow rounded-3">
        <form action="/login" method="post" class="p-4">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control">
            </div>
    
            <div class="mt-3 mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control">
            </div>
            
            <div class="d-flex justify-content-between">
                <input type="submit" value="Login" class="btn btn-primary">
                
                <a href="/forgotPassword" class="btn btn-secondary">Forgot Password</a>
            </div>
        </form>

        <div class="text-center p-3">
            Don't have an account? <a href="/register">Register</a> now!
        </div>
    </div>
@endsection