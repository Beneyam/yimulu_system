<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::post('login', 'api\AgentController@login');
Route::post('contact', 'api\AgentController@getContact');
Route::post('register', 'api\AgentController@register');
Route::post('register1', 'api\AgentController@register1');
Route::post('request-activation','api\AgentController@requestactivation');
Route::post('activate','api\AgentController@activate');
Route::post('request-password-change','api\AgentController@requestPasswordChange');
Route::post('change-password','api\AgentController@changePassword');


Route::group(['middleware' => 'auth:api'], function () {
   
    Route::post('logout','api\AgentController@logout');
    Route::post('refresh', 'api\AgentController@refresh');
    Route::post('agentinfo', 'api\AgentController@agentInfo');
    Route::post('report', 'api\ApiTransactionController@getAgentReport');
    Route::post('addsubagent', 'api\SubagentController@addsubagent');
    Route::post('update', 'api\SubagentController@update');
    Route::post('subagents', 'api\SubagentController@subagents');
    Route::post('ordercard', 'api\ApiTransactionController@ordercard');
    Route::post('syncsales', 'api\ApiTransactionController@syncSales');
    Route::post('confirmyimulu_sales', 'api\ApiTransactionController@confirmSales');
    Route::post('confirmyimulu_saless', 'api\ApiTransactionController@confirmDownloadSales');
    Route::post('confirmbulk', 'api\ApiTransactionController@confirmBulkSales');
    Route::post('unconfirmedsales', 'api\ApiTransactionController@unconfirmedSales');
    Route::post('unconfirmeddownloads', 'api\ApiTransactionController@unconfirmedDownloads');
   
    Route::post('checkreprint', 'api\ApiTransactionController@checkReprints');
    Route::post('checkallreprint', 'api\ApiTransactionController@checkAllReprints');

    Route::post('downloadyimulu_saless', 'api\ApiTransactionController@ordercards');
    Route::post('bulkprint', 'api\ApiTransactionController@bulkprint');
    Route::post('transfer', 'api\ApiTransactionController@transfer');
    Route::post('transactions', 'api\ApiTransactionController@transactions');
    Route::post('printtransactions', 'api\ApiTransactionController@transactionsPrint');

    Route::post('ordertransfer', 'api\ApiOrderController@orderTransfer');
    Route::post('order-requests', 'api\ApiOrderController@getOrders');
    Route::post('my-orders', 'api\ApiOrderController@getMyOrders');
    Route::post('approve-order-request', 'api\ApiOrderController@approveOrder');
    Route::post('remove-order-request', 'api\ApiOrderController@removeMyOrder');
    Route::post('decline-order-request', 'api\ApiOrderController@removeOrder');

});
