@extends('layouts.base')

@section('main')
    <h1 class="my-3 p-3 text-center">Search results for '{{ Request::get('search') }}'</h1>

    <x-search-bar
        url="/search"
        placeholder="Search news by title"
        :sortOptions="[
                'title' => 'title',
                'author' => 'author',
                'category' => 'category',
                'created_at' => 'date',
            ]"
    />

    <div>
        @foreach ($news as $value)
            <x-news-item :news="$value" />

            <hr>
        @endforeach
    </div>

    <x-pagination
        :currentPage="$news->currentPage()"
        :onFirstPage="$news->onFirstPage()"
        :onLastPage="$news->onLastPage()"
        :prevPageUrl="$prevPageUrl"
        :nextPageUrl="$nextPageUrl"
    />
@endsection