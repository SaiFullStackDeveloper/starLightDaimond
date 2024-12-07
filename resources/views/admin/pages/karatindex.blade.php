@include('admin.main.header');
<div class="mrg_tp"></div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Karat Update</h2>
                </div>
                <div class="card-body">
                    <form action="{{url('karatupdate')}}" method="post">
                        @csrf
                      <div class="row">
                        @foreach ($list as $item)
                        <div class="col-3"></div>
                        <div class="col-3">
                            <div class="input_bx">
                                <span>Karat Name</span>
                                <input type="text" name="kname[]" class="form-control" value="{{$item->name}}">
                                <input type="hidden" name="kmain_id[]" class="form-control" value="{{$item->manin_id}}">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="input_bx">
                                <span>Karat Percentage ({{$item->name}})</span>
                                <input type="number" min="0"  step="0.01" max="100000" name="percentage[]" class="form-control" value="{{$item->per}}">
                            </div>
                        </div>
                        <div class="col-3"></div>
                        @endforeach
                        <div class="col-3"></div>
                        <div class="col-md-3 mt-3">
                          <button class="btn btn-success" type="submit">Update</button>
                        </div>
                      </div>
                    </form>
                </div>
              </div>
        </div>
    </div>
</div>
@include('admin.main.footer');
