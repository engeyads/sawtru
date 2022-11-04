@extends('home')


@section('articles')
    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
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
    {{-- last phases --}}
    <div class="contact-form">
        <div class="rightside">
            <table>
                <tr>
                    <td style="font-size:23px;">
                        <a href="{{ route('profile') }}">
                            <i class="fa fa-user" style="font-size:82px;"></i><br />
                            Profile
                        </a>
                    </td>
                    @can('list-users')
                        <td style="font-size:23px;">
                            <a href="{{ route('users.index') }}">
                                <i class="fa fa-plus" style="font-size:82px;"></i><br />
                                Users
                            </a>
                        </td>
                    @endcan
                    @can('list-role')
                        <td style="font-size:23px;">
                            <a href="{{ route('roles.index') }}">
                                <i class="fa fa-lock" style="font-size:82px;"></i><br />
                                Roles
                            </a>
                        </td>
                    @endcan
                </tr>
            </table>
        </div>
    </div>
@endsection
