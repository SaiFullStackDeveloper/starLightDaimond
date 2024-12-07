@php
$main_id ="";
$gram_issue = "";
$fi_add = "";
$fi_reciv = "";
$fi_return = "";
$fi_bal = "";
$comment = "";
$psts  = "";
if ($main_data) {
    $main_id = $main_data->id;
    $gram_issue = $main_data->gram_issue;
    $fi_reciv = $main_data->received;
    $fi_bal = $main_data->more_or_less;
    $comment = $main_data->comment;
    $psts = $main_data->psts;
}
@endphp
@include('admin.main.header');

<div class="mrg_tp"></div>
<div class="dashboard_min filling_frm_pg">
    <div class="container-fluid">
        <div class="dashboard_panel">
            @include('admin.main.sidebar')
            <div class="dashboard_right">
                <div class="das_right_inr">
                    <div class="das_tab_menu">
                        <ul>
                            <input type="hidden" id="dep_orderid" value="{{$order->id}}">   
                            <li><a href="{{ route('repair_filling_form') }}">Filling Form</a></li>
							<li ><a href="{{ route('repair_setting') }}">Setting</a></li>
							<li class="actv"><a href="{{ route('repair_final_polish') }}">Final Polish</a></li>
                        </ul>
                    </div>
                    <div class="das_frm_panel">
                        <form method="post" action="{{ route('update_repair_final_polish') }}">
                            @csrf
                            <div class="das_frm_bx">
                                <div class="frm_tp">
                                    <h4>Order No :  #{{ $order->id }}</h4>
                                </div>
                                @php
                                $mounting = get_repair_list(2);
                                $mounting_log = array();
                                if($order->id){
                                    $mounting_log = get_repair_forward_log($order->id,4);
                                }
                                @endphp
                                </div>
                                </div>
                                <div class="frm_inp_top">
                                    <div class="row">
                                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2">
                                            <div class="input_bx">
                                                <span>Order Id</span>
                                                <select class="" style="width: 100%;" id="customer_id"
                                                     name="cname"  onchange="FinalPolish()">
                                                    <option value="0"  selected>Select</option>
                                                    @foreach($mounting as $d)
                                                    <option @if ($order->id==$d->id){{ 'selected' }} @endif value="{{$d->id}}" >{{$d->id}}</option>
                                                    @endforeach
        
                                                </select>
                                            </div>
                                            </div>
                                            @if(count($mounting_log) > 0)
                                            <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2">
                                                <div class="input_bx">
                                                    <span>Select worker</span>
                                                    <select class="" style="width: 100%;" name="" id="get_repair_finalpolish_data">
                                                        <option value="0" selected>Select</option>
                                                        @foreach($mounting_log as $d)
                                                        <option  @if ($main_id==$d->id){{ 'selected' }} @endif value="{{$d->id}}" >{{get_worker_name($d->worker_id)}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                </div>
                                            @endif
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3">
                                            <div class="input_bx">

                                                <span>Customer Name</span>
                                                <input type="text" placeholder="Name" disabled value="{{ get_client_nickname($order->client_name) }}">
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3">
                                            <div class="input_bx">
                                                <span>Unique ID</span>
                                                <input type="text"  value="{{ $order->unique_id }}" name="uniq_id" disabled>
                                                <input type="hidden" value="{{ $order->id }}" name="update_id">
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-2">
                                            <div class="input_bx">
                                                <span>Date</span>
                                                <input type="text" class="datepicker hasDatepicker" id="dp1672309261702" value="{{ $order->date }}" name="date">
                                            </div>
                                        </div>
                                        @if (count($mounting_log) < 1)
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
                                <div class="frm_inp_body">
                                    
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                            <div class="input_bx">
                                                <span>Grams Issued</span>
                                                <input type="number" placeholder="Enter here" name="fi_issue" id="fi_issue" value="{{ $gram_issue }}" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                            <div class="input_bx">
                                                <span>Gram received</span>
                                                <input type="text" required onkeyup="count_fil_return()" placeholder="Enter here" name="fi_reciv" id="fi_reciv" value="{{ $fi_reciv }}">
                                            </div>
                                        </div>
                                        
                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                            <div class="input_bx">
                                                <span>More/Less</span>
                                                <input type="text" required placeholder="Enter here" name="fi_bal" id="fi_bal" value="{{ $fi_bal }}">
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                            <div class="input_bx">
                                                <span>Current date</span>
                                                <input type="text" disabled value="{{ date('d-m-Y') }}">
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                            <div class="input_bx">
                                                <span>Comment</span>
                                                <input type="text" placeholder="" name="comment" value="{{ $comment }}">
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
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
                                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                            <div class="input_bx">
                                                <span>Repair Status</span>
                                                <select name="status">
                                                    <option @if ($order->status=='1'){{ 'selected' }}@endif
                                                        value="1">Completed</option>
                                                    <option @if ($order->status=='2'){{ 'selected' }}@endif
                                                        value="2">Pending</option>

                                                    {{-- <option>Open</option> --}}
                                                </select>
                                            </div>
                                        </div>
                                        {{-- <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
                                            <div class="input_bx">
                                                <span>Status</span>
                                                <select name="status">
                                                    <option @if ($order->status=='1'){{ 'selected' }}@endif
                                                        value="1">Completed</option>
                                                    <option @if ($order->status=='2'){{ 'selected' }}@endif
                                                        value="2">Pending</option>
                                                </select>
                                            </div>
                                        </div> --}}
                                        @if(check_per(Session::get('id'),6,'update') || Session::get('role') == 2)
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


@include('admin.main.footer');
