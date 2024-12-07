@php
$main_id ="";
$gram_issue = "";
$fi_add = "";
$fi_reciv = "";
$fi_return = "";
$fi_bal = "";
$psts  = "";

if ($main_data) {
    $main_id = $main_data->id;
    $gram_issue = $main_data->gram_issue;
    $fi_add = $main_data->fi_add;
    $fi_reciv = $main_data->fi_reciv;
    $fi_return = $main_data->fi_return;
    $fi_bal = $main_data->fi_bal;
    $psts = $main_data->psts;
}
@endphp
@include('admin.main.header');

<div class="mrg_tp"></div>
<div class="dashboard_min filling_frm_pg">
    <div class="container-fluid">
        <div class="dashboard_panel">
            <div class="dashboard_right" style="width: 100%;">
                <div class="das_right_inr">
                    <div class="das_tab_menu">
                        <ul>
                            <input type="hidden" id="dep_orderid" value="{{$order->id}}">
                            <li class="actv"><a href="{{ url('filling_form',$order->id) }}">Filling Form</a></li>
                            <li><a href="{{ url('Mounting_Form',$order->id) }}">Mounting</a></li>
                            <li><a href="{{ url('Setting_Form',$order->id) }}">Setting</a></li>
                            <li><a href="{{ route('final_Form',$order->id) }}">Final Polish</a></li>
                        </ul>
                    </div>
                    <div class="das_frm_panel">
                        <form action="{{ route('update_filling_form') }}" method="post">
                            {{ csrf_field() }}
                            <div class="das_frm_bx">
                                <div class="frm_tp">
                                    <h4>Order No : #{{ $order->ofnumber }}</h4>
                                </div>
                                @php
                                $filling = get_order_list(1);
                                $forward_log = array();
                                if($order->id){
                                    $forward_log = get_forward_log($order->id,1);
                                    
                                }
                                @endphp
                               
                                    </div>
                                     </div>

                                <div class="frm_inp_top">
                                    <div class="row">
                                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2">
                                            <div class="input_bx">
                                                <span>Unique ID</span>
                                                <select disabled class="" style="width: 100%;" id="customer_id"
                                                     name="cname"  onchange="FillingForm()">
                                                    <option value="0"  selected>Select</option>
                                                    @foreach($filling as $d)
                                                    <option @if ($order->id==$d->id){{ 'selected' }} @endif value="{{$d->id}}" >{{$d->unique_id}}</option>
                                                    @endforeach
        
                                                </select>
                                            </div>
                                            </div>
                                            @if(count($forward_log) > 0)
                                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2">
                                                <div class="input_bx">
                                                    <span>Select worker</span>
                                                    <select class="" style="width: 100%;" name="" id="get_FillingForm_data">
                                                        <option value="0" selected>Select</option>
                                                        @foreach($forward_log as $d)
                                                        <option  @if ($main_id==$d->id){{ 'selected' }} @endif value="{{$d->id}}" >{{get_worker_name($d->worker_id)}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                </div>
                                            @endif
                                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2">
                                            <div class="input_bx">

                                                <span>Customer Name</span>
                                                <input type="text" placeholder="Name" disabled value="{{ get_client_nickname($order->client_name) }}">
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2">
                                            <div class="input_bx">
                                                <span>Date</span>
                                                <input type="text" class="datepicker hasDatepicker" id="dp1672309261702" value="{{ $order->date }}" name="date">
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2">
                                            <div class="input_bx">
                                                <span>Order Form Number</span>
                                                <input type="text" value="{{ $order->ofnumber }}" name="ofnumber" disabled>
                                            </div>
                                        </div>
                                        @if(login_role() == 3 || login_role() == 1)
                                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 mt-5">
                                            <span class="filling_btn cr_poin" onclick="forward_order(1,{{$order->is_multiple}},{{$order->id}})"><img src="{{url('public/img/diamond.png')}}" class="forbtn_di" alt=""></span>
                                            @if (check_forward($order->id,2))
                                            @endif
                                            @if(check_forward($order->id,1))
                                                <div><span class="text-danger">Pending</span></div>
                                            @else
                                                <span class="br-right"></span> <span><a  href="{{ url('filling_form/'.$order->id) }}"><i class="fas fa-eye vieweyeicon"></i></a></span>
                                            @endif
                                        </div>
                                        @endif
                                        @if (count($forward_log) < 1)
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 mt-30">
                                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                Order not forwarded to any worker !    
                                            </div>  
                                        </div>
                                        @endif
                                        {{-- <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                                            <div class="input_bx">
                                                @php
                                               $worker =  DB::table('worker')->get();
                                            @endphp
                                                 <span>Worked By</span>
                                                 <select disabled style="width: 100%;" name="worker_id">
                                                    <option selected >Select</option>
                                                    @foreach($worker as $d)
                                                       <option @if ($d->id == $order->worker_id) {{ 'selected' }} @endif value="{{$d->id}}">{{$d->name}}</option>
                                                   @endforeach
                                                   </select>
                                             </div>
                                        </div> --}}
                                    </div>
                                </div>
                                <p class="mt-3">
                                    <button class="btn btn-success" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                        View Order Preview
                                    </button>
                                </p>
                                <div class="collapse" id="collapseExample">
                                    
                                        <div class="frm_inp_body">
                                                @foreach($order_details as $list)
                                                <div class="row">
                                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                        <span class="add_pro_title">Order preview</span>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 p-1">
                                                        <div class="input_bx">
                                                            <span>Product Name</span>
                                                            <span class="multi-select-custom"></span>
                                                            <input type="text" placeholder="Product Name" name="pname[]" readonly value='{{$list->product_name}}' required>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 p-1">
                                                        <div class="input_bx">
                                                            <span>Size/Inches</span>
                                                            <input type="text" placeholder="Size" name="size[]" readonly value='{{$list->size}}'>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12 p-1">
                                                        <div class="input_bx">
                                                            <span>Screw</span>
                                                            <input type="text" placeholder="Inches" name="inches[]" readonly value='{{$list->inches}}'>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12 p-1">
                                                        <div class="input_bx">
                                                            <span>Piece</span>
                                                            <input type="text" placeholder="Piece" name="piece[]" required readonly value='{{$list->piece}}'>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-2 col-md-3 col-sm-12 p-1">
                                                        <div class="input_bx">
                                                            <span>Approx Grams</span>
                                                            <input type="text" placeholder="Gram" id="pro_apx_gram0" onkeyup="countapx()" class="pro_apx_gr_class" name="apxgram[]" required readonly value='{{$list->appxgram}}'>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-4 col-md-3 col-sm-12 p-1">
                                                        <div class="input_bx">
                                                            <span>Metal colour</span>
                                                            <select name="mcolor[]" required>
                                                                @foreach ($list_stcolor as $item)
                                                                    @if($list->mcolor == $item->id)
                                                                        <option selected value="{{$item->id}}">{{$item->name}}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12 p-1">
                                                        <div class="input_bx">
                                                            <span>Karat</span>
                                                            <select name="karat[]">
                                                                @foreach ($list_karat as $item)
                                                                    @if($list->karat == $item->manin_id)
                                                                        <option selected value="{{$item->manin_id}}">{{$item->name}}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1  mt-5">
                                                        
                                                    </div>
                                                </div>
                                                @endforeach
                                            <div id="addappend"></div>
                                            <div class="row">
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                                    <div class="input_bx">
                                                        <span>Approx Weight Grams</span>
                                                        <input type="text" required placeholder="Enter here" value="{{$order->appx_gram}}" id="total_order_apx_val" name="appx_weight" required readonly>
                                                    </div>
                                                </div>
                                                @if($order->comments)
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                                    <div class="form-group mt-4">
                                                        <span>Comments</span>
                                                        <textarea type="text" rows="5" class="form-control" placeholder="Enter here" readonly name="comment" >{{$order->comments}}</textarea>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>    
                                            <div class="mt-5 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                <div class='row preview-container' id="preview-container">
                                                    @foreach($order_image as $list)
                                                    <div class='col-md-2'>
                                                        <a href="{{url('public/uploads',$list->name)}}" target="_blank">
                                                        <img height="100" width="100" class="product-image-preview" src='{{url('public/uploads',$list->name)}}' class='product-image'></a>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    
                                </div>
                                <div class="frm_inp_body">
                                    <div class="row">
                                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-6">
                                            <div class="input_bx" id="fi_issue_div">
                                                <span>Grams Issued</span>
                                                <input type="hidden" value="{{$order->appx_gram}}" id="appxGram">
                                                <input type="number" placeholder="Enter here" name="fi_issue" id="fi_issue" value="{{ $gram_issue }}" required disabled>
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-6">
                                            <div class="input_bx">
                                                <span>Grams Added</span>
                                                <input type="text" step="0.00" min="0.00" name="fi_add" id="fi_add" onkeyup="count_fil_addon()" placeholder="Enter here" value="{{ $fi_add }}">
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-6">
                                            <div class="input_bx">
                                                <span>Karat ( Purity )</span>
                                                @php
                                                    $klist = get_karat_list();
                                                @endphp
                                                <select name="filling_carret">
                                                    @foreach ($klist as $ki)
                                                    <option @if ($order->filling_carret == $ki->manin_id) {{ 'selected' }} @endif value="{{$ki->manin_id}}">{{$ki->name}}</option>
                                                    @endforeach
                                                </select>
                                                <!-- <em class="drp_cc"><img src="assets/images/drop.png" alt=""></em> -->
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-6">
                                            <div class="input_bx">
                                                <span>Gram received</span>
                                                <input type="text" required onkeyup="count_fil_return()" placeholder="Enter here" name="fi_reciv" id="fi_reciv" value="{{ $fi_reciv }}">
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-6">
                                            <div class="input_bx">
                                                <span>Grams Returned</span>
                                                <input type="text" onkeyup="count_fil_return()" placeholder="Enter here" name="fi_return" id="fi_return" value="{{ $fi_return }}">
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-6">
                                            <div class="input_bx">
                                                <span>Balance</span>
                                                <input type="text" required placeholder="Enter here" name="fi_bal" id="fi_bal" value="{{ $fi_bal }}">
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-6">
                                            <div class="input_bx">
                                                <span>Current date</span>
                                                <input type="text" disabled value="{{ date('d-m-Y') }}">
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-6">
                                            <div class="input_bx">
                                                <span>Work Status</span>
                                                <select name="psts">
                                                    <option @if ($psts=='1'){{ 'selected' }}@endif
                                                        value="1">Completed</option>
                                                    <option @if ($psts=='2'){{ 'selected' }}@endif
                                                        value="2">Pending</option>
                                                    {{-- <option>Open</option> --}}
                                                </select>
                                            </div>
                                        </div>

                                        @if(check_per(Session::get('id'),4,'update') || Session::get('role') == 2)
                                        <div class="col-md-12">
                                            <div class="sub_btn cc_top_btn">
                                                @if ($main_id)
                                                
                                                    <input type="hidden" value="{{$main_id}}" name="work_id">
                                                <button style="border:none" type="submit"  class="btn_cc">Submit
                                                    <em><img src="{{ url('public') }}/assets/images/btn_icon.png" class="" alt=""></em></button>
                                                </div>
                                                @endif
                                        </div>
                                        @endif
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
<!-- Modal -->
@php
if(login_role() == 3){
    $worker = DB::table('worker')->where('manager_id',login_id())->where('role', 2)->orderBy('name','ASC')->get();
}else{
    $worker = DB::table('worker')->where('role', 2)->orderBy('name','ASC')->get();
}
@endphp
<div class="modal fade" id="forward_order_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"><span id="forward_modal_name"></span></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            
          <form action="" method="post" id="forward_order_form" onsubmit="btnloder()">
            @csrf             
              <div class="form-group">
                  <input type="hidden" id="order_id" name="order_id">
                  <input type="hidden" id="refer_type" name="refer_type">
                <label for="numberInput">Worker</label>
                <select name="worker_id" id="worker_id" class="form-control" required>
                    @foreach ($worker as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                </select>
              </div>
              <div class="form-group" id="gram_issue_box">
                <label for="numberInput">Gram Issue</label>
                <input type="text"  class="form-control" value="" name="gram_issue" id="gram_issue" placeholder="Enter amount" required>
              </div>
              <div class="form-group">
                <label for="numberInput">Comments</label>
                <input type="text"  class="form-control" value="" name="comments" id="comments" placeholder="">
              </div>              
              <button type="submit" class="btn btn-success loaderbtn">Save</button>
        </form>
        <div id="refer_table_his"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

@include('admin.main.footer');
