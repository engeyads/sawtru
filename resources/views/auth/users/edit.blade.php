@extends('home')


@section('articles')
@can('edit-users')

    <style>
        .user-form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px 24px;
        }
        .user-form-grid .form-group { margin: 0; }
        .user-form-grid .full { grid-column: 1 / -1; }
        .user-form-grid .form-control,
        .user-form-grid select { width: 100%; }
        @media screen and (max-width: 767px) {
            .user-form-grid { grid-template-columns: 1fr; }
        }
    </style>

    <x-page-header title="Edit User" :back="route('users.index')"></x-page-header>

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

    {!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id]]) !!}
    <div class="user-form-grid">
        <div class="form-group">
            <strong>Name:</strong>
            {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
        </div>
        <div class="form-group">
            <strong>Email:</strong>
            {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
        </div>
        <div class="form-group">
            <strong>Password:</strong>
            {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
        </div>
        <div class="form-group">
            <strong>Confirm Password:</strong>
            {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
        </div>
        <div class="form-group full">
            <strong>Role:</strong>
            <x-role-select :roles="$roles" :selected="$userRole" />
        </div>
        <div class="full" style="display:flex;justify-content:flex-end;margin-top:10px;">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
    {!! Form::close() !!}

@else
    <h4>Not Allowed !</h4>
@endcan
@endsection
