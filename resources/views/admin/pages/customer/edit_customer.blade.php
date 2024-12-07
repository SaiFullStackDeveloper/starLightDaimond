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
                                <li class=" mt-5"><a href="order-form.html">Edit Customer</a></li>
                            </h2>

                        </ul>
                    </div>
                    <div class="das_frm_panel ">
                        <form action="{{ route('add_customer') }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="das_frm_bx mt-5">
                                <div class="frm_inp_body">
                                    <div class="row">

                                        <input type="hidden" name="update_id" value="{{ $customer->id }}" >
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                            <div class="input_bx">
                                                <span>Customer Name</span>
                                                <input type="text" placeholder="Customer Name" name="cname" value="{{ $customer->customer_name }}" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                            <div class="input_bx">
                                                <span>Nickname</span>
                                                <input type="text" placeholder="Nickname" name="nickname" value="{{ $customer->nickname }}" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                            <div class="input_bx">
                                                <span>Customer Id</span>
                                                <input type="text" value="{{ $customer->order_id }}" disabled name="orderid">
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                            <div class="input_bx">
                                                <span>Address</span>
                                                <input type="text" placeholder="Address" name="address" value="{{ $customer->address }}" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                            <div class="input_bx">
                                                <span>Pan No</span>
                                                <input type="text" placeholder="Pan No" name="panno" value="{{ $customer->pan_no }}" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                            <div class="input_bx">
                                                <span>GST no</span>
                                                <input type="text" placeholder="Gst no" name="gstno" value="{{ $customer->gst_no }}" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                            <div class="input_bx">
                                                <span>Email Id</span>
                                                <input type="email" placeholder="Customer email" name="email" value="{{ $customer->email }}" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                            <div class="input_bx">
                                                <span>Customer Phone</span>
                                                <input type="text" placeholder="Customer Phone" name="phone" value="{{ $customer->phone }}" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                            <div class="input_bx">
                                                <span>Joining Date</span>
                                                <input type="text" placeholder="Joining date" value="{{ $customer->joiningdate }}" class="datepicker"
                                                    name="joiningdate" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                            <div class="input_bx">
                                                <span>Aadhar Card</span>
                                                <input type="number" placeholder="Aadhar card" value="{{ $customer->aadhar_no }}" name="adhar">
                                            </div>
                                        </div>
                                        @if (login_role() != 3)
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12" id="manager_id_div">
                                            <div class="input_bx">
                                                <span>Select Manager</span>
                                                <select name="manager_id" id="manager_id_dropdown"  required>
                                                    <option value="">Select manager</option>
                                                    @foreach ($manager_list as $item)
                                                        <option @if($customer->manager_id == $item->id) selected @endif style="text-transform: capitalize" value="{{$item->id}}">{{$item->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @else
                                        <input type="hidden" name="manager_id" value="{{login_id()}}">
                                        @endif
                                        {{-- <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                            <div class="input_bx">
                                                <span>AADHAAR CARD</span>
                                                <input type="number" placeholder="Customer Aadhaar" name="adhar" value="{{ $customer->aadhar_no }}"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                            <div class="input_bx">
                                                <span>ADVANCE PAYMENT</span>
                                                <input type="text" placeholder="Advance Payment" name="adpay" value="{{ $customer->advance_pay }}" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                            <div class="input_bx">
                                                <span>DOB</span>
                                                <input type="text" placeholder="DOB" class="datepicker" name="date" value="{{ $customer->dob }}" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                            <div class="input_bx">
                                                <span>BALANCE AMOUNT</span>
                                                <input type="text" placeholder="Balance Amount" name="bamount" value="{{ $customer->balance_amount }}" required>
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                            <div class="input_bx">
                                                <span>ORDER ID</span>
                                                <input type="text" placeholder="Order Id" name="orderid" value="{{ $customer->order_id }}" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                            <div class="input_bx">
                                                <span>STATUS</span>
                                                <select name="status" required>
                                                    <option  @if ($customer->status == 1){{ 'selected' }} @endif value="1">COMPLETED</option>
                                                    <option  @if ($customer->status == 2){{ 'selected' }} @endif value="2">PENDING</option>
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
                                                        <em><img src="{{url('public')}}/uploads/{{ $customer->customer_image }}"
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
