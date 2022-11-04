@extends('home')

@section('articles')
    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
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

            @can('list-project')
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
                                        <td>{{ $data->phase == 0 ? 'New Reuqest' : ($data->phase == 1 ? 'Assembling Phase' : ($data->phase == 2 ? 'PO' : ($data->phase == 100 ? 'Success' : ($data->phase == -1 ? 'Failed' : 'Refused by Admin')))) }}
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

                @push('custom-scripts')
                    <script>
                        function deleteRec(num, nm) {
                            if (confirm("Are you sure you want to delete '" + nm + "' ?")) {
                                $.ajax({
                                    type: 'delete',
                                    url: "/dashboard/projects/" + num,
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


                        $('.printpdf').on('click',function(evt){

                            PDFDownload($(this).attr('id').toString().replace( /^\D+/g, ''));
                        });

                        function PDFDownload(num) {
                            $.get({
                                type: 'post',
                                url: "/dashboard/projects/"+num,
                                data: {
                                    '_token' : $("meta[name='csrf-token']").attr("content"),
                                    'id' : num,
                                },
                                success: function(data) {
                                    data = JSON.parse(data);
                                    console.log(data.project);
                                    var doc = new jsPDF();
                                    var specialElementHandlers = {
                                        '#editor': function(element, renderer) {
                                            return true;
                                        }
                                    };
                                    let htmlitems = "<header><table><tr><td><label >Serial No: " + data.project.serial_no + "</label></td><td>Date: " + Date.now() + "</td></tr></table></header>";
                                    doc.fromHTML(htmlitems, 15, 15, {
                                        'width': 170,
                                        'elementHandlers': specialElementHandlers
                                    });
                                    doc.save('sample-file.pdf');
                                }
                            });

                        }
                    </script>
                @endpush
            @elsecan('list-self-project')
                <div id="conts">
                    <div id="req" class="req">
                        <table class="reqs">
                            <thead>
                                <tr>
                                    <th>pname</th>
                                    <th>user id</th>
                                    <th>created at</th>
                                    <th>status</th>
                                    <th>Phase</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projects as $key => $data)
                                    <tr>
                                        <td>{{ $data->pname }}</td>
                                        <td>{{ $data->user->name }}</td>
                                        <td>{{ $data->created_at }}</td>
                                        <td>
                                            @if ($data->isApproved == 0)
                                                waiting for Confirmation
                                            @elseif ($data->isApproved == 1)
                                                Confirmed!
                                            @else
                                                Refused!
                                            @endif
                                        </td>
                                        <td>
                                            @switch($data->phase)
                                                @case(0)
                                                    New Reuqest
                                                @break

                                                @case(1)
                                                    Assembling Phase
                                                @break

                                                @case(2)
                                                    PO
                                                @break

                                                @case(3)
                                                    Purchases
                                                @break

                                                @case(4)
                                                    Delivery
                                                @break

                                                @default
                                            @endswitch
                                        </td>
                                        <td>
                                            <div style="display:inline-flex">
                                                @can('delete-projects')
                                                    {{ Form::open(['method' => 'DELETE', 'route' => ['projects.destroy', $data->id]]) }}
                                                    {{ Form::hidden('id', $data->id) }}
                                                    <button type="submit" class="editing fa fa-trash"></button>
                                                    {{ Form::close() }}
                                                @endcan
                                                @can('create-project')
                                                    @if ($data->isApproved == 1)
                                                        @switch($data->phase)
                                                            @case(0)
                                                                <span title="View Project" class="editing fa fa-edit"
                                                                    onclick="location.href ='/dashboard/projects/{{ $data->id }}/assembling'"></span>
                                                            @break

                                                            @case(1)
                                                                <span title="View Project" class="editing fa fa-edit"
                                                                    onclick="location.href ='/dashboard/purchases/{{ $data->id }}/create'"></span>
                                                            @break

                                                            @default
                                                                <span title="View Project" class="editing fa fa-eye"
                                                                    onclick="location.href ='/dashboard/projects/{{ $data->id }}'"></span>
                                                        @endswitch
                                                    @else
                                                        <span title="View Project" class="editing fa fa-eye"
                                                            onclick="location.href ='/dashboard/projects/{{ $data->id }}'"></span>
                                                    @endif
                                                @endcan
                                                {{-- Form::open(['method' => 'post', 'url' => '/dashboard/PDFDownload/'.$data->id, ]) --}}
                                                {{-- Form::hidden('id',$data->id) --}}
                                                <button onclick="PDFDownload({{ $data->id }})"
                                                    class="editing fa fa-file-pdf-o"></button>
                                                {{-- Form::close() --}}
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

                @push('custom-scripts')
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
                    <script>
                        function deleteRec(num) {
                            if (confirm("Are you sure you want to delete it? " + num)) {
                                $.ajax({
                                    type: 'delete',
                                    url: "projects.destroy",
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

                        function PDFDownload(num) {
                            var doc = new jsPDF();
                            var specialElementHandlers = {
                                '#editor': function(element, renderer) {
                                    return true;
                                }
                            };
                            doc.fromHTML($('#content').html(), 15, 15, {
                                'width': 170,
                                'elementHandlers': specialElementHandlers
                            });
                            doc.save('sample-file.pdf');
                        }
                    </script>
                @endpush
            @else
                <h3>Not Allowed!</h3>
            @endcan

        </div>
    </div>

@endsection
