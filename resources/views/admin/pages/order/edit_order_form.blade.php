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
                            <li class="actv"><a href="{{ route('order_history') }}">Order Edit</a></li>
                            {{-- <li><a href="#url">Order Status</a></li> --}}
                        </ul>
                    </div>
                    <div class="das_frm_panel">
                        <form method="POST" action="{{url('update_order_form')}}" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="edit_id" value="{{$order->id}}">
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
                                                            <option @if($order->client_name == $d->id) selected @endif value="{{$d->id}}">{{$d->nickname}}</option>
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
                                                            <option @if($order->filling_carret == $item->manin_id) selected @endif value="{{$item->manin_id}}">{{$item->name}}</option>                                                    
                                                        
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                                            <div class="input_bx">
                                                <span>Order Date</span>
                                                <input type="text" placeholder="Select date*" class="datepicker"
                                                    name="date"  value='{{$order->date}}' required>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                                            <div class="input_bx">
                                                <span>Delivery Date</span>
                                                <input type="text"  value='{{$order->delivery_date}}' placeholder="Select date*" class="datepicker"
                                                    name="deliverydate" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                                            <div class="input_bx">
                                                <span>Priority</span>
                                                <select name="priority" required>
                                                    @foreach ($list_priority as $item)
                                                   
                                                    <option @if($order->priority == $item->id) selected @endif value="{{$item->id}}">{{$item->name}}</option>                                                    
                                                   
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                                            <div class="input_bx">
                                                <span>Delivery Dates</span>
                                                <select name="delivery_priority" required>
                                                    <option disabled selected value>Select an option</option>
                                                    <option @if($order->delivery_priority == 1) selected @endif value="1">Less than 5</option>
                                                    <option @if($order->delivery_priority == 2) selected @endif value="2">5 to 10</option>
                                                    <option @if($order->delivery_priority == 3) selected @endif value="3">Above 10</option>                                                    
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="frm_inp_body">
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                            <span class="add_pro_title">Multiple Products<img onclick="appendformedit({{count($order_details)}})" src="{{asset('public/img/plus-sign 1.png')}}" alt=""> </span>
                                        </div>
                                    </div>
                                    @php
                                     $index = 1;   
                                    @endphp
                                    @foreach($order_details as $list)
                                    <div class="row remove{{$index}}" @if($index != 1) id="removelist" @endif>
                                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 p-1">
                                            <div class="input_bx">
                                                <span>Product Name</span>
                                                <span class="multi-select-custom"></span>
                                                <input type="text" placeholder="Product Name" name="pname[]"  value='{{$list->product_name}}' required>
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-lg-1 col-md-1 col-sm-12 p-1">
                                            <div class="input_bx">
                                                <span>Client order no</span>
                                                <span class="multi-select-custom"></span>
                                                <input type="text" placeholder="Client Order no" class="numbers" maxlength="10" name="client_order_no[]" value='{{$list->client_order_no}}' required>
                                            </div>
                                        </div>
                                        <div class="col-xl-1 col-lg-2 col-md-2 col-sm-12 p-1">
                                            <div class="input_bx">
                                                <span>Size/Inches</span>
                                                <input type="text" placeholder="Size" name="size[]"  value='{{$list->size}}'>
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 p-1">
                                            <div class="input_bx">
                                                <span>Screw</span>
                                                <select name="inches[]" required>
                                                    <option disabled selected value>Select an option</option>
                                                    <option @if($list->inches == "bombay") selected @endif value="bombay">Bombay</option>
                                                    <option @if($list->inches == "south") selected @endif value="south">South</option>
                                                    <option @if($list->inches == "nose_pin") selected @endif value="nose_pin">Nose pin</option>
                                                    <option @if($list->inches == "tar") selected @endif value="tar">Tar</option>                                                   
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12 p-1">
                                            <div class="input_bx">
                                                <span>Piece</span>
                                                <input type="text" placeholder="Piece" id="piece" name="piece[]" required  value='{{$list->piece}}'>
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-lg-2 col-md-3 col-sm-12 p-1">
                                            <div class="input_bx">
                                                <span>Approx Grams</span>
                                                <input type="text" placeholder="Gram" id="pro_apx_gram0" onkeyup="countapx()" class="pro_apx_gr_class" name="apxgram[]" required  value='{{$list->appxgram}}'>
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-lg-4 col-md-3 col-sm-12 p-1">
                                            <div class="input_bx">
                                                <span>Metal colour</span>
                                                <select name="mcolor[]" required>
                                                    @foreach ($list_stcolor as $item)
                                                            <option selected value="{{$item->id}}">{{$item->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <!-- <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12 p-1">
                                            <div class="input_bx">
                                                <span>Karat</span>
                                                <select name="karat[]" required>
                                                    @foreach ($list_karat as $item)
                                                            <option selected value="{{$item->manin_id}}">{{$item->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div> -->
                                        <div class="col-md-1  mt-5">
                                            @if($index > 1)<div class="form-group"><button class="btn btn-danger" type="button" style="background-color: rgba(0, 0, 0, 0);font-size: 20px; padding: 0px 10px;" onclick="removeform({{$index}})"><img src='{{asset('public/img/deleteicon.png')}}' alt=''></button></div>@endif
                                        </div>
                                    </div>
                                    @php
                                     $index++;   
                                    @endphp
                                    @endforeach
                                        <div id="addappend"></div>


                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                                <div class="input_bx">
                                                    <span>Approx Weight Grams</span>
                                                    <input type="text" required placeholder="Enter here" value="{{$order->appx_gram}}" id="total_order_apx_val" name="appx_weight" required>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                                <div class="input_bx">
                                                    <span>Comments</span>
                                                    <input type="text" class="comment_input_css" placeholder="Enter here" value="{{$order->comments}}" name="comment" >
                                                </div>
                                            </div>
                                        </div> 
                                        
                                        <div class="col-xl-5 col-lg-6 col-md-12 col-sm-12">
                                            <div class="uplodimg">
                                                <span class="uplode_spa"><small>Upload File</small></span>
                                                <div class="uplodimgfil">
                                                    <input type="file" name="img[]" multiple id="file-1" class="inputfile" onchange="previewImages(event)" />
                                                    <label for="file-1">Select and <b>Browse</b> to upload
                                                        <em><img src="assets/images/gall.png" alt=""></em>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="preview-container" id="preview-container"></div>   
                                        @if(count($order_image) > 0)
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                <h3>Uploaded Images</h3>
                                            </div>
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                <div class="row">
                                                @foreach($order_image as $list)
                                                <div class="col-4 text-center">
                                                    <img src='{{url('public/uploads',$list->name)}}' class='preview-image'>
                                                    <a href="{{url('delete_product_image',$list->id)}}" class="btn btn-danger w-100">Delete</a>
                                                </div>
                                                @endforeach
                                            </div>
                                        @endif
                                        <div class="col-md-12">
                                            <div class="sub_btn cc_top_btn">
                                                <button style="border:none" type="submit"  class="btn_cc">Update
                                                        <em><img src="{{ url('public') }}/assets/images/btn_icon.png" class="" alt=""></em></button>
                                            </div>
                                        </div>
                                            {{-- </div> --}}
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

