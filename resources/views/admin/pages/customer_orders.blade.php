@php
    $customer = $cus_data;
    $cus_id = $customer->id;
    $cus_initial_amount = $customer->initial_amount;
    $cus_name = "";
    $cus_bal = 0;
    if($customer->balance_amount){
        $cus_bal = $customer->balance_amount;
    }
    if($customer->customer_name){
        $cus_name = $customer->customer_name;
    }
    $cus_name = "";
    if($customer->customer_name){
        $cus_name = $customer->customer_name;
    }
    $cus_email = "";
    if($customer->email){
        $cus_email = $customer->email;
    }
    $cus_img = "";
    if($customer->customer_image){
        $cus_img = $customer->customer_image;
    }
@endphp
@include('admin.main.header')

<div class="mrg_tp"></div>
<style>
    p.head_t_m {
    font-weight: 800;
    color: #f00;
    font-size: 15px;
    }
        .tile_a span {
        font-weight: 800;
    }
    .woker_name img {
        border-radius: 50%;
        height: 30px;
        width: 30px;
    }
    .woker_name span {
        font-size: 15px;
        color: #979797;
    }
    .btn_ex_css{
        background: rgba(75, 159, 71, 0.1);
        border-radius: 8px;
        color:#4B9F47 ;
    }
    .down_sts_text span{
        font-family: 'Gotham';
        font-style: normal;
        font-weight: 500;
        font-size: 14px;
        line-height: 150%;
        /* identical to box height, or 21px */


        /* Gray/Gray-400 */

        color: #A0AEC0;
    }
    td.br-red {
        background: #ff00004a;
    }
    .mc_var_edit_btn img{
        cursor: pointer;
    }
    span.top_con_inline {
        display: inline-block;
        float: left;
        margin-right: 6px;
    }
    .details_con {
        line-height: 16px;
    }
    span.top_con_inline .cos_imag {
        height: 40px;
        width: 40px;
        border-radius: 15%;
    }
    .tab_head th {
        border: 0px solid #2984FF !important;
        border-right: 1px solid #2984FF !important;
        background: rgba(41, 132, 255, 0.13);
        white-space: nowrap;
        padding: 7px 10px 0px 10px;
    }

    .tab_head th:last-child {
        border: 0px solid #2984FF !important;
    }
    tr.head_un td {
        padding: 0px 15px;
    }
    tbody td {
        border: 0px solid #2984FF !important;
        border-right: 1px solid #2984FF !important;
    }
    tbody td:last-child {
        border: 0px solid #2984FF !important;
    }
    .das_right_inr {
        padding: 0px;
        overflow: hidden;
    }
    .head_un{
        border-bottom: 1px solid #2984FF !important;
        background: rgba(41, 132, 255, 0.13) !important;
    }
    .head_un td{
        background: rgba(41, 132, 255, 0.13) !important;
    }
    .wsp{
        white-space: nowrap;
    }
    .br_none{
        border-right: none !important;
    }
    img.pro_image {
        height: 50px;
        width: 50px;
        margin: 5px;
    }
</style>
<div class="dashboard_min">
    <div class="container-fluid">
        <div class="dashboard_panel">
        <div class="">
            <div class="row mb-3">
                <div class="col-md-12">
                    <input type="hidden" id="customer_id" value="{{$cus_id}}">
                    <input type="hidden" id="customer_id" value="{{$cus_id}}">
                    {{-- <button style="float: right;" type="button" onclick="update_balance_modal({{$cus_id}})" class="btn btn-sm btn-success mx-2">Customer Initial Balance {{$cus_bal}}</button> --}}
                    <button style="float: right;" type="button" onclick="gold_return_model()" class="btn btn-success mx-2">Gold Return</button>
                    <button style="float: right;" type="button" onclick="open_payment_model()" class="btn btn-success mx-2">Gold Recive</button>
                    <button style="float: right;" type="button" onclick="open_cashpayment_model()" class="btn btn-success  mx-2">Pending Metal Payment</button>
                    <button style="float: right;" type="button" onclick="open_chargespayment_model()" class="btn btn-success">Charges Payment</button>
                    <a style="float: right;" class="btn btn-success mr-2" href="{{url('gold_transtion/'.$cus_id)}}">View Gold Transtion</a>
                    <a style="float: right;" class="btn btn-success mr-2" href="{{url('customer_orders_excel/'.$cus_id)}}">Import To Excel</a>
                    <span class="top_con_inline">
                        @if ($cus_img)
                        <img class="cos_imag" src="{{url('public') }}/uploads/{{ $cus_img }}" alt="">
                        @else
                        <img class="cos_imag" src="http://localhost/jewellery/public/uploads/1677326235images.jpg" alt="">
                        @endif
                    </span>
                    <span class="top_con_inline">
                        <div class="details_con">
                            <div class="tile_a">
                                <span>{{$cus_name}}</span>
                            </div>
                            <div class="woker_name">
                                <span>{{$cus_id}}</span>
                            </div>
                            <div class="woker_name">
                                <span>{{$cus_email}}</span>
                            </div>
                        </div>
                    </span>
                </div>
            </div>
            <div class="das_right_inr">
                <div class="das_frm_panel">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table_con">
                            <div class="table-responsive"> 
                                <table class="table table-bordered text-center table-striped">
                                    <thead>
                                      <tr class="tab_head">
                                        <th scope="col1">Order ID</th>
                                        <th scope="col2">Date</th>
                                        <th scope="col2">Item</th>
                                        <th scope="col5">Karat</th>
                                        <th scope="col6">Gold G/W</th>                                        
                                        <th scope="col7 col7a" colspan="2">Diamond</th>
                                        <th scope="col8 col8a" colspan="2">Diamond Received</th>                                        
                                        <th scope="col9 col9a" colspan="2">Diamond Returned</th>
                                        <th scope="col10 col10a" colspan="2">Colour Stone</th>                                        
                                        <th scope="col11 col11a" colspan="2">AD</th>                                        
                                        <th scope="col12">Enamel Weight</th>
                                        <th scope="col13">Is Diamond</th>
                                        <th scope="col14">Gold N/W</th>
                                        <th scope="col15">Pure Metal </th>                                        
                                        <th scope="col16">Pure Metal Pending</th>
                                        <th scope="col17">Making Charges</th>                                        
                                        <th scope="col18">Addional Charges</th>
                                        <th scope="col19">Gold Charges</th>
                                        <th scope="col20">Diamond Charges</th>
                                        <th scope="col">Payment</th>           
                                        <th scope="col21" class="w-30">Comments</th>
                                        <th scope="col22">MC Variable</th>
                                        <th scope="col23">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <tr class="head_un">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="br_none">Weight</td>
                                        <td>Pieces</td>
                                        <td class="br_none">Weight</td>
                                        <td>Pieces</td>
                                        <td class="br_none">Weight</td>
                                        <td>Pieces</td>
                                        <td class="br_none">Weight</td>
                                        <td>Pieces</td>
                                        <td class="br_none">Weight</td>
                                        <td>Pieces</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                      </tr>
                                      @php
                                          $pure_metal_pen = 0;
                                          $total_gold_nw = 0;
                                          $cbal = $cus_bal;
                                        //   $c_gold_paid = get_customer_gold_paid($cus_id);
                                      @endphp
                                      @foreach ($orders_data as $i)
                                      @php
                                        $get_product = DB::table('order_details')->where('order_id',$i->id)->get();
                                        $get_product_img = DB::table('order_image')->where('orderid',$i->id)->get();
                                        $get_caret_det = DB::table('karrat')->where('manin_id',$i->filling_carret)->first();
                                        if ($i->is_order == 1) {
                                            $fp_recive =  $i->fp_reciv;
                                        } else {
                                            $fp_recive = count_gem_recive_polish('fp_reciv',$i->id,4);
                                        }
                                        $count_total_gc = count_gem_recive_polish('gc',$i->id,3);
                                        $count_total_ga = count_gem_recive_polish('ga',$i->id,3);
                                        $count_total_gew = count_gem_recive_polish('gew',$i->id,3);
                                        $count_total_gd = count_gem_recive_polish('gd',$i->id,3);
                                        // color stone 
                                        if(!$count_total_gc){
                                            $cs_w = 0;
                                        }else{
                                            $cs_w = $count_total_gc;
                                        }
                                        // AD 
                                        if(!$count_total_ga){
                                            $ad_w = 0;
                                        }else{
                                            $ad_w = $count_total_ga;
                                        }
                                        // Enamel WT
                                        if(!$count_total_gew){
                                            $gew_w = 0;
                                        }else{
                                            $gew_w = $count_total_gew;
                                        }
                                        // diamond
                                        if(!$count_total_gd || $i->is_diamond != 1){
                                            $diamond_w = 0;
                                        }else{
                                            $diamond_w = $count_total_gd;
                                        }
                                        $gold_nw = $fp_recive-$cs_w-$ad_w-$gew_w-$diamond_w;
                                        $pure_metal = 0;
                                        if ($i->id_cash == 1) {
                                                $pure_metal = $gold_nw;
                                        }else{
                                            if($get_caret_det){
                                                $pure_metal = $gold_nw*$get_caret_det->per;
                                            }
                                        }
                                        
                                        $gold_nw = number_format($gold_nw, 3);
                                        $pure_metal = number_format($pure_metal, 3);
                                        $pure_metal_pen = number_format($pure_metal_pen, 3);
                                        $total_gold_nw = $gold_nw+$total_gold_nw;
                                        if ($i->is_order == 1) {
                                            if($i->is_return == 1){
                                              $pure_metal_pen = $pure_metal_pen-$pure_metal;
                                            }else{
                                              $pure_metal_pen = $pure_metal_pen+$pure_metal;
                                            }
                                        } else {
                                            $pure_metal_pen = -$pure_metal-$pure_metal_pen;
                                        }
                                      @endphp
                                      @if($i->is_order == 1)
                                        <tr class="@if($i->is_return == 1) gold_return_tr @else gold_reciv_tr @endif  ">
                                            <td class="wsp">{{$i->id}}</td>
                                            <td class="wsp">{{$i->date}}</td>
                                            <td class="wsp">{{$i->items}}</td>
                                            <td>
                                              {{get_karat_name($i->filling_carret)}}
                                            </td>
                                            <td class="">{{$i->fp_reciv}}</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                            <td class="">
                                                {{$gold_nw}}
                                            </td>
                                            <td class="">
                                                {{$pure_metal}}
                                            </td>
                                            <td>
                                                {{$pure_metal_pen}}
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>{{$i->pay_amount}}</td>
                                            <td>{{$i->payment_karret_comm}}</td>
                                            <td>
                                                
                                            </td>
                                            <td>
                                                <button onclick="get_editable_values({{$i->id}})" class="btn btn-success btn-sm m-1 text-uper">Edit</button>
                                                <a href="{{url('pending_gold_payment/'.$i->id)}}" onclick="return confirm('Are you sure?')" class="btn btn-danger text-uper btn-sm m-1">Delete</a>
                                            </td>
                                        </tr>
                                      @else
                                        <tr>
                                            <td scope="col1" class="wsp">{{$i->id}}</td>
                                            <td scope="col2" class="wsp">{{$i->fp_date}}</td>
                                            <td scope="col2" class="wsp">
                                              {{get_product_item($i->id)}}
                                            </td>
                                            <td scope="col5">
                                            {{get_karat_name($i->filling_carret)}}
                                            </td>
                                            <td scope="col6">{{$fp_recive}}</td>
                                            <td scope="col7">{{count_gem_recive_polish('kd',$i->id,3)}}
                                            <input type="hidden" value="{{count_gem_recive_polish('kd',$i->id,3)}}" id="kd{{$i->id}}">
                                            </td>
                                            <td scope="col7a">{{count_gem_recive_polish('pd',$i->id,3)}}</td>
                                            <td scope="col8"></td>
                                            <td scope="col8a"></td>
                                            <td scope="col9"></td>
                                            <td scope="col9a"></td>
                                            <td scope="col10">{{$count_total_gc}}
                                            <input type="hidden" value="{{$count_total_gc}}" id="gc{{$i->id}}">
                                            </td>
                                            <td scope="col10a">{{count_gem_recive_polish('pc',$i->id,3)}}</td>
                                            <td scope="col11">{{$count_total_ga}}
                                                <input type="hidden" value="{{$count_total_ga}}" id="ga{{$i->id}}">
                                            </td>
                                            <td scope="col11a">{{count_gem_recive_polish('pa',$i->id,3)}}</td>
                                            <td scope="col12">{{$count_total_gew}}
                                                <input type="hidden" value="{{$count_total_gew}}" id="gew{{$i->id}}">
                                            </td>
                                            <td scope="col13">
                                                <div>
                                                    <form action="{{url('update_is_diamond')}}" method="post" id="diamond_form{{$i->id}}">
                                                        @csrf
                                                        <div class="form-check">
                                                            @if($i->is_diamond == 1) 
                                                            <input type="hidden" name="is_diamond" value="0">
                                                            @else
                                                            <input type="hidden" name="is_diamond" value="1">
                                                            @endif
                                                            <input type="hidden" name="orderid" value="{{$i->id}}">
                                                            <input class="form-check-input" type="checkbox" @if($i->is_diamond == 1) checked @endif value="" onchange="minus_dismond({{$i->id}})" id="is_dimond">
                                                        </div>
                                                    </form>
                                                </div>
                                            </td>
                                            <td scope="col14">
                                                <input type="hidden" id="gold_net_w{{$i->id}}" value="{{$gold_nw}}">
                                                {{$gold_nw}}
                                            </td>
                                            <td scope="col15">
                                                {{$pure_metal}}
                                                <input type="hidden" id="pure_metal{{$i->id}}" value="{{$pure_metal}}">
                                            </td>
                                            <td scope="col16">
                                                {{$pure_metal_pen}}
                                            </td>
                                            <td scope="col17">
                                                {{$i->making_charges}}
                                                <input type="hidden" name="" value="{{$i->mc_charges_val}}" id="mc_charges_val{{$i->id}}">
                                            </td>
                                            <td scopr="col18">
                                                {{$i->addional_charges_total}}
                                                <input type="hidden" name="" value="{{$i->addional_charges}}" id="addional_charges{{$i->id}}">
                                                <input type="hidden" name="" value="{{$i->addional_charges_val}}" id="addional_charges_val{{$i->id}}">
                                                <input type="hidden" name="" value="{{$i->addional_charges_total}}" id="addional_charges_total{{$i->id}}">
                                                
                                            </td>
                                            <td scopr="col19">
                                                {{$i->gold_charges_total}}
                                                <input type="hidden" name="" value="{{$i->gold_charges}}" id="gold_charges{{$i->id}}">
                                                <input type="hidden" name="" value="{{$i->gold_charges_val}}" id="gold_charges_val{{$i->id}}">
                                                <input type="hidden" name="" value="{{$i->gold_charges_total}}" id="gold_charges_total{{$i->id}}">
                                            </td>
                                            <td scopr="col20">
                                                {{$i->diamond_charges_total}}
                                                <input type="hidden" name="" value="{{$i->diamond_charges}}" id="diamond_charges{{$i->id}}">
                                                <input type="hidden" name="" value="{{$i->diamond_charges_val}}" id="diamond_charges_val{{$i->id}}">
                                                <input type="hidden" name="" value="{{$i->diamond_charges_total}}" id="diamond_charges_total{{$i->id}}">
                                            </td>
                                            <td scopr="col21"></td>
                                            <td scopr="col22"></td>
                                            <td scopr="col23">
                                                <input type="hidden" name="" value="{{$i->making_charges}}" id="making_charges{{$i->id}}">
                                                <input type="hidden" value="{{$i->mc_variable}}" id="i_mc_variable{{$i->id}}">
                                                @if (!$i->mc_variable)
                                                    <span class="mc_var_edit_btn"><img onclick="open_charges_modal({{$i->id}},0)" src="{{asset('public/img/edit.png')}}" alt=""></span>
                                                @else
                                                    <span class="mc_var_edit_btn">{{$i->mc_variable}}<img onclick="open_charges_modal({{$i->id}},{{$i->mc_variable}})" src="{{asset('public/img/edit.png')}}" alt=""></span>
                                                @endif
                                            </td>
                                            <td>
                                               <a href="{{url('print_workcomplete_pdf/'.$i->id.'/'.$gold_nw.'/'.$fp_recive)}}" class="btn btn-success text-uppercase btn-sm m-1">Print PDF</a>
                                            </td>
                                        </tr>
                                      @endif
                                      @endforeach
                                      <tr class="head_un">
                                        <td>
                                        <input type="hidden" name="" id="curent_pending_metal" value="{{$pure_metal_pen}}">
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            {{-- {{$total_fp_reciv}} --}}
                                        </td>
                                        <td>{{$total_kd}}</td>
                                        <td>{{$total_pd}}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>{{$total_gc}}</td>
                                        <td>{{$total_pc}}</td>
                                        <td>{{$total_ga}}</td>
                                        <td>{{$total_pa}}</td>
                                        <td>{{$total_gew}}</td>
                                        <td></td>
                                        <td>
                                            {{-- {{$total_gold_nw}} --}}
                                        </td>
                                        <td></td>
                                        <td>{{$pure_metal_pen}}</td>
                                        <td>{{$total_making_charges}}</td>
                                        <td>{{$total_addional_charges}}</td>
                                        <td></td>
                                        <td></td>
                                        <td>{{$total_addional_charges_given}}</td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Update Charges</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{url('update_mc_var')}}" method="post">
            @csrf
            <div class="row">
                <div class="col-12">
                    <p class="head_t_m">Making Charges</p>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                    <label for="numberInput">Gold N/W</label>
                    <input type="text"  class="form-control"  id="gold_nw" onkeyup="count_making_charges()" value="" name="gold_nw" placeholder="">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                    <label for="numberInput">MC Variable</label>
                    <input type="hidden" id="mc_order_id" name="orderid">
                    <input type="text"  class="form-control" id="mc_variable" value="" name="mc_variable" onkeyup="count_making_charges()" placeholder="">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                    <label for="numberInput">Making Charges</label>
                    <input type="text"  class="form-control" id="making_charges" value="" name="making_charges" placeholder="">
                    </div>
                </div>
                <div class="col-12">
                    <p class="head_t_m">Addional Charges</p>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                    <label for="numberInput">Addional value</label>
                    <input type="text"  class="form-control" onkeyup="count_addional_charges()" id="addional_value" value="" name="addional_value" placeholder="">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                    <label for="numberInput">Addional Charges</label>
                    <input type="text"  class="form-control" onkeyup="count_addional_charges()" id="addional_charges" value="" name="addional_charges" placeholder="">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                    <label for="numberInput">Total</label>
                    <input type="text"  class="form-control" id="addional_charges_total" value="" name="addional_charges_total" placeholder="">
                    </div>
                </div>
                <div class="col-12">
                    <p class="head_t_m">Gold Charges</p>
                </div>
                {{-- gold charge --}}
                <div class="col-md-4">
                    <div class="form-group">
                    <label for="numberInput">Pure Metal</label>
                    <input type="text"  class="form-control" onkeyup="count_gold_charges()" id="pure_metal" value="" name="pure_metal" placeholder="">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                    <label for="numberInput">Gold Charges</label>
                    <input type="text"  class="form-control" onkeyup="count_gold_charges()" id="gold_charges" value="" name="gold_charges" placeholder="">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                    <label for="numberInput">Total</label>
                    <input type="text"  class="form-control" id="gold_charges_total" value="" name="gold_charges_total" placeholder="">
                    </div>
                </div>
                <div class="col-12">
                    <p class="head_t_m">Diamond Charges</p>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                    <label for="numberInput">Diamond Weight</label>
                    <input type="text"  class="form-control" onkeyup="count_diamond_charges()" id="diamond_weight" value="" name="diamond_weight" placeholder="">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                    <label for="numberInput">Diamond Charges</label>
                    <input type="text"  class="form-control" onkeyup="count_diamond_charges()" id="diamond_charges" value="" name="diamond_charges" placeholder="">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                    <label for="numberInput">Total</label>
                    <input type="text"  class="form-control" id="diamond_charges_total" value="" name="diamond_charges_total" placeholder="">
                    </div>
                </div>
                <div class="col-md-6"></div>
                <div class="col-md-6"></div>
                <div class="col-md-6"></div>
                <div class="col-md-6"></div>
                <div class="col-md-6"></div>    
            </div>              
            <button type="submit" class="btn btn-success">Save</button>
        </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
   <!-- Modal -->
   <div class="modal fade" id="open_payment_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Gold Recive</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            @php
                $karet_form = karretform("payment_karret",0);
            @endphp
          <form action="{{url('update_customer_payment')}}" method="post">
            @csrf
            <div class="form-group">
                <label for="numberInput">Karat ( Purity )</label>
                @php echo $karet_form; @endphp
              </div>              
              <input type="hidden" id="goldeditid" name="goldeditid">
              <div class="form-group">
                <label for="numberInput">Pure Pending</label>
                <input type="text"  class="form-control" value="{{$pure_metal_pen}}" disabled>
              </div>
              <div class="form-group">
                <label for="numberInput">Pure Gold Receive</label>
                <input type="hidden" value="{{$cus_id}}" name="customerid">
                <input type="text"  class="form-control" value="" id="gold_recive" name="fp_reciv" placeholder="Enter amount">
              </div>
              <div class="form-group">
                <label for="numberInput">Charges</label>
                <input type="text"  class="form-control" value="" id="cashamount" name="pay_amount" placeholder="Enter amount">
              </div>
              <div class="form-group">
                <label for="numberInput">Comments</label>
                <input type="text"  class="form-control" value="" id="comment" name="payment_karret_comm" placeholder="">
              </div>   
              <button type="submit" class="btn btn-success">Save</button>
        </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="gold_return_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Gold Return</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            @php
                $karet_form = karretform("payment_karret",0);
            @endphp
          <form action="{{url('gold_return_insert')}}" method="post">
            @csrf
            <div class="form-group">
                <label for="numberInput">Karat ( Purity )</label>
                @php echo $karet_form; @endphp
              </div>              
              <input type="hidden" id="goldeditid" name="goldeditid">
              <div class="form-group">
                <label for="numberInput">Pure Pending</label>
                <input type="text"  class="form-control" value="{{$pure_metal_pen}}" disabled>
              </div>
              <div class="form-group">
                <label for="numberInput">Pure Gold Return</label>
                <input type="hidden" value="{{$cus_id}}" name="userid">
                <input type="text"  class="form-control" value="" id="gold_return" name="gold_return">
              </div>           
              <div class="form-group">
                <label for="numberInput">Comments</label>
                <input type="text"  class="form-control" value="" id="comment" name="comment" placeholder="">
              </div>   
              <button type="submit" class="btn btn-success">Save</button>
        </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="open_cashpayment_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Gold Karet</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            @php
                $karet_form = karretform("payment_karret",0);
            @endphp
          <form action="{{url('update_customer_cashpayment')}}" method="post">
            @csrf
                     
              <div class="form-group">
                <label for="numberInput">Pure Metal Pending	</label>
                <input type="hidden" value="{{$cus_id}}" name="customerid">
                <input type="hidden" value="1" name="id_cash">
                <input type="text"  class="form-control" value="" name="fp_reciv_value" id="currnt_pendig_metal" placeholder="">
              </div>            
              <div class="form-group">
                <label for="numberInput">Gold Price Value</label>
                <input type="text"  class="form-control" value="" name="gold_price_value" id="gold_price_value" onkeyup="conver_cash()" placeholder="">
              </div>
              <div class="form-group">
                <label for="numberInput">Total</label>
                <input type="text"  class="form-control" value="" name="pay_amount" id="current_pay_amount" placeholder="Enter amount">
              </div>
              <div class="form-group">
                <label for="numberInput">Comments</label>
                <input type="text"  class="form-control" value="" name="payment_karret_comm" placeholder="">
              </div>  
              <button type="submit" class="btn btn-success">Save</button>
        </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="open_chargespayment_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Charges Payment</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          @php
            $count_pending_payment_amount = intval($total_making_charges + $total_addional_charges - $total_addional_charges_given);
          @endphp
          <form action="{{url('customer_charges_payment')}}" method="post">
              @csrf
              <div class="form-group">
                <label for="numberInput">Pending payment amount</label>
                <input type="hidden" value="{{$cus_id}}" name="customerid">
                <input readonly type="text"  class="form-control" value="{{$count_pending_payment_amount}}" name="" id="pending_payment_amount">
              </div>
              <div class="form-group">
                <label for="numberInput">Enter amount</label>
                <input type="number" class="form-control" value="{{$count_pending_payment_amount}}" require name="payment_amount" id="payment_amount" max="{{$count_pending_payment_amount}}">
              </div>
              <div class="form-group">
                <label for="numberInput">Comment</label>
                <input type="text"  class="form-control" value="" name="comment">
              </div>
              <button type="submit" class="btn btn-success">Save</button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="open_initial_amount_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Update customer Initial Balance</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{url('update_customer_initial_balance')}}" method="post">
            @csrf
                          
              <div class="form-group">
                <label for="numberInput">Gold G/W</label>
                <input type="hidden" value="{{$cus_id}}" name="customerid">
                <input type="text"  class="form-control" id="customer_initial_bal" value="{{$cus_bal}}" name="bal" placeholder="Enter amount">
              </div>
              <button type="submit" class="btn btn-success">Save</button>
        </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  
@include('admin.main.footer')
