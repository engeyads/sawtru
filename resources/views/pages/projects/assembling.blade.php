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
    <form action="{{ route('projects.update', $project->id) }}" method="POST" enctype="multipart/form-data">
        <div class="rightside">
            <div class="contact-form" id="contact-form">
                @csrf
                @method('PUT')

                @can('create-project')
                @if ($project->uid == auth()->user()->id || $project->admin == auth()->user()->id)
                    @if ($project->isApproved == 1 && $project->phase == 0)
                        <div>
                            <div>
                                <div>
                                    <a class="btn btn-warning" href="{{ route('projects.index') }}"><i
                                            class="fa fa-arrow-left"></i>
                                        Back</a>
                                </div>
                                <div>
                                    <h2>Project Assembling</h2>


                                </div>
                            </div>
                        </div>

                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>{{ $message }}</p>
                            </div>
                        @endif



                        <div id="phase1">
                            <span id="editbtn1" class="btn btn-info pull-right">edit</span>

                            <div class="row">
                                <div class="col-lg-12 margin-tb">
                                    <div class="pull-left">
                                        <label for="pname">
                                            <span>Title:</span>
                                        </label>
                                        <input type="text" id="pname" name="pname" value="{{ $project->pname }}"
                                            placeholder="Project Name" tabindex="1" autofocus="autofocus" readonly />
                                    </div>
                                    <div class="pull-right">
                                        <label for="serialno">
                                            <span>Serial Number: </span>
                                        </label>
                                        <input type="text" id="serialno" name="serialno" value="{{ $project->serial_no }}"
                                            placeholder="Project serial number" min="0" readonly />
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="row">
                                    <div class="col-lg-12 margin-tb">
                                        <hr>
                                        <h4>Machine Dimentions: </h4>
                                        <div class="pull-left">
                                            <table>
                                                <tr>
                                                    @if($project->width != '')
                                                    <td style="max-width:85px">
                                                        <label for="L">
                                                            <span>Length:</span>
                                                        </label>
                                                        <input type="number" min="0" id="L" name="L"
                                                            value="{{ $project->length }}" placeholder="number" min="0"
                                                            tabindex="3" readonly />
                                                    </td>
                                                    <td style="max-width:85px">
                                                        <label for="W">
                                                            <span>Width:</span>
                                                        </label>
                                                        <input type="number" min="0" id="W" name="W"
                                                            value="{{ $project->width }}" placeholder="number" min="0"
                                                            tabindex="4" readonly />
                                                    </td>
                                                    <td style="max-width:85px">
                                                        <label for="H">
                                                            <span>Height:</span>
                                                        </label>
                                                        <input type="number" min="0" id="H" name="H"
                                                            value="{{ $project->height }}" placeholder="number" min="0"
                                                            tabindex="5" readonly />
                                                    </td>
                                                    <td>
                                                        <label for="units1">
                                                            <span >Unit:</span>
                                                        </label>
                                                            <input value="{{ $project->unit }}">
                                                    </td>
                                                    @endif

                                                    @if($project->volume != '')
                                                    <td>
                                                        <label for="volume">
                                                            <span>Volume:</span>
                                                        </label>
                                                        <input type="number"  id="volume" name="volume" value="{{ $project->volume }}"
                                                            placeholder="Number" tabindex="6" required="required" readonly />
                                                    </td>
                                                        <td>
                                                            <label for="units1">
                                                                <span >Unit:</span>
                                                            </label>
                                                            <input type="text" tabindex="6" required="required" readonly
                                                                value="{{ $project->cubic_unit }}">

                                                        </td>
                                                        @endif
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 margin-tb">
                                    <div class="pull-left">
                                        <label for="asd">
                                            <span class="required">Assembling Diagram :</span>
                                        </label>
                                        <input type='file' accept="image/*" multiple name="asd[]" id="asd"
                                            required="required" />
                                    </div>
                                </div>
                                <div class="col-lg-6 margin-tb">
                                    <div class="pull-right">
                                        <label for="mtd">
                                            <span class="required">Machine 3D :</span>
                                        </label>
                                        <input type='file' accept="image/*" multiple name="mtd[]" id="mtd"
                                            required="required" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 margin-tb">
                                    <div class="pull-left">
                                        <label for="Horizontal">
                                            <span class="required">Horizontal :</span>
                                        </label>
                                        <input type='file' accept="image/*" multiple name="Horizontal[]" id="Horizontal"
                                            tabindex="7" required="required" />
                                    </div>
                                </div>
                                <div class="col-lg-6 margin-tb">
                                    <div class="pull-right">
                                        <label for="Vertical">
                                            <span class="required">Vertical :</span>
                                            <input type='file' accept="image/*" multiple name="Vertical[]" id="Vertical"
                                                tabindex="7" required="required" />
                                        </label>
                                    </div>
                                </div>
                                <div class="pull-right">
                                    <span id="toPhase2" class="btn btn-success" tabindex="8">Next</span>
                                </div>
                            </div>

                        </div>
                        <div id="phase2">
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
                                            <th class="required">Motor</th>
                                            <th class="required">Power</th>
                                            <th class="required">Unit</th>
                                            <th class="required">Quantity</th>
                                            <th class="required">Unit Price</th>
                                            <th class="required">Total Price</th>
                                            <th class="required">Photo</th>
                                            <th></th>
                                        </tr>
                                        {!! Form::hidden('cnt', $i = 1, [null]) !!}
                                        @foreach ($project->motors as $val)
                                            <tr>
                                                <input type="hidden" name="motors[{{ $i }}][motorreal]"
                                                    value="{{ $val->motor }}">
                                                <td id="motortd{{ $i }}" class="motortd">
                                                    <input type="text" id="motor{{ $i }}"
                                                        name="motors[{{ $i }}][motor]"
                                                        value="{{ $val->motor }}" placeholder="motor" readonly
                                                        required="required" tabindex="1" autofocus="autofocus" />
                                                </td>

                                                <td id="power" class="power">
                                                    <input type="number" min="0" step="0.01" id="power1"
                                                        name="motors[1][power]" value="{{ $val->Power }}" placeholder="power"
                                                        required="required" tabindex="1" autofocus="autofocus" />
                                                </td>
                                                <td id="munit" class="unit">
                                                    <input type="text" min="0" id="unit1"
                                                        name="motors[1][unit]" value="{{ $val->unit }}" placeholder="cm"
                                                        required="required" autofocus="autofocus" />
                                                </td>

                                                <td id="qtytd{{ $i }}" class="qtytd">
                                                    <input type="number" min="1" id="qty{{ $i }}"
                                                        name="motors[{{ $i }}][qty]"
                                                        onchange=" $('#total{{ $i }}').val($('#qty{{ $i }}').val()*$('#price{{ $i }}').val()); sum('motors');"
                                                        value="1" placeholder="qty" required="required" tabindex="1"
                                                        autofocus="autofocus" />
                                                </td>
                                                <td id="pricetd{{ $i }}" class="pricetd">
                                                    <div class="currencyinput">$</div>
                                                    <input type="number" min="0" id="price{{ $i }}"
                                                        name="motors[{{ $i }}][price]"
                                                        onchange=" $('#total{{ $i }}').val($('#qty{{ $i }}').val()*$('#price{{ $i }}').val()); sum('motors');"
                                                        value="0" placeholder="price" required="required"
                                                        tabindex="1" autofocus="autofocus" />
                                                </td>
                                                <td id="totaltd{{ $i }}" class="totaltd">
                                                    <div class="currencyinput">$</div>
                                                    <input type="number" min="0" id="total{{ $i }}"
                                                        name="motors[{{ $i }}][total]" value="0"
                                                        placeholder="Total" required="required" readonly
                                                        autofocus="autofocus" />
                                                </td>
                                                <td id="mtphoto{{ $i }}" class="mtphoto">
                                                    <input type="file" id="mtphoto{{ $i }}"
                                                        name="motors[{{ $i }}][photo]"
                                                        placeholder="Select Photo" required="required"
                                                        autofocus="autofocus" />
                                                </td>
                                                @if ($i == 1)
                                                    <td id="btns3">
                                                        <div class="addremove">
                                                            <span id="addmtrs" class="addmtrs btn btn-warning">+</span>
                                                            <span id="removemtrs"
                                                                class="removemtrs btn btn-warning">-&nbsp;</span>
                                                            <input type="hidden" value="1" id="total_addmtrs">
                                                        </div>
                                                    </td>
                                                @else
                                                    <td>

                                                    </td>
                                                @endif
                                            </tr>
                                            {!! Form::hidden('cnt', $i++, [null]) !!}
                                        @endforeach
                                        <tfoot>
                                            <tr>
                                                <td colspan="4"><label class="pull-right"><strong>Net : </strong></label>
                                                </td>
                                                <td><div class="currencyinput">$</div><input id="motorsItemNet" type="number" value="0" readonly></td>
                                                <td><div class="currencyinput">$</div><input id="motorsTotalNet" type="number" value="0" readonly></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <input type="hidden" id="motorsItemsum">
                                    <input type="hidden" id="motorssum">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <hr>

                                    <h4>
                                        Metal:
                                    </h4>
                                    <table id="metals">
                                        <tr>
                                            <th class="required">Metal</th>
                                            <th class="required">Thickness</th>
                                            <th class="required">Unit</th>
                                            <th class="required">Quantity</th>
                                            <th class="required">Unit Price</th>
                                            <th class="required">Total Price</th>
                                            <th></th>
                                        </tr>
                                        {!! Form::hidden('cnt', $i = 1, [null]) !!}
                                        @foreach ($project->metals as $val)
                                            <tr>
                                                <input type="hidden" name="metals[{{ $i }}][metalreal]"
                                                    value="{{ $val->metal_type }}">

                                                <td id="metaltd{{ $i }}" class="metaltd">
                                                    <input type="text" id="metal{{ $i }}"
                                                        name="metals[{{ $i }}][metal]" readonly
                                                        value="{{ $val->metal_type }}" placeholder="Metal"
                                                        required="required" tabindex="1" autofocus="autofocus" />
                                                </td>

                                                <td id="thicknesstd" class="thicknesstd">
                                                    <input type="number" min="0" step="0.01" id="thicknesstd1"
                                                        name="metals[1][thickness]" value="{{ $val->thickness }}" placeholder="Thickness"
                                                        required="required" tabindex="1" autofocus="autofocus" />
                                                </td>
                                                <td id="thkunittd" class="thkunittd">

                                                    <input type="text" id="thkunit1" class="thkunit"
                                                        name="metals[1][unit]" value="{{ $val->unit }}" placeholder="cm"
                                                        required="required" autofocus="autofocus" />

                                                    {{-- <select id="thkunit1" class="thkunit" name="metals[1][unit]"
                                                        required="required"
                                                        tabindex="1" autofocus="autofocus">
                                                        <option value="cm">centimeter</option>
                                                        <option value="decimeter">decimeter</option>
                                                    </select> --}}
                                                </td>

                                                <td id="mtqtytd{{ $i }}" class="qtytd">
                                                    <input type="number" min="1" id="mtqty{{ $i }}"
                                                        name="metals[{{ $i }}][qty]"
                                                        onchange=" $('#mttotal{{ $i }}').val($('#mtqty{{ $i }}').val()*$('#mtprice{{ $i }}').val()); sum('metals');"
                                                        value="1" placeholder="qty" required="required" tabindex="1"
                                                        autofocus="autofocus" />
                                                </td>
                                                <td id="mtpricetd{{ $i }}" class="pricetd">
                                                    <div class="currencyinput">$</div>
                                                    <input type="number" min="0" id="mtprice{{ $i }}"
                                                        name="metals[{{ $i }}][price]"
                                                        onchange=" $('#mttotal{{ $i }}').val($('#mtqty{{ $i }}').val()*$('#mtprice{{ $i }}').val()); sum('metals');"
                                                        value="0" placeholder="price" required="required"
                                                        tabindex="1" autofocus="autofocus" />
                                                </td>
                                                <td id="mttotaltd{{ $i }}" class="totaltd">
                                                    <div class="currencyinput">$</div>
                                                    <input type="number" min="0" id="mttotal{{ $i }}"
                                                        name="metals[{{ $i }}][total]" value="0"
                                                        placeholder="Total" required="required" tabindex="1" readonly
                                                        autofocus="autofocus" />
                                                </td>
                                                @if ($i == 1)
                                                    <td id="btns4">
                                                        <div class="addremove">
                                                            <span id="addmtls" class="addmtls btn btn-warning">+</span>
                                                            <span id="removemtls"
                                                                class="removemtls btn btn-warning">-&nbsp;</span>
                                                            <input type="hidden" value="1" id="total_addmtls">
                                                        </div>
                                                    </td>
                                                @else
                                                    <td>

                                                    </td>
                                                @endif
                                            </tr>
                                            {!! Form::hidden('cnt', $i++, [null]) !!}
                                        @endforeach
                                        <tfoot>
                                            <tr>
                                                <td colspan="4"><label class="pull-right"><strong>Net : </strong></label>
                                                </td>
                                                <td><div class="currencyinput">$</div><input id="metalsItemNet" type="number" value="0" readonly></td>
                                                <td><div class="currencyinput">$</div><input id="metalsTotalNet" type="number" value="0" readonly></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <input type="hidden" id="metalsItemsum">
                                    <input type="hidden" id="metalssum">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <hr>

                                    <h4>
                                        Others:
                                    </h4>

                                    <table id="Others">

                                        <tr>
                                            <th class="required">Title</th>
                                            <th class="required">Info</th>
                                            <th class="required">Quantity</th>
                                            <th class="required">Unit Price</th>
                                            <th class="required">Total Price</th>
                                            <th></th>
                                        </tr>
                                        {!! Form::hidden('cnt', $i = 1, [null]) !!}
                                        @foreach ($project->others as $val)
                                            <tr>
                                                <input type="hidden" name="others[{{ $i }}][titlereal]"
                                                    value="{{ $val->title }}">
                                                <td id="othertd{{ $i }}" class="othertd">
                                                    <input type="text" id="other{{ $i }}"
                                                        name="others[{{ $i }}][title]" readonly
                                                        value="{{ $val->title }}" placeholder="Title" required="required"
                                                        tabindex="1" autofocus="autofocus" />
                                                </td>

                                                <td id="info" class="info">
                                                    <input type="text" id="info1" name="others[1][info]"
                                                        value="" placeholder="Info" required="required" tabindex="1"
                                                        autofocus="autofocus" />
                                                </td>

                                                <td id="otqtytd{{ $i }}" class="qtytd">
                                                    <input type="number" min="0" id="oqty{{ $i }}"
                                                        name="others[{{ $i }}][qty]"
                                                        onchange=" $('#ototal{{ $i }}').val($('#oqty{{ $i }}').val()*$('#oprice{{ $i }}').val()); sum('Others');"
                                                        value="1" placeholder="qty" required="required" tabindex="1"
                                                        autofocus="autofocus" />
                                                </td>
                                                <td id="otpricetd{{ $i }}" class="pricetd">
                                                    <div class="currencyinput">$</div>
                                                    <input type="number" min="0" id="oprice{{ $i }}"
                                                        name="others[{{ $i }}][price]"
                                                        onchange=" $('#ototal{{ $i }}').val($('#oqty{{ $i }}').val()*$('#oprice{{ $i }}').val()); sum('Others');"
                                                        value="0" placeholder="price" required="required"
                                                        tabindex="1" autofocus="autofocus" />
                                                </td>
                                                <td id="ottotaltd{{ $i }}" class="totaltd">
                                                    <div class="currencyinput">$</div>
                                                    <input type="number" min="0" id="ototal{{ $i }}"
                                                        name="others[{{ $i }}][total]" value="0"
                                                        placeholder="Total" required="required" tabindex="1"
                                                        autofocus="autofocus" readonly />
                                                </td>
                                                @if ($i == 1)
                                                    <td id="btns5">
                                                        <div class="addremove">
                                                            <span id="addothr" class="addothr btn btn-warning">+</span>
                                                            <span id="removeothr"
                                                                class="removeothr btn btn-warning">-&nbsp;</span>
                                                            <input type="hidden" value="1" id="total_addothr">
                                                        </div>
                                                    </td>
                                                @else
                                                    <td>

                                                    </td>
                                                @endif

                                            </tr>
                                            {!! Form::hidden('cnt', $i++, [null]) !!}
                                        @endforeach
                                        <tfoot>
                                            <tr>
                                                <td colspan="3"><label class="pull-right"><strong>Net : </strong></label>
                                                </td>
                                                <td><div class="currencyinput">$</div><input id="OthersItemNet" type="number" value="0" readonly></td>
                                                <td><div class="currencyinput">$</div><input id="OthersTotalNet" type="number" value="0" readonly></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <input type="hidden" id="OthersItemsum">
                                    <input type="hidden" id="Otherssum">
                                </div>
                            </div>

                            <div id="mtl" class="specifications">
                                <hr>
                                <h4>Laser :</h4>
                                <div>

                                    <table id="Laser">
                                        <tr>
                                            <td id="laserCuttinglbl" class="laserCuttinglbl pull-right required">
                                                <label for="laserCutting">Laser Cutting</label>
                                            </td>
                                            <td id="laserCuttingtd" class="laserCuttingtd">
                                                <div class="currencyinput">$</div>
                                                <input type="number" id="laserCutting" name="laserCutting" value="0" onchange="sum('lasers');"
                                                    placeholder="Laser Cutting" required="required" tabindex="1"
                                                    autofocus="autofocus" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td id="CNClbl" class="CNClbl pull-right required">
                                                <label for="CNC">CNC Fee</label>
                                            </td>
                                            <td id="CNCtd" class="CNCtd">
                                                <div class="currencyinput">$</div>
                                                <input type="number" id="CNC" name="CNC" value="0" onchange="sum('lasers');"
                                                    placeholder="CNC Fee" required="required" tabindex="1"
                                                    autofocus="autofocus" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td id="Tornalbl" class="Tornalbl pull-right required">
                                                <label for="Torna">Torna</label>
                                            </td>
                                            <td id="Tornatd" class="Tornatd">
                                                <div class="currencyinput">$</div>
                                                <input type="number" id="Torna" name="Torna" value="0" onchange="sum('lasers');"
                                                    placeholder="Torna" required="required" tabindex="1"
                                                    autofocus="autofocus" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td id="Assemblinglbl" class="Assemblinglbl pull-right required">
                                                <label for="Assembling">Assembling</label>
                                            </td>
                                            <td id="Assemblingtd" class="Assemblingtd">
                                                <div class="currencyinput">$</div>
                                                <input type="number" id="Assembling" name="Assembling" value="0" onchange="sum('lasers');"
                                                    placeholder="Laser Cutting" required="required" tabindex="1"
                                                    autofocus="autofocus" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td id="eandalbl" class="eandalbl pull-right required">
                                                <label for="eanda">Electric and Automation</label>
                                            </td>
                                            <td id="eandalbltd" class="eandalbltd">
                                                <div class="currencyinput">$</div>
                                                <input type="number" id="eanda" name="eanda" value="0" onchange="sum('lasers');"
                                                    placeholder="Electric and Automation" required="required" tabindex="1"
                                                    autofocus="autofocus" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td id="dtimelbl" class="dtimelbl pull-right required">
                                                <label for="dtime">Delivery Time</label>
                                            </td>
                                            <td id="dtimetd" class="dtimetd">
                                                <input type="number" id="dtime" name="dtime" value=""
                                                    placeholder="Delivery Time" required="required" tabindex="1"
                                                    autofocus="autofocus" />
                                            </td>
                                        </tr>
                                        <tfoot>
                                            <tr>
                                                <td colspan="1"><label class="pull-right"><strong>Net : </strong></label>
                                                </td>
                                                <td><div class="currencyinput">$</div><input id="lasersNet" type="number" value="0" readonly></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <input type="hidden" id="laserssum">
                                </div>
                            </div>

                            <div>
                                <span id="toPhase3" class="btn btn-success">Next</span>
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
                        <button class="btn btn-warning" name="submit" type="submit" id="submit">Submit</button>
                    </div>
                </div>
                <input type="hidden" name="assembling" value="assembling">
        </form>
        <table>
            <tr>
                <td>
                    <div class="comment">

                        <label for="managercomment">Comment:</label>
                        <textarea  name="managercomment" id="mgrcomment" cols="10" rows="3"></textarea>
                        <span class="btn btn-warning pull-right" onclick="submitComment({{ $project->serial_no }},{{ Auth::user()->id }},{{ $project->uid }})">Send</span>
                    </div>
                </td>
            </tr>
        </table>
        <div id="comments-table" class="comments-container">
            <table>
                @foreach ($project->comments as $comment)
                    @if($comment->available == 1)
                    <tr id="cmnt{{ $comment->id }}">
                        <td >
                            <div id="cmntuser{{ $comment->id }}" class="comments-username">
                                <b>{{ $comment->user->name }}</b><br>

                            </div>
                            @if ($comment->byid == Auth::user()->id && date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s'))) < date('Y-m-d H:i:s', strtotime($comment->created_at . ' + 5 minutes')) )
                            <div class="comments-remove" onclick="deleteComment({{ $comment->id }})">

                            </div>
                            @endif

                            <div class="comments">
                                {{ $comment->content }}
                            </div>
                            <div class="comments-timestamp">
                                <small >{{ $comment->created_at }}</small>
                            </div>
                        </td>
                    </tr>
                    @endif
                @endforeach
            </table>
        </div>
    </div>
        @push('custom-scripts')
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
            <script src="{{ URL::asset('js/scripts.js') }}"></script>
            <script>
                $('input').on('change',function(){
                        $('#lasersNet').val(
                            (isNaN($('#metalsTotalNet').val()) ? 0 : parseFloat($('#metalsTotalNet').val()))+
                            (isNaN($('#motorsTotalNet').val()) ? 0 : parseFloat($('#motorsTotalNet').val()))+
                            (isNaN($('#OthersTotalNet').val()) ? 0 : parseFloat($('#OthersTotalNet').val()))+
                            (isNaN($('#laserCutting').val()) ? 0 : parseFloat($('#laserCutting').val()))+
                            (isNaN($('#CNC').val()) ? 0 : parseFloat($('#CNC').val()))+
                            (isNaN($('#Torna').val()) ? 0 : parseFloat($('#Torna').val()))+
                            (isNaN($('#Assembling').val()) ? 0 : parseFloat($('#Assembling').val()))+
                            (isNaN($('#eanda').val()) ? 0 : parseFloat($('#eanda').val()))
                        );
                });
                function submitComment(projectSerialNumber,LogedinUserId,projectUserId){
                    if($('#mgrcomment').val() != ''){
                        $.ajax({
                            type: 'put',
                            url: "/dashboard/comment/",
                            data: {
                                '_token' : $("meta[name='csrf-token']").attr("content"),
                                'serial' : projectSerialNumber,
                                'byid' : LogedinUserId,
                                'toid' : projectUserId,
                                'content' : $('#mgrcomment').val(),
                            },
                            success: function(data) {
                                row = $("<tr id='cmnt"+ data.data.id +"'></tr>");
                                col1 = $('<td ><div id="cmntuser'+data.data.id+'" class="comments-username"><b>you</b><br></div><div class="comments-remove" onclick="deleteComment(' + data.data.id + ')"></div><div class="comments">'+data.data.content+'</div><div class="comments-timestamp">    <small>'+new Date(data.data.created_at)+'</small></div></td>');
                                row.append(col1).prependTo("#comments-table table");
                            }
                        });
                    }
                }
                function deleteComment(commentId){
                    $.ajax({
                        type: 'delete',
                        url: "/dashboard/comment/"+commentId,
                        data: {
                            '_token' : $("meta[name='csrf-token']").attr("content"),
                            'id' : commentId,
                        },
                        success: function(data) {
                            $("#comments-table tr#cmnt"+data.data.id).remove();
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
            <h3>Not Allowed !</h3>
        @endif

    @else
    <h3>Not your project !</h3>
        @endif
    @endcan
    </div>
    </div>
@endsection
