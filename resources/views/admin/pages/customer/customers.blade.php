@include('admin.main.header')

<div class="mrg_tp"></div>

<div class="dashboard_min">
    <div class="container-fluid">
        <div class="worker_list_sec">
            
            <div class="card">
                <div class="card-header">
                    <div class="worker_list_top" style="cursor: pointer">
                        <div class="worker_list_left">
                            
                                @if(mpc(Session::get('id'),2,'add'))
                            <div class="worker_list_input" >
                                <a href="{{ route('customer_form') }}"><input type="submit" placeholder="Add Worker"
                                        value="Add Customer" style="cursor: pointer"></a>
                                        <em class="sh_img"><img src="{{ asset('assets/images/plus.png') }}" alt=""></em>
                                    </div>
                                     @endif
                                    
                        </div>
                        <div style="float:right">
                            <a class="btn btn-sm btn-success" href="{{url('customerwise_orders')}}">View Clientwise</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 table_con">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered text-center">
                                  <thead>
                                    <tr class="tab_head">
                                        <th>Customer Id</th>
                                        <th>Assigned To</th>
                                        <th>NAME</th>
                                        <th>PHOTO</th>
                                        <th>PHONE</th>
                                        <th>Orders</th>
                                        <th>Actions</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @foreach ($customer as $item)
                                    <tr>
                                        <td>
                                            <p>{{ $item->id  }}</p>
                                        </td>
                                        <td>
                                          <span class="badge badge-success badge-lg">{{get_worker_name($item->manager_id)}}</span>
                                      </td>
                                        <td>
                                            <p class="user_nm ">{{ $item->customer_name  }}</p>
                                        </td>
                                        <td>
                                            <em><img height="50px" width="50px" src="{{asset('uploads/{{ $item->') }}customer_image }}"  alt=""></em>
                                        </td>
                                        <td>
                                            <p>{{ $item->phone  }}</p>
                                            <div class="mt-2 mb-2">
                                                @php
                                                    $q = DB::table('customers_contact')->where('customer_id',$item->id);
                                                    $count = $q->count();
                                                    $qq = array();
                                                    if($count > 0){
                                                        $qq = $q->get();
                                                    }
                                                    @endphp
                                                    @if($count > 0)
                                                    <div class="row phone_number_view_div">
                                                        <div class="col-md-6">
                                                            <span class="titl">Name</span>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <span class="titl">Phone Number</span>
                                                        </div>
                                                        
                                                    </div>
                                                    @foreach ($qq as $key => $value)
                                                        <div class="row phone_number_view_div">
                                                            <div class="col-md-6">
                                                                {{$value->contact_name}}
                                                            </div>
                                                            <div class="col-md-6">
                                                                {{$value->phone_number}}<a title="Delete" href="{{url('customers_phone_delete/'.$value->id)}}"><img class="ml-2" src="{{ asset('user.png')}}" alt=""></a>
                                                            </div>
                                                          
                                                        </div>
                                                    @endforeach
                                                    @endif
                                            </div>
                                            <div class="add_cus_ph_div">
                                                <button  onclick="add_customer_id({{$item->id}})" type="button" class="btn btn-waning add_phone_btn" data-toggle="modal" data-target="#add_customer_phone">
                                                    <img class="phone_add_img" src="{{ asset('phone-book.png')}}" alt=""> Add Phone
                                                  </button>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{url('order_history?customer_id='.$item->id)}}" class="btn btn-success btn-sm"> View Orders</a>
                                        </td>
                                        <td>
                                            <div class="ac_di">
                                                <ul>
                                                    {{-- <li><a href=""><img src="{{ asset('assets/images/action1.png') }}" alt=""></a>
                                                    </li> --}}
                                                    @if(mpc(Session::get('id'),2,'add'))
                                                    <li><a href="{{ route('edit_customer',[$item->id]) }}"><img src="{{ asset('assets/images/action2.png') }}" alt=""></a></li>
                                                    <li ><a href="{{ route('delete_customer',[$item->id]) }}"><img src="{{ asset('assets/images/action3.png') }}" alt=""></a></li>
                                                    @endif
                                                    <li>
                                                        <span style="cursor: pointer;" onclick="fetch_customer_details({{$item->id}})" data-toggle="modal" data-target="#user_details_modal" class="badge badge-light  badge-lg"><img src="{{ asset('assets/images/user-avatar') }}.png" alt=""></span>

                                                        <input type="hidden" id="customer_name_{{$item->id}}" value="{{$item->customer_name}}">
                                                        <input type="hidden" id="phone_{{$item->id}}" value="{{$item->phone}}">
                                                        <input type="hidden" id="nickname_{{$item->id}}" value="{{$item->nickname}}">
                                                        <input type="hidden" id="pan_no_{{$item->id}}" value="{{$item->pan_no}}">
                                                        <input type="hidden" id="aadhar_no_{{$item->id}}" value="{{$item->aadhar_no}}">
                                                        <input type="hidden" id="email_id_{{$item->id}}" value="{{$item->email}}">
                                                        <input type="hidden" id="gst_no_{{$item->id}}" value="{{$item->gst_no}}">
                                                        <input type="hidden" id="address_{{$item->id}}" value="{{$item->address}}">
                                                        <input type="hidden" id="dob_{{$item->id}}" value="{{$item->dob}}">
                                                        <input type="hidden" id="joiningdate_{{$item->id}}" value="{{$item->joiningdate}}">
                                                        <input type="hidden" id="worker_iamge_{{$item->id}}" value="{{ asset('uploads/'.$item->customer_image) }}">
                                                      </li>  
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                  </tbody>
                                </table>
                              </div>
                              
                        </div>
                    </div>
            
            </div>
            </div>
    </div>
</div>

{{-- modal area --}}
<!-- Modal -->


<div class="modal fade" id="user_details_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Worker Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                 <div class="col-md-12 text-center mb-5">
                  <img class="user_image_on_modal" id="worker_iamge_part" src="" alt="">                
                  </div> 
                  <div class="col-md-12">
                    <div class="user_data_box">
                      <ul class="mb-2">
                        <li class="ttle">Customer name : </li>  
                        <li class="details"><span id="customer_name"></span></li>  
                      </ul>
                      <ul class="mb-2">
                        <li class="ttle">Phone : </li>  
                        <li class="details"><span id="phone_span"></span></li>  
                      </ul>
                      <ul class="mb-2">
                        <li class="ttle">Nickname : </li>  
                        <li class="details"><span id="nickname_span"></span></li>  
                      </ul>
                      <ul class="mb-2">
                        <li class="ttle">Pan No  : </li>  
                        <li class="details"><span id="pan_no_span"></span></li>  
                      </ul>
                      <ul class="mb-2">
                        <li class="ttle">Aadhar No  : </li>  
                        <li class="details"><span id="aadhar_no_span"></span></li>  
                      </ul>
                      <ul class="mb-2">
                        <li class="ttle">Email  : </li>  
                        <li class="details"><span id="email_id_span"></span></li>  
                      </ul>
                      <ul class="mb-2">
                        <li class="ttle">GST  : </li>  
                        <li class="details"><span id="gst_no_span"></span></li>  
                      </ul>
                      <ul class="mb-2">
                        <li class="ttle">Address  : </li>  
                        <li class="details"><span id="address_span"></span></li>  
                      </ul>
                      <ul class="mb-2">
                        <li class="ttle">DOB  : </li>  
                        <li class="details"><span id="dob_span"></span></li>  
                      </ul>
                      <ul class="mb-2">
                        <li class="ttle">Joiningdate  : </li>  
                        <li class="details"><span id="joiningdate_span"></span></li>  
                      </ul>

                     
                    </div>
                  </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
  </div>

<div class="modal fade" id="add_customer_phone" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form action="{{url('add_morephone_number')}}" method="post">
        @csrf
        <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Add Phone Number</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <input type="hidden" name="customer_id_input" id="customer_id_input">
            <label for="">Contact Name</label>
          <input type="text" required name="contact_name" class="form-control mb-2" placeholder="Enter contact name">
          <label for="">Phone Number</label>
          <input type="number" required name="phone_number" class="form-control mb-2" placeholder="Enter phone Number">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </form>
    </div>
  </div>

@include('admin.main.footer')
