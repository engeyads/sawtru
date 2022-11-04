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
                        <h2>Purchase Orders</h2>
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

            @can('list-purchases')
                <div id="conts">
                    <div id="req" class="req">
                        <table class="reqs">
                            <thead>
                                <tr>
                                    <th>Serial</th>
                                    <th>Project</th>
                                    <th>By Engineer</th>
                                    <th>Created At</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($purchases as $data)
                                    <input type="hidden" value="{{ $i = $data->project_serial_no }}">
                                    <tr>
                                        <td>{{ $data->serial_no }}</td>
                                        @if ($data->project_serial_no !== null)
                                            <td>{{ $data->projects->pname }}</td>
                                            <td>{{ $data->projects->user->name }}</td>
                                        @else
                                            <td style="color:orange">deleted project</td>
                                            <td style="color:orange">deleted project</td>
                                        @endif
                                        <td>{{ $data->created_at }}</td>
                                        <td>
                                            <div class="progress bar-wrapper w-100 ">
                                                <div class="progress-bar skill-bar" role="progressbar"
                                                    style="width: {{ ($data->status / $data->items) * 100 }}%"
                                                    aria-valuenow="{{ ($data->status / $data->items) * 100 }}" aria-valuemin="0"
                                                    aria-valuemax="100">
                                                    {{ ($data->status / $data->items) * 100 }}%
                                                </div>
                                            </div>
                                        <td>
                                            <div style="display:inline-flex">


                                                @can('delete-purchases')
                                                    <button id="item{{ $data->id }}" type="submit"

                                                        class="delt editing fa fa-trash"></button>
                                                @endcan
                                                @can('edit-purchases')
                                                    <span title="View Project" class="editing fa fa-eye"
                                                        onclick="location.href ='/dashboard/purchases/{{ $data->id }}'"></span>
                                                @endcan
                                                <button id="printpdf{{ $data->id }}"
                                                    class="editing printpdf fa fa-file-pdf-o"></button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <center>
                            {{ $purchases->links('pagination::bootstrap-5') }}
                        </center>
                    </div>
                </div>

                @push('custom-scripts')

                <script src="https://cdn.jsdelivr.net/npm/pdf-lib/dist/pdf-lib.js"></script>
                    <script >
                        var PDFDocument = PDFLib.PDFDocument;
                        var rgb = PDFLib.rgb;
                        $('.printpdf').on('click',function(evt){
                            createPdf($('this').attr('id').toString().replace( /^\D+/g, ''));
                        });
                        async function createPdf(num) {
                            const pdfDoc = await PDFDocument.create()
                            const timesRomanFont = await pdfDoc.embedFont(StandardFonts.TimesRoman)

                            const page = pdfDoc.addPage()
                            const { width, height } = page.getSize()
                            const fontSize = 30
                            page.drawText('Creating PDFs in JavaScript is awesome!', {
                                x: 50,
                                y: height - 4 * fontSize,
                                size: fontSize,
                                font: timesRomanFont,
                                color: rgb(0, 0.53, 0.71),
                            })

                            const pdfBytes = await pdfDoc.save()
                        }
                    </script>
                    <script>
                        $('.delt').on('click',function(evt){
                            deleteRec($(this).attr('id').replace( /^\D+/g, ''));
                        });
                        function deleteRec(num) {
                            if (confirm("Are you sure you want to delete?")) {
                                $.ajax({
                                    type: 'delete',
                                    url: "/dashboard/purchases/" + num,
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

                        function deleteRec(num, nm) {
                            if (confirm("Are you sure you want to delete '" + nm + "' ?")) {
                                $.ajax({
                                    type: 'delete',
                                    url: "/dashboard/purchases/" + num,
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
                            // $.ajax({
                            //     type: 'post',
                            //     url: "/dashboard/PDFDownload/"+num,
                            //     data: {
                            //         '_token' : $("meta[name='csrf-token']").attr("content"),
                            //         'id' : num,
                            //     },
                            //     success: function(data) {
                            //         $("#msg").html(data.msg);
                            //     }
                            // });
                            var pdfdoc = new jsPDF();

                            var specialElementHandlers = {
                                '#ignoreContent': function(element, renderer) {
                                    return true;
                                }
                            };
                            let conts = "<html><body><table><tbody>";
                            num = JSON.parse(JSON.stringify(num));
                            $.each(num, function(key, value) {
                                conts += '<tr><td>';
                                if (key == "deskphotos") {
                                    //let str = value.replace(/[/]/\/\", '');
                                    console.log(str);
                                    let arrs = value.split(",");
                                    console.log(arrs);
                                    $.each(arrs, function(keys, values) {
                                        conts += '<tr><td><img src="/images/';
                                        conts += values;
                                        conts += '"></td></tr>';
                                    });
                                } else {
                                    conts += key + ' : ' + value;
                                }
                                conts += '</td></tr>';
                            });

                            conts += "</tbody></table></body></html>";

                            pdfdoc.fromHTML(conts, 10, 10, {
                                'width': 110,
                                'elementHandlers': specialElementHandlers
                            });
                            pdfdoc.save('First.pdf');
                        }
                    </script>
                @endpush
            @elsecan('list-self-purchases')
                <div id="conts">
                    <div id="req" class="req">
                        <table class="reqs">
                            <thead>
                                <tr>
                                    <th>Serial</th>
                                    <th>Project</th>
                                    <th>By Engineer</th>
                                    <th>Created At</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($purchases as $key => $data)
                                    <tr>
                                        <td>{{ $data->serial_no }}</td>
                                        @if ($data->project_serial_no !== null)
                                            <td>{{ $data->projects->pname }}</td>
                                            <td>{{ $data->projects->user->name }}</td>
                                        @else
                                            <td style="color:orange">deleted project</td>
                                            <td style="color:orange">deleted project</td>
                                        @endif

                                        <td>{{ $data->created_at }}</td>
                                        <td>
                                            <div class="progress bar-wrapper w-100 ">
                                                <div class="progress-bar skill-bar" role="progressbar"
                                                    style="width: {{ ($data->status / $data->items) * 100 }}%"
                                                    aria-valuenow="{{ ($data->status / $data->items) * 100 }}" aria-valuemin="0"
                                                    aria-valuemax="100">
                                                    {{ ($data->status / $data->items) * 100 != 100 ? ($data->status / $data->items) * 100 . '%' : 'Completed' }}
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div style="display:inline-flex">

                                                @can('delete-self-purchases')
                                                    <button type="submit"
                                                        onclick="deleteRec({{ $data->id }})"
                                                        class="editing fa fa-trash"></button>
                                                @endcan
                                                @can('edit-self-purchases')
                                                    @if ($data->status < 100)
                                                        <span title="View Project" class="editing fa fa-edit"
                                                            onclick="location.href ='/dashboard/purchases/{{ $data->id }}/progress'"></span>
                                                    @else
                                                        {{-- only view items and their progress wihile cannot edit anything --}}
                                                        <span title="View Project" class="editing fa fa-eye"
                                                            onclick="location.href ='/dashboard/purchases/{{ $data->id }}'"></span>
                                                    @endif
                                                @endcan
                                                <button id="printpdf{{ $data->id }}" class="editing printpdf fa fa-file-pdf-o"></button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <center>
                            {{ $purchases->links('pagination::bootstrap-5') }}
                        </center>
                    </div>
                </div>

                @push('custom-scripts')
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/pdf-lib/dist/pdf-lib.js"></script>
                    <script >
                        var PDFDocument = PDFLib.PDFDocument;
                        var rgb = PDFLib.rgb;
                        $('.printpdf').on('click',function(evt){

                            PDFDownload($(this).attr('id').toString().replace( /^\D+/g, ''));
                        });
                        async function createPdf(num) {
                            $.ajax({
                                    type: 'get',
                                    url: "/dashboard/purchases/"+num,
                                    data: {
                                        _method: 'GET',
                                        '_token': $("meta[name='csrf-token']").attr("content"),
                                        'id': num,
                                    },
                                    success: function(data) {
                                        console.log(data);
                                        var doc = new jsPDF();
                            var specialElementHandlers = {
                                '#editor': function(element, renderer) {
                                    return true;
                                }
                            };

                            doc.fromHTML(data, 15, 15, {
                                'width': 170,
                                'elementHandlers': specialElementHandlers
                            });
                            doc.save('sample-file.pdf');
                                    }
                                });


                            const pdfDoc = await PDFDocument.create()

                            const page = pdfDoc.addPage()
                            const { width, height } = page.getSize()
                            const fontSize = 30
                            page.drawText('Creating PDFs in JavaScript is awesome!', {
                                x: 50,
                                y: height - 4 * fontSize,
                                size: fontSize,
                                color: rgb(0, 0.53, 0.71),
                            })

                            const pdfBytes = await pdfDoc.save()
                        }
                    </script>
                    <script>
                        function deleteRec(num) {
                            if (confirm("Are you sure you want to delete it? " + num)) {
                                $.ajax({
                                    type: 'delete',
                                    url: "purchases.destroy",
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
                            $.get({
                                type: 'post',
                                url: "/dashboard/purchases/"+num,
                                data: {
                                    '_token' : $("meta[name='csrf-token']").attr("content"),
                                    'id' : num,
                                },
                                success: function(data) {
                                    data = JSON.parse(data);
                                    console.log(data);
                                    var doc = new jsPDF();
                            var specialElementHandlers = {
                                '#editor': function(element, renderer) {
                                    return true;
                                }
                            };

                            doc.fromHTML(data, 15, 15, {
                                'width': 170,
                                'elementHandlers': specialElementHandlers
                            });
                            doc.save('sample-file.pdf');
                                }
                            });
                        }
                    </script>
                @endpush
            @else
                <h3>Not Allowed!</h3>
            @endcan
        </div>
    </div>

@endsection
