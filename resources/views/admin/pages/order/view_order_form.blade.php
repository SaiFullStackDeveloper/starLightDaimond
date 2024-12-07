@include('admin.main.header')
<style>
    .product-image {
        height: auto;
        width: 200px;
    }
</style>
<div class="mrg_tp"></div>
<div class="dashboard_min">
    <div class="container-fluid">
        <div class="dashboard_panel">
                @include('admin.main.sidebar')
            <div class="dashboard_right">
                <div class="das_right_inr">
                    <div class="das_tab_menu">
                        <ul>
                            <li><a href="order-form.html">Order Form</a></li>
                            <li class="actv"><a href="{{ route('order_history') }}">Order Preview</a></li>
                            {{-- <li><a href="#url">Order Status</a></li> --}}
                        </ul>
                    </div>
                    <div class="das_frm_panel">
                        <form method="POST" enctype="multipart/form-data">
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
                                                <select class="select2" readonly required style="width: 100%;" name="cname">

                                                    @foreach($customer as $d)
                                                        @if($order->client_name == $d->id)
                                                            <option @if($order->client_name == $d->id) selected @endif value="{{$d->id}}">{{$d->nickname}}</option>
                                                        @endif
                                                   @endforeach
                                                   </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                                            <div class="input_bx">
                                                <span>Unique ID</span>
                                                <input type="text" readonly placeholder="" name="unique_id" value="{{$order->unique_id}}">
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                                            <div class="input_bx">
                                                <span>Order From No</span>
                                                <input type="text" disabled placeholder="" name="ofnumber" value="{{$order->ofnumber}}">
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                                            <div class="input_bx">
                                                <span>Karat</span>
                                                <select name="main_karat" required>
                                                    @foreach ($list_karat as $item)
                                                        @if($order->filling_carret == $item->manin_id)
                                                            <option @if($order->filling_carret == $item->manin_id) selected @endif value="{{$item->manin_id}}">{{$item->name}}</option>                                                    
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                                            <div class="input_bx">
                                                <span>Date</span>
                                                <input type="text" placeholder="Select date*" class="datepicker"
                                                    name="date" readonly value='{{$order->date}}' required>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                                            <div class="input_bx">
                                                <span>Delivery Date</span>
                                                <input type="text" readonly value='{{$order->delivery_date}}' placeholder="Select date*" class="datepicker"
                                                    name="deliverydate" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                                            <div class="input_bx">
                                                <span>Priority</span>
                                                <select name="priority" required>
                                                    @foreach ($list_priority as $item)
                                                    @if($order->priority == $item->id)
                                                    <option @if($order->priority == $item->id) selected @endif value="{{$item->id}}">{{$item->name}}</option>                                                    
                                                    @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="frm_inp_body">
                                    @foreach($order_details as $list)
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                            <span class="add_pro_title">Multiple Products</span>
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
                                                <select name="karat[]" required>
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
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                                <div class="input_bx">
                                                    <span>Comments</span>
                                                    <input type="text" class="comment_input_css" placeholder="Enter here" value="{{$order->comments}}" readonly name="comment" >
                                                </div>
                                            </div>
                                        </div>    
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                            <h3>Uploaded Images</h3>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                            <div class="preview-container" id="preview-container">
                                                @foreach($order_image as $list)
                                                    <img src='{{url('public/uploads',$list->name)}}' class='preview-image'>
                                                @endforeach
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

