@include('admin.main.header')
@php
                                                    $allq = DB::table('orders')->where('status',1);
                                                @endphp
<div class="mrg_tp"></div>

<div class="dashboard_min">
    <div class="container-fluid mt-2">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Client wise</h2>
                    </div>
                    <div class="card-body">
                        <div class="row">   
                        <div class="col-md-12 table_con">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered text-center">
                                      <thead>
                                      <tr class="tab_head" style="border-bottom:1px solid #000; background: green; color: #fff">
                                            <th colspan="2">Consolidted Details</td>
                                            <th>{{$allq->sum('making_charges')}}</td>
                                            <th>{{$allq->sum('addional_charges_total')}}</td>
                                            <th>{{$allq->sum('gold_charges_total')}}</td>
                                            <th>{{$allq->sum('diamond_charges_total')}}</td>
                                            <th>{{$allq->sum('pay_amount')}}</td>
                                            <th>{{cus_bal_total()}}</td>
                                            <th>{{count_all_get_customer_gold_painding()}}</td>
                                    </tr>
                                        <tr class="tab_head">
                                            <th>Sl. no</th>
                                            <th>Client name</th>
                                            <th>Making Charges</th>
                                            <th>Addional Charges</th>
                                            <th>Gold Charges</th>
                                            <th>Diamond Charges</th>
                                            <th>Payment</th>
                                            <th>Balance</th>
                                            <th>Pure Metal Pending</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        @php $jddsds = 1; @endphp
                                        @foreach ($clist as $i)
                                        @php
                                            $customer_bal_amount = $i->balance_amount;
                                            $is_order_avail = DB::table('orders')->where('client_name',$i->id)->count();
                                            $count_paymment = count_customer_payment($i->id);
                                            $qq = DB::table('orders')->where('client_name',$i->id)->where('is_order',1)->where('status',1)->get();
                                            $totalmakingcharges = DB::table('orders')->where('client_name',$i->id)->where('status',1)->sum('making_charges');
                                            $addional_charges_total = DB::table('orders')->where('client_name',$i->id)->where('status',1)->sum('addional_charges_total');
                                            $gold_charges_total = DB::table('orders')->where('client_name',$i->id)->where('status',1)->sum('gold_charges_total');
                                            $diamond_charges_total = DB::table('orders')->where('client_name',$i->id)->where('status',1)->sum('diamond_charges_total');
                                            $count_bal = $customer_bal_amount-$count_paymment;
                                            $bal = 0;
                                            $bal = $bal+($totalmakingcharges+$addional_charges_total+$gold_charges_total+$diamond_charges_total)-$count_paymment;
                                        @endphp
                                      <tr>
                                        <td>{{$jddsds}}</td>
                                        <td><a href="{{url('customer_orders/'.$i->id)}}">{{$i->nickname}}</a></td>
                                         <td>{{$totalmakingcharges}}</td>
                                         <td>{{$addional_charges_total}}</td>
                                         <td>{{$gold_charges_total}}</td>
                                         <td>{{$diamond_charges_total}}</td>
                                         <td>{{$count_paymment}}</td>
                                         <td>{{$bal}}</td>
                                         <td>{{get_customer_gold_painding($i->id)}}</td>
                                      </tr>
                                      @php
        $jddsds++;
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
