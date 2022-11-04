@extends('home')

@section('articles')
    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
    <div class="rightside">
        <div id="contact-form">
            <form action="{{ route('updateProfile') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name"><strong>Name:</strong></label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}">
                </div>
                <div class="form-group">
                    <label for="email"><strong>Email:</strong></label>
                    <input type="text" class="form-control" id="email" value="{{ Auth::user()->email }}" name="email">
                </div>
                <div class="form-group">
                    <label for="iscolor"><strong>display background as:</strong></label>
                    <select name="isColor" id="isColor">
                        <option value="1" selected>Background Image</option>
                        <option value="2">Solid Color</option>
                    </select>
                </div>
                <div id="imgs" class="form-group">
                    <label for="bgimage"><strong>Background:</strong></label>
                    <img src="{{ URL::asset('uploads/'.Auth::user()->background) }}" alt="">
                    <input type="file" accepts="img/jpg" class="form-control" id="bgimage" name="background">
                </div>
                <div id="clrs" class="form-group">
                    <label for="bgcolor"><strong>Color:</strong></label>
                    <input type="color" class="form-control" id="bgcolor" value="{{ Auth::user()->color }}" name="color">
                </div>
                <button class="btn btn-primary" type="submit">Update Profile</button>
            </form>
            @push('custom-scripts')
                <script>
                    $('#clrs').hide();
                    $('#isColor').on('change',function(){
                        if($(this).val() == 1){
                            $('#imgs').show();
                            $('#clrs').hide();
                        }else{
                            $('#imgs').hide();
                            $('#clrs').show();
                        }
                    });
                </script>
            @endpush
        </div>
    </div>
@endsection
