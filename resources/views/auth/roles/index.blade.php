@extends('home')


@section('articles')
    @can('list-role')

        <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
        <div class="rightside">
            <div id="contact-form">
                <div>

                </div>
                <div>
                    <div>
                        <div>
                            <div>
                                <div>
                                    <a class="btn btn-warning" href="{{ route('settings.index') }}"><i
                                            class="fa fa-arrow-left"></i>
                                        Back</a>
                                </div>
                                <div>
                                    <h2>Manage Roles</h2>
                                </div>
                            </div>
                        </div>
                        @can('create-role')
                        <div>
                            <a class="btn btn-warning" href="{{ route('roles.create') }}">
                                Create Role</a>
                        </div>
                        @endcan
                    </div>
                </div>
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
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $role->id], 'style' => 'display:inline']) !!}
                                                <button class='editing fa fa-trash'></button>
                                                {!! Form::close() !!}
                                            @endcan
                                            <a class="editing fa fa-eye" href="{{ route('roles.show', $role->id) }}"></a>
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
