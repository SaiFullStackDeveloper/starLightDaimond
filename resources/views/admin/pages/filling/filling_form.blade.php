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
							<li class="actv"><a href="{{ route('filling_form') }}">Filling Form</a></li>
							<li><a href="{{ route('mounting') }}">Mounting</a></li>
							<li><a href="{{ route('setting') }}">Setting</a></li>
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
												$order = get_order_list(1);
                                            @endphp
                                            <span>Order Id</span>
                                            <select style="width: 100%;" id="customer_id"
                                                 name="cname"  onchange="FillingForm()">
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

                                                    <span>Customer Name</span>
                                             <input type="text" name="" id="" value="">
                                                </div>
						 					</div>
						 					<div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
						 						<div class="input_bx">
						 							<span>Date</span>
						 							<input type="text" placeholder="26| 11 | 2022" class="datepicker hasDatepicker" id="dp1672309261702">
						 						</div>
						 					</div>
						 					<div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
						 						<div class="input_bx">
													@php
                                                   $worker =  DB::table('worker')->get();
                                                @endphp
						 							<span>Worked By</span>
						 							<select style="width: 100%;" name="worker_id">
                                                    <option selected >Select</option>
                                                    @foreach($worker as $d)
                                                       <option @if ($d->id) {{ 'selected' }} @endif value="{{$d->id}}">{{$d->name}}</option>
                                                   @endforeach
                                                   </select>
						 						</div>
						 					</div>
						 				</div>
						 			</div>
						 			<div class="frm_inp_body">
						 				{{-- <div class="row">
						 					<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
						 						<div class="input_bx">
						 							<span>Grams Issued</span>
						 							<input type="text" placeholder="Enter here" value="5">
						 						</div>
						 					</div>
											 <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
												<div class="input_bx">
													<span>Grams Added</span>
													<input type="text" placeholder="Enter here" value="2">
												</div>
											</div>
						 					<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
						 						<div class="input_bx">
						 							<span>Karat ( Purity )</span>
						 							<select>
						 								<option>18K</option>
						 								<option>22K</option>
						 							</select>
						 							<!-- <em class="drp_cc"><img src="assets/images/drop.png" alt=""></em> -->
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
													<span>Grams Returned</span>
													<input type="text" placeholder="Enter here" value="7">
												</div>
											</div>
						 					<div class="col-xl-4 col-lg-6 col-md-6 col-sm-12">
						 						<div class="input_bx">
						 							<span>Status</span>
						 							<input type="text" placeholder="Enter here" value="Open">
						 						</div>
						 					</div>
											 <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
												<div class="input_bx tex_er">
													<span>Comments</span>
													<textarea placeholder="Enter here" value="Text"></textarea>
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
