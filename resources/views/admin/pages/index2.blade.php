@include('admin.main.header');

<div class="mrg_tp"></div>
<div class="dashboard_min dashboard_pg">
	<div class="container-fluid">
		<div class="dashboard_pg_sec">
       <div class="dashboard_pg_top">
       		<div class="dashboard_pg_lft">
       			<h1>Overview</h1>
       		</div>
       		<div class="dashboard_pg_rig">
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
       		</div>
       </div>
       <div class="caunt_sec">
       		<div class="caunt_bx">
       			<h4>Orders</h4>
       			<h2>91023</h2>
       			<p class="count_red"><i class="fa fa-caret-down"></i>-0.5%</p>
       		</div>
       		<div class="caunt_bx">
       			<h4>Products</h4>
       			<h2>7682</h2>
       			<p class="count_gr"><i class="fa fa-caret-down"></i>+0.1%</p>
       		</div>
       		<div class="caunt_bx">
       			<h4>Customers</h4>
       			<h2>6818</h2>
       			<p class="count_red"><i class="fa fa-caret-down"></i>-2.1%</p>
       		</div>
       		<div class="caunt_bx">
       			<h4>Grams</h4>
       			<h2>2322</h2>
       			<p class="count_red"><i class="fa fa-caret-down"></i>+0.8%</p>
       		</div>
       </div>
       <div class="grap_chart_sec">
       		<div class="row">
       			<div class="col-md-6">
       					<div class="grap_chart_bx">
       						<h3>By Grams</h3>
       						<b class="all_drp"><a href="#url">All <img src="{{ url('public') }}/assets/images/drop1.png" alt=""></a></b>
       						<div class="grams_dv">
       							<canvas id="myChart" height="400" width="600"></canvas>
       						</div>
							</div>
       			</div>
       			<div class="col-md-6">
       					<div class="grap_chart_bx">
       						<h3>Grams by Date</h3>
       						<b class="all_drp"><a href="#url">All <img src="{{ url('public') }}/assets/images/drop1.png" alt=""></a></b>
       						<div class="grams_dv">
       					<canvas id="myChart2" height="400" width="600"></canvas>
       					</div>
       					</div>
       			</div>
       			<div class="col-md-6">
       					<div class="grap_chart_bx">
       						<h3>Grams</h3>
       						<b class="all_drp all_drp_vie"><a href="#url">View All</a></b>
       						<canvas id="myChart5" height="400" width="600"></canvas>
       					</div>
       			</div>
       			<div class="col-md-6">
       					<div class="grap_chart_bx">
       					<h3>PRODUCTS</h3>

       					<canvas id="myChart6" height="400" width="600"></canvas>
       					</div>
       			</div>
       			<div class="col-md-12">
     					<div class="grap_chart_bx">
     							<div class="row">
     								<div class="col-md-6">
     									<div class="cur_chart">
     										<h3>By Colour</h3>
     										<div class="canvas_pai">
     											<canvas id="myChart3" width="600"></canvas>
     										</div>
     									</div>
     									<div class="cur_tex">
     										<ul>
     											<li class="yel"><em></em>Yellow<span>9283</span></li>
     											<li class="wit"><em></em>White<span>2434</span></li>
     											<li class="ton2"><em></em>2 Tone<span>1234</span></li>
     											<li class="ton3"><em></em>3 Tone<span>34432</span></li>
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
     											<li class="kar_18"><em></em>18 Karat<span>40%</span></li>
     											<li class="kar_22"><em></em>22Karat<span>20%</span></li>
     											<li class="kar_24"><em></em>24 Karat<span>18%</span></li>
     										</ul>
     									</div>
     								</div>
     							</div>
     					</div>
       			</div>
       		</div>
       </div>
     </div>
	</div>
</div>


@include('admin.main.footer');
