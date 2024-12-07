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
                    <h2 class="card-title">Gold Transtion</h2>
                    <a href="{{url('customer_orders/'.$cusid)}}" class="btn btn-sm btn-success mx-2" style="float: right;">All Orders History</a>
                    {{-- <form action="{{url()->current()}}">
                      <div class="row mt-2">
                          
                          <div class="col-2">
                              <input type="text" placeholder="Select date" class="form-control datepicker" name="fdate" value="{{old('fdate')}}">
                          </div>
                          <div class="col-2">
                              <input type="text" placeholder="Select date" class="form-control datepicker" name="tdate" value="{{old('tdate')}}">
                          </div>
                          <div class="col-1">
                              <button type="submit" class="btn btn-sm btn-success">Filter</button>
                          </div>
                          <div class="col-1">
                              <a href="{{url()->current()}}" class="btn btn-sm btn-success">Reset</a>
                          </div>
                      </div>
                  </form> --}}
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 table_con">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered text-center">
                                  <thead>
                                    <tr class="tab_head">
                                      <th>SL.No</th>
                                      <th>Name</th>
                                      <th>Date</th>
                                      <th>Karat</th>
                                      <th>Pure Metal</th>
                                      <th>Comment</th>
                                      <th>Type</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($list as $item)
                                    <tr class="@if($item->type == 1) recivebg @else returnbg @endif">
                                        <td>{{$i}}</td>
                                        <td>{{get_client_name($item->userid)}}</td>
                                        
                                        <td>{{$item->date}}</td>
                                        <td>{{get_karat_name($item->karret)}}</td>
                                        <td>{{$item->gold}}</td>
                                        <td>{{$item->comment}}</td>
                                        <td>
                                            <span class="btn @if($item->type == 1) btn-success @else btn-danger @endif">
                                                @if ($item->type == 1)
                                                    Recive
                                                @else
                                                    Return
                                                @endif
                                            </span>
                                        </td>
                                        @php
                                        $i++;
                                    @endphp
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
@include('admin.main.footer');
