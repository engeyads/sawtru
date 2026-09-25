@extends('home')


@section('articles')
    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">



    @can('create-project')
        @if ($project->isApproved == 1)
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

            <x-page-header title="Project Purchase Order" :back="route('projects.index')"></x-page-header>
            <div class="contact-form">
                <div class="rightside">
                    <div>
                        <div>
                            <div class="pull-right">
                                <table>
                                    <tr>
                                        <th>
                                            Due in
                                        </th>
                                        <th>
                                            Finish before
                                        </th>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="text" id="dtime"
                                                value="{{ intval(abs(strtotime($project->due_time) - strtotime(date('Y-m-d'))) / 86400) }} days"
                                                placeholder="Delivery Time" readonly />
                                        </td>
                                        <td>
                                            <input type="date" value="{{ $project->due_time }}" readonly />
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <br><br><br><br><br>

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-lg-12 margin-tb">
                            <div class="pull-left">
                                <label for="pname">
                                    <span>Title:</span>
                                </label>
                                <input type="text" id="pname" value="{{ $project->pname }}"
                                    placeholder="Project Name" tabindex="1" autofocus="autofocus" readonly />
                            </div>
                            <div class="pull-right">
                                <label for="serialno">
                                    <span>Serial Number: </span>
                                </label>
                                <input type="text" id="serialno" value="{{ $project->serial_no }}"
                                    placeholder="Project serial number" min="0" readonly />
                            </div>
                        </div>
                    </div>
                    <div id="accordion">
                        <button type="button" class="btn btn-warning" data-bs-toggle="collapse"
                            data-bs-target="#Assemblingphase">View Assembling Phase Values</button>
                        <div id="Assemblingphase" class="collapse">



                            <div id="">
                                <div>
                                    <div class="row">
                                        <div class="col-lg-12 margin-tb">
                                            <hr>
                                            <h4>Machine Dimentions: </h4>
                                            <div class="pull-left">
                                                <table>
                                                    <tr>
                                                        @if ($project->volume == null)
                                                            <td style="max-width:85px">
                                                                <label for="L">
                                                                    <span>Length:</span>
                                                                </label>
                                                                <input type="number" min="0" id="L"
                                                                    value="{{ $project->length }}"
                                                                    placeholder="number" min="0" tabindex="3"
                                                                    readonly />
                                                            </td>
                                                            <td style="max-width:85px">
                                                                <label for="W">
                                                                    <span>Width:</span>
                                                                </label>
                                                                <input type="number" min="0" id="W"
                                                                    value="{{ $project->width }}"
                                                                    placeholder="number" min="0" tabindex="4"
                                                                    readonly />
                                                            </td>
                                                            <td style="max-width:85px">
                                                                <label for="H">
                                                                    <span>Height:</span>
                                                                </label>
                                                                <input type="number" min="0" id="H"
                                                                    value="{{ $project->height }}"
                                                                    placeholder="number" min="0" tabindex="5"
                                                                    readonly />
                                                            </td>
                                                            <td>
                                                                <label for="units1">
                                                                    <span>Unit:</span>
                                                                </label>
                                                                <select type=" id="units1" tabindex="6">
                                                                    @if ($project->unit == 'cm')
                                                                        <option value="cm">CM</option>
                                                                    @endif
                                                                    @if ($project->unit == 'm')
                                                                        <option value="m">Meters</option>
                                                                    @endif
                                                                    @if ($project->unit == 'ft')
                                                                        <option value="f">Feets</option>
                                                                    @endif
                                                                </select>
                                                            </td>
                                                        @else
                                                            <td>
                                                                <label for="volume">
                                                                    <span>Volume:</span>
                                                                </label>
                                                                <input type="number" id="volume"
                                                                    value="{{ $project->volume }}" placeholder="Number"
                                                                    tabindex="6" readonly />
                                                            </td>
                                                            <td>
                                                                <label for="units1">
                                                                    <span>Unit:</span>
                                                                </label>
                                                                <select type=" id="units2" tabindex="6"
                                                                    readonly>
                                                                    @if ($project->cubic_unit == 'm3')
                                                                        <option selected value="m3">Cubic Meters</option>
                                                                    @endif
                                                                    @if ($project->cubic_unit == 'cm3')
                                                                        <option selected value="cm3">Cubic Centimeter
                                                                        </option>
                                                                    @endif
                                                                    @if ($project->cubic_unit == 'dm3')
                                                                        <option selected value="dm3">Cubic Decimeter</option>
                                                                    @endif
                                                                    @if ($project->cubic_unit == 'ft3')
                                                                        <option selected value="ft3">Cubic Feets</option>
                                                                    @endif
                                                                </select>
                                                            </td>
                                                        @endif
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="container mt-3">
                                    <div id="accordion">
                                        <h2>Drawings:</h2>

                                        <button type="button" class="btn btn-warning" data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne">Assembling Photos:</button>
                                        <div id="collapseOne" class="collapse">
                                            <table>

                                                @foreach ($project->assemblingphts as $val)
                                                    @if ($loop->iteration % 2 == 0)
                                                        <td><a download="{{ $val->name }}"
                                                                href="{{ url('uploads/' . $val->name) }}"><img height="200"
                                                                    src="{{ url('uploads/' . $val->name) }}"
                                                                    alt=""></a></td>
                                                        </tr>
                                                    @else
                                                        <tr>
                                                            <td><a download="{{ $val->name }}"
                                                                    href="{{ url('uploads/' . $val->name) }}"><img
                                                                        height="200"
                                                                        src="{{ url('uploads/' . $val->name) }}"
                                                                        alt=""></a></td>
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
                                        <div id="collapseTwo" class="collapse">
                                            <table>
                                                @foreach ($project->diagramphts as $val)
                                                    @if ($loop->iteration % 2 == 0)
                                                        <td><a download="{{ $val->name }}"
                                                                href="{{ url('uploads/' . $val->name) }}"><img height="200"
                                                                    src="{{ url('uploads/' . $val->name) }}"
                                                                    alt=""></a></td>
                                                        </tr>
                                                    @else
                                                        <tr>
                                                            <td><a download="{{ $val->name }}"
                                                                    href="{{ url('uploads/' . $val->name) }}"><img
                                                                        height="200"
                                                                        src="{{ url('uploads/' . $val->name) }}"
                                                                        alt=""></a></td>
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
                                        <div id="collapseThr" class="collapse">
                                            <table>
                                                @foreach ($project->horizontalphts as $val)
                                                    @if ($loop->iteration % 2 == 0)
                                                        <td><a download="{{ $val->name }}"
                                                                href="{{ url('uploads/' . $val->name) }}"><img height="200"
                                                                    src="{{ url('uploads/' . $val->name) }}"
                                                                    alt=""></a></td>
                                                        </tr>
                                                    @else
                                                        <tr>
                                                            <td><a download="{{ $val->name }}"
                                                                    href="{{ url('uploads/' . $val->name) }}"><img
                                                                        height="200"
                                                                        src="{{ url('uploads/' . $val->name) }}"
                                                                        alt=""></a></td>
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
                                        <div id="collapseFor" class="collapse">
                                            <table>
                                                @foreach ($project->verticalphts as $val)
                                                    @if ($loop->iteration % 2 == 0)
                                                        <td><a download="{{ $val->name }}"
                                                                href="{{ url('uploads/' . $val->name) }}"><img height="200"
                                                                    src="{{ url('uploads/' . $val->name) }}"
                                                                    alt=""></a></td>
                                                        </tr>
                                                    @else
                                                        <tr>
                                                            <td><a download="{{ $val->name }}"
                                                                    href="{{ url('uploads/' . $val->name) }}"><img
                                                                        height="200"
                                                                        src="{{ url('uploads/' . $val->name) }}"
                                                                        alt=""></a></td>
                                                    @endif
                                                @endforeach
                                                @if (count($project->verticalphts) % 2 != 0)
                                                    </tr>
                                                @endif
                                            </table>
                                        </div>
                                    </div>
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
                                        <table id="motorss">
                                            <tr>
                                                <th>Motor</th>
                                                <th>Power</th>
                                                <th>Title</th>
                                                <th>Quantity</th>
                                                <th>Unit Price</th>
                                                <th>Total Price</th>
                                                <th>Photo</th>
                                                <th></th>
                                            </tr>
                                            {!! Form::hidden('cnt', $i = 1, [null]) !!}
                                            @foreach ($project->motors as $val)
                                                <tr>
                                                    <td id="motorss{{ $i }}" class="motors">
                                                        <input readonly type="text" id="motors{{ $i }}"

                                                            value="{{ $val->motor }}" placeholder="motor" tabindex="1"
                                                            autofocus="autofocus" />
                                                    </td>
                                                    <td id="powers{{ $i }}" class="powers">
                                                        <input readonly type="text" id="power{{ $i }}"

                                                            value="{{ $val->Power }}" placeholder="power" tabindex="1"
                                                            autofocus="autofocus" />
                                                    </td>
                                                    <td id="titles{{ $i }}" class="titles">
                                                        <input readonly type="text" id="titles{{ $i }}"

                                                            value="{{ $val->title }}" placeholder="title" tabindex="1"
                                                            autofocus="autofocus" />
                                                    </td>
                                                    <td id="qtytds{{ $i }}" class="qtytds">
                                                        <input type="number" min="1" id="qty{{ $i }}"

                                                            onchange=" $('#total{{ $i }}').val($('#qty{{ $i }}').val()*$('#price{{ $i }}').val()); sum('motorss');"
                                                            value="{{ $val->qty }}" placeholder="qty" tabindex="1"
                                                            autofocus="autofocus" readonly />
                                                    </td>
                                                    <td id="pricetds{{ $i }}" class="pricetds">
                                                        <div class="currencyinput">$</div>
                                                        <input type="number" min="0" id="prices{{ $i }}"

                                                            onchange=" $('#total{{ $i }}').val($('#qty{{ $i }}').val()*$('#price{{ $i }}').val()); sum('motorss');"
                                                            value="{{ $val->price }}" placeholder="price" tabindex="1"
                                                            autofocus="autofocus" readonly />
                                                    </td>
                                                    <td id="totaltds{{ $i }}" class="totaltds">
                                                        <div class="currencyinput">$</div>
                                                        <input type="number" min="0" id="totals{{ $i }}"

                                                            value="{{ $val->total }}" placeholder="Total" tabindex="1"
                                                            readonly autofocus="autofocus" />
                                                    </td>
                                                    <td id="mtphotos{{ $i }}" class="mtphotos">
                                                        <a download="{{ $val->photo }}"
                                                            href="{{ url('uploads/' . $val->photo) }}">
                                                            <img height="100" src="{{ url('uploads/' . $val->photo) }}"
                                                                alt="">
                                                        </a>
                                                    </td>


                                                    <td>

                                                    </td>


                                                </tr>
                                                {!! Form::hidden('cnt', $i++, [null]) !!}
                                            @endforeach
                                            <tfoot>
                                                <tr>
                                                    <td colspan="4"><label class="pull-right"><strong>Net :
                                                            </strong></label>
                                                    </td>
                                                    <td>
                                                        <div class="currencyinput">$</div><input id="motorssItemNet"
                                                            type="number" value="0" readonly>
                                                    </td>
                                                    <td>
                                                        <div class="currencyinput">$</div><input id="motorssTotalNet"
                                                            type="number" value="0" readonly>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        <input type="hidden" id="motorssItemsum">
                                        <input type="hidden" id="motorsssum">


                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-12">
                                        <div id="mtl" class="specifications">
                                            <hr>
                                            <h4>Metal:</h4>
                                            <table id="metalss">
                                                <tr>
                                                    <th>Metal Type</th>
                                                    <th>Thickness</th>
                                                    <th>Title</th>
                                                    <th>Quantity</th>
                                                    <th>Unit Price</th>
                                                    <th>Total Price</th>
                                                    <th></th>
                                                </tr>
                                                {!! Form::hidden('cnt', $i = 1, [null]) !!}
                                                @foreach ($project->metals as $val)
                                                    <tr>
                                                        <td id="metaltds{{ $i }}" class="metaltds">
                                                            <input readonly type="text" id="metaltds{{ $i }}"

                                                                value="{{ $val->metal_type }}" placeholder="Metal"
                                                                tabindex="1" autofocus="autofocus" />
                                                        </td>
                                                        <td id="thicknesstds{{ $i }}" class="thicknesstds">
                                                            <input readonly type="text"
                                                                id="thicknesstds{{ $i }}"

                                                                value="{{ $val->thickness }}" placeholder="Thickness"
                                                                tabindex="1" autofocus="autofocus" />
                                                        </td>
                                                        <td id="titletds{{ $i }}" class="titletds">
                                                            <input readonly type="text" id="titletds{{ $i }}"

                                                                value="{{ $val->title }}" placeholder="Title"
                                                                tabindex="1" autofocus="autofocus" />
                                                            <input readonly type="hidden" value="1" id="total_mtl">
                                                        </td>
                                                        <td id="mtqtytds{{ $i }}" class="qtytd">
                                                            <input type="number" min="1"
                                                                id="mtqtys{{ $i }}"

                                                                onchange=" $('#mttotal{{ $i }}').val($('#mtqty{{ $i }}').val()*$('#mtprice{{ $i }}').val()); sum('metals');"
                                                                value="{{ $val->qty }}" placeholder="qty" tabindex="1"
                                                                autofocus="autofocus" readonly />
                                                        </td>
                                                        <td id="mtpricetds{{ $i }}" class="pricetds">
                                                            <div class="currencyinput">$</div>
                                                            <input type="number" min="0"
                                                                id="mtprices{{ $i }}"

                                                                onchange=" $('#mttotal{{ $i }}').val($('#mtqty{{ $i }}').val()*$('#mtprice{{ $i }}').val()); sum('metals');"
                                                                value="{{ $val->price }}" placeholder="price"
                                                                tabindex="1" autofocus="autofocus" readonly />
                                                        </td>
                                                        <td id="mttotaltds{{ $i }}" class="totaltds">
                                                            <div class="currencyinput">$</div>
                                                            <input type="number" min="0"
                                                                id="mttotals{{ $i }}"

                                                                value="{{ $val->total }}" placeholder="Total"
                                                                tabindex="1" readonly autofocus="autofocus" />
                                                        </td>
                                                    </tr>
                                                    {!! Form::hidden('cnt', $i++, [null]) !!}
                                                @endforeach
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="4"><label class="pull-right"><strong>Net :
                                                                </strong></label>
                                                        </td>
                                                        <td>
                                                            <div class="currencyinput">$</div><input id="metalssItemNet"
                                                                type="number" value="0" readonly>
                                                        </td>
                                                        <td>
                                                            <div class="currencyinput">$</div><input id="metalssTotalNet"
                                                                type="number" value="0" readonly>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <input type="hidden" id="metalssItemsum">
                                            <input type="hidden" id="metalsssum">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div id="ot" class="specifications">
                                            <hr>
                                            <h4>Others:</h4>
                                            <small>Heares, pumbs, pipes or othes</small>
                                            <table id="Otherss">
                                                <tr>
                                                    <th>Title</th>
                                                    <th>Info</th>
                                                    <th>Details</th>
                                                    <th>Quantity</th>
                                                    <th>Unit Price</th>
                                                    <th>Total Price</th>
                                                    <th></th>
                                                </tr>
                                                {!! Form::hidden('cnt', $i = 1, [null]) !!}
                                                @foreach ($project->others as $val)
                                                    <tr>
                                                        <td id="others{{ $i }}" class="others">
                                                            <input readonly type="text" id="others{{ $i }}"

                                                                value="{{ $val->title }}" placeholder="Title"
                                                                tabindex="1" autofocus="autofocus" />
                                                        </td>
                                                        <td id="infos{{ $i }}" class="infos">
                                                            <input readonly type="text" id="infos{{ $i }}"

                                                                value="{{ $val->info }}" placeholder="Info"
                                                                tabindex="1" autofocus="autofocus" />
                                                        </td>
                                                        <td id="detailss{{ $i }}" class="detailss">
                                                            <input readonly type="text" id="detailss{{ $i }}"
                                                                name="otherss[{{ $i }}][details]"
                                                                value="{{ $val->details }}" placeholder="Details"
                                                                tabindex="1" autofocus="autofocus" />
                                                            <input readonly type="hidden" value="1" id="total_ot">
                                                        </td>
                                                        <td id="otqtytds{{ $i }}" class="qtytds">
                                                            <input type="number" min="0"
                                                                id="oqty{{ $i }}"

                                                                onchange=" $('#ototal{{ $i }}').val($('#oqty{{ $i }}').val()*$('#oprice{{ $i }}').val()); sum('Others');"
                                                                value="{{ $val->qty }}" placeholder="qty"
                                                                tabindex="1" autofocus="autofocus" readonly />
                                                        </td>
                                                        <td id="otpricetds{{ $i }}" class="pricetds">
                                                            <div class="currencyinput">$</div>
                                                            <input type="number" min="0"
                                                                id="oprices{{ $i }}"

                                                                onchange=" $('#ototal{{ $i }}').val($('#oqty{{ $i }}').val()*$('#oprice{{ $i }}').val()); sum('Others');"
                                                                value="{{ $val->price }}" placeholder="price"
                                                                tabindex="1" autofocus="autofocus" readonly />
                                                        </td>
                                                        <td id="ottotaltds{{ $i }}" class="totaltds">
                                                            <div class="currencyinput">$</div>
                                                            <input type="number" min="0"
                                                                id="ototals{{ $i }}"

                                                                value="{{ $val->total }}" placeholder="Total"
                                                                tabindex="1" autofocus="autofocus" readonly />
                                                        </td>


                                                    </tr>
                                                    {!! Form::hidden('cnt', $i++, [null]) !!}
                                                @endforeach
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="4"><label class="pull-right"><strong>Net :
                                                                </strong></label>
                                                        </td>
                                                        <td>
                                                            <div class="currencyinput">$</div><input id="OtherssItemNet"
                                                                type="number" value="0" readonly>
                                                        </td>
                                                        <td>
                                                            <div class="currencyinput">$</div><input id="OtherssTotalNet"
                                                                type="number" value="0" readonly>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table>

                                            <input type="hidden" id="OtherssItemsum">
                                            <input type="hidden" id="Othersssum">
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
                                                                        @if ($project->type == 0) checked @endif
                                                                        onchange='chkd(1)' class="cdusd" id="traditional"
                                                                         value="traditional">
                                                                    <span class="check-box-effect"></span>
                                                                </label>
                                                            </td>
                                                            <td>
                                                                <label class="chklabel">
                                                                    <input readonly type="radio"
                                                                        @if ($project->type == 1) checked @endif
                                                                        onchange='chkd(1)' class="cdusd" id="PLC"
                                                                        name="torp" value="PLC">
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
                                            <textarea minlength="5" id="Details"  placeholder="Details" required="required"
                                                autofocus="autofocus">{{ $project->details }}</textarea>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <hr>
                                            <h4>Laser Fees</h4>

                                            <div>

                                                <table id="Laser">
                                                    <tr>
                                                        <td id="laserCuttinglbl" class="laserCuttinglbl pull-right required">
                                                            <label for="laserCutting">Laser Cutting</label>
                                                        </td>
                                                        <td id="laserCuttingtd" class="laserCuttingtd">
                                                            <div class="currencyinput">$</div>
                                                            <input type="number" id="laserCutting"
                                                                value="{{ $project->lasers->laser_cutting }}"
                                                                onchange="sum('lasers');" placeholder="Laser Cutting" readonly
                                                                tabindex="1" autofocus="autofocus" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td id="CNClbl" class="CNClbl pull-right required">
                                                            <label for="CNC">CNC Fee</label>
                                                        </td>
                                                        <td id="CNCtd" class="CNCtd">
                                                            <div class="currencyinput">$</div>
                                                            <input type="number" id="CNC"
                                                                value="{{ $project->lasers->cnc }}"
                                                                onchange="sum('lasers');" placeholder="CNC Fee" readonly
                                                                tabindex="1" autofocus="autofocus" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td id="Tornalbl" class="Tornalbl pull-right required">
                                                            <label for="Torna">Torna</label>
                                                        </td>
                                                        <td id="Tornatd" class="Tornatd">
                                                            <div class="currencyinput">$</div>
                                                            <input type="number" id="Torna"
                                                                value="{{ $project->lasers->torna }}"
                                                                onchange="sum('lasers');" placeholder="Torna" readonly
                                                                tabindex="1" autofocus="autofocus" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td id="Assemblinglbl" class="Assemblinglbl pull-right required">
                                                            <label for="Assembling">Assembling</label>
                                                        </td>
                                                        <td id="Assemblingtd" class="Assemblingtd">
                                                            <div class="currencyinput">$</div>
                                                            <input type="number" id="Assembling"
                                                                value="{{ $project->lasers->assembling }}"
                                                                onchange="sum('lasers');" placeholder="Laser Cutting" readonly
                                                                tabindex="1" autofocus="autofocus" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td id="eandalbl" class="eandalbl pull-right required">
                                                            <label for="eanda">Electric and Automation</label>
                                                        </td>
                                                        <td id="eandalbltd" class="eandalbltd">
                                                            <div class="currencyinput">$</div>
                                                            <input type="number" id="eanda"
                                                                value="{{ $project->lasers->electric_and_automation }}"
                                                                onchange="sum('lasers');"
                                                                placeholder="Electric and Automation" readonly tabindex="1"
                                                                autofocus="autofocus" />
                                                        </td>
                                                    </tr>

                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="1"><label class="pull-right"><strong>Net :
                                                                    </strong></label>
                                                            </td>
                                                            <td>
                                                                <div class="currencyinput">$</div><input id="lasersNet"
                                                                    type="number" value="{{ $project->lasers->total }}"
                                                                    readonly>
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                                <input type="hidden" id="laserssum">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>


                    {{--  new phase --}}
                    <div>

                        <form action="{{ route('projects.update', $project->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div id="contact-form">


                                <div class="row">
                                    <div class="col-12">

                                        <hr>
                                        <h4 class="pull-left">PO Request</h4>
                                        <div class="pull-right">
                                            <label for="serialno">
                                                <span>PO Number: </span>
                                            </label>
                                            <input type="text" id="poserialno" name="poserialno" value="{{ $number }}"
                                                placeholder="Project serial number" min="0" readonly />
                                        </div>
                                    </div>
                                </div>
                                        <div class="row">
                                            <div class="col-12">
                                        <h4>
                                            Motors:
                                        </h4>
                                        <table id="motors">

                                            <tr>
                                                <th>Motor</th>
                                                <th>Item Code</th>
                                                <th>Quantity</th>
                                                <th>Details</th>
                                                <th>Image</th>
                                                <th>Delivery</th>
                                                <th></th>
                                            </tr>
                                            {!! Form::hidden('cnt', $i = 1, [null]) !!}
                                            @foreach ($project->motors as $val)
                                            <input type='hidden' name='motors[{{$i}}][cnti]' value='{{ $val->id }}'>
                                                <tr>
                                                    <td id="motor{{ $i }}" class="motor">
                                                        <input readonly type="text" id="motor{{ $i }}"
                                                            name="motors[{{ $i }}][item]"
                                                            value="{{ $val->motor }}" placeholder="Motor Title"
                                                            tabindex="1" autofocus="autofocus" />
                                                    </td>
                                                    <td id="mcodetd{{ $i }}" class="mcodetd">
                                                        <input type="text" id="code{{ $i }}"
                                                            name="motors[{{ $i }}][code]" value="{{ $val->code }}"
                                                            placeholder="Item Code" tabindex="1" autofocus="autofocus" required />
                                                    </td>
                                                    <td>
                                                        <input type="number" id="qty{{ $i }}"
                                                            name="motors[{{ $i }}][qty]" value="{{ $val->qty }}"
                                                            placeholder="qty" tabindex="1" autofocus="autofocus" />
                                                    </td>
                                                    <td id="mdetailstd{{ $i }}" class="mdetailstd">
                                                        <input type="text" id="title{{ $i }}"
                                                            name="motors[{{ $i }}][details]" value="{{ $val->title }}"
                                                            placeholder="Details" tabindex="1" autofocus="autofocus" />
                                                    </td>
                                                    <td>
                                                        @if($val->photo != null) <div><img width="160" src="{{ URL::asset('uploads/'.$val->photo) }}" alt=""></div> @endif
                                                        <input type="file" id="photo{{ $i }}"
                                                            name="motors[{{ $i }}][photo]" value=""
                                                            placeholder="qty" tabindex="1" autofocus="autofocus" />
                                                    </td>
                                                    <td id="mdeliverytd{{ $i }}" class="mdeliverytd">
                                                        <input type="number" min="1"
                                                            id="delivery{{ $i }}"
                                                            name="motors[{{ $i }}][delivery]" value="{{ $val->delivery }}"
                                                            placeholder="days" tabindex="1" autofocus="autofocus" />
                                                    </td>

                                                    <td>
                                                        <span id="mot{{ $val->id }}"

                                                            class="deltmot editing fa fa-trash"></span>
                                                    </td>
                                                    @if ($i == 1)
                                                        <td id="btns1">
                                                            <div class="addremove">
                                                                <span id="addsp" class="addsp btn btn-warning">+</span>
                                                                <span id="removesp"
                                                                    class="removesp btn btn-warning">-&nbsp;</span>
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
                                        <input type="hidden" id="motorsItemsum">
                                        <input type="hidden" id="motorssum">


                                    </div>
                                </div>

                                <div class="col-12">
                                    <div id="mtl" class="specifications">
                                        <hr>
                                        <h4>Metal:</h4>
                                        <table id="metals">
                                            <tr>
                                                <th>Metal Type</th>
                                                <th>Item Code</th>
                                                <th>qty</th>
                                                <th>Details</th>
                                                <th>Delivery</th>
                                                <th></th>
                                            </tr>
                                            {!! Form::hidden('cnt', $i = 1, [null]) !!}
                                            @foreach ($project->metals as $val)
                                            <input type='hidden' name='metals[{{$i}}][cnti]' value='{{ $val->id }}'>

                                                <tr>
                                                    <td id="metaltd{{ $i }}" class="metaltd">
                                                        <input readonly type="text" id="metaltd{{ $i }}"
                                                            name="metals[{{ $i }}][item]"
                                                            value="{{ $val->metal_type }}" placeholder="Metal"
                                                            required="required" tabindex="1" autofocus="autofocus" />
                                                    </td>
                                                    <td id="tcodetd{{ $i }}" class="tcodetd">
                                                        <input type="text" id="tcode{{ $i }}"
                                                            name="metals[{{ $i }}][code]" value="{{ $val->code }}"
                                                            placeholder="Item Code" tabindex="1" autofocus="autofocus" required />
                                                    </td>
                                                    <td id="tqty{{ $i }}" class="tqtytd">
                                                        <input type="number" id="ttitle{{ $i }}"
                                                            name="metals[{{ $i }}][qty]" value="{{ $val->qty }}"
                                                            placeholder="" tabindex="1" autofocus="autofocus" />
                                                    </td>
                                                    <td id="tdetailstd{{ $i }}" class="tdetailstd">
                                                        <input type="text" id="ttitle{{ $i }}"
                                                            name="metals[{{ $i }}][details]" value="{{ $val->title }}"
                                                            placeholder="Details" tabindex="1" autofocus="autofocus" />
                                                    </td>
                                                    <td id="tdeliverytd{{ $i }}" class="tdeliverytd">
                                                        <input type="number" min="1"
                                                            id="tdelivery{{ $i }}"
                                                            name="metals[{{ $i }}][delivery]" value="{{ $val->delivery }}"
                                                            placeholder="days" tabindex="1" autofocus="autofocus" />
                                                    </td>
                                                    <td>
                                                        <span id="met{{ $val->id }}"

                                                            class="deltmet editing fa fa-trash"></span>
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
                                        <input type="hidden" id="metalsItemsum">
                                        <input type="hidden" id="metalssum">
                                    </div>



                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div id="ot" class="specifications">
                                        <hr>
                                        <h4>Others:</h4>
                                        <small>Heaters, bumps, pipes or othes</small>
                                        <table id="Others">
                                            <tr>
                                                <th>Title</th>
                                                <th>Item Code</th>
                                                <th>qty</th>
                                                <th>Details</th>
                                                <th>Image</th>
                                                <th>Delivery</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                            {!! Form::hidden('cnt', $i = 1, [null]) !!}
                                            @foreach ($project->others as $val)
                                            <input type='hidden' name='other[{{$i}}][cnti]' value='{{ $val->id }}'>

                                                <tr>
                                                    <td id="other{{ $i }}" class="other">
                                                        <input readonly type="text" id="other{{ $i }}"
                                                            name="others[{{ $i }}][item]"
                                                            value="{{ $val->title }}" placeholder="Title"
                                                            required="required" tabindex="1" autofocus="autofocus" />
                                                    </td>




                                                    <td id="ocodetd{{ $i }}" class="ocodetd">
                                                        <input type="text" id="ocode{{ $i }}"
                                                            name="others[{{ $i }}][code]" value="{{ $val->code }}"
                                                            placeholder="Item Code" tabindex="1" autofocus="autofocus" required />
                                                    </td>
                                                    <td id="oqtytd{{ $i }}" class="oqtytd">
                                                        <input type="number" min="1"
                                                            id="oqty{{ $i }}"
                                                            name="others[{{ $i }}][qty]" value="{{ $val->qty }}"
                                                            placeholder="" tabindex="1" autofocus="autofocus" />
                                                    </td>
                                                    <td id="odetailstd{{ $i }}" class="odetailstd">
                                                        <input type="text" id="otitle{{ $i }}"
                                                            name="others[{{ $i }}][details]" value="{{ $val->details }}"
                                                            placeholder="Details" tabindex="1" autofocus="autofocus" />
                                                    </td>
                                                    <td id="ophototd{{ $i }}" class="ophototd">
                                                        @if($val->photo != null) <div><img width="160" src="{{ URL::asset('uploads/'.$val->photo) }}" alt=""></div> @endif
                                                        <input type="file" min="1"
                                                            id="ophoto{{ $i }}"
                                                            name="others[{{ $i }}][photo]" value=""
                                                            placeholder="" tabindex="1" autofocus="autofocus" />
                                                    </td>
                                                    <td id="odeliverytd{{ $i }}" class="odeliverytd">
                                                        <input type="number" min="1"
                                                            id="odelivery{{ $i }}"
                                                            name="others[{{ $i }}][delivery]" value="{{ $val->delivery }}"
                                                            placeholder="days" tabindex="1" autofocus="autofocus" />
                                                    </td>
                                                    <td>
                                                        <span id="oth{{ $val->id }}"

                                                            class="deltoth editing fa fa-trash"></span>
                                                    </td>
                                                    @if ($i == 1)
                                                        <td id="btns1">
                                                            <div class="addremove">
                                                                <span id="addot" class="addot btn btn-warning">+</span>
                                                                <span id="removeot"
                                                                    class="removeot btn btn-warning">-&nbsp;</span>
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

                                        <input type="hidden" id="OthersItemsum">
                                        <input type="hidden" id="Otherssum">
                                        </table>

                                    </div>
                                </div>
                            </div>
                            <button type="submit">Submit</button>
                    </div>
                    <input type="hidden" name="assembling" value="assembling">
                    </form>
                </div>
                <br><br>
                <hr>
                <table>
                    <tr>
                        <td>
                            <div class="comment">


                                <textarea name="managercomment" id="mgrcomment" placeholder="Comment" cols="10" rows="3"></textarea>
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

                @push('custom-scripts')
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
                    <script src="{{ URL::asset('js/scripts.js') }}"></script>
                    <script>

                        $('.deltmot').on('click',function(evt){
                            deltmot($(this).attr('id').replace( /^\D+/g, ''));
                        });
                        function deltmot(num) {
                            if (confirm("Are you sure you want to delete?")) {
                                $.ajax({
                                    type: 'delete',
                                    url: "/dashboard/dmotitem/" + num,
                                    data: {
                                        '_token': $("meta[name='csrf-token']").attr("content"),
                                        'id': num,
                                    },
                                    success: function(data) {
                                        //$("#msg").html(data.msg);
                                        $('#motors tbody').load(document.URL +  ' #motors tbody');
                                    }
                                });
                            } else {
                                return false;
                            }
                        }

                        $('.deltmet').on('click',function(evt){
                            deltmet($(this).attr('id').replace( /^\D+/g, ''));
                        });
                        function deltmet(num) {
                            if (confirm("Are you sure you want to delete?")) {
                                $.ajax({
                                    type: 'delete',
                                    url: "/dashboard/dmetitem/" + num,
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

                        $('.deltoth').on('click',function(evt){
                            deltoth($(this).attr('id').replace( /^\D+/g, ''));
                        });
                        function deltoth(num) {
                            if (confirm("Are you sure you want to delete?")) {
                                $.ajax({
                                    type: 'delete',
                                    url: "/dashboard/dothitem/" + num,
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
                    </script>
                @endpush
            @else
                <h4>Project is Refused By Admin! redirecting to project information</h4>
                @push('custom-scripts')
                    <script>
                        setTimeout(function() {
                            window.location = "/dashboard/projects/{{ $project->id }}";
                        }, 3000);
                    </script>
                @endpush
        @endif
        </div>
        </div>
    @else
        <h3>Not Allowed !</h3>
    @endcan
@endsection
