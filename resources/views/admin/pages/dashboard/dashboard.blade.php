@include('admin.main.header');

<div class="mrg_tp"></div>
<div class="dashboard_min dashboard_pg">
	<div class="container-fluid">
		<div class="row mb-3">
			<div class="container-fluid">
				<div class="col-md-12">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">Graph Filter</h3>
						</div>
						<div class="card-body">
							<form action="{{url()->current()}}" method="get">
								<div class="row">
									<div class="col-md-3">
										<select name="filtertype" id="" class="form-control">
											<option  value="">Select</option>
											<option @if(request('filtertype')=="Monthly") selected @endif value="Monthly">Monthly</option>
											<option @if(request('filtertype')=="Quarterly") selected @endif value="Quarterly">Quarterly</option>
											<option @if(request('filtertype')=="Half Yearly") selected @endif value="Half Yearly">Half Yearly</option>
										</select>
									</div>
									<div class="col-md-2">
										@php	
											$client =DB::table('customers')->get();
										@endphp
										<select name="customers_id" id="" class="form-control">
											<option value="">Select Client</option>
											@foreach ($client as $c)
												<option @if(request('customers_id')==$c->id) selected @endif value="{{$c->id}}">{{$c->customer_name}}</option>
											@endforeach
										</select>
									</div>
									<div class="col-md-2">
										<select name="filter_year" id="" class="form-control" disabled>
											@php
												$currentYear = date('Y');
											@endphp
											@for ($i = 2000; $i <= $currentYear; $i++)
												<option @if($i==$currentYear) selected @endif value="{{$i}}">{{$i}}</option>
										  	@endfor
										</select>
									</div>
									<div class="col-md-1">
										<button type="submit" class="btn btn-success">Filter</button>
									</div>
									<div class="col-md-1">
										<a href="{{url()->current()}}" class="btn btn-success">Reset</a>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		   </div>
		<div class="dashboard_pg_sec">
       <div class="dashboard_pg_top">
       		{{-- <div class="dashboard_pg_lft">
       			<h1>Overview</h1>
       		</div> --}}
       		{{-- <div class="dashboard_pg_rig">
       			<ul>
       				<li><button href="#url" class="das_arw_btn das_bor_btn">
       					<em><img src="{{ url('public') }}/assets/images/print_icon2.png" alt="" class="prin_img1">
       					<img src="{{ url('public') }}/assets/images/print_icon.png" alt="" class="prin_img2"></em>
       					 Print</button></li>
       				<li><button class="das_arw_btn">
       					<em>
       						<img src="{{ url('public') }}/assets/images/export_icon.png" alt="" class="prin_img1">
       						<img src="{{ url('public') }}/assets/images/export_icon1.png" alt="" class="prin_img2">
       					</em>
       				Export</button></li>
       			</ul>
       		</div> --}}
       </div>
       <div class="caunt_sec">
		<div class="container-fluid">
			<div class="infobox_area">
			<div class="row">
				<div class="col-md-3">
					<div class="infobox_itm bg-success">
							<h4 class="no_count"> <span class="box_value">{{$t_order}}</span> <br> <span class="box_title">Total Orders</span></h4>
					</div>
				</div>	
				<div class="col-md-3">
					<div class="infobox_itm bg-warning">
							<h4 class="no_count"> <span class="box_value">{{$t_complete_order}}</span> <br> <span class="box_title">Total Complete Orders</span></h4>
					</div>
				</div>
				<div class="col-md-3">
					<div class="infobox_itm bg-secondary">
							<h4 class="no_count"> <span class="box_value">{{$t_pendint_order}}</span> <br> <span class="box_title">Total Pending Orders</span></h4>
					</div>
				</div>
				<div class="col-md-3">
					<div class="infobox_itm bg-primary">
							<h4 class="no_count"> <span class="box_value">{{$t_order_product}}</span> <br> <span class="box_title">Total Order Product</span></h4>
					</div>
				</div>
				<div class="col-md-3">
					<div class="infobox_itm bg-danger">
							<h4 class="no_count"> <span class="box_value">{{$t_high_pyority_order}}</span> <br> <span class="box_title">Total High Priority</span></h4>
					</div>
				</div>
				<div class="col-md-3">
					<div class="infobox_itm bg-primary">
							<h4 class="no_count"> <span class="box_value">{{$total_medium_pyority_order}}</span> <br> <span class="box_title">Total Medium Priority</span></h4>
					</div>
				</div>
				<div class="col-md-3">
					<div class="infobox_itm bg-warning">
							<h4 class="no_count"> <span class="box_value">{{$total_low_pyority_order}}</span> <br> <span class="box_title">Total Low Priority</span></h4>
					</div>
				</div>
				<div class="col-md-3">
					<div class="infobox_itm bg-success">
							<h4 class="no_count"> <span class="box_value">{{$complete_filling}}</span> <br> <span class="box_title">Filling Complete</span></h4>
					</div>
				</div>
				<div class="col-md-3">
					<div class="infobox_itm bg-warning">
							<h4 class="no_count"> <span class="box_value">{{$pending_filling}}</span> <br> <span class="box_title">Filling Pending</span></h4>
					</div>
				</div>
				<div class="col-md-3">
					<div class="infobox_itm bg-danger">
							<h4 class="no_count"> <span class="box_value">{{$complete_mounting}}</span> <br> <span class="box_title">Mounting Complete</span></h4>
					</div>
				</div>
				<div class="col-md-3">
					<div class="infobox_itm bg-success">
							<h4 class="no_count"> <span class="box_value">{{$pending_mounting}}</span> <br> <span class="box_title">Mounting Pending</span></h4>
					</div>
				</div>
				<div class="col-md-3">
					<div class="infobox_itm bg-primary">
							<h4 class="no_count"> <span class="box_value">{{$complete_setting}}</span> <br> <span class="box_title">Setting Complete</span></h4>
					</div>
				</div>
				<div class="col-md-3">
					<div class="infobox_itm bg-secondary">
							<h4 class="no_count"> <span class="box_value">{{$pending_setting}}</span> <br> <span class="box_title">Setting Pending</span></h4>
					</div>
				</div>
				<div class="col-md-3">
					<div class="infobox_itm bg-info">
							<h4 class="no_count"> <span class="box_value">{{$complete_final_polish}}</span> <br> <span class="box_title">Final polish Complete</span></h4>
					</div>
				</div>
				<div class="col-md-3">
					<div class="infobox_itm bg-primary">
							<h4 class="no_count"> <span class="box_value">{{$pending_final_polish}}</span> <br> <span class="box_title">Final polish Pending</span></h4>
					</div>
				</div>
				<div class="col-md-3">
					<div class="infobox_itm bg-warning">
							<h4 class="no_count"> <span class="box_value">{{$total_gram_issued}}</span> <br> <span class="box_title">Total Gram Issued</span></h4>
					</div>
				</div>
				<div class="col-md-3">
					<div class="infobox_itm bg-success">
							<h4 class="no_count"> <span class="box_value">{{$total_gram_recived}}</span> <br> <span class="box_title">Total Gram Pending</span></h4>
					</div>
				</div>
				<div class="col-md-3">
					<div class="infobox_itm bg-secondary">
							<h4 class="no_count"> <span class="box_value">{{$total_coustomer}}</span> <br> <span class="box_title">Total Coustomer</span></h4>
					</div>
				</div>
				<div class="col-md-3">
					<div class="infobox_itm bg-info">
							<h4 class="no_count"> <span class="box_value">{{$total_worker}}</span> <br> <span class="box_title">Total Worker</span></h4>
					</div>
				</div>
				<div class="col-md-3">
					<div class="infobox_itm bg-danger">
							<h4 class="no_count"> <span class="box_value">{{$t_order}}</span> <br> <span class="box_title">Total Repair</span></h4>
					</div>
				</div>
				<div class="col-md-3">
					<div class="infobox_itm bg-secondary">
							<h4 class="no_count"> <span class="box_value">{{$total_repair_pending}}</span> <br> <span class="box_title">Total Pending Repair</span></h4>
					</div>
				</div>
				<div class="col-md-3">
					<div class="infobox_itm bg-info">
							<h4 class="no_count"> <span class="box_value">{{$total_repair_complete}}</span> <br> <span class="box_title">Total Complete Repair</span></h4>
					</div>
				</div>
				<div class="col-md-3">
					<div class="infobox_itm bg-danger">
							<h4 class="no_count"> <span class="box_value">{{$total_repair_product}}</span> <br> <span class="box_title">Total Repair product</span></h4>
					</div>
				</div>	
			</div>
		</div>	
		</div>
       </div>
	   <div class="col-md-12">
		<div class="grap_chart_bx">
				<div class="row">
					<div class="col-md-6">
						<div class="cur_chart">
							<h3>By Karat</h3>
							<div class="canvas_pai">
								<canvas id="myChart3" width="600"></canvas>
							</div>
						</div>
						<div class="cur_tex">
							<ul>
							   @php
								   $karat_color = [  "#FFC300", "#FF5733", "#C70039", "#900C3F", "#581845",  "#00FFFF", "#00BFFF", "#008080", "#2E8B57", "#FFA07A",  "#FF7F50", "#FF6347", "#DC143C", "#8B0000", "#4B0082",  "#8A2BE2", "#4B008A", "#483D8B", "#00CED1", "#1E90FF",  "#ADD8E6", "#F08080", "#FA8072", "#E9967A", "#FFC0CB",  "#FF69B4", "#FF1493", "#C71585", "#9400D3", "#9932CC",  "#8B008B", "#800080", "#4F4F4F", "#696969", "#808080",  "#A9A9A9", "#C0C0C0", "#D3D3D3", "#FFFFFF", "#000000",  "#FFDAB9", "#FFE4B5", "#F5DEB3", "#FFF8DC", "#F5F5DC",  "#FAEBD7", "#FFF0F5", "#E6E6FA", "#F8F8FF", "#F0F8FF",  "#FFFAFA", "#F0FFF0", "#FFFACD", "#FFEFD5", "#FFF5EE",  "#F5FFFA", "#FFFFF0", "#FFF0F5", "#D8BFD8", "#DA70D6",  "#EE82EE", "#FF00FF", "#BA55D3", "#9370DB", "#8B008B",  "#6A5ACD", "#483D8B", "#7B68EE", "#191970", "#000080",  "#4169E1", "#6495ED", "#00FFFF", "#008B8B", "#20B2AA",  "#00FF7F", "#32CD32", "#9ACD32", "#ADFF2F", "#7CFC00",  "#556B2F", "#808000", "#6B8E23", "#BDB76B", "#F0E68C",  "#FFD700", "#FFA500", "#FF8C00", "#FF4500", "#B22222",  "#8B0000", "#CD5C5C", "#DC143C", "#FF69B4", "#FF1493"];
							   @endphp
							   @foreach($karrat_lable as $k => $list)
								   <li><em style="background: {{$karat_color[$k]}}"></em><span>{{$list}}</span></li>
							   @endforeach
							   
							</ul>
						</div>
					</div>
					<div class="col-md-6">
						<div class="cur_chart">
							<h3>By Karat</h3>
							<div class="canvas_pai">
							  <canvas id="myChart4" height="400" width="600"></canvas>
						  </div>
						</div>
						<div class="cur_tex">
							<ul>
							   @php
								   $cus_color = [  "#FFC300", "#FF5733", "#C70039", "#900C3F", "#581845",  "#00FFFF", "#00BFFF", "#008080", "#2E8B57", "#FFA07A",  "#FF7F50", "#FF6347", "#DC143C", "#8B0000", "#4B0082",  "#8A2BE2", "#4B008A", "#483D8B", "#00CED1", "#1E90FF",  "#ADD8E6", "#F08080", "#FA8072", "#E9967A", "#FFC0CB",  "#FF69B4", "#FF1493", "#C71585", "#9400D3", "#9932CC",  "#8B008B", "#800080", "#4F4F4F", "#696969", "#808080",  "#A9A9A9", "#C0C0C0", "#D3D3D3", "#FFFFFF", "#000000",  "#FFDAB9", "#FFE4B5", "#F5DEB3", "#FFF8DC", "#F5F5DC",  "#FAEBD7", "#FFF0F5", "#E6E6FA", "#F8F8FF", "#F0F8FF",  "#FFFAFA", "#F0FFF0", "#FFFACD", "#FFEFD5", "#FFF5EE",  "#F5FFFA", "#FFFFF0", "#FFF0F5", "#D8BFD8", "#DA70D6",  "#EE82EE", "#FF00FF", "#BA55D3", "#9370DB", "#8B008B",  "#6A5ACD", "#483D8B", "#7B68EE", "#191970", "#000080",  "#4169E1", "#6495ED", "#00FFFF", "#008B8B", "#20B2AA",  "#00FF7F", "#32CD32", "#9ACD32", "#ADFF2F", "#7CFC00",  "#556B2F", "#808000", "#6B8E23", "#BDB76B", "#F0E68C",  "#FFD700", "#FFA500", "#FF8C00", "#FF4500", "#B22222",  "#8B0000", "#CD5C5C", "#DC143C", "#FF69B4", "#FF1493"];
							   @endphp
							   @foreach ($customer_order_lable as $key => $item)
								   <li><em style="background: {{$cus_color[$key]}}"></em>{{$item}}</span></li>
							   @endforeach
							</ul>
						</div>
					</div>
				</div>
		</div>
  </div>
       <div class="grap_chart_sec">
       		<div class="row">
       			<div class="col-md-6">
       					<div class="grap_chart_bx">
       						<h3>Grams by Date</h3>
       						<b class="all_drp"><a href="#url">All <img src="{{ url('public') }}/assets/images/drop1.png" alt=""></a></b>
       						<div class="grams_dv">
       					<canvas id="myChart2" height="400" width="600"></canvas>
       					</div>
       					</div>
       			</div>
       			{{-- <div class="col-md-6">
       					<div class="grap_chart_bx">
       						<h3>Grams</h3>
       						<b class="all_drp all_drp_vie"><a href="#url">View All</a></b>
       						<canvas id="myChart5" height="400" width="600"></canvas>
       					</div>
       			</div> --}}
       			{{-- <div class="col-md-6">
       					<div class="grap_chart_bx">
       					<h3>PRODUCTS</h3>

       					<canvas id="myChart6" height="400" width="600"></canvas>
       					</div>
       			</div> --}}
       			
       		</div>
       </div>
     </div>
	</div>
</div>


@include('admin.main.footer');
