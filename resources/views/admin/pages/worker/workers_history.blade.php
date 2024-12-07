@php
$c_name = "";
$c_pp = asset('uploads/1677326235images.jpg');
$cus_data = get_worker($workerid);
if ($cus_data) {
  $c_name = $cus_data->name;
  $c_pp =  asset('uploads/'.$cus_data->worker_iamge);
}
@endphp
@include('admin.main.header')
<style>
    .woker_name img {
    height: 50px;
    width: 50px;
    border-radius: 50%;
}
</style>
<div class="mrg_tp"></div>
<style>
  
</style>
<div class="dashboard_min">
    <div class="container-fluid">
        <div class="dashboard_panel">
        <div class="">
            <div class="row mb-3">
                <div class="col-md-6"></div>
                <div class="col-md-6">
                  @if ($cus_data)
                      
                  
                    <div class="top_right" style="float: right;">
                        <div class="tile_a">
                            <span>Working By :</span>
                        </div>
                        <div class="woker_name">
                            <span>{{$c_name}} <img src="{{$c_pp}}" alt=""> </span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="das_right_inr">
                <div class="das_frm_panel p-3">
                    <div class="row">
                        <div class="col-md-12 mx-auto">
                            <div class="table_con">
                                <h2 class="card-title">
                                    @if ($ref_type == 1)
                                        Filling History
                                    @endif
                                    @if ($ref_type == 2)
                                        Mounting History
                                    @endif  
                                    @if ($ref_type == 3)
                                    Setting History
                                    @endif  
                                    @if ($ref_type == 4)
                                    Final polish History    
                                    @endif    

                                    <form action="{{url()->current()}}">
                                    <div class="row mt-2">
                                        <div class="col-2">
                                            <select name="worker_id" class="form-control" >
                                            <option value="">Select Worker</option>
                                                @foreach ($worker_list as $item)
                                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                                @endforeach
                                            </select> 
                                        </div>
                                        <div class="col-2">
                                            <input type="text" placeholder="Select date" class="form-control datepicker" name="fdate" value="{{old('fdate')}}">
                                        </div>
                                        <div class="col-2">
                                            <input type="text" placeholder="Select date" class="form-control datepicker" name="tdate" value="{{old('tdate')}}">
                                        </div>
                                        <div class="col-1">
                                            <button type="submit" class="btn btn-success">Filter</button>
                                        </div>
                                        <div class="col-1">
                                            <a href="{{url()->current()}}" class="btn  btn-success">Reset</a>
                                        </div>
                                        <div class="col-1">
                                            <a href="{{ url('worker_order_excel') }}?order_type=<?php echo $ref_type; ?>&worker_id=<?php echo $workerid; ?>" class="btn btn-success">Download Excel</a>
                                        </div>
                                    </div>
                                </form>
                                </h2>
                                <div class="table-responsive">
                                <table class="table table-striped table-bordered text-center">
                                  <thead class="mt-3">
                                    <tr  class="tab_head">
                                      <th scope="1">Order Id</th>
                                      <th scope="1">Unique Id</th>
                                        <th>Date</th>
                                        <th>Worker Name</th>
                                        <th scope="2">Karet</th>
                                        <th scope="4">Issue</th>
                                        @if ($ref_type == 1)
                                        <th scope="5">Add</th>
                                        <th scope="6">Received</th>
                                        <th scope="7">Return</th>
                                        <th scope="8">Dust</th>
                                        @endif
                                        @if ($ref_type == 3)
                                        <th>Gram received</th>
                                        <th>Diamond </th>
                                        <th>Diamond Piece</th>
                                        <th>Color Stone</th>
                                        <th>Color Stone Piece</th>
                                        <th>AD</th>
                                        <th>AD Piece</th>
                                        <th>Enamel WT</th>
                                        <th>Dust</th>
                                        @endif
                                        @if ($ref_type == 4 || $ref_type == 2)
                                        <th>Received</th>
                                        <th>Dust</th>
                                        @if ($ref_type == 4)
                                        <th>Action</th>
                                        @endif
                                        @endif
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @php
                                        $iscount = $list->count();
                                        $j = 0;
                                        $karet18 = 0;
                                        $karet10 = 0;
                                        $karet14 = 0;
                                        $karet22 = 0;
                                        $karet24 = 0;
                                    @endphp
                                    
                                    @foreach ($list as $i)
                                    @php 
                                        $karet = get_karet_name($i->order_id); 
                                        if($karet == "18K"){
                                            $karet18++;
                                        }
                                        if($karet == "10K"){
                                            $karet10++;
                                        }
                                        if($karet == "14K"){
                                            $karet14++;
                                        }
                                        if($karet == "22K"){
                                            $karet22++;
                                        }
                                        if($karet == "24K"){
                                            $karet24++;        
                                        }
                                    @endphp                              
                                    <tr>
                                       <td scope="1">{{$i->order_id}}</td>
                                       <td scope="1">{{get_order_qid($i->order_id)}}</td>
                                       <td>{{$i->update_date}}</td>
                                       <td>{{get_worker_name($i->worker_id)}}</td>
                                       <td scope="2">{{get_karet_name($i->order_id)}}</td>
                                       <td scope="4">{{$i->gram_issue}}</td>
                                       @if ($ref_type == 1)
                                            <td scope="5">{{$i->fi_add}}</td>
                                            <td scope="6">{{$i->fi_reciv}}</td>
                                            <td scope="7">{{$i->fi_return}}</td>
                                            <td scope="8">
                                                <input type="hidden" value="{{$i->fi_bal}}" id="cdust{{$i->id}}">
                                                {{$i->fi_bal}}
                                            </td>
                                       @endif
                                       @if ($ref_type == 3)
                                            <td>{{$i->se_reciv}}</td>
                                            <td>{{$i->kd}}</td>
                                            <td>{{$i->pd}}</td>
                                            <td>{{$i->kc}}</td>
                                            <td>{{$i->pc}}</td>
                                            <td>{{$i->ka}}</td>
                                            <td>{{$i->pa}}</td>
                                            <td>{{$i->gew}}</td>
                                            <td><input type="hidden" value="{{$i->se_dust}}" id="cdust{{$i->id}}">{{$i->se_dust}}</td>
                                       @endif
                                       @if ($ref_type == 4)
                                        <td>{{$i->fp_reciv}}</td>
                                        <td>
                                            <input type="hidden" value="{{$i->fp_dust}}" id="cdust{{$i->id}}">
                                            {{$i->fp_dust}}</td>
                                            <td scope="9">
                                                @php
                                                    $fp_dust_return = 0;
                                                    if($i->fp_dust_return){
                                                        $fp_dust_return = $i->fp_dust_return;
                                                    }
                                                @endphp
                                                        <span id="fil_dust_ret{{$i->id}}">{{$fp_dust_return}}</span><span class="filling_btn cr_poin" id="retid" onclick="dust_return(4,{{$i->id}})"><i class="fas fa-sync"></i></span>
                                                </td>
                                       @endif
                                       @if ($ref_type == 2)
                                        <td>{{$i->mo_reciv}}</td>
                                        <td>
                                            <input type="hidden" value="{{$i->mo_dust}}" id="cdust{{$i->id}}">
                                            {{$i->mo_dust}}</td>
                                       @endif
                                    </tr>
                                   @endforeach
                                    @if ($ref_type == 1)
                                        <tr class='table-dark-css'>
                                        <td  class="text-center" colspan="4"><span>18K</span></td>
                                        <td class="text-center">
                                            {{$karet18}}
                                        </td>
                                        </tr>
                                        <tr class='table-dark-css'>
                                        <td  class="text-center" colspan="4"><span>10K</span></td>
                                        <td class="text-center">
                                            {{$karet10}}
                                        </td>
                                        </tr>
                                        <tr class='table-dark-css'>
                                        <td  class="text-center" colspan="4"><span>14K</span></td>
                                        <td class="text-center">
                                            {{$karet14}}
                                        </td>
                                        </tr>
                                        <tr class='table-dark-css'>
                                        <td  class="text-center" colspan="4"><span>22K</span></td>
                                        <td class="text-center">
                                            {{$karet22}}
                                        </td>
                                        </tr>
                                        <tr class='table-dark-css'>
                                        <td  class="text-center" colspan="4"><span>24K</span></td>
                                        <td class="text-center">
                                            {{$karet24}}
                                        </td>
                                        </tr>
                                        <tr class='table-dark-css'>
                                        <td  class="text-center" colspan="5"><span>TOTAL</span></td>
                                        <td class="text-center">
                                            {{$list->sum('gram_issue')}}
                                        </td>
                                        <td class="text-center">{{$list->sum('fi_add')}}</td>  
                                        <td class="text-center">{{$list->sum('fi_reciv')}}</td>
                                        <td class="text-center">{{$list->sum('fi_return')}}</td>
                                        <td class="text-center">{{$list->sum('fi_bal')}}</td>
                                        </tr>
                                    @endif
                                    @if ($ref_type == 2)
                                        <tr class='table-dark-css'>
                                        <td  class="text-center" colspan="4"><span>18K</span></td>
                                        <td class="text-center">
                                            {{$karet18}}
                                        </td>
                                        </tr>
                                        <tr class='table-dark-css'>
                                        <td  class="text-center" colspan="4"><span>10K</span></td>
                                        <td class="text-center">
                                            {{$karet10}}
                                        </td>
                                        </tr>
                                        <tr class='table-dark-css'>
                                        <td  class="text-center" colspan="4"><span>14K</span></td>
                                        <td class="text-center">
                                            {{$karet14}}
                                        </td>
                                        </tr>
                                        <tr class='table-dark-css'>
                                        <td  class="text-center" colspan="4"><span>22K</span></td>
                                        <td class="text-center">
                                            {{$karet22}}
                                        </td>
                                        </tr>
                                        <tr class='table-dark-css'>
                                        <td  class="text-center" colspan="4"><span>24K</span></td>
                                        <td class="text-center">
                                            {{$karet24}}
                                        </td>
                                        </tr>
                                        <tr class='table-dark-css'>
                                        <td  class="text-center" colspan="5"><span>TOTAL</span></td>
                                        <td class="text-center">
                                            {{$list->sum('gram_issue')}}
                                        </td>
                                        <td class="text-center">{{$list->sum('mo_reciv')}}</td>  
                                        <td class="text-center">{{$list->sum('mo_dust')}}</td>
                                        </tr>
                                    @endif
                                    @if ($ref_type == 3)
                                        <tr class='table-dark-css'>
                                        <td  class="text-center" colspan="4"><span>18K</span></td>
                                        <td class="text-center">
                                            {{$karet18}}
                                        </td>
                                        </tr>
                                        <tr class='table-dark-css'>
                                        <td  class="text-center" colspan="4"><span>10K</span></td>
                                        <td class="text-center">
                                            {{$karet10}}
                                        </td>
                                        </tr>
                                        <tr class='table-dark-css'>
                                        <td  class="text-center" colspan="4"><span>14K</span></td>
                                        <td class="text-center">
                                            {{$karet14}}
                                        </td>
                                        </tr>
                                        <tr class='table-dark-css'>
                                        <td  class="text-center" colspan="4"><span>22K</span></td>
                                        <td class="text-center">
                                            {{$karet22}}
                                        </td>
                                        </tr>
                                        <tr class='table-dark-css'>
                                        <td  class="text-center" colspan="4"><span>24K</span></td>
                                        <td class="text-center">
                                            {{$karet24}}
                                        </td>
                                        </tr>
                                        <tr class='table-dark-css'>
                                        <td  class="text-center" colspan="5"><span>TOTAL</span></td>
                                        <td class="text-center">
                                            {{$list->sum('gram_issue')}}
                                        </td>
                                        <td class="text-center">{{$list->sum('se_reciv')}}</td>
                                        <td class="text-center">{{$list->sum('kd')}}</td>
                                        <td class="text-center">{{$list->sum('pd')}}</td>
                                        <td class="text-center">{{$list->sum('kc')}}</td>
                                        <td class="text-center">{{$list->sum('pc')}}</td>
                                        <td class="text-center">{{$list->sum('ka')}}</td>
                                        <td class="text-center">{{$list->sum('pa')}}</td>
                                        <td class="text-center">{{$list->sum('gew')}}</td>
                                        <td class="text-center">{{$list->sum('se_dust')}}</td>
                                        </tr>
                                    @endif
                                    @if ($ref_type == 4)
                                        <tr class='table-dark-css'>
                                        <td  class="text-center" colspan="4"><span>18K</span></td>
                                        <td class="text-center">
                                            {{$karet18}}
                                        </td>
                                        </tr>
                                        <tr class='table-dark-css'>
                                        <td  class="text-center" colspan="4"><span>10K</span></td>
                                        <td class="text-center">
                                            {{$karet10}}
                                        </td>
                                        </tr>
                                        <tr class='table-dark-css'>
                                        <td  class="text-center" colspan="4"><span>14K</span></td>
                                        <td class="text-center">
                                            {{$karet14}}
                                        </td>
                                        </tr>
                                        <tr class='table-dark-css'>
                                        <td  class="text-center" colspan="4"><span>22K</span></td>
                                        <td class="text-center">
                                            {{$karet22}}
                                        </td>
                                        </tr>
                                        <tr class='table-dark-css'>
                                        <td  class="text-center" colspan="4"><span>24K</span></td>
                                        <td class="text-center">
                                            {{$karet24}}
                                        </td>
                                        </tr>
                                        <tr class='table-dark-css'>
                                        <td  class="text-center" colspan="5"><span>TOTAL</span></td>
                                        <td class="text-center">
                                            {{$list->sum('gram_issue')}}
                                        </td>
                                        <td class="text-center">{{$list->sum('fp_reciv')}}</td>
                                        <td class="text-center">{{$list->sum('fp_dust')}}</td>
                                        <td class="text-center">{{$list->sum('fp_dust_return')}}</td>
                                        </tr>
                                    @endif
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
</div>

 <!-- Modal -->
 <div class="modal fade" id="dust_return_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-title">
            Dust Return
          </div>
          <h5 class="modal-title" id="exampleModalLabel"><span id="forward_modal_name"></span></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            
          <form action="" method="post" id="return_dust_form">
            @csrf             
              <div class="form-group">
                  <input type="hidden" id="order_id" name="order_id">
                  <input type="hidden" id="order_type" name="order_type">
              </div>
              <div class="form-group">
                <label for="numberInput">Available Dust</label>
                <input type="number" step="0.01" class="form-control" value="" id="cr_av_dust" name="cr_av_dust" disabled>
              </div>              
              <div class="form-group">
                <label for="numberInput">Return Dust Amount</label>
                <input type="number" step="0.01" class="form-control" value="" id="dust_return" name="dust_return">
              </div>
              <button type="submit" class="btn btn-success">Save</button>
        </form>
        <div id="refer_table_his"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


@include('admin.main.footer')
