<?php

namespace App\Http\Controllers\Admin;

use App\Debt;
use App\Deposit;
use App\Http\Controllers\Controller;
use App\System_transaction;
use App\System_balance;
use App\System_deposit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use App\Transaction;
use App\Balance;
use App\Message;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Yimulu_sale;
use Validator;
use phpseclib\Crypt\RSA as Crypt_RSA; 
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
class TransactionController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {

        $transactions = Transaction::where('user_id', 1)->whereDate('created_at', '>', Carbon::now()->subDays(30));
        //dd($yimulu_saless);
        return view('transactions.index', ['transactions' => $transactions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.transactions.create');
    }
    public function send(Request $request)
    {
        $agent = Auth::user();
        if (!isset($agent->name)) {
            return response()->json(['success' => 'false', 'error' => 'No user'], 200);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'amount' => "required|numeric|min:5",
                'phone_number' => "required",
                'sales_type'=>"required"
            ]
        );

        if ($validator->fails()) {
            return response()->json(['success' => 'false', 'error' => ['error' => $validator->errors()]], 200);
        }
        $sales_type = $request->sales_type;
        $phone_number = $request->phone_number;
        $amount = $request->amount;
        DB::beginTransaction();
        $oldAgentBalance =  $this->getAgentBalance($agent);

        if ($amount > $oldAgentBalance) {
            return response()->json(['success' => 'false', 'error' => 'insufficient balance'], 200);
        }
        $sales = new Yimulu_sale();
        $sales->user_id = $agent->id;
        $sales->sales_type = $sales_type;
        $sales->phone_number = $phone_number;
        $sales->amount=$amount;
        $sales->save();

        $agentBalance = new Balance();
        $agentBalance->user_id = $agent->id;
        $agentBalance->yimulu_sales_id = $sales->id;
        $agentBalance->balance = $oldAgentBalance - $amount;
        $agentBalance->begining_balance = $oldAgentBalance;
        $agentBalance->performed_by = $agent->id;
        $agentBalance->amount = $amount;
        $agentBalance->save();

        // dd($agentBalance)
        $dt = Carbon::now();
       

        if (!$agentBalance || !$sales ) {
            DB::rollback();
            return back()->with('error_message','Error Occured');
        } else {
            // Else commit the queries
            DB::commit();
            $rsa = new Crypt_RSA();
            $publickey="-----BEGIN CERTIFICATE-----
            MIIDQDCCAiigAwIBAgICDHMwDQYJKoZIhvcNAQEFBQAwYzELMAkGA1UEBhMCRVQx
            EDAOBgNVBAgTB0V0aG9waWExFDASBgNVBAcTC0FkZGlzIEFiYWJhMQ8wDQYDVQQK
            EwZ5aW11bHUxCzAJBgNVBAsTAklUMQ4wDAYDVQQDEwVGNS5MQjAeFw0xODA5MjQw
            NjU4MDBaFw0yMDA5MjMwNjU4MDBaMGMxCzAJBgNVBAYTAkVUMRAwDgYDVQQIEwdF
            dGhvcGlhMRQwEgYDVQQHEwtBZGRpcyBBYmFiYTEPMA0GA1UEChMGeWltdWx1MQsw
            CQYDVQQLEwJJVDEOMAwGA1UEAxMFRjUuTEIwggEiMA0GCSqGSIb3DQEBAQUAA4IB
            DwAwggEKAoIBAQC/CFJjXsiIdpJ9/5o3I86PbMmjDr0TdcMlbaeFQnrcZSBRbofZ
            Bh58GhJvWHLTVuqgwLN7+pzyP3vL1E7YYJtJfK5Xa6n9h2wFJlk+69v2sopaCOFS
            ykiMe2UY2OAD6OE1CLGwTn0PNCqP4fhXxfPcZB3oRGraejZG5t+LZ+OBGiHsfvpz
            G+gHWZdLTQnaXavLBpE5YmZL+r89Sn+NYOjQKOoklV7/7Hn+GKd7ry+sNNft9t4J
            N5hkQvcPnzPSCRjuJBRww6n7H4u6hxu7c++gEh6L7xiype5BG5eqG+4+6YQIQL54
            z7wvvmSayc27wr02cjv2RSUDAuz53Xj3xxwvAgMBAAEwDQYJKoZIhvcNAQEFBQAD
            ggEBAIaRCyfocbUsdK5dTVcFq0YdgCvjSRe9V67zVK04EBRGpy1EBF7Ze62mK8my
            rwqvP92ssopDASu89+sb2mideT8pujR7O+q9olfP/kJk3jTfdiKfRxWt64LDGf4a
            ix6g34wYDnVgzujVXWW6pkCuYuEEBQtbYO3Ro+W073leiQWoLd20iy3x3NrXV7bw
            1zwMvxmfMjKOvLU5r/YFw7b2KJqTUXs4biZ5UwuFwYeKZKxGcpBjRqAE1Szo7VbJ
            0zEaLi+whehEHXjY8gxyJKaCIWzMsbcNNijz2bJJcduEo003zCQrtkU0FqMjbw3k
            SwFOQMrKgM7GkZR9cZWJ+eM1NBk=
            -----END CERTIFICATE-----";
            $rsa->loadKey($publickey);
            $rsa->setEncryptionMode(2);
            //$data = 'Your String';
            

            $message="<?xml version=\"1.0\"?>
            <COMMAND>             
            <TYPE>EXRCTRFREQ</TYPE>
            <DATE>". $dt->toDateString()."</DATE>
            <EXTNWCODE>ET</EXTNWCODE>
            <MSISDN>962586148</MSISDN>
	    <PIN>3214</PIN>
	    <LOGINID></LOGINID>
	    <PASSWORD></PASSWORD>
	    <EXTCODE></EXTCODE>
	    <EXTREFNUM>NAZ000163917557</EXTREFNUM>
            <MSISDN2>".$phone_number."</MSISDN2>  
            <AMOUNT>".$amount."</AMOUNT>
            <LANGUAGE1>0</LANGUAGE1>
            <LANGUAGE2>1</LANGUAGE2>
            <SELECTOR>1</SELECTOR></COMMAND>";
            if($sales_type==1){
                $message="<COMMAND>
                <TYPE>EXPPBREQ</TYPE>              
                <DATE>". $dt->toDateString()."</DATE>
                <MSISDN>962586148</MSISDN>
		<PIN>3214</PIN>
		<LOGINID></LOGINID>
		<PASSWORD></PASSWORD>
		<EXTCODE></EXTCODE>
		<EXTREFNUM>NAZ000163917557</EXTREFNUM>
		<MSISDN2>".$phone_number."</MSISDN2>  
                <AMOUNT>".$amount."</AMOUNT>         
                <LANGUAGE1>0</LANGUAGE1>
                <LANGUAGE2>1</LANGUAGE2>
                <SELECTOR>1</SELECTOR>
                </COMMAND> ";
            }
            //$message=simplexml_load_string($message);
            
            $output = $rsa->encrypt($message);
           /* $client = new Client();

            //$post = $request->all();
            $myRequest = $client->post('http://localhost/xmlexample2.php', [
                'headers' => [
                    'Content-Type' => 'text/xml; charset=UTF8',
                ],
                'body' => $message                         
            ]);
          dd($myRequest);
            $response = $myRequest->send();
            dd($response);*/
           /* $response = Http::post('http://localhost/xmlexample.php', [
                'headers' => [
                    'Content-Type' => 'text/xml; charset=UTF8',
                ],
                'body' => $message,
            ]);*/
            $response = Http::withHeaders(['Content-Type' => 'text/xml; charset=utf-8'])->send('POST', 'https://10.208.254.131/pretups/C2SReceiver?LOGIN=nazret1&PASSWORD=70c0ad9d73cafc653ba10ee56ce10033&REQUEST_GATEWAY_CODE=nazret&REQUEST_GATEWAY_TYPE=EXTGW&SERVICE_PORT=190&SOURCE_TYPE=EXTGW', ['body' => $message, 'verify' => false]);
            dd($response->body());
            $clean_xml = str_ireplace(['SOAP-ENV:', 'SOAP:'], '', $response);
            dd($clean_xml);
            $cxml = simplexml_load_string($clean_xml);
    
            dd($cxml);
          

            return response()->json(['success' => 'true', 'xmlmessage' => $message, 'encrypted'=>base64_encode($output)], 200);
   
            return back()->with('success_message',$message);
            
            //return response()->json(['success' => 'true', 'data' => ['yimulu_sales' => $cards, 'balance' => $agentBalance->balance]], 200);
        }


    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function transfer(Request $request)
    {
        //
       
        $user=Auth::user();
        if(Gate::denies('manage-transaction')){
            //dd($salestype->hasRole('Agent Manager'));
            return back()->withInput();
        }
        $this->validateTransactionInput($request);

        $agent=User::where('id',$request->to_agent)->first();
        $old_transaction=System_transaction::where('amount',$request->amount)
                        ->where('performed_by',$user->id)
                        ->where('to_agent',$agent->id)
                        ->orderBy('id','desc')
                        ->first();
        if (isset($old_transaction->created_at))
         {
            $tran_time=new Carbon($old_transaction->created_at);
            $diff=$tran_time->diffInSeconds(Carbon::now());

          //  dd($diff);
            if($diff<=5)
            {
                $new_balance = $this->getAgentBalance($agent);
                return back()->with('success_message','Transfer successful');            }
            elseif($diff<60)
            {
                return back()->with('error_message','Please wait for one minute to transfer same amount of money to the same agent.');
            }
        }
        DB::beginTransaction();
        $oldBalance = $this->getSystemBalance();

        //dd($oldBalance);
        $oldAgentBalance=$this->getAgentBalance($agent);
       
        //dd($oldAgentDebt);
        if(($oldBalance-$request->amount)<0){
            DB::rollback();
            return back()->with('error_message','Insufficient system balance');
        }
        if(($oldAgentBalance+$request->amount)<0){
            DB::rollback();
            return back()->with('error_message','Insufficient agent balance');
        }

        $receivable=$request->amount-$request->amount*$request->commission*0.01;
        $transaction = new System_transaction();
        $transaction->to_agent = $agent->id;
        $transaction->amount = $request['amount'];
        $transaction->commission=$request->commission;
        $transaction->performed_by=$user->id;
        $transaction->save();

        $balance=new System_balance();
        $balance->system_transaction_id=$transaction->id;
        $balance->balance = $oldBalance-$transaction->amount;
        $balance->begining_balance=$oldBalance;
        $balance->performed_by=$user->id;
        $balance->amount=$request['amount'];


        $balance->save();

       
        if ($agent->parent_id!=1) {
            $oldAgentDebt=$this->getAgentDebt($user->id);
            $debt=new Debt();
            $debt->system_transaction_id=$transaction->id;
            //$usrid=$agent->id;
            $usrid=$user->id;
            $debt->user_id=$usrid;
            $debt->debt=$oldAgentDebt+$receivable;
            $debt->beginning_debt=$oldAgentDebt;
            $debt->save();
        }
        $agentBalance=new Balance();
        $agentBalance->user_id=$request->to_agent;
        $agentBalance->system_transaction_id=$transaction->id;
        $agentBalance->balance=$oldAgentBalance+$transaction->amount;
        $agentBalance->begining_balance=$oldAgentBalance;
        $agentBalance->performed_by=$user->id;
        $agentBalance->amount=$request['amount'];


        $agentBalance->save();


        if (!$agentBalance || !$balance || !$transaction ) {
            DB::rollback();      
            return back()->with('error_message','Error Occured');      } 
        else {
            // Else commit the queries
            DB::commit();
          
           // $agentbalanceupdate = DB::statement('UPDATE users SET balance=balance-'.$request->amount.' WHERE id=' . $agent->id);                
           // $recieverbalanceupdate = DB::statement('UPDATE users SET balance=balance+'.$request->amount.' WHERE id=' . $request->to_agent);                
        //dd($request->to_agent);
            if ($agent->parent_id != 1) {
                $receivable=$request->amount-$request->amount*$request->commission*0.01;
                //$agentbalanceupdate = DB::statement('UPDATE users SET debt=debt+'.$receivable.' WHERE id=' . $user->id);                          
            }
          
            $message = new Message();
            $message->receiver = '0911222102';
            $message->msg = number_format((float)$request->amount) . ' Birr was directly filled to ' . $agent->name . " by ".$user->name.".  System's new balance: " . number_format((float)$balance->balance) . "Birr.";
            $message->message_type_id='4';
            $message->save();
            $message = new Message();
            $message->receiver = $agent->phone_number;
            $message->msg = 'Your balance was credited with ' . number_format((float)$request->amount) . ' Birr by Nared. Your new balance: '. number_format(floatval($agentBalance->balance)) . "Birr.";
            $message->message_type_id='4';
          
            $message->save();
            return back()->with('success_message','Transfer successful');
        }
        return back()->with('success_message','Successfully recorded');
    }
    
    public function transferStaff(Request $request)
    {
        //
       
        $agent=Auth::user();
        if(Gate::denies('fill-balance')){
            //dd($salestype->hasRole('Agent Manager'));
            return back()->withInput();
        }
        $this->validateTransactionInput($request);
        $receiver=User::where('id',$request->to_agent)->first();
        
        $old_transaction=Transaction::where('amount',$request->amount)
                        ->where('from_agent',$agent->id)
                        ->where('to_agent',$receiver->id)
                        ->orderBy('id','desc')
                        ->first();
        if (isset($old_transaction->created_at))
         {
            $tran_time=new Carbon($old_transaction->created_at);
            $diff=$tran_time->diffInSeconds(Carbon::now());

          //  dd($diff);
            if($diff<=5)
            {
            //    $new_balance = $this->getAgentBalance($agent);
                return back()->with('success_message','Successfully recorded');
            }
            elseif($diff<60)
            {
                return  back()->with('error_message','Please wait for one minute to transfer same amount of money to the same agent.');
            }
        }

        if ($receiver->parent_id != $agent->id) {
            return back()->with('error_message','you can only transfer money to your subagents');   
        }
        DB::beginTransaction();
        $agent_balance = $this->getAgentBalance($agent);
        $reciever_balance = $this->getAgentBalance($receiver);
        if (($agent_balance - $request->amount) < 0 || ($reciever_balance + $request->amount) < 0) {
            DB::rollback();
            return back()->with('error_message','Insufficient balance');     
        }
       
        $transaction = new Transaction();
        $transaction->amount = $request->amount;
        $transaction->from_agent = $agent->id;
        $transaction->to_agent = $receiver->id;
        $transaction->commission = $request->commission;
        $transaction->save();

        $recieverBalance = new Balance();
        $recieverBalance->balance = $reciever_balance + $request->amount;
        $recieverBalance->user_id = $receiver->id;
        $recieverBalance->transaction_id = $transaction->id;
        $recieverBalance->begining_balance = $reciever_balance;
        $recieverBalance->performed_by = $agent->id;
        $recieverBalance->amount = $request->amount;
        $recieverBalance->save();
       
        $balance = new Balance();
        $balance->balance = $agent_balance - $request->amount;
        $balance->user_id = $agent->id;
        $balance->transaction_id = $transaction->id;
        $balance->begining_balance = $agent_balance;
        $balance->performed_by = $receiver->id;
        $balance->amount = $request->amount;
        $balance->save();
        
        $receivable=$request->amount-$request->amount*$request->commission*0.01;
        
        $oldAgentDebt=$this->getAgentDebt($agent->id);
        $debt=new Debt();
        $debt->transaction_id=$transaction->id;
        //$usrid=$agent->id;
        $usrid=$agent->id;
        $debt->user_id=$usrid;
        $debt->debt=$oldAgentDebt+$receivable;
        $debt->beginning_debt=$oldAgentDebt;
        $debt->save();
        
        if (!$balance || !$transaction || !$recieverBalance) {
            DB::rollback();
            return response()->json(['success' => 'false', 'error' => 'transaction failed'], 200);
        } else {
            // Else commit the queries
            DB::commit();
            //$agentbalanceupdate = DB::statement('UPDATE users SET balance=balance-'.$request->amount.' WHERE id=' . $agent->id);                
           // $recieverbalanceupdate = DB::statement('UPDATE users SET balance=balance+'.$request->amount.' WHERE id=' . $receiver->id);                
            if ($agent->parent_id == 1) {
                $receivable = $request->amount - $request->amount * $receiver->commission * 0.01;           
               // $agentbalanceupdate = DB::statement('UPDATE users SET debt=debt+'.$receivable.' WHERE id=' . $agent->id);                          
            }
          
            $message = new Message();
            $message->receiver = $agent->phone_number;
            $message->msg = 'You transferred  ' . number_format((float) $request->amount) . ' Birr to ' . $receiver->name . ".  Your new balance: " . number_format((float) $balance->balance) . "Birr.";
            $message->message_type_id = '4';
            $message->save();
            $message = new Message();
            $message->receiver = $receiver->phone_number;
            $message->msg = 'Your balance was credited with ' . number_format((float) $request->amount) . ' Birr by ' . $agent->name . ". Your new balance: " . number_format((float) $recieverBalance->balance) . "Birr.";
            $message->message_type_id = '4';
            $message->save();
        }
      //  $new_balance = $this->getAgentBalance($agent);
    

        return back()->with('success_message','Successfully recorded');
    }
    public function deposit(Request $request)
    {
        //
        if(Gate::denies('manage-transaction')){
            //dd($salestype->hasRole('Agent Manager'));
            return redirect(route('admin.transactions.index'));
        }
        if(isset($request->by_agent)){
            $user=User::where($request->by_agent); 
        }
        else{
            $user=Auth::user();
        }
       
        $this->validateDepositInput($request);
       
        DB::beginTransaction();
        $oldDebt = $this->getAgentDebt($user->id);
        $sdeposit=new System_deposit();
        $sdeposit->amount=$request->deposit_amount;
        $sdeposit->from_agent=$user->id;
        $sdeposit->bank_id=$request->bank_id;
        $sdeposit->ref_number=$request->ref_number;
        $sdeposit->save();
        $debt=new Debt();
        $debt->system_deposit_id=$sdeposit->id;
        $debt->user_id=$request->to_agent;
        $debt->debt=$oldDebt-$sdeposit->amount;
        $debt->save();
        
        
        if (!$debt || !$sdeposit ) {
            DB::rollback();
            return back()->with('error_message','Error Occured');
        } else {
            // Else commit the queries
            DB::commit();
            return back()->with('success_message','Successfully recorded');
        }
        
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\System_transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(System_transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\System_transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(System_transaction $transaction)
    {
        //

        //dd((Gate::denies('edit-transaction')));
        // dd($transaction->hasRole('Agent Manager'));
        if (Gate::denies('manage-system')) {
            //dd($transaction->hasRole('Agent Manager'));
            return redirect(route('admin.transactions.index'));
        }
        // $transaction = System_transaction::find($id);
        //dd($transaction);
        // Redirect to product list if updating product wasn't existed
        if ($transaction == null || count($transaction->all()) == 0) {
            return redirect()->intended('/admin/transactions/index');
        }
        return view('admin.transactions.edit', ['transaction' => $transaction]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\System_transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, System_transaction $transaction)
    {

        $this->validateInput($request);
        $transaction->name = $request['name'];
        $transaction->branch = $request['branch'];
        $transaction->address = $request['address'];
        $transaction->account_number = $request['account_number'];

        $transaction->save();
        return redirect()->route('admin.transactions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\System_transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(System_transaction $transaction)
    {
        //
    }
    public function getAgentBalance($user)
    {
        $balance = Balance::where('user_id', $user->id)->orderBy('id', 'desc')->lockForUpdate()->first();       
        return ($this->existAgentBalance($user))?$balance->balance : 0;
    }
    public function existAgentBalance($user)
    {
        $balance = Balance::where('user_id', $user->id)->first();
        return isset($balance->balance) ? 1: 0;
    }
    public function getAgentDebt($user)
    {
        $debt = Debt::where('user_id', $user)->orderBy('id', 'desc')->lockForUpdate()->first();
        return isset($debt->debt) ? $debt->debt : 0;
    }
    public function getSystemBalance()
    {
        $balance = System_balance::orderBy('id', 'desc')->lockForUpdate()->first();
        return isset($balance->balance) ? $balance->balance : 0;
    }
    private function validateTransactionInput($request)
    {
        $this->validate($request, [
            'to_agent' => 'required',
            'amount' => 'required|numeric',

        ]);
    }
}
