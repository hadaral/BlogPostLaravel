<div class="mb-2 mt-2">
@auth
    <form method="POST" action="{{ $route }}">
        @csrf
        
        <div class="form-group">
            <textarea type="text" class="form-control" name="content"></textarea>
        </div>

        <button type="submit" class="btn btn-primary w-100 mt-2">{{ __('Add comment') }}</button>
    </form>
    @errors
    @enderrors
@else
    <a href="{{ route('login') }}">{{ __('Sign-in') }}</a>  {{ __('to post comments!') }}
@endauth
</div>
<hr/>