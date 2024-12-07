@php
    $customer = $data['cus_data'];
    $cus_id = $customer->id;
    $cus_initial_amount = $customer->initial_amount;
    $cus_name = "";
    $cus_bal = 0;
    if($customer->balance_amount){
        $cus_bal = $customer->balance_amount;
    }
    if($customer->customer_name){
        $cus_name = $customer->customer_name;
    }
    $cus_name = "";
    if($customer->customer_name){
        $cus_name = $customer->customer_name;
    }
    $cus_email = "";
    if($customer->email){
        $cus_email = $customer->email;
    }
    $cus_img = "";
    if($customer->customer_image){
        $cus_img = $customer->customer_image;
    }
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .bordered-table {
            border-collapse: collapse;
            width: 100%;
        }
        .bordered-table th, .bordered-table td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        .bordered-table th {
            background-color: #ddd;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th scope="col1">Order ID</th>
                <th scope="col1">Unique ID</th>
                <th scope="col2">Date</th>
                <th scope="col3">Item</th>                                      
                <th scope="col5">Karat</th>
                
                <th scope="col6">Gold G/W</th>                                        
                <td class="br_none">Weight</td>
                <td>Pieces</td>
                <td class="br_none">Weight</td>
                <td>Pieces</td>
                <td class="br_none">Weight</td>
                <td>Pieces</td>
                <td class="br_none">Weight</td>
                <td>Pieces</td>
                <td class="br_none">Weight</td>
                <td>Pieces</td>
                <th scope="col12">Enamel Weight</th>
                <th scope="col13">Is Diamond</th>
                <th scope="col14">Gold N/W</th>
                <th scope="col15">Pure Metal </th>                                        
                <th scope="col16">Pure Metal Pending</th>
                <th scope="col17">Making Charges</th>                                        
                <th scope="col18">Addional Charges</th>
                <th scope="col19">Gold Charges</th>
                <th scope="col20">Diamond Charges</th>
            </tr>
        </thead>
        <tbody>
             @php
              $pure_metal_pen = 0;
              $total_gold_nw = 0;
              $cbal = $cus_bal;
          @endphp
          @foreach ($data['orders_data'] as $i)
          @php
            $get_product = DB::table('order_details')->where('order_id',$i->id)->get();
            $get_product_img = DB::table('order_image')->where('orderid',$i->id)->get();
            $get_caret_det = DB::table('karrat')->where('manin_id',$i->filling_carret)->first();
            if ($i->is_order == 1) {
                $fp_recive =  $i->fp_reciv;
            } else {
                $fp_recive = count_gem_recive_polish('fp_reciv',$i->id,4);
            }
            $count_total_gc = count_gem_recive_polish('gc',$i->id,3);
            $count_total_ga = count_gem_recive_polish('ga',$i->id,3);
            $count_total_gew = count_gem_recive_polish('gew',$i->id,3);
            $count_total_gd = count_gem_recive_polish('gd',$i->id,3);
            // color stone 
            if(!$count_total_gc){
                $cs_w = 0;
            }else{
                $cs_w = $count_total_gc;
            }
            // AD 
            if(!$count_total_ga){
                $ad_w = 0;
            }else{
                $ad_w = $count_total_ga;
            }
            // Enamel WT
            if(!$count_total_gew){
                $gew_w = 0;
            }else{
                $gew_w = $count_total_gew;
            }
            // diamond
            if(!$count_total_gd || $i->is_diamond != 1){
                $diamond_w = 0;
            }else{
                $diamond_w = $count_total_gd;
            }
            $gold_nw = $fp_recive-$cs_w-$ad_w-$gew_w-$diamond_w;
            $pure_metal = 0;
            if ($i->id_cash == 1) {
                    $pure_metal = $gold_nw;
            }else{
                if($get_caret_det){
                    $pure_metal = $gold_nw*$get_caret_det->per;
                }
            }
            
            $gold_nw = number_format($gold_nw, 3);
            $pure_metal = number_format($pure_metal, 3);
            $pure_metal_pen = number_format($pure_metal_pen, 3);
            $total_gold_nw = $gold_nw+$total_gold_nw;
            if ($i->is_order == 1) {
                if($i->is_return == 1){
                  $pure_metal_pen = $pure_metal_pen-$pure_metal;
                }else{
                  $pure_metal_pen = $pure_metal_pen+$pure_metal;
                }
            } else {
                $pure_metal_pen = -$pure_metal-$pure_metal_pen;
            }
          @endphp
          @if($i->is_order != 1)
            <tr>
                <td scope="col1" class="wsp">{{$i->id}}</td>
                <td scope="col1" class="wsp">{{$i->unique_id}}</td>
                <td scope="col2" class="wsp">{{$i->fp_date}}</td>
                <td scope="col3">
                    @foreach($get_product as $pi)
                    {{$pi->product_name}},
                    @endforeach
                </td>
                
                <td scope="col5">
                {{get_karat_name($i->filling_carret)}}
                </td>
                <td scope="col6">{{$fp_recive}}</td>
                <td scope="col7">{{count_gem_recive_polish('kd',$i->id,3)}}
                <input type="hidden" value="{{count_gem_recive_polish('kd',$i->id,3)}}" id="kd{{$i->id}}">
                </td>
                <td scope="col7a">{{count_gem_recive_polish('pd',$i->id,3)}}</td>
                <td scope="col8"></td>
                <td scope="col8a"></td>
                <td scope="col9"></td>
                <td scope="col9a"></td>
                <td scope="col10">{{$count_total_gc}}
                <input type="hidden" value="{{$count_total_gc}}" id="gc{{$i->id}}">
                </td>
                <td scope="col10a">{{count_gem_recive_polish('pc',$i->id,3)}}</td>
                <td scope="col11">{{$count_total_ga}}
                    <input type="hidden" value="{{$count_total_ga}}" id="ga{{$i->id}}">
                </td>
                <td scope="col11a">{{count_gem_recive_polish('pa',$i->id,3)}}</td>
                <td scope="col12">{{$count_total_gew}}
                    <input type="hidden" value="{{$count_total_gew}}" id="gew{{$i->id}}">
                </td>
                <td scope="col13">
                    
                </td>
                <td scope="col14">
                    <input type="hidden" id="gold_net_w{{$i->id}}" value="{{$gold_nw}}">
                    {{$gold_nw}}
                </td>
                <td scope="col15">
                    {{$pure_metal}}
                    <input type="hidden" id="pure_metal{{$i->id}}" value="{{$pure_metal}}">
                </td>
                <td scope="col16">
                    {{$pure_metal_pen}}
                </td>
                <td scope="col17">
                    {{$i->making_charges}}
                    <input type="hidden" name="" value="{{$i->mc_charges_val}}" id="mc_charges_val{{$i->id}}">
                </td>
                <td scopr="col18">
                    {{$i->addional_charges_total}}
                    <input type="hidden" name="" value="{{$i->addional_charges}}" id="addional_charges{{$i->id}}">
                    <input type="hidden" name="" value="{{$i->addional_charges_val}}" id="addional_charges_val{{$i->id}}">
                    <input type="hidden" name="" value="{{$i->addional_charges_total}}" id="addional_charges_total{{$i->id}}">
                    
                </td>
                <td scopr="col19">
                    {{$i->gold_charges_total}}
                    <input type="hidden" name="" value="{{$i->gold_charges}}" id="gold_charges{{$i->id}}">
                    <input type="hidden" name="" value="{{$i->gold_charges_val}}" id="gold_charges_val{{$i->id}}">
                    <input type="hidden" name="" value="{{$i->gold_charges_total}}" id="gold_charges_total{{$i->id}}">
                </td>
                <td scopr="col20">
                    {{$i->diamond_charges_total}}
                    <input type="hidden" name="" value="{{$i->diamond_charges}}" id="diamond_charges{{$i->id}}">
                    <input type="hidden" name="" value="{{$i->diamond_charges_val}}" id="diamond_charges_val{{$i->id}}">
                    <input type="hidden" name="" value="{{$i->diamond_charges_total}}" id="diamond_charges_total{{$i->id}}">
                </td>
                <td scopr="col21"></td>
                <td scopr="col22"></td>
                
                <td>
                   
                </td>
            </tr>
          @endif
          @endforeach
          <tr class="head_un">
            <td>
            <input type="hidden" name="" id="curent_pending_metal" value="{{$pure_metal_pen}}">
            </td>
            <td></td>
            <td></td>
            <td>
                {{-- {{$total_fp_reciv}} --}}
            </td>
            <td>{{$data['total_kd']}}</td>
            <td>{{$data['total_pd']}}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>{{$data['total_gc']}}</td>
            <td>{{$data['total_pc']}}</td>
            <td>{{$data['total_ga']}}</td>
            <td>{{$data['total_pa']}}</td>
            <td>{{$data['total_gew']}}</td>
            <td></td>
            <td>
                {{-- {{$total_gold_nw}} --}}
            </td>
            <td></td>
            <td>{{$pure_metal_pen}}</td>
            <td>{{$data['total_making_charges']}}</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>
            </td>
          </tr>
        </tbody>
    </table>
    
    
</body>
</html>