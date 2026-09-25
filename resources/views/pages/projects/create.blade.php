@extends('home')


@section('articles')
    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
    <style>
        /* Add New Project — tidy header and dimensions layout (#36) */
        .proj-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
            padding-bottom: 14px;
        }
        .proj-head h2 { margin: 0; }
        .contact-form .section-title { margin: 6px 0 14px; }
        .dims-grid {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-end;
            gap: 16px;
            margin-bottom: 10px;
        }
        .dims-grid .dim-field {
            display: flex;
            flex-direction: column;
            gap: 6px;
            width: 140px;
        }
        .dims-grid .dim-field label { margin: 0; }
        .dims-grid .dim-field input { width: 100%; }
        .dims-grid .dim-or {
            display: flex;
            align-items: center;
            padding-bottom: 10px;
            font-weight: 700;
            opacity: 0.75;
        }
    </style>
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
    @can('create-project')
        <div class="rightside">
            <div class="contact-form" id="contact-form">
                <div class="proj-head">
                    <h2>Add New Project</h2>
                    <a class="btn btn-warning" href="{{ route('projects.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
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
                <form method="post" action="{{ route('projects.store') }}" enctype="multipart/form-data">
                    @csrf
                    <fieldset>
                        <div id="phase1">
                            <span id="editbtn1" class="btn btn-info pull-right">edit</span>
                            <div id="fs1">
                                <div class="row">
                                    <div class="col-lg-12 margin-tb">
                                        <div class="pull-left">
                                            <label for="pname">
                                                <span class="required">Title:</span>
                                            </label>
                                            <input type="text" id="pname" name="pname" value=""
                                                placeholder="Project Name" required="required" tabindex="1"
                                                autofocus="autofocus" />
                                        </div>
                                        <div class="pull-right">
                                            <label for="serialno">
                                                <span class="required">Serial Number: </span>
                                            </label>
                                            <input type="text" id="serialno" name="serialno" value="{{ $number }}"
                                                placeholder="Project serial number" required="required" readonly />
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="row">
                                        <div class="col-lg-12 margin-tb">
                                            <h4 class="section-title">Machine Dimensions</h4>
                                            <div class="dims-grid">
                                                <div class="dim-field">
                                                    <label for="L"><span class="required">Length:</span></label>
                                                    <input type="number" id="L" name="L" value=""
                                                        placeholder="Number" min="0" step="0.01"
                                                        tabindex="3" required="required" />
                                                </div>
                                                <div class="dim-field">
                                                    <label for="W"><span class="required">Width:</span></label>
                                                    <input type="number" id="W" name="W" value=""
                                                        placeholder="Number" min="0" step="0.01"
                                                        tabindex="4" required="required" />
                                                </div>
                                                <div class="dim-field">
                                                    <label for="H"><span class="required">Height:</span></label>
                                                    <input type="number" id="H" name="H" value=""
                                                        placeholder="Number" min="0" step="0.01"
                                                        tabindex="5" required="required" />
                                                </div>
                                                <div class="dim-field">
                                                    <label for="units1"><span class="required">Unit:</span></label>
                                                    <input type="text" id="units1" name="units1"
                                                        placeholder="cm" required="required">
                                                </div>
                                                <div class="dim-or"><span>OR</span></div>
                                                <div class="dim-field">
                                                    <label for="volume"><span class="required">Volume:</span></label>
                                                    <input type="number" id="volume" name="volume" value=""
                                                        placeholder="Number" tabindex="6" required="required"
                                                        min="0" step="0.01" />
                                                </div>
                                                <div class="dim-field">
                                                    <label for="units2"><span class="required">Unit:</span></label>
                                                    <input type="text" id="units2" name="units2"
                                                        placeholder="m³" required="required">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 margin-tb">
                                        <div class="pull-left">
                                            <label for="dp">
                                                <span class="required">Machine Voltage:</span>
                                            </label>
                                            <select name="voltage" id="voltage" tabindex="7" required="required">
                                                <option value="220">220 v</option>
                                                <option value="380">380 v</option>
                                            </select>
                                        </div>
                                        <div class="pull-right">
                                            <label for="photo">
                                                <span class="required">Machine Photo:</span>
                                            </label>
                                            <input type="file" accept="image/*" id="photo" name="photo"
                                                value="" placeholder="Select a picture" tabindex="7"
                                                required="required" />
                                        </div>
                                    </div>
                                    <div class="pull-left">
                                        <span id="toPhase2" class="btn btn-success" tabindex="8">Next</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="phase2">
                            <div id="mtrs" class="specifications">
                                <hr>
                                <h4>Specifications:</h4>
                                <span id="editbtn2" class="btn btn-info pull-right">edit</span>
                                <div>
                                    <div id="mtr" class="specifications">
                                        <h4>Motors:</h4>
                                        <table id="motors">
                                            <tr>
                                                <th class="required">Motor</th>
                                                <th class="required">Power</th>
                                                <th class="required">Unit</th>
                                                <th>Title</th>
                                                <th></th>
                                            </tr>
                                            <tr>
                                                <td id="motor" class="motor">
                                                    <input type="text" id="motor1" name="motors[1][motor]"
                                                        value="" placeholder="motor" required="required"
                                                        tabindex="1" autofocus="autofocus" />
                                                </td>
                                                <td id="power" class="power">
                                                    <input type="number" min="0" step="0.01" id="power1"
                                                        name="motors[1][power]" value="" placeholder="power"
                                                        required="required" tabindex="1" autofocus="autofocus" />
                                                </td>
                                                <td id="munit" class="unit">
                                                    <input type="text" min="0" id="unit1"
                                                        name="motors[1][unit]" value="" placeholder="cm"
                                                        required="required" autofocus="autofocus" />
                                                </td>
                                                <td id="title" class="title">
                                                    <input type="text" id="title1" name="motors[1][title]"
                                                        value="" placeholder="title" tabindex="1"
                                                        autofocus="autofocus" />
                                                    <input type="hidden" value="1" id="total_spc">
                                                </td>
                                                <td id="btns1">
                                                    <div class="addremove">
                                                        <span id="addsp" class="addsp btn btn-warning">+</span>
                                                        <span id="removesp" class="removesp btn btn-warning">-&nbsp;</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div id="mtl" class="specifications">
                                        <hr>
                                        <h4>Metal:</h4>
                                        <table id="metals">
                                            <tr>
                                                <th class="required">Metal Type</th>
                                                <th class="required">Thickness</th>
                                                <th class="required">Unit</th>
                                                <th>Title</th>
                                                <th></th>
                                            </tr>
                                            <tr>
                                                <td id="metaltd" class="metaltd">
                                                    <input type="text" id="metaltd1" name="metals[1][metal]"
                                                        value="" placeholder="Metal" required="required"
                                                        tabindex="1" autofocus="autofocus" />
                                                </td>
                                                <td id="thicknesstd" class="thicknesstd">
                                                    <input type="number" min="0" step="0.01" id="thicknesstd1"
                                                        name="metals[1][thickness]" value="" placeholder="Thickness"
                                                        required="required" tabindex="1" autofocus="autofocus" />
                                                </td>
                                                <td id="thkunittd" class="thkunittd">

                                                    <input type="text" id="thkunit1" class="thkunit"
                                                        name="metals[1][unit]" value="" placeholder="cm"
                                                        required="required" autofocus="autofocus" />

                                                    {{-- <select id="thkunit1" class="thkunit" name="metals[1][unit]"
                                                        required="required"
                                                        tabindex="1" autofocus="autofocus">
                                                        <option value="cm">centimeter</option>
                                                        <option value="decimeter">decimeter</option>
                                                    </select> --}}
                                                </td>
                                                <td id="titletd" class="titletd">
                                                    <input type="text" id="titletd1" name="metals[1][title]"
                                                        value="" placeholder="Title" tabindex="1"
                                                        autofocus="autofocus" />
                                                    <input type="hidden" value="1" id="total_mtl">
                                                </td>
                                                <td id="btns2">
                                                    <div class="addremove">
                                                        <span type="button" id="addmt"
                                                            class="addmt btn btn-warning">+</span>
                                                        <span type="button" id="removemt"
                                                            class="removemt btn btn-warning">-&nbsp;</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div id="ot" class="specifications">
                                        <hr>
                                        <h4>Others:</h4>
                                        <small>Heares, pumbs, pipes or othes</small>
                                        <table id="Others">
                                            <tr>
                                                <th class="required">Title</th>
                                                <th class="required">Info</th>
                                                <th>Details</th>
                                                <th></th>
                                            </tr>
                                            <tr>
                                                <td id="other" class="other">
                                                    <input type="text" id="other1" name="others[1][title]"
                                                        value="" placeholder="Title" required="required"
                                                        tabindex="1" autofocus="autofocus" />
                                                </td>
                                                <td id="info" class="info">
                                                    <input type="text" id="info1" name="others[1][info]"
                                                        value="" placeholder="Info" required="required" tabindex="1"
                                                        autofocus="autofocus" />
                                                </td>
                                                <td id="details" class="details">
                                                    <input type="text" id="details1" name="others[1][details]"
                                                        value="" placeholder="Details" tabindex="1"
                                                        autofocus="autofocus" />
                                                    <input type="hidden" value="1" id="total_ot">
                                                </td>
                                                <td id="btns1">
                                                    <div class="addremove">
                                                        <span id="addot" class="addot btn btn-warning">+</span>
                                                        <span id="removeot" class="removeot btn btn-warning">-&nbsp;</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>

                                    </div>
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

                                                                <input type="radio" onchange='chkd(1)' checked
                                                                    class="cdusd" id="traditional" name="torp"
                                                                    value="traditional">
                                                                <span class="check-box-effect"></span>
                                                            </label>
                                                        </td>
                                                        <td>
                                                            <label class="chklabel">
                                                                <input type="radio" onchange='chkd(1)' class="cdusd"
                                                                    id="PLC" name="torp" value="PLC">
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
                                        <textarea minlength="5" id="Details" name="edetails" value="" placeholder="Details" required="required"
                                            autofocus="autofocus"></textarea>
                                        <div class="row">
                                            <div class="col-lg-12 margin-tb">
                                                <label for="drawing">
                                                    <span class="required">Drawing Delivery Time:</span>
                                                </label>
                                                <input required type="number" name="dtime">
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <span id="toPhase3" class="btn btn-success">Next</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="phase3" class="phase3 ">
                            <div class="row">
                                <div class="col-lg-12 margin-tb">
                                    <hr>
                                    <div class="pull-left">
                                        <span id="printpdf" class="btn btn-warning fa fa-file-pdf-o"> Print pdf</span>
                                    </div>
                                    {{-- this select is to select an admin who will review the application --}}
                                    <div class="pull-right">
                                        <label for="adminselect">Select Admin: </label>
                                        <select name="adminselect" id="adminselect">
                                            @foreach ($data as $key => $usr)
                                                @if (!empty($usr->getRoleNames()))
                                                    @foreach ($usr->getRoleNames() as $v)
                                                        @if ($v == 'Admin')
                                                            <option value="{{ $usr->id }}">{{ $usr->name }}</option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <br><br><br>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <button class="btn btn-warning" name="submit" type="submit" id="submit">SEND</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>

        @push('custom-scripts')
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
            <script src="{{ URL::asset('js/scripts.js') }}"></script>
        @endpush
    @else
        <h3>Not Allowed !</h3>
    @endcan
@endsection
