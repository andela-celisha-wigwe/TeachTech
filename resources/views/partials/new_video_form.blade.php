    <div class="form-group">
        {!! Form::label('title', 'Title:') !!}
        {!! Form::text('title', old('title'), ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('url', 'URL:') !!}
        {!! Form::url('url', old('url'), ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('title', 'Description:') !!}
        {!! Form::textarea('description', old('description'), ['class' => 'form-control new-video-description', 'placeholder' => 'Briefly describe the video']) !!}
    </div>
    <div class="form-group">
        <select class="form-control new-video-category" name="category_id">
            @foreach(TeachTech\Category::all() as $category)
                <option class="new-video-category" id="cat-{{ $category->id }}" value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>