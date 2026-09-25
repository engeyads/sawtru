@extends('home')


@section('articles')
    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
    <x-page-header title="Settings" :back="route('home')"></x-page-header>
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="settings-menu">
        <a href="{{ route('profile') }}" class="settings-card">
            <i class="fa fa-user"></i>
            <span>Profile</span>
        </a>
        @can('list-users')
            <a href="{{ route('users.index') }}" class="settings-card">
                <i class="fa fa-plus"></i>
                <span>Users</span>
            </a>
        @endcan
        @can('list-role')
            <a href="{{ route('roles.index') }}" class="settings-card">
                <i class="fa fa-lock"></i>
                <span>Roles</span>
            </a>
        @endcan
    </div>
@endsection
