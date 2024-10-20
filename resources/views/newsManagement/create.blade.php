@extends('layouts.base')

@section('main')
    <div class="container p-3">
        <h3 class="text-center ">Create News Item</h3>
        <hr>

        <form action="/newsManagement" method="post">
            @csrf

            <div class="my-4">
                <label for="title" class="form-label">Title</label>
                <input class="form-control" type="text" name="title" id="title" required>
            </div>

            <div class="my-4">
                <label for="thumbnail_url" class="form-label">Thumbnail URL</label>
                <input class="form-control" type="text" name="thumbnail_url" id="thumbnail_url">
            </div>

            <div class="my-4">
                <label for="category" class="form-label">Category</label>

                <select class="form-control" name="category" id="category">
                    <option value="" disabled>Pilih Kategori</option>
                    <option value="olahraga">Olahraga</option>
                    <option value="kuliner">Kuliner</option>
                    <option value="kesehatan">Kesehatan</option>
                    <option value="otomotif">Otomotif</option>
                    <option value="teknologi">Teknologi</option>
                    <option value="ekonomi">Ekonomi</option>
                    <option value="politik">Politik</option>
                </select>
            </div>

            <div class="my-4">
                <label for="author" class="form-label">Author</label>
                <input class="form-control" type="text" name="author" id="author" required disabled value="{{ Auth::user()->name }}">
            </div>

            <div class="my-4">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" rows="8"></textarea>
            </div>

            <div class="my-4">
                <label for="body" class="form-label">Body</label>
                <textarea name="body" id="body" class="form-control" rows="16" required></textarea>
            </div>

            <hr>

            <input type="submit" value="Create News" class="btn btn-primary">
        </form>
    </div>
@endsection