<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\StatController;
use App\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\User;
use Illuminate\Support\Facades\Auth;
use View;
use Barryvdh\DomPDF\Facade as PDF;

class ReportController extends Controller
{
    //
    public function purchase(Request $request)
    {
        $first_date = Carbon::now()->firstOfMonth();
        $last_date = Carbon::now();
        //dd($first_date);
        if (isset($request->first_date) && isset($request->last_date)) {
            $first_date = $request->first_date;
            $last_date = $request->last_date;
        } elseif (isset($request->first_date)) {
            $first_date = $request->first_date;
            $last_date = $request->first_date;
        } elseif (isset($request->last_date)) {
            $first_date = $request->last_date;
            $last_date = $request->last_date;
        }
        $last_date=new Carbon($last_date);
        $last_date=$last_date->endOfDay();
        //dd($first_date);
        $purchases = StatController::purchase_report($first_date, $last_date);
        return view('admin.reports.purchase', ['purchases' => $purchases, 'first_date' => $first_date, 'last_date' => $last_date]);
    }
    public function refill(Request $request)
    {
        $first_date = Carbon::now()->firstOfMonth();
        $last_date = Carbon::now();
        //dd($first_date);
        if (isset($request->first_date) && isset($request->last_date)) {
            $first_date = $request->first_date;
            $last_date = $request->last_date;
        } elseif (isset($request->first_date)) {
            $first_date = $request->first_date;
            $last_date = $request->first_date;
        } elseif (isset($request->last_date)) {
            $first_date = $request->last_date;
            $last_date = $request->last_date;
        }
        $last_date=new Carbon($last_date);
        $last_date=$last_date->endOfDay();
        //dd($first_date);
        $refills = StatController::refill_report($first_date, $last_date);
        return view('admin.reports.refills', ['refills' => $refills, 'first_date' => $first_date, 'last_date' => $last_date]);
    }
    public function staffRefill(Request $request)
    {
        $first_date = Carbon::now()->firstOfMonth();
        $last_date = Carbon::now();
        //dd($first_date);
        $staff=Auth::user();
        if (isset($request->first_date) && isset($request->last_date)) {
            $first_date = $request->first_date;
            $last_date = $request->last_date;
        } elseif (isset($request->first_date)) {
            $first_date = $request->first_date;
            $last_date = $request->first_date;
        } elseif (isset($request->last_date)) {
            $first_date = $request->last_date;
            $last_date = $request->last_date;
        }
        $last_date=new Carbon($last_date);
        $last_date=$last_date->endOfDay();
        //dd($first_date);
        $refills = StatController::staff_refill_report($first_date, $last_date,$staff->id);
       // dd($refills);
        return view('admin.reports.staffrefills', ['system_refills'=>$refills['system_refills'],'agent_refills'=>$refills['agent_refills'], 'first_date' => $first_date, 'last_date' => $last_date]);
    }
    public function mainAgentsRefill(Request $request)
    {
        $first_date = Carbon::now()->firstOfMonth();
        $last_date = Carbon::now();
        //dd($first_date);
        if (isset($request->first_date) && isset($request->last_date)) {
            $first_date = $request->first_date;
            $last_date = $request->last_date;
        } elseif (isset($request->first_date)) {
            $first_date = $request->first_date;
            $last_date = $request->first_date;
        } elseif (isset($request->last_date)) {
            $first_date = $request->last_date;
            $last_date = $request->last_date;
        }
        $last_date=new Carbon($last_date);
        $last_date=$last_date->endOfDay();
        //dd($first_date);
        $refills = StatController::main_agent_refill_report($first_date, $last_date);
        return view('admin.reports.invoice', ['refills' => $refills, 'first_date' => $first_date, 'last_date' => $last_date]);
    }
    public function agentrefill(Request $request)
    {
        $first_date = Carbon::now()->firstOfMonth();
        $last_date = Carbon::now();
        //dd($first_date);
        if (isset($request->first_date) && isset($request->last_date)) {
            $first_date = $request->first_date;
            $last_date = $request->last_date;
        } elseif (isset($request->first_date)) {
            $first_date = $request->first_date;
            $last_date = $request->first_date;
        } elseif (isset($request->last_date)) {
            $first_date = $request->last_date;
            $last_date = $request->last_date;
        }
        $last_date=new Carbon($last_date);
        $last_date=$last_date->endOfDay();
        //dd($first_date);
        $refills = StatController::agent_refill_report($first_date, $last_date);
        return view('admin.reports.agentrefills', ['refills' => $refills, 'first_date' => $first_date, 'last_date' => $last_date]);
    }
    public function agentsales(Request $request)
    {
        $first_date = Carbon::now()->firstOfMonth();
        $last_date = Carbon::now();
        //dd($first_date);
        if (isset($request->first_date) && isset($request->last_date)) {
            $first_date = $request->first_date;
            $last_date = $request->last_date;
        } elseif (isset($request->first_date)) {
            $first_date = $request->first_date;
            $last_date = $request->first_date;
        } elseif (isset($request->last_date)) {
            $first_date = $request->last_date;
            $last_date = $request->last_date;
        }
        $last_date=new Carbon($last_date);
        $last_date=$last_date->endOfDay();
        //dd($first_date);
        $sales = StatController::agent_sales_report($first_date, $last_date);
        // dd($sales);
        return view('admin.reports.agentsales', ['sales' => $sales, 'first_date' => $first_date, 'last_date' => $last_date]);
    }
    public function singleagentsales(Request $request)
    {
        $first_date = Carbon::now()->firstOfMonth();
        $last_date = Carbon::now();
        //dd($first_date);
        $agent=auth::user();
        //dd($agent);
        if(isset($request->agent_id))
        {
            $agent=User::where('id', $request->agent_id)->first();
        }
        if (isset($request->first_date) && isset($request->last_date)) {
            $first_date = $request->first_date;
            $last_date = $request->last_date;
        } elseif (isset($request->first_date)) {
            $first_date = $request->first_date;
            $last_date = $request->first_date;
        } elseif (isset($request->last_date)) {
            $first_date = $request->last_date;
            $last_date = $request->last_date;
        }
        $ld=$last_date;
        $last_date=new Carbon($last_date);
        $last_date=$last_date->endOfDay();
        //dd($first_date);
        $sales = StatController::single_agent_sales_report($first_date, $last_date, $agent->id);
        // dd($sales);
        return view('admin.reports.singleagentsales', ['sales' => $sales, 'agent'=>$agent, 'first_date' => $first_date, 'last_date' => $ld]);
    }
    public function singleagenttxs(Request $request)
    {
        $first_date = Carbon::now()->firstOfMonth();
        $last_date = Carbon::now();
        //dd($first_date);
        $agent=auth::user();
        //dd($agent);
        if(isset($request->agent_id))
        {
            $agent=User::where('id', $request->agent_id)->first();
        }
        if (isset($request->first_date) && isset($request->last_date)) {
            $first_date = $request->first_date;
            $last_date = $request->last_date;
        } elseif (isset($request->first_date)) {
            $first_date = $request->first_date;
            $last_date = $request->first_date;
        } elseif (isset($request->last_date)) {
            $first_date = $request->last_date;
            $last_date = $request->last_date;
        }
        $ld=$last_date;
        $last_date=new Carbon($last_date);
        $last_date=$last_date->endOfDay();
        //dd($first_date);
        $transaction_details = StatController::getAgentTransactionsDetailsReport($first_date, $last_date, $agent->id);
        // dd($sales);
        return view('admin.reports.singleagenttxs', ['transaction_details' => $transaction_details, 'agent'=>$agent, 'first_date' => $first_date, 'last_date' => $ld]);
    }
    public function sales(Request $request)
    {
        $first_date = Carbon::now()->firstOfMonth();
        $last_date = Carbon::now();
        //dd($first_date);
        if (isset($request->first_date) && isset($request->last_date)) {
            $first_date = $request->first_date;
            $last_date = $request->last_date;
        } elseif (isset($request->first_date)) {
            $first_date = $request->first_date;
            $last_date = $request->first_date;
        } elseif (isset($request->last_date)) {
            $first_date = $request->last_date;
            $last_date = $request->last_date;
        }
        $last_date=new Carbon($last_date);
        $last_date=$last_date->endOfDay();
        //dd($first_date);
        $last_date=new Carbon($last_date);
        $last_date=$last_date->endOfDay();
        $sales = StatController::sales_report($first_date, $last_date);
        // dd($sales);
        return view('admin.reports.sales', ['sales' => $sales, 'first_date' => $first_date, 'last_date' => $last_date]);
    }
    public function staffSales(Request $request)
    {
        $staff=Auth::user();
        $first_date = Carbon::now()->firstOfMonth();
        $last_date = Carbon::now();
        //dd($first_date);
        if (isset($request->first_date) && isset($request->last_date)) {
            $first_date = $request->first_date;
            $last_date = $request->last_date;
        } elseif (isset($request->first_date)) {
            $first_date = $request->first_date;
            $last_date = $request->first_date;
        } elseif (isset($request->last_date)) {
            $first_date = $request->last_date;
            $last_date = $request->last_date;
        }
        $last_date=new Carbon($last_date);
        $last_date=$last_date->endOfDay();
        //dd($first_date);
        $sales = StatController::staff_sales_report($first_date, $last_date,$staff->id);
        // dd($sales);
        return view('admin.reports.staffsales', ['sales' => $sales, 'first_date' => $first_date, 'last_date' => $last_date]);
    }
    public function collections(Request $request)
    {
        $first_date = Carbon::now()->firstOfMonth();
        $last_date = Carbon::now();
        //dd($first_date);
        if (isset($request->first_date) && isset($request->last_date)) {
            $first_date = $request->first_date;
            $last_date = $request->last_date;
        } elseif (isset($request->first_date)) {
            $first_date = $request->first_date;
            $last_date = $request->first_date;
        } elseif (isset($request->last_date)) {
            $first_date = $request->last_date;
            $last_date = $request->last_date;
        }
        $last_date=new Carbon($last_date);
        $last_date=$last_date->endOfDay();
        //dd($first_date);
        $collection = StatController::collection_report($first_date, $last_date);
        //dd($collection);
        return view('admin.reports.collections', ['collections' => $collection, 'first_date' => $first_date, 'last_date' => $last_date]);
    }
    public function agentCollections(Request $request)
    {
        $first_date = Carbon::now()->firstOfMonth();
        $last_date = Carbon::now();
        $staff=Auth::user();

        //dd($first_date);
        if (isset($request->first_date) && isset($request->last_date)) {
            $first_date = $request->first_date;
            $last_date = $request->last_date;
        } elseif (isset($request->first_date)) {
            $first_date = $request->first_date;
            $last_date = $request->first_date;
        } elseif (isset($request->last_date)) {
            $first_date = $request->last_date;
            $last_date = $request->last_date;
        
        }
        $last_date=new Carbon($last_date);
        $last_date=$last_date->endOfDay();
        //dd($first_date);
        $collection = StatController::agent_collection_report($first_date, $last_date,$staff);
       //dd($collection);
        return view('admin.reports.agentcollections', ['collections' => $collection, 'first_date' => $first_date, 'last_date' => $last_date]);
    }
 
    public function invoice(Request $request)
    {
        $data = StatController::main_agent_refill_invoice($request->first_date, $request->last_date, $request->staff_id, $request->agent_id);
        //dd($data);
        $agent = User::where('id', $request->agent_id)->first();
        $staff = User::where('id', $request->staff_id)->first();
        $invoice = new Invoice();
        $invoice->staff_id = $staff->id;
        $invoice->agent_id = $agent->id;
        $invoice->date_from = $request->first_date;
        $invoice->date_to = $request->last_date;
        if ($invoice->save()) {
            $pdf = PDF::loadView('admin.reports.invoiceprint', ['to_name' => $agent->name, 'to_phone' => $agent->phone_number, 'invoices' => $data, 'staff_name' => $staff->name,'id'=>$invoice->id,'date'=>date('Y-m-d')]);

            return $pdf->download('invoice.pdf');
        }

        return back()->with('error_message', "Couldn't make the invoice");
        // return $pdf->download('disney.pdf');
        //$dompdf->stream("dompdf_out.pdf", array("Attachment" => true));
        //exit(0);
    }
}
