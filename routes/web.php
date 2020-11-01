<?php

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
/*Route::group(['middleware' => ['auth']], function () {
    Route::get('/', function () {
        return view('home');
    });
});

*/
Route::namespace('webapi')->prefix('webapi123bb')->name('webapi123bb.')->group(function () {
    Route::get('get', 'DashboardAPI@getstats')->name('get');
    Route::get('agentstat', 'DashboardAPI@getAgentsStats')->name('agentstat');
    Route::get('userstat', 'DashboardAPI@getUsersStats')->name('userstat');
    Route::get('sales', 'DashboardAPI@getSales')->name('sales');

    Route::get('sales', 'DashboardAPI@getSalesStat')->name('sales');
    Route::get('purchases', 'DashboardAPI@getPurchasesStat')->name('purchase');
    Route::get('comparisons', 'DashboardAPI@getComparisons')->name('comparisons');
    Route::get('top-agents', 'DashboardAPI@getTopAgentStat')->name('topstat');

});
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');

Auth::routes();
Route::group(['middleware' => ['can:manage-others']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::post('/users/changeMyPassword', 'Admin\UserController@changeMyPassword')->name('users.changeMyPassword');
    Route::post('/users/editagent','Admin\UserController@editAgent')->name('users.editagent');
});
Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function () {

    Route::group(['middleware' => ['can:manage-agents']], function () {
        Route::post('/users/suspend', 'UserController@suspend')->name('users.suspend');
        Route::post('/users/delete', 'UserController@delete')->name('users.delete');
        Route::post('/users/activate', 'UserController@activate')->name('users.activate');
        Route::post('/users/changePassword', 'UserController@changePassword')->name('users.changePassword');
        Route::post('/users/changeParent', 'UserController@changeParent')->name('users.changeParent');
        Route::get('/users/staffAgents', 'UserController@staffAgents')->name('users.staffAgents');
        Route::get('/users/newagents', 'UserController@newAgents')->name('users.newagents');
        Route::get('/users/logins', 'UserController@logins')->name('users.logins');
        Route::get('/users/userlogins/{user}', 'UserController@userLogins')->name('users.userlogins');
        Route::post('/deposits/store2', 'DepositController@store2')->name('deposits.store2');
       
        Route::resource('/users', 'UserController');
        Route::resource('/deposits', 'DepositController', ['except' => ['show']]);

        // Route::post('/parents', 'UserController@parentlist')->name('parentlist');      

    });
    Route::group(['middleware' => ['can:manage-system']], function () {
        Route::resource('/banks', 'BankController', ['except' => ['show']]);
        Route::resource('/conversions', 'ConversionController');
        Route::resource('/userstatuses', 'UserStatusController', ['except' => ['show']]);
        Route::resource('/salestypes', 'SalesTypeController', ['except' => ['show']]);     
    });
    Route::group(['middleware' => ['can:fill-balance']], function () {
        Route::post('/transactions/transfer_staff', 'TransactionController@transferStaff')->name('transactions.transfer_staff');
        Route::post('/transactions/send', 'TransactionController@send')->name('transactions.send');
        Route::get('/transactions/topup', 'TransactionController@send_yimulu')->name('transactions.topup');
     
    });
    Route::group(['middleware' => ['can:manage-transaction']], function () {
        Route::post('/transactions/transfer', 'TransactionController@transfer')->name('transactions.transfer');
        //Route::post('/transactions/send', 'TransactionController@send')->name('transactions.send');
     });
    Route::group(['middleware' => ['can:manage-report']], function () {
        Route::post('/reports/purchase', 'ReportController@purchase')->name('reports.purchase');
        Route::get('/reports/purchase', 'ReportController@purchase')->name('reports.purchase');
        Route::post('/reports/refill', 'ReportController@refill')->name('reports.refill');
        Route::get('/reports/refill', 'ReportController@refill')->name('reports.refill');
        Route::post('/reports/invoice', 'ReportController@mainAgentsRefill')->name('reports.invoice');
        Route::get('/reports/invoice', 'ReportController@mainAgentsRefill')->name('reports.invoice');
        Route::post('/reports/invoiceprint', 'ReportController@invoice')->name('reports.invoiceprint');

        Route::post('/reports/agentrefill', 'ReportController@agentrefill')->name('reports.agentrefill');
        Route::get('/reports/agentrefill', 'ReportController@agentrefill')->name('reports.agentrefill');
        Route::post('/reports/agentsales', 'ReportController@agentsales')->name('reports.agentsales');
        Route::get('/reports/agentsales', 'ReportController@agentsales')->name('reports.agentsales');

       
       // Route::get('/reports/singleagentsales', 'ReportController@agentsales')->name('reports.agentsales');

        Route::post('/reports/collections', 'ReportController@collections')->name('reports.collections');
        Route::get('/reports/collections', 'ReportController@collections')->name('reports.collections');
     
        Route::post('/reports/sales', 'ReportController@sales')->name('reports.sales');
        Route::get('/reports/sales', 'ReportController@sales')->name('reports.sales');
        //Route::post('/reports/invoice', 'ReportController@invoice')->name('reports.invoice');
        //Route::get('/reports/invoice', 'ReportController@invoice')->name('reports.invoice');

    });
    Route::group(['middleware' => ['can:verify-deposits']], function () {
        Route::post('/deposits/approve', 'DepositController@approve')->name('deposits.approve');
        Route::post('/deposits/cancel', 'DepositController@cancel')->name('deposits.cancel');
    });
    Route::group(['middleware' => ['can:manage-others']], function () {
        Route::post('/others/assign-papers', 'UserController@assignPaper')->name('others.assign-papers');

        Route::post('/reports/agentcollections', 'ReportController@agentCollections')->name('reports.agentcollections');
        Route::get('/reports/agentcollections', 'ReportController@agentCollections')->name('reports.agentcollections');
       
        Route::post('/reports/staffsales', 'ReportController@staffSales')->name('reports.staffsales');
        Route::get('/reports/staffsales', 'ReportController@staffSales')->name('reports.staffsales');
    
        Route::post('/reports/staffrefills', 'ReportController@staffRefill')->name('reports.staffrefills');
        Route::get('/reports/staffrefills', 'ReportController@staffRefill')->name('reports.staffrefills');
        
        Route::post('/reports/singleagentsales', 'ReportController@singleagentsales')->name('reports.singleagentsales');
        Route::post('/reports/singleagentxs', 'ReportController@singleagenttxs')->name('reports.singleagenttxs');
   

    });
});

Route::prefix('yimulu')->name('purchase.')->group(function () {
    Route::group(['middleware' => ['can:manage-vc']], function () {
        Route::get('/', 'PurchaseController@index')->name('index');
        Route::get('/create', 'PurchaseController@create')->name('create');
        Route::post('/store', 'PurchaseController@store')->name('store');
    });
});
