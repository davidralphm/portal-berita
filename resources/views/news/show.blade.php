@extends('layouts.base')

@section('main')
    <div class="container">
        <!-- Modal -->

        <div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="replyModalLabel">Reply to comment</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form action="" method="post" id="replyForm">
                            @csrf

                            <div class="mb-3">
                                <label for="body" class="col-form-label">Reply body</label>
                                <textarea class="form-control" id="body" name="body" rows="8"></textarea>
                            </div>
                        </form>
                    </div>
                    
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary" onclick="sendReply()">Send message</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- End of modal -->
         
        <div class="text-center my-3">
            <h2>{{ $news->title }}</h2>
            <h4>{{ $news->author }} - {{ Str::title($news->category) }}</h4>
            <h6 class="mt-3">
                {{ $news->commentCount() }} <i class="far fa-comments"></i> &nbsp;
                
                {{ $news->likeCount() }}
                
                @if ($news->isLiked() == true)
                    <a style="color: black" href="/{{ $news->slug }}/removeVote"><i class="fas fa-thumbs-up"></i></a>
                @else
                    <a style="color: black" href="/{{ $news->slug }}/like"><i class="far fa-thumbs-up"></i></a>
                @endif
                &nbsp;

                {{ $news->dislikeCount() }}
                
                @if ($news->isDisliked() == true)
                    <a style="color: black" href="/{{ $news->slug }}/removeVote"><i class="fas fa-thumbs-down"></i></a>
                @else
                    <a style="color: black" href="/{{ $news->slug }}/dislike"><i class="far fa-thumbs-down"></i></a>
                @endif
                &nbsp;

                {{ $news->reportCount() }}
                @if ($news->isReported())
                    <a href="/report/news/{{ $news->id }}" style="color: black; text-decoration: none"><i class="fas fa-flag"></i>Edit Report</a>
                @else
                    <a href="/report/news/{{ $news->id }}" style="color: black; text-decoration: none"><i class="far fa-flag"></i>Report</a>
                @endif
                &nbsp;

                @if ($news->isBookmarked())
                    <a href="/{{ $news->slug }}/removeBookmark" style="color: black; text-decoration: none"><i class="fas fa-star"></i>Remove from bookmarks</a>
                @else
                    <a href="/{{ $news->slug }}/addBookmark" style="color: black; text-decoration: none"><i class="far fa-star"></i> Add to bookmarks</a>
                @endif
            </h6>

            <h6>
            </h6>
        </div>

        <div id="newsBody" class="my-5">
        </div>

        <hr>

        <form action="/comment/news/{{ $news->id }}" method="post">
            @csrf

            <div class="my-3">
                <label for="body" class="form-label">Post a comment</label>
                <textarea name="body" id="body" class="form-control" rows=8 @if (!Auth::check()) disabled @endif>@if (!Auth::check()) You need to login to be able to post a comment @endif</textarea>
            </div>

            <div class="d-flex" style="gap: 1rem">
                <input type="submit" value="Post Comment" class="btn btn-primary">

                @if (Auth::check() && Auth::user()->type == 'admin')
                    <a class="btn btn-primary" href="/commentManagement/news/{{ $news->id }}">Comment Management</a>
                @endif
            </div>
        </form>

        <hr>

        <h3 class="my-3 text-center">Comments</h3>

        @foreach ($comments as $comment)
            <div class="p-3 rounded-3 shadow my-3">
                <div>
                    <h5>
                        {{ $comment->user->name }}
                        &nbsp;

                        <a href="/report/user/{{ $comment->user->id }}" style="color: black">
                            @if ($comment->user->isReported())
                                <i class="fas fa-flag"></i>
                            @else
                                <i class="far fa-flag"></i>
                            @endif
                        </a>
                    </h5>

                    <h6>{{ $comment->created_at }}</h6>

                    <b>
                        {{ $comment->replyCount() }}

                        <i class="far fa-comments"></i>

                        &nbsp;
                        
                        {{ $comment->likeCount() }}

                        @if ($comment->likedByUser())
                            <a style="color: black" href="/comment/{{ $comment->id }}/removeVote"><i class="fas fa-thumbs-up"></i></a>
                        @else
                            <a style="color: black" href="/comment/{{ $comment->id }}/like"><i class="far fa-thumbs-up"></i></a>
                        @endif

                        &nbsp;

                        {{ $comment->dislikeCount() }}

                        @if ($comment->dislikedByUser())
                            <a style="color: black" href="/comment/{{ $comment->id }}/removeVote"><i class="fas fa-thumbs-down"></i></a>
                        @else
                            <a style="color: black" href="/comment/{{ $comment->id }}/dislike"><i class="far fa-thumbs-down"></i></a>
                        @endif

                        &nbsp;

                        {{ $comment->reportCount() }}

                        <a style="color: black; text-decoration: none" href="/report/comment/{{ $comment->id }}">
                            @if ($comment->isReported())
                                <i class="fas fa-flag"></i> Edit Report
                            @else
                                <i class="far fa-flag"></i> Report
                            @endif
                        </a>
                    </b>
                </div>

                <p class="my-0 mt-3">{{ $comment->body }}</p>

                <br>

                <div class="d-flex">
                    <button class="btn btn-primary me-3" data-bs-toggle="modal" data-bs-target="#replyModal" onclick="showReplyModal({{ $comment->id }})">Reply</button>

                    @if ($comment->replyCount() > 0)
                        <b><a href="/comment/{{ $comment->id }}/replies" class="btn btn-info text-light">Show replies</a></b>
                    @endif

                    @if ($comment->user_id == Auth::id())
                        <a href="/comment/{{ $comment->id }}" class="btn btn-success">Edit</a>
                        
                        <form action="/comment/{{ $comment->id }}" method="post">
                            @csrf
                            @method('DELETE')

                            <input type="submit" value="Delete" class="btn btn-danger">
                        </form>
                    @endif
                </div>

                <div class="d-none" id="comment{{$comment->id}}ReplyBox"></div>
                <div class="d-none" id="comment{{$comment->id}}Replies">
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->

    <div class="text-center">
        @if (!$comments->onFirstPage())
            <a href="{{ $comments->previousPageUrl() }}" class="btn btn-primary">&lt;&lt;</a>
        @endif

        <b class="btn btn-secondary">{{ $comments->currentPage() }}</b>

        @if (!$comments->onLastPage())
            <a href="{{ $comments->nextPageUrl() }}" class="btn btn-primary">&gt;&gt;</a>
        @endif
    </div>

    <script>
        window.onload = function() {
            $('#newsBody')[0].innerHTML = unescape(`{{ $newsBody }}`);
        }

        // Function to show reply modal
        function showReplyModal(commentId) {
            const replyForm = $('#replyForm')[0];

            replyForm.setAttribute('action', '/comment/reply/' + commentId);
        }

        // Function to send reply
        function sendReply() {
            $('#replyForm')[0].submit();
        }
        
        // Function to show replies
        function showReplies(commentId, page) {
            var commentBox = $('#comment' + commentId + 'Replies')[0];
            var replyButton = $('#comment' + commentId + 'ReplyButton')[0];

            $.get('/comment/replies/' + commentId + '?page=' + page, (data) => {
                data['data'].forEach((comment) => {
                    var html = '';

                    html += 
                    `
                        <div class="p-3 rounded-3 shadow my-3">
                            <div>
                                <h5>${comment.name}</h5>
                                <h6>${comment.created_at}</h6>
                            </div>

                            <p class="my-0 mt-3">${comment.body}</p>
                    `

                    if (comment.user_id == {{ Auth::id() }})
                        html += `
                            <a href="/comment/${comment.id}" class="mt-3 btn btn-success">Edit</a>
                        `;

                    html += `</div>`

                    commentBox.innerHTML += html;
                });

                // Show comment box for replies
                commentBox.classList.remove('d-none');

                // Remove previous show reply / show more replies buttons
                var remove = $('#comment' + commentId + 'ReplyButton')[0];

                while (remove != null) {
                    remove.remove();
                    remove = $('#comment' + commentId + 'ReplyButton')[0];
                }

                // Add show more replies button if necessary at the end of the replies box
                if (data.current_page < data.last_page) {
                    commentBox.innerHTML += `
                        <a class="btn btn-primary" href="#${replyButton.id}" id="${replyButton.id}" onclick="showReplies(${commentId}, ${page + 1})">Bau</a>
                    `;
                }
            });
        }
    </script>
@endsection