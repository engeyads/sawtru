@extends('home')


@section('articles')
    @can('list-role')

        <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
        <x-page-header title="Manage Roles" :back="route('settings.index')">
            @can('create-role')
                <a class="btn btn-warning" href="{{ route('roles.create') }}">Create Role</a>
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
                                    <th>No</th>
                                    <th>Name</th>
                                    <th width="280px">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($roles as $key => $role)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            @can('delete-role')
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $role->id], 'id' => 'delete-role-' . $role->id, 'style' => 'display:none']) !!}
                                                {!! Form::close() !!}
                                                <button type="button" title="Delete" class='editing fa fa-trash'
                                                    onclick="Sawtru.confirmDelete('{{ $role->name }}', function () { document.getElementById('delete-role-{{ $role->id }}').submit(); })"></button>
                                            @endcan
                                            <button type="button" title="View" class="editing fa fa-eye"
                                                onclick="Sawtru.viewInModal('{{ route('roles.show', $role->id) }}', 'Role Details')"></button>
                                            @can('edit-role')
                                                <a class="editing fa fa-edit" href="{{ route('roles.edit', $role->id) }}"></a>
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
        {!! $roles->render() !!}
    @else
        <div>
            <h2>
                Access Denied!
            </h2>
        </div>
    @endcan
@endsection
