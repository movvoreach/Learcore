<div class="course-comment-list course-workspace-comment-list" data-discussion-list>
    @forelse($discussionPosts as $discussionPost)
        <article class="course-comment">
            <img src="{{ $discussionPost->author?->avatar ? \Illuminate\Support\Facades\Storage::disk('public')->url($discussionPost->author->avatar) : asset('backend/dist/img/avatar.png') }}" alt="">
            <div>
                <strong>{{ $discussionPost->author?->name ?? 'Deleted user' }}</strong>
                <small>{{ $discussionPost->created_at?->diffForHumans() }}</small>
                <p>{{ $discussionPost->body }}</p>
                @if($discussionPost->image_path)
                    <img class="course-discussion-post-image" src="{{ asset('storage/'.$discussionPost->image_path) }}" alt="Discussion image">
                @endif
                <div class="course-discussion-actions">
                    @auth
                        <button
                            type="button"
                            class="course-discussion-react js-discussion-reaction @if($discussionPost->reacted_by_current_user) is-reacted @endif"
                            data-action="{{ route('frontend.discussion.posts.reaction', $discussionPost) }}"
                            aria-pressed="{{ $discussionPost->reacted_by_current_user ? 'true' : 'false' }}"
                        >
                            <i class="fas fa-heart"></i>
                            <span>{{ $discussionPost->reacted_by_current_user ? 'Liked' : 'Like' }}</span>
                            <strong>{{ $discussionPost->reactions_count ?? 0 }}</strong>
                        </button>
                    @else
                        <span class="course-discussion-reaction-count">
                            <i class="fas fa-heart"></i>
                            {{ $discussionPost->reactions_count ?? 0 }}
                        </span>
                    @endauth
                </div>
                <div class="course-discussion-replies">
                    @foreach($discussionPost->publishedComments as $discussionComment)
                        <article class="course-discussion-reply">
                            <img src="{{ $discussionComment->author?->avatar ? \Illuminate\Support\Facades\Storage::disk('public')->url($discussionComment->author->avatar) : asset('backend/dist/img/avatar.png') }}" alt="">
                            <div>
                                <strong>{{ $discussionComment->author?->name ?? 'Deleted user' }}</strong>
                                <small>{{ $discussionComment->created_at?->diffForHumans() }}</small>
                                <p>{{ $discussionComment->body }}</p>
                                @if($discussionComment->image_path)
                                    <img class="course-discussion-post-image" src="{{ asset('storage/'.$discussionComment->image_path) }}" alt="Reply image">
                                @endif
                                <div class="course-discussion-actions">
                                    @auth
                                        <button
                                            type="button"
                                            class="course-discussion-react js-discussion-reaction @if($discussionComment->reacted_by_current_user) is-reacted @endif"
                                            data-action="{{ route('frontend.discussion.comments.reaction', $discussionComment) }}"
                                            aria-pressed="{{ $discussionComment->reacted_by_current_user ? 'true' : 'false' }}"
                                        >
                                            <i class="fas fa-heart"></i>
                                            <span>{{ $discussionComment->reacted_by_current_user ? 'Liked' : 'Like' }}</span>
                                            <strong>{{ $discussionComment->reactions_count ?? 0 }}</strong>
                                        </button>
                                    @else
                                        <span class="course-discussion-reaction-count">
                                            <i class="fas fa-heart"></i>
                                            {{ $discussionComment->reactions_count ?? 0 }}
                                        </span>
                                    @endauth
                                </div>
                            </div>
                        </article>
                    @endforeach

                    @auth
                        <form class="course-discussion-reply-form js-discussion-form" method="POST" action="{{ route('frontend.discussion.comments.store', $discussionPost) }}" enctype="multipart/form-data" data-no-loading>
                            @csrf
                            <textarea name="body" rows="2" placeholder="Write a reply..." required></textarea>
                            <label class="course-discussion-image">
                                <i class="fas fa-image"></i>
                                <span>Image</span>
                                <input type="file" name="image" accept="image/*">
                            </label>
                            <button type="submit">Reply</button>
                            <small class="course-discussion-error js-discussion-error" hidden></small>
                        </form>
                    @endauth
                </div>
            </div>
        </article>
    @empty
        <div class="course-discussion-empty">
            No discussion posts yet.
        </div>
    @endforelse
</div>
