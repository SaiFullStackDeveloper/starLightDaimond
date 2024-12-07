@include('admin.main.header');
<style>
    .select2-container--default .select2-selection--single {
        height: 40px;
        background: #CAD7EA;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 40px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #659EEA;
        font-size: 18px;
        font-weight: 600;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 40px;
        width: 29px;
    }
    .select2-container--default .select2-selection--single {
        border: 1px solid #65a2ea;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow b {
        border-color: #65a0ea transparent transparent transparent;
        border-width: 10px 7px 0 7px;
        left: 40%;
        top: 44%;
    }
    .filter_btn_css {
        background: none;
        border: none;
        color: #98a9bc;
        font-size: 18px;
        font-weight: 500;
    }
    .select2-search--dropdown .select2-search__field {
        height: 37px;
    }

</style>
<div class="dashboard_min dashboard_pg mt-5">
	<div class="container-fluid">
        <div class="row">
            <div class="col-md-9 mb-3">
                <form action="{{url('dashboard')}}" method="GET">
                    <div class="row">
                        <div class="col-md-3">
                            <select name="customer_id" id="dashboard_customer_s2" class="form-control" onchange="">
                                <option value="">Select Customer</option>
                                    @foreach ($customet_list as $item)
                                        <option value="{{$item->id}}">{{$item->customer_name}}</option>
                                    @endforeach
                                </select> 
                        </div>
                        <div class="col-md-3">
                            <select name="worker_id" id="dashboard_worker_s2" class="form-control" onchange="">
                                <option value="">Select Worker</option>
                                    @foreach ($worker_list as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select> 
                        </div>
                        <div class="col-md-3">
                            <select name="manager_id" id="dashboard_worker_s3" class="form-control" onchange="">
                                <option value="">Select Manager</option>
                                    @foreach ($manager_list as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select> 
                        </div>
                        
                        <div class="col-md-1">
                            <button type="submit" class="btn btn_no_css filter_btn_css">Filter: <img class="filter_gif" src="{{url('public/filter.png')}}" alt=""></button>
                        </div>
                        <div class="col-md-1">
                            <a style="border:1px solid #c2c2c2;" href="{{url('dashboard')}}" class="btn btn_no_css filter_btn_css">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-3"></div>
                <div class="col-md-3">
                    <div class="total_order_box">
                        <div class="box_head mb-2">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="das_cart_title">
                                        <h3 class="box_title">Total Orders</h3>
                                        <select name="" id="order_chart_filter" class="form-control" onchange="order_chart()">
                                            <option value="yearly">Yearly</option>
                                            <option value="halfyearly">Half Yearly</option>
                                            <option value="quarterly">Quarterly</option>
                                        </select>
                                    </div>
                                 </div>
                            </div>
                        </div>
                        <div class="body">
                            <div class="box_graph">
                                <div id="order_graph"></div>
                            </div>
                            <div class="box_graph_details text-center">
                                <p>{{$total_order}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="total_order_box">
                        <div class="box_head mb-2">
                            <div class="row">
                                <div class="col-md-12">
                                <div class="das_cart_title">
                                    <h3 class="box_title">Total Complete & Pending Orders</h3>
                                    <select name="" id="order_complete_chart_filter" class="form-control" onchange="order_complete_chart_filter()">
                                        <option value="yearly">Yearly</option>
                                        <option value="halfyearly">Half Yearly</option>
                                        <option value="quarterly">Quarterly</option>
                                    </select>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="body">
                            <div class="box_graph">
                                <div id="order_complete_graph"></div>
                            </div>
                            <div class="box_graph_details text-center">
                                {{-- <p>{{$total_complete_order}}</p> --}}
                                <p>Complete : {{$total_complete_order}} | Pending : {{$total_pending_order}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-md-3">
                    <div class="total_order_box">
                        <div class="box_head mb-2">
                            <div class="row">
                                <div class="col-md-7"><h3 class="box_title">Total Pending Orders</h3> </div>
                                <div class="col-md-5">
                                    <select name="" id="order_pending_chart_filter" class="form-control" onchange="order_pending_chart_filter()">
                                        <option value="yearly">Yearly</option>
                                        <option value="halfyearly">Half Yearly</option>
                                        <option value="quarterly">Quarterly</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="body">
                            <div class="box_graph">
                                <div id="order_pending_graph"></div>
                            </div>
                            <div class="box_graph_details text-center">
                                <p>{{$total_pending_order}}</p>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div class="col-md-3">
                    <div class="total_worker">
                        <div class="row">
                            <div class="col-md-12">
                                <h3 class="title_individual total_worker_text">Total Worker</h3>
                            </div>
                            <div class="col-md-12">
                                <h3 class="title_individual total_worker_val">{{$total_worker}}</h3>
                            </div>
                        </div>
                        <img class="total_worker_bg" src="{{url('public/dash/Worker.svg')}}" alt="">
                    </div>
                    <div class="total_worker">
                        <div class="row">
                            <div class="col-md-12">
                                <h3 class="title_individual total_worker_text total_gram_color">Total Gram Pending</h3>
                            </div>
                            <div class="col-md-12">
                                <h3 class="title_individual total_worker_val total_gram_color">{{$total_gram_pending}}</h3>
                            </div>
                        </div>
                        <img class="total_worker_bg" src="{{url('public/dash/Grams.svg')}}" alt="">
                    </div>
                </div>

            <div class="col-md-12 mt-3">
                <div class="total_order_box">
                    <div class="box_head mb-2">
                        <div class="row">
                            <div class="col-md-7"> 
                                <div class="dashboard_filter_heading">
                                    <ul>
                                        <li class="dashboard_main_chaty_li active" id="li_overview" onclick="set_dashboard_big_chart('overview')">Overview</li>
                                        <li class="dashboard_main_chaty_li " id="li_bygrams" onclick="set_dashboard_big_chart('bygrams')">Grams</li>
                                        <li class="dashboard_main_chaty_li" id="li_products" onclick="set_dashboard_big_chart('products')">Products</li>
                                        <li class="dashboard_main_chaty_li" id="li_orders" onclick="set_dashboard_big_chart('orders')">Orders</li>
                                        <li class="dashboard_main_chaty_li" id="li_product_wise"  onclick="set_dashboard_big_chart('product_wise')">Product Wise</li>
                                        <li class="dashboard_main_chaty_li" id="li_customer_wise"  onclick="set_dashboard_big_chart('customer_wise')">Customer</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-5">
                                {{-- <select name="" id="order_pending_chart_filter" class="form-control" onchange="order_pending_chart_filter()">
                                    <option value="yearly">Yearly</option>
                                    <option value="halfyearly">Half Yearly</option>
                                    <option value="quarterly">Quarterly</option>
                                </select> --}}
                            </div>
                        </div>
                    </div>
                    <div class="body">
                       <div class="row">    
                        <div class="col-md-8">
                            <div id="below_big_graph"></div>
                            <div id="graph_product_wise"></div>
                            <div id="graph_customer_wise"></div>
                            <input type="hidden" id="graph_product_wise_in">
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="total_worker das_down_box">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h3 class="title_individual total_worker_text total_order_red_color">Total Orders</h3>
                                            </div>
                                            <div class="col-md-12">
                                                <h3 class="title_individual total_worker_val total_order_red_color">{{$total_order}}</h3>
                                            </div>
                                        </div>
                                        <img class="total_worker_bg" src="{{url('public/dash/download (42) 1.svg')}}" alt="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="total_worker das_down_box">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h3 class="title_individual total_worker_text ">Products</h3>
                                            </div>
                                            <div class="col-md-12">
                                                <h3 class="title_individual total_worker_val ">{{$total_order_product}}</h3>
                                            </div>
                                        </div>
                                        <img class="total_worker_bg" src="{{url('public/dash/download (43) 1.svg')}}" alt="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="total_worker das_down_box">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h3 class="title_individual total_worker_text total_customer_color">Customers</h3>
                                            </div>
                                            <div class="col-md-12">
                                                <h3 class="title_individual total_worker_val total_customer_color">{{$customet_total}}</h3>
                                            </div>
                                        </div>
                                        <img class="total_worker_bg" src="{{url('public/Layer 2.png')}}" alt="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="total_worker das_down_box">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h3 class="title_individual total_worker_text total_gram_color">Total Approx Grams</h3>
                                            </div>
                                            <div class="col-md-12">
                                                <h3 class="title_individual total_worker_val total_gram_color">{{$total_gram_approx}}</h3>
                                            </div>
                                        </div>
                                        <img class="total_worker_bg" src="{{url('public/dash/download (45) 1.svg')}}" alt="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="total_worker das_down_box">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h3 class="title_individual total_worker_text total_gram_color">Total Grams Used</h3>
                                            </div>
                                            <div class="col-md-12">
                                                <h3 class="title_individual total_worker_val total_gram_color">{{$total_gram_pending}}</h3>
                                            </div>
                                        </div>
                                        <img class="total_worker_bg" src="{{url('public/dash/download (45) 1.svg')}}" alt="">
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
</div>
@include('admin.main.footer');
