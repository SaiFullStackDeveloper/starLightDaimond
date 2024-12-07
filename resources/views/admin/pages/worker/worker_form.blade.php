@include('admin.main.header')
<div class="mrg_tp"></div>
<div class="dashboard_min">
    <div class="container-fluid">
        <div class="dashboard_panel">

            <div class="dashboard_right w-100">
                <div class="das_right_inr ">
                    <div class="">
                        <ul class="">
                            <h2>
                                <li class=" mt-5"><a href="order-form.html">Add {{$worker_type}}</a></li>
                            </h2>

                        </ul>
                    </div>
                    <div class="das_frm_panel ">
                        <form action="{{ route('add_worker') }}" method="post" enctype="multipart/form-data" >
                            {{ csrf_field() }}
                            <div class="das_frm_bx mt-5">
                                <div class="frm_inp_body">
                                    <div class="row">

                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                            <div class="input_bx">
                                                <span>User Name</span>
                                                <input type="text" placeholder="{{$worker_type}} Name" name="name" required>
                                            </div>
                                        </div>

                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                            <div class="input_bx">
                                                <span>User Phone</span>
                                                <input type="number" placeholder="{{$worker_type}} Phone" name="phone" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                            <div class="input_bx">
                                                <span>Alternative Phone</span>
                                                <input type="number" placeholder="{{$worker_type}} Phone" name="alt_number" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                            <div class="input_bx">
                                                <span>Place</span>
                                                <input type="text" placeholder="{{$worker_type}} Place" name="place" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                            <div class="input_bx">
                                                <span>Aadhaar</span>
                                                <input type="number" placeholder="{{$worker_type}} Adhar" name="adhar" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                            <div class="input_bx">
                                                <span>Username</span>
                                                <input type="text" placeholder="Working username" name="email" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                            <div class="input_bx">
                                                <span>password</span>
                                                <input type="text" placeholder="Password" name="pass" required>
                                            </div>
                                        </div>
                                        @if (login_role() != 3)
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                            <div class="input_bx">
                                                <span>Role</span>
                                                <select name="role" id="role_check_id" onchange="is_worker()">
                                                    {{-- <option value="1">Admin</option> --}}
                                                    @if ($worker_type_id == 2)<option value="2">Worker</option>@endif
                                                    @if ($worker_type_id == 3)<option value="3">Management </option>@endif
                                                </select>
                                            </div>
                                        </div>
                                        @if ($worker_type_id == 2)
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12" id="manager_id_div" >
                                            <div class="input_bx">
                                                <span>Select Manager</span>
                                                <select name="manager_id" required id="manager_id_dropdown">
                                                    <option value="">Select manager</option>
                                                    @foreach ($manager_list as $item)
                                                        <option style="text-transform: capitalize" value="{{$item->id}}">{{$item->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        @endif
                                        @if ($worker_type_id == 3)
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mt-4" style='display:none'>
                                            <div class="">
                                                <span class="text-danger">If the {{$worker_type}} is part of the management team, check box for permissions.</span>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="1" id="checkbox2" name="permissions">
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
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                                            <div class="uplodimg">
                                                <span class="uplode_spa"><small>{{$worker_type}} Image</small></span>
                                                <div class="uplodimgfil">
                                                    <input required type="file" name="worker_iamge" id="file-1"
                                                        class="inputfile inputfile-1"
                                                        data-multiple-caption="{count} files selected" >
                                                    <label for="file-1">Drag and Drop or <b>Browse</b> to upload
                                                        <em><img src="{{url('public')}}/assets/images/gall.png"
                                                                alt=""></em>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                                            <div class="uplodimg">
                                                <span class="uplode_spa"><small>Identity Document</small></span>
                                                <div class="uplodimgfil">
                                                    <input  type="file" name="identity_doc" id="file-2" class="identity_doc inputfile-1">
                                                    <label for="file-2">Drag and Drop or <b>Browse</b> to upload
                                                        <em><img src="{{url('public')}}/assets/images/gall.png"
                                                                alt=""></em>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        @if ($worker_type_id == 2)
                                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mt-5">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="1" id="checkbox1" name="filling">
                                                <label class="form-check-label" for="checkbox1">
                                                  Filling
                                                </label>
                                              </div>
                                              
                                              <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="1" id="checkbox2" name="mounting">
                                                <label class="form-check-label" for="checkbox2">
                                                  Mounting
                                                </label>
                                              </div>
                                              
                                              <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="1" id="checkbox3" name="setting">
                                                <label class="form-check-label" for="checkbox3">
                                                  Setting
                                                </label>
                                              </div>
                                              
                                              <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="1" id="checkbox4" name="finalpolish">
                                                <label class="form-check-label" for="checkbox4">
                                                  Final Polish
                                                </label>
                                              </div>
                                              
                                        </div>
                                        @endif
                                        <div class=" cc_top_btn">
                                            <!--onclick="image_upload_check()"-->
                                            <button  style="border:none;margin-top:123px;height:53px;text-align:center;"
                                                type="submit" class="btn_cc mx-5">Submit
                                                <em>
                                                    <img src="{{url('public')}}/assets/images/btn_icon.png" alt=""
                                                        class="mt-2">
                                                </em>
                                            </button>
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
