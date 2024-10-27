<div class="" style="gap: 2rem; display: flex; flex-wrap: wrap; min-height: 256px">
    <!-- <div style="flex: 1 1 256px">
        <img class="d-block border p-3" src="{{ $news->thumbnail_url }}" alt="Thumbnail">
    </div> -->

    <div style="flex: 1 1 256px; background: url('{{ $news->thumbnail_url }}')">
    </div>

    <div style="flex: 4 1 256px">
        <h6>{{ Str::title($news->category) }}</h6>

        <h3>{{ $news->title }}</h3>

        <p class="my-2">@if ($news->description != ''){{ $news->description }}@else No description available... @endif</p>

        <small class="d-block">{{ $news->author }} - {{ $news->created_at }}</small>

        <div class="mt-2">
            <p>
                {{ $news->commentCount() }}
                <i class="far fa-comments"></i>
                &nbsp;

                {{ $news->likeCount() }}
                @if (!$news->isLiked())
                    <a href="/{{ $news->slug }}/like" style="color: black;"><i class="far fa-thumbs-up"></i></a>
                @else
                    <a href="/{{ $news->slug }}/removeVote" style="color: black;"><i class="fas fa-thumbs-up"></i></a>
                @endif
                &nbsp;

                {{ $news->dislikeCount() }}
                @if (!$news->isDisliked())
                    <a href="/{{ $news->slug }}/dislike" style="color: black;"><i class="far fa-thumbs-down"></i></a>
                @else
                    <a href="/{{ $news->slug }}/removeVote" style="color: black;"><i class="fas fa-thumbs-down"></i></a>
                @endif
                &nbsp;

                {{ $news->reportCount() }}
                <a href="/report/news/{{ $news->id }}" style="color: black; text-decoration: none">
                    @if ($news->isReported())
                        <i class="fas fa-flag"></i> Edit Report
                    @else
                        <i class="far fa-flag"></i> Report
                    @endif
                </a>
                &nbsp;

                @if ($news->isBookmarked())
                    <a href="/{{ $news->slug }}/removeBookmark" style="color: black; text-decoration: none">
                        <i class="fas fa-star"></i> Remove from Bookmarks
                    </a>
                @else
                    <a href="/{{ $news->slug }}/addBookmark" style="color: black; text-decoration: none">
                        <i class="far fa-star"></i> Add to Bookmarks
                    </a>
                @endif
            </p>
        </div>

        <div class="d-flex mt-3">
            <a href="/{{ $news->slug }}" class="btn btn-primary me-3">Visit</a>

            <!-- @if ($news->isBookmarked())
                <a href="/{{ $news->slug }}/removeBookmark" class="btn btn-danger">Remove from bookmarks</a>
            @else
                <a href="/{{ $news->slug }}/addBookmark" class="btn btn-success">Add to bookmarks</a>
            @endif -->
        </div>
    </div>
</div>