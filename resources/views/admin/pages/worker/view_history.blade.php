@include('admin.main.header')

<div class="mrg_tp"></div>

<div class="dashboard_min">
    <div class="container-fluid mt-2">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <span class="card-title">Dust return history</span>
                        <div class="">
                            <div class="row">
                                <div class="col-md-3 phea user_tab">
                                    <p class="worker_name">{{$worker_name}}</p>
                                </div>
                            </div>
                        </div>
                        <div>
                            <form action="{{url()->current()}}" id="dust_table_form">
                            <div class="row mt-2">      
                                <div class="col-2">
                                    <input type="text" placeholder="Starting date" class="form-control datepicker" name="fdate" value="{{$fdate}}" >
                                </div>
                                <div class="col-2">
                                    <input type="text" placeholder="Ending date" class="form-control datepicker" name="tdate" value="{{$tdate}}" >
                                </div>
                                <input type="hidden" value="{{$worker_id}}" name="worker_id">
                                <input type="hidden" value="" name="is_excel" id="is_excel">
                                <div class="col-3">
                                    <button type="submit" class="btn"><img src="{{url('public/magnifying-glass.png')}}" height="auto" width="25px" alt=""></button>
                                    <button type="button" onclick="dust_table_excel()" class="btn"><img src="{{url('public/excel.png')}}" height="auto" width="25px" alt=""></button>
                                </div>
                                
                            </div>
                            </form>
                        </div>
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
                                            <th>Worker Name</th>
                                            <th>Dust Return</th>
                                            <th>Actions</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($list as $item)
                                       <tr>
                                           <td>{{$i}}</td>
                                           <td>{{$item->date}}</td>
                                           <td>{{$item->name}}</td>
                                           <td>{{$item->return_dust}}</td>
                                           <td>
                                            {{-- <a href="" class="btn"><img height="auto" width="25px" src="{{url('public/edit.png')}}" alt=""></a> --}}
                                            <a href="{{url('delete_return_dust/'.$item->id)}}" class="btn"><img height="auto" width="25px" src="{{url('public/delete.png')}}" alt=""></a>
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
</div>

@include('admin.main.footer')
