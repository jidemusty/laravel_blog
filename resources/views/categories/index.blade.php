@extends('main')

@section('title', '| All Categories')

@section('content')

    <div class="row">
        <div class="col-md-8">
            <h1>Categories</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Created At</th>
                        <th colspan="2" class="text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($Categories as $category)
                        <tr>
                            <th>{{ $category->id }}</th>
                            <td>{{ $category->name }}</td>
                            <td>{{ date('M j, Y', strtotime($category->created_at)) }}</td>
                            <td><a href="{{ route('categories.edit', $category->id) }}" class="btn btn-default btn-sm">Edit</a></td>
                            <td>
                                {!! Form::open(['route' => ['categories.destroy', $category->id], 'method' => 'DELETE']) !!}

                                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}

                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="col-md-3">
            <div class="well">
                {!! Form::open(['route' => 'categories.store', 'method' => 'POST']) !!}
                    <h2>New Category</h2>
                    {{ Form::label('name', 'Name:') }}
                    {{ Form::text('name', null, ['class' => 'form-control']) }}

                    {{ Form::submit('Create New Category', ['class' => 'btn btn-primary btn-block btn-h1-spacing']) }}
            </div>
        </div>
    </div>

@endsection