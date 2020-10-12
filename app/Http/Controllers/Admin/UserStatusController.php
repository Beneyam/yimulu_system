<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User_status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserStatusController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        
        $userstatuses=User_status::all();
       //dd($userstatuses);
        return view('admin.userstatuses.index',['userstatuses'=>$userstatuses]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.userstatuses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $userstatus = new User_status();
        $this->validateInput($request);
        $userstatus->status = $request['status'];
        $userstatus->save(); 
        return redirect()->route('admin.userstatuses.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User_status  $userstatus
     * @return \Illuminate\Http\Response
     */
    public function show(User_status $userstatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User_status  $userstatus
     * @return \Illuminate\Http\Response
     */
    public function edit(User_status $userstatus)
    {
       
        if(Gate::denies('manage-system')){
            //dd($userstatus->hasRole('Agent Manager'));
            return redirect(route('admin.userstatuses.index'));
        }
       /* $userstatus = User_status::find($id);
        //dd($userstatus);
        // Redirect to product list if updating product wasn't existed
        if ($userstatus == null || count($userstatus->all()) == 0) {
            return redirect()->intended('/admin/userstatuses/index');
        }*/
        return view('admin.userstatuses.edit',['userstatus'=>$userstatus]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User_status  $userstatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User_status $userstatus)
    {
       
        $this->validateInput($request);
        $userstatus->status = $request['status'];
       
        $userstatus->save(); 
        return redirect()->route('admin.userstatuses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User_status  $userstatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(User_status $userstatus)
    {
        //
    }
    private function validateInput($request)
    {
        $this->validate($request, [
            'status' => 'required|max:20|',        
        ]);
    }
}

