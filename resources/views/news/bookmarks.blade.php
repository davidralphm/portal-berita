@extends('layouts.base')

@section('main')
    <h1 class="my-3 p-3 text-center">Bookmarks</h1>

    <x-search-bar
        url="/bookmarks"
        placeholder="Search news by title"
        :sortOptions="[
                'news.title' => 'title',
                'news.author' => 'author',
                'news.category' => 'category',
                'news.created_at' => 'date',
            ]"
    />

    <div>
        @foreach ($bookmarks as $value)
            <x-news-item :news="$value->news" />

            <hr>
        @endforeach
    </div>

    <x-pagination
        :currentPage="$bookmarks->currentPage()"
        :onFirstPage="$bookmarks->onFirstPage()"
        :onLastPage="$bookmarks->onLastPage()"
        :prevPageUrl="$prevPageUrl"
        :nextPageUrl="$nextPageUrl"
    />
@endsection