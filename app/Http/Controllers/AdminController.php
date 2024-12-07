<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use session;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use Hash;
use App\Exports\MyExport;
use App\Exports\Filling;
use App\Exports\Mounting;
use App\Exports\Setting;
use App\Exports\Finalpolish;
use App\Exports\CustomerOrders;
use App\Exports\Dustreturntableexcel;
use Carbon\Carbon;

class AdminController extends Controller
{

    public function downloadExcel()
    {
        $data = DB::table('customers')->get();
        return Excel::download(new MyExport($data), 'filename.xlsx');
        return back();
    }
    public function worker_order_excel(Request $req)
    {

        $q = DB::table('order_forward')->orderBy('id', 'DESC')->where('refer_type', $req->order_type)->whereNotNull('update_date');
        if ($req->worker_id) {
            $q = $q->where('worker_id', $req->worker_id);
        }
        $q = $q->get();
        if ($req->order_type == 1) {
            $data = $q;
            return Excel::download(new Filling($data), 'filling_excel.xlsx');
            return back();
        }
        if ($req->order_type == 2) {
            $data = $q;
            return Excel::download(new Mounting($data), 'Mounting_excel.xlsx');
            return back();
        }
        if ($req->order_type == 3) {
            $data = $q;
            return Excel::download(new Setting($data), 'Setting_excel.xlsx');
            return back();
        }
        if ($req->order_type == 4) {
            $data = $q;
            return Excel::download(new Finalpolish($data), 'Finalpolish_excel.xlsx');
            return back();
        }
    }
    public function password_change_admin(Request $req)
    {
        return view('admin.pages.password_change_admin');
    }
    public function manager_settings(Request $req)
    {
        return view('admin.pages.worker.manager_settings');
    }
    public function password_change_admin_update(Request $req)
    {
        $where = array();
        $where['role'] = 1;
        $check = DB::table('worker')->where($where)->first();
        if ($check) {

            if ($req->password == $check->password) {
                $data = array();
                if ($req->username) {
                    $data['email'] = $req->username;
                }
                if ($req->new_password) {
                    $data['password'] = $req->new_password;
                }
                DB::table('worker')->where('id', $check->id)->update($data);
                return back()->with('success', 'Login details change successful');
            } else {
                return back()->with('error', 'Current Password Not Matched');
            }

        } else {
            return back()->with('error', 'Something wrong please logout first !');
        }
    }
    public function manager_permission(Request $req)
    {
        DB::table('manager_per')->where('manager_id', $req->manager_id)->delete();
        $view = $req->input('view');
        $add = $req->input('add');
        $update = $req->input('update');
        $page_name = $req->input('page_name');
        foreach ($req->page_id as $item) {
            $data = array();
            $data['manager_id'] = $req->manager_id;
            $data['page_id'] = $item;
            $data['page_name'] = $page_name[$item];
            $data['add_per'] = isset ($add[$item]) ? $add[$item] : 0;
            $data['view_per'] = isset ($view[$item]) ? $view[$item] : 0;
            $data['update_per'] = isset ($update[$item]) ? $update[$item] : 0;
            DB::table('manager_per')->insert($data);
        }
        return redirect('manager')->with('success', 'Permission updated');
    }
    public function login(Request $req)
    {
        // return 1;
        $where = array();
        $where['email'] = $req->email;
        $where['password'] = $req->password;
        $check = DB::table('worker')->where($where)->first();
        if (empty ($check)) {
            return redirect()->back()->with('error', 'User Not Found!');
        } else {
            if (!empty ($check)) {
                if ($req->password === $check->password) {
                    // session()->flush();
                    $req->session()->put('id', $check->id);
                    $req->session()->put('role', $check->role);
                    DB::table('worker')->where('id', $check->id)->update(['created_date' => date('d-m-Y')]);
                    if ($check->role == 3) {

                        return redirect('worker')->with('success', 'Login Successfully');
                    } else {

                        return redirect()->route('dashboard')->with('success', 'Login Successfully');
                    }
                } else {
                    return redirect()->back()->with('error', 'Password Not Matched');
                }
            }
        }
    }
    public function logout()
    {
        DB::table('worker')->where('id', session()->get('id'))->update(['updateed_date' => date('d-m-Y')]);
        session()->forget(['id']);
        return redirect('/')->with('success', 'Logout Successfully');
    }
    public function index()
    {
        return view('admin.pages.index');
    }
    public function dashboard(Request $req)
    {
        $filter_year = date('Y');
        $filter_type = "yearly";
        $label_monthly = ["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"];
        $label_quarterly = ['Jan-Mar', 'Apr-Jun', 'Jul-Sep', 'Oct-Dec'];
        $label_halfyearly = ['JAN-JUN', 'JUL-DEC'];
        $customer_id = '';
        $worker_id = '';
        $manager_id = '';
        if ($req->customer_id) {
            $customer_id = $req->customer_id;
        }
        if ($req->worker_id) {
            $worker_id = $req->worker_id;
            $order_forward_id = DB::table('order_forward')->where('worker_id', $worker_id)->pluck('id')->toArray();
            $order_forward_id_pending = DB::table('order_forward')->where('worker_id', $worker_id)->where('psts', 1)->pluck('id')->toArray();
            $order_forward_id_complete = DB::table('order_forward')->where('worker_id', $worker_id)->where('psts', 2)->pluck('id')->toArray();

        } elseif ($req->manager_id) {
            $manager_id = $req->manager_id;
            $order_forward_id = DB::table('order_forward')->where('manager_id', $manager_id)->pluck('id')->toArray();
            $order_forward_id_pending = DB::table('order_forward')->where('manager_id', $manager_id)->where('psts', 1)->pluck('id')->toArray();
            $order_forward_id_complete = DB::table('order_forward')->where('manager_id', $manager_id)->where('psts', 2)->pluck('id')->toArray();
        }

        // order chart area start
        $order_query_total = DB::table('orders')->where('is_order', 0);
        if ($customer_id) {
            $order_query_total = $order_query_total->where('client_name', $customer_id);
        }
        if ($worker_id || $manager_id) {

            $order_query_total = $order_query_total->whereIn('id', $order_forward_id);
        }
        $order_query_total = $order_query_total->count();
        $data['total_order'] = $order_query_total;
        // order mothly
        $order_monthlyValues = [];
        for ($month = 1; $month <= 12; $month++) {
            $firstDay = sprintf('' . $filter_year . '%02d01', $month);
            $lastDay = sprintf('' . $filter_year . '%02d31', $month);
            $sum = DB::table('orders')->where('is_order', 0);
            if ($customer_id) {
                $sum = $sum->where('client_name', $customer_id);
            }
            if ($worker_id || $manager_id) {
                $sum = $sum->whereIn('id', $order_forward_id);
            }
            $sum = $sum->whereBetween('order_mindate', [$firstDay, $lastDay]);
            $sum = $sum->count();
            $order_monthlyValues[] = $sum;
        }
        $data['order_monthly'] = html_entity_decode(json_encode($order_monthlyValues));

        // order quterly
        $order_quarterlyValues = [];
        for ($quarter = 1; $quarter <= 4; $quarter++) {
            $firstMonth = ($quarter - 1) * 3 + 1;
            $lastMonth = $quarter * 3;
            $firstDay = sprintf('%04d%02d01', $filter_year, $firstMonth);
            $lastDay = sprintf('%04d%02d31', $filter_year, $lastMonth);
            $sum = DB::table('orders')->where('is_order', 0);
            if ($customer_id) {
                $sum = $sum->where('client_name', $customer_id);
            }
            if ($worker_id || $manager_id) {
                $sum = $sum->whereIn('id', $order_forward_id);
            }
            $sum = $sum->whereBetween('order_mindate', [$firstDay, $lastDay]);
            $sum = $sum->count();
            $order_quarterlyValues[] = $sum;
        }
        $data['order_quarterly'] = html_entity_decode(json_encode($order_quarterlyValues));

        // order half yearly
        $order_halfYearlyValues = [];
        for ($halfYear = 1; $halfYear <= 2; $halfYear++) {
            // Calculate the month range for the current half-year
            $startMonth = ($halfYear == 1) ? 1 : 7;
            $endMonth = ($halfYear == 1) ? 6 : 12;
            $sum = 0;
            for ($month = $startMonth; $month <= $endMonth; $month++) {
                $firstDay = sprintf('' . $filter_year . '%02d01', $month);
                $lastDay = sprintf('' . $filter_year . '%02d31', $month);
                if ($customer_id) {
                    $sum += DB::table('orders')->where('client_name', $customer_id)->where('is_order', 0)->whereBetween('order_mindate', [$firstDay, $lastDay])->count();
                } elseif ($worker_id) {
                    if ($worker_id || $manager_id) {
                        $sum += DB::table('orders')->where('is_order', 0)->whereIn('id', $order_forward_id)->whereBetween('order_mindate', [$firstDay, $lastDay])->count();
                    }
                } else {
                    $sum += DB::table('orders')->where('is_order', 0)->whereBetween('order_mindate', [$firstDay, $lastDay])->count();
                }

            }
            $order_halfYearlyValues[] = $sum;
        }
        $data['order_halfyearly'] = html_entity_decode(json_encode($order_halfYearlyValues));
        // order chart area end

        // order complete  chart area start
        if ($customer_id) {
            $data['total_complete_order'] = DB::table('orders')->where('client_name', $customer_id)->where('is_order', 0)->where('status', 1)->count();
        } elseif ($worker_id || $manager_id) {
            $data['total_complete_order'] = DB::table('orders')->whereIn('id', $order_forward_id_complete)->where('is_order', 0)->count();
        } else {
            $data['total_complete_order'] = DB::table('orders')->where('is_order', 0)->where('status', 1)->count();
        }
        // order mothly
        $order_monthlyValues = [];
        for ($month = 1; $month <= 12; $month++) {
            $firstDay = sprintf('' . $filter_year . '%02d01', $month);
            $lastDay = sprintf('' . $filter_year . '%02d31', $month);
            $sum = DB::table('orders')->where('is_order', 0);
            if ($customer_id) {
                $sum = $sum->where('client_name', $customer_id);
            }
            if ($worker_id || $manager_id) {
                $sum = $sum->whereIn('id', $order_forward_id_complete);
            } else {
                $sum = $sum->where('status', 1);
            }
            $sum = $sum->whereBetween('order_mindate', [$firstDay, $lastDay]);
            $sum = $sum->count();
            $order_monthlyValues[] = $sum;
        }
        $data['order_complete_yearly'] = html_entity_decode(json_encode($order_monthlyValues));

        // order quterly
        $order_quarterlyValues = [];
        for ($quarter = 1; $quarter <= 4; $quarter++) {
            $firstMonth = ($quarter - 1) * 3 + 1;
            $lastMonth = $quarter * 3;
            $firstDay = sprintf('%04d%02d01', $filter_year, $firstMonth);
            $lastDay = sprintf('%04d%02d31', $filter_year, $lastMonth);
            $sum = DB::table('orders')->where('is_order', 0);
            if ($customer_id) {
                $sum = $sum->where('client_name', $customer_id);
            }
            if ($worker_id || $manager_id) {
                $sum = $sum->whereIn('id', $order_forward_id_complete);
            } else {
                $sum = $sum->where('status', 1);
            }
            $sum = $sum->whereBetween('order_mindate', [$firstDay, $lastDay]);
            $sum = $sum->count();
            $order_quarterlyValues[] = $sum;
        }
        $data['order_complete_quarterly'] = html_entity_decode(json_encode($order_quarterlyValues));

        // order half yearly
        $order_halfYearlyValues = [];
        for ($halfYear = 1; $halfYear <= 2; $halfYear++) {
            // Calculate the month range for the current half-year
            $startMonth = ($halfYear == 1) ? 1 : 7;
            $endMonth = ($halfYear == 1) ? 6 : 12;
            $sum = 0;
            for ($month = $startMonth; $month <= $endMonth; $month++) {
                $firstDay = sprintf('' . $filter_year . '%02d01', $month);
                $lastDay = sprintf('' . $filter_year . '%02d31', $month);
                if ($customer_id) {
                    $sum += DB::table('orders')->where('client_name', $customer_id)->where('is_order', 0)->where('status', 1)->whereBetween('order_mindate', [$firstDay, $lastDay])->count();
                } elseif ($worker_id || $manager_id) {
                    $sum += DB::table('orders')->whereIn('id', $order_forward_id_complete)->where('is_order', 0)->whereBetween('order_mindate', [$firstDay, $lastDay])->count();
                } else {
                    $sum += DB::table('orders')->where('is_order', 0)->where('status', 1)->whereBetween('order_mindate', [$firstDay, $lastDay])->count();
                }
            }
            $order_halfYearlyValues[] = $sum;
        }
        $data['order_complete_halfyearly'] = html_entity_decode(json_encode($order_halfYearlyValues));

        //  complete order chart area end

        // order pending  chart area start

        if ($customer_id) {
            $data['total_pending_order'] = DB::table('orders')->where('client_name', $customer_id)->where('is_order', 0)->where('status', 2)->count();
        } elseif ($worker_id || $manager_id) {
            $data['total_pending_order'] = DB::table('orders')->whereIn('id', $order_forward_id_pending)->where('is_order', 0)->count();
        } else {
            $data['total_pending_order'] = DB::table('orders')->where('is_order', 0)->where('status', 2)->count();
        }
        // order mothly
        $order_monthlyValues = [];
        for ($month = 1; $month <= 12; $month++) {
            $firstDay = sprintf('' . $filter_year . '%02d01', $month);
            $lastDay = sprintf('' . $filter_year . '%02d31', $month);
            $sum = DB::table('orders')->where('is_order', 0);
            if ($customer_id) {
                $sum = $sum->where('client_name', $customer_id);
            }
            if ($worker_id || $manager_id) {
                $sum = $sum->whereIn('id', $order_forward_id_pending);
            } else {
                $sum = $sum->where('status', 2);
            }
            $sum = $sum->whereBetween('order_mindate', [$firstDay, $lastDay]);
            $sum = $sum->count();
            $order_monthlyValues[] = $sum;
        }
        $data['order_pending_yearly'] = html_entity_decode(json_encode($order_monthlyValues));

        // order quterly
        $order_quarterlyValues = [];
        for ($quarter = 1; $quarter <= 4; $quarter++) {
            $firstMonth = ($quarter - 1) * 3 + 1;
            $lastMonth = $quarter * 3;
            $firstDay = sprintf('%04d%02d01', $filter_year, $firstMonth);
            $lastDay = sprintf('%04d%02d31', $filter_year, $lastMonth);
            $sum = DB::table('orders')->where('is_order', 0);
            if ($customer_id) {
                $sum = $sum->where('client_name', $customer_id);
            }
            if ($worker_id || $manager_id) {
                $sum = $sum->whereIn('id', $order_forward_id_pending);
            } else {
                $sum = $sum->where('status', 2);
            }
            $sum = $sum->whereBetween('order_mindate', [$firstDay, $lastDay]);
            $sum = $sum->count();
            $order_quarterlyValues[] = $sum;
        }
        $data['order_pending_quarterly'] = html_entity_decode(json_encode($order_quarterlyValues));

        // order half yearly
        $order_halfYearlyValues = [];
        for ($halfYear = 1; $halfYear <= 2; $halfYear++) {
            // Calculate the month range for the current half-year
            $startMonth = ($halfYear == 1) ? 1 : 7;
            $endMonth = ($halfYear == 1) ? 6 : 12;
            $sum = 0;
            for ($month = $startMonth; $month <= $endMonth; $month++) {
                $firstDay = sprintf('' . $filter_year . '%02d01', $month);
                $lastDay = sprintf('' . $filter_year . '%02d31', $month);
                if ($customer_id) {
                    $sum += DB::table('orders')->where('client_name', $customer_id)->where('is_order', 0)->where('status', 2)->whereBetween('order_mindate', [$firstDay, $lastDay])->count();
                } elseif ($worker_id || $manager_id) {
                    $sum += DB::table('orders')->whereIn('id', $order_forward_id_pending)->where('is_order', 0)->whereBetween('order_mindate', [$firstDay, $lastDay])->count();
                } else {
                    $sum += DB::table('orders')->where('is_order', 0)->where('status', 2)->whereBetween('order_mindate', [$firstDay, $lastDay])->count();
                }
            }
            $order_halfYearlyValues[] = $sum;
        }
        $data['order_pending_halfyearly'] = html_entity_decode(json_encode($order_halfYearlyValues));

        //  pending order chart area end

        //   order product count start
        if ($customer_id) {
            $data['total_order_product'] = DB::table('orders')->where('client_name', $customer_id)->where('is_order', 0)->sum('count_total_pice');
        } else {
            $data['total_order_product'] = DB::table('orders')->where('is_order', 0)->sum('count_total_pice');
        }
        // order mothly
        $order_product_monthlyValues = [];
        for ($month = 1; $month <= 12; $month++) {
            $firstDay = sprintf('' . $filter_year . '%02d01', $month);
            $lastDay = sprintf('' . $filter_year . '%02d31', $month);
            $sum = DB::table('orders')->where('is_order', 0);
            if ($customer_id) {
                $sum = $sum->where('client_name', $customer_id);
            }
            $sum = $sum->whereBetween('order_mindate', [$firstDay, $lastDay]);
            $sum = $sum->sum('count_total_pice');
            $order_product_monthlyValues[] = $sum;
        }
        $data['order_product_monthly'] = html_entity_decode(json_encode($order_product_monthlyValues));

        // order quterly
        $order_product_quarterlyValues = [];
        for ($quarter = 1; $quarter <= 4; $quarter++) {
            $firstMonth = ($quarter - 1) * 3 + 1;
            $lastMonth = $quarter * 3;
            $firstDay = sprintf('%04d%02d01', $filter_year, $firstMonth);
            $lastDay = sprintf('%04d%02d31', $filter_year, $lastMonth);
            $sum = DB::table('orders')->where('is_order', 0);
            if ($customer_id) {
                $sum = $sum->where('client_name', $customer_id);
            }
            $sum = $sum->whereBetween('order_mindate', [$firstDay, $lastDay]);
            $sum = $sum->sum('count_total_pice');
            $order_product_quarterlyValues[] = $sum;
        }
        $data['order_product_quarterly'] = html_entity_decode(json_encode($order_product_quarterlyValues));

        // order half yearly
        $order_product_halfYearlyValues = [];
        for ($halfYear = 1; $halfYear <= 2; $halfYear++) {
            // Calculate the month range for the current half-year
            $startMonth = ($halfYear == 1) ? 1 : 7;
            $endMonth = ($halfYear == 1) ? 6 : 12;
            $sum = 0;
            for ($month = $startMonth; $month <= $endMonth; $month++) {
                $firstDay = sprintf('' . $filter_year . '%02d01', $month);
                $lastDay = sprintf('' . $filter_year . '%02d31', $month);
                if ($customer_id) {
                    $sum += DB::table('orders')->where('client_name', $customer_id)->where('is_order', 0)->whereBetween('order_mindate', [$firstDay, $lastDay])->sum('count_total_pice');
                } else {
                    $sum += DB::table('orders')->where('is_order', 0)->whereBetween('order_mindate', [$firstDay, $lastDay])->sum('count_total_pice');
                }
            }
            $order_product_halfYearlyValues[] = $sum;
        }
        $data['order_product_halfyearly'] = html_entity_decode(json_encode($order_product_halfYearlyValues));
        //   order product count end

        //   order product gram count start

        if ($customer_id) {
            $data['total_order_gram'] = DB::table('orders')->where('client_name', $customer_id)->where('is_order', 0)->sum('appx_gram');
        } else {
            $data['total_order_gram'] = DB::table('orders')->where('is_order', 0)->sum('appx_gram');
        }

        // order mothly
        $order_gram_monthlyValues = [];
        for ($month = 1; $month <= 12; $month++) {
            $firstDay = sprintf('' . $filter_year . '%02d01', $month);
            $lastDay = sprintf('' . $filter_year . '%02d31', $month);
            $sum = DB::table('orders')->where('is_order', 0);
            if ($customer_id) {
                $sum = $sum->where('client_name', $customer_id);
            }
            $sum = $sum->whereBetween('order_mindate', [$firstDay, $lastDay]);
            $sum = $sum->sum('appx_gram');
            $order_gram_monthlyValues[] = $sum;
        }
        $data['order_gram_monthly'] = html_entity_decode(json_encode($order_gram_monthlyValues));


        $order_gram_used_monthly = [];
        for ($month = 1; $month <= 12; $month++) {
            $firstDay = sprintf('' . $filter_year . '%02d01', $month);
            $lastDay = sprintf('' . $filter_year . '%02d31', $month);
            $sum = DB::table('order_forward');
            $sum = $sum->whereBetween('mindate', [$firstDay, $lastDay]);
            $sum = $sum->sum('fi_reciv', 'mo_reciv', 'se_reciv', 'fp_reciv');
            $order_gram_used_monthly[] = $sum;
        }
        $data['order_gram_used_monthly'] = html_entity_decode(json_encode($order_gram_used_monthly));

        // order quterly
        $order_gram_quarterlyValues = [];
        for ($quarter = 1; $quarter <= 4; $quarter++) {
            $firstMonth = ($quarter - 1) * 3 + 1;
            $lastMonth = $quarter * 3;
            $firstDay = sprintf('%04d%02d01', $filter_year, $firstMonth);
            $lastDay = sprintf('%04d%02d31', $filter_year, $lastMonth);
            $sum = DB::table('orders')->where('is_order', 0);
            if ($customer_id) {
                $sum = $sum->where('client_name', $customer_id);
            }
            $sum = $sum->whereBetween('order_mindate', [$firstDay, $lastDay]);
            $sum = $sum->sum('appx_gram');
            $order_gram_quarterlyValues[] = $sum;
        }
        $data['order_gram_quarterly'] = html_entity_decode(json_encode($order_gram_quarterlyValues));

        // order half yearly
        $order_gram_halfYearlyValues = [];
        for ($halfYear = 1; $halfYear <= 2; $halfYear++) {
            // Calculate the month range for the current half-year
            $startMonth = ($halfYear == 1) ? 1 : 7;
            $endMonth = ($halfYear == 1) ? 6 : 12;
            $sum = 0;
            for ($month = $startMonth; $month <= $endMonth; $month++) {
                $firstDay = sprintf('' . $filter_year . '%02d01', $month);
                $lastDay = sprintf('' . $filter_year . '%02d31', $month);
                if ($customer_id) {
                    $sum += DB::table('orders')->where('client_name', $customer_id)->where('is_order', 0)->whereBetween('order_mindate', [$firstDay, $lastDay])->sum('appx_gram');
                } else {
                    $sum += DB::table('orders')->where('is_order', 0)->whereBetween('order_mindate', [$firstDay, $lastDay])->sum('appx_gram');
                }
            }
            $order_gram_halfYearlyValues[] = $sum;
        }
        $data['order_gram_halfyearly'] = html_entity_decode(json_encode($order_gram_halfYearlyValues));

        // Step 1: Retrieve the data from the database
        $items = DB::table('order_details');
        if ($customer_id) {
            $items = $items->where('customer_id', $customer_id);
        }
        $items = $items->get();
        $groupedByName = $items->groupBy('product_name');
        $pieceCounts = $groupedByName->map(function ($items) {
            return $items->sum('piece');
        });
        $productNames = $pieceCounts->keys()->all();
        $pieceCountsArray = $pieceCounts->values()->all();

        $data['product_namewise_lable'] = html_entity_decode(json_encode($productNames));
        $data['product_namewise_pice_count'] = html_entity_decode(json_encode($pieceCountsArray));



        $get_customername_in_array = DB::table('customers')->get()->pluck('customer_name')->toArray();
        $get_customer_id_in_array = DB::table('customers')->get()->pluck('id')->toArray();
        $customer_wise_order_array = [];
        foreach ($get_customer_id_in_array as $list) {
            $count = DB::table('orders')->where('is_order', 0)->where('client_name', $list)->count();
            $customer_wise_order_array[] = $count;
        }

        $data['customer_wise_lable'] = html_entity_decode(json_encode($get_customername_in_array));
        $data['customer_wise_pice_count'] = html_entity_decode(json_encode($customer_wise_order_array));






        $data['customet_total'] = DB::table('customers')->count();
        $data['customet_list'] = DB::table('customers')->orderBy('customer_name', 'ASC')->get();
        $data['worker_list'] = DB::table('worker')->orderBy('name', 'ASC')->where('role', 2)->get();
        $data['manager_list'] = DB::table('worker')->orderBy('name', 'ASC')->where('role', 3)->get();
        $data['total_worker'] = DB::table('worker')->where('role', 2)->count();
        $data['total_gram_pending'] = DB::table('order_forward')->sum('fi_reciv', 'se_reciv', 'mo_reciv', 'fp_reciv');
        $data['total_gram_approx'] = DB::table('orders')->sum('appx_gram');
        $data['label_monthly'] = html_entity_decode(json_encode($label_monthly));
        $data['label_quarterly'] = html_entity_decode(json_encode($label_quarterly));
        $data['label_halfyearly'] = html_entity_decode(json_encode($label_halfyearly));
        return view('admin.pages.dashboard.dashboardtwo', $data);
    }
    public function dashboardt(Request $req)
    {
        $data['i'] = 1;
        $orderq = DB::table('order_forward');
        $filter_year = Date('Y');


        $order_query = DB::table('orders')->where('is_order', 0);
        $order_product_q = DB::table('order_details');
        $order_forward_q = DB::table('order_forward');
        $repair_query = DB::table('repair')->where('is_order', 0);

        if ($req->customers_id) {
            $get_order_id_for_customer = DB::table('orders')->where('client_name', $req->customers_id)->pluck('id')->toArray();
            $order_query = $order_query->where('client_name', $req->customers_id);
            $order_product_q = $order_product_q->whereIn('order_id', $get_order_id_for_customer);
            $order_forward_q = $order_forward_q->whereIn('order_id', $get_order_id_for_customer);
            $repair_query = $repair_query->where('client_name', $req->customers_id);
        }

        if ($req->filter_year) {
            $filter_year = $req->filter_year;
        }
        // graph 2
        if ($req->filtertype == "Monthly") {
            $monthlyValues = [];
            for ($month = 1; $month <= 12; $month++) {
                $firstDay = sprintf('' . $filter_year . '%02d01', $month);
                $lastDay = sprintf('' . $filter_year . '%02d31', $month);
                $sum = DB::table('order_forward');
                if ($req->customers_id) {
                    $cusarr = DB::table('orders')->where('client_name', $req->customers_id)->pluck('id')->toArray();
                    $sum = $sum->whereIn('order_id', $cusarr);
                }
                $sum = $sum->whereBetween('mindate', [$firstDay, $lastDay])
                    ->sum('fi_reciv', 'se_reciv', 'mo_reciv', 'fp_reciv');
                $monthlyValues[] = $sum;
            }
            $g2_label = ["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"];
            $data['grap2_lavel'] = html_entity_decode(json_encode($g2_label));
            $data['grap2_val'] = html_entity_decode(json_encode($monthlyValues));
            // graph 2 end
        } else if ($req->filtertype == "Half Yearly") {
            $halfYearlyValues = [];

            for ($halfYear = 1; $halfYear <= 2; $halfYear++) {
                // Calculate the month range for the current half-year
                $startMonth = ($halfYear == 1) ? 1 : 7;
                $endMonth = ($halfYear == 1) ? 6 : 12;

                $sum = 0;
                for ($month = $startMonth; $month <= $endMonth; $month++) {
                    $firstDay = sprintf('' . $filter_year . '%02d01', $month);
                    $lastDay = sprintf('' . $filter_year . '%02d31', $month);

                    $sum += DB::table('order_forward')
                        ->when($req->customers_id, function ($query) use ($req) {
                            $cusarr = DB::table('orders')
                                ->where('client_name', $req->customers_id)
                                ->pluck('id')->toArray();
                            return $query->whereIn('order_id', $cusarr);
                        })
                        ->whereBetween('mindate', [$firstDay, $lastDay])
                        ->sum('fi_reciv', 'se_reciv', 'mo_reciv', 'fp_reciv');
                }

                $halfYearlyValues[] = $sum;
            }
            $g2_label = ["First Half", "Second Half"];
            $data['grap2_lavel'] = html_entity_decode(json_encode($g2_label));
            $data['grap2_val'] = json_encode($halfYearlyValues);
        } else if ($req->filtertype == "Quarterly") {
            $quarterlyValues = [];

            for ($quarter = 1; $quarter <= 4; $quarter++) {
                $firstMonth = ($quarter - 1) * 3 + 1;
                $lastMonth = $quarter * 3;
                $firstDay = sprintf('%04d%02d01', $filter_year, $firstMonth);
                $lastDay = sprintf('%04d%02d31', $filter_year, $lastMonth);
                $sum = DB::table('order_forward');
                if ($req->customers_id) {
                    $cusarr = DB::table('orders')->where('client_name', $req->customers_id)->pluck('id')->toArray();
                    $sum = $sum->whereIn('order_id', $cusarr);
                }
                $sum = $sum->whereBetween('mindate', [$firstDay, $lastDay])
                    ->sum('fi_reciv', 'se_reciv', 'mo_reciv', 'fp_reciv');
                $quarterlyValues[] = $sum;
                $g2_label = ["First Quarter", "Second Quarter", "Third Quarter"];
                $data['grap2_lavel'] = html_entity_decode(json_encode($g2_label));
                $data['grap2_val'] = json_encode($quarterlyValues);
            }
        } else {
            $monthlyValues = [];
            for ($month = 1; $month <= 12; $month++) {
                $firstDay = sprintf('' . $filter_year . '%02d01', $month);
                $lastDay = sprintf('' . $filter_year . '%02d31', $month);
                $sum = DB::table('order_forward');
                if ($req->customers_id) {
                    $cusarr = DB::table('orders')->where('client_name', $req->customers_id)->pluck('id')->toArray();
                    $sum = $sum->whereIn('order_id', $cusarr);
                }
                $sum = $sum->whereBetween('mindate', [$firstDay, $lastDay])
                    ->sum('fi_reciv', 'se_reciv', 'mo_reciv', 'fp_reciv');
                $monthlyValues[] = $sum;
            }
            $g2_label = ["JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"];
            $data['grap2_lavel'] = html_entity_decode(json_encode($g2_label));
            $data['grap2_val'] = html_entity_decode(json_encode($monthlyValues));
            // graph 2 end
        }
        // infobox data

        // order 
        // $order_query = DB::table('orders')->where('is_order',0);

        $total_order = $order_query;
        $data['t_order'] = $total_order->count();

        $total_pending_order = $order_query;
        $data['t_pendint_order'] = $total_pending_order->where('status', '!=', 1)->count();

        $total_complete_order = $order_query;
        $data['t_complete_order'] = $total_complete_order->where('status', 1)->count();

        $t_high_pyority_order = $order_query;
        $data['t_high_pyority_order'] = $t_high_pyority_order->where('status', 2)->where('priority', 1)->count();

        $total_low_pyority_order = $order_query;
        $data['total_low_pyority_order'] = $total_low_pyority_order->where('status', 2)->where('priority', 3)->count();

        $total_medium_pyority_order = $order_query;
        $data['total_medium_pyority_order'] = $total_medium_pyority_order->where('status', 2)->where('priority', 2)->count();


        // $order_product_q = DB::table('order_details');
        $t_order_product = $order_product_q;
        $data['t_order_product'] = $t_order_product->count();
        // end order
        // dipartment  
        // $order_forward_q = DB::table('order_forward');

        $complete_filling = $order_forward_q;
        $data['complete_filling'] = $complete_filling->where('refer_type', 1)->where('psts', 1)->count();

        $pending_filling = $order_forward_q;
        $data['pending_filling'] = $pending_filling->where('refer_type', 1)->where('psts', 2)->count();

        $complete_mounting = $order_forward_q;
        $data['complete_mounting'] = $complete_mounting->where('refer_type', 2)->where('psts', 1)->count();

        $pending_mounting = $order_forward_q;
        $data['pending_mounting'] = $pending_mounting->where('refer_type', 2)->where('psts', 2)->count();

        $complete_setting = $order_forward_q;
        $data['complete_setting'] = $complete_setting->where('refer_type', 3)->where('psts', 1)->count();

        $pending_setting = $order_forward_q;
        $data['pending_setting'] = $pending_setting->where('refer_type', 3)->where('psts', 2)->count();

        $complete_final_polish = $order_forward_q;
        $data['complete_final_polish'] = $complete_final_polish->where('refer_type', 4)->where('psts', 1)->count();

        $pending_final_polish = $order_forward_q;
        $data['pending_final_polish'] = $pending_final_polish->where('refer_type', 4)->where('psts', 2)->count();
        // end dipartment  
        // coustomer
        $coustomer_query = DB::table('customers');

        $total_coustomer = $coustomer_query;
        $data['total_coustomer'] = $total_coustomer->count();
        // end coustomer
        // worker
        $worker_query = DB::table('worker');

        $total_worker = $worker_query;
        $data['total_worker'] = $total_worker->count();
        // end worker
        // repair
        // $repair_query = DB::table('repair')->where('is_order',0);

        $total_repair = $repair_query;
        $data['t_order'] = $total_repair->count();

        $total_repair_pending = $repair_query;
        $data['total_repair_pending'] = $total_repair_pending->where('status', '!=', 2)->count();

        $total_repair_complete = $repair_query;
        $data['total_repair_complete'] = $total_repair_complete->where('status', 2)->count();

        $total_repair_product_q = DB::table('repair_details');
        $total_repair_product = $total_repair_product_q;
        $data['total_repair_product'] = $total_repair_product->count();
        //end  repair
        // gram
        $total_gram_issued = $order_forward_q;
        $data['total_gram_issued'] = $total_gram_issued->sum('gram_issue');

        $total_gram_recived = $order_forward_q;
        $data['total_gram_recived'] = $total_gram_recived->sum('fi_reciv', 'se_reciv', 'mo_reciv', 'fp_reciv');
        // end gram
        $karat_q = DB::table('karrat');
        $get_karat = $karat_q;
        $get_karat = $get_karat->get();
        foreach ($get_karat as $list) {
            $sum_karat_count = DB::table('orders')->where('is_order', 0)->where('filling_carret', $list->manin_id)->count();
            $KaraatValues[] = $sum_karat_count;
            $KaraatValueslabel[] = $list->name . ' = ' . $sum_karat_count;
        }
        $data['karrat_val'] = html_entity_decode(json_encode($KaraatValues));
        $data['karrat_lable'] = $KaraatValueslabel;

        $customemr_list = $coustomer_query;
        foreach ($customemr_list->get() as $list) {
            $sum_cusorder_count = DB::table('orders')->where('is_order', 0)->where('client_name', $list->id)->count();
            $cusorderValues[] = $sum_cusorder_count;
            $cusorderValueslabel[] = $list->nickname . ':' . $sum_cusorder_count;
        }
        $data['customer_order_val'] = html_entity_decode(json_encode($cusorderValues));
        $data['customer_order_lable'] = $cusorderValueslabel;


        return view('admin.pages.dashboard.dashboard', $data);
    }
    public function order_form()
    {
        return view('admin.pages.order.order_form');
    }

    public function delete_order_form($id)
    {
        DB::table('orders')->where('id', $id)->delete();
        DB::table('order_image')->where('orderid', $id)->delete();
        DB::table('order_forward')->where('order_id', $id)->delete();
        DB::table('order_details')->where('order_id', $id)->delete();
        return redirect()->back()->with('success', 'Order Deleted Successfull');
    }
    public function update_order_form(Request $req)
    {
        // $req->edit_id
        $my_qunic_id = "";
        $worker_name = "";
        $qunic_product_name = "";
        $insert = array();
        $insert['client_name'] = $req->cname;
        $insert['role_id'] = $req->cname;
        //  $insert['ofnumber'] = $unique_id;
        //  $insert['worker_id'] = $req->worker_id;
        $of_number = get_slno_orderform();
        $insert['status'] = 2;
        $insert['ofnumber'] = $of_number;
        $insert['date'] = $req->date;
        $insert['order_mindate'] = get_min_date($req->date);
        $insert['delivery_date'] = $req->deliverydate;
        $insert['delivery_mindate'] = get_min_date($req->deliverydate);
        $insert['mcolor'] = $req->metalcolor;
        $insert['appx_gram'] = $req->appx_weight;
        $insert['priority'] = $req->priority;
        $insert['delivery_priority'] = $req->delivery_priority;
        $insert['is_order'] = 0;
        $insert['manager_id'] = login_id();
        if ($req->main_karat) {
            $insert['filling_carret'] = $req->main_karat;
        }
        $insert['fi_issue'] = $req->appx_weight;
        $insert['comments'] = $req->comment;

        //   if(empty($req->img)){
        //   return redirect()->back()->with('error','Please Select Image');
        //   }
        DB::table('orders')->where('id', $req->edit_id)->update($insert);
        $lastid = $req->edit_id;
        $get_worker_details = DB::table('customers')->where('id', $req->cname)->first();
        if ($get_worker_details) {
            $worker_name = $get_worker_details->customer_name;
            $customer_nick_name = $get_worker_details->nickname;
        }
        $my_qunic_id .= $of_number . "|" . $customer_nick_name;
        $i = 0;
        if($req->has('img')){

            foreach($req->img as $img){
                if ($img) {
                    $image = time() . $img->getClientOriginalName();
                    $img->move(public_path('uploads'), $image);
                    $ar = array();
                    $ar['name'] = $image;
                    $ar['orderid'] = $lastid;
                    DB::table('order_image')->insert($ar);
                }
            }
        }
        $count_total_pice = 0;
        if ($req->pname) {
            $count_pro_arr = count($req->pname);
            if ($count_pro_arr > 2) {
                $qunic_product_name .= "|Multiple";
            }
            
            DB::table('order_details')->where('order_id', $lastid)->delete();
            foreach ($req->pname as $key => $file) {
                $data = array();
                $data['order_id'] = $lastid;
                $data['product_name'] = $req->pname[$key];
                if ($count_pro_arr <= 2) {
                    $qunic_product_name .= "|" . $req->pname[$key];
                }
                $data['size'] = $req->size[$key];
                $data['inches'] = $req->inches[$key];
                $data['piece'] = $req->piece[$key];
                $data['client_order_no'] = $req->client_order_no[$key];
                $data['mcolor'] = $req->mcolor[$key];
                $data['appxgram'] = $req->apxgram[$key];
                $data['customer_id'] = $req->cname;
                DB::table('order_details')->insert($data);
                $count_total_pice = $count_total_pice + $req->piece[$key];
                $i++;
            }
        }
        $my_qunic_id .= $qunic_product_name;
        DB::table('orders')->where('id', $lastid)->update(['unique_id' => $my_qunic_id, 'is_multiple' => $i, 'count_total_pice' => $count_total_pice]);
        return redirect()->back()->with('success', 'Order Updated Successfull');
    }
    public function store_order(Request $req)
    {
        
        if (!$req->hasFile('img')) {
            return redirect()->back()->with('error', 'Please Select Image');
        }
        // $unique_id = uniqid('', true);

        // $exists = DB::table('orders')->where('ofnumber', $unique_id)->exists();

        // while ($exists) {
        //     $unique_id = uniqid('', true);
        //     $exists = DB::table('orders')->where('ofnumber', $unique_id)->exists();
        // }
        $my_qunic_id = "";
        $worker_name = "";
        $insert = array();
        $insert['client_name'] = $req->cname;
        $insert['role_id'] = $req->cname;
        //  $insert['ofnumber'] = $unique_id;
        //  $insert['worker_id'] = $req->worker_id;
        $of_number = get_slno_orderform();
        $insert['status'] = 2;
        $insert['ofnumber'] = $of_number;
        $insert['date'] = $req->date;
        $insert['order_mindate'] = get_min_date($req->date);
        $insert['delivery_date'] = $req->deliverydate;
        $insert['delivery_priority'] = $req->delivery_priority;
        $insert['delivery_mindate'] = get_min_date($req->deliverydate);
        $insert['mcolor'] = $req->metalcolor;
        $insert['appx_gram'] = $req->appx_weight;
        $insert['priority'] = $req->priority;
        $insert['is_order'] = 0;
        $insert['manager_id'] = login_id();
        if ($req->main_karat) {
            $insert['filling_carret'] = $req->main_karat;
        }
        $insert['fi_issue'] = $req->appx_weight;
        $insert['comments'] = $req->comment;

        if (empty ($req->img)) {
            return redirect()->back()->with('error', 'Please Select Image');
        }
        $lastid = DB::table('orders')->insertGetId($insert);
        $get_worker_details = DB::table('customers')->where('id', $req->cname)->first();
        if ($get_worker_details) {
            $worker_name = $get_worker_details->customer_name;
            $customer_nick_name = $get_worker_details->nickname;
        }
        $my_qunic_id .= $of_number . "|" . $customer_nick_name;
        $i = 0;

        foreach($req->img as $img){
            if ($img) {
                $image = time() . $img->getClientOriginalName();
                $img->move(public_path('uploads'), $image);
                $ar = array();
                $ar['name'] = $image;
                $ar['orderid'] = $lastid;
                DB::table('order_image')->insert($ar);
            }
        }
        if ($req->pname) {
            $count_pro_arr = count($req->pname);
            if ($count_pro_arr > 2) {
                $uniqueId = $lastid."|".$customer_nick_name."|Multiple";
            }
            $count_total_pice = 0;
            foreach ($req->pname as $key => $file) {
                $data = array();
                $data['order_id'] = $lastid;
                $data['product_name'] = $file;
                if ($count_pro_arr <= 2) {
                    $uniqueId = $lastid."|".$customer_nick_name."|" .$file;
                }
                $data['size'] = $req->size[$key];
                $data['inches'] = $req->inches[$key];
                $data['piece'] = $req->piece[$key];
                $data['client_order_no'] = $req->client_order_no[$key];
                $data['mcolor'] = $req->mcolor[$key];
                $data['appxgram'] = $req->apxgram[$key];
                $data['customer_id'] = $req->cname;
               
                DB::table('order_details')->insert($data);
                $count_total_pice = $count_total_pice + $req->piece[$key];
                $i++;
            }
        }
        $my_qunic_id = $uniqueId;
        DB::table('orders')->where('id', $lastid)->update(['unique_id' => $my_qunic_id, 'is_multiple' => $i, 'count_total_pice' => $count_total_pice]);
        return redirect()->back()->with('success', 'Order Successfull');

    }
    public function order_history(Request $req)
    {
        $q = DB::table('orders')->where('is_order', 0)->orderBy('id', 'DESC');
        if (login_role() == 3) {
            $q = $q->where('manager_id', login_id());
        }
        if ($req->customer_id) {
            $q = $q->where('client_name', $req->customer_id);
        }
        if ($req->order_status) {
            $reqStatus = $req->order_status;
            if($reqStatus ==3){
                $reqStatus = 2;
            }
            $q = $q->where('status', $reqStatus);
            $data['orderStatus'] = $req->order_status;
        } else {
            $q = $q->where('status', 2);
            $data['orderStatus'] = 0;
        }
       
        if($req->has('date_range')){
            if($req->date_range == 'month'){
                $q = $q->where('created_at', '>=', Carbon::now()->startOfMonth());
            }else if($req->date_range == 'last_month'){

                $startDate = Carbon::now()->startOfMonth()->subMonth()->toDateString();
                $endDate = Carbon::now()->endOfMonth()->subMonth()->toDateString();
                $q = $q->whereBetween('created_at',[$startDate,$endDate]);

            }else if($req->date_range == 'quarterly'){

                $q = $q->where('created_at', '>=', Carbon::now()->firstOfQuarter());

            }else if($req->date_range == 'half_yearly'){

                $q = $q->where('created_at', '>=', Carbon::now()->subMonths(6));

            }else if($req->date_range == 'yearly'){

                $q = $q->where('created_at', '>=', Carbon::now()->subMonths(12));
            }
        }
        if ($req->fdate && $req->tdate) {

            $fdate = date('Y-m-d H:i:s',strtotime($req->fdate));
            $tdate = date('Y-m-d H:i:s',strtotime($req->tdate));
            $q = $q->whereBetween(DB::raw('DATE(created_at)'), [$fdate,$tdate]);
        }
        if ($req->pyority) {
            $q = $q->where('priority', $req->pyority);
        }
        $q = $q->get();
        
        if($req->order_status && $req->order_status == 2){
            
           foreach ($q as $d) {
               $qf_check = DB::table('order_forward')->where('order_id',$d->id)->count();
               if($qf_check == 0){
                   $qid[] = $d->id;
                 }
           } 
            $q = DB::table('orders')->where('is_order', 0)->orderBy('id', 'DESC')->whereIn('id', $qid)->get();
        }
        if($req->order_status && $req->order_status == 3){
            
            foreach ($q as $d) {
                $qf_check = DB::table('order_forward')->where('order_id',$d->id)->count();
                if($qf_check > 0){
                    $qid[] = $d->id;
                  }
            } 
             $q = DB::table('orders')->where('is_order', 0)->orderBy('id', 'DESC')->whereIn('id', $qid)->get();
         }
    
        $data['order'] = $q;
        if (login_role() == 3) {
            $data['worker'] = DB::table('worker')->where('manager_id', login_id())->where('role', 2)->orderBy('name', 'ASC')->get();
            $data['customer'] = DB::table('customers')->where('manager_id', login_id())->orderBy('customer_name', 'ASC')->get();
        } else {
            $data['worker'] = DB::table('worker')->where('role', 2)->orderBy('name', 'ASC')->get();
            $data['customer'] = DB::table('customers')->orderBy('customer_name', 'ASC')->get();
        }
       
        return view('admin.pages.order.order_history', $data);
    }
    public function orders(Request $req)
    {
        $q = DB::table('orders')->where('status', 1)->where('is_order', 0)->orderBy('id', 'DESC');
        if (login_role() == 3) {
            $q = $q->where('manager_id', login_id());
        }
        if ($req->fdate && $req->tdate) {
            $fdate = get_min_date($req->fdate);
            $tdate = get_min_date($req->tdate);
            $q = $q->whereBetween('order_mindate', [$fdate, $tdate]);
        }
        if ($req->pyority) {
            $q = $q->where('priority', $req->pyority);
        }
        $q = $q->get();
        $data['order'] = $q;
        return view('admin.pages.order.orders', $data);
    }
    public function delete_product_image($id)
    {
        DB::table('order_image')->where('id', $id)->delete();
        return back()->with('success', 'Deleted successfully');
    }
    public function edit_order_form($id)
    {
        $where['id'] = $id;
        $order = DB::table('orders')->where($where)->first();
        $order_details = DB::table('order_details')->where('order_id', $id)->get();
        $order_image = DB::table('order_image')->where('orderid', $id)->get();
        $data = compact('order', 'order_details', 'order_image');
        return view('admin.pages.order.edit_order_form', $data);
    }
    public function view_order_form($id)
    {
        $where['id'] = $id;
        $order = DB::table('orders')->where($where)->first();
        $order_details = DB::table('order_details')->where('order_id', $id)->get();
        $order_image = DB::table('order_image')->where('orderid', $id)->get();
        $data = compact('order', 'order_details', 'order_image');
        return view('admin.pages.order.view_order_form', $data);
    }
    public function worker(Request $req)
    {
        $worker_forward = array();
        $q = DB::table('worker')->where('role', 2);
        if ($req->name) {
            $q = $q->where('name', 'LIKE', '%' . $req->name . '%');
        }
        if (login_role() == 3) {
            if (mpc(Session::get('id'), 7, 'add')) {
                $q = $q;
            } else {
                $q = $q->where('manager_id', login_id());
            }
            $q = $q->get();
            $worker = $q;
            $worker_forward = DB::table('worker')->where('role', 3)->get();
        } else {
            $q = $q->get();
            $worker = $q;
            $worker_forward = DB::table('worker')->where('role', 3)->get();
        }
        $worker_type = 2;
        $data = compact('worker', 'worker_forward', 'worker_type');
        return view('admin.pages.worker.worker')->with($data);
    }

    public function delete_manager(Request $req)
    {
        if ($req->new_managet_id == $req->manager_id) {
            return back()->with('error', 'Forward and delete manager must be different !');
        } else {
            $data = array();
            $data['manager_id'] = $req->new_managet_id;
            DB::table('worker')->where('manager_id', $req->manager_id)->update($data);
            DB::table('worker')->where('id', $req->manager_id)->delete();
            return back()->with('success', 'Manager delete successful');
        }
    }
    public function manager(Request $req)
    {
        $worker_forward = array();
        $q = DB::table('worker')->where('role', 3);
        if ($req->name) {
            $q = $q->where('name', 'LIKE', '%' . $req->name . '%');
        }
        if (login_role() == 3) {
            if (mpc(Session::get('id'), 7, 'add')) {
                $q = $q->where('id', '!=', login_id());
                $worker_forward = DB::table('worker')->where('role', 3)->get();
            } else {
                $q = $q->where('manager_id', login_id());
                $worker_forward = DB::table('worker')->where('id', '!=', login_id())->where('role', 3)->get();
            }
            $q = $q->get();
            $worker = $q;
        } else {
            $q = $q->get();
            $worker = $q;
            $worker_forward = DB::table('worker')->where('role', 3)->get();
        }
        $worker_type = 3;
        $data = compact('worker', 'worker_forward', 'worker_type');
        return view('admin.pages.worker.worker')->with($data);
    }
    public function worker_forward_form(Request $req)
    {
        $data = array();
        $where = array();
        $data['manager_id'] = $req->managet_id;
        // $data['updateed_date'] = date('d-m-Y');
        $where['id'] = $req->worker_id;
        DB::table('worker')->where($where)->update($data);
        return back()->with('success', 'Worker Forwared Successful');
    }
    public function show_workers_orders(Request $req, $id)
    {
        $q = DB::table('order_forward')->where('worker_id', $id)->orderBy('id', 'DESC');
        $data['fdate'] = '';
        $data['tdate'] = '';
        $data['worker_name'] = get_worker_name($id);
        if ($req->order_status) {
            $q = $q->where('psts', $req->order_status);
        }
       if(!is_null($req->type)){
            $q = $q->where('refer_type', $req->type);
            $data['type'] = $req->type;
       }
        if ($req->fdate && $req->tdate) {
            $data['fdate'] = $req->fdate;
            $data['tdate'] = $req->tdate;
            $fdate = get_min_date($req->fdate);
            $tdate = get_min_date($req->tdate);
            $q = $q->whereBetween('mindate', [$fdate, $tdate]);
        }
        $data['table_loat'] = $q->get();
        if(!is_null($req->karrat)){
            $data['karet'] = $req->karrat;
        }
        $data['profitOrLoss'] = 0;
        if(count($data['table_loat']) > 0){
            $issue_gram = 0;
            $rec_gram = 0;
            foreach ($data['table_loat'] as $items) {
                $issue_gram += $items->gram_issue;
                $rec_gram += $items->fi_reciv;
               
            }
            $data['profitOrLoss'] =(($rec_gram/$issue_gram)*100)-100;
        }
        
        return view('admin.pages.worker.show_workers_orders')->with($data);
    }
    public function worker_form(Request $req)
    {
        if ($req->worker_type) {
            $data['manager_list'] = DB::table('worker')->where('role', 3)->orderBy('name', 'asc')->get();
            $data['worker_type'] = $req->worker_type;
            $data['worker_type_id'] = $req->worker_type == 'Manager' ? 3 : 2;
            return view('admin.pages.worker.worker_form', $data);
        } else {
            return redirect('worker');
        }

    }
    public function add_worker(Request $req)
    {

        $insert = array();
        // if($req->permissions){
        //     $insert['permissions'] = 1;    
        // }else{
        //     $insert['permissions'] = 0;    
        // }
        $insert['permissions'] = 1;
        $insert['name'] = $req->name;
        $insert['phone'] = $req->phone;
        $insert['alt_number'] = $req->phone;
        $insert['place'] = $req->place;
        $insert['adhar'] = $req->adhar;
        $insert['working_id'] = time();
        $insert['email'] = $req->email;
        $insert['password'] = $req->pass;
        $insert['role'] = $req->role;
        // $insert['updateed_date'] = date('d-m-Y');
        $insert['manager_id'] = ($req->role == 2) ? $req->manager_id : null;
        $insert['filling'] = $req->input('filling', 0);
        $insert['mounting'] = $req->input('mounting', 0);
        $insert['setting'] = $req->input('setting', 0);
        $insert['finalpolish'] = $req->input('finalpolish', 0);
        if (!$req->update_id) {
            if (empty ($req->worker_iamge)) {
                return redirect()->back()->with('error', 'Please Select Image');
            }
        }

        if ($req->file('worker_iamge')) {
            $file = $req->file('worker_iamge');
            $image = time() . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $image);
            $insert['worker_iamge'] = $image;
        }
        if ($req->file('identity_doc')) {
            $file = $req->file('identity_doc');
            $image = time() . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $image);
            $insert['identity_doc'] = $image;
        }

        if ($req->update_id) {
            DB::table('worker')->where('id', $req->update_id)->update($insert);
            return redirect()->route('worker')->with('success', 'Updated successfully');

        } else {
            //   $insert['created_date'] = date('d-m-Y');
            DB::table('worker')->insert($insert);
            return redirect()->route('worker')->with('success', 'Added successfully');
        }
    }
    public function delete_worker($id)
    {
        $where = array();
        $where['id'] = $id;
        DB::table('worker')->where($where)->delete();
        return redirect()->back()->with('success', 'Worker Remove SuccessFully');
    }

    public function edit_worker(Request $req, $id)
    {
        if ($req->permission == 1) {
            $data['manager_id'] = $id;
            $data['permission_pages'] = DB::table('permission_pages')->get();
            return view('admin.pages.worker.permission_page')->with($data);
        } else {
            if (need_access()) {
                return back()->with('error', 'Admin access required for participant changes');
            }
            $where = array();
            $where['id'] = $id;
            $worker = DB::table('worker')->where($where)->first();
            $manager_list = DB::table('worker')->where('role', 3)->orderBy('name', 'asc')->get();
            $data = compact('worker', 'manager_list');
            return view('admin.pages.worker.edit_worker')->with($data);
        }
    }
    public function update_worker_id(Request $req)
    {
        $where = array();
        $update = array();
        $where['id'] = $req->updateid;
        $update['worker_id'] = $req->worker_id;
        DB::table('orders')->where($where)->update($update);
        return redirect()->route('order_history')->with('success', 'Worker Update SuccessFully');

    }
    public function customers()
    {
        if (login_role() == 3) {
            $customer = DB::table('customers')->where('manager_id', login_id())->get();
        } else {
            $customer = DB::table('customers')->get();
        }
        $data = compact('customer');
        return view('admin.pages.customer.customers')->with($data);

    }
    public function customers_phone_delete($id)
    {
        DB::table('customers_contact')->where('id', $id)->delete();
        return back()->with('success', 'Phone number deleted successfully');
    }
    public function add_morephone_number(Request $req)
    {
        $insert = array();
        $insert['customer_id'] = $req->customer_id_input;
        $insert['contact_name'] = $req->contact_name;
        $insert['phone_number'] = $req->phone_number;
        DB::table('customers_contact')->insert($insert);
        return back()->with('success', 'Phone number added successfully');
    }
    public function customer_form()
    {
        $data['manager_list'] = DB::table('worker')->where('role', 3)->orderBy('name', 'asc')->get();
        return view('admin.pages.customer.customer_form', $data);

    }
    public function add_customer(Request $req)
    {

        $insert = array();
        $insert['customer_name'] = $req->cname;
        $insert['nickname'] = $req->nickname;
        $insert['order_id'] = get_slno_coustomer();
        $insert['address'] = $req->address;
        $insert['pan_no'] = $req->panno;
        $insert['gst_no'] = $req->gstno;
        $insert['email'] = $req->email;
        $insert['phone'] = $req->phone;
        $insert['joiningdate'] = $req->joiningdate;
        $insert['aadhar_no'] = $req->adhar;
        $insert['status'] = 1;
        $insert['manager_id'] = $req->manager_id;
        // $insert['dob'] =$req->date;
        // $insert['advance_pay'] =$req->adpay;
        // $insert['balance_amount'] =$req->bamount;
        if (!$req->update_id && empty ($req->customer_image)) {
            return redirect()->back()->with('error', 'Please Select Image');
        }
        if ($req->file('customer_image')) {
            $file = $req->file('customer_image');
            $image_name = time() . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $image_name);
            $insert['customer_image'] = $image_name;
        }

        if ($req->update_id) {

            DB::table('customers')->where('id', $req->update_id)->update($insert);
            return redirect()->route('customers')->with('success', 'Customer update successfully');

        } else {

            DB::table('customers')->insert($insert);
            return redirect()->route('customers')->with('success', 'Customer create successfully');

        }
    }

    public function delete_customer($id)
    {
        $where = array();
        $where['id'] = $id;
        DB::table('customers')->where($where)->delete();
        return redirect()->route('customers')->with('success', 'Customer Remove SuccessFully');

    }
    public function edit_customer($id)
    {
        if (need_access()) {
            return back()->with('error', 'Admin access required for participant changes');
        }
        $where = array();
        $where['id'] = $id;
        $customer = DB::table('customers')->where($where)->first();
        $manager_list = DB::table('worker')->where('role', 3)->orderBy('name', 'asc')->get();
        $data = compact('customer', 'manager_list');
        return view('admin.pages.customer.edit_customer')->with($data);
    }

    public function fetchcustomer(Request $req)
    {
        $data = DB::table('customers')->where('id', $req->cid)->first();
        return $data;
    }

    public function order_status($id)
    {
        $where['id'] = $id;
        $order = DB::table('orders')->where($where)->first();
        $order_details = DB::table('order_details')->where('order_id', $id)->get();
        $data = compact('order', 'order_details');
        return view('admin.pages.order.order_status', $data);
    }

    public function update_status(Request $req)
    {
        $where = array();
        $update = array();
        $where['id'] = $req->updateid;
        $update['status'] = $req->status;
        DB::table('orders')->where($where)->update($update);
        return redirect()->back()->with('success', 'Status Update SuccessFully');

    }
    public function filling_form()
    {
        return view('admin.pages.filling.filling_form');
    }
    public function mounting()
    {
        return view('admin.pages.mounting.mounting');
    }
    public function setting()
    {
        $order = DB::table('orders')->get();
        $data = compact('order');
        return view('admin.pages.setting.setting')->with($data);
    }
    public function final_polish()
    {
        $order = DB::table('orders')->get();
        $data = compact('order');
        return view('admin.pages.polish.final_polish')->with($data);
    }
    public function fillingData($id)
    {
        $where['id'] = $id;
        $role = session()->get('role');
        $userid = session()->get('id');
        if ($role == 2) {
            $get_order_tableid = DB::table('forward_log')->where(['worker_id' => $userid, 'refer_type' => 1])->pluck('order_id')->toArray();
            $order_q = DB::table('orders')->where($where)->whereIn('id', $get_order_tableid);
            if ($order_q->count() > 0) {
                $order = DB::table('orders')->where($where)->first();
            } else {
                return redirect('filling_form');
            }
        } else {
            $order = DB::table('orders')->where($where)->first();
        }
        // $order_details = DB::table('order_details')->where('order_id',$id)->get();
        $data['main_data'] = "";
        $data['order'] = $order;
        $data['order_details'] = DB::table('order_details')->where('order_id', $id)->get();
        $data['order_image'] = DB::table('order_image')->where('orderid', $id)->get();
        $data['list_karat'] = get_karat_list();
        $data['list_stcolor'] = get_stcolor_list();
        $data['list_priority'] = get_priority_list();
        return view('admin.pages.filling.view_filling_form', $data);
    }
    public function filling_form_work($id, $workid)
    {
        $where['id'] = $id;
        $role = session()->get('role');
        $userid = session()->get('id');
        if ($role == 2) {
            $get_order_tableid = DB::table('forward_log')->where(['worker_id' => $userid, 'refer_type' => 1])->pluck('order_id')->toArray();
            $order_q = DB::table('orders')->where($where)->whereIn('id', $get_order_tableid);
            if ($order_q->count() > 0) {
                $order = DB::table('orders')->where($where)->first();
            } else {
                return redirect('filling_form');
            }
        } else {
            $order = DB::table('orders')->where($where)->first();
        }
        // $order_details = DB::table('order_details')->where('order_id',$id)->get();
        $data['order'] = $order;
        $qq = DB::table('order_forward')->where('id', $workid);
        if ($qq->count() > 0) {
            $data['main_data'] = $qq->first();
            $data['order_details'] = DB::table('order_details')->where('order_id', $id)->get();
            $data['order_image'] = DB::table('order_image')->where('orderid', $id)->get();
            $data['list_karat'] = get_karat_list();
            $data['list_stcolor'] = get_stcolor_list();
            $data['list_priority'] = get_priority_list();
            return view('admin.pages.filling.view_filling_form', $data);
        } else {
            return back();
        }
    }
    public function Mounting_Form($id)
    {
        $where['id'] = $id;
        $role = session()->get('role');
        $userid = session()->get('id');
        if ($role == 2) {
            $get_order_tableid = DB::table('forward_log')->where(['worker_id' => $userid, 'refer_type' => 2])->pluck('order_id')->toArray();
            $order_q = DB::table('orders')->where($where)->whereIn('id', $get_order_tableid);
            if ($order_q->count() > 0) {
                $order = DB::table('orders')->where($where)->first();
            } else {
                return redirect('mounting');
            }
        } else {
            $order = DB::table('orders')->where($where)->first();
        }
        // $order_details = DB::table('order_details')->where('order_id',$id)->get();
        $data['main_data'] = "";
        $data['order'] = $order;
        $data['order_details'] = DB::table('order_details')->where('order_id', $id)->get();
        $data['order_image'] = DB::table('order_image')->where('orderid', $id)->get();
        $data['list_karat'] = get_karat_list();
        $data['list_stcolor'] = get_stcolor_list();
        $data['list_priority'] = get_priority_list();
        return view('admin.pages.mounting.view_mounting', $data);
    }
    public function mounting_form_work($id, $workid)
    {
        $where['id'] = $id;
        $role = session()->get('role');
        $userid = session()->get('id');
        if ($role == 2) {
            $get_order_tableid = DB::table('forward_log')->where(['worker_id' => $userid, 'refer_type' => 2])->pluck('order_id')->toArray();
            $order_q = DB::table('orders')->where($where)->whereIn('id', $get_order_tableid);
            if ($order_q->count() > 0) {
                $order = DB::table('orders')->where($where)->first();
            } else {
                return redirect('mounting');
            }
        } else {
            $order = DB::table('orders')->where($where)->first();
        }
        // $order_details = DB::table('order_details')->where('order_id',$id)->get();
        $data['order'] = $order;
        $qq = DB::table('order_forward')->where('id', $workid);
        if ($qq->count() > 0) {
            $data['main_data'] = $qq->first();
            $data['order_details'] = DB::table('order_details')->where('order_id', $id)->get();
            $data['order_image'] = DB::table('order_image')->where('orderid', $id)->get();
            $data['list_karat'] = get_karat_list();
            $data['list_stcolor'] = get_stcolor_list();
            $data['list_priority'] = get_priority_list();
            return view('admin.pages.mounting.view_mounting', $data);
        } else {
            return back();
        }
    }
    public function update_filling_form(Request $req)
    {
        if (need_access()) {
            return back()->with('error', 'Admin access required for participant changes');
        }
        $update = array();
        if ($req->work_id) {
            $update['fi_date'] = date('d-m-Y');
            $update['update_date'] = date('d-m-Y');
            $update['fi_date_min'] = date('Ymd');
            $update['fi_add'] = $req->fi_add;
            $update['fi_reciv'] = $req->fi_reciv;
            $update['fi_return'] = $req->fi_return;
            $update['fi_bal'] = $req->fi_bal;
            $update['psts'] = $req->psts;
            DB::table('order_forward')->where('id', $req->work_id)->update($update);
            if ($req->psts == 1) {
                ins_notification($req->work_id);
            }
            return redirect()->back()->with('success', 'Update Successfully');
        } else {
            return back();
        }
    }
    public function worker_history($id)
    {
        $history = DB::table('orders')->where('worker_id', Session::get('id'))->get();
        $data = compact('history');
        return view('admin.pages.worker.worker_history')->with($data);
    }
    public function workers_order(Request $req)
    {
        $history = DB::table('orders')->where('worker_id', Session::get('id'))->get();
        $data = compact('history');
        return view('admin.pages.worker.workers_order')->with($data);
    }
    public function dust_return_form(Request $req)
    {
        $data = array();
        $data['worker_id'] = $req->customer_id_input;
        $data['name'] = get_worker_name($req->customer_id_input);
        $data['date'] = date('d-m-Y');
        $data['mindate'] = date('Ymd');
        $data['dust'] = $req->available_dust;
        $data['return_dust'] = $req->return_dust;
        DB::table('dust_return_history')->insert($data);
        return back()->with('success', 'Dust return Successful');
    }

    public function delete_return_dust($id)
    {
        DB::table('dust_return_history')->where('id', $id)->delete();
        return back()->with('success', 'Deleted Successfully');
    }

    public function view_history(Request $req)
    {
        $q = DB::table('dust_return_history')->orderBy('id', 'DESC');
        $data['fdate'] = '';
        $data['tdate'] = '';
        if ($req->worker_id) {
            if ($req->fdate && $req->tdate) {
                $data['fdate'] = $req->fdate;
                $data['tdate'] = $req->tdate;
                $fdate = get_min_date($req->fdate);
                $tdate = get_min_date($req->tdate);
                $q = $q->whereBetween('mindate', [$fdate, $tdate]);
            }
            $q = $q->where('worker_id', $req->worker_id);
            $q = $q->get();
            if ($req->is_excel == 1) {
                return Excel::download(new Dustreturntableexcel($q), 'dustreturnhistory.xlsx');
                return back();
            } else {
                $data['list'] = $q;
                $data['worker_id'] = $req->worker_id;
                $data['worker_name'] = get_worker_name($req->worker_id);
                return view('admin.pages.worker.view_history')->with($data);
            }

        } else {
            return redirect('worker');
        }
    }
    public function workers_history(Request $req, $workerid, $ordertype)
    {
        $q = DB::table('order_forward')->where('worker_id', $workerid)->orderBy('id', 'DESC')->where('refer_type', $ordertype)->whereNotNull('update_date');
        if ($req->fdate && $req->tdate) {
            $fdate = get_min_date($req->fdate);
            $tdate = get_min_date($req->tdate);
            $cname = '';
            if ($ordertype && $ordertype == 1) {
                $cname = 'fi_date_min';
            } else if ($ordertype && $ordertype == 3) {
                $cname = 'se_date_min';
            } else if ($ordertype && $ordertype == 4) {
                $cname = 'fp_date_min';
            }
            if ($cname) {
                $q = $q->whereBetween($cname, [$fdate, $tdate]);
            }
        }
        $q = $q->get();

        $data['list'] = $q;
        $data['ref_type'] = $ordertype;
        $data['workerid'] = $workerid;
        if (login_role() == 3) {
            $data['worker_list'] = DB::table('worker')->where('manager_id', login_id())->where('role', '!=', 1)->get();
        } else {
            $data['worker_list'] = DB::table('worker')->where('role', '!=', 1)->get();
        }
        return view('admin.pages.worker.workers_history', $data);
    }
    public function workers_history_all(Request $req, $ordertype)
    {
        $q = DB::table('order_forward')->orderBy('id', 'DESC')->where('refer_type', $ordertype)->whereNotNull('update_date');
        $data['worker_list'] = DB::table('worker')->orderBy('name', 'ASC')->where('role', 2)->get();
        if ($req->fdate && $req->tdate) {
            $fdate = get_min_date($req->fdate);
            $tdate = get_min_date($req->tdate);
            $cname = '';
            if ($ordertype && $ordertype == 1) {
                $cname = 'fi_date_min';
            } else if ($ordertype && $ordertype == 3) {
                $cname = 'se_date_min';
            } else if ($ordertype && $ordertype == 4) {
                $cname = 'fp_date_min';
            }
            if ($cname) {
                $q = $q->whereBetween($cname, [$fdate, $tdate]);
            }
        }
        if ($req->worker_id) {
            $q = $q->where('worker_id', $req->worker_id);
        }
        $q = $q->get();
        $data['list'] = $q;
        $data['ref_type'] = $ordertype;
        // sum col
        $data['ref_type'] = $ordertype;


        $data['workerid'] = $req->worker_id;
        return view('admin.pages.worker.workers_history', $data);
    }
    public function update_mounting(Request $req)
    {
        if (need_access()) {
            return back()->with('error', 'Admin access required for participant changes');
        }
        $update = array();
        if ($req->work_id) {
            $update['mo_date'] = date('d-m-Y');
            $update['update_date'] = date('d-m-Y');
            $update['mo_date_min'] = date('Ymd');
            $update['mo_reciv'] = $req->mo_reciv;
            $update['mo_dust'] = $req->mo_dust;
            $update['psts'] = $req->psts;
            DB::table('order_forward')->where('id', $req->work_id)->update($update);
            if ($req->psts == 1) {
                ins_notification($req->work_id);
            }
            return redirect()->back()->with('success', 'Update Successfully');
        } else {
            return back();
        }
    }
    public function Setting_Form($id)
    {
        $where['id'] = $id;
        $role = session()->get('role');
        $userid = session()->get('id');
        if ($role == 2) {
            $get_order_tableid = DB::table('forward_log')->where(['worker_id' => $userid, 'refer_type' => 3])->pluck('order_id')->toArray();
            $order_q = DB::table('orders')->where($where)->whereIn('id', $get_order_tableid);
            if ($order_q->count() > 0) {
                $order = DB::table('orders')->where($where)->first();
            } else {
                return redirect('setting');
            }
        } else {
            $order = DB::table('orders')->where($where)->first();
        }
        // $order_details = DB::table('order_details')->where('order_id',$id)->get();
        $data['main_data'] = "";
        $data['order'] = $order;
        $data['order_details'] = DB::table('order_details')->where('order_id', $id)->get();
        $data['order_image'] = DB::table('order_image')->where('orderid', $id)->get();
        $data['list_karat'] = get_karat_list();
        $data['list_stcolor'] = get_stcolor_list();
        $data['list_priority'] = get_priority_list();
        return view('admin.pages.setting.view_setting', $data);
    }
    public function setting_Form_work($id, $workid)
    {
        $where['id'] = $id;
        $role = session()->get('role');
        $userid = session()->get('id');
        if ($role == 2) {
            $get_order_tableid = DB::table('forward_log')->where(['worker_id' => $userid, 'refer_type' => 3])->pluck('order_id')->toArray();
            $order_q = DB::table('orders')->where($where)->whereIn('id', $get_order_tableid);
            if ($order_q->count() > 0) {
                $order = DB::table('orders')->where($where)->first();
            } else {
                return redirect('setting');
            }
        } else {
            $order = DB::table('orders')->where($where)->first();
        }
        // $order_details = DB::table('order_details')->where('order_id',$id)->get();
        $data['order'] = $order;
        $qq = DB::table('order_forward')->where('id', $workid);
        if ($qq->count() > 0) {
            $data['main_data'] = $qq->first();
            $data['order_details'] = DB::table('order_details')->where('order_id', $id)->get();
            $data['order_image'] = DB::table('order_image')->where('orderid', $id)->get();
            $data['list_karat'] = get_karat_list();
            $data['list_stcolor'] = get_stcolor_list();
            $data['list_priority'] = get_priority_list();
            return view('admin.pages.setting.view_setting', $data);
        } else {
            return back();
        }
    }
    public function final_Form($id)
    {
        $where['id'] = $id;
        $role = session()->get('role');
        $userid = session()->get('id');
        if ($role == 2) {
            $get_order_tableid = DB::table('forward_log')->where(['worker_id' => $userid, 'refer_type' => 4])->pluck('order_id')->toArray();
            $order_q = DB::table('orders')->where($where)->whereIn('id', $get_order_tableid);
            if ($order_q->count() > 0) {
                $order = DB::table('orders')->where($where)->first();
            } else {
                return redirect('final_polish');
            }
        } else {
            $order = DB::table('orders')->where($where)->first();
        }
        // $order_details = DB::table('order_details')->where('order_id',$id)->get();
        $data['main_data'] = "";
        $data['order'] = $order;
        $data['order_details'] = DB::table('order_details')->where('order_id', $id)->get();
        $data['order_image'] = DB::table('order_image')->where('orderid', $id)->get();
        $data['list_karat'] = get_karat_list();
        $data['list_stcolor'] = get_stcolor_list();
        $data['list_priority'] = get_priority_list();
        return view('admin.pages.polish.final_Form', $data);
    }
    public function final_Form_work($id, $workid)
    {
        $where['id'] = $id;
        $role = session()->get('role');
        $userid = session()->get('id');
        if ($role == 2) {
            $get_order_tableid = DB::table('forward_log')->where(['worker_id' => $userid, 'refer_type' => 4])->pluck('order_id')->toArray();
            $order_q = DB::table('orders')->where($where)->whereIn('id', $get_order_tableid);
            if ($order_q->count() > 0) {
                $order = DB::table('orders')->where($where)->first();
            } else {
                return redirect('final_polish');
            }
        } else {
            $order = DB::table('orders')->where($where)->first();
        }
        $data['order'] = $order;
        $qq = DB::table('order_forward')->where('id', $workid);
        if ($qq->count() > 0) {
            $data['main_data'] = $qq->first();
            $data['order_details'] = DB::table('order_details')->where('order_id', $id)->get();
            $data['order_image'] = DB::table('order_image')->where('orderid', $id)->get();
            $data['list_karat'] = get_karat_list();
            $data['list_stcolor'] = get_stcolor_list();
            $data['list_priority'] = get_priority_list();
            return view('admin.pages.polish.final_Form', $data);
        } else {
            return back();
        }
    }
    public function update_setting(Request $req)
    {
        if (need_access()) {
            return back()->with('error', 'Admin access required for participant changes');
        }
        $update = array();
        if ($req->work_id) {
            $update['se_date'] = date('d-m-Y');
            $update['update_date'] = date('d-m-Y');
            $update['se_date_min'] = date('Ymd');
            $update['se_reciv'] = $req->se_reciv;
            $update['se_dust'] = $req->se_dust;
            $update['kd'] = $req->kd;
            $update['kc'] = $req->kc;
            $update['ka'] = $req->ka;
            $update['ktotal'] = $req->ktotal;
            $update['pd'] = $req->pd;
            $update['pc'] = $req->pc;
            $update['pa'] = $req->pa;
            $update['ptotal'] = $req->ptotal;
            $update['gd'] = $req->gd;
            $update['gc'] = $req->gc;
            $update['ga'] = $req->ga;
            $update['gew'] = $req->gew;
            $update['gtotal'] = $req->gtotal;
            $update['se_comm'] = $req->se_comm;
            $update['psts'] = $req->psts;
            DB::table('order_forward')->where('id', $req->work_id)->update($update);
            if ($req->psts == 1) {
                ins_notification($req->work_id);
            }
            return redirect()->back()->with('success', 'Update Successfully');
        } else {
            return back();
        }
    }

    public function update_final_polish(Request $req)
    {
        if (need_access()) {
            return back()->with('error', 'Admin access required for participant changes');
        }
        $update = array();
        if ($req->work_id) {
            $update['fp_date'] = date('d-m-Y');
            $update['update_date'] = date('d-m-Y');
            $update['fp_date_min'] = date('Ymd');
            $update['fp_reciv'] = $req->fp_reciv;
            $update['fp_dust'] = $req->fp_dust;
            $update['psts'] = $req->psts;
            DB::table('order_forward')->where('id', $req->work_id)->update($update);
            $frwdOrder = DB::table('order_forward')->where('id', $req->work_id)->where('refer_type',4)->first();
            $update = array();
            $update['status'] = $req->status;
            $update['psts'] = $req->psts;
            DB::table('orders')->where('id', $frwdOrder->order_id)->update($update);
            if ($req->psts == 1) {
                ins_notification($req->work_id);
            }
            return redirect()->back()->with('success', 'Update Successfully');
        } else {
            return back();
        }
    }
    public function update_is_diamond(Request $req)
    {
        $data = array();
        $data['is_diamond'] = $req->is_diamond;
        DB::table('orders')->where('id', $req->orderid)->update($data);
        return back()->with('success', 'Update successfully');
    }
    public function update_customer_payment(Request $req)
    {

        if (need_access()) {
            return back()->with('error', 'Admin access required for participant changes');
        }
        $data = array();
        $fp_reciv = $req->fp_reciv;
        if ($fp_reciv || $req->pay_amount) {
            // $total = count_karret_per($fp_reciv,$req->payment_karret);
            if (!$req->goldeditid) {
                $data['status'] = 1;
                $data['client_name'] = $req->customerid;
                $data['date'] = date('d-m-Y');
                $data['fp_date_min'] = date('Ymd');
                $data['filling_carret'] = $req->payment_karret;
                $data['is_order'] = 1;
                $data['status'] = 1;
            }
            $data['fp_reciv'] = $fp_reciv;
            $data['payment_karret_comm'] = $req->payment_karret_comm;
            $data['pay_amount'] = $req->pay_amount;
            $data['items'] = "Gold";
            if (!$req->goldeditid) {
                $lastid = DB::table('orders')->insertGetId($data);
                if ($fp_reciv) {
                    $data = array();
                    $data['insertid'] = $lastid;
                    $data['gold'] = $req->fp_reciv;
                    $data['comment'] = $req->payment_karret_comm;
                    $data['karret'] = $req->payment_karret;
                    $data['type'] = 1;
                    $data['date'] = date('d-m-Y');
                    $data['mindate'] = date('Ymd');
                    $data['time'] = time();
                    $data['userid'] = $req->customerid;
                    DB::table('gold_ret_rec')->insert($data);
                }
            } else {
                DB::table('orders')->where('id', $req->goldeditid)->update($data);
                if ($fp_reciv) {
                    $data = array();
                    $data['gold'] = $req->fp_reciv;
                    $data['comment'] = $req->payment_karret_comm;
                    DB::table('gold_ret_rec')->where('insertid', $req->goldeditid)->update($data);
                }
            }
            return back()->with('success', 'Insert successfully');
        } else {
            return back()->with('error', 'Try again !');
        }

    }
    public function customer_charges_payment(Request $req)
    {
        $total_addional_charges = intval(DB::table('orders')->where('client_name', $req->customerid)->where('status', 1)->sum('addional_charges_total'));
        $total_making_charges = intval(DB::table('orders')->where('client_name', $req->customerid)->where('status', 1)->sum('making_charges'));
        $total_addional_charges_given = intval(DB::table('orders')->where('client_name', $req->customerid)->where('is_order', 1)->sum('payment_amount'));
        $count_pending_payment_amount = intval($total_making_charges + $total_addional_charges - $total_addional_charges_given);
        $entered_amount = intval($req->payment_amount);

        if ($entered_amount > $count_pending_payment_amount || $entered_amount < 1) {
            return back()->with('error', 'Incorrect amount entered !');
        }
        $data = array();
        $data['status'] = 1;
        $data['client_name'] = $req->customerid;
        $data['date'] = date('d-m-Y');
        $data['fp_date_min'] = date('Ymd');
        $data['items'] = "Cash payment";
        if ($req->comment) {
            $data['payment_karret_comm'] = 'Make payment Rs.' . $entered_amount . ', ' . $req->comment;
        } else {
            $data['payment_karret_comm'] = 'Make payment Rs.' . $entered_amount;
        }
        $data['is_order'] = 1;
        $data['payment_amount'] = $entered_amount;
        $data['pay_amount'] = $entered_amount;
        DB::table('orders')->insert($data);
        return back()->with('success', 'Insert successfully');
    }
    public function update_customer_cashpayment(Request $req)
    {
        if (need_access()) {
            return back()->with('error', 'Admin access required for participant changes');
        }

        $data = array();
        $fp_reciv = $req->fp_reciv_value;
        if ($fp_reciv || $req->pay_amount) {
            if ($fp_reciv) {
                // $total = count_karret_per($fp_reciv,$req->payment_karret);
                $data['fp_reciv'] = $fp_reciv;
                $data['status'] = 1;
                $data['id_cash'] = $req->id_cash;
                $data['client_name'] = $req->customerid;
                $data['date'] = date('d-m-Y');
                $data['fp_date_min'] = date('Ymd');
                $data['filling_carret'] = $req->payment_karret;
                $data['items'] = "Gold Payment";
                if ($req->payment_karret_comm) {
                    $data['payment_karret_comm'] = 'Gold price value ' . $req->gold_price_value . ', Total amount ' . $req->pay_amount . ', ' . $req->payment_karret_comm;
                } else {
                    $data['payment_karret_comm'] = 'Gold Price value ' . $req->gold_price_value . ', Total amount ' . $req->pay_amount;
                }
                // $data['pay_amount'] = $req->pay_amount;
                $data['is_order'] = 1;
                DB::table('orders')->insert($data);
                return back()->with('success', 'Insert successfully');
            } else {
                return back()->with('error', 'Metal pending is 0');
            }
        } else {
            return back()->with('error', 'Try again !');
        }

    }
    public function update_mc_var(Request $req)
    {

        if (need_access()) {
            return back()->with('error', 'Admin access required for participant changes');
        }
        $data = array();
        if ($req->gold_nw && $req->mc_variable && $req->making_charges) {
            $data['mc_variable'] = $req->mc_variable;
            $data['mc_charges_val'] = $req->gold_nw;
            $data['making_charges'] = $req->making_charges;
        }
        if ($req->addional_value && $req->addional_charges && $req->addional_charges_total) {
            $data['addional_charges_val'] = $req->addional_value;
            $data['addional_charges'] = $req->addional_charges;
            $data['addional_charges_total'] = $req->addional_charges_total;
        }
        if ($req->pure_metal && $req->gold_charges && $req->gold_charges_total) {
            $data['gold_charges_val'] = $req->pure_metal;
            $data['gold_charges'] = $req->gold_charges;
            $data['gold_charges_total'] = $req->gold_charges_total;
        }
        if ($req->gold_nw && $req->mc_variable && $req->making_charges) {
            $data['diamond_charges_val'] = $req->diamond_weight;
            $data['diamond_charges'] = $req->diamond_charges;
            $data['diamond_charges_total'] = $req->diamond_charges_total;
        }
        DB::table('orders')->where('id', $req->orderid)->update($data);
        return back()->with('success', 'Update successfully');
    }
    public function customer_orders_excel($cid)
    {
        $q = DB::table('customers')->where('id', $cid);
        $udata = $q->first();
        $order_q = DB::table('orders')->where('client_name', $udata->id)->where('status', 1)->get();
        $data = array();
        $data['orders_data'] = $order_q;
        $data['total_kd'] = $order_q->sum('kd');
        $data['total_pd'] = $order_q->sum('pd');
        $data['total_gc'] = $order_q->sum('gc');
        $data['total_pc'] = $order_q->sum('pc');
        $data['total_ga'] = $order_q->sum('ga');
        $data['total_pa'] = $order_q->sum('pa');
        $data['total_gew'] = $order_q->sum('gew');
        $data['total_making_charges'] = $order_q->sum('making_charges');
        $data['total_fp_reciv'] = $order_q->sum('fp_reciv');
        $data['cus_data'] = $udata;
        return Excel::download(new CustomerOrders($data), 'customer_orders.xlsx');
        return back();
    }
    public function customer_orders($cid)
    {
        $q = DB::table('customers')->where('id', $cid);
        if ($q->count() == 1) {
            $udata = $q->first();
            $order_q = DB::table('orders')->where('client_name', $udata->id)->where('status', 1)->get();
            $data = array();
            $data['orders_data'] = $order_q;
            $data['total_kd'] = $order_q->sum('kd');
            $data['total_pd'] = $order_q->sum('pd');
            $data['total_gc'] = $order_q->sum('gc');
            $data['total_pc'] = $order_q->sum('pc');
            $data['total_ga'] = $order_q->sum('ga');
            $data['total_pa'] = $order_q->sum('pa');
            $data['total_gew'] = $order_q->sum('gew');
            $data['total_making_charges'] = $order_q->sum('making_charges');
            $data['total_addional_charges'] = $order_q->sum('addional_charges_total');
            $data['total_addional_charges_given'] = DB::table('orders')->where('client_name', $udata->id)->where('is_order', 1)->sum('payment_amount');
            $data['total_fp_reciv'] = $order_q->sum('fp_reciv');
            $data['cus_data'] = $udata;
            return view('admin.pages.customer_orders')->with($data);
        } else {
            return back()->with('error', 'Customer not found');
        }
    }
    public function print_workcomplete_pdf($cid,$gnw,$ggw)
    {
        $order_details = DB::table('orders')->where('status', 1)->where('id', $cid)->first();
        $customer_name = DB::table('customers')->where('id', $order_details->client_name)->select('customer_name')->first();
        $order_product = DB::table('order_details')->where('order_id', $order_details->id)->pluck('product_name');
        $order_product_first = DB::table('order_details')->where('order_id', $order_details->id)->first();
        $product_names = implode(', ', $order_product->toArray());
        $get_metal_color = DB::table('metalcolour')->where('id',$order_product_first->mcolor)->first();
        $order_setting = DB::table('order_forward')->where('refer_type', 3)->where('order_id',$order_details->id)->first();
        
        // dd($order_details);
        $data = [
            'order_data' => $order_details,
            'customer_name' => $customer_name,
            'products' => $product_names,
            'color' => $get_metal_color->name ? $get_metal_color->name : 'N/A',
            'setting' => $order_setting,
            'gold_nw' => $gnw,
            'gold_gw' => $ggw
        ];
        // Render the Blade view to a string
        $htmlContent = View::make('printorder', $data)->render();
    
        // Initialize Dompdf
        $pdf = new Dompdf();
    
        // Load the HTML content
        $pdf->loadHtml($htmlContent);
    
        // Set the paper size and orientation
        $pdf->setPaper('A4', 'portrait');
    
        // Render the PDF
        $pdf->render();
    
        // Download the PDF (the second parameter is the file name)
        return $pdf->stream('order_'.$cid.'.pdf', ['Attachment' => 1]);
    }
    public function customerwise_orders()
    {
        $data = array();
        if (login_role() == 3) {
            $q = DB::table('customers')->where('manager_id', login_id())->get();
        } else {
            $q = DB::table('customers')->get();
        }
        $data['clist'] = $q;
        // $data['order_q'] = DB::table('orders')->where('status',1)->where('is_order',0)->get();
        return view('admin.pages.customerwise_orders')->with($data);
    }
    public function forward_order_form(Request $r)
    {
        $data = array();
        $data['order_id'] = $r->order_id;
        $data['refer_type'] = $r->refer_type;
        $data['worker_id'] = $r->worker_id;
        $data['gram_issue'] = $r->gram_issue;
        $data['no'] = $r->no;
        $data['comments'] = $r->comments;
        $data['date'] = date('d-m-Y');
        $data['mindate'] = date('Ymd');
        $data['psts'] = 2;
        $data['manager_id'] = login_id();
        $lastid = DB::table('order_forward')->insertGetId($data);

        $where = array();
        $where['order_id'] = $r->order_id;
        $where['refer_type'] = $r->refer_type;
        $where['worker_id'] = $r->worker_id;
        $check = DB::table('forward_log')->where($where)->count();
        if ($check == 0) {
            DB::table('forward_log')->insert($where);
        }
        return $lastid;
    }
    public function del_xxx()
    {
        DB::table('order_forward')->truncate();
        DB::table('forward_log')->truncate();
        DB::table('orders')->truncate();
        DB::table('order_details')->truncate();
        DB::table('order_image')->truncate();
        return back();
    }
    public function get_forward_history(Request $req)
    {
        $d = '';
        $d_a = get_forward_history($req->id, $req->type);
        if ($d_a) {
            $d = $d_a;
        }
        $json = ['html' => $d];
        return response()->json($json);
    }
    public function update_customer_initial_balance(Request $r)
    {
        $data = array();
        $data['balance_amount'] = $r->bal;
        $where = array();
        $where['id'] = $r->customerid;
        DB::table('customers')->where($where)->update($data);
        return back()->with('success', 'Updated');
    }
    // repair
    public function repair_index()
    {
        return view('admin.pages.repair.repair_index');
    }
    public function repair_store(Request $req)
    {
        
        if (!$req->hasFile('img')) {
        return redirect()->back()->with('error', 'Image must not be empty');
    }
        $my_qunic_id = "";
        $worker_name = "";
        $qunic_product_name = "";
        $insert = array();
        $insert['client_name'] = $req->cname;
        $insert['status'] = 2;
        $insert['date'] = $req->date;
        $insert['order_mindate'] = get_min_date($req->date);
        $insert['delivery_date'] = $req->deliverydate;
        $insert['delivery_mindate'] = get_min_date($req->deliverydate);
        $insert['appx_gram'] = $req->appx_weight;
        $insert['comments'] = $req->comment;
        $insert['is_order'] = 0;
        $insert['manager_id'] = login_id();
        if (empty ($req->img)) {
            return redirect()->back()->with('error', 'Please Select Image');
        }
      
        $lastid = DB::table('repair')->insertGetId($insert);
        $get_worker_details = DB::table('customers')->where('id', $req->cname)->first();
        if ($get_worker_details) {
            $worker_name = $get_worker_details->customer_name;
            $customer_nick_name = $get_worker_details->nickname;
        }
        $my_qunic_id .= $lastid . "|" . $customer_nick_name;
        $i = 0;
        if ($req->file('img')) {
            $image_array = $req->file('img');
            foreach ($image_array as $photo) {
                $image = time() . $photo->getClientOriginalName();
                $photo->move(public_path('uploads'), $image);
                // $insert['image'] = $image;
                $ar = array();
                $ar['name'] = $image;
                $ar['orderid'] = $lastid;
                DB::table('repair_image')->insert($ar);
            }
        }
        if ($req->pname) {
            $count_pro_arr = count($req->pname);
            if ($count_pro_arr > 2) {
                $qunic_product_name .= "|Multiple";
            }
            foreach ($req->pname as $key => $file) {
                $data = array();
                $data['order_id'] = $lastid;
                $data['product_name'] = $req->pname[$key];
                if ($count_pro_arr <= 2) {
                    $qunic_product_name .= "|" . $req->pname[$key];
                }
                $data['size'] = $req->size[$key];
                $data['inches'] = $req->inches[$key];
                $data['piece'] = $req->piece[$key];
                $data['karat'] = $req->karat[$key];
                $data['mcolor'] = $req->mcolor[$key];
                $data['appxgram'] = $req->apxgram[$key];
                DB::table('repair_details')->insert($data);
                $i++;
            }
        }
        $my_qunic_id .= $qunic_product_name;
        DB::table('repair')->where('id', $lastid)->update(['unique_id' => $my_qunic_id, 'is_multiple' => $i]);
        return redirect()->back()->with('success', 'Order created Successfull');

    }
    public function repair_list()
    {
        if (login_role() == 3) {
            $data['order'] = DB::table('repair')->where('manager_id', login_id())->orderBy('id', 'DESC')->get();
            $data['worker'] = DB::table('worker')->where('manager_id', login_id())->where('role', 2)->orderBy('name', 'ASC')->get();
        } else {

            $data['order'] = DB::table('repair')->orderBy('id', 'DESC')->get();
            $data['worker'] = DB::table('worker')->where('role', 2)->orderBy('name', 'ASC')->get();
        }
        return view('admin.pages.repair.repair_list', $data);
    }
    public function repair_log()
    {
        if (login_role() == 3) {
            $data['order'] = DB::table('repair')->where('manager_id', login_id())->where('status', 1)->orderBy('id', 'DESC')->get();
            $data['worker'] = DB::table('worker')->where('manager_id', login_id())->where('role', 2)->orderBy('name', 'ASC')->get();
        } else {
            $data['order'] = DB::table('repair')->where('status', 1)->orderBy('id', 'DESC')->get();
            $data['worker'] = DB::table('worker')->where('role', 2)->orderBy('name', 'ASC')->get();
        }
        return view('admin.pages.repair.repair_log', $data);
    }
    public function repair_forward_history(Request $req)
    {
        $d = '';
        $d_a = get_repair_forward_history($req->id, $req->type);
        if ($d_a) {
            $d = $d_a;
        }
        $json = ['html' => $d];
        return response()->json($json);
    }
    public function repair_forward(Request $r)
    {
        $data = array();
        $data['order_id'] = $r->order_id;
        $data['refer_type'] = $r->refer_type;
        $data['worker_id'] = $r->worker_id;
        $data['gram_issue'] = $r->gram_issue;
        $data['comments'] = $r->comments;
        $data['psts'] = 2;
        $data['date'] = date('d-m-Y');
        $data['mindate'] = date('Ymd');
        $data['manager_id'] = login_id();
        $lastid = DB::table('repair_forward')->insertGetId($data);

        $where = array();
        $where['order_id'] = $r->order_id;
        $where['refer_type'] = $r->refer_type;
        $where['worker_id'] = $r->worker_id;
        $check = DB::table('repair_for_log')->where($where)->count();
        if ($check == 0) {
            DB::table('repair_for_log')->insert($where);
        }
        // return $lastid;
        return back()->with('success', 'Insert Successfully');
    }
    public function repair_filling_form()
    {
        return view('admin.pages.repair.filling_form');
    }
    public function repairfillingData($id)
    {
        $where['id'] = $id;
        $role = session()->get('role');
        $userid = session()->get('id');
        if ($role == 2) {
            $get_order_tableid = DB::table('repair_for_log')->where(['worker_id' => $userid, 'refer_type' => 1])->pluck('order_id')->toArray();
            $order_q = DB::table('repair')->where($where)->whereIn('id', $get_order_tableid);
            if ($order_q->count() > 0) {
                $order = DB::table('repair')->where($where)->first();
            } else {
                return redirect('repair_filling_form');
            }
        } else {
            $order = DB::table('repair')->where($where)->first();
        }
        // $order_details = DB::table('repair_details')->where('order_id',$id)->get();
        $data['main_data'] = "";
        $data['order'] = $order;
        return view('admin.pages.repair.view_filling_form', $data);
    }

    public function repair_filling_form_work($id, $workid)
    {
        $where['id'] = $id;
        $role = session()->get('role');
        $userid = session()->get('id');
        if ($role == 2) {
            $get_order_tableid = DB::table('repair_for_log')->where(['worker_id' => $userid, 'refer_type' => 1])->pluck('order_id')->toArray();
            $order_q = DB::table('orders')->where($where)->whereIn('id', $get_order_tableid);
            if ($order_q->count() > 0) {
                $order = DB::table('repair')->where($where)->first();
            } else {
                return redirect('repair_filling_form');
            }
        } else {
            $order = DB::table('repair')->where($where)->first();
        }
        // $order_details = DB::table('repair_details')->where('order_id',$id)->get();
        $data['order'] = $order;
        $qq = DB::table('repair_forward')->where('id', $workid);
        if ($qq->count() > 0) {
            $data['main_data'] = $qq->first();
            return view('admin.pages.repair.view_filling_form', $data);
        } else {
            return back();
        }
    }
    public function update_repair_filling_form(Request $req)
    {
        $update = array();
        if ($req->work_id) {
            $update['update_date'] = date('d-m-Y');
            $update['update_min_date'] = date('Ymd');
            $update['isseed_edited'] = $req->fi_issue;
            $update['received'] = $req->fi_reciv;
            $update['comment'] = $req->comment;
            $update['psts'] = $req->psts;
            $update['more_or_less'] = $req->fi_bal;
            DB::table('repair_forward')->where('id', $req->work_id)->update($update);
            return redirect()->back()->with('success', 'Update Successfully');
        } else {
            return back();
        }
    }
    public function repair_setting()
    {
        $order = DB::table('repair')->get();
        $data = compact('order');
        return view('admin.pages.repair.setting')->with($data);
    }
    public function repair_Setting_Form($id)
    {
        $where['id'] = $id;
        $role = session()->get('role');
        $userid = session()->get('id');
        if ($role == 2) {
            $get_order_tableid = DB::table('repair_for_log')->where(['worker_id' => $userid, 'refer_type' => 3])->pluck('order_id')->toArray();
            $order_q = DB::table('repair')->where($where)->whereIn('id', $get_order_tableid);
            if ($order_q->count() > 0) {
                $order = DB::table('repair')->where($where)->first();
            } else {
                return redirect('setting');
            }
        } else {
            $order = DB::table('repair')->where($where)->first();
        }
        // $order_details = DB::table('repair_details')->where('order_id',$id)->get();
        $data['main_data'] = "";
        $data['order'] = $order;
        return view('admin.pages.repair.view_setting', $data);
    }
    public function repair_setting_Form_work($id, $workid)
    {
        $where['id'] = $id;
        $role = session()->get('role');
        $userid = session()->get('id');
        if ($role == 2) {
            $get_order_tableid = DB::table('repair_for_log')->where(['worker_id' => $userid, 'refer_type' => 3])->pluck('order_id')->toArray();
            $order_q = DB::table('repair')->where($where)->whereIn('id', $get_order_tableid);
            if ($order_q->count() > 0) {
                $order = DB::table('repair')->where($where)->first();
            } else {
                return redirect('setting');
            }
        } else {
            $order = DB::table('repair')->where($where)->first();
        }
        // $order_details = DB::table('repair_details')->where('order_id',$id)->get();
        $data['order'] = $order;
        $qq = DB::table('repair_forward')->where('id', $workid);
        if ($qq->count() > 0) {
            $data['main_data'] = $qq->first();
            return view('admin.pages.repair.view_setting', $data);
        } else {
            return back();
        }
    }
    public function update_repair_setting(Request $req)
    {
        $update = array();
        if ($req->work_id) {
            $update['update_date'] = date('d-m-Y');
            $update['update_min_date'] = date('Ymd');
            $update['isseed_edited'] = $req->fi_issue;
            $update['received'] = $req->fi_reciv;
            $update['comment'] = $req->comment;
            $update['psts'] = $req->psts;
            $update['more_or_less'] = $req->fi_bal;
            DB::table('repair_forward')->where('id', $req->work_id)->update($update);
            return redirect()->back()->with('success', 'Update Successfully');
        } else {
            return back();
        }
    }
    public function repair_final_polish()
    {
        $order = DB::table('repair')->get();
        $data = compact('order');
        return view('admin.pages.repair.final_polish')->with($data);
    }
    public function repair_final_Form($id)
    {
        $where['id'] = $id;
        $role = session()->get('role');
        $userid = session()->get('id');
        if ($role == 2) {
            $get_order_tableid = DB::table('repair_for_log')->where(['worker_id' => $userid, 'refer_type' => 4])->pluck('order_id')->toArray();
            $order_q = DB::table('repair')->where($where)->whereIn('id', $get_order_tableid);
            if ($order_q->count() > 0) {
                $order = DB::table('repair')->where($where)->first();
            } else {
                return redirect('final_polish');
            }
        } else {
            $order = DB::table('repair')->where($where)->first();
        }
        // $order_details = DB::table('repair_details')->where('order_id',$id)->get();
        $data['main_data'] = "";
        $data['order'] = $order;
        return view('admin.pages.repair.final_Form', $data);
    }
    public function repair_final_Form_work($id, $workid)
    {
        $where['id'] = $id;
        $role = session()->get('role');
        $userid = session()->get('id');
        if ($role == 2) {
            $get_order_tableid = DB::table('repair_for_log')->where(['worker_id' => $userid, 'refer_type' => 4])->pluck('order_id')->toArray();
            $order_q = DB::table('repair')->where($where)->whereIn('id', $get_order_tableid);
            if ($order_q->count() > 0) {
                $order = DB::table('repair')->where($where)->first();
            } else {
                return redirect('final_polish');
            }
        } else {
            $order = DB::table('repair')->where($where)->first();
        }
        $data['order'] = $order;
        $qq = DB::table('repair_forward')->where('id', $workid);
        if ($qq->count() > 0) {
            $data['main_data'] = $qq->first();
            return view('admin.pages.repair.final_Form', $data);
        } else {
            return back();
        }
    }
    public function update_repair_final_polish(Request $req)
    {
        $update = array();
        if ($req->work_id) {
            $update['update_date'] = date('d-m-Y');
            $update['update_min_date'] = date('Ymd');
            $update['isseed_edited'] = $req->fi_issue;
            $update['received'] = $req->fi_reciv;
            $update['comment'] = $req->comment;
            $update['psts'] = $req->psts;
            $update['more_or_less'] = $req->fi_bal;
            DB::table('repair_forward')->where('id', $req->work_id)->update($update);
            $update = array();
            $update['status'] = $req->status;
            DB::table('repair')->where('id', $req->update_id)->update($update);
            return redirect()->back()->with('success', 'Update Successfully');
        } else {
            return back();
        }
    }
    public function trrep()
    {
        DB::table('repair')->truncate();
        DB::table('repair_details')->truncate();
        DB::table('repair_image')->truncate();
    }
    public function add_repair_chrg(Request $req)
    {
        $data = array();
        if ($req->order_type == 1) {
            $data['addi_chrg'] = $req->charge;
        }
        if ($req->order_type == 2) {
            $data['gold_chrg'] = $req->charge;
        }
        DB::table('repair')->where('id', $req->order_id)->update($data);
        return $req->order_id;
    }
    public function return_dust_form(Request $req)
    {
        $data = array();
        $final = 0;
        $q = DB::table('order_forward')->where('id', $req->order_id)->first();
        if ($req->order_type == 1) {
            $fi_bal = $q->fi_bal;
            $final = $fi_bal - $req->dust_return;
            $data['fi_dust_return'] = $req->dust_return;
            $data['fi_current_bal'] = $final;
            $data['fi_dust_re_date'] = date('d-m-Y');
        }
        if ($req->order_type == 3) {
            $fi_bal = $q->fi_bal;
            $final = $fi_bal - $req->dust_return;
            $data['fi_dust_return'] = $req->dust_return;
            $data['fi_current_bal'] = $final;
            $data['fi_dust_re_date'] = date('d-m-Y');
        }
        if ($req->order_type == 4) {
            $fi_bal = $q->fi_bal;
            $final = $fi_bal - $req->dust_return;
            $data['fi_dust_return'] = $req->dust_return;
            $data['fi_current_bal'] = $final;
            $data['fi_dust_re_date'] = date('d-m-Y');
        }
        $up = DB::table('order_forward')->where('id', $req->order_id)->where('refer_type', $req->order_type)->update($data);
        return $final;
    }
    public function order_item_details($id)
    {
        $wh['order_id'] = $id;
        $data['itemlist'] = DB::table('order_details')->where($wh)->get();
        $data['filing_history'] = DB::table('order_forward')->where('order_id', $id)->where('refer_type', 1)->get();
        $data['mounting_history'] = DB::table('order_forward')->where('order_id', $id)->where('refer_type', 2)->get();
        $data['setting_history'] = DB::table('order_forward')->where('order_id', $id)->where('refer_type', 3)->get();
        $data['finalpolish_history'] = DB::table('order_forward')->where('order_id', $id)->where('refer_type', 4)->get();
        return view('admin.pages.order_item_details', $data);
    }
    public function repair_item_details($id)
    {
        $wh['order_id'] = $id;
        $data['itemlist'] = DB::table('repair_details')->where($wh)->get();
        return view('admin.pages.repair_item_details', $data);
    }
    public function updateorderitemstatus(Request $req)
    {
        $wh['id'] = $req->itemid;
        $ch = DB::table('order_details')->where($wh)->first();
        if ($ch->sts == 1) {
            $data['sts'] = 0;
            DB::table('order_details')->where($wh)->update($data);
            return 0;
        } else {
            $data['sts'] = 1;
            DB::table('order_details')->where($wh)->update($data);
            return 1;
        }
    }
    public function pending_gold_payment($id)
    {
        if (need_access()) {
            return back()->with('error', 'Admin access required for participant changes');
        }
        if ($id) {
            if (Session::get('role') == 1) {
                DB::table('orders')->where('id', $id)->delete();
                return back()->with('success', 'Deleted Successfully');
            }
        }
        return back();
    }
    public function get_editable_values(Request $req)
    {
        $res = array();
        $res['s'] = 0;
        $get = DB::table('orders')->where('id', $req->id)->first();
        if ($get) {
            $res['edit_id'] = $get->id;
            $res['gold_recive'] = $get->fp_reciv;
            $res['cashamount'] = $get->pay_amount;
            $res['comment'] = $get->payment_karret_comm;
            $res['s'] = 1;
        }
        return response()->json($res);
    }
    public function gold_return_insert(Request $req)
    {
        if (need_access()) {
            return back()->with('error', 'Admin access required for participant changes');
        }
        if ($req->gold_return) {

            $data = array();
            $data['status'] = 1;
            $data['client_name'] = $req->userid;
            $data['date'] = date('d-m-Y');
            $data['fp_date_min'] = date('Ymd');
            $data['filling_carret'] = $req->payment_karret;
            $data['is_order'] = 1;
            $data['status'] = 1;
            $data['fp_reciv'] = $req->gold_return;
            $data['payment_karret_comm'] = $req->comment;
            $data['is_return'] = 1;
            $lastid = DB::table('orders')->insertGetId($data);

            $data = array();
            $data['gold'] = $req->gold_return;
            $data['comment'] = $req->comment;
            $data['karret'] = $req->payment_karret;
            $data['type'] = 2;
            $data['date'] = date('d-m-Y');
            $data['mindate'] = date('Ymd');
            $data['time'] = time();
            $data['userid'] = $req->userid;
            $data['insertid'] = $lastid;
            DB::table('gold_ret_rec')->insert($data);
            return back()->with('success', 'Inserted Successfully');
        } else {
            return back()->with('Error', 'Invalid amount');
            die();
        }
    }
    public function client_pdf_download(Request $req)
    {
        $q = DB::table('customers')->get();
        $tb = '';
        $tb .= '<thead>';
        $tb .= '<tr>';
        $tb .= '<th>Sl.no</th>';
        $tb .= '<th>Name</th>';
        if ($req->MakingCharges) {
            $tb .= '<th>Making Charges</th>';
        }
        if ($req->AddionalCharges) {
            $tb .= '<th>Addional Charges</th>';
        }
        if ($req->GoldCharges) {
            $tb .= '<th>Gold Charges</th>';
        }
        if ($req->DiamondCharges) {
            $tb .= '<th>Diamond Charges</th>';
        }
        if ($req->Payment) {
            $tb .= '<th>Payment</th>';
        }
        if ($req->Balance) {
            $tb .= '<th>c</th>';
        }
        if ($req->PureMetalPending) {
            $tb .= '<th>Pure Metal Pending</th>';
        }
        $tb .= '</tr>';
        $tb .= '</thead>';
        $tb .= '<tbody>';
        $j = 1;
        foreach ($q as $i) {
            $is_order_avail = DB::table('orders')->where('client_name', $i->id)->count();
            $count_paymment = count_customer_payment($i->id);
            $qq = DB::table('orders')->where('client_name', $i->id)->where('is_order', 1)->where('status', 1);
            $totalmakingcharges = $qq->sum('making_charges');
            $addional_charges_total = $qq->sum('addional_charges_total');
            $gold_charges_total = $qq->sum('gold_charges_total');
            $diamond_charges_total = $qq->sum('diamond_charges_total');
            $bal = 0;
            $bal = $bal + ($totalmakingcharges + $addional_charges_total + $gold_charges_total + $diamond_charges_total) - $count_paymment;
            $tb .= '<tr>';
            $tb .= '<td>' . $j . '</td>';
            $tb .= '<td>' . $i->customer_name . '</td>';
            if ($req->MakingCharges) {
                $tb .= '<td>' . $totalmakingcharges . '</td>';
            }
            if ($req->AddionalCharges) {
                $tb .= '<td>' . $addional_charges_total . '</td>';
            }
            if ($req->GoldCharges) {
                $tb .= '<td>' . $gold_charges_total . '</td>';
            }
            if ($req->DiamondCharges) {
                $tb .= '<td>' . $diamond_charges_total . '</td>';
            }
            if ($req->Payment) {
                $tb .= '<td>' . $count_paymment . '</td>';
            }
            if ($req->Balance) {
                $tb .= '<td>' . $bal . '</td>';
            }
            if ($req->PureMetalPending) {
                $tb .= '<td>' . get_customer_gold_painding($i->id) . '</td>';
            }
            $tb .= '</tr>';
            $j++;
        }
        $tb .= '</tbody>';
        $table = $tb;
        $pdf = new Dompdf();
        $pdf->loadHTML(view('table', compact('table'))->render());
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();
        return $pdf->stream();
    }
    public function karatview()
    {
        $data['list'] = DB::table('karrat')->orderBy('manin_id', 'ASC')->get();
        return view('admin.pages.karatindex', $data);
    }
    public function karatupdate(Request $req)
    {
        foreach ($req->kmain_id as $key => $k) {
            $data = array();
            $data['name'] = $req->kname[$key];
            $data['manin_id'] = $req->kmain_id[$key];
            $data['per'] = $req->percentage[$key];
            DB::table('karrat')->where('manin_id', $req->kmain_id[$key])->delete();
            DB::table('karrat')->insert($data);
        }
        return back()->with('success', 'Update Successfully');
    }
    public function gold_transtion($uid)
    {
        $data['list'] = DB::table('gold_ret_rec')->where('userid', $uid)->orderBy('id', 'DESC')->get();
        $data['cusid'] = $uid;
        return view('admin.pages.gold_transtion', $data);
    }
    public function josn_false()
    {

        DB::table('customers')->truncate();
        DB::table('repair_image')->truncate();
        DB::table('dust_return_history')->truncate();
        DB::table('forward_log')->truncate();
        DB::table('gold_ret_rec')->truncate();
        DB::table('notification')->truncate();
        DB::table('orders')->truncate();
        DB::table('order_details')->truncate();
        DB::table('order_forward')->truncate();
        DB::table('order_image')->truncate();
        DB::table('repair_details')->truncate();
    }

}
