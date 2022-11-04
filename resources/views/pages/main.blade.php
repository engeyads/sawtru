@extends('home')

@section('articles')
    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">

    <style>


        ul.progress_bar{
            max-width: 39em;
            width: 100%;
            padding: 0 18px;
            height: 2em;
            margin: 0;
            padding: 0;
            font-size: 10px; /* change font size only to scale*/
        }

        ul.progress_bar li{
            width: 25%;
            float: left;
            height: 100%;
            list-style: none;
            position: relative;
            margin: 0;
            padding: 0;
        }

        ul.progress_bar li span{
            position: absolute;
            display: block;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            margin: auto;
            background: #dfbd01;
            height: .4em;
            z-index: 1;
        }

        ul.progress_bar li.activated:before{
            background: #fff;
            border: 0.3em solid #dfbd01;
            box-sizing: border-box;
        }

        ul.progress_bar li:before{
            content: '';
            display: block;
            position: absolute;
            left: 0;
            top: 0;
            background: #dfbd01;
            width: 2em;
            height: 2em;
            border-radius: 2em;
            z-index: 2;
        }

        /*ul.progress_bar li.new :after{
            content: 'New';
            margin-top: 10px;
            color:#fff;
            z-index:3;
        }
        ul.progress_bar li.assembling :after{
            content: 'Assembling';
            margin-top: 10px;
            color:#fff;
            z-index:3;
        }
        ul.progress_bar li.po :after{
            content: 'Purchases';
            margin-top: 10px;
            color:#fff;
            z-index:3;
        }
        ul.progress_bar li.done :after{
            content: 'Done';
            padding-top: 10px;
            color:#fff;
            z-index:3;
        }*/
    </style>
    <div class="rightside">
        <div id="contact-form">
            <div>

            </div>
            <div>
                <div>
                    <div>
                        <h2>Projects</h2>
                    </div>
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
                                <th>pname</th>
                                <th>user id</th>
                                <th>created at</th>
                                <th>status</th>
                                <th>remaining</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($projects as $key => $data)
                                <tr>
                                    <td>{{ $data->pname }}</td>
                                    <td>{{ $data->user->name }}</td>
                                    <td>{{ $data->created_at }}</td>
                                    {{-- this will show phase of project or status --}}

                                    <td>
                                        <center>
                                            <div>
                                                <label>
                                                    @if($data->phase == 0) New @endif
                                                    @if($data->phase == 1) Assembling @endif
                                                    @if($data->phase == 2) Purchases @endif
                                                    @if($data->phase == 100) Done @endif
                                                </label>
                                            </div>
                                        </center>
                                        <ul class="progress_bar">
                                            <li class='new @if($data->phase == 0) activated @endif'><span></span></li>
                                            <li class='assembling @if($data->phase == 1) activated @endif'><span></span></li>
                                            <li class='po @if($data->phase == 2) activated @endif'><span></span></li>
                                            <li class='done @if($data->phase == 100) activated @endif'></li>
                                        </ul>
                                    </td>
                                    <td>
                                        {{-- this will get remaining days for projects --}}
                                        @if ($data->isApproved == 1)
                                            {{-- if project is approved by admin --}}
                                            <input type="hidden" name="remaining"
                                                value="{{ $remain = intval(abs(strtotime($data->due_time) - strtotime(date('Y-m-d'))) / 86400) }}">
                                            <span class="{{ $remain > 0 && $remain < 3 ? 'new' : '' }}">{{ $remain }}
                                                days</span>
                                        @elseif ($data->isApproved == -1)
                                            <span class="fail">finished!</span>
                                        @else
                                            <span
                                                class="{{ intval(abs(strtotime($data->created_at) - strtotime(date('Y-m-d'))) / 86400) > 0 && intval(abs(strtotime($data->created_at) - strtotime(date('Y-m-d'))) / 86400) < 3 ? 'new' : '' }}">{{ $data->daysneed }}
                                                days</span>
                                        @endif

                                    </td>
                                    <td>
                                        <div style="display:inline-flex">
                                            @can('delete-projects')
                                                <button type="submit"
                                                    onclick="deleteRec({{ $data->id }},'{{ $data->pname }}')"
                                                    class="editing fa fa-trash"></button>
                                            @endcan
                                            @can('edit-projects')
                                                <span title="View Project" class="editing fa fa-eye"
                                                    onclick="location.href = '/dashboard/projects/{{ $data->id }}';"></span>
                                            @endcan
                                            <button id="printpdf{{ $data->id }}" class="editing printpdf fa fa-file-pdf-o"></button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <center>
                        {{ $projects->links('pagination::bootstrap-5') }}
                    </center>


            </div>


        </div>
    </div>

@endsection
