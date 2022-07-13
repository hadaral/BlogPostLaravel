<div class="form-group">
    <label for="title">Title</label>
    <input type="text" name="title" class="form-control"
        value="{{old('title',optional($post ?? null)->title)}}">
</div>

@error('title')
    <div class="alert alert-danger">{{$message}}</div>
@enderror

<div class="form-group">
    <label for="content">Content</label>
    <textarea id="content" class="form-control" name="content">{{old('content',optional($post ?? null)->content)}}</textarea>
</div>

<div class="form-group">
    <label style= "display:inline-block; width:100px">Thumbnail</label>
    <input type="file" name="thumbnail" class="form-control-file"/>
</div>

@errors
@enderrors