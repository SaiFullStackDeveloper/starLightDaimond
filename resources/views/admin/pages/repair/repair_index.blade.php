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
                @include('admin.main.repair_bar')
            <div class="dashboard_right">
                <div class="das_right_inr">
                    <div class="das_tab_menu">
                        <ul>
                            <li class="actv"><a href="{{route('repair_index')}}">Repair Form</a></li>
                            <li><a href="{{ route('repair_list') }}">Repair History</a></li>
                            {{-- <li><a href="#url">Order Status</a></li> --}}
                        </ul>
                    </div>
                    <div class="das_frm_panel">
                        <form action="{{ route('repair_store') }}" method="POST" enctype="multipart/form-data">
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
                                                @endphp
                                                  <span>Customer Name</span>
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
                                                <input type="text" disabled placeholder="Unique Id" name="unique_id" value="">
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                                            <div class="input_bx">
                                                <span>Date</span>
                                                <input type="text" placeholder="Select date*" class="datepicker"
                                                    name="date" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                                            <div class="input_bx">
                                                <span>Delivery Date</span>
                                                <input type="text" placeholder="Select date*" class="datepicker"
                                                    name="deliverydate" required>
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
                                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-12 p-1">
                                            <div class="input_bx">
                                                <span>Size/Inches</span>
                                                <input type="text" placeholder="Size" name="size[]">
                                            </div>
                                        </div>
                                        <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12 p-1">
                                            <div class="input_bx">
                                                <span>Screw</span>
                                                <input type="text" placeholder="Inches" name="inches[]">
                                            </div>
                                        </div>
                                        <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12 p-1">
                                            <div class="input_bx">
                                                <span>Piece</span>
                                                <input type="text" placeholder="Piece" name="piece[]" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-lg-2 col-md-3 col-sm-12 p-1">
                                            <div class="input_bx">
                                                <span>Approx Gram</span>
                                                <input type="text" placeholder="Gram" id="pro_apx_gram0" onkeyup="countapx()" class="pro_apx_gr_class" name="apxgram[]" required>
                                            </div>
                                        </div>
                                        @php
                                            $list_stcolor = get_stcolor_list();
                                        @endphp
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
                                        @php
                                            $list_karat = get_karat_list();
                                        @endphp
                                        <div class="col-xl-1 col-lg-1 col-md-1 col-sm-12 p-1">
                                            <div class="input_bx p-1">
                                                <span>Karat</span>
                                                <select name="karat" required>
                                                    @foreach ($list_karat as $item)
                                                    <option value="{{$item->manin_id}}">{{$item->name}}</option>                                                    
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
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
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                                <div class="input_bx">
                                                    <span>Approx Weight Grams</span>
                                                    <input type="text" required placeholder="Enter here" value="" id="total_order_apx_val" name="appx_weight" required>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                                <div class="input_bx">
                                                    <span>Comments</span>
                                                    <input type="text" class="comment_input_css" placeholder="Enter here" value="" name="comment">
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
                                                        <em><img src="{{ asset('assets/images/btn_icon.png') }}" class="" alt=""></em></button>
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

