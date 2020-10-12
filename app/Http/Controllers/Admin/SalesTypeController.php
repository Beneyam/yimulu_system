<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Sales_type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SalesTypeController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        
        $salestypes=Sales_type::all();
       //dd($salestypes);
        return view('admin.salestypes.index',['salestypes'=>$salestypes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.salestypes.create');
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
        $salestype = new Sales_type();
        $this->validateInput($request);
        $salestype->type = $request['type'];
        $salestype->save(); 
        return redirect()->route('admin.salestypes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sales_type  $salestype
     * @return \Illuminate\Http\Response
     */
    public function show(Sales_type $salestype)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sales_type  $salestype
     * @return \Illuminate\Http\Response
     */
    public function edit(Sales_type $salestype)
    {
       
        if(Gate::denies('manage-system')){
            //dd($salestype->hasRole('Agent Manager'));
            return redirect(route('admin.salestypes.index'));
        }
       /* $salestype = Sales_type::find($id);
        //dd($salestype);
        // Redirect to product list if updating product wasn't existed
        if ($salestype == null || count($salestype->all()) == 0) {
            return redirect()->intended('/admin/salestypes/index');
        }*/
        return view('admin.salestypes.edit',['salestype'=>$salestype]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sales_type  $salestype
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sales_type $salestype)
    {
       
        $this->validateInput($request);
        $salestype->type = $request['type'];
       
        $salestype->save(); 
        return redirect()->route('admin.salestypes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sales_type  $salestype
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sales_type $salestype)
    {
        //
    }
    private function validateInput($request)
    {
        $this->validate($request, [
            'type' => 'required|max:20|',        
        ]);
    }
}
