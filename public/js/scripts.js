
$(document).ready(function () {

    $('#phase2').hide();
    $('#phase3').hide();
    $('#editbtn1').hide();
    $('#editbtn2').hide();

    $('#volume').on('change', function () {
        $('#L').val(null);
        $('#W').val(null);
        $('#H').val(null);
        $('#units1').val(null);
        if ($('#volume').val() == 0) {
            $('#L').attr('readonly', false);
            $('#W').attr('readonly', false);
            $('#H').attr('readonly', false);
            $('#units1').attr('readonly', false);
            $('#units1').attr('required', true);
        } else {
            $('#L').attr('readonly', true);
            $('#W').attr('readonly', true);
            $('#H').attr('readonly', true);
            $('#units1').attr('readonly', true);
            $('#units1').attr('required', false);
        }
    });

    $('#L').on('change', function () {
        $('#volume').val(null);
        if ($('#L').val() == 0) {
            $('#volume').attr('readonly', false);
            $('#units2').attr('readonly', false);
            $('#units2').attr('required', true);
        } else {
            $('#volume').attr('readonly', true);
            $('#units2').attr('readonly', true);
            $('#units2').attr('required', false);
        }
    });
    $('#W').on('change', function () {
        $('#volume').val(null);
        if ($('#W').val() == 0) {
            $('#volume').attr('readonly', false);
            $('#units2').attr('readonly', false);
            $('#units2').attr('required', true);
        } else {
            $('#volume').attr('readonly', true);
            $('#units2').attr('readonly', true);
            $('#units2').attr('required', false);
        }
    });
    $('#H').on('change', function () {
        $('#volume').val(null);
        if ($('#H').val() == 0) {
            $('#volume').attr('readonly', false);
            $('#units2').attr('readonly', false);
            $('#units2').attr('required', true);
        } else {
            $('#volume').attr('readonly', true);
            $('#units2').attr('readonly', true);
            $('#units2').attr('required', false);
        }
    });

    $('#toPhase2').on('click', function () {
        if ($('#pname').val() !== '' && ($('#volume').val() !== '' || ($('#L').val() !== '' && $('#W').val() !== '' && $('#H').val() !== ''))) {
            $('#phase1fs').attr('disabled', 'disabled');
            $('#editbtn1').show();
            $('#toPhase2').hide();
            $('#phase2').show();
        };
    });

    // if phase 1 edit button clicked
    $('#editbtn1').on('click', function () {
        if ($('#editbtn1').text() == "done !") {
            $('#editbtn1').text("edit");
            $('#phase1fs').attr('disabled', 'disabled');
        } else {
            $('#editbtn1').text("done !");
            $('#phase1fs').removeAttr('disabled');
        }
    });


    // if phase 2 edit button clicked
    $('#editbtn2').on('click', function () {
        if ($('#editbtn2').text() == "done !") {
            $('#editbtn2').text("edit");
            $('#phase2fs').attr('disabled', 'disabled');
        } else {
            $('#editbtn2').text("done !");
            $('#phase2fs').removeAttr('disabled');
        }
    });

    $('#toPhase3').on('click', function () {
        $('#editbtn2').show();
        $('#toPhase3').hide();
        $('#phase2fs').attr('disabled', 'disabled');
        $('#phase3').show();
    });
    // Multiple images preview in browser
    var imagesPreview = function (input, placeToInsertImagePreview) {
        $(placeToInsertImagePreview).removeChild("img");

        if (input.files) {
            var filesAmount = input.files.length;
            for (i = 0; i < filesAmount; i++) {
                var reader = new FileReader();
                reader.onload = function (event) {
                    $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                }
                reader.readAsDataURL(input.files[i]);
            }
        }

    };

    $('#dp').on('change', function () {
        imagesPreview(this, '#dpdisplay');
    });



    $("#picture").change(function () {
        if (this.files && this.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#picimg').attr('src', e.target.result);
            }

            reader.readAsDataURL(this.files[0]);
        }
    });

    $('#printpdf').on('click', function () {

        var pdfdoc = new jsPDF();

        autoTable(doc, { html: '#contact-form' });

        // let sizes = $('#contact-form').find('#number').val() == '' ? $('#contact-form').find('#number').val() : "L: " + $('#contact-form').find('#L').val() + " W: " + $('#contact-form').find('#W').val() + " H: " + $('#contact-form').find('#H').val();

        // pdfdoc.fromHTML('<html><body>'+


        // "<table><tr><td>Project Name: " + $('#contact-form').find('#pname').val() + '<td/>' +
        // "<td>serial Number: " + $('#contact-form').find('#serialno').val() + '</td/><tr/>' +
        // "<tr><td colspan='2'>Machine Dimentions: " + sizes + '</td/><tr/></table>' +


        // '</body></html>', 10, 10, {
        //     'width': 110,
        // });
        doc.save('table.pdf');
    });


    $('.addsp').on('click', addsp);
    $('.removesp').on('click', removesp);

    $('.addmt').on('click', addmt);
    $('.removemt').on('click', removemt);

    $('.addot').on('click', addot);
    $('.removeot').on('click', removeot);

    $('.addprice').on('click', addprice);
    $('.removeprice').on('click', removeprice);

    $('.addmtrs').on('click', addmtrs);
    $('.removemtrs').on('click', removemtrs);

    $('.addmtls').on('click', addmtls);
    $('.removemtls').on('click', removemtls);

    $('.addothr').on('click', addothr);
    $('.removeothr').on('click', removeothr);


    function sums(wher) {

        $('#' + wher + "sum").val("0");

        $('#' + wher + ' .totaltd input').each(function () {
            if (parseInt($(this).val()) <= 0 || isNaN(parseInt($(this).val()))) {

            } else {
                $('#' + wher + "TotalNet").val(parseInt($('#' + wher + "sum").val()) + (parseInt(this.value) == '' || isNaN(parseInt(this.value)) ? 0 : parseInt(this.value)));
            }
        });

        //$('#sellingpriceusd').val($('#sumusd').val());

        //$('#sellingprice').val($('#sum').val());
    }
});

function addmtrs() {
    var new_addmtrs_no = parseInt($('#total_addmtrs').val()) + 1;
    var last = parseInt($('.motortd').last().attr('id').toString().replace( /^\D+/g, ''))+1;

    var new_row = "<tr class='new_" + new_addmtrs_no + "'>" +
        '<td id="motortd' + (last) + '" class="motortd">' +
        '<input type="text" class="new_' + new_addmtrs_no + ' " id="motor' + (last) + '" name="motors[' + (last) + '][motor]" value=""' +
        'placeholder="'+last+'" required="required" tabindex="1"' +
        'autofocus="autofocus" />' +
        '</td>' +

        '<td id="power' + (last) + '" class="power">' +
            '<input type="number" min="0" step="0.01" id="power' + (last) + '"'+
                'name="motors[' + (last) + '][power]" value="" placeholder="power"'+
                'required="required" tabindex="1" autofocus="autofocus" />'+
        '</td>'+
        '<td id="munit' + (last) + '" class="unit">'+
            '<input type="text" min="0" id="unit' + (last) + '"'+
                'name="motors[' + (last) + '][unit]" value="" placeholder="cm"'+
                'required="required" autofocus="autofocus" />'+
        '</td>'+

        '<td id="qtytd' + new_addmtrs_no + '" class="qtytd">' +
        '<input type="number" min="1" class="new_' + new_addmtrs_no + ' " id="qty' + (last) + '" name="motors[' + (last) + '][qty]" onchange=" $(\'#total' + (last) + '\').val($(\'#qty' + (last) + '\').val()*$(\'#price' + (last) + '\').val()); sum(\'motors\');" value="1"' +
        'placeholder="qty" required="required" ' +
        'autofocus="autofocus" />' +
        '</td>' +
        '<td id="pricetd' + new_addmtrs_no + '" class="pricetd">' +
        '<div class="currencyinput">$</div>' +
        '<input type="number" min="0" class="new_' + new_addmtrs_no + ' " id="price' + (last) + '" name="motors[' + (last) + '][price]" onchange=" $(\'#total' + (last) + '\').val($(\'#qty' + (last) + '\').val()*$(\'#price' + (last) + '\').val()); sum(\'motors\');" value="0"' +
        'placeholder="price" required="required" ' +
        'autofocus="autofocus" />' +
        '</td>' +
        '<td id="totaltd' + new_addmtrs_no + '" class="totaltd">' +
        '<div class="currencyinput">$</div>' +
        '<input type="number" min="0" class="new_' + new_addmtrs_no + ' " id="total' + (last) + '" name="motors[' + (last) + '][total]" value="0" ' +
        'placeholder="Total" required="required" ' +
        'autofocus="autofocus" readonly />' +
        '</td>' +
        '<td id="mtphototd' + new_addmtrs_no + '" class="mtphoto">' +
        '<input type="file" class="new_' + new_addmtrs_no + ' " id="mtphoto' + (last) + '" name="motors[' + (last) + '][photo]" value=""' +
        'placeholder="Select Photo" required="required" tabindex="1"' +
        'autofocus="autofocus" />' +
        '</td>' +
        "</tr>";

    $('#motors').append(new_row);
    $('#total_addmtrs').val(new_addmtrs_no);
}

function removemtrs() {
    var last_addmtrs_no = $('#total_addmtrs').val();

    if (last_addmtrs_no > 1) {
        $('.new_' + last_addmtrs_no).remove();
        $('#total_addmtrs').val(last_addmtrs_no - 1);
    }
    sum('motors');
}


function addmtls() {
    var new_addmtls_no = parseInt($('#total_addmtls').val()) + 1;
    var last = parseInt($('.metaltd').last().attr('id').toString().replace( /^\D+/g, ''))+1;

    var new_row = "<tr class='new_" + new_addmtls_no + "'>" +

        "<td id='metaltd" + (last) + "' class='metaltd'>" + "<input type='text' class='new_" + new_addmtls_no + " metaltd' id='metaltd" + (last) + "' name='metals[" + (last) + "][metal]' value='' placeholder='metal' required='required'  />" + "</td>" +

        '<td id="thicknesstd' + (last) + '" class="thicknesstd">'+
            '<input type="number" min="0" step="0.01" id="thicknesstd' + (last) + '"'+
                'name="metals[' + (last) + '][thickness]" value="" placeholder="Thickness"'+
                'required="required" tabindex="1" autofocus="autofocus" />'+
        '</td>'+
        '<td id="thkunittd" class="thkunittd">'+
            '<input type="text" id="thkunit' + (last) + '" class="thkunit"'+
                'name="metals[' + (last) + '][unit]" value="" placeholder="cm"'+
                'required="required" autofocus="autofocus" />'+
        '</td>'+


        '<td id="metqtytd' + new_addmtls_no + '" class="qtytd">' +
        '<input type="number" min="1" class="new_' + new_addmtls_no + ' " id="mtqty' + (last) + '" name="metals[' + (last) + '][qty]" onchange=" $(\'#mttotal' + (last) + '\').val($(\'#mtqty' + (last) + '\').val()*$(\'#mtprice' + (last) + '\').val()); sum(\'metals\');" value="1"' +
        'placeholder="qty" required="required" tabindex="1"' +
        'autofocus="autofocus" />' +
        '</td>' +
        '<td id="metpricetd' + new_addmtls_no + '" class="pricetd">' +
        '<div class="currencyinput">$</div>' +
        '<input type="number" min="0" class="new_' + new_addmtls_no + ' " id="mtprice' + (last) + '" name="metals[' + (last) + '][price]" onchange=" $(\'#mttotal' + (last) + '\').val($(\'#mtqty' + (last) + '\').val()*$(\'#mtprice' + (last) + '\').val()); sum(\'metals\');" value="0"' +
        'placeholder="price" required="required" tabindex="1"' +
        'autofocus="autofocus" />' +
        '</td>' +
        '<td id="mettotaltd' + new_addmtls_no + '" class="totaltd">' +
        '<div class="currencyinput">$</div>' +
        '<input type="number" min="0" class="new_' + new_addmtls_no + ' " id="mttotal' + (last) + '" name="metals[' + (last) + '][total]" value="0"' +
        'placeholder="Total" required="required" tabindex="1"' +
        'autofocus="autofocus" readonly />' +
        '</td>' +
        "</tr>";

    $('#metals').append(new_row);

    $('#total_addmtls').val(new_addmtls_no);
}

function removemtls() {
    var last_addmtls_no = $('#total_addmtls').val();

    if (last_addmtls_no > 1) {
        $('.new_' + last_addmtls_no).remove();
        $('#total_addmtls').val(last_addmtls_no - 1);
    }
    sum('metals');
}


function addothr() {
    var new_addothr_no = parseInt($('#total_addothr').val()) + 1;
    var last = parseInt($('.othertd').last().attr('id').toString().replace( /^\D+/g, ''))+1;

    var new_row = "<tr class='new_" + new_addothr_no + "'>" +
        "<td id='othertd" + (last) + "' class='othertd'>" + "<input type='text' class='new_" + new_addothr_no + " other' id='other" + last + "' name='others[" + last + "][title]' value='' placeholder='Title' required='required' tabindex='" + last + "' autofocus='autofocus' />" + "</td>" +
        '<td id="info' + (last) + '" class="info">'+
            '<input type="text" id="info' + (last) + '" name="others[' + (last) + '][info]"'+
                'value="" placeholder="Info" required="required"'+
                'autofocus="autofocus" />'+
        '</td>'+

        '<td id="otqtytd' + new_addothr_no + '" class="qtytd">' +
        '<input type="number" min="1" class="new_' + new_addothr_no + ' " id="otqty' + last + '" name="others[' + last + '][qty]" onchange=" $(\'#ottotal' + last + '\').val($(\'#otqty' + last + '\').val()*$(\'#otprice' + last + '\').val()); sum(\'Others\');" value="1"' +
        'placeholder="qty" required="required" tabindex="1"' +
        'autofocus="autofocus" />' +
        '</td>' +
        '<td id="otpricetd' + new_addothr_no + '" class="pricetd">' +
        '<div class="currencyinput">$</div>' +
        '<input type="number" min="0" class="new_' + new_addothr_no + ' " id="otprice' + last + '" name="others[' + last + '][price]" onchange=" $(\'#ottotal' + last + '\').val($(\'#otqty' + last + '\').val()*$(\'#otprice' + last + '\').val()); sum(\'Others\');" value="0"' +
        'placeholder="price" required="required" tabindex="1"' +
        'autofocus="autofocus" />' +
        '</td>' +
        '<td id="ottotaltd' + new_addothr_no + '" class="totaltd">' +
        '<div class="currencyinput">$</div>' +
        '<input type="number" min="0" class="new_' + new_addothr_no + ' " id="ottotal' + last + '" name="others[' + last + '][total]" value=""' +
        'placeholder="Total" required="required" tabindex="1"' +
        'autofocus="autofocus" readonly />' +
        '</td>' +
        "</tr>";

    $('#Others').append(new_row);

    $('#total_addothr').val(new_addothr_no);
}

function removeothr() {
    var last_addothr_no = $('#total_addothr').val();

    if (last_addothr_no > 1) {
        $('.new_' + last_addothr_no).remove();
        $('#total_addothr').val(last_addothr_no - 1);
    }
    sum('Others');
}

function addprice() {
    var new_chq_no = parseInt($('#total_chq').val()) + 1;

    var new_row = "<tr class='new_" + new_chq_no + "'>" +
        "<td class='prexplab'>" + "<input type='text' class='new_" + new_chq_no + " cdlbl' id='cdlbl" + new_chq_no + "' name='costdetails[" + new_chq_no + "][cdlbl]' value='' placeholder='name' required='required' tabindex='1' autofocus='autofocus' />" + "</td>" +
        "<td class='prexpval'>" + "<input type='number' min='0' class='new_" + new_chq_no + " cdepr' id='cdepr" + new_chq_no + "' name='costdetails[" + new_chq_no + "][cdepr]' value='' placeholder='0' required='required' tabindex='1' autofocus='autofocus' />" + "</td>" +
        "<td class='practval'>" + "<input type='number' min='0' onchange='practvalsum(this," + new_chq_no + ")' class='new_" + new_chq_no + " cdapr' id='cdapr" + new_chq_no + "' name='costdetails[" + new_chq_no + "][cdapr]' value='' placeholder='0' required='required' tabindex='1' autofocus='autofocus' />" + "</td>" +
        "<td class='practusd'><label class='chklabel'> " + "<input type='checkbox' onchange='chkd(" + new_chq_no + ")' class='new_" + new_chq_no + " cdusd' id='cdusd" + new_chq_no + "' name='costdetails[" + new_chq_no + "][cdusd]' value='USD' tabindex='1' autofocus='autofocus' />" + "<span class='check-box-effect'></span></label></td>" +
        "<td class='practpic'>" + "<input accept='image/*' type='file' class='new_" + new_chq_no + " cdimg' id='cdimg" + new_chq_no + "' name='costdetails[" + new_chq_no + "][cdimg]'  tabindex='1' autofocus='autofocus' />" + "</td>" +
        "<td class='practkdv'><label class='chklabel'> " + "<input type='checkbox' class='new_" + new_chq_no + " cdkdv' id='cdkdv" + new_chq_no + "' name='costdetails[" + new_chq_no + "][cdkdv]' value='KDV' tabindex='1' autofocus='autofocus' />" + "<span class='check-box-effect'></span></label></td>" +
        "</tr>";

    $('#cdt').append(new_row);

    $('#total_chq').val(new_chq_no);
}

function removeprice() {
    var last_chq_no = $('#total_chq').val();

    if (last_chq_no > 1) {
        $('.new_' + last_chq_no).remove();
        $('#total_chq').val(last_chq_no - 1);
    }
}

function addsp() {
    var new_spc_no = parseInt($('#total_spc').val()) + 1;

    var new_row = "<tr class='newsp_" + new_spc_no + "'>" +
        "<td class='motor'>" + "<input type='text' class='newsp_" + new_spc_no + " motor' id='motor" + new_spc_no + "' name='motors[" + new_spc_no + "][motor]' value='' placeholder='motor' required='required' tabindex='1' autofocus='autofocus' />" + "</td>" +
        "<td class='power'>" + "<input type='number' min='0' step='0.05' class='newsp_" + new_spc_no + " power' id='power" + new_spc_no + "' name='motors[" + new_spc_no + "][power]' value='' placeholder='power' required='required' tabindex='1' autofocus='autofocus' />" + "</td>" +
        "<td class='unit' id='munit' class='unit'> <input type='text' min='0' class='newsp_" + new_spc_no + " id='unit" + new_spc_no + "' name='motors[" + new_spc_no + "][unit]' value='' placeholder='cm' required='required' autofocus='autofocus' /> </td>" +
        "<td class='title'>" + "<input type='text' class='newsp_" + new_spc_no + " title' id='title" + new_spc_no + "' name='motors[" + new_spc_no + "][title]' value='' placeholder='title' autofocus='autofocus' />" + "</td>" +
        "</tr>";

    $('#motors').append(new_row);
    $('#total_spc').val(new_spc_no);
}

function removesp() {
    var last_spc_no = $('#total_spc').val();

    if (last_spc_no > 1) {
        $('.newsp_' + last_spc_no).remove();
        $('#total_spc').val(last_spc_no - 1);
    }
}
function addmt() {
    var new_mtl_no = parseInt($('#total_mtl').val()) + 1;

    var new_row = "<tr class='newmt_" + new_mtl_no + "'>" +
        "<td class='motor'>" + "<input type='text' class='newmt_" + new_mtl_no + " metaltd' id='metaltd" + new_mtl_no + "' name='metals[" + new_mtl_no + "][metal]' value='' placeholder='metal' required='required' tabindex='" + new_mtl_no + "' autofocus='autofocus' />" + "</td>" +
        "<td class='thicknesstd'>" + "<input type='number' min='0' step='0.05'  class='newmt_" + new_mtl_no + " thicknesstd' id='thicknesstd" + new_mtl_no + "' name='metals[" + new_mtl_no + "][thickness]' value='' placeholder='thickness' required='required' tabindex='" + new_mtl_no + "' autofocus='autofocus' />" + "</td>" +
        /*"<td class='thkunittd'>" + "<select class='newmt_" + new_mtl_no + " thkunit' id='thkunit" + new_mtl_no + "' name='metals[" + new_mtl_no + "][unit]' required='required' tabindex='" + new_mtl_no + "' autofocus='autofocus'>" +
        "<option value='cm'>centimeter</option>" +
        "<option value='decimeter'>decimeter</option>" +
        "</select>" + "</td>" +*/
        "<td class='thkunittd'>" + "<input type='text' id='thkunit" + new_mtl_no + "' class='newmt_" + new_mtl_no + "' name='metals[" + new_mtl_no + "][unit]' value='' placeholder='cm' required='required' autofocus='autofocus' />" + "</td>" +
        "<td class='title'>" + "<input type='text' class='newmt_" + new_mtl_no + " titletd' id='titletd" + new_mtl_no + "' name='metals[" + new_mtl_no + "][title]' value='' placeholder='title'  tabindex='" + new_mtl_no + "' autofocus='autofocus' />" + "</td>" +
        "</tr>";
    $('#metals').append(new_row);
    $('#total_mtl').val(new_mtl_no);
}

function removemt() {
    var last_mtl_no = $('#total_mtl').val();

    if (last_mtl_no > 1) {
        $('.newmt_' + last_mtl_no).remove();
        $('#total_mtl').val(last_mtl_no - 1);
    }
}

function addot() {
    var new_oth_no = parseInt($('#total_ot').val()) + 1;

    var new_row = "<tr class='newot_" + new_oth_no + "'>" +
        "<td class='other'>" + "<input type='text' class='newot_" + new_oth_no + " other' id='other" + new_oth_no + "' name='others[" + new_oth_no + "][title]' value='' placeholder='Title' required='required' tabindex='" + new_oth_no + "' autofocus='autofocus' />" + "</td>" +
        "<td class='info'>" + "<input type='text' class='newot_" + new_oth_no + " info' id='info" + new_oth_no + "' name='others[" + new_oth_no + "][info]' value='' placeholder='Info' required='required' tabindex='" + new_oth_no + "' autofocus='autofocus' />" + "</td>" +
        "<td class='details'>" + "<input type='text' class='newot_" + new_oth_no + " details' id='details" + new_oth_no + "' name='others[" + new_oth_no + "][details]' value='' placeholder='Details' tabindex='" + new_oth_no + "' autofocus='autofocus' />" + "</td>" +
        "</tr>";

    $('#Others').append(new_row);

    $('#total_ot').val(new_oth_no);
}

function removeot() {
    var last_oth_no = $('#total_ot').val();

    if (last_oth_no > 1) {
        $('.newot_' + last_oth_no).remove();
        $('#total_ot').val(last_oth_no - 1);
    }
}

function practvalsum(vl, num) {
    sum();
}

function sum(wher) {
    $('#' + wher + "sum").val("0");
    $('#' + wher + "Itemsum").val("0");

    $('#' + wher + ' .totaltd input').each(function () {
        if (parseInt($(this).val()) <= 0 || isNaN(parseInt($(this).val()))) {

        } else {
            $('#' + wher + "sum").val(parseInt($('#' + wher + "sum").val()) + (parseInt(this.value) == '' || isNaN(parseInt(this.value)) ? 0 : parseInt(this.value)));
        }
    });

    $('#' + wher + ' .pricetd input').each(function () {
        if (parseInt($(this).val()) <= 0 || isNaN(parseInt($(this).val()))) {

        } else {
            $('#' + wher + "Itemsum").val(parseInt($('#' + wher + "Itemsum").val()) + (parseInt(this.value) == '' || isNaN(parseInt(this.value)) ? 0 : parseInt(this.value)));
        }
    });

    $('#' + wher + "TotalNet").val($('#' + wher + "sum").val());
    $('#' + wher + "ItemNet").val($('#' + wher + "Itemsum").val());
    //$('#sellingpriceusd').val($('#sumusd').val());

    //$('#sellingprice').val($('#sum').val());
}

function chkd(numb) {
    sum();
}


