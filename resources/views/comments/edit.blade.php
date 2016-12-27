@extends('main')

@section('title', '| Edit Comment')

@section('content')

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
        <h1>Edit Comment</h1>

    {{ Form::model($comment, ['route' => ['comments.update', $comment->id], 'method' => 'PUT']) }}

        {{ Form::label('name', 'Name:') }}
        {{ Form::text('name', null, ['class' => 'form-control', 'disabled' => 'disabled', 'style' => 'margin-bottom: 15px;']) }}

    `   {{ Form::label('email', 'Email:') }}
        {{ Form::email('email', null, ['class' => 'form-control', 'disabled' => 'disabled', 'style' => 'margin-bottom: 15px;']) }}

        {{ Form::label('comment', 'Comment:') }}
        {{ Form::textarea('comment', null, ['class' => 'form-control']) }}

        {{ Form::submit('Update comment', ['class' => 'btn btn-block btn-success', 'style' => 'margin-top: 15px;']) }}

    {{ Form::close() }}

        </div>
    </div>

@endsection