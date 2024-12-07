@include('admin.main.header')

<div class="mrg_tp"></div>
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
</style>
<div class="dashboard_min">
    <div class="container-fluid">
        <div class="dashboard_panel">
        <div class="">
            <div class="row mb-3">
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <div class="top_right" style="float: right;">
                        <div class="tile_a">
                            <span>Working By :</span>
                        </div>
                        <div class="woker_name">
                            <span>Worker Name <img src="http://localhost/jewellery/public/uploads/1677326235images.jpg" alt=""> </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="das_right_inr">
                <div class="das_frm_panel">
                    <div class="row">
                        <div class="col-md-3">
                            <div>
                                <span>Order Id : 102245</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div>
                                <div>
                                    <span>Client Name : Rohn</span>
                                </div>
                                <div>
                                    <span>Size : 24</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div>
                                <div>
                                    <span>Product : Ring</span>
                                </div>
                                <div>
                                    <span>Colour : Yellow</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div>
                                <div>
                                    <span>Metal  Karat : 24K</span>
                                </div>
                                <div>
                                    <span>CAD/HandMade : </span>
                                </div>
                            </div>
                            <div style="position: relative;">
                                <div>
                                    {{-- <span>  </span> --}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="table_con">
                            <div class="table-responsive-sm"> 
                                <table class="table table-bordered text-center">
                                    <thead>
                                      <tr>
                                        <th scope="col">Particulars</th>
                                        <th scope="col">Casting</th>
                                        <th scope="col" colspan="2">Filing</th>
                                        <th scope="col" colspan="2">Buffing</th>
                                        <th scope="col" colspan="2">Setting</th>
                                        <th scope="col" colspan="2">Setting</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td></td>
                                        <td>Actual</td>
                                        <td>Actual</td>
                                        <td>Re-assigned</td>
                                        <td>Actual</td>
                                        <td>Re-assigned</td>
                                        <td>Actual</td>
                                        <td>Re-assigned</td>
                                        <td>Actual</td>
                                        <td>Re-assigned</td>
                                      </tr>
                                      <tr>
                                        <td>Metal Issue</td>
                                        <td>00.00</td>
                                        <td>00.00</td>
                                        <td>00.00</td>
                                        <td>00.00</td>
                                        <td>00.00</td>
                                        <td>00.00</td>
                                        <td>00.00</td>
                                        <td>00.00</td>
                                        <td>00.00</td>
                                      </tr>
                                      <tr>
                                        <td>Metal Received</td>
                                        <td>00.00</td>
                                        <td>00.00</td>
                                        <td>00.00</td>
                                        <td>00.00</td>
                                        <td>00.00</td>
                                        <td>00.00</td>
                                        <td>00.00</td>
                                        <td>00.00</td>
                                        <td>00.00</td>
                                      </tr>
                                      <tr>
                                        <td>Wastage</td>
                                        <td>00.00</td>
                                        <td>00.00</td>
                                        <td>00.00</td>
                                        <td>00.00</td>
                                        <td>00.00</td>
                                        <td>00.00</td>
                                        <td>00.00</td>
                                        <td>00.00</td>
                                        <td>00.00</td>
                                      </tr>
                                    </tbody>
                                  </table>
                            </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div>
                                <div class="down_sts_text">
                                    <span>STATUS</span>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-success btn_ex_css">Completed</button>
                                </div>
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
