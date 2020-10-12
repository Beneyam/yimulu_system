<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\System_deposit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Gate;
use App\Bank;
use App\User;
use App\Debt;
use App\Http\Controllers\StatController;
use Illuminate\Support\Facades\DB;

class DepositController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {

        if (Gate::allows('verify-deposits')) {
            $deposits = DB::table('system_deposits')
                ->leftJoin('users as agent', 'agent.id', '=', 'system_deposits.deposited_by')
                ->join('banks', 'banks.id', '=', 'system_deposits.bank_id')
                ->join('users as staff', 'staff.id', '=', 'system_deposits.user_id')
                ->select(DB::raw('staff.name as staff, system_deposits.status, agent.name as agent, banks.name  as bank_name,banks.branch as branch_name, banks.account_number as account_number, system_deposits.amount as amount,system_deposits.id, system_deposits.ref_number as ref_number, system_deposits.remark,DATE(system_deposits.created_at) as date,system_deposits.deposit_date'))

                ->orderBy('system_deposits.id', 'desc')
                ->limit(1000)
                ->get();
        } else {
            $user = Auth::user();
            $deposits = DB::table('system_deposits')
                ->leftJoin('users as agent', 'agent.id', '=', 'system_deposits.deposited_by')
                ->join('banks', 'banks.id', '=', 'system_deposits.bank_id')
                ->join('users as staff', 'staff.id', '=', 'system_deposits.user_id')
                ->select(DB::raw('staff.name as staff, agent.name as agent, banks.name  as bank_name,banks.branch as branch_name, banks.account_number as account_number, system_deposits.amount as amount, system_deposits.ref_number as ref_number, system_deposits.remark, system_deposits.id,system_deposits.status,DATE(system_deposits.created_at) as date,system_deposits.deposit_date'))

                ->where('user_id', $user->id)
                ->orderBy('system_deposits.id', 'desc')
                ->limit(1000)
                ->get();
            //$deposits = System_deposit::where('user_id', $user->id)->orderBy('id', 'desc')->limit(1000)->get();
        }
        // dd($deposits);
        return view('admin.deposits.index', ['deposits' => $deposits]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if (Gate::denies('manage-others')) {
            return redirect(route('admin.deposits.index'));;
        }
        $banks = Bank::all();
        //$staffs = User::where('parent_id', 1)->orWhere('id', '1')->get('id');
        $user = Auth::user();

        $agents = User::where('parent_id', $user->id)->get();
        return view('admin.deposits.create', ['banks' => $banks, 'agents' => $agents]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::denies('manage-others')) {
            return redirect(route('admin.deposits.index'));;
        }
        $deposit = new System_deposit();
        $this->validateInput($request);
        $deposit->bank_id = $request['bank_id'];
        $user = Auth::user();
        $deposit->user_id = $user->id;
        $deposit->ref_number = $request['ref_number'];
        $deposit->amount = $request['amount'];
        $deposit->remark = $request['remark'];
        $deposit->deposited_by = $request['agent_id'];
        $deposit->deposit_date = $request['deposit_date'];
        $deposit->save();
        return redirect()->route('admin.deposits.index');
    }

    public function store2(Request $request)
    {
        if (Gate::denies('manage-others')) {
            return redirect(route('admin.deposits.index'));;
        }
        $deposit = new System_deposit();
        $this->validateInput($request);
        $deposit->bank_id = $request['bank_id'];
        $deposit->user_id = $request['user_id'];
        $deposit->ref_number = $request['ref_number'];
        $deposit->amount = $request['amount'];
        $deposit->remark = $request['remark'];
        $deposit->deposited_by = $request['agent_id'];
        $deposit->deposit_date = $request['deposit_date'];
        $deposit->save();
        return redirect()->route('admin.deposits.index');
    }
    public function show(System_deposit $deposit)
    {
        //
    }
    public function approve(Request $request)
    {
        $deposit = System_deposit::where('id', $request->id)->first();
        if (!isset($deposit->id)) {
            return back()->with('error_message', 'Invalid id');
        }
        if (Gate::denies('verify-deposits')) {
            return back()->with('error_message', 'No privilege');
        }
        $deposit->status = 1;
        $deposit->save();
        $user = User::where('id', $deposit->user_id)->first();
        $oldAgentDebt = StatController::getAgentDebt($user->id);

        $debt = new Debt();
        $debt->system_deposit_id = $deposit->id;
        $debt->beginning_debt = $oldAgentDebt;
        $debt->approved_by = Auth::user()->id;
        $debt->user_id = $user->id;
        $debt->debt = $oldAgentDebt - $deposit->amount;
        $debt->save();
        $agentbalanceupdate = DB::statement('UPDATE users SET debt=debt-' . $deposit->amount . ' WHERE id=' . $user->id);

        return back()->with('success', 'Successfully Approved');
    }
    public function cancel(Request $request)
    {
        //

        $deposit = System_deposit::where('id', $request->id)->first();
        if (!isset($deposit->id)) {
            return back()->with('error_message', 'Invalid id');
        }
        if (Gate::denies('verify-deposits')) {
            return back()->with('error_message', 'No privilege');
        }
        $deposit->status = 2;
        $deposit->save();

        return back()->with('success', 'Deposit Canceled');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function edit(deposit $deposit)
    {
        //
        /*
        //dd((Gate::denies('edit-deposit')));
       // dd($deposit->hasRole('Agent Manager'));
        if(Gate::denies('manage-system')){
            //dd($deposit->hasRole('Agent Manager'));
            return redirect(route('admin.deposit.index'));
        }
       // $deposit = deposit::find($id);
        //dd($deposit);
        // Redirect to product list if updating product wasn't existed
        if ($deposit == null || count($deposit->all()) == 0) {
            return redirect()->intended('/admin/deposits/index');
        }
        return view('admin.deposits.edit',['deposit'=>$deposit]);*/
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, deposit $deposit)
    {

        $this->validateInput($request);
        $deposit->bank_id = $request['bank_id'];
        $deposit->user_id = $request['user_id'];

        $deposit->save();
        return redirect()->route('admin.deposits.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\deposit  $deposit
     * @return \Illuminate\Http\Response
     */
    public function destroy(deposit $deposit)
    {
        //
    }
    private function validateInput($request)
    {
        $this->validate($request, [

            'bank_id' => 'required|numeric',
            'ref_number' => 'required',
            'remark' => 'max:300',

        ]);
    }
}
