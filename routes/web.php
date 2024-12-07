<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




// Auth Route


Route::get('/clear-cache', function () {
    try {
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        return 'Cache cleared successfully!';
    } catch (\Exception $e) {
        return 'Failed to clear cache: ' . $e->getMessage();
    }
});



Route::post('delete_manager',[AdminController::class,'delete_manager']);
Route::post('login',[AdminController::class,'login'])->name('login');
Route::get('password_change_admin',[AdminController::class,'password_change_admin']);
Route::post('password_change_admin_update',[AdminController::class,'password_change_admin_update']);
Route::post('manager_permission',[AdminController::class,'manager_permission']);
Route::get('logout',[AdminController::class,'logout'])->name('logout');
Route::get('manager_settings',[AdminController::class,'manager_settings']);

Route::get('josn_false',[AdminController::class,'josn_false']);
Route::group(['middleware'=>['CustomAuth']],function(){
    Route::get('/',function (){
        return view('index');
    })->name('index');

// Dashboard Route Here
Route::get('dashboardt',[AdminController::class,'dashboardt'])->name('dashboardt');
Route::get('dashboard',[AdminController::class,'dashboard'])->name('dashboard');
// ORDER ROUTES HERE
Route::get('worker_order_excel',[AdminController::class,'worker_order_excel'])->name('worker_order_excel');
Route::get('order_form',[AdminController::class,'order_form'])->name('order_form');
Route::post('store_order',[AdminController::class,'store_order'])->name('store_order');
Route::get('order_history',[AdminController::class,'order_history'])->name('order_history');
// Route::get('/order-history', [AdminController::class, 'order_history'])->name('order_history');
Route::get('order_preview',[AdminController::class,'order_preview'])->name('order_preview');
Route::get('orders',[AdminController::class,'orders']);
Route::get('order_item_details/{id}',[AdminController::class,'order_item_details']);
Route::get('repair_item_details/{id}',[AdminController::class,'repair_item_details']);
Route::get('updateorderitemstatus',[AdminController::class,'updateorderitemstatus']);
Route::get('view_order_form/{id}',[AdminController::class,'view_order_form'])->name('view_order_form');
Route::get('edit_order_form/{id}',[AdminController::class,'edit_order_form'])->name('edit_order_form');
Route::get('delete_product_image/{id}',[AdminController::class,'delete_product_image'])->name('delete_product_image');
Route::get('delete_order_form/{id}',[AdminController::class,'delete_order_form'])->name('delete_order_form');
Route::post('update_order_form',[AdminController::class,'update_order_form'])->name('update_order_form');
Route::get('order_status/{id}',[AdminController::class,'order_status'])->name('order_status');
Route::post('update_status',[AdminController::class,'update_status'])->name('update_status');


// Route::get('management_permission',[AdminController::class,'management_permission'])->name('management_permission');
// Worker Route Here
Route::get('worker',[AdminController::class,'worker'])->name('worker');
Route::get('manager',[AdminController::class,'manager'])->name('manager');
Route::post('worker_forward_form',[AdminController::class,'worker_forward_form']);
Route::get('show_workers_orders/{id}',[AdminController::class,'show_workers_orders'])->name('show_workers_orders');
Route::post('add_worker',[AdminController::class,'add_worker'])->name('add_worker');
Route::get('worker_form',[AdminController::class,'worker_form'])->name('worker_form');
Route::get('delete_worker/{id}',[AdminController::class,'delete_worker'])->name('delete_worker');
Route::get('edit_worker/{id}',[AdminController::class,'edit_worker'])->name('edit_worker');
Route::post('update_worker_id}',[AdminController::class,'update_worker_id'])->name('update_worker_id');

// worker table
Route::get('workers_order/{id}',[AdminController::class,'workers_order'])->name('workers_order');
Route::get('workers_history/{workerid}/{ordertype}',[AdminController::class,'workers_history']);
Route::get('workers_history_all/{ordertype}',[AdminController::class,'workers_history_all']);
Route::post('return_dust_form',[AdminController::class,'return_dust_form']);
Route::post('dust_return_form',[AdminController::class,'dust_return_form']);
Route::get('view_history',[AdminController::class,'view_history']);
Route::get('delete_return_dust/{id}',[AdminController::class,'delete_return_dust']);
Route::get('dust_table_excel_download',[AdminController::class,'dust_table_excel_download']);




// Customers Routes Here
Route::get('customers',[AdminController::class,'customers'])->name('customers');
Route::get('customers_phone_delete/{id}',[AdminController::class,'customers_phone_delete'])->name('customers_phone_delete');
Route::post('add_morephone_number',[AdminController::class,'add_morephone_number'])->name('add_morephone_number');

Route::post('add_customer',[AdminController::class,'add_customer'])->name('add_customer');
Route::get('customer_form',[AdminController::class,'customer_form'])->name('customer_form');
Route::get('delete_customer/{id}',[AdminController::class,'delete_customer'])->name('delete_customer');
Route::get('edit_customer/{id}',[AdminController::class,'edit_customer'])->name('edit_customer');
Route::post('/fetchcustomer',[AdminController::class,'fetchcustomer'])->name('fetchcustomer');
Route::get('customer_orders/{id}',[AdminController::class,'customer_orders']);
Route::get('print_workcomplete_pdf/{id}/{gnw}/{ggw}',[AdminController::class,'print_workcomplete_pdf']);
Route::get('customer_orders_excel/{id}',[AdminController::class,'customer_orders_excel']);
Route::get('customerwise_orders',[AdminController::class,'customerwise_orders']);
Route::post('update_is_diamond',[AdminController::class,'update_is_diamond']);
Route::post('update_mc_var',[AdminController::class,'update_mc_var']);
Route::post('update_customer_payment',[AdminController::class,'update_customer_payment']);
Route::post('update_customer_cashpayment',[AdminController::class,'update_customer_cashpayment']);
Route::post('customer_charges_payment',[AdminController::class,'customer_charges_payment']);
Route::post('update_customer_initial_balance',[AdminController::class,'update_customer_initial_balance']);


// repair
Route::get('repair_index',[AdminController::class,'repair_index'])->name('repair_index');
Route::get('repair_list',[AdminController::class,'repair_list'])->name('repair_list');
Route::post('repair_store',[AdminController::class,'repair_store'])->name('repair_store');
Route::post('repair_forward',[AdminController::class,'repair_forward']);
Route::get('repair_forward_history',[AdminController::class,'repair_forward_history']);
Route::post('repair_process_store',[AdminController::class,'repair_process_store']);
Route::post('add_repair_chrg',[AdminController::class,'add_repair_chrg']);
Route::get('repair_log',[AdminController::class,'repair_log']);
// reapair FILLING
Route::get('repair_filling_form',[AdminController::class,'repair_filling_form'])->name('repair_filling_form');
Route::get('repair_filling_form/{id}',[AdminController::class,'repairfillingData'])->name('view_repair_filling_form');
Route::get('repair_filling_form_work/{id}/{workid}',[AdminController::class,'repair_filling_form_work']);
Route::post('update_repair_filling_form/',[AdminController::class,'update_repair_filling_form'])->name('update_repair_filling_form');
// reapair SETTING
Route::get('repair_setting',[AdminController::class,'repair_setting'])->name('repair_setting');
Route::get('repair_Setting_Form/{id}',[AdminController::class,'repair_Setting_Form'])->name('repair_Setting_Form');
Route::get('repair_setting_Form_work/{id}/{workid}',[AdminController::class,'repair_setting_Form_work']);
Route::post('update_repair_setting',[AdminController::class,'update_repair_setting'])->name('update_repair_setting');
// reapairFINAL POLISH
Route::get('repair_final_polish',[AdminController::class,'repair_final_polish'])->name('repair_final_polish');
Route::get('repair_final_Form/{id}',[AdminController::class,'repair_final_Form'])->name('repair_final_Form');
Route::get('repair_final_Form_work/{id}/{workid}',[AdminController::class,'repair_final_Form_work']);
Route::post('update_repair_final_polish',[AdminController::class,'update_repair_final_polish'])->name('update_repair_final_polish');



Route::get('trrep',[AdminController::class,'trrep']);


// FILLING
Route::get('filling_form',[AdminController::class,'filling_form'])->name('filling_form');
Route::get('filling_form/{id}',[AdminController::class,'fillingData'])->name('view_filling_form');
Route::get('filling_form_work/{id}/{workid}',[AdminController::class,'filling_form_work']);
Route::post('update_filling_form/',[AdminController::class,'update_filling_form'])->name('update_filling_form');

// MOUNTING
Route::get('mounting',[AdminController::class,'mounting'])->name('mounting');
Route::get('Mounting_Form/{id}',[AdminController::class,'Mounting_Form'])->name('Mounting_Form');
Route::get('mounting_form_work/{id}/{workid}',[AdminController::class,'mounting_form_work']);
Route::post('update_mounting',[AdminController::class,'update_mounting'])->name('update_mounting');

// SETTING
Route::get('setting',[AdminController::class,'setting'])->name('setting');
Route::get('Setting_Form/{id}',[AdminController::class,'Setting_Form'])->name('Setting_Form');
Route::get('setting_Form_work/{id}/{workid}',[AdminController::class,'setting_Form_work']);
Route::post('update_setting',[AdminController::class,'update_setting'])->name('update_setting');

//FINAL POLISH
Route::get('final_polish',[AdminController::class,'final_polish'])->name('final_polish');
Route::get('final_Form/{id}',[AdminController::class,'final_Form'])->name('final_Form');
Route::get('final_Form_work/{id}/{workid}',[AdminController::class,'final_Form_work']);
Route::post('update_final_polish',[AdminController::class,'update_final_polish'])->name('update_final_polish');

Route::get('pending_gold_payment/{id}',[AdminController::class,'pending_gold_payment']);
Route::get('get_editable_values',[AdminController::class,'get_editable_values']);
Route::post('gold_return_insert',[AdminController::class,'gold_return_insert']);

Route::post('gold_return_insert',[AdminController::class,'gold_return_insert']);

// worker forward
Route::post('forward_order_form',[AdminController::class,'forward_order_form']);
Route::get('get_forward_history',[AdminController::class,'get_forward_history']);
Route::get('karatview',[AdminController::class,'karatview']);

Route::get('gold_transtion/{id}',[AdminController::class,'gold_transtion']);

Route::post('karatupdate',[AdminController::class,'karatupdate']);

Route::get('del_xxx',[AdminController::class,'del_xxx']);
Route::get('client_pdf_download',[AdminController::class,'client_pdf_download']);


Route::get('download-excel',[AdminController::class,'downloadExcel']);


});
