@extends('main')

@section('title', '| Login')

@section('content')

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            {!! Form::open() !!}

                {{ Form::label('email', 'Email:') }}
                {{ Form::email('email', null, ['class' => 'form-control']) }}

                {{ Form::label('password', 'Password:') }}
                {{ Form::password('password', ['class' => 'form-control']) }}

                <br>
                {{ Form::checkbox('remember') }}&nbsp;{{ Form::label('remember', 'Remember Me:') }}

                {{ Form::submit('Login', ['class' => 'btn btn-primary btn-block form-spacing-top']) }}

                <p><a href="{{ url('password/reset') }}">Forgot My Password</a></p>

            {!! Form::close() !!}
        </div>
    </div>

@endsection