
<!-- Bootstrap core JavaScript -->
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" /> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script> -->
<script src="{{ asset('assets/js/jquerymin.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.js') }}"></script>
<script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>
<script src="{{ asset('assets/js/datepicker.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('select2/dist/js/select2.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<!-- <script src="https://npmcdn.com/chart.js@latest/dist/chart.min.js"></script> -->
{{-- <script src="https://canvasjs.com/{{ asset('assets/script/canvasjs.min.js') }}"></script> --}}
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
@if(Route::currentRouteNamed('dashboard'))
    {{-- @include('graph') --}}
    @include('dashboard_graph')
@endif
<script>
    $(document).ready(function() {
        $('#dashboard_customer_s2').select2();
        var issueGm = $('#fi_issue').val();
        var appxGram = $('#appxGram').val();
        var worker = $('#get_FillingForm_data').val();
        
        $('#startDate').datepicker({
                    format:'mm/dd/yyyy',
                }).datepicker("setDate",'now');
    
        if(issueGm < appxGram & worker !=0){
            $('#fi_issue_div').attr('style','background-color:#cd8f8f;');
        }
    });
    $(document).ready(function() {
        $('#dashboard_worker_s2').select2();
        $('#strtDate').hide();
        $('#endDate').hide();
        $('#date_range').change(function() {    
            var range = $(this).val();
            if(range == "custom") {
                $('#strtDate').show();
                $('#endDate').show();        
            } else {
                $('#strtDate').hide();
                $('#endDate').hide(); 
            }        
        })
    });
    $(document).ready(function() {
        $('#dashboard_worker_s3').select2();
    });
    function image_upload_check(){
        var file = $(".inputfile").val();
        var file2 = $(".identity_doc").val();
        console.log(file2+'xx'+file);
        if(!file || !file2){
            Swal.fire(
            '',
            'File not uploaded',
            'error');
        }
    }
    window.addEventListener('load', function () {
    document.getElementById('preloader').style.display = 'none';
    });

    $(document).ready(function() {
      $('#myTable').DataTable({
        responsive: true,
        scrollX: true,
        "rowCallback": function(row, data, index) {
            // add serial number column
            var serialNum = index + 1;
            $('td:eq(0)', row).html(serialNum);
        }
      });
    });

    @if(session()->has('success'))
            Swal.fire(
            '',
            '{{ session()->get('success') }}!',
            'success');
    @endif
    @if(session()->has('error'))
            Swal.fire(
            '',
            '{{ session()->get('error') }}!',
            'error');
    @endif
</script>

<input type="hidden" id="append_no" value="1">
<input type="hidden" id="append_noedit" value="1">
<script>
function appendform(){
    var i = Number($("#append_no").val());
    var karat = '{{get_karat_list_html()}}';
    var stonecolor = '{{get_stcolor_list_html()}}';
    $('#addappend').append("<div class='row mt-1 remove"+i+"' id='removelist'><div class='col-xl-2 col-lg-2 col-md-2 col-sm-12 p-1'><div class='input_bx'><span>Product Name</span><span class='multi-select-custom'></span><input type='text' placeholder='Product Name' name='pname[]'></div></div><div class='col-xl-2 col-lg-2 col-md-2 col-sm-12 p-1'><div class='input_bx'><span>Size/Inches</span><input type='text' placeholder='Size' name='size[]'></div></div><div class='col-lg-1 col-md-1 col-sm-12 p-1'><div class='input_bx'><span>Screw</span><input type='text' placeholder='Inches' name='inches[]'></div></div><div class='col-lg-1 col-md-1 col-sm-12 p-1'><div class='input_bx'><span>Piece</span><input type='text' placeholder='Enter Piece' name='piece[]'></div></div><div class='col-xl-2 col-lg-2 col-md-3 col-sm-12 p-1'><div class='input_bx'><span>Appx Gram</span><input type='text' placeholder='Gram' id='pro_apx_gram"+i+"' class='pro_apx_gr_class' onkeyup='countapx()' name='apxgram[]'></div></div><div class='col-xl-2 col-lg-4 col-md-3 col-sm-12 p-1'><div class='input_bx' id='stonecollist"+i+"'></div></div><div class='col-xl-1 col-lg-1 col-md-1 col-sm-12 p-1'><div class='input_bx p-1'><span>Karat</span><div id='dropdownlist"+i+"'></div></div></div><div class='col-md-1 mt-5'><div class='form-group'><button class='btn btn-danger' type='button' style='background-color: rgba(0, 0, 0, 0);font-size: 20px; padding: 0px 10px;' onclick='removeform("+i+")'><img src='{{asset('public/img/deleteicon.png')}}' alt=''></button></div></div></div>");
    $('#dropdownlist'+i).html($('<div>').html(karat).text());
    $('#stonecollist'+i).html($('<div>').html(stonecolor).text());
    $("#append_no").val(i+1);
}
function appendformedit(slno){
    var check = Number($("#append_no").val());
    var srarting_no = slno;
    if(srarting_no > check){
        $("#append_no").val(srarting_no+1);
    }
    var i = Number($("#append_no").val());
    var karat = '{{get_karat_list_html()}}';
    var stonecolor = '{{get_stcolor_list_html()}}';
    $('#addappend').append("<div class='row mt-1 remove"+i+"' id='removelist'><div class='col-xl-2 col-lg-2 col-md-2 col-sm-12 p-1'><div class='input_bx'><span>Product Name</span><span class='multi-select-custom'></span><input type='text' placeholder='Product Name' name='pname[]'></div></div><div class='col-xl-2 col-lg-2 col-md-2 col-sm-12 p-1'><div class='input_bx'><span>Size/Inches</span><input type='text' placeholder='Size' name='size[]'></div></div><div class='col-lg-1 col-md-1 col-sm-12 p-1'><div class='input_bx'><span>Screw</span><input type='text' placeholder='Inches' name='inches[]'></div></div><div class='col-lg-1 col-md-1 col-sm-12 p-1'><div class='input_bx'><span>Piece</span><input type='text' placeholder='Enter Piece' name='piece[]'></div></div><div class='col-xl-2 col-lg-2 col-md-3 col-sm-12 p-1'><div class='input_bx'><span>Appx Gram</span><input type='text' placeholder='Gram' id='pro_apx_gram"+i+"' class='pro_apx_gr_class' onkeyup='countapx()' name='apxgram[]'></div></div><div class='col-xl-2 col-lg-4 col-md-3 col-sm-12 p-1'><div class='input_bx' id='stonecollist"+i+"'></div></div><div class='col-xl-1 col-lg-1 col-md-1 col-sm-12 p-1'><div class='input_bx p-1'><span>Karat</span><div id='dropdownlist"+i+"'></div></div></div><div class='col-md-1 mt-5'><div class='form-group'><button class='btn btn-danger' type='button' style='background-color: rgba(0, 0, 0, 0);font-size: 20px; padding: 0px 10px;' onclick='removeform("+i+")'><img src='{{asset('public/img/deleteicon.png')}}' alt=''></button></div></div></div>");
    $('#dropdownlist'+i).html($('<div>').html(karat).text());
    $('#stonecollist'+i).html($('<div>').html(stonecolor).text());
    $("#append_no").val(i+1);
}
function removeform(id){
    $(".remove"+id).remove();
    countapx();
}
function count_fil_addon(){
    count_fil_return();
}
function count_mo_dast(){
    var total = parseFloat(0);
    var issu = parseFloat($("#mo_issue").val());
    var reciv = parseFloat($("#mo_reciv").val());
    if(issu > 0 && reciv > 0){
        total = parseFloat(issu-reciv);
        total = parseFloat(total.toFixed(3));
    }
    $("#mo_dust").val(total);
}
function count_fp_dast(){
    var total = parseFloat(0);
    var issu = parseFloat($("#fp_issue").val());
    var reciv = parseFloat($("#fp_reciv").val());
    var percentage = parseInt(10)/parseInt(100);
    var reduction  =  issu*percentage;
    var subtract   =  issu-reduction;
    var add        =  issu+reduction;
    if(reciv < subtract || reciv > add){
        $('#recGram').attr('style','background-color:#cd8f8f;');
    } else {
        $('#recGram').attr('style','background-color:;');
    }
    if(issu > 0 && reciv > 0){
        total = parseFloat(issu-reciv);
        total = parseFloat(total.toFixed(3));
    }
    $("#fp_dust").val(total);
}
function count_fil_return(){
    var total = parseFloat(0);
    var issu = parseFloat($("#fi_issue").val());
    var addon = parseFloat($("#fi_add").val());
    var recive = parseFloat($("#fi_reciv").val());
    var g_return = parseFloat($("#fi_return").val());
    if(issu > 0 && recive > 0){
        if(!addon){
            addon = parseFloat(0);
        }
        if(!g_return){
            g_return = parseFloat(0);
        }
        total = parseFloat(issu+addon-g_return-recive);
        total = parseFloat(total.toFixed(3));
        
    }
    $("#fi_bal").val(total);
}
function minus_dismond(oderid){
    $('#diamond_form'+oderid).submit();
}
function count_se_dust(){
    var total = parseFloat(0);
    var issu = parseFloat($("#se_issue").val());
    var reciv = parseFloat($("#se_reciv").val());
    var gtotal = parseFloat($("#gtotal").val());
    if(issu > 0 && reciv > 0){
        if(!gtotal){
            gtotal = parseFloat(0);
        }
        total = parseFloat(issu+gtotal-reciv);
        total = parseFloat(total.toFixed(3));
    }
    $("#se_dust").val(total);
}
function count_making_charges(){
    // get value
    var orderid = parseFloat($("#mc_order_id").val());
    var mc_variable = parseFloat($("#mc_variable").val());
    var gold_net_w = parseFloat($("#gold_nw").val());
    var total = parseFloat(0);
    total = mc_variable*gold_net_w;
    total = parseFloat(total.toFixed(3));
    $("#making_charges").val(total);
}
function count_addional_charges(){
    var a = parseFloat($("#addional_value").val());
    var b = parseFloat($("#addional_charges").val());
    var total = parseFloat(0);
    total = a*b;
    total = parseFloat(total.toFixed(3));
    $("#addional_charges_total").val(total);
}
function count_gold_charges(){
    var a = parseFloat($("#pure_metal").val());
    var b = parseFloat($("#gold_charges").val());
    var total = parseFloat(0);
    total = a*b;
    total = parseFloat(total.toFixed(3));
    $("#gold_charges_total").val(total);
}
function count_diamond_charges(){
    var a = parseFloat($("#diamond_weight").val());
    var b = parseFloat($("#diamond_charges").val());
    var total = parseFloat(0);
    total = a*b;
    total = parseFloat(total.toFixed(3));
    $("#diamond_charges_total").val(total);
}


function gold_return_model(){
    $('#gold_return_model').modal('show');
}
function open_payment_model(){
    $('#open_payment_model').modal('show');
}

function open_chargespayment_model(){
    $('#open_chargespayment_model').modal('show');
}
function open_cashpayment_model(){
    var c = $("#curent_pending_metal").val();
    var negativeNumber = c;
    var positiveNumber = Math.abs(negativeNumber);
    $("#currnt_pendig_metal").val(positiveNumber);
    $('#open_cashpayment_model').modal('show');
}
function conver_cash(){
    var v = parseFloat($("#gold_price_value").val());
    var cp = parseFloat($("#currnt_pendig_metal").val());
    var t = parseFloat(0);
    var t = cp*v;
    t = parseFloat(t.toFixed(3));
    console.log(v);
    console.log(cp);
    console.log(t);
    $("#current_pay_amount").val(t);
}
function update_balance_modal(cus_id){
    $('#open_initial_amount_model').modal('show');
}
function open_charges_modal(id,mc_var){

    // get value
    // mc var
    var mc_charges_val = parseFloat($("#mc_charges_val"+id).val());
    var i_mc_variable = parseFloat($("#i_mc_variable"+id).val());
    var gold_net_w = parseFloat($("#gold_net_w"+id).val());
    var making_charges = parseFloat($("#making_charges"+id).val());
    // adition change

    var addional_charges_val = parseFloat($("#addional_charges_val"+id).val());
    var gc = parseFloat($("#gc"+id).val());
    var ga = parseFloat($("#ga"+id).val());
    var gew = parseFloat($("#gew"+id).val());
    var addional_charges = parseFloat($("#addional_charges"+id).val());
    var addional_charges_total = parseFloat($("#addional_charges_total"+id).val());
    var adition_val_total = parseFloat(gc+ga+gew);
    adition_val_total = parseFloat(adition_val_total.toFixed(3));
    // gold charge

    var gold_charges_val = parseFloat($("#gold_charges_val"+id).val());
    var pure_metal = parseFloat($("#pure_metal"+id).val());
    var gold_charges = parseFloat($("#gold_charges"+id).val());
    var gold_charges_total = parseFloat($("#gold_charges_total"+id).val());
    // diamond charge

    var diamond_charges_val = parseFloat($("#diamond_charges_val"+id).val());
    var kd = parseFloat($("#kd"+id).val());
    var diamond_charges = parseFloat($("#diamond_charges"+id).val());
    var diamond_charges_total = parseFloat($("#diamond_charges_total"+id).val());
    

    // print values
// mc var
if(!mc_charges_val){
$("#gold_nw").val(gold_net_w);
}else{
$("#gold_nw").val(mc_charges_val);
}
$("#mc_variable").val(i_mc_variable);
$("#making_charges").val(making_charges);
// adition change
if(!addional_charges_val){
$("#addional_value").val(adition_val_total);
}else{
$("#addional_value").val(addional_charges_val);
}
$("#addional_charges").val(addional_charges);
$("#addional_charges_total").val(addional_charges_total);
// gold charge
if(!gold_charges_val){
$("#pure_metal").val(pure_metal);
}else{
$("#pure_metal").val(gold_charges_val);
}
$("#gold_charges").val(gold_charges);
$("#gold_charges_total").val(gold_charges_total);
// diamond charge
if(!diamond_charges_val){
$("#diamond_weight").val(kd);
}else{
$("#diamond_weight").val(diamond_charges_val);
}
$("#diamond_charges").val(diamond_charges);
$("#diamond_charges_total").val(diamond_charges_total);
// order id
$("#mc_order_id").val(id);
    $('#exampleModal').modal('show');
}
$("input.numbers").keypress(function(event) {
  return /\d/.test(String.fromCharCode(event.keyCode));
});
function countapx(){
    var piece = $('#piece').val();
    var pr_gm = $("#pro_apx_gram0").val();
    var total = parseInt(piece)*parseInt(pr_gm);

    // var x = Number($("#append_no").val())-1;
    // var total = parseFloat(0);
    // for (let i = 0; i <= x; i++) {
    //     var in_val = parseFloat($("#pro_apx_gram"+i).val());
    //     if(in_val){
    //         total = parseFloat(total + in_val);
    //         total = parseFloat(total.toFixed(3));
    //     }
    // }
    $("#total_order_apx_val").val(total);
}
function forward_order(type,multiple,id){
    $("#gram_issue").val("");
    $("#comments").val("");
    $("#order_id").val(id);
    $("#refer_type").val(type);
    $.ajax({
        url: '{{url('get_forward_history')}}',
        method: 'GET',
        dataType: 'json',
        data: {
            id: id,
            type: type
        },
        success: function(response) {
            console.log(response);
            $('#refer_table_his').html(response.html);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        }
    });

    // Add HTML content to the div

    if(type == 1){
        $("#forward_modal_name").text('Filling form');
    }
    if(type == 2){
        $("#forward_modal_name").text('Mounting form');
    }
    if(type == 3){
        $("#forward_modal_name").text('Setting form');
    }
    if(type == 4){
        $("#forward_modal_name").text('Final Polish form');
    }
    $('#forward_order_model').modal('show');
}

function forward_repair(type,multiple,id){
    $("#gram_issue").val("");
    $("#comments").val("");
    $("#order_id").val(id);
    $("#refer_type").val(type);
    $.ajax({
        url: '{{url('repair_forward_history')}}',
        method: 'GET',
        dataType: 'json',
        data: {
            id: id,
            type: type
        },
        success: function(response) {
            console.log(response);
            $('#refer_table_his').html(response.html);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        }
    });

    // Add HTML content to the div

    if(type == 1){
        $("#forward_modal_name").text('Filling form');
    }
    if(type == 2){
        $("#forward_modal_name").text('Mounting form');
    }
    if(type == 3){
        $("#forward_modal_name").text('Setting form');
    }
    if(type == 4){
        $("#forward_modal_name").text('Final Polish form');
    }
    $('#forward_order_model').modal('show');
}

$('#forward_order_form').submit(function(e) {
    e.preventDefault(); // prevent form from submitting normally
    var form_data = $(this).serialize(); // get the form data
    
    // validate form fields
    var worker_id = $('#worker_id').val().trim();
    var gram_issue = $('#gram_issue').val().trim();
    var no = $('#no').val().trim();
    if (worker_id == '' || gram_issue == '') {
      alert("Please fill in all required fields.");
      return;
    }
    
    $.ajax({
      type: "POST",
      url: '{{url('forward_order_form')}}',
      data: form_data,
      success: function(response) {
        if(response > 0){
            Swal.fire(
            '',
            'Order assistant to worker successfully',
            'success');
            $('#forward_order_model').modal('hide');
            location.reload();
        }else{
            Swal.fire(
            '',
            'Try again',
            'error');
            location.reload();
        }
      },
      error: function() {
        // handle error
        alert("Error submitting form.");
      }
    });
});

$('#forward_repair_form').submit(function(e) {
    e.preventDefault(); // prevent form from submitting normally
    var form_data = $(this).serialize(); // get the form data
    
    // validate form fields
    var worker_id = $('#worker_id').val().trim();
    var gram_issue = $('#gram_issue').val().trim();
    if (worker_id == '' || gram_issue == '') {
      alert("Please fill in all required fields.");
      return;
    }
    
    $.ajax({
      type: "POST",
      url: '{{url('repair_forward')}}',
      data: form_data,
      success: function(response) {
        if(response > 0){
            Swal.fire(
            '',
            'Order assistant to worker successfully',
            'success');
            $('#forward_order_model').modal('hide');
        }else{
            Swal.fire(
            '',
            'Try again',
            'error');
            location.reload();
        }
      },
      error: function() {
        // handle error
        alert("Error submitting form.");
      }
    });
});

function setting_karaet_calculate(i){
    var a = parseFloat($(".setting_karaet_classa").val());
    if(!a){
        a = 0;
    }
    var b = parseFloat($(".setting_karaet_classb").val());
    if(!b){
        b = 0;
    }
    var c = parseFloat($(".setting_karaet_classc").val());
    if(!c){
        c = 0;
    }
    var total = parseFloat(a + b + c);
    total = parseFloat(total.toFixed(3));
    $("#ktotal").val(total);
    if(i){
        if(i == 1){
            var conv = parseFloat(a*0.2);
            $("#gd").val(parseFloat(conv.toFixed(3)));
        }
        if(i == 2){
            var conv = parseFloat(b*0.2);
            $("#gc").val(parseFloat(conv.toFixed(3)));
        }
        if(i == 3){
            var conv = parseFloat(c*0.2);
            $("#ga").val(parseFloat(conv.toFixed(3)));
        }
        setting_t_calculate();
        count_se_dust();
    }
}
function setting_pd_calculate(){
    var a = parseFloat($(".setting_pd_classa").val());
    if(!a){
        a = 0;
    }
    var b = parseFloat($(".setting_pd_classb").val());
    if(!b){
        b = 0;
    }
    var c = parseFloat($(".setting_pd_classc").val());
    if(!c){
        c = 0;
    }
    var total = parseFloat(a + b + c);
    total = parseFloat(total.toFixed(3));
    $("#ptotal").val(total);
}
function setting_t_calculate(){
    var a = parseFloat($(".setting_t_classa").val());
    if(!a){
        a = 0;
    }
    var b = parseFloat($(".setting_t_classb").val());
    if(!b){
        b = 0;
    }
    var c = parseFloat($(".setting_t_classc").val());
    if(!c){
        c = 0;
    }
    var d = parseFloat($(".setting_t_classd").val());
    if(!d){
        d = 0;
    }
    var total = parseFloat(a + b + c + d);
    total = parseFloat(total.toFixed(3));
    $("#gtotal").val(total);
    count_se_dust();
}
// $('.pro_apx_gr_class').on('change', function() {
    
// });
</script>
{{-- <script type='text/javascript'>
	function getcustomerid(val){
	$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
	}
	});
	$.ajax({
		type:"POST",
		url:"{{ url('/fetchcustomer')}}",
		data: ({cid:val}),
		success: function(response){
			$("#unique_id").val(response['customer_name']);
			// $("#caddress").val(response['address']);
	}});
}
</script> --}}

<script>
    function ChangeOrder() {
        let order_id = $('#order_id').val();
        // alert(order_id);
        // return false;
        // var value = (el.value || el.options[el.selectedIndex].value);
        var firstPart = "{{URL::to('order_status')}}";
       window.location.href = firstPart +'/' + order_id;
    }
    function FillingForm() {
        let customer_id = $('#customer_id').val();
        var order_is_select_input = $('#customer_id').val().trim();
        console.log(order_is_select_input);
        if(order_is_select_input > 0){
        // alert(order_id);
        // return false;
        // var value = (el.value || el.options[el.selectedIndex].value);
            var firstPart = "{{URL::to('filling_form')}}";
         window.location.href = firstPart +'/' + customer_id;
        }
    }
    function repair_FillingForm() {
        let customer_id = $('#customer_id').val();
        var order_is_select_input = $('#customer_id').val().trim();
        console.log(order_is_select_input);
        if(order_is_select_input > 0){
        // alert(order_id);
        // return false;
        // var value = (el.value || el.options[el.selectedIndex].value);
            var firstPart = "{{URL::to('repair_filling_form')}}";
         window.location.href = firstPart +'/' + customer_id;
        }
    }
    $("#get_FillingForm_data").change(function() {
      var selectedValue = $(this).val();
      var ordrid = $("#dep_orderid").val();
      var firstPart = "{{url('filling_form_work')}}";
      window.location.href = firstPart +'/' + ordrid +'/' + selectedValue;
    //   if(selectedValue != 0){
    //     $.ajax({
    //     url: '{{url('filling_data')}}/'+selectedValue,
    //     type: "GET",
    //     dataType: "json",
    //     success: function(data) {
    //         console.log(data);
    //     },
    //     error: function(jqXHR, textStatus, errorThrown) {
    //         console.log("AJAX request failed: " + textStatus, errorThrown);
    //     }
    //     });

    //   }
    });
    $("#get_repair_FillingForm_data").change(function() {
      var selectedValue = $(this).val();
      var ordrid = $("#dep_orderid").val();
      var firstPart = "{{url('repair_filling_form_work')}}";
      window.location.href = firstPart +'/' + ordrid +'/' + selectedValue;
    //   if(selectedValue != 0){
    //     $.ajax({
    //     url: '{{url('filling_data')}}/'+selectedValue,
    //     type: "GET",
    //     dataType: "json",
    //     success: function(data) {
    //         console.log(data);
    //     },
    //     error: function(jqXHR, textStatus, errorThrown) {
    //         console.log("AJAX request failed: " + textStatus, errorThrown);
    //     }
    //     });

    //   }
    });
    $("#get_Mounting_data").change(function() {
      var selectedValue = $(this).val();
      var ordrid = $("#dep_orderid").val();
      var firstPart = "{{url('mounting_form_work')}}";

      window.location.href = firstPart +'/' + ordrid +'/' + selectedValue;
    });
    $("#get_setting_data").change(function() {
      var selectedValue = $(this).val();
      var ordrid = $("#dep_orderid").val();
      var firstPart = "{{url('setting_Form_work')}}";

      window.location.href = firstPart +'/' + ordrid +'/' + selectedValue;
    });
    $("#get_repair_setting_data").change(function() {
      var selectedValue = $(this).val();
      var ordrid = $("#dep_orderid").val();
      var firstPart = "{{url('repair_setting_Form_work')}}";

      window.location.href = firstPart +'/' + ordrid +'/' + selectedValue;
    });
    $("#get_finalpolish_data").change(function() {
      var selectedValue = $(this).val();
      var ordrid = $("#dep_orderid").val();
      var firstPart = "{{url('final_Form_work')}}";

      window.location.href = firstPart +'/' + ordrid +'/' + selectedValue;
    });
    $("#get_repair_finalpolish_data").change(function() {
      var selectedValue = $(this).val();
      var ordrid = $("#dep_orderid").val();
      var firstPart = "{{url('repair_final_Form_work')}}";

      window.location.href = firstPart +'/' + ordrid +'/' + selectedValue;
    });
    function MountingForm() {
        let customer_id = $('#customer_id').val();
        var order_is_select_input = $('#customer_id').val().trim();
        if(order_is_select_input > 0){
            var firstPart = "{{URL::to('Mounting_Form')}}";
         window.location.href = firstPart +'/' + customer_id;
        }
    }
    function SettingForm() {
        let customer_id = $('#customer_id').val();
        var order_is_select_input = $('#customer_id').val().trim();
        if(order_is_select_input > 0){
        var firstPart = "{{URL::to('Setting_Form')}}";
       window.location.href = firstPart +'/' + customer_id;
    }
    }
    function repair_SettingForm() {
        let customer_id = $('#customer_id').val();
        var order_is_select_input = $('#customer_id').val().trim();
        if(order_is_select_input > 0){
        var firstPart = "{{URL::to('repair_Setting_Form')}}";
       window.location.href = firstPart +'/' + customer_id;
    }
    }
    function FinalPolish() {
        let customer_id = $('#customer_id').val();
        var order_is_select_input = $('#customer_id').val().trim();
       
        if(order_is_select_input > 0){
            var firstPart = "{{URL::to('final_Form')}}";
         window.location.href = firstPart +'/' + customer_id;
        }
    }
    function repair_FinalPolish() {
        let customer_id = $('#customer_id').val();
        var order_is_select_input = $('#customer_id').val().trim();
       
        if(order_is_select_input > 0){
            var firstPart = "{{URL::to('repair_final_Form')}}";
         window.location.href = firstPart +'/' + customer_id;
        }
    }
    function add_repair_charge(type,id){
       $("#chr_order_id").val(id);
       $("#order_type").val(type);
        $('#repair_charge').modal('show');


    }
    $('#add_repair_charge_form').submit(function(e) {
        var oid = Number($("#order_id").val());
        var vv = Number($("#rep_charge").val());
        var add_in_c = Number($("#add_in_c"+oid).val());
        var gold_in_c = Number($("#gold_in_c"+oid).val());
        var otype = Number($("#order_type").val());
        e.preventDefault(); // prevent form from submitting normally
        if(vv > 0){
    var form_data = $(this).serialize(); // get the form data
        $.ajax({
        type: "POST",
        url: '{{url('add_repair_chrg')}}',
        data:form_data,
        success: function(response) {
            if(response > 0){
                Swal.fire(
                '',
                'Added successfully',
                'success');
                $('#repair_charge').modal('hide');
                if(otype == 1){
                    var ttt = vv;
                    if(gold_in_c){
                        ttt = ttt+gold_in_c;
                    }
                    ttt = parseFloat(ttt.toFixed(3));
                    $('#add_c_r'+response).text(vv);
                    $('#total_c_r'+response).text(ttt);
                }
                if(otype == 2){
                    var ttt = vv;
                    if(add_in_c){
                        ttt = ttt+add_in_c;
                        ttt = parseFloat(ttt.toFixed(3));
                    }
                    $('#gold_c_r'+response).text(vv);
                    $('#total_c_r'+response).text(ttt);
                }
                location.reload();
            }else{
                Swal.fire(
                '',
                'Try again',
                'error');
                location.reload();
            }
        },
        error: function() {
            // handle error
            alert("Error submitting form.");
        }
        });
    }else{  
        Swal.fire(
                '',
                'Field required',
                'error');
    }   
    });
    $('#return_dust_form').submit(function(e) {
        var oid = Number($("#order_id").val());
        var vv = Number($("#dust_return").val());
        var tval = Number($("#cr_av_dust").val());
        
        e.preventDefault(); // prevent form from submitting normally
        if(vv > 0){
        var form_data = $(this).serialize(); // get the form data
            $.ajax({
            type: "POST",
            url: '{{url('return_dust_form')}}',
            data:form_data,
            success: function(response) {
                if(response > 0){
                    Swal.fire(
                    '',
                    'Returned successfully',
                    'success');
                    $('#dust_return_modal').modal('hide');
                    var total = tval-vv;
                    total = parseFloat(total.toFixed(3));
                    $('#fil_dust_ret'+oid).text(vv);
                    $('#fil_cr_bal'+oid).text(total);
                }else{
                    Swal.fire(
                    '',
                    'Try again',
                    'error');
                    location.reload();
                }
            },
            error: function() {
                // handle error
                alert("Error submitting form.");
            }
            });
        }else{  
            Swal.fire(
                    '',
                    'Field required',
                    'error');
        }   
    });
    function dust_return(type,id){
        var cr_av_dust = Number($("#cdust"+id).val());
        $("#order_id").val(id);
        $("#cr_av_dust").val(cr_av_dust);
       $("#order_type").val(type);
        $('#dust_return_modal').modal('show');
    }
    var isOn = false;
    function togelitems(id){
        $.ajax({
            url: '{{url('updateorderitemstatus')}}',
            type: 'GET',
            data: {itemid: id},
            success: function(response) {
                if (response == 0) {
                    $('#syzz'+id).text('Pending');
                }
                if (response == 1) {
                    $('#syzz'+id).text('Complete');
                }
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    }
    function get_editable_values(id){
        $.ajax({
            url: '{{url('get_editable_values')}}',
            type: 'GET',
            data: {id: id},
            success: function(response) {
                if (response.s == 0) {
                    Swal.fire(
                    '',
                    response.msg,
                    'error');
                }
                if (response.s == 1) {
                    $("#gold_recive").val(response.gold_recive);
                    $("#cashamount").val(response.cashamount);
                    $("#comment").val(response.comment);
                    $("#goldeditid").val(response.edit_id);
                    $('#open_payment_model').modal('show');
                }
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    }
    function client_pdf_download(){
        $('#client_pdf_download').modal('show');        
    }
    function client_export_to_excel(){
        $.ajax({
        type: 'GET',
        url: '{{url('download-excel')}}',
        data: 1,
        success: function(response) {
            
        },
        error: function(xhr, status, error) {
            
        }
        });
    }
    $("#pdf_config_form").submit(function(event) {
    event.preventDefault();
    var form = $(this);
    var formData = form.serialize();
    $.ajax({
      type: 'GET',
      url: '{{url('client_pdf_download')}}',
      data: formData,
      success: function(response) {
        $('#client_pdf_download').modal('hide');
      },
      error: function(xhr, status, error) {
        $('#client_pdf_download').modal('hide');
      }
    });
  });
  function btnloder(){
    var btn = $('.loaderbtn');
    btn.text('Loading...');
    btn.prop('disabled', true);
}
function add_customer_id(id){
    $("#customer_id_input").val(id);
}
function set_ids_in_modal(id,dust){
    $("#customer_id_input").val(id);
    $("#available_dust").val(dust);
}
function fetch_user_details(id){
    var filelink = $("#worker_identity_"+id).val();
var linkContainer = $('.identity_div');
    var link = $('<a>', {
        href: filelink, // Replace with your actual link
        text: 'Download',
        download: ''
        });
    linkContainer.append(link);
var name = $("#name_"+id).val();
console.log(name);
var phone = $("#phone_"+id).val();
var place = $("#place_"+id).val();
var adhar = $("#adhar_"+id).val();
var working_id = $("#working_id_"+id).val();
var email = $("#email_"+id).val();
var password = $("#password_"+id).val();
var role = $("#role_"+id).val();
var worker_iamge = $("#worker_iamge_"+id).val();
var alt_number = $("#alt_number_"+id).val();


    $('#worker_iamge_part').attr('src', worker_iamge);
    $("#name_span").html(name);
    $("#phone_span").html(phone);
    $("#alt_phone_span").html(alt_number);
    $("#place_span").html(place);
    $("#adhar_span").html(adhar);
    $("#email_span").html(email);
    $("#role_span").html(role);
}
function fetch_customer_details(id){
var customer_name = $("#customer_name_"+id).val();
var phone = $("#phone_"+id).val();
var pan_no = $("#pan_no_"+id).val();
var aadhar_no = $("#aadhar_no_"+id).val();
var email_id = $("#email_id_"+id).val();
var gst_no = $("#gst_no_"+id).val();
var address = $("#address_"+id).val();
var dob = $("#dob_"+id).val();
var joiningdate = $("#joiningdate_"+id).val();
var worker_iamge = $("#worker_iamge_"+id).val();
var nickname = $("#nickname_"+id).val();

    $('#worker_iamge_part').attr('src', worker_iamge);
    $("#customer_name").html(customer_name);
    $("#phone_span").html(phone);
    $("#nickname_span").html(nickname);
    $("#pan_no_span").html(pan_no);
    $("#aadhar_no_span").html(aadhar_no);
    $("#email_id_span").html(email_id);
    $("#gst_no_span").html(gst_no);
    $("#address_span").html(address);
    $("#dob_span").html(dob);
    $("#joiningdate_span").html(joiningdate);

}
function dust_table_excel(){
$("#is_excel").val(1);
$("#dust_table_form").submit();
$("#is_excel").val(0);
}

function is_worker(){
    var role = $("#role_check_id").val();
    var selectElement = $("#manager_id_dropdown");
    if(role == 2){
        $("#manager_id_div").show();
        selectElement.attr("required", "required");

    }else{
        $("#manager_id_div").hide();
        selectElement.removeAttr("required");
    }
}
</script>
<script>
        function previewImages(event) {
            console.log("s");
            var previewContainer = document.getElementById('preview-container');
            previewContainer.innerHTML = ''; // Clear previous previews
            
            var files = event.target.files;

            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                var reader = new FileReader();

                reader.onload = function (e) {
                    var previewImage = document.createElement('img');
                    previewImage.src = e.target.result;
                    previewImage.classList.add('preview-image');
                    previewContainer.appendChild(previewImage);
                }

                reader.readAsDataURL(file);
            }
        }
    </script>
</body>
</html>
