<?php
function get_product_item($id = null){
  $get_orders_item = DB::table('order_details')->where('order_id',$id)->get();
  if($get_orders_item){
    $item = '';
    foreach($get_orders_item as $i){
      $item .= $i->product_name.',';
    }
    return $item;
  }else{
    return '';
  }
}
function get_client_name($id){
  $data = DB::table('customers')->where('id',$id)->first();
  if ($data) {
    return $data->customer_name;
  } else {
    return "";
  }
  
}
function get_client_nickname($id){
  $data = DB::table('customers')->where('id',$id)->first();
  if ($data) {
    return $data->nickname;
  } else {
    return "";
  }
  
}
function mpc($manager_id,$pageid,$type){
 if(Session::get('role') == 1)   {
     return true;
 }else{
    $check = DB::table('manager_per')->where('manager_id',$manager_id)->where('page_id',$pageid)->first();
    if($check){
        if($type == 'view'){
            if($check->view_per == 1){
                return true;        
            }else{
                return false;        
            }
        }
        if($type == 'add'){
            if($check->add_per == 1){
                return true;        
            }else{
                return false;        
            }
        }
    }else{
        return false;
    } 
 }
}
function check_per($manager_id,$pageid,$type){
    if($pageid == 4 && Session::get('role') == 1){
        return true;
    }
    $check = DB::table('manager_per')->where('manager_id',$manager_id)->where('page_id',$pageid)->first();
    if($check){
        if($type == 'view'){
            if($check->view_per == 1){
                return true;        
            }else{
                return false;        
            }
        }
        if($type == 'add'){
            if($check->add_per == 1){
                return true;        
            }else{
                return false;        
            }
        }
        if($type == 'update'){
            if($check->update_per == 1){
                return true;        
            }else{
                return false;        
            }
        }
    }else{
        return false;
    }
}
function get_order_list($type){
  $role = session()->get('role');
  $userid = session()->get('id');
  if($role == 2){
      $get_order_tableid = DB::table('forward_log')->where(['worker_id'=>$userid,'refer_type'=>$type])->pluck('order_id')->toArray();
      $order = DB::table('orders')->where(['is_order'=>0])->whereIn('id', $get_order_tableid)->get();
  }else{
      $order = DB::table('orders')->where(['is_order'=>0])->get();
  }
  return $order;
}
function get_repair_list($type){
  $role = session()->get('role');
  $userid = session()->get('id');
  if($role == 2){
      $get_order_tableid = DB::table('repair_for_log')->where(['worker_id'=>$userid,'refer_type'=>$type])->pluck('order_id')->toArray();
      $order = DB::table('repair')->where(['is_order'=>0])->whereIn('id', $get_order_tableid)->get();
  }else{
      $order = DB::table('repair')->where(['is_order'=>0])->get();
  }
  return $order;
}
function get_repair_forward_log($order_id,$type)
{
  $role = session()->get('role');
  $userid = session()->get('id');
  if($role == 2){
    $q = DB::table('repair_forward')->where('order_id', $order_id)->where('worker_id', $userid)->where('refer_type',$type)->get();
  }else{
    $q = DB::table('repair_forward')->where('order_id', $order_id)->where('refer_type',$type)->get();
  }
  return $q;
}
function get_forward_log($order_id,$type)
{
  $role = session()->get('role');
  $userid = session()->get('id');
  if($role == 2){
    $q = DB::table('order_forward')->where('order_id', $order_id)->where('worker_id', $userid)->where('refer_type',$type)->get();
  }else{
    $q = DB::table('order_forward')->where('order_id', $order_id)->where('refer_type',$type)->get();
  }
  return $q;
}
function get_forward_history($order_id,$type)
{
  $d = "";
  if(login_role() == 3){
    $q = DB::table('order_forward')->where('manager_id',login_id())->where('order_id', $order_id)->where('refer_type',$type)->orderBy('psts','DESC')->get();
  }else{
    $q = DB::table('order_forward')->where('order_id', $order_id)->where('refer_type',$type)->orderBy('psts','DESC')->get();   
  }
  $q = DB::table('order_forward')->where('order_id', $order_id)->where('refer_type',$type)->orderBy('psts','DESC')->get();
  if($q){
    $d .= '<div class="row mt-2">';
    $d .= '<div class="col-12">';
      $d .= '<div class="table-responsive">';
        $d .= '<table class="table table-striped table-bordered table-rounded forward_history">';
          $d .= '<thead>';
            $d .= '<tr>';
              $d .= '<th>Date</th>';
              $d .= '<th>Worker</th>';
              $d .= '<th>Gram issued</th>';
              $d .= '<th>Comment</th>';
              $d .= '<th>Status</th>';
            $d .= '</tr>';
          $d .= '</thead>';
          $d .= '<tbody>';
        foreach($q as $i){
          if($i->psts == 1){
            $sts = "Complete";
          }else{
            $sts = "Pending";
          }
          $d .= '<tr>';
          $d .= '<td>' . $i->date . '</td>';
          $d .= '<td>' . get_worker_name($i->worker_id) . '</td>';
          $d .= '<td>' . $i->gram_issue . '</td>';
          $d .= '<td>' . $i->comments . '</td>';
          $d .= '<td>' . $sts . '</td>';
          $d .= '</tr>';
        }
        $d .= '</tbody>';
        $d .= '</table>';
      $d .= '</div>';
    $d .= '</div>';
  $d .= '</div>';
  }
  // dd($d);
  return  $d;
}
function get_repair_forward_history($order_id,$type)
{
  $d = "";
  $q = DB::table('repair_forward')->where('order_id', $order_id)->where('refer_type',$type)->get();
  if($q){
    $d .= '<div class="row mt-2">';
    $d .= '<div class="col-12">';
      $d .= '<div class="table-responsive">';
        $d .= '<table class="table table-striped table-bordered table-rounded forward_history">';
          $d .= '<thead>';
            $d .= '<tr>';
              $d .= '<th>Date</th>';
              $d .= '<th>Worker</th>';
              $d .= '<th>Gram issued</th>';
            $d .= '</tr>';
          $d .= '</thead>';
          $d .= '<tbody>';
        foreach($q as $i){
          $d .= '<tr>';
          $d .= '<td>' . $i->date . '</td>';
          $d .= '<td>' . get_worker_name($i->worker_id) . '</td>';
          $d .= '<td>' . $i->gram_issue . '</td>';
          $d .= '</tr>';
        }
        $d .= '</tbody>';
        $d .= '</table>';
      $d .= '</div>';
    $d .= '</div>';
  $d .= '</div>';
  }
  // dd($d);
  return  $d;
}
function get_worker_name($id){
  $name = "";
  if($id){
    $q = DB::table('worker')->where('id', $id)->first();
    if($q){
      if($q->name){
        $name = $q->name;
      }
    }
  }
  return $name;
}
function count_gem_recive_polish($col_name,$order_id,$type)
{
  $q = 0;
  $query = DB::table('order_forward')->where('order_id', $order_id)->where('refer_type',$type)->sum($col_name);
  if($query > 0){
    $q = $query;
    $q = number_format($q, 3, '.', '');
  }
  return $q;
}
function get_department_name($type){
  $r = "";
  if($type == 1){
    $r = "Filling";
  }elseif($type == 2){
    $r = "Mounting";
  }elseif($type == 3){
    $r = "Settings";
  }elseif($type == 4){
    $r = "Final Polish";
  }
  return $r;
}
function get_karet_name($orderid)
{
  $r = "";
  $c = DB::table('orders')->where('id', $orderid)->first();
  if($c){
    if ($c->filling_carret) {
      $qq = DB::table('karrat')->where('manin_id', $c->filling_carret)->first();
      if($qq){
        $r = $qq->name;
      }
    }
  }
  return $r;
} 
function get_order_qid($orderid)
{
  $r = "";
  $c = DB::table('orders')->where('id', $orderid)->first();
  if($c){
    if ($c->unique_id) {
        $r = $c->unique_id;

    }
  }
  return $r;
}
function get_worker($id)
{
  $r = "";
  $c = DB::table('worker')->where('id', $id)->first();
  if($c){
      $r = $c;
  }
  return $r;
}
function get_order_priority($pid = NULL)
{
  $v = '';
  if($pid){
    $q = DB::table('priority')->where('id',$pid)->first();
    if($q){
        $v = '<div class="status_cc status_pending  d-inline"><span>'.$q->name.'</span></div>';
    }
  }
  return $v;
}
function get_order_depart_status($id){
  $v = '';
  if($id == 1){
    $v = 'Complete';
  }elseif($id == 2){
    $v = 'Pending';
  }
  return $v;
}
function get_order_status($orderid = NULL)
{
  $v = '';
  if($orderid){
  $q = DB::table('orders')->where('id',$orderid)->first();
  if($q){
    if($q->status == 2){
      $qf_check = DB::table('order_forward')->where('order_id',$orderid)->count();
      if($qf_check > 0){
        $v = '<div class="status_cc status_processing d-inline"><span>Processing</span></div>';
      }else{
        $v = '<div class="status_cc status_pending d-inline"><span>Open</span></div>';
      }
    }else{
      $v = '<div class="status_cc d-inline"><span>Completed</span></div>';
    }
  }
}
  return $v;
}
function get_repair_status($orderid = NULL)
{
  $v = '';
  if($orderid){
  $q = DB::table('repair')->where('id',$orderid)->first();
  if($q){
    if($q->status == 2){
      $qf_check = DB::table('repair_forward')->where('order_id',$orderid)->count();
      if($qf_check > 0){
        $v = '<div class="status_cc status_processing d-inline"><span>Processing</span></div>';
      }else{
        $v = '<div class="status_cc status_pending d-inline"><span>Pending</span></div>';
      }
    }else{
      $v = '<div class="status_cc d-inline"><span>Completed</span></div>';
    }
  }
}
  return $v;
}
function get_sum_forward_table($cusid,$colname)
{
  $v = 0;
  $where = array();
  $where['client_name'] = $cusid;
  $where['status'] = 1;
  $where['is_order'] = 0;
  $get_orderid = DB::table('orders')->where( $where)->pluck('id')->toArray();
  $total = DB::table('order_forward')->where('refer_type',3)->whereIn('order_id', $get_orderid)->whereNotNull('update_date')->sum($colname);
  if($total){
    $v = number_format($total, 3, '.', '');
  }
  return $v;
}
function get_total_forward_table($colname)
{
  $v = 0;
  $where = array();
  $where['refer_type'] = 3;
  $total = DB::table('order_forward')->where($where)->whereNotNull('update_date')->sum($colname);
  if($total){
    $v = number_format($total, 3, '.', '');
  }
  return $v;
}
function count_customer_payment($cusid)
{
  $v = 0;
  $where['client_name'] = $cusid;
  $where['is_order'] = 1;
  $where['status'] = 1;
  $total = DB::table('orders')->where($where)->sum('pay_amount');
  if($total){
    $v = number_format($total, 3, '.', '');
  }
  return $v;
}
function get_sum_cus_payment($calname)
{
  $v = 0;
  $where['status'] = 1;
  $total = DB::table('orders')->where($where)->sum($calname);
  if($total){
    $v = number_format($total, 3, '.', '');
  }
  return $v;
}
function get_total_issued($id = NULL)
{
  $v = 0;
  if($id){
    $total = DB::table('order_forward')->where('order_id',$id)->sum('gram_issue');
    if($total){
      $v = number_format($total, 3, '.', '');
    }
  }
  return $v;
}
function get_total_rec($id = NULL)
{
  $v = 0;
  if($id){
    $total = DB::table('order_forward')->where('order_id',$id)->sum('fi_reciv','mo_reciv','se_reciv','fp_reciv');
    if($total){
      $v = number_format($total, 3, '.', '');
    }
  }
  return $v;
}
function get_total_item($id = NULL)
{
  $v = 0;
  if($id){
    $total = DB::table('order_details')->where('order_id',$id)->count();
    if($total){
      $v = $total;
    }
  }
  return $v;
}
function get_sum_cus_balance()
{
  $v = 0;
  $total = DB::table('customers')->sum('balance_amount');
  $total_pay = DB::table('orders')->sum('pay_amount');
  $v = $total-$total_pay;
  $v = number_format($total, 3, '.', '');
  return $v;
}
function cus_bal_total()
{
  $re = 0;
  $tt = DB::table('customers')->get();
  foreach($tt as $i){
  $is_order_avail = DB::table('orders')->where('client_name',$i->id)->count();
  $count_paymment = count_customer_payment($i->id);
  $qq = DB::table('orders')->where('client_name',$i->id)->where('status',1);
  $totalmakingcharges = $qq->sum('making_charges');
  $addional_charges_total = $qq->sum('addional_charges_total');
  $gold_charges_total = $qq->sum('gold_charges_total');
  $diamond_charges_total = $qq->sum('diamond_charges_total');
  //   $count_bal = $customer_bal_amount-$count_paymment;
  // bal count

  $bal = 0;
  $bal = $bal+($totalmakingcharges+$addional_charges_total+$gold_charges_total+$diamond_charges_total)-$count_paymment;
  $re = $re+$bal;
  }
  return $re;
}
function count_all_get_customer_gold_painding()
{
  $ts = 0;
  $tt = DB::table('customers')->get();
  foreach($tt as $i){
    $ts = $ts+get_customer_gold_painding($i->id);
  }
  return $ts;
  
}
function get_customer_gold_painding($cusid){
  $pure_metal_pen = 0;
  $total_gold_nw = 0;
  // $cbal = $cus_bal;
  $order_q = DB::table('orders')->where('client_name',$cusid)->where('status',1)->get();
  foreach($order_q as $i){
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
    
    $gold_nw = number_format($gold_nw, 3, '.', '');
    $pure_metal = number_format($pure_metal, 3, '.', '');
    $pure_metal_pen = number_format($pure_metal_pen, 3, '.', '');
    $total_gold_nw = $gold_nw+$total_gold_nw;
    if ($i->is_order == 1) {
        $pure_metal_pen = $pure_metal_pen+$pure_metal;
    } else {
        $pure_metal_pen = -$pure_metal-$pure_metal_pen;
    }
  }
  return $pure_metal_pen;
  
}
function count_total_pending_for_admin(){
    $q = DB::table('customers')->get();
    $t  = 0;
    foreach($q as $i){
      $t = $t+get_customer_gold_painding($i->id);
    }
    $t = number_format($t, 3, '.', '');
    return $t;
}
function count_production_for_admin(){
  // count_gem_recive_polish('fp_reciv',$i->id,4);
  $q = DB::table('customers')->get();
  $t  = 0;
  foreach($q as $i){
    $t = $t+count_production($i->id);
  }
  $t = number_format($t, 3, '.', '');
  return $t;
}
function count_production($cuid){
  // count_gem_recive_polish('fp_reciv',$i->id,4);
  $q = DB::table('orders')->where('client_name',$cuid)->where('is_order',0)->where('status',1)->get();
  $t = 0;
  foreach($q as $i){
    $t = $t+count_gem_recive_polish('fp_reciv',$i->id,4);
  }
  $t = number_format($t, 3, '.', '');
  return $t;
}
function count_repair_is($id = NULL,$name  = NULL)
{
  $r = 0;
  if($id && $name && $id > 0){
      $t = DB::table('repair_forward')->where('order_id',$id)->sum($name);
      if($t && $t > 0){
        $r = number_format($t,3, '.', '');
      }
  }
  return $r;
}
function count_repair_charge($id = NULL)
{
  $r = 0;
  if($id && $id > 0){
      $t = DB::table('repair')->where('id',$id)->sum('addi_chrg');
      $q = DB::table('repair')->where('id',$id)->sum('gold_chrg');
      if($t && $t > 0){
        $r = $r+$t;
      }
      if($q && $q > 0){
        $r = $r+$q;
      }
  }
  return number_format($r,2, '.', '');
}
function get_min_date($d)
{
  $date_string = $d;
  $date = DateTime::createFromFormat('m/d/Y', $date_string);
  $formatted_date = $date->format('Ymd');
  return $formatted_date;
}
function count_total_order()
{
  return DB::table('orders')->where('is_order',0)->count();  
}
function count_total_product()
{
  return DB::table('order_details')->sum('piece');  
}
function count_total_gram_recive()
{
  return DB::table('order_forward')->sum('fi_reciv','se_reciv','mo_reciv','fp_reciv');  
}
function count_gram_recive($id)
{
  return DB::table('order_forward')->where('order_id',$id)->sum('fi_reciv','se_reciv','mo_reciv','fp_reciv');  
}
function count_gram_recive_final_polish($id)
{
  return DB::table('order_forward')->where('order_id',$id)->sum('fp_reciv');  
}
function count_total_customer()
{
  return DB::table('customers')->count();  
}
function ins_notification($work_id)
{
  $data = array();
  $data['forwardid'] = $work_id;
  $data['date'] = date('d-m-Y');
  DB::table('notification')->insert($data);
}
function check_work_status($id = null,$type = null)
{
  $r = 0;  
  if($type == 2){
  $v = 1;
  }else if($type == 3){
    $v = 2;
  }else if($type == 4){
    $v = 3;
  }else{
    $v = 4;
  }
  if($id){
    $qa = DB::table('order_forward')->where('order_id',$id)->where('refer_type',$v)->count();
    $qb = DB::table('order_forward')->where('order_id',$id)->where('psts',1)->where('refer_type',$v)->count();
    // if($qa == $qb && $qa > 0){
    //   $r = 1;
    // }
    if($qa > 0){
      $r = 1;
    }
  }
  return $r;
}
function check_repair_status($id = null,$type = null)
{
  $r = 0;  
  if($type == 2){
  $v = 1;
  }else if($type == 3){
    $v = 1;
  }else if($type == 4){
    $v = 3;
  }else{
    $v = 4;
  }
  if($id){
    $qa = DB::table('repair_forward')->where('order_id',$id)->where('refer_type',$v)->count();
    $qb = DB::table('repair_forward')->where('order_id',$id)->where('psts',1)->where('refer_type',$v)->count();
    if($qa == $qb && $qa > 0){
      $r = 1;
    }
  }
  return $r;
}
function check_forward($id = null,$type = null)
{
  $r = 0;  
  if($id){
    $qa = DB::table('order_forward')->where('order_id',$id)->where('refer_type',$type)->count();
    if($qa == 0){
      $r = 1;
    }
  }
  return $r;
}
function check_repair_forward($id = null,$type = null)
{
  $r = 0;  
  if($id){
    $qa = DB::table('repair_forward')->where('order_id',$id)->where('refer_type',$type)->count();
    if($qa == 0){
      $r = 1;
    }
  }
  return $r;
}
function check_repair_forward_status($id = null,$type = null)
{
  $r = 0;  
  if($id){
    $qa = DB::table('repair_forward')->where('order_id',$id)->where('refer_type',$type)->count();
    if($qa == 0){
      $r = 1;
    }
  }
  return $r;
}
function get_slno_coustomer()
{
  $p = DB::table('customers')->select('id')->orderBy('id','DESC')->limit(1)->first();

  $p = $p?$p->id+1:0+1;
  return $p;
}
function get_slno_orderform()
{
  $p = DB::table('orders')->select('id')->where('is_order', 0)->orderBy('id','DESC')->limit(1)->first();
  $p = $p?$p->id+1:0+1;
  return $p;
}
function get_karat_list()
{
  $p = DB::table('karrat')->OrderBy('name','DESC')->get();
  return $p;
}
function get_stcolor_list()
{
  $p = DB::table('metalcolour')->OrderBy('name','DESC')->get();
  return $p;
}
function get_priority_list()
{
  $p = DB::table('priority')->OrderBy('id','DESC')->get();
  return $p;
}
function get_karat_list_html()
{
  $p = DB::table('karrat')->OrderBy('name','DESC')->get();
  $t = "<select name='karat[]' required><option value=''>Select</option>";
  foreach ($p as $item){
    $t .="<option value='$item->manin_id'>$item->name</option>";
  }
  $t .= "</select>";
  return html_entity_decode($t);
}
function get_stcolor_list_html()
{
  $p = DB::table('metalcolour')->OrderBy('name','DESC')->get();
  $t = "<span>Metal colour</span><select name='mcolor[]' required><option value=''>Select</option>";
  foreach ($p as $item){
    $t .="<option value='$item->id'>$item->name</option>";
  }
  $t .= "</select>";
  return html_entity_decode($t);
}
function get_karat_name($var = null)
{
  $r = '';
  if($var){
    $q= DB::table('karrat')->where('manin_id', $var)->first();
    if($q){
      $r = $q->name;
    }
  }
  return $r;
}
function get_orderIDKarat_name($var = null)
{
  $r = '';
  if($var){
    $order = DB::table('orders')->where('id',$var)->first();
    $q= DB::table('karrat')->where('manin_id', $order->filling_carret)->first();
    if($q){
      $r = $q->name;
    }
  }
  return $r;
}
function total_dust_ofworker($id = NULL) {
  $total = 0;
  if($id){
    $sum_a = DB::table('order_forward')->where('worker_id',$id)->whereNotNull('update_date')->sum('fi_bal');
    $sum_b = DB::table('order_forward')->where('worker_id',$id)->whereNotNull('update_date')->sum('se_dust');
    $sum_c = DB::table('order_forward')->where('worker_id',$id)->whereNotNull('update_date')->sum('fp_dust');
    $total_return = DB::table('dust_return_history')->where('worker_id',$id)->sum('return_dust');
    $final = $sum_a+$sum_b+$sum_c-$total_return;
    $total = $final;
  }
  return $total;
}
function get_role_name($role){
  $r = '';
  if($role == 2){
    $r = 'Worker';
  }elseif ($role == 3) {
    $r = 'Management';
  }
  return $r;
}
function need_access(){
//   if(need_access()){
//     return back()->with('error','Admin access required for participant changes');
// }
  $r = false;
  $role = Session::get('role');
  if($role){
    if($role == 3){
      $id = Session::get('id');
      $q = DB::table('worker')->where('id',$id)->first();
      if($q){
        if($q->permissions == 1){
          $r = false;
        }else{
          $r = true;
        }
      }else{
        $r = true;
      }
    }
  }
  return $r;
}
function login_role() {
  $role = Session::get('role');
  return $role;
}
function login_id() {
  $id = Session::get('id');
  return $id;
}
?>
