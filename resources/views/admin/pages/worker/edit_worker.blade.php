@include('admin.main.header')

<div class="mrg_tp"></div>
<div class="dashboard_min">
    <div class="container-fluid">
        <div class="dashboard_panel">

            <div class="dashboard_right w-100">
                <div class="das_right_inr ">
                    <div class="">
                        <ul class="">
                            <h2><li class=" mt-5">Edit</li></h2>

                        </ul>
                    </div>
                    <div class="das_frm_panel ">
                        <form action="{{ route('add_worker') }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="das_frm_bx mt-5">
                                <div class="frm_inp_body">
                                    <div class="row">

                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                            <div class="input_bx">
                                                <span>User Name</span>
                                                <input type="text" placeholder="Name" name="name" value="{{ $worker->name }}" required >
                                                <input type="hidden"  name="update_id" value="{{ $worker->id }}"  >
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                            <div class="input_bx">
                                                <span>User Phone</span>
                                                <input type="text" placeholder="Phone" name="phone" value="{{ $worker->phone }}" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                            <div class="input_bx">
                                                <span>Alternative Phone</span>
                                                <input type="text" placeholder="Phone" name="alt_number"  value="{{ $worker->alt_number }}" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                            <div class="input_bx">
                                                <span>Place</span>
                                                <input type="text" placeholder="Place" name="place" value="{{ $worker->place }}" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                            <div class="input_bx">
                                                <span>Aadhaar</span>
                                                <input type="number" placeholder="Aadhaar" name="adhar" value="{{ $worker->adhar }}">
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                            <div class="input_bx">
                                                <span>Working Id</span>
                                                <input type="text" placeholder="Working Id" name="working_id" value="{{ $worker->working_id }}" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                            <div class="input_bx">
                                                <span>Username</span>
                                                <input type="text" placeholder="Working username" name="email" value="{{ $worker->email }}" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                            <div class="input_bx">
                                                <span>password</span>
                                                <input type="text" placeholder="Password" name="pass" value="{{ $worker->password }}"  required>
                                            </div>
                                        </div>
                                        @if (login_role() != 3)
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                            <div class="input_bx">
                                                <span>Role</span>
                                                <select name="role"  id="role_check_id" onchange="is_worker()">
                                                    {{-- <option @if ($worker->role=='1'){{ 'selected' }}@endif value="1">Admin</option> --}}
                                                    @if($worker->role == 2)<option @if ($worker->role=='2'){{ 'selected' }}@endif value="2">Worker</option>@endif
                                                    @if($worker->role == 3)<option @if ($worker->role=='3'){{ 'selected' }}@endif value="3">Management</option>@endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12" id="manager_id_div" @if($worker->role != 2) style="display: none;" @endif>
                                            <div class="input_bx">
                                                <span>Select Manager</span>
                                                <select name="manager_id" id="manager_id_dropdown" @if($worker->role == 2) required @endif>
                                                    <option value="">Select manager</option>
                                                    @foreach ($manager_list as $item)
                                                        <option @if($worker->manager_id == $item->id) selected @endif style="text-transform: capitalize" value="{{$item->id}}">{{$item->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @if($worker->role == 3)
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-4" style='display:none'>
                                            <div class="">
                                                <span class="text-danger">If the worker is part of the management team, check box for permissions.</span>
                                                <div class="form-check">
                                                    <input class="form-check-input" @if($worker->permissions) checked @endif  type="checkbox" value="1" id="checkbox2" name="permissions">
                                                    <label class="form-check-label" for="checkbox2">
                                                        Modify Permissions
                                                    </label>
                                                  </div>
                                            </div>
                                        </div>
                                        @endif
                                        @else
                                        <input type="hidden" name="role" value="2">
                                        <input type="hidden" name="manager_id" value="{{login_id()}}">
                                        @endif
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                            <div class="uplodimg">
                                                <span class="uplode_spa"><small>Image</small></span>
                                                <div class="uplodimgfil">
                                                    <input type="file" name="worker_iamge" id="file-1"
                                                        class="inputfile inputfile-1"
                                                        data-multiple-caption="{count} files selected" >
                                                    <label for="file-1">Drag and Drop or <b>Browse</b> to upload
                                                        <em><img src="{{ url('public') }}/uploads/{{ $worker->worker_iamge }}" style="width:38px;border-radius:15px;height: 100%;
                                                        }" alt=""></em>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                                            <div class="uplodimg">
                                                <span class="uplode_spa"><small>Identity Document</small></span>
                                                <div class="uplodimgfil">
                                                    <input  type="file"  name="identity_doc" id="file-2"
                                                        class="inputfile inputfile-1"
                                                        data-multiple-caption="{count} files selected" >
                                                    <label for="file-2">Drag and Drop or <b>Browse</b> to upload
                                                        <em><img src="{{ url('public') }}/uploads/{{ $worker->identity_doc }}" style="width:38px;border-radius:15px;height: 100%;
                                                                alt=""></em>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        @if($worker->role == 2)
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mt-5">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="1" id="checkbox1" name="filling" @if($worker->filling == 1) checked @endif>
                                                <label class="form-check-label" for="checkbox1">
                                                  Filling
                                                </label>
                                              </div>
                                              
                                              <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="1" id="checkbox2" name="mounting" @if($worker->mounting == 1) checked @endif>
                                                <label class="form-check-label" for="checkbox2">
                                                  Mounting
                                                </label>
                                              </div>
                                              
                                              <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="1" id="checkbox3" name="setting" @if($worker->setting == 1) checked @endif>
                                                <label class="form-check-label" for="checkbox3">
                                                  Setting
                                                </label>
                                              </div>
                                              
                                              <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="1" id="checkbox4" name="finalpolish" @if($worker->finalpolish == 1) checked @endif>
                                                <label class="form-check-label" for="checkbox4">
                                                  Final Polish
                                                </label>
                                              </div>
                                              
                                        </div>
                                        @endif

                                        <div class=" cc_top_btn">
                                            <button style="border:none;margin-top:123px;height:53px;text-align:center;" type="submit" class="btn_cc mx-5" >Submit
                                                    <em><img src="{{url('public')}}/assets/images/btn_icon.png" class="mt-2" alt=""></em></button>
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
</div>


@include('admin.main.footer');
