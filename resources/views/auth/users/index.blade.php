@extends('home')

@section('articles')
    @can('list-users')
        <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
        <x-page-header title="Manage Users" :back="route('settings.index')">
            @can('create-users')
                <a class="btn btn-warning" href="{{ route('users.create') }}">Create User</a>
            @endcan
        </x-page-header>
        <div class="rightside">
            <div id="contact-form">

                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif
                @if ($message = Session::get('fail'))
                    <div class="alert alert-danger">
                        <p>{{ $message }}</p>
                    </div>
                @endif
                <div id="conts">
                    <div id="req" class="req">
                        <table class="reqs">
                            <thead>

                                <tr>
                                    <th>Name</th>
                                    <th>email</th>
                                    <th>Role</th>
                                    <th>created at</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key => $user)
                                    <tr data-id="{{ $user->id }}">
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if (!empty($user->getRoleNames()))
                                                @foreach ($user->getRoleNames() as $v)
                                                    <label class="badge badge-success">{{ $v }}</label>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>{{ $user->created_at }}</td>
                                        <td>
                                            @can('delete-users')
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id], 'id' => 'delete-user-' . $user->id, 'style' => 'display:none']) !!}
                                                {!! Form::close() !!}
                                                <span title="Delete" class="editing fa fa-trash"
                                                    onclick="Sawtru.confirmDelete('{{ $user->name }}', function () { document.getElementById('delete-user-{{ $user->id }}').submit(); })"></span>
                                            @endcan
                                            @can('list-users')
                                                <span title="View" class="editing fa fa-eye"
                                                    onclick="Sawtru.viewInModal('/dashboard/users/{{ $user->id }}', 'User Details')"></span>
                                            @endcan
                                            @can('edit-users')
                                                <span title="Edit" class="editing fa fa-edit"
                                                    onclick="location.href ='/dashboard/users/{{ $user->id }}/edit'"></span>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <center>
            {{ $data->links('pagination::bootstrap-5') }}
        </center>

    @else
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h4>
                        Not Allowed !
                    </h4>
                </div>
            </div>
        </div>
    @endcan
@endsection
