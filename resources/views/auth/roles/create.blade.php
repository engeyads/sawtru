@extends('home')


@section('articles')
    @can('create-role')

    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">

    <div class="role-form">
        <div class="role-head">
            <h2>Create New Role</h2>
            <a class="btn btn-warning" href="{{ route('roles.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
        </div>

        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {!! Form::open(['route' => 'roles.store', 'method' => 'POST']) !!}

            <div class="form-group">
                <label class="field-label" for="name">Name</label>
                {!! Form::text('name', null, ['id' => 'name', 'placeholder' => 'Role name', 'class' => 'form-control']) !!}
            </div>

            <div class="perm-toolbar">
                <span class="field-label">Permissions</span>
                <label class="perm-selectall">
                    <input type="checkbox" id="checkAll">
                    Select all
                </label>
            </div>

            @include('auth.roles._permissions', ['selected' => []])

            <div class="form-actions">
                <button type="submit" class="btn-submit">Create role</button>
            </div>

        {!! Form::close() !!}
    </div>

    @push('custom-scripts')
        <script>
            $("#checkAll").on('change', function () {
                $('.perm-item input[type=checkbox]').prop('checked', this.checked);
            });
        </script>
    @endpush

    @else
        <div><h2>You cannot create new roles...</h2></div>
    @endcan
@endsection
