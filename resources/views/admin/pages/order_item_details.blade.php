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
                    <h2 class="card-title">Order Items</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 table_con">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered text-center">
                                  <thead>
                                    <tr class="tab_head">
                                      <th>Sl. No</th>
                                      <th>Product Name</th>
                                      <th>Size/Inches</th>
                                      <th>Screw</th>
                                      <th>Piece</th>
                                      <th>Appx Gram</th>
                                      <th>Metal colour</th>
                                      <th>Karat</th>
                                      <th>Status</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($itemlist as $j)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{$j->product_name}}</td>
                                        <td>{{$j->size}}</td>
                                        <td>{{$j->inches}}</td>
                                        <td>{{$j->piece}}</td>
                                        <td>{{$j->karat}}</td>
                                        <td>{{$j->mcolor}}</td>
                                        <td>{{$j->appxgram}}</td>
                                        <td><div id="toggle-button{{$j->id}}" onclick="togelitems({{$j->id}})" class="status_cc d-inline clickable "><span id="syzz{{$j->id}}"> @if($j->sts == 1) Complete @else Pending @endif </span> </div></td>
                                    </tr>    
                                    @php
                                    $i++;
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
        <div class="col-md-12 my-2">
          <div class="card">
              <div class="card-header">
                  <h2 class="card-title">Filling</h2>
              </div>
              <div class="card-body">
                  <div class="row">
                      <div class="col-md-12 table_con">
                          <div class="table-responsive">
                              <table class="table table-striped table-bordered text-center">
                                <thead>
                                  <tr class="tab_head">
                                    <th>Sl. No</th>
                                    <th>Date</th>
                                    <th>Worker name</th>
                                    <th>Gram Issue</th>
                                    <th>Comment</th>
                                    <th>Status</th>
                                    <th>View</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  @php
                                      $i = 1;
                                  @endphp
                                  @foreach ($filing_history as $j)
                                  <tr>
                                      <td>{{$i}}</td>
                                      <td>{{$j->date}}</td>
                                      <td>{{$j->worker_id}}</td>
                                      <td>{{$j->gram_issue}}</td>
                                      <td>{{$j->comments}}</td>
                                      <td>
                                        <div id="toggle-button"  class="status_cc d-inline ">
                                          
                                            @if($j->psts == 1)
                                            <span class="bg-success text-white">Complete</span> 
                                            @else
                                            <span class="bg-danger text-white"> Pending </span>
                                            @endif 
                                          </span>
                                         </div>
                                      </td>
                                      <td>
                                        @if(check_forward($j->order_id,1))
                                            
                                          @else
                                            <span class="br-right"></span> <span><a  href="{{ url('filling_form/'.$j->order_id) }}"><i class="fas fa-eye vieweyeicon"></i></a></span>
                                          @endif
                                      </td>
                                  </tr>    
                                  @php
                                  $i++;
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
      <div class="col-md-12 my-2">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Mounting</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 table_con">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered text-center">
                              <thead>
                                <tr class="tab_head">
                                  <th>Sl. No</th>
                                  <th>Date</th>
                                  <th>Worker name</th>
                                  <th>Gram Issue</th>
                                  <th>Comment</th>
                                  <th>Status</th>
                                  <th>View</th>
                                </tr>
                              </thead>
                              <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($mounting_history as $j)
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{$j->date}}</td>
                                    <td>{{$j->worker_id}}</td>
                                    <td>{{$j->gram_issue}}</td>
                                    <td>{{$j->comments}}</td>
                                    <td>
                                      <div id="toggle-button"  class="status_cc d-inline ">
                                        @if($j->psts == 1)
                                        <span class="bg-success text-white">Complete</span> 
                                        @else
                                        <span class="bg-danger text-white"> Pending </span>
                                        @endif 
                                       </div>
                                    </td>
                                    <td>
                                      @if(check_forward($j->order_id,2))
                                          
                                        @else
                                          <span class="br-right"></span> <span><a  href="{{ url('Mounting_Form/'.$j->order_id) }}"><i class="fas fa-eye vieweyeicon"></i></a></span>
                                        @endif
                                    </td>
                                </tr>    
                                @php
                                $i++;
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
    <div class="col-md-12 my-2">
      <div class="card">
          <div class="card-header">
              <h2 class="card-title">Setting</h2>
          </div>
          <div class="card-body">
              <div class="row">
                  <div class="col-md-12 table_con">
                      <div class="table-responsive">
                          <table class="table table-striped table-bordered text-center">
                            <thead>
                              <tr class="tab_head">
                                <th>Sl. No</th>
                                <th>Date</th>
                                <th>Worker name</th>
                                <th>Gram Issue</th>
                                <th>Comment</th>
                                <th>Status</th>
                                <th>View</th>
                              </tr>
                            </thead>
                            <tbody>
                              @php
                                  $i = 1;
                              @endphp
                              @foreach ($setting_history as $j)
                              <tr>
                                  <td>{{$i}}</td>
                                  <td>{{$j->date}}</td>
                                  <td>{{$j->worker_id}}</td>
                                  <td>{{$j->gram_issue}}</td>
                                  <td>{{$j->comments}}</td>
                                  <td>
                                    <div id="toggle-button"  class="status_cc d-inline ">
                                      @if($j->psts == 1)
                                      <span class="bg-success text-white">Complete</span> 
                                      @else
                                      <span class="bg-danger text-white"> Pending </span>
                                      @endif 
                                     </div>
                                  </td>
                                  <td>
                                    @if(check_forward($j->order_id,3))
                                        
                                      @else
                                        <span class="br-right"></span> <span><a  href="{{ url('Setting_Form/'.$j->order_id) }}"><i class="fas fa-eye vieweyeicon"></i></a></span>
                                      @endif
                                  </td>
                              </tr>    
                              @php
                              $i++;
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
  <div class="col-md-12 my-2">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Final polish</h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 table_con">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered text-center">
                          <thead>
                            <tr class="tab_head">
                              <th>Sl. No</th>
                              <th>Date</th>
                              <th>Worker name</th>
                              <th>Gram Issue</th>
                              <th>Comment</th>
                              <th>Status</th>
                              <th>View</th>
                            </tr>
                          </thead>
                          <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($finalpolish_history as $j)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$j->date}}</td>
                                <td>{{$j->worker_id}}</td>
                                <td>{{$j->gram_issue}}</td>
                                <td>{{$j->comments}}</td>
                                <td>
                                  <div id="toggle-button"  class="status_cc d-inline ">
                                    @if($j->psts == 1)
                                    <span class="bg-success text-white">Complete</span> 
                                    @else
                                    <span class="bg-danger text-white"> Pending </span>
                                    @endif 
                                   </div>
                                </td>
                                <td>
                                  @if(check_forward($j->order_id,4))
                                      
                                    @else
                                      <span class="br-right"></span> <span><a  href="{{ url('final_Form/'.$j->order_id) }}"><i class="fas fa-eye vieweyeicon"></i></a></span>
                                    @endif
                                </td>
                            </tr>    
                            @php
                            $i++;
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
@include('admin.main.footer');
