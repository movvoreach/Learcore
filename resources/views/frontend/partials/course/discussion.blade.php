@php
    $currentUser = auth()->user();
    $avatar = $currentUser?->avatar
        ? \Illuminate\Support\Facades\Storage::disk('public')->url($currentUser->avatar)
        : asset('backend/dist/img/avatar.png');
@endphp

<section class="course-workspace-discussion" id="discussion">
    <div class="course-workspace-discussion-head">
        <span>Discussion</span>
        <strong>{{ $currentUser?->name ?? 'Student' }}</strong>
    </div>

    @auth
        <form class="course-workspace-comment-form js-discussion-form" method="POST" action="{{ $discussionAction }}" enctype="multipart/form-data" data-no-loading>
            @csrf
            <img src="{{ $avatar }}" alt="">
            <div>
                <textarea name="body" rows="4" placeholder="Write a comment or question..." required>{{ old('body') }}</textarea>
                @error('body')
                    <small class="course-discussion-error">{{ $message }}</small>
                @enderror
                <label class="course-discussion-image">
                    <i class="fas fa-image"></i>
                    <span>Add image</span>
                    <input type="file" name="image" accept="image/*">
                </label>
                @error('image')
                    <small class="course-discussion-error">{{ $message }}</small>
                @enderror
                <button type="submit">
                    Post comment
                    <i class="fas fa-paper-plane"></i>
                </button>
                <small class="course-discussion-error js-discussion-error" hidden></small>
            </div>
        </form>
    @else
        <div class="course-discussion-login">
            <a href="{{ route('login') }}">Login to join the discussion.</a>
        </div>
    @endauth

    @include('frontend.partials.course.discussion-list', ['discussionPosts' => $discussionPosts])
</section>

@once
    @push('scripts')
        <script>
            $(function() {
                $(document).on('submit', '.js-discussion-form', function(event) {
                    event.preventDefault();

                    const $form = $(this);
                    const $button = $form.find('button[type="submit"]').first();
                    const $error = $form.find('.js-discussion-error').first();
                    const formData = new FormData(this);
                    const defaultButtonHtml = $button.html();

                    $error.prop('hidden', true).text('');
                    $button.prop('disabled', true).html('Posting...');

                    $.ajax({
                        url: $form.attr('action'),
                        method: $form.attr('method') || 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            Accept: 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        success(response) {
                            if (response.html) {
                                $('[data-discussion-list]').replaceWith(response.html);
                                $('[data-discussion-list] .course-comment:first').hide().slideDown(180);
                            }

                            $form[0].reset();
                        },
                        error(xhr) {
                            const errors = xhr.responseJSON?.errors || {};
                            const message = errors.body?.[0]
                                || errors.image?.[0]
                                || xhr.responseJSON?.message
                                || 'Could not post right now. Please try again.';

                            $error.text(message).prop('hidden', false);
                        },
                        complete() {
                            $button.prop('disabled', false).html(defaultButtonHtml);
                        },
                    });
                });

                $(document).on('click', '.js-discussion-reaction', function() {
                    const $button = $(this);

                    if ($button.prop('disabled')) {
                        return;
                    }

                    $button.prop('disabled', true).addClass('is-pulsing');

                    $.ajax({
                        url: $button.data('action'),
                        method: 'POST',
                        headers: {
                            Accept: 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        success(response) {
                            if (response.html) {
                                $('[data-discussion-list]').replaceWith(response.html);
                            }
                        },
                        complete() {
                            $button.prop('disabled', false).removeClass('is-pulsing');
                        },
                    });
                });
            });
        </script>
    @endpush
@endonce
