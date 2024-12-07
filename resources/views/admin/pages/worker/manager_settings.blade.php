@include('admin.main.header')

<div class="mrg_tp"></div>

<div class="dashboard_min">
    <div class="container-fluid">
        <div class="worker_list_sec">
            <div class="worker_list_top">
                <div class="worker_list_left">
                    @if(mpc(Session::get('id'),3,'add'))
                      @if($worker_type == 2)
                      <div class="worker_list_input mx-2">
                        <a href="{{ route('worker_form') }}?worker_type=Worker"><input type="submit" placeholder="Add Worker"
                                value="Add Worker"></a>
                        <em class="sh_img"><img src="{{ asset('assets/images/plus.png') }}" alt=""></em>
                    </div>
                    @endif
                    @if (Session::get('role') != 3 && $worker_type == 3)
                    <div class="worker_list_input mx-2">
                      <a href="{{ route('worker_form') }}?worker_type=Manager"><input type="submit" placeholder="Add Worker"
                              value="Add Management"></a>
                      <em class="sh_img"><img src="{{ asset('assets/images/plus.png') }}" alt=""></em>
                  </div>  
                  @endif
                  @endif 
                </div>
            </div>
            
        </div>
    </div>
    <div class="container-fluid mt-2">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">All Worker</h3>
                        <div class="row">
                            <div class='col-md-12'>
                                 <form action="{{url()->current()}}">
                      <div class="row mt-2">
                          <div class="col-2">
                              <input required type="text" placeholder="Enter name" class="form-control" name="name" value="{{old('name')}}">
                          </div>
                          <div class="col-1">
                              <button type="submit" class="btn  btn-success">Filter</button>
                          </div>
                          <div class="col-1">
                              <a href="{{url()->current()}}" class="btn  btn-success">Reset</a>
                          </div>
                      </div>
                  </form>
                            </div>
                            <div class='col-md-12'>
                                @if($worker_type == 2)
                                @if(mpc(Session::get('id'),5,'view'))
                                <a class="btn btn-success btn-sm float-right mx-1" href="{{url('workers_history_all/4')}}">All Final Polish</a>
                                <a class="btn btn-success btn-sm float-right mx-1" href="{{url('workers_history_all/3')}}">All Setting</a>
                                <a class="btn btn-success btn-sm float-right mx-1" href="{{url('workers_history_all/2')}}">All Mounting</a>
                                <a class="btn btn-success btn-sm float-right mx-1" href="{{url('workers_history_all/1')}}">All Filling</a>
                                @endif
                                @endif
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
                                            <th>User Name</th>
                                            <th>Worker Assigned</th>
                                            <th>Working ID</th>
                                            <th>Filling</th>
                                            <th>Setting</th>
                                            <th>Final Polish</th>
                                            <th>Total Dust</th>
                                            <th>Address</th>
                                            <th>Phone</th>
                                            <th>Alt. Phone</th>
                                            {{-- <th>Aadhaar</th> --}}
                                            <th>Orders</th>
                                            <th>Forward</th>
                                            <th>Created</th>
                                            <th>Updated</th>
                                            <th>Actions</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        @foreach ($worker as $item)
                                        <tr>
                                            <td>
                                              <p class="user_nm " style="float: right;">
                                                {{ $item->name  }}
                                                <em>
                                                  <img src="{{asset('uploads/{{ $item->worker_iamge }}') }}" class="ml-2" alt="">
                                                </em>
                                              </p>
                                              @if($item->role)
                                              <div class="mt-4">
                                                <span class="badge @if($item->role == 3) badge-danger @else badge-success @endif badge-lg">{{get_role_name($item->role)}}</span>
                                              </div>
                                              @endif
                                            </td>
                                            <td>
                                              @if ($item->manager_id)
                                              <span class="badge badge-success badge-lg">{{get_worker_name($item->manager_id)}}</span>
                                              @endif
                                            </td>
                                            <td>
                                              @if($item->role == 2)
                                              
                                              <p> <a href="{{url('workers_order/'.$item->id)}}">{{ $item->working_id  }}</a>     <img src="{{url('public')}}/assets/images/id_icon.png" alt="" class="working_id"></p>
                                              @endif
                                            </td>
                                            <td class="incon_css">
                                              @if($item->role == 2)
                                                @if($item->filling == 1)
                                                <span><a target="_blank" href="{{ url('workers_history/'.$item->id.'/1') }}"><i class="fas fa-eye"></i></a></span>
                                                @endif                                                
                                                @endif
                                            </td>
                                            
                                            <td  class="incon_css">
                                              @if($item->role == 2)
                                                @if($item->setting == 1)
                                                <span><a target="_blank" href="{{ url('workers_history/'.$item->id.'/3') }}"><i class="fas fa-eye"></i></a></span>
                                                @endif                                                
                                                @endif
                                          </td>
                                            <td  class="incon_css">
                                              @if($item->role == 2)
                                                @if($item->finalpolish == 1)
                                                <span><a target="_blank" href="{{ url('workers_history/'.$item->id.'/4') }}"><i class="fas fa-eye"></i></a></span>
                                                @endif                                                
                                                @endif
                                          </td>
<td>
  @if($item->role == 2)

    @php
        $toatl_dust =     total_dust_ofworker($item->id);
    @endphp
    <p class="green_bage">{{$toatl_dust}}</p>
    <input type="hidden" value="{{$toatl_dust}}"  id="total_dust_{{$item->id}}">
    @if($toatl_dust > 0)
<button type="button" class="btn btn-success button_css_style" data-toggle="modal" data-target="#dust_return_modal" onclick="set_ids_in_modal({{$item->id}},{{$toatl_dust}})">Return Dust</button>
<a href="{{url('view_history?worker_id='.$item->id)}}" class="btn btn-dark button_css_style">View History</a>
@endif
@endif
</td>
          <td><p>{{ $item->place  }}</p></td>
          <td><p>{{ $item->phone  }}</p></td>
          <td><p>{{ $item->alt_number  }}</p></td>
          {{-- <td> <p>{{ $item->adhar  }}</p></td> --}}
          <td>
              @if($item->role == 2)
              @if(mpc(Session::get('id'),5,'view'))
              <a href="{{url('show_workers_orders/'.$item->id)}}" class="btn btn-success"> View Orders</a>
              @endif
              @endif
          </td>
          <td>
              @if($item->role == 2)
              @if(mpc(Session::get('id'),3,'add'))
              <button  type="button" onclick='document.getElementById("worker_forward_id").value = "{{$item->id}}"' data-toggle="modal" data-target="#worker_forward_modal" class="btn btn-success btn-sm">Forward</button>
              @endif
              @endif
          </td>
          <td>{{ $item->created_date  }}</td>
          <td>{{ $item->updateed_date  }}</td>
          <td>
            <div class="ac_di">
                <ul>
                    @if(mpc(Session::get('id'),3,'add'))
                    @if($item->role == 3)     
                    <li><a title='permission' href="{{ url('edit_worker/'.$item->id) }}?worker_type=Manager&permission=1"><img src="{{ asset('assets/images/userlock.png') }}" alt=""></a></li>
                    <li><a href="{{ url('edit_worker/'.$item->id) }}?worker_type=Manager"><img src="{{ asset('assets/images/action2.png') }}" alt=""></a></li>
                    @else
                    <li><a href="{{ url('edit_worker/'.$item->id) }}?worker_type=Worker"><img src="{{ asset('assets/images/action2.png') }}" alt=""></a></li>
                    @endif
                    <li ><a href="{{ route('delete_worker',[$item->id]) }}"><img src="{{ asset('assets/images/action3.png') }}" alt=""></a></li>
                    @endif
                    <li>
                      <span style="cursor: pointer;" onclick="fetch_user_details({{$item->id}})" data-toggle="modal" data-target="#user_details_modal" class="badge badge-light  badge-lg"><img src="{{ asset('assets/images/user-avatar.png') }}" alt=""></span>

                      <input type="hidden" id="name_{{$item->id}}" value="{{$item->name}}">
                      <input type="hidden" id="phone_{{$item->id}}" value="{{$item->phone}}">
                      <input type="hidden" id="place_{{$item->id}}" value="{{$item->place}}">
                      <input type="hidden" id="adhar_{{$item->id}}" value="{{$item->adhar}}">
                      <input type="hidden" id="working_id_{{$item->id}}" value="{{$item->working_id}}">
                      <input type="hidden" id="email_{{$item->id}}" value="{{$item->email}}">
                      <input type="hidden" id="password_{{$item->id}}" value="{{$item->password}}">
                      <input type="hidden" id="role_{{$item->id}}" value="{{get_role_name($item->role)}}">
                      <input type="hidden" id="worker_iamge_{{$item->id}}" value="{{ asset('uploads/'.$item->worker_iamge) }}">
                      <input type="hidden" id="alt_number_{{$item->id}}" value="{{$item->alt_number}}">
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
    </div>
</div>
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
                      <li class="ttle">User Name : </li>  
                      <li class="details"><span id="name_span"></span></li>  
                    </ul>
                    <ul class="mb-2">
                      <li class="ttle">User Phone : </li>  
                      <li class="details"><span id="phone_span"></span></li>  
                    </ul>
                    <ul class="mb-2">
                      <li class="ttle">Alternative Phone  : </li>  
                      <li class="details"><span id="alt_phone_span"></span></li>  
                    </ul>
                    <ul class="mb-2">
                      <li class="ttle">Place  : </li>  
                      <li class="details"><span id="place_span"></span></li>  
                    </ul>
                    <ul class="mb-2">
                      <li class="ttle">Adhar  : </li>  
                      <li class="details"><span id="adhar_span"></span></li>  
                    </ul>
                    <ul class="mb-2">
                      <li class="ttle">Email  : </li>  
                      <li class="details"><span id="email_span"></span></li>  
                    </ul>

                    {{-- <ul class="mb-2">
                      <li class="ttle">password  : </li>  
                      <li class="details">Test Name</li>  
                    </ul> --}}
                    <ul class="mb-2">
                      <li class="ttle">Role  : </li>  
                      <li class="details"><span class="badge badge-danger badge-lg"><span id="role_span"></span></span></li>  
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
<div class="modal fade" id="dust_return_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form action="{{url('dust_return_form')}}" method="post">
        @csrf
        <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Dust Return</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <input type="hidden" name="customer_id_input" id="customer_id_input">
            <label for="">Available Dust</label>
          <input type="number" readonly  name="available_dust" id="available_dust" class="form-control mb-2" >
          <label for="">Return Dust</label>
          <input type="number" required name="return_dust" id="return_dust" class="form-control mb-2" step="0.01">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </form>
    </div>
  </div>
  <div class="modal fade" id="worker_forward_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Worker forward to manager</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    
                    <form action="{{url('worker_forward_form')}}" method='post'>
                        @csrf
                        <input type="hidden" id="worker_forward_id" name="worker_id">
                         <label for="exampleSelect">Select Manager</label>
                            <select class="text-uppercase form-control mb-3" id="exampleSelect" required name="managet_id">
                                @foreach ($worker_forward as $item){
                                    <option value='{{$item->id}}'>{{$item->name}}</option>
                                
                                @endforeach
                            </select>
                            <button class='btn btn-succcess' type='submit'>Submit</button>
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@include('admin.main.footer')
