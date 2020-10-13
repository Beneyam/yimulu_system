<?php

namespace App\Http\Controllers;

use App\Activation;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Balance;
use App\Debt;
use App\Deposit;
use App\Bank;
use App\Print_paper;
use App\Transaction;
use Illuminate\Support\Carbon;
use App\System_transaction;
use App\System_balance;
use App\System_deposit;
use Illuminate\Support\Facades\Http;
//use Carbon;

class StatController extends Controller
{
    //
    public static function parentlist()
    {

        /* $search = $request->search;

        if ($search == '') {
            $users = User::where('parent_id', 1)->where('id', '!=', '1')->select('id', 'phone_number', 'name')->limit(5)->get();
        } else {
            $users = User::where('parent_id', 1)->where('id', '!=', '1')->select('id', 'phone_number', 'name')->where('name', 'like', '%' . $search . '%')->limit(5)->get();
        }
        */
        $users = User::where('parent_id', 1)->orWhere('id', '1')->select('id', 'phone_number', 'name')->get();


        return $users;
    }

    public static function GetAgentStat($user)
    {
        $balance = StatController::getAgentBalance($user->id);
        $debt = StatController::getAgentDebt($user->id);
        //  dd($balance);
        $subagents = User::where('parent_id', $user->id)->where('user_status', '!=', 4)->get();
        // dd($balance);
        //dd($subagents);
        $subagentBalance = 0;
        $subagentsSales = 0;
        $subagent_stat = [];
        $otp = Activation::where('user_id', $user->id)->orderBy('id', 'desc')->first();
        foreach ($subagents as $subagent) {

            $BB = $subagent->balance;

            //dd(now());
            //dd($sales);
            $agent_sales = StatController::getAgentTotalSales($subagent->id);
            //dd($agent_sales->amount);
            $subagent_stat[] = [
                'name' => $subagent->name,
                'phone_number' => $subagent->phone_number,
                'balance' => $BB,
                'id' => $subagent->id,
                'amount' => $agent_sales->total,
            ];
            $subagentBalance += $BB;
            $subagentsSales += $agent_sales->total;
        }
        $allSubagentBalance = 0;
        $allSubagentSales = 0;
        $allsubagents = User::where('ancestry', 'like', '%[' . $user->id . ']%')->where('user_status', '!=', 4)->get();
        //dd($allsubagents);
        $a_assigned_terminals = 0;
        $active_agent_count = 0;
        $allsubagent_stat = [];
        foreach ($allsubagents as $allsubagent) {
            //dd(StatController::getAgentTotalSales($allsubagent->id)->total);
            $subagent_sales = StatController::getAgentTotalSales($allsubagent->id)->total;

            $allSubagentSales += $subagent_sales;
            if ($subagent_sales > 0) {
                $active_agent_count++;
            }
            $BB = $allsubagent->balance;
            $allSubagentBalance += $BB;
            $allsubagent_stat[] = [
                'name' => $allsubagent->name,
                'phone_number' => $allsubagent->phone_number,
                'parent' => $allsubagent->parent->name,
                'balance' => $BB,
                'id' => $allsubagent->id,
                'sales' => $subagent_sales,
            ];
        }
        $allSubagentBalance -= $subagentBalance;
        $parent = User::where('id', $user->parent_id)->first();
        //dd($allSubagentSales);
        $sales = StatController::getAgentTotalSales($user->id);
        $transaction = StatController::getAgentTransactions($user->id);
        $transaction_details = StatController::getAgentTransactionsDetails($user->id);
        // dd($sales);
        $parentlist =  User::where('user_status', 2)->orWhere('id', '1')->select('id', 'phone_number', 'name')->get(); //StatController::parentlist();
        $commission = $user->commission;
        $commmission_sugg = $commission;
        $lastMRefill = StatController::getLastMonthSystemRefillToAgent($user->id);
        $lastMRefill = $lastMRefill + 0;
        //dd($lastMRefill);
        if ($lastMRefill >= 1000000) {
            $commmission_sugg = 13;
        } elseif ($lastMRefill >= 500000) {
            $commmission_sugg = 12.5;
        } elseif ($lastMRefill >= 100000) {
            $commmission_sugg = 12;
        } elseif ($lastMRefill >= 40000) {
            $commmission_sugg = 11;
        } elseif ($lastMRefill >= 1000) {
            $commmission_sugg = 10;
        }
        if ($user->parent_id == 1) {
            $commmission_sugg = 0;
        }
        $banks = Bank::all();
        return [
            'banks' => $banks,
            'parentlists' => $parentlist,
            'user' => $user,
            'commission' => $commission,
            'commmission_sugg' => $commmission_sugg,
            'otp' => $otp,
            'parent' => $parent,
            'balance' => $balance,
            'debt' => $debt,
            'subagents' => $subagents,
            'allsubagents' => $allsubagents,
            'subagents_stat' => $subagent_stat,
            'allsubagents_stat' => $allsubagent_stat,
            'subagentBalance' => $subagentBalance,
            'totalSubagentBalance' => $allSubagentBalance,
            'sales' => $sales->total,
            'subagentSales' => $subagentsSales,
            'allSubagentSales' => $allSubagentSales,
            'transaction' => $transaction,
            'transaction_details' => $transaction_details,
            'active_agents' => $active_agent_count,
            'lastMRefill' => $lastMRefill
        ];
    }
    public static function GetAgentStatDashboard($user)
    {

        $first_date = Carbon::now()->startOfDay();
        $last_date = Carbon::now();

        $balance = StatController::getAgentBalance($user->id);
        $debt = StatController::getAgentDebt($user->id);
        //  dd($balance);
        $subagents = User::where('parent_id', $user->id)->where('user_status', '!=', 4)->get();
        // dd($balance);
        //dd($subagents);
        $subagentBalance = 0;
        $subagentsSales = 0;
        $allSubagentBalance = 0;
        $allSubagentSales = 0;
        $active_agent_count = 0;
        $allsubagents = User::where('ancestry', 'like', '%[' . $user->id . ']%')->where('user_status', '!=', 4)->get();
        $newAgents = User::where('ancestry', 'like', '%[' . $user->id . ']%')->where('user_status', '!=', 4)->whereBetween('created_at', [$first_date, $last_date])->count();
        foreach ($subagents as $subagent) {
            $BB = StatController::getAgentBalance($subagent->id);
            $agent_sales = StatController::getAgentTotalSales($subagent->id);
            $subagentBalance += $BB;
            $subagentsSales += $agent_sales->total;
        }

        foreach ($allsubagents as $allsubagent) {
            //dd(StatController::getAgentTotalSales($allsubagent->id)->total);
            $subagent_sales = StatController::getAgentTotalSales($allsubagent->id)->total;
            $allSubagentSales += $subagent_sales;
            if ($subagent_sales > 0) {
                $active_agent_count++;
            }
            $BB = StatController::getAgentBalance($allsubagent->id);
            $allSubagentBalance += $BB;
        }
        // $allSubagentBalance -= $subagentBalance;

        //dd($allsubagents);

        $active_agent_count = 0;
        $sales = StatController::getAgentSales($user->id);
        $tot_sales=StatController::getAgentTotalSales($user->id);
        $sold_card_amount = 0;
        $transaction = StatController::getAgentTransactions($user->id);

        return [

            'user' => $user,
            'balance' => $balance,
            'debt' => $debt,
            'subagents' => $subagents,
            'allsubagents' => $allsubagents,
            'subagentBalance' => $subagentBalance,
            'totalSubagentBalance' => $allSubagentBalance,
            'sales' => $tot_sales->amount,
            'subagentSales' => $subagentsSales,
            'allSubagentSales' => $allSubagentSales,
            'transaction' => $transaction,
            'activeAgents' => $active_agent_count,
            'newAgents' => $newAgents

        ];
    }
   
    public static function getAgentSales($user)
    {
        $first_date = Carbon::now()->startOfDay();
        $last_date = Carbon::now();
        return DB::table('yimulu_sales')
            ->join('sales_types', 'yimulu_sales.sales_type', '=', 'sales_types.id')
            ->select('sales_types.type',  DB::raw("count('yimulu_sales.amount') as amount"))
            ->where('yimulu_sales.user_id', $user)
            ->whereBetween('yimulu_sales.created_at', [$first_date, $last_date])
            ->groupBy('sales_types.type')
            ->get();
    }
    
    public static function getAgentTotalSales($user)
    {

        $first_date = Carbon::now()->startOfDay();
        $last_date = Carbon::now();
        return DB::table('sales_stats')
            ->select(DB::raw('SUM(amount) as total') )->where('sales_stats.user_id', $user)
            ->whereBetween('sales_stats.sales_date', [$first_date->toDateString(), $last_date->toDateString()])
            ->first();
    }
    public static function getAgentTransactionsDetails($user)
    {

        $first_date = Carbon::now()->startOfDay();
        $last_date = Carbon::now();
        $beginning_balance = StatController::getAgentBalanceDate($user, Carbon::yesterday());
        $transfers = Transaction::whereBetween('created_at', [$first_date, $last_date])->where('from_agent', $user)->orderBy('created_at', 'desc')->get();
        $deposits = Transaction::whereBetween('created_at', [$first_date, $last_date])->where('to_agent', $user)->orderBy('created_at', 'desc')->get();
        $sdeposits = System_transaction::whereBetween('created_at', [$first_date, $last_date])->where('to_agent', $user)->orderBy('created_at', 'desc')->get();
        $ending_balance = StatController::getAgentBalanceDate($user, Carbon::now());
        return [
            'beginingBalance' => $beginning_balance,
            'endingBalance' => $ending_balance,
            'transfers' => $transfers,
            'deposits' => $deposits,
            'sDeposits' => $sdeposits
        ];
    }
    public static function getAgentTransactionsDetailsReport($first, $last, $user)
    {
        $beginning_balance = StatController::getAgentBalanceDate($user, $first);
        $transfers = Transaction::whereBetween('created_at', [$first, $last])->where('from_agent', $user)->orderBy('created_at', 'desc')->get();
        $deposits = Transaction::whereBetween('created_at', [$first, $last])->where('to_agent', $user)->orderBy('created_at', 'desc')->get();
        $sdeposits = System_transaction::whereBetween('created_at', [$first, $last])->where('to_agent', $user)->orderBy('created_at', 'desc')->get();
        $ending_balance = StatController::getAgentBalanceDate($user, $last);
        return [
            'beginingBalance' => $beginning_balance,
            'endingBalance' => $ending_balance,
            'transfers' => $transfers,
            'deposits' => $deposits,
            'sDeposits' => $sdeposits
        ];
    }

    public static function getAgentTransactions($user)
    {

        $first_date = Carbon::now()->startOfDay();
        $last_date = Carbon::now();

        $beginning_balance = StatController::getAgentBalanceDate($user, Carbon::yesterday());
        $transfers = Transaction::where('from_agent', $user)->whereBetween('created_at', [$first_date, $last_date])->orderBy('created_at', 'desc')->get();
        $fills = 0;
        foreach ($transfers as $transfer) {
            $fills += $transfer->amount;
        }
        $refills = 0;

        $deposits = Transaction::where('to_agent', $user)->whereBetween('created_at', [$first_date, $last_date])->orderBy('created_at', 'desc')->get();
        foreach ($deposits as $deposit) {
            $refills += $deposit->amount;
        }
        $sdeposits = System_transaction::where('to_agent', $user)->whereBetween('created_at', [$first_date, $last_date])->orderBy('created_at', 'desc')->get();

        foreach ($sdeposits as $sdeposit) {
            $refills += $sdeposit->amount;
        }

        return [
            'beginingBalance' => $beginning_balance,
            'fills' => $fills,
            'refills' => $refills,
        ];
    }
    public static function getAgentBalance($user)
    {
        $balance = Balance::where('user_id', $user)->orderBy('id', 'desc')->first();
        return isset($balance->balance) ? $balance->balance : 0;
    }
    public static function getAgentDebt($user)
    {
        $debt = Debt::where('user_id', $user)->orderBy('id', 'desc')->first();
        return isset($debt->debt) ? $debt->debt : 0;
    }
    public static function getAgentBalanceDate($user, $date)
    {
        $edate = new Carbon($date);
        //whereBetween('created_at', [$first_date,$last_date])->
        $balance = Balance::where('user_id', $user)->where('created_at', '<=', $edate->endOfDay())->orderBy('id', 'desc')->first();
        return isset($balance->balance) ? $balance->balance : 0;
    }
    public static function getAgentDebtDate($user, $date)
    {
        $edate = new Carbon($date);

        $debt = Debt::where('user_id', $user)->where('created_at', '<=', $edate->endOfDay())->orderBy('id', 'desc')->first();
        return isset($debt->debt) ? $debt->debt : 0;
    }
    public static function getSystemBalance()
    {
        $dt = Carbon::now();
        $message = "<?xml version=\"1.0\"?>
<COMMAND>             
<TYPE>EXUSRBALREQ</TYPE>
<DATE>" . $dt->toDateString() . "</DATE>
<EXTNWCODE>ET</EXTNWCODE>
<MSISDN>962586148</MSISDN>
<PIN>3214</PIN>
<LOGINID></LOGINID>
<PASSWORD></PASSWORD>
<EXTCODE></EXTCODE>
<EXTREFNUM>NAZ000163917557</EXTREFNUM>
</COMMAND>";
        $response = Http::withHeaders(['Content-Type' => 'text/xml; charset=utf-8'])->send('POST', 'https://10.208.254.131/pretups/C2SReceiver?LOGIN=nazret1&PASSWORD=70c0ad9d73cafc653ba10ee56ce10033&REQUEST_GATEWAY_CODE=nazret&REQUEST_GATEWAY_TYPE=EXTGW&SERVICE_PORT=190&SOURCE_TYPE=EXTGW', ['body' => $message, 'verify' => false]);
        
        $clean_xml = str_ireplace(['SOAP-ENV:', 'SOAP:'], '', $response);
        //dd($clean_xml);
        $cxml = simplexml_load_string($clean_xml);

        //dd($cxml->RECORD->BALANCE);
        $balance=0;
        try
        {
            $balance = $cxml->RECORD->BALANCE->first();
        }
        catch(Exception $ex)
        {
            $balance=-1;
        }
        return $balance;
    }
    
   

    public static function getAllAgentStat()
    {
        $first_date = Carbon::now()->startOfDay();
        $last_date = Carbon::now();

        $all_users = User::where('user_status', 2)->count();
        $new_users = User::whereBetween('created_at', [$first_date, $last_date])->count();
        $active_users = Balance::whereBetween('created_at', [$first_date, $last_date])->groupBy('balances.user_id')->select('user_id')->get();
        return ['all_users' => $all_users, 'new_users' => $new_users, 'active_users' => $active_users->count()];
    }

    public static function getTodaysRefills()
    {
        //  $staff_agents=User::where('parent_id',1)->get();
        $first_date = Carbon::now()->startOfDay();
        $last_date = Carbon::now();

        $system_to_agents = System_transaction::select(DB::raw('SUM(system_transactions.amount) as total'))
            ->whereBetween('created_at', [$first_date, $last_date])->first();
        $agents_to_agents = Transaction::select(DB::raw('SUM(transactions.amount) as total'))
            ->whereBetween('created_at', [$first_date, $last_date])->first();
        $system_to_agents = isset($system_to_agents) ? $system_to_agents : 0;
        $agents_to_agents = isset($agents_to_agents) ? $agents_to_agents : 0;
        //dd($system_to_agents);
        return ['system_to_agent' => $system_to_agents, 'agents_to_agents' => $agents_to_agents];
    }


    public static function getTotalAgentStats()
    {
        $users = User::all();
        $balance = 0;
        $debt = 0;
        foreach ($users as $user) {
            $balance += StatController::getAgentBalance($user->id);
            $debt += StatController::getAgentDebt($user->id);
        }
        return ['balance' => $balance, 'debt' => $debt];
    }


    public static function getYTDSales($date)
    {
        // DB::enableQueryLog(); // Enable query log 
        //dd($date);
        //$date2 = Carbon::parse($date);
        $sdate = new Carbon($date);
        $fdate = new Carbon($date->firstOfYear());

        //dd([$fdate, $sdate]);
        $result = DB::table('sales_stats')
            ->select(DB::raw('SUM(amount) as amount'))
            ->whereBetween('sales_stats.sales_date', [$fdate->toDateString(), $sdate->toDateString()])
            ->first();

        return isset($result->amount) ? $result->amount : 0;
    }

    public static function getMTDSales($date)
    {
        $sdate = new Carbon($date);
        $fdate = new Carbon($date->firstOfMonth());


        $result = DB::table('sales_stats')
            ->select(DB::raw('SUM(amount) as amount'))
            ->whereBetween('sales_stats.sales_date', [$fdate->toDateString(), $sdate->toDateString()])
            ->first();

        return isset($result->amount) ? $result->amount : 0;
    }
    public static function getWTDsales($date)
    {
        $sdate = new Carbon($date);
        $fdate = new Carbon($date->startOfWeek());
        $result = DB::table('sales_stats')
            ->select(DB::raw('SUM(amount) as amount'))
            ->whereBetween('sales_stats.sales_date', [$fdate->toDateString(), $sdate->toDateString()])
            ->first();
        return isset($result->amount) ? $result->amount : 0;
    }
    public static function getYesterdaySales()
    {
        $first_date = Carbon::yesterday()->startOfDay();
        $last_date = Carbon::now()->subDays(1);

        $sales =   DB::table('yimulu_sales')
            ->select(DB::raw('SUM(amount) as amount'))
            ->whereBetween('yimulu_sales.created_at', [$first_date, $last_date])
            ->first();
        return $sales->amount + 0;
    }
    public static function getTodaysSales()
    {
        $first_date = Carbon::now()->startOfDay();
        $last_date = Carbon::now();

        $sales =   DB::table('yimulu_sales')
           
            
            ->select(DB::raw('SUM(amount) as amount'))
            ->whereBetween('yimulu_sales.created_at', [$first_date, $last_date])
            ->first();
        return $sales->amount + 0;
    }

    public static function getComparisonStats()
    {
        $todays_sales = StatController::getTodaysSales();
        $cur_YTD = StatController::getYTDSales(Carbon::now()) + $todays_sales;
        $last_YTD = StatController::getYTDSales(Carbon::now()->subYear(1));

        $last_MTD = StatController::getMTDSales(Carbon::now()->subMonth(1));
        $cur_MTD = StatController::getMTDSales(Carbon::now()) + $todays_sales;;
        $last_WTD = StatController::getWTDSales(Carbon::now()->subWeek(1));
        $cur_WTD = StatController::getWTDSales(Carbon::now()) + $todays_sales;;
        $yesterday_sales = StatController::getYesterdaySales();

        $DTD = ($todays_sales != 0) ? 100 : 0;
        $WTW = ($cur_WTD != 0) ? 100 : 0;
        $YTY = ($cur_YTD != 0) ? 100 : 0;
        $MTM = ($cur_MTD != 0) ? 100 : 0;
        if ($yesterday_sales != 0) {
            $DTD = ($todays_sales - $yesterday_sales) * 100 / $yesterday_sales;
        }
        if ($last_WTD != 0) {
            $WTW = ($cur_WTD - $last_WTD) * 100 / $last_WTD;
        }
        if ($last_MTD != 0) {
            $MTM = ($cur_MTD - $last_MTD) * 100 / $last_MTD;
        }
        if ($last_YTD != 0) {
            $YTY = ($cur_YTD - $last_YTD) * 100 / $last_YTD;
        }
        //dd($last_YTD);
        return ['YTY' => $YTY, 'cur_YTD' => $cur_YTD, 'cur_MTD' => $cur_MTD, 'MTM' => $MTM, 'WTW' => $WTW, 'cur_WTD' => $cur_WTD, 'today_sales' => $todays_sales, 'DTD' => $DTD];
    }



    //purchase Stats
    public static function getYTDPurchase()
    {

        $yd_date = Carbon::now()->startOfYear();
        $last_date = Carbon::yesterday();
        $result = DB::table('purchases')
            ->select(DB::raw('sum(amount) as amount'))
            ->whereBetween('purchase_date', [$yd_date->toDateString(), $last_date->toDateString()])
            ->get();
        return $result;
    }

    public static function getMTDPurchase()
    {

        $first_date = Carbon::now()->startOfMonth();
        $last_date = Carbon::yesterday();
        $result = DB::table('purchases')
            ->select(DB::raw('sum(amount) as amount'))
            ->whereBetween('purchase_date', [$first_date->toDateString(), $last_date->toDateString()])

            ->get();
        return $result;
    }

    public static function getLSDPurchases()
    {
        $first_date = Carbon::now()->subDays(7);
        $last_date = Carbon::yesterday();
        $result = DB::table('purchases')
            ->select(DB::raw('sum(amount) as amount'))
            ->whereBetween('purchase_date',  [$first_date->toDateString(), $last_date->toDateString()])
            ->get();
        return $result;
    }
   
    //for Reports
    public static function purchase_report($first, $last)
    {
        $result = DB::table('purchases')
            ->select(DB::raw('purchases.order_number, purchases.purchase_date as date, purchases.amount'))
            ->whereBetween('purchases.purchase_date', [$first, $last])
            ->orderBy('purchases.purchase_date', 'desc')
            ->get();
        return $result;
    }
    public static function refill_report($first, $last)
    {

        $result = DB::table('system_transactions')
            ->join('users as agent', 'agent.id', '=', 'system_transactions.to_agent')
            ->join('users as staff', 'staff.id', '=', 'system_transactions.performed_by')
            ->select(DB::raw('agent.name as agent_name, DATE(system_transactions.created_at) as date, system_transactions.commission, system_transactions.amount, staff.name as staff_name'))
            ->whereBetween('system_transactions.created_at', [$first, $last])
            ->orderBy('date', 'desc')
            ->get();
        //dd($result);
        return $result;
    }
    public static function staff_refill_report($first, $last, $staff)
    {

        $system_refill = DB::table('system_transactions')
            ->join('users as staff', 'staff.id', '=', 'system_transactions.performed_by')
            ->join('users as agent', 'agent.id', '=', 'system_transactions.to_agent')

            ->select(DB::raw('agent.name as agent_name, DATE(system_transactions.created_at) as date, system_transactions.commission, system_transactions.amount, staff.name as staff_name'))
            ->where('system_transactions.to_agent', $staff)
            ->whereBetween('system_transactions.created_at', [$first, $last])
            ->orderBy('date', 'desc')
            ->get();
        $agent_refill = DB::table('transactions')
            ->join('users as from_agent', 'from_agent.id', '=', 'transactions.from_agent')
            ->join('users as to_agent', 'to_agent.id', '=', 'transactions.to_agent')

            ->select(DB::raw('from_agent.name as from_name, DATE(transactions.created_at) as date, to_agent.commission, transactions.amount, to_agent.name as to_name'))
            ->where('transactions.to_agent', $staff)
            ->whereBetween('transactions.created_at', [$first, $last])
            ->orderBy('date', 'desc')
            ->get();
        //dd($result);
        return ['system_refills' => $system_refill, 'agent_refills' => $agent_refill];
    }
    public static function main_agent_refill_report($first, $last)
    {
        $staffs = User::where('parent_id', 1)->orWhere('id', '1')->get('id');

        $result = DB::table('transactions')
            ->join('users as agent', 'agent.id', '=', 'transactions.to_agent')
            ->join('users as staff', 'staff.id', '=', 'transactions.from_agent')
            ->whereIn('transactions.from_agent', $staffs)
            ->select(DB::raw('agent.id as agent_id, agent.name as agent_name, agent.phone_number as agent_phone, AVG(transactions.commission) as commission, SUM(transactions.amount) as amount, staff.name as staff_name, staff.id as staff_id'))
            ->whereBetween('transactions.created_at', [$first, $last])
            ->groupBy('agent_id')
            ->groupBy('agent_name')
            ->groupBy('agent_phone')
            ->groupBy('staff_name')
            ->groupBy('staff_id')
            ->get();
        //dd($result);
        return $result;
    }
    public static function main_agent_refill_invoice($first, $last, $staff_id, $agent_id)
    {

        $result = DB::table('transactions')
            ->join('users as agent', 'agent.id', '=', 'transactions.to_agent')
            ->join('users as staff', 'staff.id', '=', 'transactions.from_agent')
            ->where('transactions.from_agent', $staff_id)
            ->select(DB::raw('DATE(transactions.created_at) as date, transactions.commission, transactions.amount'))
            ->whereBetween('transactions.created_at', [$first, $last])
            ->where('staff.id', $staff_id)
            ->where('agent.id', $agent_id)
            ->orderBy('date', 'desc')
            ->get();
        //dd($result);
        return $result;
    }
    public static function collection_report($first, $last)
    {
        $staffs = User::where('parent_id', 1)->orWhere('id', '1')->get();
        $staffs_id = User::where('parent_id', 1)->orWhere('id', '1')->get('id')->toArray();

        //dd($staffs);
        $result = [];

        //dd($staffs_id);

        foreach ($staffs as $staff) {
            $fills = Transaction::where('from_agent', $staff->id)
                ->select(DB::raw('SUM((100-commission)*0.01*amount) as collection,SUM(amount) as fill'))
                ->whereBetween('created_at', [$first, $last])
                ->first();
            $deposits = System_deposit::where('user_id', $staff->id)
                ->where('status', 1)
                ->select(DB::raw('SUM(amount) as deposit'))
                ->whereBetween('created_at', [$first, $last])
                ->first();
            $refills = System_transaction::where('to_agent', $staff->id)
                ->select(DB::raw('SUM((100-commission)*0.01*amount) as receivable,SUM(amount) as refill'))
                ->whereBetween('created_at', [$first, $last])
                ->first();
            $sfills = System_transaction::where('performed_by', $staff->id)
                ->whereNotIn('to_agent', $staffs_id)
                ->select(DB::raw('SUM((100-commission)*0.01*amount) as receivable,SUM(amount) as refill'))
                ->whereBetween('created_at', [$first, $last])
                ->first();
            $beginning_balance = Balance::where('user_id', $staff->id)
                ->select('balance')
                ->where('created_at', '<=', $first)
                ->orderBy('id', 'desc')
                ->limit(1)
                ->first();
            $ending_balance = Balance::where('user_id', $staff->id)
                ->select('balance')
                ->where('created_at', '<=', $last)
                ->orderBy('id', 'desc')
                ->limit(1)
                ->first();
            /*$beginning_debt = Debt::where('user_id', $staff->id)
                ->select('debt')
                ->where('created_at', '<=', $first)
                ->orderBy('id', 'desc')
                ->limit(1)
                ->first();
            $ending_debt = Debt::where('user_id', $staff->id)
                ->select('debt')
                ->where('created_at', '<=', $last)
                ->orderBy('id', 'desc')
                ->limit(1)
                ->first();*/

            $result[] =
                [
                    'name' => $staff->name,
                    'phone_number' => $staff->phone_number,
                    'fill' => isset($fills->fill) ? $fills->fill : 0,
                    'collection' => isset($fills->collection) ? $fills->collection : 0,
                    'deposit' => isset($deposits->deposit) ? $deposits->deposit : 0,
                    'refill' => isset($refills->refill) ? $refills->refill : 0,
                    'sfill' => isset($sfills->fill) ? $sfills->fill : 0,
                    'sreceivable' => isset($sfills->receivable) ? $sfills->receivable : 0,
                    'receivable' => isset($refills->receivable) ? $refills->receivable : 0,
                    'beginning_balance' => isset($beginning_balance->balance) ? $beginning_balance->balance : 0,
                    'ending_balance' => isset($ending_balance->balance) ? $ending_balance->balance : 0,
                ];
        }
        //dd($result);
        //dd($result);
        return $result;
    }
    public static function collection_report_total()
    {
        $staffs = User::where('parent_id', 1)->orWhere('id', '1')->get();
        //dd($staffs);
        $result = [];
        $fill = 0;
        $receivable = 0;
        $deposit = 0;
        $refill = 0;
        foreach ($staffs as $staff) {
            $fills = Transaction::where('from_agent', $staff->id)
                ->select(DB::raw('SUM((100-commission)*0.01*amount) as collection,SUM(amount) as fill'))
                ->first();
            $debt = Debt::where('user_id', $staff->id)
                ->select('debt')
                ->orderBy('id', 'desc')
                ->first();
            $fill += $fills->fill;
            $receivable += isset($debt->debt) ? $debt->debt : 0;
            $deposits = System_deposit::where('user_id', $staff->id)
                ->where('status', 1)
                ->select(DB::raw('SUM(amount) as deposit'))
                ->first();
            $deposit += $deposits->deposit;
            $refills = System_transaction::where('to_agent', $staff->id)
                ->select(DB::raw('SUM((100-commission)*0.01*amount) as receivable,SUM(amount) as refill'))
                ->first();
            $refill += $refills->refill;

            /* $result[] =
                [
                    'name' => $staff->name,
                    'phone_number' => $staff->phone_number,
                    'fill' => isset($fills->fill) ? $fills->fill : 0,
                    'collection' => isset($fills->collection) ? $fills->collection : 0,
                    'deposit' => isset($deposits->deposit) ? $deposits->deposit : 0,
                    'refill' => isset($refills->refill) ? $refills->refill : 0,
                    'receivable' => isset($refills->receivable) ? $refills->receivable : 0,
                   ];*/
        }
        //dd($result);
        //dd($result);
        $result = [
            'fill' => $fill,
            'deposit' => $deposit,
            'refill' => $refill,
            'receivable' => $receivable,
        ];
        return $result;
    }
    public static function agent_collection_report($first, $last, $staff)
    {
        $agents = Transaction::where('from_agent', $staff->id)
            ->whereBetween('created_at', [$first, $last])
            ->groupBy('to_agent')
            ->get('to_agent');
        //dd($staffs);
        $result = [];
        foreach ($agents as $agent) {
            $fills = Transaction::where('from_agent', $staff->id)
                ->where('to_agent', $agent->to_agent)
                ->select(DB::raw('SUM((100-commission)*0.01*amount) as collection,SUM(amount) as fill'))
                ->whereBetween('created_at', [$first, $last])
                ->first();
            $deposits = System_deposit::where('user_id', $staff->id)
                ->where('deposited_by', $agent->to_agent)
                ->where('status', 1)
                ->select(DB::raw('SUM(amount) as deposit'))
                ->whereBetween('created_at', [$first, $last])
                ->first();
            $user = User::where('id', $agent->to_agent)->first();
            //   dd($agent);
            $result[] =
                [
                    'name' => $user->name,
                    'phone_number' => $user->phone_number,
                    'fill' => isset($fills->fill) ? $fills->fill : 0,
                    'collection' => isset($fills->collection) ? $fills->collection : 0,
                    'deposit' => isset($deposits->deposit) ? $deposits->deposit : 0,
                ];
        }
        //dd($result);
        //dd($result);
        return $result;
    }

    public static function agent_refill_report($first, $last)
    {

        $result = DB::table('transactions')
            ->join('users as from_agent', 'from_agent.id', '=', 'transactions.from_agent')
            ->join('users as to_agent', 'to_agent.id', '=', 'transactions.to_agent')
            ->select(DB::raw('from_agent.name as from_name, DATE(transactions.created_at) as date, to_agent.commission, transactions.amount, to_agent.name as to_name'))
            ->whereBetween('transactions.created_at', [$first, $last])
            ->orderBy('date', 'desc')
            ->get();
        //dd($result);
        return $result;
    }
    public static function agent_sales_report($first, $last)
    {
        //$now=Carbon::now();
        //DB::enableQueryLog();

        $result = DB::table('sales_stats')
            ->join('users', 'sales_stats.user_id', '=', 'users.id')
            ->select('users.name', 'users.phone_number', DB::raw('SUM(amount) as amount, sales_stats.sales_date as date'))
            ->whereBetween('sales_stats.sales_date', [$first, $last])
            ->groupBy('name')
            ->groupBy('phone_number')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get();
        return $result;
    }
    public static function single_agent_sales_report($first, $last, $agent)
    {
        //$now=Carbon::now();
        //DB::enableQueryLog();

        $result = DB::table('sales_stats')
            
            ->select( DB::raw('SUM(sales_stats.amount) as amount, sales_stats.sales_date as date'))
            ->where('sales_stats.user_id', $agent)
            ->whereBetween('sales_stats.sales_date', [$first, $last]) 
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get();
        return $result;
    }
    public static function agent_today_sales_report($agent)
    {
        $result = DB::table('yimulu_sales')
           
            
            ->select(DB::raw('SUM(amount) as amount, DATE(yimulu_sales.created_at) as date'))
            ->where('yimulu_sales.user_id', $agent)
            ->whereBetween('yimulu_sales.created_at', [Carbon::now()->startOfDay(), Carbon::now()])
            
            ->groupBy('date')
            ->first();
        return $result;
    }
    public static function today_sales_report($agent)
    {
        $result = DB::table('yimulu_sales')
            ->select(DB::raw('SUM(amount) as amount, DATE(yimulu_sales.created_at) as date'))
            ->whereBetween('created_at', [Carbon::now()->startOfDay(), Carbon::now()])
            ->groupBy('date')
            ->first();
        return $result;
    }
    public static function sales_report($first, $last)
    {
        //$now=Carbon::now();
        //DB::enableQueryLog();
        $result = DB::table('sales_stats')
            ->select(DB::raw('SUM(amount) as amount,sales_date as date'))
            ->whereBetween('sales_date', [$first, $last])
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get();

        return $result;
    }
    public static function staff_sales_report($first, $last, $staff)
    {
        //$now=Carbon::now();
        //DB::enableQueryLog();

        $result = DB::table('sales_stats')
            ->select(DB::raw('SUM(amount) as amount, sales_stats.sales_date as date'))
            ->whereBetween('sales_stats.sales_date', [$first, $last])
            ->where('sales_stats.user_id', $staff)
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get();
        return $result;
    }

    //for agent reports

    public static function getSalesStatAgent($agent)
    {
        $td_date = Carbon::now()->startOfDay();
        $wd_date = Carbon::now()->startOfWeek();
        $md_date = Carbon::now()->startOfMonth();
        $yd_date = Carbon::now()->startOfYear();
        $last_date = Carbon::now();
        $yesterday = Carbon::yesterday();

        $ytd = DB::table('sales_stats')
            ->select(DB::raw('SUM(amount) as total'))
            ->whereBetween('sales_stats.sales_date', [$yd_date->toDateString(), $yesterday->toDateString()])
            ->where('sales_stats.user_id', $agent)
            ->first();
        $mtd = DB::table('sales_stats')
            ->select(DB::raw('SUM(amount) as total'))
            ->whereBetween('sales_stats.sales_date', [$md_date->toDateString(), $yesterday->toDateString()])
            ->where('sales_stats.user_id', $agent)
            ->first();
        $wtd = DB::table('sales_stats')
            ->select(DB::raw('SUM(amount) as total'))
            ->whereBetween('sales_stats.sales_date', [$wd_date->toDateString(), $yesterday->toDateString()])
            ->where('sales_stats.user_id', $agent)
            ->first();
        $td = DB::table('yimulu_sales')
            ->select(DB::raw('SUM(amount) as total'))
            ->whereBetween('yimulu_sales.created_at', [$td_date, $last_date])
            ->where('yimulu_sales.user_id', $agent)
            ->first();
        return ['wtd' => $td->total + $wtd->total + 0, 'mtd' => $td->total + $mtd->total + 0, 'ytd' => $td->total + $ytd->total + 0, 'td' => $td->total + 0];
    }
   

    public static function getRefillStatAgent($agent)
    {
        $td_date = Carbon::now()->startOfDay();
        $wd_date = Carbon::now()->startOfWeek();
        $md_date = Carbon::now()->startOfMonth();
        $yd_date = Carbon::now()->startOfYear();
        $last_date = Carbon::now();

        $ytd = DB::table('transactions')
            ->join('users', 'users.id', '=', 'transactions.to_agent')
            ->select(DB::raw('SUM(transactions.amount) as refill'))
            ->where('transactions.to_agent', $agent)
            ->whereBetween('transactions.created_at', [$yd_date, $last_date])
            ->first();
        $mtd =  DB::table('transactions')
            ->join('users', 'users.id', '=', 'transactions.to_agent')
            ->select(DB::raw('SUM(transactions.amount) as refill'))
            ->where('transactions.to_agent', $agent)
            ->whereBetween('transactions.created_at', [$md_date, $last_date])
            ->first();
        $wtd =  DB::table('transactions')
            ->join('users', 'users.id', '=', 'transactions.to_agent')
            ->select(DB::raw('SUM(transactions.amount) as refill'))
            ->where('transactions.to_agent', $agent)
            ->whereBetween('transactions.created_at', [Carbon::now()->startOfWeek(), Carbon::now()])
            ->first();
        $td =  DB::table('transactions')
            ->join('users', 'users.id', '=', 'transactions.to_agent')
            ->select(DB::raw('SUM(transactions.amount) as refill'))
            ->where('transactions.to_agent', $agent)
            ->whereBetween('transactions.created_at', [$td_date, $last_date])
            ->first();
        return ['wtd' => $wtd->refill + 0, 'mtd' => $mtd->refill + 0, 'ytd' => $ytd->refill + 0, 'td' => $td->refill + 0];
    }
    public static function getSystemRefillStatAgent($agent)
    {
        $td_date = Carbon::now()->startOfDay();
        $wd_date = Carbon::now()->startOfWeek();
        $md_date = Carbon::now()->startOfMonth();
        $yd_date = Carbon::now()->startOfYear();
        $last_date = Carbon::now();
        $ytd = DB::table('system_transactions')
            ->join('users', 'users.id', '=', 'system_transactions.to_agent')
            ->select(DB::raw('SUM(system_transactions.amount) as refill'))
            ->where('system_transactions.to_agent', $agent)
            ->whereBetween('system_transactions.created_at', [$yd_date, $last_date])
            ->first();
        $mtd =  DB::table('system_transactions')
            ->join('users', 'users.id', '=', 'system_transactions.to_agent')
            ->select(DB::raw('SUM(system_transactions.amount) as refill'))
            ->where('system_transactions.to_agent', $agent)
            ->whereBetween('system_transactions.created_at', [$md_date, $last_date])
            ->first();
        $wtd =  DB::table('system_transactions')
            ->join('users', 'users.id', '=', 'system_transactions.to_agent')
            ->select(DB::raw('SUM(system_transactions.amount) as refill'))
            ->where('system_transactions.to_agent', $agent)
            ->whereBetween('system_transactions.created_at', [Carbon::now()->startOfWeek(), Carbon::now()])
            ->first();
        $td =  DB::table('system_transactions')
            ->join('users', 'users.id', '=', 'system_transactions.to_agent')
            ->select(DB::raw('SUM(system_transactions.amount) as refill'))
            ->where('system_transactions.to_agent', $agent)
            ->whereBetween('system_transactions.created_at', [$td_date, $last_date])
            ->first();
        return ['wtd' => $wtd->refill + 0, 'mtd' => $mtd->refill + 0, 'ytd' => $ytd->refill + 0, 'td' => $td->refill + 0];
    }
    public static function getLastMonthSystemRefillToAgent($agent)
    {
        //dd([Carbon::now()->firstOfMonth()->subMonth()->startOfMonth(),Carbon::now()->firstOfMonth()->subMonth()->endOfMonth()]);
        $sys_refill = DB::table('system_transactions')
            ->select(DB::raw('SUM(system_transactions.amount) as total'))
            ->where('system_transactions.to_agent', $agent)
            ->whereBetween('system_transactions.created_at', [Carbon::now()->firstOfMonth()->subMonth()->startOfMonth(), Carbon::now()->firstOfMonth()->subMonth()->endOfMonth()])
            ->first();
        $agent_refill = DB::table('transactions')
            ->select(DB::raw('SUM(transactions.amount) as total'))
            ->where('transactions.to_agent', $agent)
            ->whereBetween('transactions.created_at', [Carbon::now()->firstOfMonth()->subMonth()->startOfMonth(), Carbon::now()->firstOfMonth()->subMonth()->endOfMonth()])
            ->first();
        return ($sys_refill->total + $agent_refill->total) + 0;
    }
    public static function getFillStatAgent($agent)
    {
        $td_date = Carbon::now()->startOfDay();
        $wd_date = Carbon::now()->startOfWeek();
        $md_date = Carbon::now()->startOfMonth();
        $yd_date = Carbon::now()->startOfYear();
        $last_date = Carbon::now();

        $ytd = DB::table('transactions')
            ->join('users', 'users.id', '=', 'transactions.from_agent')
            ->select(DB::raw('SUM(transactions.amount) as refill'))
            ->where('transactions.from_agent', $agent)
            ->whereBetween('transactions.created_at', [$yd_date, $last_date])
            ->first();
        $mtd =  DB::table('transactions')
            ->join('users', 'users.id', '=', 'transactions.from_agent')
            ->select(DB::raw('SUM(transactions.amount) as refill'))
            ->where('transactions.from_agent', $agent)
            ->whereBetween('transactions.created_at', [$md_date, $last_date])
            ->first();
        $wtd =  DB::table('transactions')
            ->join('users', 'users.id', '=', 'transactions.from_agent')
            ->select(DB::raw('SUM(transactions.amount) as refill'))
            ->where('transactions.from_agent', $agent)
            ->whereBetween('transactions.created_at', [Carbon::now()->startOfWeek(), Carbon::now()])
            ->first();
        $td =  DB::table('transactions')
            ->join('users', 'users.id', '=', 'transactions.from_agent')
            ->select(DB::raw('SUM(transactions.amount) as refill'))
            ->where('transactions.from_agent', $agent)
            ->whereBetween('transactions.created_at', [$td_date, $last_date])
            ->first();
        return ['wtd' => $wtd->refill + 0, 'mtd' => $mtd->refill + 0, 'ytd' => $ytd->refill + 0, 'td' => $td->refill + 0];
    }



    public static function getTopAgentStats()
    {
        $yimulu_sales= DB::table('sales_stats')
            ->join('users', 'users.id', '=', 'sales_stats.user_id')
            ->select('users.name', 'users.name', DB::raw('SUM(amount) as amount'))
            ->whereBetween('sales_stats.sales_date', [Carbon::now()->firstOfMonth()->toDateString(), Carbon::now()->toDateString()])
            ->groupBy('users.name', 'users.phone_number')
            ->orderBy('amount', 'desc')
            ->limit(5)
            ->get();
        $staff_agents = User::where('parent_id', 1)->get('id');

        $first_levels_sales = DB::table('transactions')
            ->join('users', 'users.id', '=', 'transactions.from_agent')
            ->select('users.name', 'users.name', DB::raw('SUM(transactions.amount) as amount'))
            ->whereIn('users.parent_id', $staff_agents)
            ->WhereBetween('transactions.created_at', [Carbon::now()->firstOfMonth(), Carbon::now()])
            ->groupBy('users.name', 'users.phone_number')
            ->orderBy('amount', 'desc')
            ->limit(5)
            ->get();
        $other_levels_sales = DB::table('transactions')
            ->join('users', 'users.id', '=', 'transactions.from_agent')
            ->select('users.name', 'users.name', DB::raw('SUM(transactions.amount) as amount'))
            ->whereNotIn('users.parent_id', $staff_agents)
            ->where('users.parent_id', '!=', 1)
            ->WhereBetween('transactions.created_at', [Carbon::now()->firstOfMonth(), Carbon::now()])
            ->groupBy('users.name', 'users.phone_number')
            ->orderBy('amount', 'desc')
            ->limit(5)
            ->get();
        return ['yimulu_sales' => $yimulu_sales, 'first' => $first_levels_sales, 'second' => $other_levels_sales];
    }
}
