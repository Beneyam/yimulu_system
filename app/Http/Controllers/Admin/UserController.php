<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use App\Balance;
use App\Debt;
use App\Http\Controllers\StatController;
use App\Logins;
use App\Parent_change;
use App\Print_paper;
use App\Terminal;
use App\Terminal_sale;
use App\Yimulu_sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Message;
use Validator;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        if (Gate::denies('manage-agents')) {
            //dd($user->hasRole('Agent Manager'));
            return back()->with('error_message', 'Unauthorized');
        }

        $manager = Auth::user();
        if (Gate::allows('manage-users')) {
            $users = User::all();
            //dd($users);
        } else {

            $users = User::where('id', '!=', '1')
                ->where('parent_id', $manager->id)

                ->get();           // ->where('ancestry', 'LIKE', '%[' . $manager->id . ']%')
        }
        // dd($users);
        return view('admin.users.index', ['users' => $users]);
    }
    public function staffAgents()
    {
        if (Gate::denies('manage-users')) {
            //dd($user->hasRole('Agent Manager'));
            return redirect(route('admin.users.index'));
        }

        $users = User::where('parent_id', 1)->where('id', '!=', '1')->get();
        // dd($users);
        return view('admin.users.staffAgents', ['users' => $users]);
    }

    public function changeParent(Request $request)
    {
        if (Gate::denies('manage-agents')) {
            //dd($user->hasRole('Agent Manager'));
            return back()->with('error_message', 'Not Authorized', 200);
        }
        $validator = Validator::make(
            $request->all(),
            [
                'user_id' => "required|numeric",
                'parent_id' => "required|numeric",
            ]
        );
        if ($validator->fails()) {
            $error = $validator->errors()->first();


            return back()->with('error_message', $error, 200);
        }
        $user = User::where('id', $request->user_id)->first();
        $parent = User::where('id', $request->parent_id)->first();
        // dd(isset($user->id));
        if (!isset($user->id) || !isset($parent->id)) {
            return back()->with('error_message', 'user or parent doesnt exist', 200);
        }
        $allsubagents = User::where('ancestry', 'like', '%[' . $user->id . ']%')->where('user_status', '!=', 4)->get();

        DB::beginTransaction();

        $user->parent_id = $parent->id;
        $user->ancestry = $parent->ancestry . "[" . $parent->id . "]";
        $user->save();
        foreach ($allsubagents as $allsubagent) {
            //$old_ancestry=$allsubagent->ancestry;
            $arr_ancestry = explode('[' . $user->id . ']', $allsubagent->ancestry);
            $new_ancestry = $user->ancestry . "[" . $user->id . "]" . $arr_ancestry[1];
            $allsubagent->ancestry = $new_ancestry;
            $allsubagent->save();
        }
        $changes = new Parent_change();
        $changes->user_id = $user->id;
        $changes->parent_id = $parent->id;
        $changes->performed_by = Auth::user()->id;
        $changes->save();
        if (!isset($changes->id)) {
            DB::rollBack();
            return back()->with('error_message', 'Error Occurred', 200);
        }

        DB::commit();
        return back()->with('success_message', 'Succesfully changed', 200);

        // dd($users);
        //  return view('admin.users.index', ['users' => $user]);
    }
    public function changePassword(Request $request)
    {
        if (Gate::denies('manage-users')) {
            //dd($user->hasRole('Agent Manager'));
            return back()->with('error_message', 'Not Authorized', 200);
        }
        $validator = Validator::make(
            $request->all(),
            [
                'user_id' => "required|numeric",
                'password' => "required",
            ]
        );
        if ($validator->fails()) {
            return back()->with('error_message', 'password is required', 200);
        }
        $user = User::where('id', $request->user_id)->first();
        if (!isset($user->id)) {
            return back()->with('error_message', 'user  does not exist', 200);
        }

        $user->password = bcrypt($request->password);
        $user->save();
        $message = new Message;
        $message->receiver = $user->phone_number;
        $message->msg = 'Password changed by  ' . Auth::user()->name . '. New password: ' . $request->password;
        $message->message_type_id = '2';

        $message->save();
        return back()->with('success_message', 'Succesfully changed', 200);

        // dd($users);
        //  return view('admin.users.index', ['users' => $user]);
    }
    public function changeMyPassword(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'password' => "required",
            ]
        );
        if ($validator->fails()) {
            return back()->with('error_message', 'password is required', 200);
        }
        $user = Auth::user();
        if (!isset($user->id)) {
            return back()->with('error_message', 'user  does not exist', 200);
        }

        $user->password = bcrypt($request->password);
        $user->save();
        return back()->with('success_message', 'Succesfully changed', 200);

        // dd($users);
        //  return view('admin.users.index', ['users' => $user]);
    }
    public function suspend(Request $request)
    {
        if (Gate::denies('manage-agents')) {
            //dd($user->hasRole('Agent Manager'));
            return back()->with('error_message', 'Not Authorized', 200);
        }
        $validator = Validator::make(
            $request->all(),
            [
                'user_id' => "required|numeric",

            ]
        );
        if ($validator->fails()) {
            return back()->with('error_message', 'User must be selected', 200);
        }

        $user = User::where('id', $request->user_id)->first();

        if (!isset($user->id)) {
            return back()->with('error_message', 'user  does not exist', 200);
        }
        //$allsubagents = User::where('ancestry', 'like', '%[' . $user->id . ']%')->where('user_status', '!=', 4)->get();
        if (Gate::denies('manage-users') && $user->parent_id != Auth::user()->id) {
            //dd($user->hasRole('Agent Manager'));
            return back()->with('error_message', 'Not Authorized', 200);
        }
        //DB::beginTransaction();
        $tokens = $user->tokens;
        //dd($tokens);
        foreach ($tokens as $token) {
            $token->delete();
        }
        $user->user_status = 1;
        $user->save();
        /*foreach($allsubagents as $allsubagent){
            //$old_ancestry=$allsubagent->ancestry;
            $allsubagent->user_status=1;
            $allsubagent->save();
        }
        */
        //DB::commit();
        return back()->with('success_message', 'User Deactivated', 200);

        // dd($users);
        //  return view('admin.users.index', ['users' => $user]);
    }
    public function delete(Request $request)
    {
        if (Gate::denies('manage-agents')) {
            //dd($user->hasRole('Agent Manager'));
            return back()->with('error_message', 'Not Authorized', 200);
        }
        $validator = Validator::make(
            $request->all(),
            [
                'user_id' => "required|numeric",

            ]
        );
        if ($validator->fails()) {
            return back()->with('error_message', 'User must be selected', 200);
        }

        $user = User::where('id', $request->user_id)->first();

        if (!isset($user->id)) {
            return back()->with('error_message', 'user  does not exist', 200);
        }
        //$allsubagents = User::where('ancestry', 'like', '%[' . $user->id . ']%')->where('user_status', '!=', 4)->get();
        if (Gate::denies('manage-users') && $user->parent_id != Auth::user()->id) {
            //dd($user->hasRole('Agent Manager'));
            return back()->with('error_message', 'Not Authorized', 200);
        }
        //DB::beginTransaction();
        $tokens = $user->tokens;
        //dd($tokens);
        foreach ($tokens as $token) {
            $token->delete();
        }
        $user->user_status = 4;
        $user->save();
        /*foreach($allsubagents as $allsubagent){
            //$old_ancestry=$allsubagent->ancestry;
            $allsubagent->user_status=1;
            $allsubagent->save();
        }
        */
        //DB::commit();
        return back()->with('success_message', 'User Deactivated', 200);

        // dd($users);
        //  return view('admin.users.index', ['users' => $user]);
    }
    public function newAgents()
    {
        if (Gate::denies('manage-users')) {
            return back()->with('error_message', 'Unauthorized', 200);
        }
        $users = User::where('parent_id', NULL)->where('user_status', '!=', '4')->get();
        //dd($users);   
        return view('admin.users.newagents', ['users' => $users]);
    }
    public function activate(Request $request)
    {
        if (Gate::denies('manage-users')) {
            //dd($user->hasRole('Agent Manager'));
            return back()->with('error_message', 'Not Authorized', 200);
        }
        $validator = Validator::make(
            $request->all(),
            [
                'user_id' => "required|numeric",

            ]
        );
        if ($validator->fails()) {
            return back()->with('error_message', 'User must be selected', 200);
        }
        $user = User::where('id', $request->user_id)->first();
        if (!isset($user->id)) {
            return back()->with('error_message', 'user  does not exist', 200);
        }
        if (Gate::denies('manage-users') && $user->parent_id != Auth::user()->id) {
            //dd($user->hasRole('Agent Manager'));
            return back()->with('error_message', 'Not Authorized', 200);
        }
        $user->user_status = 2;
        $user->save();

        return back()->with('success_message', 'User Activate', 200);

        // dd($users);
        //  return view('admin.users.index', ['users' => $user]);
    }
    public function create()
    {
        if (Gate::denies('edit-users')) {
            //dd($user->hasRole('Agent Manager'));
            return back()->with('error_message', 'Unauthorized');

            //return redirect(route('admin.users.index'));
        }
        $roles = Role::all();

        return view('admin.users.create', ['roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::denies('edit-users')) {
            //dd($user->hasRole('Agent Manager'));
            return back()->with('error_message', 'Unauthorized');

            //return redirect(route('admin.users.index'));
        }
        $validator = Validator::make(
            $request->all(),
            [
                'phone_number' => "required|unique:users",
                'password' => "required",
                'name' => "required"
            ]
        );
        if ($validator->fails()) {
            return back()->with('error_message', $validator->errors()->first(), 200);
        }
        //dd($request->roles);
        $user = new User();
        $user->phone_number = $request->phone_number;
        // $user->roles()->sync($request->roles);
        $user->name = $request->name;
        $user->password = bcrypt($request->password);
        $user->commission = $request->commission;
        $user->parent_id = 1;
        $user->user_status = 2;
        $user->save();
        if (isset($user->id)) {
            $users = User::where('parent_id', 1)->where('id', '!=', '1')->get();
            // dd($users);
            return view('admin.users.staffAgents', ['users' => $users]);
        }
        return back()->with('error_message', 'error occured', 200);
    }

    public function assignTerminal(Request $request)
    {
        if (!isset($request->terminals)) {
            return back()->with('error_message', 'Terminals were not selected');
        }
        $terminals = $request->terminals;
        //dd($terminals);
        DB::beginTransaction();
        $count = 0;
        foreach ($terminals as $terminal_id) {

            $terminal_sale = new Terminal_sale();
            $terminal_sale->user_id = $request->user_id;
            $terminal_sale->terminal_id = $terminal_id;

            $terminal_sale->performed_by = Auth::user()->id;
            $terminal_sale->save();
            $terminal = Terminal::where('id', $terminal_id)->first();
            $terminal->terminal_status = 0;
            $terminal->save();
            $count++;
        }
        DB::commit();
        return back()->with('success_message', $count . ' terminals are assigned');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        if (Gate::denies('manage-users') && $user->parent_id != Auth::user()->id) {
            return back()->with('error_message', 'Not Authorized', 200);
        }
        if ($user->id == 1) {
            return back()->with('error_message', 'Can not view system ');
        }
        $stats = StatController::GetAgentStat($user);
        
        return view('admin.users.profile', $stats);
    }
    public function logins()
    {
        $user = Auth::user();
        if (Gate::denies('manage-users') && $user->parent_id != Auth::user()->id) {
            return back()->with('error_message', 'Not Authorized', 200);
        }

        $newest_login_ids = Logins::groupBy('user_id')
            ->select(DB::raw('max(id) as id'))

            ->limit(1000)
            ->get()
            ->pluck('id');
        //dd($newest_login_ids);            
        $logins = Logins::join('users as agent', 'agent.id', '=', 'logins.user_id')
            ->join('users as parent', 'parent.id', '=', 'agent.parent_id')
            ->select(DB::raw('agent.id,agent.name, agent. phone_number,parent.name as parent_name,parent.phone_number as parent_phone,logins.app_version,logins.longitude,logins.latitude,phone_model,logins.created_at'))
            ->whereIn('logins.id', $newest_login_ids)
            ->get();

        //dd($logins);
        return view('admin.users.logins', ['users' => $logins]);
    }
    public function userLogins(User $user)
    {
        if (Gate::denies('manage-users') && $user->parent_id != Auth::user()->id) {
            return back()->with('error_message', 'Not Authorized', 200);
        }
        if ($user->id == 1) {
            return back()->with('error_message', 'Can not view system ');
        }
        $logins = Logins::join('users as agent', 'agent.id', '=', 'logins.user_id')
            ->select(DB::raw('logins.app_version,logins.longitude,logins.latitude,phone_model,logins.created_at'))
            ->where('user_id', $user->id)
            ->get();
        //dd($logins);
        return view('admin.users.userlogins', ['logins' => $logins, 'user' => $user]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //dd((Gate::denies('edit-user')));
        // dd($user->hasRole('Agent Manager'));
        if (Gate::denies('edit-users')) {
            //dd($user->hasRole('Agent Manager'));
            return redirect(route('admin.users.index'));
        }
        $roles = Role::all();

        return view('admin.users.edit', ['user' => $user, 'roles' => $roles]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
        // dd($request);
        $user->roles()->sync($request->roles);
        $user->name = $request->name;
        $user->commission = $request->commission;
        $user->save();
        // return back()->with('success_message','Successfully ');
        return redirect()->route('admin.users.index');
    }
    public function editAgent(Request $request)
    {
        //
        // dd($request);
        if (Gate::denies('manage-others')) {
            //dd($user->hasRole('Agent Manager'));
            return back()->with('error_message', 'Not Authorized', 200);
        }
        $validator = Validator::make(
            $request->all(),
            [

                'name' => "required",
                'commission' => "required|numeric|max:14|min:0",
                'agent_id' => "required|numeric",
                'multi_login' => "required"
            ]
        );
        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return back()->with('error_message', $error, 200);
        }
        $user = User::where('id', $request->agent_id)->first();
        if (isset($user->id)) {
            $user->name = $request->name;
            $user->commission = $request->commission;
            $user->multi_login = $request->multi_login;
            $user->save();
            return back()->with('success_message', 'Successfully modified');
        }
        return back()->with('error_message', 'User does not exist');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
    public function getAgentBalance($user)
    {
        $balance = Balance::where('user_id', $user)->orderBy('id', 'desc')->first();
        return isset($balance->balance) ? $balance->balance : 0;
    }
    public function getAgentDebt($user)
    {
        $debt = Debt::where('user_id', $user)->orderBy('id', 'desc')->first();
        return isset($debt->debt) ? $debt->debt : 0;
    }
}
