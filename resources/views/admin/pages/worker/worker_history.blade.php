@include('admin.main.header')

<div class="mrg_tp"></div>

<div class="dashboard_min">
    <div class="container-fluid">
        <div class="worker_list_sec">
            <div class="worker_list_top" style="cursor: pointer">
                <div class="worker_list_left">
                    <div class="worker_list_input" >
                        <a href="{{ route('customer_form') }}"><input type="submit" placeholder="Add Worker"
                                value="Add Customer" style="cursor: pointer"></a>
                        <em class="sh_img"><img src="{{ asset('assets/images/plus.png" alt=""></em>
                    </div>
                </div>
            </div>
            <div class="worker_list_panel">
                <div class="worker_list_tab_hed">
                    <div class="row">
                        {{-- <div class="col "><b>#</b></div> --}}
                        <div class="col "><b>Actions</b></div>
                        <div class="col "><b>WORKER </b></div>
                        {{-- <div class="col "><b>PHONE</b></div>
                        <div class="col "><b>ITEM</b></div>
                        <div class="col "><b>PAN NO</b></div>
                        <div class="col "><b>AADHAR </b></div>
                        <div class="col "><b>EMAIL</b></div> --}}
                        {{-- <div class="col "><b>BALANCE_AMOUNT</b></div> --}}
                        {{-- <div class="col "><b>GST NO</b></div> --}}
                        {{-- <div class="col "><b>ADDRESS</b></div>
                        <div class="col "><b>ORDER_ID</b></div>
                        <div class="col "><b>STATUS</b></div> --}}
                    </div>
                </div>
                @foreach ($history as $item)
                <div class="worker_list_tab_itm">
                    <div class="row">
                        <div class="col">
                            <span class="hide_big">Actions</span>
                            <div class="ac_di">
                                <ul>
                                    <li><a href="{{ route('view_filling_form',[$item->id]) }}"><img src="{{ asset('assets/images/action1.png" alt=""></a>
                                    {{-- </li>
                                    <li><a href="{{ route('edit_customer',[$item->id]) }}"><img src="{{ asset('assets/images/action2.png" alt=""></a></li>
                                    <li ><a href="{{ route('delete_customer',[$item->id]) }}"><img src="{{ asset('assets/images/action3.png" alt=""></a></li> --}}
                                </ul>
                            </div>
                        </div>
                        {{-- <div class="col">
                            <p class="user_nm ">{{ get_client_name($item->client_name)  }}<em><img src="{{asset('uploads/{{ $item->image }}"  alt=""></em></p>
                            <span class="">Actions</span>
                        </div> --}}

                         <div class="col">
                            <p class="user_nm">{{ get_client_name( $item->client_name)  }}<em><img src="{{asset('uploads/{{ $item->image }}"  alt=""></em></p>
                        </div>
                       {{-- <div class="col">
                            <p>{{ $item->item  }}</p>
                        </div>
                        <div class="col">
                            <p>{{ $item->pan_no  }} </p>
                        </div>
                        <div class="col">
                            <p>{{ $item->aadhar_no  }}</p>
                        </div>
                        <div class="col">
                            <p>{{ $item->email  }}</p>
                        </div>

                        <div class="col">
                            <p>{{ $item->address  }}</p>
                        </div>
                        <div class="col">
                            <p>{{ $item->order_id  }}<img src="{{url('public')}}/assets/images/id_icon.png" alt="" class="working_id"></p>
                        </div>
                        <div class="col">
                            <div class="status_cc d-inline">
                                <span>Completed</span>
                            </div>
                        </div> --}}
                    </div>
                </div>
                @endforeach
                {{-- <div class="phar_pagination">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1"><i class="fa fa-angle-left"></i>Prev</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item "><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">4</a></li>
                            <li class="page-item"><a class="page-link" href="#">5</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#" tabindex="-1">Next<i class="fa fa-angle-right"></i></a>
                            </li>
                        </ul>
                    </nav>
                </div> --}}
            </div>
        </div>
    </div>
</div>

@include('admin.main.footer')
