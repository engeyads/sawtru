@extends('home')


@section('articles')
    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
    @can('edit-self-purchases')
        {{-- @if ($purchaseorder->status < $purchaseorder->items) --}}
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
            <div class="contact-form">
                <div class="rightside">
                    <form action="{{ route('purchases.update_order', $purchases,$purchases->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="text" value="{{ $purchases->serial_no }}" readonly>
                        <table>
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Code</th>
                                    <th>Details</th>
                                    <th>Delivery</th>
                                    <th>qty</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                    <th>Done?</th>
                                    <th>Cancel</th>
                                </tr>
                            </thead>
                            <tbody >
                                <tr><td style="padding-bottom:25px"></td></tr>
                                @foreach ($purchases->project_orders as $val)
                                <input type="hidden" name="item[{{ $val->id }}][itm]" value="{{ $val->id }}">
                                <tr id="item{{ $val->item_id }}">
                                    <td>
                                        <input type="text"  value="{{ $val->item }}" readonly>
                                    </td>
                                    <td>
                                        <input type="text" value="{{ $val->Code }}" readonly>
                                    </td>
                                    <td>
                                        <input type="text" value="{{ $val->details }}" readonly>
                                    </td>
                                    <td>
                                        <table style="margin-top:-25px">
                                            <tr>
                                                <td>
                                                    <span>order:</span><input type="text" value="{{ $val->delivery }}" readonly>
                                                </td>
                                                <td>
                                                    <span>can:</span><input type="text" value="{{ $val->delivery }}">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <input type="number" value="{{ $val->qty }}" class="itemqty"
                                        {{-- @if ($val->status == 0) id="item[{{ $val->id }}]" name="item[{{ $val->id }}][qty]" @endif @if ($val->status == 1) --}} readonly {{-- @endif --}}>
                                    </td>
                                    <td>
                                        <input type="number" value="{{ $val->price }}" class="itemprice" min="0"
                                        @if ($val->status == 0) id="item[{{ $val->id }}]" name="item[{{ $val->id }}][price]" @endif @if ($val->status == 1) readonly @endif>
                                    </td>
                                    <td>
                                        <input type="text" value="{{ $val->total }}" class="itemtotlal" readonly
                                        @if ($val->status == 0) id="item[{{ $val->id }}]" name="item[{{ $val->id }}][total]" @endif @if ($val->status == 1) readonly @endif>
                                    </td>
                                    <td>
                                        <label class="chklabel">
                                            <input type="checkbox"  class="chklabell" id="done{{ $val->id }}"
                                                @if ($val->status == 0) name="item[{{ $val->id }}][done]" @endif @if ($val->status == 1) checked disabled @endif value="1">
                                            <span class="check-box-effect"></span>
                                        </label>
                                        <input type="checkbox" value="{{ $val->id }}" >
                                    </td>
                                    <td>
                                        <label class="chklabel">
                                            <input type="checkbox"  class="chklabelr" id="cancel{{ $val->id }}"
                                                @if ($val->status == 0) name="item[{{ $val->id }}][cancel]" @endif @if ($val->status == 1) disabled @endif @if ($val->canceled == 1) checked @endif value="1">
                                            <span class="check-box-effect"></span>
                                        </label>
                                        <input type="checkbox" value="{{ $val->id }}" >
                                    </td>
                                </tr>
                                @if ($val->canceled != 0)
                                    <tr id="asiklama{{ $val->id }}">
                                        <td colspan="7">
                                            <div>
                                                <textarea placeholder="why do you want to Cancel this order?" name="item[{{ $val->id }}][clarification]" required class="">
                                                    {{ $val->description }}
                                                </textarea>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                        <div class="col-3 pull-right">
                            <button type="submit">Send</button>
                        </div>
                    </form>
                    <br><br>
                <hr>
                <table>
                    <tr>
                        <td>
                            <div class="comment">
                                <textarea name="managercomment" id="mgrcomment" placeholder="Comment" cols="10" rows="3"></textarea>
                                @if ($purchases->project_serial_no !== null)

                                <span class="btn btn-warning pull-right"
                                    onclick="submitComment({{ $purchases->projects->serial_no }},{{ Auth::user()->id }},{{ $purchases->projects->uid }})">Send</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                </table>
                <div id="comments-table" class="comments-container">
                    <table>
                        @if ($purchases->project_serial_no !== null)

                        @foreach ($purchases->projects->comments as $comment)
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
                        @else
                            @foreach ($purchases->comments as $comment)
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
                        @endif
                    </table>
                </div>
                @push('custom-scripts')
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
                    <script src="{{ URL::asset('js/scripts.js') }}"></script>
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
                    </script>
                @endpush
                </div>
            </div>
            @push('custom-scripts')
                <script>
                    $('.itemqty').on('change',function(evt){
                        $(this).parent().next().next().find('.itemtotlal').val(parseFloat(parseFloat($(this).val())*parseFloat($(this).parent().next().find('input').val())));
                    });
                    $('.itemprice').on('change',function(evt){
                        var sm = parseFloat(parseFloat($(this).val())*parseFloat($(this).parent().prev().find('input').val()))
                        if(!isNaN(sm)){
                            $(this).parent().next().find('.itemtotlal').val(sm);
                        }else{
                            $(this).parent().next().find('.itemtotlal').val('');
                        }
                    });
                    $('.chklabell').on('change',function(evt){
                        if ($(this).is(':checked')) {
                            $(this).parent().parent().next().find('.chklabelr').prop('checked', false);
                            asiklama($(this).attr('id').replace( /^\D+/g, ''));
                        }
                    });
                    $('.chklabelr').on('change',function(evt){
                        if ($(this).is(':checked')) {
                            $(this).parent().parent().prev().find('.chklabell').prop('checked', false);
                            $(this).parent().parent().parent().after('<tr id="asiklama' + $(this).attr('id').replace( /^\D+/g, '') + '"><td colspan="7"><div><textarea placeholder="why do you want to Cancel this order?" name="item['+$(this).attr('id').replace( /^\D+/g, '')+'][clarification]" required class=""></textarea></div></td></tr>');
                        }else{
                            asiklama($(this).attr('id').replace( /^\D+/g, ''));
                        }
                    });
                    function asiklama(id){
                        if(document.getElementById('asiklama' + id)){
                            document.getElementById('asiklama' + id).remove();
                        }
                    }
                </script>
            @endpush
            {{-- @else
            <h4>Order is already Completed returning to bill</h4>
            @push('custom-scripts')
                <script>
                    setTimeout(function() {
                        window.location = "/dashboard/purchases/{{ $purchaseorder->id }}";
                    }, 3000);
                </script>
            @endpush
        @endif--}}
    @else
        <h3>Not Allowed !</h3>
    @endcan
@endsection
