@extends('main')

@section('title', '| Edit Tag')

@section('content')

    <div class="row">
        <div class="col-md-4">
            {{ Form::model($tag, ['route' => ['tags.update', $tag->id], 'method' => 'PUT']) }}

                {{ Form::label('name', 'Title:') }}
                {{ Form::text('name', null, ['class' => 'form-control']) }}

                {{ Form::submit('Save Changes', ['class' => 'btn btn-success', 'style' => 'margin-top: 20px;']) }}

            {{ Form::close() }}
        </div>
    </div>


@endsection