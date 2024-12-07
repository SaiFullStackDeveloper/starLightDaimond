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
                            <li><a href="{{ route('order_form') }}">Order Form</a></li>
                            <li><a href="{{ route('order_history') }}">Order History</a></li>
                            <li class="{{ (request()->route()->named('order_status')) ? 'actv' : '' }}"><a
                                    href="{{ route('order_status',[$order->id]) }}">Order Status</a></li>

                        </ul>
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 float-right">
                            <div class="input_bx">
                                @php
                                   $order_id =  DB::table('orders')->get();
                                @endphp
                                  <span>Order ID</span>
                                <select class="select2" style="width: 100%;" name="cname" onchange="ChangeOrder(this)" id="order_id">
                                    @foreach($order_id as $d)
                                       <option @if ($order->id == $d->id){{ 'selected' }} @endif value="{{$d->id}}">{{$d->id}}</option>
                                   @endforeach
                                   </select>
                            </div>
                        </div>
                    </div>
                    <div class="das_frm_panel">
                        <form action="{{ route('update_status') }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="das_frm_bx">
                                <div class="frm_tp">
                                    {{-- <h4>Order No : #{{ $order->id }}</h4> --}}

                                </div>
                                <div class="frm_inp_top mt-5">
                                    <div class="row">

                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                                            <div class="input_bx">
                                                @php
                                                   $customer =  DB::table('customers')->get();
                                                @endphp
                                                  <span>Customer Name</span>
                                                <select class="select2" style="width: 100%;" name="cname">

                                                    @foreach($customer as $d)
                                                       <option @if ($order->client_name == $d->id){{ 'selected' }} @endif value="{{$d->id}}">{{$d->customer_name}}</option>
                                                   @endforeach
                                                   </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                                            <div class="input_bx">
                                                <span>Unique ID</span>
                                                <input type="text" value="{{ $order->unique_id }}" name="unique_id">
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                                            <div class="input_bx">
                                                <span>Date</span>
                                                <input type="text" class="datepicker" name="date"
                                                    value="{{ $order->date }}">
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                                            <div class="input_bx">
                                                @php
                                                $worker = DB::table('worker')->get();
                                                @endphp
                                                <span>Worker Name</span>
                                                <input type="hidden" name="updateid" value="{{ $order->id }}">

                                                <select style="width: 100%;" name="worker_id">
                                                    <option selected>Select</option>
                                                    @foreach($worker as $d)
                                                    <option @if ($d->id) {{ 'selected' }} @endif
                                                        value="{{$d->id}}">{{$d->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="frm_inp_body">
                                    @foreach ($order_details as $data)
                                    <div class="row">
                                        <div class="col-xl-3 col-lg-2 col-md-3 col-sm-12">
                                            <div class="input_bx">
                                                <span>Product Name</span>
                                                <span class="multi-select-custom"></span>
                                                <input type="text" value="{{ $data->product_name }}">
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12">
                                            <div class="input_bx">
                                                <span>Size</span>
                                                <input type="text" value="{{ $data->size }}">
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-lg-2 col-md-3 col-sm-12">
                                            <div class="input_bx">
                                                <span>Appx Gram</span>
                                                <input type="text" value="{{ $data->appxgram}}">
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-lg-4 col-md-3 col-sm-12">
                                            <div class="input_bx">
                                                <span>Metal colour</span>
                                                <select>
                                                    <option @if ($data->mcolor == 1){{ 'selected' }} @endif >Red
                                                    </option>
                                                    <option @if ($data->mcolor == 2){{ 'selected' }} @endif >Yellow
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-4 col-md-3 col-sm-12">
                                            <div class="input_bx">
                                                <span>Karat ( Purity )</span>
                                                <select name="karat">
                                                    <option @if ($data->karat == 1){{ 'selected' }} @endif >18K</option>
                                                    <option @if ($data->karat == 2){{ 'selected' }} @endif>22K</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    @endforeach
                                    <div id="addappend"></div>


                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                                <div class="input_bx">
                                                    <span>Approx Weight Grams</span>
                                                    <input type="text" placeholder="Enter here" name="appx_weight"
                                                        value="{{ $order->appx_gram }}">
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 ">
                                                <div class="input_bx">
                                                    <span>Comments</span>
                                                    <input type="text" placeholder="Enter here" name="comment"
                                                        value="{{ $order->comments }}">
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 ">
                                                <div class="input_bx">
                                                    <span>Status</span>
                                                    <select name="status" id="">
                                                        <option  selected >Select</option>
                                                        <option @if ($order->status=='1'){{ 'selected' }} @endif
                                                            value="1">Completed</option>
                                                        <option @if ($order->status=='2'){{ 'selected' }} @endif
                                                            value="2">Pending</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 text-center mt-4 ">
                                                @if($order->status == '1')
                                                <div class="status_cc">
                                                    <span>Completed</span>
                                                </div>
                                                @elseif($order->status == '2')
                                                <div class="status_pp">
                                                    <span>Pending</span>
                                                </div>
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="sub_btn cc_top_btn">
                                            <button style="border:none" type="submit" class="btn_cc">Submit
                                                <em>
                                                    <img src="{{ url('public') }}/assets/images/btn_icon.png" class=""
                                                        alt="">
                                                </em>
                                            </button>
                                        </div>
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
