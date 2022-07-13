<div class="mb-2 mt-2">
@auth
    <form method="POST" action="{{ route('posts.comments.store',['post' => $post->id]) }}">
        @csrf
        
        <div class="form-group">
            <textarea type="text" class="form-control" name="content"></textarea>
        </div>

        <button type="submit" class="btn btn-primary w-100 mt-2">Add Comment</button>
    </form>
    @errors
    @enderrors
@else
    <a href="{{ route('login') }}">Sign-in</a>  to post comment!
@endauth
</div>
<hr/>