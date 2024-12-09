@php
// $unique_id = rand(100000, 999999);

// $exists = DB::table('orders')->where('unique_id', $unique_id)->exists();

// while ($exists) {
//     $unique_id = rand(100000, 999999);
//     $exists = DB::table('orders')->where('unique_id', $unique_id)->exists();
// }

// Use $unique_id as needed

@endphp
@include('admin.main.header')

<div class="mrg_tp"></div>

<div class="dashboard_min">
    <div class="container-fluid">
        <div class="dashboard_panel">
                @include('admin.main.sidebar')
            <div class="dashboard_right">
                <div class="das_right_inr">
                    <div class="das_tab_menu">
                        <ul>
                            <li class="actv"><a href="order-form.html">Order Form</a></li>
                            <li><a href="{{ route('order_history') }}">Order History</a></li>
                            {{-- <li><a href="#url">Order Status</a></li> --}}
                        </ul>
                    </div>
                    <div class="das_frm_panel">
                        <form action="{{ route('store_order') }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="das_frm_bx">
                                <div class="frm_tp">
                                    {{-- <h4>Order No : 13202</h4> --}}
                                </div>
                                <div class="frm_inp_top">
                                    <div class="row">
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                                            <div class="input_bx">
                                                @php
                                                if(login_role() == 3){

                                                    $customer =  DB::table('customers')->where('manager_id',login_id())->get();
                                                }else{

                                                    $customer =  DB::table('customers')->get();
                                                }
                                                $list_karat = get_karat_list();
                                                $list_stcolor = get_stcolor_list();
                                                $list_priority = get_priority_list();
                                                @endphp
                                                  <span>Customer</span>
                                                <select class="select2" required style="width: 100%;" name="cname">

                                                    @foreach($customer as $d)
                                                       <option value="{{$d->id}}">{{$d->nickname}}</option>
                                                   @endforeach
                                                   </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                                            <div class="input_bx">
                                                <span>Unique ID</span>
                                                <input type="text" disabled placeholder="Unique ID" name="unique_id" value="">
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                                            <div class="input_bx">
                                                <span>Order From No</span>
                                                <input type="text" disabled placeholder="" name="ofnumber" value="{{get_slno_orderform()}}">
                                            </div>
                                        </div>
                                        <!-- <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                                            <div class="input_bx">
                                                <span>Karat</span>
                                                <select name="main_karat" required>
                                                    @foreach ($list_karat as $item)
                                                    <option value="{{$item->manin_id}}">{{$item->name}}</option>                                                    
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div> -->
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                                            <div class="input_bx">
                                                <span>Order Date</span>
                                                <input type="text" placeholder="Select date*" class="datepicker"
                                                    name="date" id="startDate" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                                            <div class="input_bx">
                                                <span>Delivery Date</span>
                                                <input type="text" placeholder="Select date*" class="datepicker"
                                                    name="deliverydate" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                                            <div class="input_bx">
                                                <span>Priority</span>
                                                <select name="priority" required>
                                                    @foreach ($list_priority as $item)
                                                    <option value="{{$item->id}}">{{$item->name}}</option>                                                    
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                                            <div class="input_bx">
                                                <span>Delivery Dates</span>
                                                <select name="delivery_priority" required>
                                                    <option disabled selected value>Select an option</option>
                                                    <option value="1">Less than 5</option>
                                                    <option value="2">5 to 10</option>
                                                    <option value="3">Above 10</option>                                                    
                                                </select>
                                            </div>
                                        </div>
                                        {{-- <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                                            <div class="input_bx">
                                                @php
                                                   $worker =  DB::table('worker')->get();
                                                @endphp
                                                  <span>Worker Name</span>
                                                <select style="width: 100%;" name="worker_id">
                                                    <option selected >Select</option>
                                                    @foreach($worker as $d)
                                                       <option value="{{$d->id}}">{{$d->name}}</option>
                                                   @endforeach
                                                   </select>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                                <div class="frm_inp_body">
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                            <span class="add_pro_title">Multiple Products <img onclick="appendform()" src="{{asset('public/img/plus-sign 1.png')}}" alt=""> </span>
                                        </div>
                                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 p-1">
                                            <div class="input_bx">
                                                <span>Product Name</span>
                                                <span class="multi-select-custom"></span>
                                                <input type="text" placeholder="Product Name" name="pname[]" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-lg-1 col-md-1 col-sm-12 p-1">
                                            <div class="input_bx">
                                                <span>Client order no</span>
                                                <span class="multi-select-custom"></span>
                                                <input type="text" placeholder="Client Order no" class="numbers" maxlength="10" name="client_order_no[]" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-lg-1 col-md-2 col-sm-12 p-1">
                                            <div class="input_bx">
                                                <span>Size/Inches</span>
                                                <input type="text" placeholder="Size" name="size[]">
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 p-1">
                                            <div class="input_bx">
                                                <span>Screw</span>
                                                <select name="inches[]" required>
                                                    <option disabled selected value>Select an option</option>
                                                    <option value="bombay">Bombay</option>
                                                    <option value="south">South</option>
                                                    <option value="nose_pin">Nose pin</option>
                                                    <option value="tar">Tar</option>                                                   
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12 p-1">
                                            <div class="input_bx">
                                                <span>Piece</span>
                                                <input type="text" placeholder="Piece" id="piece" name="piece[]" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-lg-2 col-md-3 col-sm-12 p-1">
                                            <div class="input_bx">
                                                <span>Approx Grams</span>
                                                <input type="text" placeholder="Gram" id="pro_apx_gram0" onkeyup="countapx()" class="pro_apx_gr_class" name="apxgram[]" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-lg-4 col-md-3 col-sm-12 p-1">
                                            <div class="input_bx">
                                                <span>Metal colour</span>
                                                <select name="mcolor[]" required>
                                                    @foreach ($list_stcolor as $item)
                                                    <option value="{{$item->id}}">{{$item->name}}</option>                                                    
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <!-- <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12 p-1">
                                            <div class="input_bx">
                                                <span>Karat</span>
                                                <select name="karat[]" required>
                                                    @foreach ($list_karat as $item)
                                                    <option value="{{$item->manin_id}}">{{$item->name}}</option>                                                    
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div> -->
                                        <div class="col-md-1  mt-5">
                                            {{-- <div class="form-group ">
                                                <button class="btn btn-primary" type="button"
                                                    style="font-size: 2 0px; padding: 0px 10px;"
                                                    >+</button>
                                            </div> --}}
                                        </div>
                                    </div>
                                        <div id="addappend"></div>


                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6" style="h" >
                                                <div class="input_bx">
                                                    <span>Approx Weight Grams</span>
                                                    <input type="text" required placeholder="Enter here" value="" id="total_order_apx_val" name="appx_weight" required>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                                <div class="input_bx">
                                                    <span>Comments</span>
                                                    <input type="text" class="comment_input_css" placeholder="Enter here" value="" name="comment" >
                                                </div>
                                            </div>
                                        </div>    

                                        <div class="col-xl-5 col-lg-6 col-md-12 col-sm-12">
                                            <div class="uplodimg">
                                                <span class="uplode_spa"><small>Upload File</small></span>
                                                <div class="uplodimgfil">
                                                    <input type="file" name="img[]"  multiple id="file-1" class="inputfile" onchange="previewImages(event)" />
                                                    <label for="file-1">Select and <b>Browse</b> to upload
                                                        <em><img src="assets/images/gall.png" alt=""></em>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="preview-container" id="preview-container"></div>
                                        <div class="col-md-12">
                                            <div class="sub_btn cc_top_btn">
                                                <button style="border:none" type="submit"  class="btn_cc">Submit
                                                        <em><img src="{{ url('public') }}/assets/images/btn_icon.png" class="" alt=""></em></button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@include('admin.main.footer')

<!-- Load jQuery first -->

<script>
$(document).ready(function() {
    console.log('on ready');
    
    // Initialize Select2
    $('select').select2();
    $('select[name="priority"] option').each(function() {
        console.log('ID:', $(this).val(), 'Name:', $(this).text());
    });
    // Bind change event to deliverydate input field
    $('input[name="deliverydate"]').on('change', function() {
        console.log('Date changed');
        var selectedDate = new Date($(this).val());
        var currentDate = new Date();
        var difference = (selectedDate - currentDate) / (1000 * 3600 * 24); // Difference in days

        console.log('Selected Date:', selectedDate);
        console.log('Current Date:', currentDate);
        console.log('Difference (days):', difference);
        
        var priority = '';
        if (difference < 5) {
            priority = '1';
        } else if (difference >= 5 && difference <= 10) {
            priority = '2';
        } else {
            priority = '3';
        }

        console.log('Selected Priority:', priority);

        // Now, update the priority dropdown based on the calculated priority
        // Find the <select> for priority and set the value accordingly
        $('select[name="priority"]').val(priority).trigger('change');  // Trigger change to update Select2
        $('select[name="delivery_priority"]').val(priority).trigger('change');  // Trigger change to update Select2

    });
});


</script>

