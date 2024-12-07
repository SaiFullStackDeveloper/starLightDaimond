@include('admin.main.header');
<style>
  .tile_a span {
  font-weight: 800;
}
.woker_name img {
  border-radius: 50%;
  height: 30px;
  width: 30px;
}
.woker_name span {
  font-size: 15px;
  color: #979797;
}
.btn_ex_css{
  background: rgba(75, 159, 71, 0.1);
  border-radius: 8px;
  color:#4B9F47 ;
}
.down_sts_text span{
  font-family: 'Gotham';
  font-style: normal;
  font-weight: 500;
  font-size: 14px;
  line-height: 150%;
  /* identical to box height, or 21px */


  /* Gray/Gray-400 */

  color: #A0AEC0;
}
i.fas.fa-paper-plane {
    color: #73d9c6;
}
td.br-red {
  background: #ff00004a;
}
.mc_var_edit_btn img{
  cursor: pointer;
}
span.top_con_inline {
  display: inline-block;
  float: left;
  margin-right: 6px;
}
.details_con {
  line-height: 16px;
}
span.top_con_inline .cos_imag {
  height: 40px;
  width: 40px;
  border-radius: 15%;
}
.tab_head th {
  border: 0px solid #2984FF !important;
  border-right: 1px solid #2984FF !important;
  background: rgba(41, 132, 255, 0.13);
  white-space: nowrap;
  padding: 7px 10px 0px 10px;
}

.tab_head th:last-child {
  border: 0px solid #2984FF !important;
}
tr.head_un td {
  padding: 0px 15px;
}
tbody td {
  border: 0px solid #2984FF !important;
  border-right: 1px solid #2984FF !important;
}
tbody td:last-child {
  border: 0px solid #2984FF !important;
}
.das_right_inr {
  padding: 0px;
  overflow: hidden;
}
.head_un{
  border-bottom: 1px solid #2984FF !important;
  background: rgba(41, 132, 255, 0.13) !important;
}
.head_un td{
  background: rgba(41, 132, 255, 0.13) !important;
}
.wsp{
  white-space: nowrap;
}
.br_none{
  border-right: none !important;
}
img.pro_image {
  height: 50px;
  width: 50px;
  margin: 5px;
}
.table_con tr {
    border-bottom: 1px solid #d1d2ff;
}
</style>
<style>
  .select2-container--default .select2-selection--single {
      height: 40px;
  }
  .select2-container--default .select2-selection--single .select2-selection__rendered {
      line-height: 40px;
  }
  .select2-container--default .select2-selection--single .select2-selection__rendered {

      font-size: 18px;
  }
  .select2-container--default .select2-selection--single .select2-selection__arrow {
      height: 40px;
      width: 29px;
  }
  .select2-container--default .select2-selection--single {

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
<div class="mrg_tp"></div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Order history</h2>
                    <a href="{{url('orders')}}" class="btn btn-sm btn-success mx-2" style="float: right;">All Orders History</a>
                    <form action="{{url()->current()}}">
                      <div class="row mt-2">
                        <div class="col-2">
                          <select name="customer_id" id="dashboard_customer_s2" class="form-control" onchange="">
                            <option value="">Select Customer</option>
                                @foreach ($customer as $item)
                                    <option value="{{$item->id}}">{{$item->nickname}}</option>
                                @endforeach
                            </select> 
                        </div>
                        <div class="col-2">
                            <select name="date_range" id="date_range" class="form-control">
                                <option disabled selected value>Select Date Range</option>
                                <option value="month">This month</option>
                                <option value="last_month">Last month</option>
                                <option value="quarterly">Quarterly</option>
                                <option value="half_yearly">Half-yearly</option>
                                <option value="yearly">Yearly</option>
                                <option value="custom">Custom</option>
                            </select> 
                        </div>
                          <div class="col-2">
                            @php
                                $pyority = get_priority_list();
                            @endphp
                            <select name="pyority" class="form-control" id="">
                              <option value="">Select Priority</option>
                              @foreach ($pyority as $p)
                                  <option value="{{$p->id}}">{{$p->name}}</option>
                              @endforeach
                            </select>
                        </div>
                        <div class="col-2">
                          @php
                              $order_status = DB::table('order_status')->get();
                          @endphp
                          <select name="order_status" class="form-control" id="">
                            <option value="">Select Status</option>
                            @foreach ($order_status as $p)
                                <option value="{{$p->type}}">{{$p->name}}</option>
                            @endforeach
                          </select>
                      </div>
                          <div class="col-1">
                              <button type="submit" class="btn btn-sm btn-success">Filter</button>
                          </div>
                          <div class="col-1">
                              <a href="{{url()->current()}}" class="btn btn-sm btn-success">Reset</a>
                          </div>
                          <div class="col-2">
                              <input type="text" placeholder="Select date" id="strtDate" class="form-control datepicker" name="fdate" value="{{old('fdate')}}">
                          </div>
                          <div class="col-2">
                              <input type="text" placeholder="Select date" id="endDate" class="form-control datepicker" name="tdate" value="{{old('tdate')}}">
                          </div>
                      </div>
                  </form>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 table_con">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered text-center">
                                  <thead>
                                    <tr class="tab_head">
                                      <th>Unique Id</th>
                                      <th>order Date</th>
                                      <th>Filling</th>
                                      <th>Mounting</th>
                                      <th>Setting</th>
                                      <th>Final Polish</th>
                                       
                                      <th>Priority</th>
                                      <th>Delivery Date</th>
                                      {{-- <th>Status</th> --}}
                                      <th>Approx Grams</th>
                                      <th>Finsihed Grams</th>
                                      <th>Preview</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @foreach ($order as $item)

                                    <tr>
                                      <td>
                                        <p>Client Name : {{ get_client_nickname($item->client_name)  }}</p>
                                        {{ $item->unique_id  }} <span><a href="{{ url('order_item_details/'.$item->id) }}"><i class="fas fa-eye"></i></a></span>
                                      </td>
                                      <td>
                                        {{ $item->created_at  }}</span>
                                      </td>
                                      <td class="incon_css">
                                          
                                            <span class="filling_btn cr_poin" onclick="forward_order(1,{{$item->is_multiple}},{{$item->id}})">
                                              <img src="{{ asset('img/diamond.png')}}" class="forbtn_di" alt="">
                                            </span>
                                          <!-- @if (check_forward($item->id,2)) -->
                                          <!-- @endif -->
                                          @if(check_forward($item->id,1))
                                            <div><span class="text-danger">Pending</span></div>
                                          @else
                                            <span class="br-right"></span> <span><a  href="{{ url('filling_form/'.$item->id) }}"><i class="fas fa-eye vieweyeicon"></i></a></span>
                                          @endif
                                          
                                      </td>
                                      <td  class="incon_css">
                                        @if(check_work_status($item->id,2) == 1)
                                        <span class="filling_btn cr_poin" onclick="forward_order(2,{{$item->is_multiple}},{{$item->id}})"><img src="{{ asset('img/diamond.png')}}" class="forbtn_di" alt=""></span><span class="br-right"></span>
                                          <!-- @if (check_forward($item->id,3)) -->
                                          <!-- @endif -->
                                         @if(check_forward($item->id,2))
                                          <div><span class="text-danger">Pending</span></div>
                                         @else
                                          <span><a  href="{{ url('Mounting_Form/'.$item->id) }}"><i class="fas fa-eye vieweyeicon"></i></a></span>
                                         @endif
                                         @endif
                                    </td>
                                      <td  class="incon_css">
                                        @if(check_work_status($item->id,3) == 1)
                                        <span class="filling_btn cr_poin" onclick="forward_order(3,{{$item->is_multiple}},{{$item->id}})"><img src="{{ asset('img/diamond.png')}}" class="forbtn_di" alt=""></span><span class="br-right"></span>
                                            <!-- @if (check_forward($item->id,4)) -->
                                            <!-- @endif -->
                                        @if(check_forward($item->id,3))
                                        <div><span class="text-danger">Pending</span></div>
                                       @else
                                       <span><a  href="{{ url('Setting_Form/'.$item->id) }}"><i class="fas fa-eye vieweyeicon"></i></a></span>
                                       @endif
                                        
                                        @endif
                                    </td>
                                      <td  class="incon_css">
                                        @if(check_work_status($item->id,4) == 1)
                                        <span class="filling_btn cr_poin" onclick="forward_order(4,{{$item->is_multiple}},{{$item->id}})"><img src="{{ asset('img/diamond.png')}}" class="forbtn_di" alt=""></span><span class="br-right"></span>
                                        @if(check_forward($item->id,4))
                                          <div><span class="text-danger">Pending</span></div>
                                         @else
                                         <span><a  href="{{ url('final_Form/'.$item->id) }}"><i class="fas fa-eye vieweyeicon"></i></a></span>
                                         @endif
                                        @endif
                                    </td>
                                    
                                    <td>
                                          @php
                                              echo get_order_priority($item->priority);
                                          @endphp
                                    </td>
                                    <td>
                                      {{$item->delivery_date}} <br>
                                      @if($item->delivery_mindate > $item->order_mindate)
                                        <span class="text-danger">Days Left =  <span class="text-bold">{{$item->delivery_mindate-date('Ymd')}}</span> </span>
                                      @endif
                                    </td>
                                      <td>{{$item->appx_gram}}</td>
                                    <td>{{count_gram_recive($item->id)}}</td>
                                    <td>
                                        <a href='{{ url('view_order_form', [$item->id]) }}' class='btn btn-success table-action-btn'><i class="fas fa-eye vieweyeicon"></i></a>
                                        <a onclick="return confirm('Are you sure you want to edit this order?')" href='{{ url('edit_order_form', [$item->id]) }}' class='btn btn-dark table-action-btn'><i class="fa-solid fa-pen-to-square vieweyeicon"></i></a>
                                        <a onclick="return confirm('Are you sure you want to delete this order?')" href='{{ url('delete_order_form', [$item->id]) }}' class='btn btn-danger table-action-btn'><i class="fa-solid fa-trash vieweyeicon"></i></a>
                                        <div class="mt-1">
                                        @php
                                            echo get_order_status($item->id);
                                        @endphp
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

 <!-- Modal -->
 <div class="modal fade" id="forward_order_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"><span id="forward_modal_name"></span></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            
          <form action="" method="post" id="forward_order_form" onsubmit="btnloder()">
            @csrf             
              <div class="form-group">
                  <input type="hidden" id="order_id" name="order_id">
                  <input type="hidden" id="refer_type" name="refer_type">
                <label for="numberInput">Worker</label>
                <select name="worker_id" id="worker_id" class="form-control" required>
                    @foreach ($worker as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                </select>
              </div>
              <div class="form-group" id="gram_issue_box">
                <label for="numberInput">Gram Issue</label>
                <input type="text"  class="form-control" value="" name="gram_issue" id="gram_issue" placeholder="Enter amount" required>
              </div>
                <div class="form-group" id="no_box">
                <label for="numberInput">No</label>
                <input type="text"  class="form-control" value="" name="no" id="no" placeholder="Enter No" required>
              </div>
              <div class="form-group">
                <label for="numberInput">Comments</label>
                <input type="text"  class="form-control" value="" name="comments" id="comments" placeholder="">
              </div>              
              <button type="submit" class="btn btn-success loaderbtn">Save</button>
        </form>
        <div id="refer_table_his"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

@include('admin.main.footer');
