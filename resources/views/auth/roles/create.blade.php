@extends('home')


@section('articles')
<link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
@can('create-role')

<div class="rightside">
    <div class="contact-form" id="contact-form">
            <div>
                <div>
                    <div>
                        <a class="btn btn-warning" href="{{ route('roles.index') }}"><i class="fa fa-arrow-left"></i>
                            Back</a>
                    </div>
                    <div>
                        <h2>Create New Role</h2>
                    </div>

                </div>
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

            <div id="conts">
                <div id="req" class="req">



{!! Form::open(array('route' => 'roles.store','method'=>'POST')) !!}
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Name:</strong>
            {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Permission:</strong>
            <br/>

            <label class="chklabel">
                <input type="checkbox" class="cdusd" id="checkAll" > <span style="margin-top: -10px">Toggle All</span>
                <span class="check-box-effect" ></span>
            </label>
            <br/>
            @foreach($permission as $value)
            <label class="chklabel">

                <input type="checkbox" class="cdusd"
                    name="permission[]" value="{{$value->id}}">{{$value->name}}
                <span class="check-box-effect"></span>
            </label>

            <br/>
            @endforeach
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>
@push('custom-scripts')
    <script >
        $("#checkAll").click(function(){
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>
@endpush
{!! Form::close() !!}


                </div>
            </div>
@else
<div>
    <h2>
        You Cannot Create New Role...
    </h2>
</div>
@endcan
@endsection
