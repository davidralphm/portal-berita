@extends('layouts.base')

@section('title', 'Beranda')

@section('main')
    <h1 class="my-3 p-3 text-center">Beranda</h1>

    <x-search-bar
        url="/search"
        placeholder="Search news by title"
        value=""
        :sortOptions="[
                'title' => 'title',
                'author' => 'author',
                'category' => 'category',
                'created_at' => 'date',
            ]"
    />

    <div>
        @foreach ($news as $value)
            <h2 class="text-center my-5">{{ $value[0] }}</h2>
            @foreach ($value[1] as $item)
                <x-news-item :news="$item" />

                <hr>
            @endforeach
        @endforeach
    </div>
@endsection