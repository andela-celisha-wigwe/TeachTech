<div class="form-group">
    <label for="title">Title:</label>
    <input class="form-control" name="title" type="text" id="title">
</div>
<div class="form-group">
    <label for="url">URL:</label>
    <input class="form-control" name="url" type="url" id="url">
</div>
<div class="form-group">
    <label for="title">Description:</label>
    <textarea class="form-control new-video-description" placeholder="Briefly describe the video" name="description" cols="50" rows="10">
    </textarea>
</div>
<div class="form-group">
    <select class="form-control new-video-category" name="category_id">
        @foreach(TeachTech\Category::all() as $category)
            <option class="new-video-category" id="cat-{{ $category->id }}" value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select>
</div>