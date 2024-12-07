@include('admin.main.header')

<div class="mrg_tp"></div>

<div class="dashboard_min">
    <div class="container-fluid mt-2">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Order history</h2>
                        <form action="{{url()->current()}}">
                          <div class="row mt-2">
                              
                              <div class="col-2">
                                  <input type="text" placeholder="Select date" class="form-control datepicker" name="fdate" value="{{old('fdate')}}">
                              </div>
                              <div class="col-2">
                                  <input type="text" placeholder="Select date" class="form-control datepicker" name="tdate" value="{{old('tdate')}}">
                              </div>
                              <div class="col-2">
                                    @php
                                        $order_status = DB::table('order_status')->get();
                                    @endphp
                                    <select name="order_status" class="form-control" id="">
                                        <option disabled selected value>Select Status</option>
                                        @foreach ($order_status as $p)
                                            <option value="{{$p->id}}">{{$p->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-2">
                                    @php
                                        $karrat = DB::table('karrat')->get();
                                    @endphp
                                    <select name="karrat" class="form-control" id="">
                                        <option disabled selected value>Select Karet</option>
                                        @foreach ($karrat as $k)
                                            <option @if(isset($karet) && !empty($karet) && $karet== $k->name) Selected @endif value="{{$k->name}}">{{$k->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-2">
                                    <select name="type" class="form-control">
                                        <option disabled selected value>Select Type</option>
                                        <option @if(isset($type) && !empty($type) && $type== 1) Selected @endif value="1">Filling</option>
                                        <option @if(isset($type) && !empty($type) && $type== 2) Selected @endif value="2">Mounting</option>
                                        <option @if(isset($type) && !empty($type) && $type== 3) Selected @endif value="3">Settings</option>
                                        <option @if(isset($type) && !empty($type) && $type== 4) Selected @endif value="4">Final Polish</option>
                                    </select>
                                </div>
                              <div class="col-1">
                                  <button type="submit" class="btn btn-sm btn-success w-100 h-100">Filter</button>
                              </div>
                              <div class="col-1">
                                  <a href="{{url()->current()}}" class="btn btn-sm btn-dark w-100 h-100 d-flex align-items-center justify-content-center">Reset</a>
                              </div>
                              <div class="col-4 text-right">
                              <h1>Worker Name : <span class="badge badge-success">{{$worker_name}}</span></h1>
                              @if(isset($profitOrLoss) && $profitOrLoss < 0)
                              <h2>Loss : <span class="badge badge-danger">{{number_format($profitOrLoss,1)}}%</span></h1>
                              @else
                              <h2>Profit : <span class="badge badge-info">{{number_format($profitOrLoss,1)}}%</span></h1>
                              @endif
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
                                            <th>Sl. No</th>
                                            <th>Issue Date</th>
                                            <th>Issue Gram</th>
                                            <th>Added Gram</th>
                                            <th>Karet</th>
                                            <th>Received Gram</th>
                                            <th>Return Gram</th>
                                            <th>Balance</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        @php
                                            $slno = 1;
                                        @endphp
                                        @foreach ($table_loat as $item)
                                        @if(isset($karet) && !empty($karet))
                                            @if(get_orderIDKarat_name($item->order_id) != $karet)
                                                @continue
                                            @endif
                                        @endif
                                        <tr>
                                         <td>{{$slno}}</td>
                                         <td>{{$item->date}}</td>
                                         <td>{{$item->gram_issue}}</td>
                                         <td>{{$item->fi_add}}</td>
                                         <td>{{get_orderIDKarat_name($item->order_id)}}</td>
                                         <td>{{$item->fi_reciv}}</td>
                                         <td>{{$item->fi_return}}</td>
                                         <td>{{$item->fi_bal}}</td>
                                         <td>
                                            @if($item->refer_type == 1)
                                            <h2><span class="badge badge-success">{{get_department_name($item->refer_type)}}</span></h2>
                                            @elseif($item->refer_type == 2)
                                            <h2><span class="badge badge-warning">{{get_department_name($item->refer_type)}}</span></h2>
                                            @elseif($item->refer_type == 3)
                                            <h2><span class="badge badge-dark">{{get_department_name($item->refer_type)}}</span></h2>
                                            @elseif($item->refer_type == 4)
                                            <h2><span class="badge badge-light">{{get_department_name($item->refer_type)}}</span></h2>
                                            @else

                                            @endif
                                        </td>
                                         <td>
                                            @if($item->psts == 1)
                                            <h2><span class="badge badge-success">{{get_order_depart_status($item->psts)}}</span></h2>
                                            @else
                                            <h2><span class="badge badge-danger">{{get_order_depart_status($item->psts)}}</span></h2>
                                            @endif
                                        </td>
                                        </tr>
                                        @php
                                            $slno++;
                                        @endphp
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
@include('admin.main.footer')
