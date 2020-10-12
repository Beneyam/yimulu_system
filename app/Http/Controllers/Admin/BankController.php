<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Bank;
use Illuminate\Http\Request;
use Gate;

class BankController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        
        $banks=Bank::all();
       // dd($banks);
        return view('admin.banks.index',['banks'=>$banks]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.banks.create');
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
        $bank = new Bank();
        $this->validateInput($request);
        $bank->name = $request['name'];
        $bank->branch = $request['branch'];
        $bank->address = $request['address'];
        $bank->account_number = $request['account_number'];
       
        $bank->save(); 
        return redirect()->route('admin.banks.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function show(Bank $bank)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function edit(Bank $bank)
    {
        //

        //dd((Gate::denies('edit-bank')));
       // dd($bank->hasRole('Agent Manager'));
        if(Gate::denies('manage-system')){
            //dd($bank->hasRole('Agent Manager'));
            return redirect(route('admin.banks.index'));
        }
       // $bank = Bank::find($id);
        //dd($bank);
        // Redirect to product list if updating product wasn't existed
        if ($bank == null || count($bank->all()) == 0) {
            return redirect()->intended('/admin/banks/index');
        }
        return view('admin.banks.edit',['bank'=>$bank]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bank $bank)
    {
       
        $this->validateInput($request);
        $bank->name = $request['name'];
        $bank->branch = $request['branch'];
        $bank->address = $request['address'];
        $bank->account_number = $request['account_number'];
       
        $bank->save(); 
        return redirect()->route('admin.banks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bank $bank)
    {
        //
    }
    private function validateInput($request)
    {
        $this->validate($request, [
            'name' => 'required|max:150|',
            
            'branch' => 'required|max:150',
            'account_number' =>'required|max:15',
            'address' =>'required|max:150',
            
        ]);
    }
}
