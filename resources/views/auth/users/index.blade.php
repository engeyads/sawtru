@extends('home')

@section('articles')
    @can('list-users')
        <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
        <div class="rightside">
            <div id="contact-form">
                <div>

                </div>
                <div>
                    <div>
                        <div>
                            <a class="btn btn-warning" href="{{ route('settings.index') }}"><i class="fa fa-arrow-left"></i>
                                Back</a>
                        </div>
                        <div>
                            <h2>Manage Users</h2>
                        </div>
                    </div>
                </div>
                <div>
                    @can('create-users')
                        <a class="btn btn-warning" href="{{ route('users.create') }}">Create User</a>
                    @endcan
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
                                                <span title="Delete Project" class="editing fa fa-trash"
                                                    onclick="deleteRec({{ $user->id }})"></span>
                                            @endcan
                                            @can('list-users')
                                                <span title="Edit" class="editing fa fa-eye"
                                                    onclick="location.href ='/dashboard/users/{{ $user->id }}'"></span>
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

        @push('custom-scripts')
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <script>
                function deleteRec(num) {
                    if (confirm("Are you sure you want to delete it? " + num)) {
                        $.ajax({
                            type: 'delete',
                            url: "/dashboard/users/" + num,
                            data: {
                                '_token': $("meta[name='csrf-token']").attr("content"),
                                'id': num,
                            },
                            success: function(data) {
                                $("#msg").html(data.msg);
                            }
                        });
                    } else {
                        return false;
                    }
                }
            </script>
        @endpush
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
