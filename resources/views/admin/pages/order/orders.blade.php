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
                                $pyority = get_priority_list();
                            @endphp
                            <select name="pyority" class="form-control" id="">
                              <option value="">Select Priority</option>
                              @foreach ($pyority as $p)
                                  <option value="{{$p->id}}">{{$p->name}}</option>
                              @endforeach
                            </select>
                        </div>
                          <div class="col-1">
                              <button type="submit" class="btn btn-sm btn-success">Filter</button>
                          </div>
                          <div class="col-1">
                              <a href="{{url()->current()}}" class="btn btn-sm btn-success">Reset</a>
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
                                      <th>Order Date</th>
                                      <th>Delivery Date</th>
                                      <th>No of Item</th>
                                      {{-- <th>Issued</th>
                                      <th>Recv.</th> --}}
                                      <th>Priority</th>
                                      <th>Status</th>
                                      <th>Approx Grams</th>
                                      <th>Finsihed Grams</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @foreach ($order as $item)
                                    <tr>
                                      <td>{{ $item->unique_id  }} <span><a href="{{ url('order_item_details/'.$item->id) }}"><i class="fas fa-eye"></i></a></span></td>
                                      <td>
                                        {{ $item->created_at  }}</span>
                                      </td>
                                      <td>
                                        {{ $item->delivery_date  }} <br>
                                        <span class="text-danger">Total Days =  <span class="text-bold">{{$item->delivery_mindate-$item->order_mindate}}</span> </span>
                                      </td>
                                    <td>{{get_total_item($item->id)}}</td>
                                    {{-- <td>{{get_total_issued($item->id)}}</td>
                                    <td>{{get_total_rec($item->id)}}</td> --}}
                                    <td>
                                        @php
                                            echo get_order_priority($item->priority);
                                        @endphp
                                    </td>
                                    <td>
                                        <div class="status_cc d-inline"><span>Completed</span></div>
                                    </td>
                                    <td>{{$item->appx_gram}}</td>
                                    <td>{{count_gram_recive_final_polish($item->id)}}</td>
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
