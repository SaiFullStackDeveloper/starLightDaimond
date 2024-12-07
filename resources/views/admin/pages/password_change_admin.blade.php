@include('admin.main.header');
<div class="mrg_tp"></div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Password Change</h2>
                </div>
                <div class="card-body">
                    <form action="{{url('password_change_admin_update')}}" method="post">
                        @csrf
                      <div class="row">
                          <div class="col-4"></div>
                        <div class="col-4">
                            <div class="row">
                                <div class="col-12">
                                    <div class="input_bx">
                                        <span>User Name</span>
                                        <input type="text" name="username" class="form-control">
                                    </div>      
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="input_bx">
                                        <span>New Password</span>
                                        <input type="text" name="new_password" class="form-control">
                                    </div>      
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="input_bx">
                                        <span>Old Password</span>
                                        <input type="text" name="password" class="form-control" required>
                                    </div>      
                                </div>
                                
                                <div class="col-12">
                                    <button class="btn btn-success" type="submit">Submit</button>
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
