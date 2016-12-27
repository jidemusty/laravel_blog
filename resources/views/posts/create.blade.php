@extends('main')

@section('title', '| Create New Post')

@section('stylesheets')

    {!! Html::style('css/parsley.css') !!}
    {!! Html::style('css/select2.min.css') !!}
    <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
    {{--{!! Html::script('js/tinymce.min.js') !!}--}}

    <script>
        tinymce.init({
            selector:'textarea',
            plugins: 'link code imagetools',
        });
    </script>

@endsection

@section('content')

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>Create New Post</h1>
            <hr>

            {!! Form::open(['route' => 'posts.store', 'data-parsley-validate' => '', 'files' => 'true']) !!}
                {{ Form::label('title', 'Title:') }}
                {{ Form::text('title', null, array('class' => 'form-control', 'required' => '', 'maxlength' => "255", 'style' => 'margin-bottom: 15px;')) }}

                {{ Form::label('slug', 'Slug:') }}
                {{ Form::text('slug', null, array('class' => 'form-control', 'required' => '', 'minlenght' => '5', 'maxlenght' => '255', 'style' => 'margin-bottom: 15px;')) }}

                {{ Form::label('category_id', 'Category:') }}
                <select class="form-control" name="category_id" style="margin-bottom: 15px;" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>

                {{ Form::label('tag', 'Tags:') }}
                <select class="form-control select2-multi" name="tags[]" multiple="multiple" style="margin-bottom: 15px;" required>
                    @foreach($tags as $tag)
                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                    @endforeach
                </select>

                {{ Form::label('featured_image', 'Upload featured Image', ['style' => 'margin-top: 15px;']) }}
                {{ Form::file('featured_image') }}

                {{ Form::label('body', "Post Body:", ['style' => 'margin-top: 15px;']) }}
                {{ Form::textarea('body', null, array('class' => 'form-control')) }}

                {{ Form::submit('Create Post', array('class' => 'btn btn-success btn-lg btn-block', 'style' => 'margin-top: 15px;')) }}
            {!! Form::close() !!}
        </div>
    </div>

@endsection

@section('scripts')

    {!! Html::script('js/parsley.min.js') !!}
    {!! Html::script('js/select2.min.js') !!}

    <script type="text/javascript">
        $('.select2-multi').select2();
    </script>

@endsection

