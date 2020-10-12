<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\yimulu_sales_status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class yimulu_salesStatusController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        
        $yimulu_salesstatuses=yimulu_sales_status::all();
       //dd($yimulu_salesstatuses);
        return view('admin.yimulu_salesstatuses.index',['yimulu_salesstatuses'=>$yimulu_salesstatuses]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.yimulu_salesstatuses.create');
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
        $yimulu_salesstatus = new yimulu_sales_status();
        $this->validateInput($request);
        $yimulu_salesstatus->status_name = $request['status_name'];
        $yimulu_salesstatus->save(); 
        return redirect()->route('admin.yimulu_salesstatuses.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\yimulu_sales_status  $yimulu_salesstatus
     * @return \Illuminate\Http\Response
     */
    public function show(yimulu_sales_status $yimulu_salesstatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\yimulu_sales_status  $yimulu_salesstatus
     * @return \Illuminate\Http\Response
     */
    public function edit(yimulu_sales_status $yimulu_salesstatus)
    {
       
        if(Gate::denies('manage-system')){
            //dd($yimulu_salesstatus->hasRole('Agent Manager'));
            return redirect(route('admin.yimulu_salesstatuses.index'));
        }
       /* $yimulu_salesstatus = yimulu_sales_status::find($id);
        //dd($yimulu_salesstatus);
        // Redirect to product list if updating product wasn't existed
        if ($yimulu_salesstatus == null || count($yimulu_salesstatus->all()) == 0) {
            return redirect()->intended('/admin/yimulu_salesstatuses/index');
        }*/
        return view('admin.yimulu_salesstatuses.edit',['yimulu_salesstatus'=>$yimulu_salesstatus]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\yimulu_sales_status  $yimulu_salesstatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, yimulu_sales_status $yimulu_salesstatus)
    {
       
        $this->validateInput($request);
        $yimulu_salesstatus->status_name = $request['status_name'];
       
        $yimulu_salesstatus->save(); 
        return redirect()->route('admin.yimulu_salesstatuses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\yimulu_sales_status  $yimulu_salesstatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(yimulu_sales_status $yimulu_salesstatus)
    {
        //
    }
    private function validateInput($request)
    {
        $this->validate($request, [
            'status_name' => 'required|max:20|',        
        ]);
    }
}

