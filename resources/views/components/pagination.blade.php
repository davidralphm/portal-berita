<div class="text-center">
    @if (!$onFirstPage)
        <a href="{{ $prevPageUrl }}" class="btn btn-primary">&lt;&lt;</a>
    @endif

    <b class="btn btn-secondary">{{ $currentPage }}</b>

    @if (!$onLastPage)
        <a href="{{ $nextPageUrl }}" class="btn btn-primary">&gt;&gt;</a>
    @endif
</div>