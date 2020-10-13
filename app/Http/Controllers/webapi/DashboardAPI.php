<?php

namespace App\Http\Controllers\webapi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\StatController;
use App\yimulu_sales_type;
use Illuminate\Support\Carbon;

class DashboardAPI extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    

    //
    public function getStats()
    {
        
        $system_balance = StatController::getSystemBalance(); //ok
    
        $txs=StatController::getTodaysRefills();//ok
        $txs_sta=isset($txs['system_to_agent']['total'])?($txs['system_to_agent']['total']):0;
        $txs_ata=isset($txs['agents_to_agents']['total'])?($txs['agents_to_agents']['total']):0;

        return response()->json(['system_balance' => $system_balance,'txsta'=>$txs_sta,'txata'=>$txs_ata]);
    }
   
    public function getAgentsStats()
    {
        
       
        $agentsStats = StatController::getTotalAgentStats();//separate
        // 'agentsBalance' => $agentsStats['balance'], 'agentsDebt' => $agentsStats['debt'], 'yimulu_sales'=>$todays_sales,'txsta'=>$txs_sta,'txata'=>$txs_ata,'agent_count'=>$user_stats['all_users'], 'new_agents'=>$user_stats['new_users'], 'active_agents'=>$user_stats['active_users']
        return response()->json(['agentsBalance' => $agentsStats['balance'], 'agentsDebt' => $agentsStats['debt']]);
    }
    public function getUsersStats()
    {
        $user_stats=StatController::getAllAgentStat();//separate
        // 'yimulu_sales'=>$todays_sales,'txsta'=>$txs_sta,'txata'=>$txs_ata,'agent_count'=>$user_stats['all_users'], 'new_agents'=>$user_stats['new_users'], 'active_agents'=>$user_stats['active_users']
        return response()->json(['agent_count'=>$user_stats['all_users'], 'new_agents'=>$user_stats['new_users'], 'active_agents'=>$user_stats['active_users']]);
    }
    public function getSales()
    {
    
        $sales=StatController::getTodaysSales();
        return response()->json([ 'yimulu_sales'=>$sales]);
 
    }
   
    public function getComparisons(){
        $comparisons=StatController::getComparisonStats();
        return response()->json($comparisons);

    }
    
    public function getSalesStat()
    {
        //$yimulu_sales_types=yimulu_sales_type::get();
        $sales=StatController::getTodaysSales();
        return response()->json([ 'yimulu_sales'=>$sales]);
 
    }
    public function getPurchasesStat()
    {
        /*$yimulu_sales_types=yimulu_sales_type::get();
        $data=[];
        foreach ($yimulu_sales_types as $yimulu_sales_type) {
            $ytd=StatController::getYTDPurchase2($yimulu_sales_type->id);
            $mtd=StatController::getMTDPurchase2($yimulu_sales_type->id);
            $wtd=StatController::getLSDPurchases2($yimulu_sales_type->id);
            $data[]=['type'=>$yimulu_sales_type->face_value,'ytd'=>$ytd->amount,'mtd'=>$mtd->amount,'wtd'=>$wtd->amount];
        }
        return $data;*/
    }
    public function getTopAgentStat()
    {
        return StatController::getTopAgentStats();
    }
  
}
