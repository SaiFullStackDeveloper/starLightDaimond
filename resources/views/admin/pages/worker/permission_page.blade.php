@include('admin.main.header');
<div class="mrg_tp"></div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Permission Update</h2>
                </div>
                <div class="card-body">
                    <form action="{{url('manager_permission')}}" method="post">
                        @csrf
                      <div class="row">
                          <div class='col-md-4'>
                              <div class="row">
                                <div class="col-3">
                                    <h3>Page name</h3>
                                </div>
                                <div class="col-3">
                                    <h3>View</h3>
                                </div>
                                <div class="col-3">
                                    <h3>Add</h3>
                                </div>
                                <div class="col-3">
                                    <h3>Update</h3>
                                </div>
                                <input name='manager_id' type="hidden" value='{{$manager_id}}'>
                                @foreach ($permission_pages as $item)
                                <input name='page_id[]' type="hidden" value='{{$item->id}}'>
                                <input name='page_name[{{$item->id}}]' type="hidden" value='{{$item->name}}'>
                                    <div class="col-3">
                                        <h3>{{$item->name}}</h3>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-check">
                                            <input name='view[{{$item->id}}]' @if(check_per($manager_id,$item->id,'view')) checked @endif class="form-check-input" type="checkbox" value="1" id="exampleCheckbox">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-check">
                                            <input @if(check_per($manager_id,$item->id,'add')) checked @endif name='add[{{$item->id}}]' class="form-check-input" type="checkbox" value="1" id="exampleCheckbox">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-check">
                                            <input @if(check_per($manager_id,$item->id,'update')) checked @endif name='update[{{$item->id}}]' class="form-check-input" type="checkbox" value="1" id="exampleCheckbox">
                                        </div>
                                    </div>
                                @endforeach
                                <div class='col-md-12'>
                                    <button type='submit' class='btn btn-success'>Submit</button>
                                </div>
                              </div>
                          </div>
                      </div>
                    </form>
                </div>
              </div>
        </div>
    </div>
</div>
@include('admin.main.footer');
