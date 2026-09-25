@extends('home')


@section('articles')
    @can('edit-role')

    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">

    <div class="role-form">
        <div class="role-head">
            <h2>Edit Role</h2>
            <a class="btn btn-primary" href="{{ route('roles.index') }}">Back</a>
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

        {!! Form::model($role, ['method' => 'PATCH', 'route' => ['roles.update', $role->id]]) !!}

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

            @include('auth.roles._permissions', ['selected' => $rolePermissions])

            <div class="form-actions">
                <button type="submit" class="btn-submit">Save changes</button>
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
        <div><h2>You are not able to edit roles...</h2></div>
    @endcan
@endsection
