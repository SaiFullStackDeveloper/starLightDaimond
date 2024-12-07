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
<div class="mrg_tp"></div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Repair history
                      <a href="{{url('repair_log')}}" class="btn btn-sm btn-success  mx-2" style="float: right;">Repair Log</a>
                      <a href="{{url('repair_index')}}" class="btn btn-sm btn-success mx-2" style="float: right;">New Repair</a>
                    </h2>
                    
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 table_con">
                            <div class="table-responsive">
                                <table id="myTable" class="display nowrap" style="width:100%">
                                  <thead>
                                    <tr class="tab_head">
                                      <th>Order No</th>
                                      <th>Client Name</th>
                                      <th>Unique Id</th>
                                      <th>Date</th>
                                      <th>Due Date</th>
                                      <th>Total Days</th>
                                      <th>Issued</th>
                                      <th>Received</th>
                                      <th>More/Less</th>
                                      <th>Additional Charge</th>
                                        <th>Gold Charge</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @foreach ($order as $item)
                                    <tr>
                                      <td>{{$item->id}}</td>
                                      <td>{{ get_client_name($item->client_name)  }}</td>
                                      <td>{{ $item->unique_id  }}<span><a href="{{ url('repair_item_details/'.$item->id) }}"> <i class="fas fa-eye"></i></a></span></td>
                                      <td>{{ $item->date  }}</td>
                                      <td>
                                        {{ $item->delivery_date  }}
                                      </td>
                                      <td>
                                        <span class="text-danger">Total Days =  <span class="text-bold">{{$item->delivery_mindate-$item->order_mindate}}</span> </span>
                                      </td>
                                      <td>
                                          {{count_repair_is($item->id,'gram_issue')}}
                                      </td>
                                      <td>{{count_repair_is($item->id,'received')}}</td>
                                      <td>{{count_repair_is($item->id,'more_or_less')}}</td>
                                      
                                      <td>
                                        <input type="hidden" value="{{$item->addi_chrg}}" id="add_in_c{{$item->id}}">
                                        <span id="add_c_r{{$item->id}}">{{$item->addi_chrg}}</span> 
                                        <span class="filling_btn cr_poin" onclick="add_repair_charge(1,{{$item->id}})"><i class="fas fa-paper-plane"></i></span>
                                      </td>
                                      <td>
                                        <input type="hidden" value="{{$item->gold_chrg}}" id="gold_in_c{{$item->id}}">
                                        <span id="gold_c_r{{$item->id}}">{{$item->gold_chrg}}</span> 
                                        <span class="filling_btn cr_poin" onclick="add_repair_charge(2,{{$item->id}})"><i class="fas fa-paper-plane"></i></span>
                                      </td>
                                      <td>
                                        <span id="total_c_r{{$item->id}}">{{count_repair_charge($item->id)}}</span> 
                                        </td>
                                        <td>
                                            @php
                                                echo get_repair_status($item->id);
                                            @endphp
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
          
        <form action="{{url('repair_forward')}}" method="post">
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
            <div class="form-group">
              <label for="numberInput">Comments</label>
              <input type="text"  class="form-control" value="" name="comments" id="comments" placeholder="">
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
 <div class="modal fade" id="repair_charge" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-title">
            Add charge
          </div>
          <h5 class="modal-title" id="exampleModalLabel"><span id="forward_modal_name"></span></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            
          <form action="" method="post" id="add_repair_charge_form">
            @csrf             
              <div class="form-group">
                  <input type="hidden" id="chr_order_id" name="order_id">
                  <input type="hidden" id="order_type" name="order_type">
              </div>
              <div class="form-group">
                <label for="numberInput">Charge</label>
                <input type="number" step="0.01" class="form-control" value="" id="rep_charge" name="charge">
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

@include('admin.main.footer');
