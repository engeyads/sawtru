@extends('home')


@section('articles')
    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
    <div class="contact-form">
        <div class="row">
            <div>
                <div>
                    <a class="btn btn-warning" href="{{ route('projects.index') }}"><i class="fa fa-arrow-left"></i>
                        Back</a>
                    <label class="pull-right">
                        @if ($project->isApproaved == 1)
                            @switch($project->phase)
                                @case(0)
                                    Assembling Phase
                                @break

                                @case(1)
                                    Purchase Order Phase
                                @break

                                @case(2)
                                    Purchases Phase
                                @break

                                @default
                            @endswitch
                        @else
                            @switch($project->phase)
                                @case(0)
                                    New Project
                                @break

                                @case(1)
                                    Assembling Phase
                                @break

                                @case(2)
                                    Purchase Order Phase
                                @break

                                @case(3)
                                    Purchases Phase
                                @break

                                @default
                            @endswitch
                        @endif
                    </label>
                </div>
                <div>
                    <div class="pull-left">
                        @switch ($project->phase)
                            @case(0)
                                <h2>New Project Review</h2>
                            @break

                            @case(1)
                                <h2>Assembling Phase Review</h2>
                            @break

                            @case(2)
                                <h2>PO Phase Review</h2>
                            @break
                        @endswitch
                    </div>
                    <div class="pull-right">
                                    <p style="float:right">Due in: {{ $project->daysneed }} days </p>
                                    <p>Finish before: {{ date('Y-m-d', strtotime(date('Y-m-d') . ' + ' . $project->daysneed . ' days')) }} </p>
                    </div>

                </div>
            </div>
        </div>
        <div id="msg" class=" msg">
            <p></p>
        </div>
        @can('edit-projects')
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <strong>Name:</strong>
                        <p >{{ $project->pname }}</p>
                        <input name="phase" type="hidden" value="{{ $project->phase }}" />
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <strong>Serial Number:</strong>
                        <p>{{ $project->serial_no }}</p>
                    </div>
                </div>
                <div class="row">
                    <hr>
                    <h4>Machine Dimentions: </h4>
                    <div class="pull-left">
                        <table>
                            <tr>
                                @if ($project->length != null && $project->width != null && $project->height != null)
                                    <td style="max-width:85px">
                                        <label for="L">
                                            <span>Length:</span>
                                        </label>
                                        <p>{{ $project->length }}</p>
                                    </td>
                                    <td style="max-width:85px">
                                        <label for="W">
                                            <span>Width:</span>
                                        </label>
                                        <p>{{ $project->width }}</p>
                                    </td>
                                    <td style="max-width:85px">
                                        <label for="H">
                                            <span>Height:</span>
                                        </label>
                                        <p>{{ $project->height }}</p>
                                    </td>
                                    <td>
                                        <label for="units1">
                                            <span>Unit:</span>
                                        </label>
                                            {{ $project->unit }}
                                    </td>
                                @endif

                                @if ($project->volume != null)
                                    <td>
                                        <p><span>Volume: </span> {{ $project->volume }}
                                        {{ $project->cubic_unit }}</p>
                                    </td>
                                @endif
                            </tr>
                        </table>
                    </div>
                </div>
                <div>
                    <a download="{{ $project->photo }}" href="{{ url('uploads/' . $project->photo) }}">
                        <img height="400" src="{{ url('uploads/' . $project->photo) }}" alt="">
                    </a>
                </div>





                {{--  ===========================================Begin====================================  --}}
                <div class="container mt-3">
                    @if ($project->phase == 1)
                    <div id="accordion">
                        <h2>Drawings:</h2>

                        <button type="button" class="btn btn-warning" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne">Assembling Photos:</button>
                        <div id="collapseOne" class="collapse" data-bs-parent="#accordion">
                            <table>
                                @foreach ($project->assemblingphts as $val)
                                    @if ($loop->iteration % 2 == 0)
                                        <td><a download="{{ $val->name }}" href="{{ url('uploads/' . $val->name) }}"><img
                                                    height="200" src="{{ url('uploads/' . $val->name) }}" alt=""></a>
                                        </td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td><a download="{{ $val->name }}"
                                                    href="{{ url('uploads/' . $val->name) }}"><img height="200"
                                                        src="{{ url('uploads/' . $val->name) }}" alt=""></a></td>
                                    @endif
                                @endforeach
                                @if (count($project->assemblingphts) % 2 != 0)
                                    </tr>
                                @endif
                            </table>
                        </div>
                        <hr>
                        <button type="button" class="btn btn-warning" data-bs-toggle="collapse"
                            data-bs-target="#collapseTwo">Machine 3D Photos:</button>
                        <div id="collapseTwo" class="collapse" data-bs-parent="#accordion">
                            <table>
                                @foreach ($project->diagramphts as $val)
                                    @if ($loop->iteration % 2 == 0)
                                        <td><a download="{{ $val->name }}" href="{{ url('uploads/' . $val->name) }}"><img
                                                    height="200" src="{{ url('uploads/' . $val->name) }}"
                                                    alt=""></a></td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td><a download="{{ $val->name }}"
                                                    href="{{ url('uploads/' . $val->name) }}"><img height="200"
                                                        src="{{ url('uploads/' . $val->name) }}" alt=""></a></td>
                                    @endif
                                @endforeach
                                @if (count($project->diagramphts) % 2 != 0)
                                    </tr>
                                @endif
                            </table>
                        </div>
                        <hr>
                        <button type="button" class="btn btn-warning" data-bs-toggle="collapse"
                            data-bs-target="#collapseThr">Horizontal Photos:</button>
                        <div id="collapseThr" class="collapse" data-bs-parent="#accordion">
                            <table>
                                @foreach ($project->horizontalphts as $val)
                                    @if ($loop->iteration % 2 == 0)
                                        <td><a download="{{ $val->name }}" href="{{ url('uploads/' . $val->name) }}"><img
                                                    height="200" src="{{ url('uploads/' . $val->name) }}"
                                                    alt=""></a></td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td><a download="{{ $val->name }}"
                                                    href="{{ url('uploads/' . $val->name) }}"><img height="200"
                                                        src="{{ url('uploads/' . $val->name) }}" alt=""></a></td>
                                    @endif
                                @endforeach
                                @if (count($project->horizontalphts) % 2 != 0)
                                    </tr>
                                @endif
                            </table>
                        </div>
                        <hr>
                        <button type="button" class="btn btn-warning" data-bs-toggle="collapse"
                            data-bs-target="#collapseFor">Vertical Photos:</button>
                        <div id="collapseFor" class="collapse" data-bs-parent="#accordion">
                            <table>
                                @foreach ($project->verticalphts as $val)
                                    @if ($loop->iteration % 2 == 0)
                                        <td><a download="{{ $val->name }}" href="{{ url('uploads/' . $val->name) }}"><img
                                                    height="200" src="{{ url('uploads/' . $val->name) }}"
                                                    alt=""></a></td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td><a download="{{ $val->name }}"
                                                    href="{{ url('uploads/' . $val->name) }}"><img height="200"
                                                        src="{{ url('uploads/' . $val->name) }}" alt=""></a></td>
                                    @endif
                                @endforeach
                                @if (count($project->verticalphts) % 2 != 0)
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                    @endif
                </div>

                {{-- project tables and details motors , metals , others --}}
                <div  id="conts" >
                    <div  id="req" class="req row">
                        <div class="req scol-12">
                            details:
                            <hr>
                            <h4>
                                Specifications:
                            </h4>
                            <h4>
                                Motors:
                            </h4>
                            <small>Motors and Bumps</small>
                            <table id="motors">
                                <thead>
                                    <tr>
                                        <th>Motor</th>
                                        <th>Power</th>
                                        <th>Title</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Total Price</th>
                                        <th>Photo</th>
                                    </tr>
                                </thead>
                                {!! Form::hidden('cnt', $i = 1, [null]) !!}
                                {!! Form::hidden('sm', $smi1 = 0, [null]) !!}
                                {!! Form::hidden('sm', $sm1 = 0, [null]) !!}
                                @foreach ($project->motors as $val)
                                    <tr>
                                        <td id="motor{{ $i }}" class="motor">
                                            <p>{{ $val->motor }}</p>
                                        </td>
                                        <td id="power{{ $i }}" class="power">
                                            <p>{{ $val->Power }}</p>
                                        </td>
                                        <td id="title{{ $i }}" class="title">
                                            <p>{{ $val->title }}</p>
                                        </td>
                                        <td id="qtytd{{ $i }}" class="qtytd">
                                            <p>{{ $val->qty }}</p>
                                        </td>
                                        <td id="pricetd{{ $i }}" class="pricetd">
                                            <p>{{ $val->price }} $</p>
                                        </td>
                                        <td id="totaltd{{ $i }}" class="totaltd">
                                            <p>{{ $val->total }} $</p>
                                        </td>
                                        <td id="mtphoto{{ $i }}" class="mtphoto">
                                            <a download="{{ $val->photo }}" href="{{ url('uploads/' . $val->photo) }}">
                                                <img height="100" src="{{ url('uploads/' . $val->photo) }}"
                                                    alt="">
                                            </a>
                                        </td>



                                    </tr>
                                    {!! Form::hidden('sm', $smi1=$smi1+$val->price, [null]) !!}
                                    {!! Form::hidden('sm', $sm1=$sm1+$val->total, [null]) !!}
                                    {!! Form::hidden('cnt', $i++, [null]) !!}
                                @endforeach
                                <tfoot>
                                    <tr>
                                        <td colspan="4"><label class="pull-right"><strong>Net : </strong></label>
                                        </td>
                                        <td>
                                            <p id="metalsItemNet">{{ $smi1}} $</p>
                                        </td>
                                        <td>
                                            <p id="metalsTotalNet">{{ $sm1}} $</p>
                                        </td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                            <input type="hidden" id="motorsItemsum">
                            <input type="hidden" id="motorssum">


                        </div>
                    </div>


                    <div id="conts" class="row">
                        <div id="req" class="req col-12">
                            <div id="mtl" class="reqs specifications">
                                <hr>
                                <h4>Metal:</h4>
                                <table id="metals">
                                    <thead>
                                        <tr>
                                            <th>Metal Type</th>
                                            <th>Thickness</th>
                                            <th>Title</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <th>Total Price</th>
                                        </tr>
                                    </thead>
                                    {!! Form::hidden('cnt', $i = 1, [null]) !!}
                                    {!! Form::hidden('sm', $smi = 0, [null]) !!}
                                    {!! Form::hidden('sm', $sm = 0, [null]) !!}
                                    @foreach ($project->metals as $val)
                                        <tr>
                                            <td id="metaltd{{ $i }}" class="metaltd">
                                                <p>{{ $val->metal_type }}</p>
                                            </td>
                                            <td id="thicknesstd{{ $i }}" class="thicknesstd">
                                                <p>{{ $val->thickness }}</p>
                                            </td>
                                            <td id="titletd{{ $i }}" class="titletd">
                                                <p>{{ $val->title }}</p>
                                                <input readonly type="hidden" value="1" id="total_mtl">
                                            </td>
                                            <td id="mtqtytd{{ $i }}" class="qtytd">
                                                <p id="mtqty{{ $i }}">{{ $val->qty }}</p>
                                            </td>
                                            <td id="mtpricetd{{ $i }}" class="pricetd">
                                                <p id="mtprice{{ $i }}">
                                                    {{ $val->price }} $</p>
                                            </td>
                                            <td id="mttotaltd{{ $i }}" class="totaltd">
                                                <p id="mttotal{{ $i }}">
                                                    {{ $val->total }} $</p>
                                            </td>

                                        </tr>
                                        {!! Form::hidden('sm', $smi=$smi+$val->price, [null]) !!}
                                        {!! Form::hidden('sm', $sm=$sm+$val->total, [null]) !!}
                                        {!! Form::hidden('cnt', $i++, [null]) !!}
                                    @endforeach
                                    <tfoot>
                                        <tr>
                                            <td colspan="4"><label class="pull-right"><strong>Net : </strong></label>
                                            </td>
                                            <td>
                                                <p id="metalsItemNet">{{ $smi}} $</p>
                                            </td>
                                            <td>
                                                <p id="metalsTotalNet">{{ $sm}} $</p>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <input type="hidden" id="metalsItemsum">
                                <input type="hidden" id="metalssum">
                            </div>



                        </div>
                    </div>


                    <div id="conts" class="row">
                        <div id="req" class="req col-12">
                            <div id="ot" class="reqs specifications">
                                <hr>
                                <h4>Others:</h4>
                                <small>Heaters, pipes or othes</small>
                                <table id="Others">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Info</th>
                                            <th>Details</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <th>Total Price</th>
                                        </tr>
                                    </thead>
                                    {!! Form::hidden('cnt', $i = 1, [null]) !!}
                                    {!! Form::hidden('sm', $smi2 = 0, [null]) !!}
                                    {!! Form::hidden('sm', $sm2 = 0, [null]) !!}
                                    @foreach ($project->others as $val)
                                        <tr>
                                            <td id="other{{ $i }}" class="other">
                                                <p>{{ $val->title }}</p>
                                            </td>
                                            <td id="info{{ $i }}" class="info">
                                                <p>{{ $val->info }}</p>
                                            </td>
                                            <td id="details{{ $i }}" class="details">
                                                <p>{{ $val->details }}</p>
                                                <input readonly type="hidden" value="1" id="total_ot">
                                            </td>
                                            <td id="otqtytd{{ $i }}" class="qtytd">
                                                <p id="oqty{{ $i }}">{{ $val->qty }}</p>
                                            </td>
                                            <td id="otpricetd{{ $i }}" class="pricetd">
                                                <p id="oprice{{ $i }}">{{ $val->price }} $</p>
                                            </td>
                                            <td id="ottotaltd{{ $i }}" class="totaltd">
                                                <p id="ototal{{ $i }}">{{ $val->total }} $</p>
                                            </td>
                                            {!! Form::hidden('sm', $smi2=$smi2+$val->price, [null]) !!}
                                            {!! Form::hidden('sm', $sm2=$sm2+$val->total, [null]) !!}
                                            {!! Form::hidden('cnt', $i++, [null]) !!}


                                        </tr>
                                        {!! Form::hidden('cnt', $i++, [null]) !!}
                                    @endforeach
                                    <tfoot>
                                        <tr>
                                            <td colspan="4"><label class="pull-right"><strong>Net : </strong></label>
                                            </td>
                                            <td>
                                                <p id="metalsItemNet">{{ $smi2 }} $</p>
                                            </td>
                                            <td>
                                                <p id="metalsTotalNet">{{ $sm2 }} $</p>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>

                                <input type="hidden" id="OthersItemsum">
                                <input type="hidden" id="Otherssum">
                                </table>

                            </div>
                        </div>
                    </div>
                    <!-- here -->
                    <div class="row">
                        <div class="col-12">
                            <div id="automations" class="specifications">
                                <hr>
                                <h4>Electricity and Automation:</h4>
                                <div>
                                    <p>
                                        Type: @if ($project->type == 1) PLC @else traditional @endif
                                    </p>
                                </div>
                                <label for="Details">
                                    <span class="required">Details:</span>
                                </label>
                                <p>{{ $project->details }}</p>
                                <div class="row">
                                    <div class="col-lg-12 margin-tb">
                                        <label for="drawing">
                                            <span class="required">Due in:</span>
                                        </label>
                                        <input readonly type="number"
                                            value="{{ $project->isApproved == 1 ? intval(abs(strtotime($project->due_time) - strtotime(date('Y-m-d'))) / 86400) : $project->daysneed }}"
                                            name="dtime">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- =====================================lasers=============================== --}}
                        @if ($project->phase == 1)
                        <div class="row">
                            <div class="col-12">
                                <hr>
                                <h4>Laser Fees</h4>
                                    <div id="req" class="req">

                                        <table class="reqs">
                                            <tr>
                                                <td>
                                                    Laser Cutting:
                                                </td>
                                                <td>
                                                    {{ $project->lasers->laser_cutting }} $
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    CNC Fee:
                                                </td>
                                                <td>
                                                    {{ $project->lasers->cnc }} $
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Torna:
                                                </td>
                                                <td>
                                                    {{ $project->lasers->torna }} $
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Assembling:
                                                </td>
                                                <td>
                                                    {{ $project->lasers->assembling }} $
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Electric and Automation:
                                                </td>
                                                <td>
                                                    {{ $project->lasers->electric_and_automation }} $
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Net :
                                                </td>
                                                <td>
                                                    {{ $project->lasers->total }} $
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <input type="hidden" id="laserssum">
                                </div>
                            </div>
                            @endif
                            {{-- ============================================================== --}}

                        </div>
                    </div>
                </div>
                <hr>
                {!! Form::model($project, ['method' => 'PATCH', 'route' => ['projects.update', $project->id]]) !!}
                <div class="row">
                    <div class="col-4 pull-right">
                        <label for="approval">Status: </label>
                        @csrf
                        <select name="approval" id="approval">
                            @if ($project->isApproved == 0)
                                <option value="1">Approve</option>
                                <option value="-1">Refuse</option>
                            @elseif ($project->isApproved == -1)
                                <option value="1">Resume</option>
                            @elseif ($project->isApproved == 1)
                                <option value="-1">Cancel</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-4 pull-right">
                        <label>&nbsp;</label>
                        <button class="btn btn-warning" name="submit" type="submit" id="submit">submit</button>
                        </form>

                    </div>
                    <table>
                        <tr>
                            <td>
                                <div class="comment">
                                    <label for="managercomment">Comment:</label>
                                    <textarea name="managercomment" id="mgrcomment" cols="10" rows="3"></textarea>
                                    <span class="btn btn-warning pull-right"
                                        onclick="submitComment({{ $project->serial_no }},{{ Auth::user()->id }},{{ $project->uid }})">Send</span>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <div id="comments-table" class="comments-container">
                        <table>
                            @foreach ($project->comments as $comment)
                                @if ($comment->available == 1)
                                    <tr id="cmnt{{ $comment->id }}">
                                        <td>
                                            <div id="cmntuser{{ $comment->id }}" class="comments-username">
                                                <b>{{ $comment->user->name }}</b><br>
                                            </div>
                                            @if ($comment->byid == Auth::user()->id &&
                                                date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s'))) <
                                                    date('Y-m-d H:i:s', strtotime($comment->created_at . ' + 5 minutes')))
                                                <div class="comments-remove" onclick="deleteComment({{ $comment->id }})">
                                                </div>
                                            @endif
                                            <div class="comments">
                                                {{ $comment->content }}
                                            </div>
                                            <div class="comments-timestamp">
                                                <small>{{ $comment->created_at }}</small>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </table>
                    </div>

                </div>
            </div>
            @push('custom-scripts')
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
                <script>
                    function submitComment(projectSerialNumber, LogedinUserId, projectUserId) {
                        if ($('#mgrcomment').val() != '') {
                            $.ajax({
                                type: 'put',
                                url: "/dashboard/comment/",
                                data: {
                                    '_token': $("meta[name='csrf-token']").attr("content"),
                                    'serial': projectSerialNumber,
                                    'byid': LogedinUserId,
                                    'toid': projectUserId,
                                    'content': $('#mgrcomment').val(),
                                },
                                success: function(data) {
                                    row = $("<tr id='cmnt" + data.data.id + "'></tr>");
                                    col1 = $('<td ><div id="cmntuser' + data.data.id +
                                        '" class="comments-username"><b>you</b><br></div><div class="comments-remove" onclick="deleteComment(' +
                                        data.data.id + ')"></div><div class="comments">' + data.data.content +
                                        '</div><div class="comments-timestamp">    <small>' + new Date(data.data
                                            .created_at) + '</small></div></td>');
                                    row.append(col1).prependTo("#comments-table table");
                                }
                            });
                        }
                    }

                    function deleteComment(commentId) {
                        $.ajax({
                            type: 'delete',
                            url: "/dashboard/comment/" + commentId,
                            data: {
                                '_token': $("meta[name='csrf-token']").attr("content"),
                                'id': commentId,
                            },
                            success: function(data) {
                                $("#comments-table tr#cmnt" + data.data.id).remove();
                            }
                        });
                    }
                    sum('motors');
                    sum('metals');
                    sum('Others');
                </script>
            @endpush
        @elsecan('create-project')
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <strong>Name:</strong>
                        <input readonly type="text" value="{{ $project->pname }}">
                        <input type="hidden" value="{{ $project->phase }}">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <strong>Serial Number:</strong>
                        <input readonly type="text" value="{{ $project->serial_no }}">
                    </div>
                </div>
                <div class="row">
                    <hr>
                    <h4>Machine Dimentions: </h4>
                    <div class="pull-left">
                        <table>
                            <tr>
                                <td style="max-width:85px">
                                    <label for="L">
                                        <span>Length:</span>
                                    </label>
                                    <input type="number" id="L" name="L" value="{{ $project->length }}"
                                        placeholder="Number" tabindex="3" readonly />
                                </td>
                                <td style="max-width:85px">
                                    <label for="W">
                                        <span>Width:</span>
                                    </label>
                                    <input type="number" id="W" name="W" value="{{ $project->width }}"
                                        placeholder="Number" tabindex="4" readonly />
                                </td>
                                <td style="max-width:85px">
                                    <label for="H">
                                        <span>Height:</span>
                                    </label>
                                    <input type="number" id="H" name="H" value="{{ $project->height }}"
                                        placeholder="Number" tabindex="5" readonly />
                                </td>
                                <td>
                                    <label for="units1">
                                        <span>Unit:</span>
                                    </label>
                                    <select type=" id="units1" name="units1" tabindex="6">
                                        @if ($project->unit == 'cm')
                                            <option value="cm">CM</option>
                                        @endif
                                        @if ($project->unit == 'm')
                                            <option value="m">Meters</option>
                                        @endif
                                        @if ($project->unit == 'ft')
                                            <option value="ft">Feets</option>
                                        @endif
                                    </select>
                                </td>


                                <td>

                                    <span>OR</span>
                                </td>
                                <td>
                                    <label for="volume">
                                        <span>Volume:</span>
                                    </label>
                                    <input type="number" id="volume" name="volume" value="{{ $project->volume }}"
                                        placeholder="Number" tabindex="6" readonly />
                                </td>
                                <td>
                                    <label for="units1">
                                        <span>Unit:</span>
                                    </label>
                                    <select type=" id="units2" name="units2" tabindex="6">
                                        @if ($project->cubic_unit == 'm3')
                                            <option value="m3">Cubic Meters</option>
                                        @endif
                                        @if ($project->cubic_unit == 'cm3')
                                            <option value="cm3">Cubic Centimeter</option>
                                        @endif
                                        @if ($project->cubic_unit == 'dm3')
                                            <option value="dm3">Cubic Decimeter</option>
                                        @endif
                                        @if ($project->cubic_unit == 'ft3')
                                            <option value="ft3">Cubic Feets</option>
                                        @endif
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>





                <div>
                    <div class="row">
                        <div class="col-12">
                            details:
                            <hr>
                            <h4>
                                Specifications:
                            </h4>


                            <h4>
                                Motors:
                            </h4>

                            <table id="motors">

                                <tr>
                                    <th>Motor</th>
                                    <th>Power</th>
                                    <th>Title</th>
                                    <th></th>
                                </tr>
                                {!! Form::hidden('cnt', $i = 1, [null]) !!}
                                @foreach ($project->motors as $val)
                                    <tr>
                                        <td id="motor{{ $i }}" class="motor">
                                            <input readonly type="text" id="motor{{ $i }}"
                                                name="motors[{{ $i }}][motor]" value="{{ $val->motor }}"
                                                placeholder="motor" required="required" />
                                        </td>
                                        <td id="power{{ $i }}" class="power">
                                            <input readonly type="text" id="power{{ $i }}"
                                                name="motors[{{ $i }}][power]" value="{{ $val->Power }}"
                                                placeholder="power" required="required" />
                                        </td>
                                        <td id="title{{ $i }}" class="title">
                                            <input readonly type="text" id="title{{ $i }}"
                                                name="motors[{{ $i }}][title]" value="{{ $val->title }}"
                                                placeholder="title" required="required" />

                                        </td>

                                        @if ($i == 1)
                                            <td id="btns1">
                                                <div class="addremove">
                                                    <span id="addsp" class="addsp btn btn-warning">+</span>
                                                    <span id="removesp" class="removesp btn btn-warning">-&nbsp;</span>
                                                    <input readonly type="hidden" value="1" id="total_spc">
                                                </div>
                                            </td>
                                        @else
                                            <td>

                                            </td>
                                        @endif

                                    </tr>
                                    {!! Form::hidden('cnt', $i++, [null]) !!}
                                @endforeach
                            </table>

                        </div>
                    </div>


                    <div class="row">
                        <div class="col-12">
                            <div id="mtl" class="specifications">
                                <hr>
                                <h4>Metal:</h4>
                                <table id="metals">
                                    <tr>
                                        <th>Metal Type</th>
                                        <th>Thickness</th>
                                        <th>Title</th>
                                        <th></th>
                                    </tr>
                                    {!! Form::hidden('cnt', $i = 1, [null]) !!}
                                    @foreach ($project->metals as $val)
                                        <tr>
                                            <td id="metaltd{{ $i }}" class="metaltd">
                                                <input readonly type="text" id="metaltd{{ $i }}"
                                                    name="metals[{{ $i }}][metal]"
                                                    value="{{ $val->metal_type }}" placeholder="Metal" required="required" />
                                            </td>
                                            <td id="thicknesstd{{ $i }}" class="thicknesstd">
                                                <input readonly type="text" id="thicknesstd{{ $i }}"
                                                    name="metals[{{ $i }}][thickness]"
                                                    value="{{ $val->thickness }}" placeholder="Thickness"
                                                    required="required" />
                                            </td>
                                            <td id="titletd{{ $i }}" class="titletd">
                                                <input readonly type="text" id="titletd{{ $i }}"
                                                    name="metals[{{ $i }}][title]" value="{{ $val->title }}"
                                                    placeholder="Title" required="required" />
                                                <input readonly type="hidden" value="1" id="total_mtl">
                                            </td>

                                            @if ($i == 1)
                                                <td id="btns2">
                                                    <div class="addremove">
                                                        <span type="button" id="addmt"
                                                            class="addmt btn btn-warning">+</span>
                                                        <span type="button" id="removemt"
                                                            class="removemt btn btn-warning">-&nbsp;</span>
                                                    </div>
                                                </td>
                                            @else
                                                <td>

                                                </td>
                                            @endif

                                        </tr>
                                        {!! Form::hidden('cnt', $i++, [null]) !!}
                                    @endforeach
                                </table>
                            </div>



                        </div>

                        <div id="ot" class="specifications">
                            <hr>
                            <h4>Others:</h4>
                            <small>Heares, pumbs, pipes or othes</small>
                            <table id="Others">
                                <tr>
                                    <th>Title</th>
                                    <th>Info</th>
                                    <th>Details</th>
                                    <th></th>
                                </tr>
                                {!! Form::hidden('cnt', $i = 1, [null]) !!}
                                @foreach ($project->others as $val)
                                    <tr>
                                        <td id="other{{ $i }}" class="other">
                                            <input readonly type="text" id="other{{ $i }}"
                                                name="others[{{ $i }}][title]" value="{{ $val->title }}"
                                                placeholder="Title" required="required" />
                                        </td>
                                        <td id="info{{ $i }}" class="info">
                                            <input readonly type="text" id="info{{ $i }}"
                                                name="others[{{ $i }}][info]" value="{{ $val->info }}"
                                                placeholder="Info" required="required" />
                                        </td>
                                        <td id="details{{ $i }}" class="details">
                                            <input readonly type="text" id="details{{ $i }}"
                                                name="others[{{ $i }}][details]" value="{{ $val->details }}"
                                                placeholder="Details" required="required" />
                                            <input readonly type="hidden" value="1" id="total_ot">
                                        </td>

                                        @if ($i == 1)
                                            <td id="btns1">
                                                <div class="addremove">
                                                    <span id="addot" class="addot btn btn-warning">+</span>
                                                    <span id="removeot" class="removeot btn btn-warning">-&nbsp;</span>
                                                </div>
                                            </td>
                                        @else
                                            <td>

                                            </td>
                                        @endif

                                    </tr>
                                    {!! Form::hidden('cnt', $i++, [null]) !!}
                                @endforeach
                            </table>

                        </div>
                        <!-- here -->
                        <div id="automations" class="specifications">
                            <hr>
                            <h4>Electricity and Automation:</h4>
                            <div>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>
                                                traditional
                                            </th>
                                            <th>
                                                PLC
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <label class="chklabel">
                                                    <input readonly type="radio"
                                                        @if ($project->type == 0) checked @endif onchange='chkd(1)'
                                                        class="cdusd" id="traditional" name="torp" value="traditional">
                                                    <span class="check-box-effect"></span>
                                                </label>
                                            </td>
                                            <td>
                                                <label class="chklabel">
                                                    <input readonly type="radio"
                                                        @if ($project->type == 1) checked @endif onchange='chkd(1)'
                                                        class="cdusd" id="PLC" name="torp" value="PLC">
                                                    <span class="check-box-effect"></span>
                                                </label>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <label for="Details">
                                <span class="required">Details:</span>
                            </label>
                            <textarea minlength="5" id="Details" name="edetails" placeholder="Details" required="required">{{ $project->details }}</textarea>
                            <div class="row">
                                <div class="col-lg-12 margin-tb">
                                    <label for="drawing">
                                        <span class="required">Drawing Delivery Time:</span>
                                    </label>
                                    <input readonly type="number"
                                        value="{{ $project->daysneed }}"
                                        name="dtime">
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <table>
                            <tr>
                                <td>
                                    <div class="comment">
                                        <label for="managercomment">Comment:</label>
                                        <textarea placeholder="Comment" name="managercomment" id="mgrcomment" cols="10" rows="3"></textarea>
                                        <span class="btn btn-warning pull-right"
                                            onclick="submitComment({{ $project->serial_no }},{{ Auth::user()->id }},{{ $project->uid }})">Send</span>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div id="comments-table" class="comments-container">
                            <table>
                                @foreach ($project->comments as $comment)
                                    @if ($comment->available == 1)
                                        <tr id="cmnt{{ $comment->id }}">
                                            <td>
                                                <div id="cmntuser{{ $comment->id }}" class="comments-username">
                                                    <b>{{ $comment->user->name }}</b><br>

                                                </div>
                                                @if ($comment->byid == Auth::user()->id &&
                                                    date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s'))) <
                                                        date('Y-m-d H:i:s', strtotime($comment->created_at . ' + 5 minutes')))
                                                    <div class="comments-remove"
                                                        onclick="deleteComment({{ $comment->id }})">

                                                    </div>
                                                @endif

                                                <div class="comments">
                                                    {{ $comment->content }}
                                                </div>
                                                <div class="comments-timestamp">
                                                    <small>{{ $comment->created_at }}</small>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </table>
                        </div>

                    </div>
                </div>
                @push('custom-scripts')
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
                    <script>
                        function submitComment(projectSerialNumber, LogedinUserId, projectUserId) {
                            if ($('#mgrcomment').val() != '') {
                                $.ajax({
                                    type: 'put',
                                    url: "/dashboard/comment/",
                                    data: {
                                        '_token': $("meta[name='csrf-token']").attr("content"),
                                        'serial': projectSerialNumber,
                                        'byid': LogedinUserId,
                                        'toid': projectUserId,
                                        'content': $('#mgrcomment').val(),
                                    },
                                    success: function(data) {
                                        row = $("<tr id='cmnt" + data.data.id + "'></tr>");
                                        col1 = $('<td ><div id="cmntuser' + data.data.id +
                                            '" class="comments-username"><b>you</b><br></div><div class="comments-remove" onclick="deleteComment(' +
                                            data.data.id + ')"></div><div class="comments">' + data.data.content +
                                            '</div><div class="comments-timestamp">    <small>' + new Date(data.data
                                                .created_at) + '</small></div></td>');
                                        row.append(col1).prependTo("#comments-table table");
                                    }
                                });
                            }
                        }

                        function deleteComment(commentId) {
                            $.ajax({
                                type: 'delete',
                                url: "/dashboard/comment/" + commentId,
                                data: {
                                    '_token': $("meta[name='csrf-token']").attr("content"),
                                    'id': commentId,
                                },
                                success: function(data) {
                                    $("#comments-table tr#cmnt" + data.data.id).remove();
                                }
                            });
                        }

                        var app = require('express')();
                        var http = require('http').Server(app);
                        var io = require('socket.io')(http);

                        app.get('/message', function(req, res) {
                            res.sendFile(__dirname + "/resources/views/ui/Chat/chat.blade.php");
                        });

                        http.listen(6001, function() {
                            console.log('listening on *:6001');
                        });
                    </script>
                @endpush
            @else
                <h4>Not Allowed !</h4>
            @endcan
        </div>
        @push('custom-scripts')
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
            <script src="{{ URL::asset('js/scripts.js') }}"></script>
        @endpush
    @endsection
