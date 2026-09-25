@extends('home')

@section('articles')
    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
    <style>
        .profile-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px 24px;
        }
        .profile-grid .form-group { margin: 0; }
        .profile-grid .full { grid-column: 1 / -1; }
        .profile-grid .form-control { width: 100%; }
        @media screen and (max-width: 767px) {
            .profile-grid { grid-template-columns: 1fr; }
        }
    </style>

    <x-page-header title="My Profile" :back="route('home')"></x-page-header>
    <div class="rightside">
        <div id="contact-form">
            <form action="{{ route('updateProfile') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="profile-grid">
                    <div class="form-group">
                        <label for="name"><strong>Name:</strong></label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}">
                    </div>
                    <div class="form-group">
                        <label for="email"><strong>Email:</strong></label>
                        <input type="text" class="form-control" id="email" value="{{ Auth::user()->email }}" name="email">
                    </div>
                    <div class="full" style="display:flex;justify-content:flex-end;margin-top:10px;">
                        <button class="btn btn-primary" type="submit">Update Profile</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
