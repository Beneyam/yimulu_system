<?php

namespace App\Http\Controllers;

use App\Conversion;
use Illuminate\Http\Request;
use App\System_balance;
use App\yimulu_sales;
use Illuminate\Support\Facades\DB;
use App\User;
use Auth;
use Illuminate\Support\Facades\Artisan;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $agent=Auth::user();
        if ($agent->hasAnyRoles(['admin','finance'])) {
            /*$system_balance=StatController::getSystemBalance();
            $system_cards=StatController::getRemainingCards();
            $agentsStats=StatController::getTotalAgentStats();
            $user_stats=StatController::getAllAgentStat();
            $sales=StatController::getTodaysSales();
            $txs=StatController::getTodaysRefills();
            $collections=StatController::collection_report_total();*/
            //$comparisons=StatController::getComparisonStats();
            //  $card_stats=StatController::getRemainingCardStats();
            //return view('home', ['system_balance'=>$system_balance,'system_cards'=>$system_cards,'agentsBalance'=>$agentsStats['balance'],'agentsDebt'=>$agentsStats['debt'],'yimulu_sales'=>$sales,'txs'=>$txs,'user_stat'=>$user_stats,'comparisons'=>$comparisons, 'card_stats'=>$card_stats, 'collections'=>$collections]);
            // Artisan::queue('send:message');
            $conversions=Conversion::limit(5)->get();
            return view('home',['conversions'=>$conversions]);
        }
        elseif($agent->hasRole('staff-agent'))
        {
            $stat= StatController::GetAgentStatDashboard($agent);
           
            return view('agenthome',$stat);
        }
    }
    
    
}
