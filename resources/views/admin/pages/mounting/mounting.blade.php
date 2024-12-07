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
                            <li><a href="{{ route('filling_form') }}">Filling Form</a></li>
							<li class="actv"><a href="{{ route('mounting') }}">Mounting</a></li>
							<li ><a href="{{ route('setting') }}">Setting</a></li>
							<li><a href="{{ route('final_polish') }}">Final Polish</a></li>

						</ul>
					</div>
					<div class="das_frm_panel">
						 <form>
						 		<div class="das_frm_bx">
						 			<div class="frm_tp">
						 				<h4>Order No : </h4>
						 			</div>

                                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                                    <div class="row">
                                        <div class="input_bx">
                                            @php
												$order = get_order_list(2);
                                            @endphp
                                            <span>Order Id</span>
                                            <select style="width: 100%;" id="customer_id"
                                                 name="cname"  onchange="MountingForm()">
                                                <option selected>Select</option>
                                                @foreach($order as $d)
                                                <option value="{{$d->id}}" >{{$d->unique_id}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                     </div>

						 			<div class="frm_inp_top">
						 				<div class="row">
						 					<div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
						 						<div class="input_bx">
						 							<span>Client Name</span>
						 							<input type="text" placeholder="Full Name">
						 						</div>
						 					</div>
						 					<div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
						 						<div class="input_bx">
						 							<span>Date</span>
						 							<input type="text" placeholder="26| 11 | 2022" class="datepicker hasDatepicker" id="dp1672310510829">
						 						</div>
						 					</div>
						 					<div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
						 						<div class="input_bx">
						 							<span>Worked By</span>
						 							<input type="text" placeholder="Name ">
						 						</div>
						 					</div>
						 				</div>
						 			</div>
						 			<div class="frm_inp_body">
						 				{{-- <div class="row">
						 					<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
						 						<div class="input_bx">
						 							<span>Grams Issued</span>
						 							<input type="text" placeholder="Enter here" value="2">
						 						</div>
						 					</div>
						 					<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
						 						<div class="input_bx">
						 							<span>Weight</span>
						 							<input type="text" placeholder="Enter here" value="12">
						 						</div>
						 					</div>
						 					<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
						 						<div class="input_bx">
						 							<span>Dust</span>
						 							<input type="text" placeholder="Enter here" value="18">
						 						</div>
						 					</div>
											 <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
												<div class="input_bx">
													<span>Karat ( Purity )</span>
													<select>
														<option>18K</option>
														<option>24K</option>
													</select>
													<!-- <em class="drp_cc"><img src="assets/images/drop.png" alt=""></em> -->
												</div>
											</div>
						 					<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
						 						<div class="input_bx">
						 							<span>Status</span>
						 							<input type="text" placeholder="Enter here" value="Open">
						 						</div>
						 					</div>
                      	<div class="col-md-12">
                      		<div class="sub_btn">
                      			<a href="#url" class="btn_cc">Submit
                      				<em><img src="assets/images/btn_icon.png" alt=""></em></a>
                      		</div>
                      	</div>
						 					</div> --}}
						 				</div>
						 			</div>
						 		</form></div>

					</div>
				</div>
			</div>
		</div>
	</div>


@include('admin.main.footer');
