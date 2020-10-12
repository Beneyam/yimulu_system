<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Purchase;
use Illuminate\Support\Facades\DB;
use App\System_balance;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    //
    public function store(Request $request)
    {
        $user = Auth::user();
        $this->validate($request, [
            'order_number' => 'required',
            'amount' => 'required|numeric|min:1',
        ]);
        DB::beginTransaction();
        $purchase = new Purchase();
        $purchase->order_number = $request['order_number'];
        $purchase->amount = $request['amount'];
        $purchase->save();
        
        $new_system_balance = 0;
        $oldSystemBalance = $this->getSystemBalance();
        $systemBalance = new System_balance();
        $systemBalance->purchase_id = $purchase->id;
        $systemBalance->balance = $oldSystemBalance + $request['amount'];
        $systemBalance->begining_balance = $oldSystemBalance;
        $systemBalance->performed_by = $user->id;
        $systemBalance->amount = $new_system_balance;
        $systemBalance->save();

        if($systemBalance){
            DB::commit();
              return view('home');   
        }     
        return back();

    }
    public function create()
    {
        return view('yimulu.create');
    }
    public function getSystemBalance()
    {
        $balance = System_balance::orderBy('id', 'desc')->lockForUpdate()->first();
        return isset($balance->balance) ? $balance->balance : 0;
    }
}
