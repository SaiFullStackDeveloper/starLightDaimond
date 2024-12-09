@include('admin.main.header')

<div class="mrg_tp"></div>
<div class="dashboard_min">
    <div class="container-fluid">
        <div class="dashboard_panel">

            <div class="dashboard_right w-100">
                <div class="das_right_inr ">
                    <div class="">
                        <ul class="">
                            <h2>
                                <li class=" mt-5">Add Customer</li>
                            </h2>

                        </ul>
                    </div>
                    <div class="das_frm_panel ">
                        <form action="{{ route('add_customer') }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="das_frm_bx mt-5">
                                <div class="frm_inp_body">
                                    <div class="row">

                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                            <div class="input_bx">
                                                <span>Name</span>
                                                <input type="text" placeholder="Name" name="cname" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                            <div class="input_bx">
                                                <span>Nickname</span>
                                                <input type="text" placeholder="Nickname" name="nickname">
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                            <div class="input_bx">
                                                <span>Customer Id</span>
                                                <input type="text" name="orderid" value="{{get_slno_coustomer()}}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                            <div class="input_bx">
                                                <span>Address</span>
                                                <input type="text" placeholder="Address" name="address" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                            <div class="input_bx">
                                                <span>Pan No</span>
                                                <input type="text" placeholder="Pan no" name="panno">
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                            <div class="input_bx">
                                                <span>GST No</span>
                                                <input type="text" placeholder="Gst no" name="gstno">
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                            <div class="input_bx">
                                                <span>Email Id</span>
                                                <input type="text" placeholder="Customer email" name="email" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                            <div class="input_bx">
                                                <span>Customer Phone</span>
                                                <input type="text" placeholder="Customer phone" name="phone" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                            <div class="input_bx">
                                                <span>Start Date</span>
                                                <input type="text" placeholder="Joining date" class="datepicker"
                                                    name="joiningdate" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                            <div class="input_bx">
                                                <span>Aadhar Card</span>
                                                <input type="number" placeholder="Aadhar card" name="adhar">
                                            </div>
                                        </div>
                                        @if (login_role() != 3)
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12" id="manager_id_div">
                                            <div class="input_bx">
                                                <span>Select Manager</span>
                                                <select name="manager_id" id="manager_id_dropdown"  required>
                                                    <option value="">Select manager</option>
                                                    @foreach ($manager_list as $item)
                                                        <option style="text-transform: capitalize" value="{{$item->id}}">{{$item->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @else
                                        <input type="hidden" name="manager_id" value="{{login_id()}}">
                                        @endif
                                        
                                        {{-- 
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                            <div class="input_bx">
                                                <span>ADVANCE PAYMENT</span>
                                                <input type="text" placeholder="Advance Payment" name="adpay" required>
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                            <div class="input_bx">
                                                <span>BALANCE AMOUNT</span>
                                                <input type="text" placeholder="Balance Amount" name="bamount" required>
                                            </div>
                                        </div>
                                        
                                        
                                        
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                            <div class="input_bx">
                                                <span>STATUS</span>
                                                <select name="status" required>
                                                    <option value="1">COMPLETED</option>
                                                    <option value="2">PENDING</option>
                                                </select>
                                                <!-- <em class="drp_cc"><img src="assets/images/drop.png" alt=""></em> -->
                                            </div>
                                        </div> --}}
                                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                            <div class="uplodimg">
                                                <span class="uplode_spa"><small>Customer Image</small></span>
                                                <div class="uplodimgfil">
                                                    <input type="file" name="customer_image" id="file-1"
                                                        class="inputfile inputfile-1"
                                                        data-multiple-caption="{count} files selected" >
                                                    <label for="file-1">Drag and Drop or <b>Browse</b> to upload
                                                        <em><img src="{{url('public')}}/assets/images/gall.png"
                                                                alt="" style="width: 38px;border-radius:15px;height:100%;"></em>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" cc_top_btn">
                                            <button style="border:none;margin-top:123px;height:53px;text-align:center;"
                                                type="submit" class="btn_cc mx-5">Submit
                                                <em><img src="{{ url('public') }}/assets/images/btn_icon.png" alt=""
                                                    class="mt-2"></em></button>
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


@include('admin.main.footer');
