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


    @can('create-project')
        <div class="rightside">
            <div id="contact-form">
                <div>
                    <div>
                        <div>
                            <a class="btn btn-primary" href="{{ route('projects.index') }}"> Back</a>
                        </div>
                        <div>
                            <h2>Add New Project</h2>
                        </div>

                    </div>
                </div>
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif


                <form method="post" action="{{ route('projects.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12 margin-tb">
                            <div class="pull-left">
                                <label for="pname">
                                    <span class="required">Title: *</span>
                                </label>
                                <input type="text" id="pname" name="pname" value="" placeholder="Project Name"
                                    required="required" tabindex="1" autofocus="autofocus" />
                            </div>
                            <div class="pull-right">
                                <label for="serialno">
                                    <span class="required">Serial Number: </span>
                                </label>
                                <input type="text" id="serialno" name="serialno" value="000001" placeholder="Project serial number"
                                    required="required" readonly />
                            </div>
                        </div>

                    </div>
                    <div>
                        <div class="row">
                            <div class="col-lg-12 margin-tb">
                                <div class="pull-left">

                                    <label for="photo">
                                        <span class="required">Picture: *</span>
                                    </label>
                                    <div class="couple">
                                    <input type="file" id="photo" accept="image/*" name="photo" value=""
                                        placeholder="select Picture" tabindex="2" required="required" />
                                    </div>
                                    <img class="pics" id="picimg" src="{{ asset('images/na.png') }}" alt="your image" />
                                    <br><br>
                                </div>
                                <div class="pull-right">
                                    <label for="dp">
                                        <span class="required">Description Pictures: *</span>
                                    </label>
                                    <div class="couple">
                                        <input type="file" multiple id="dp" accept="image/*" name="dp[]" value=""
                                            placeholder="select Picture" tabindex="2" required="required" />
                                        <div id="dpdisplay" class="descriptionpic"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="gse" class="specifications">
                        <span>General Spesifications:</span><br><br>
                        <table id="gst">
                            <tr>
                                <th>Info Title</th>
                                <th>Value</th>
                            </tr>
                            <tr>
                                <td id="gsplab">
                                    <input type="text" id="gslab1" name="specifications[1][gslab]" value=""
                                        placeholder="Power" required="required" tabindex="1" autofocus="autofocus" />
                                </td>
                                <td id="gspval">
                                    <input type="text" id="gsval1" name="specifications[1][gsval]" value=""
                                        placeholder="120" required="required" tabindex="1" autofocus="autofocus" />
                                    <input type="hidden" value="1" id="total_spc">
                                </td>
                                <td id="btns1">
                                    <div class="addremove">
                                        <input type="button" id="addsp" class="addsp" value="+">
                                        <input type="button" id="removesp" class="removesp" value="-">
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <textarea id="expesc" name="expesc" value="" placeholder="Description for Expected Specifications"
                            required="required" tabindex="1" autofocus="autofocus"></textarea>
                    </div>
                    <div class="costdetails">
                        <span>Cost Details:</span><br><br>
                        <table id="cdt">
                            <tr>
                                <th>Item</th>
                                <th>Expected Price</th>
                                <th>Actual Price</th>
                                <th>USD</th>
                                <th>Picture</th>
                                <th>KDV</th>
                            </tr>
                            <tr>
                                <td id="prexplab">
                                    <input type="text" class="cdlbl" id="cdlbl1" name="costdetails[1][cdlbl]"
                                        value="" placeholder="pump" required="required" tabindex="1"
                                        autofocus="autofocus" />
                                </td>
                                <td id="prexpval">
                                    <input type="number" class="cdepr" id="cdepr1" name="costdetails[1][cdepr]"
                                        value="" min="0" placeholder="1500" required="required" tabindex="1"
                                        autofocus="autofocus" />
                                </td>
                                <td id="practval" class="practval">
                                    <input type="number" onchange='practvalsum(this,1)' class="cdapr" id="cdapr1"
                                        name="costdetails[1][cdapr]" value="" min="0" placeholder="1400"
                                        required="required" tabindex="1" autofocus="autofocus" />
                                </td>
                                <td id="practusd" class="practusd">
                                    <label class="chklabel">
                                        <input type="checkbox" onchange='chkd(1)' class="cdusd" id="cdusd1"
                                            name="costdetails[1][cdusd]" value="USD">
                                        <span class="check-box-effect"></span>
                                    </label>
                                </td>
                                <td id="practpic">
                                    <input type="file" class="cdimg" id="cdimg1" accept="image/*"
                                        name="costdetails[1][cdimg]" placeholder="select Picture" tabindex="1"
                                        autofocus="autofocus" />
                                </td>
                                <td id="practkdv" class="practkdv">
                                    <label class="chklabel">
                                        <input type="checkbox" class="cdkdv" id="cdkdv1" name="costdetails[1][cdkdv]"
                                            value="KDV">
                                        <span class="check-box-effect"></span>
                                    </label>
                                    <input type="hidden" value="1" id="total_chq">
                                </td>
                                <td id="btns" class="addremove">
                                    <div class="addremove">
                                        <input type="button" id="addprice" class="addprice" value="+">
                                        <input type="button" id="removeprice" class="removeprice" value="-">
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <input id="sum" type="hidden" value="0">
                        <input id="sumusd" type="hidden" value="0">
                    </div>
                    <label for="actPrice1nm"><span>Selling Price:</span></label>
                    <input readonly type="number" id="sellingprice" name="sellingprice" value="0" placeholder="0"
                        required="required" tabindex="1" autofocus="autofocus" />


                    <label for="actPrice1us"><span>Selling Price USD:</span></label>
                    <input readonly type="number" id="sellingpriceusd" name="sellingpriceusd" value="0"
                        placeholder="0" required="required" tabindex="1" autofocus="autofocus" />


                    <input type="hidden" name="perc15" id="perc15">
                    <input type="hidden" name="perc30" id="perc30">
                    <input type="hidden" name="perc50" id="perc50">


                    <br><br><br>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button name="submit" type="submit" id="submit">SEND</button>
                    </div>
                </form>

            </div>
        </div>
        @push('custom-scripts')
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <script src="{{ URL::asset('js/scripts.js') }}"></script>
        @endpush
    @else
        <h3>Not Allowed !</h3>
    @endcan
@endsection
