<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\yimulu_sales_type;
class yimulu_salesTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        
        $yimulu_salestypes=yimulu_sales_type::all();
       //dd($yimulu_salestypes);
        return view('admin.yimulu_salestypes.index',['yimulu_salestypes'=>$yimulu_salestypes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.yimulu_salestypes.create');
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
        $yimulu_salestype = new yimulu_sales_type();
        $this->validateInput($request);
        $yimulu_salestype->yimulu_sales_name = $request['yimulu_sales_name'];
        $yimulu_salestype->face_value = $request['face_value'];
       
        $yimulu_salestype->save(); 
        return redirect()->route('admin.yimulu_salestypes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\yimulu_sales_type  $yimulu_salestype
     * @return \Illuminate\Http\Response
     */
    public function show(yimulu_sales_type $yimulu_salestype)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\yimulu_sales_type  $yimulu_salestype
     * @return \Illuminate\Http\Response
     */
    public function edit(yimulu_sales_type $yimulu_salestype)
    {
        //

        //dd((Gate::denies('edit-yimulu_salestype')));
       // dd($yimulu_salestype->hasRole('Agent Manager'));
        if(Gate::denies('manage-system')){
            //dd($yimulu_salestype->hasRole('Agent Manager'));
            return redirect(route('admin.yimulu_salestypes.index'));
        }
       // $yimulu_salestype = yimulu_sales_type::find($id);
        //dd($yimulu_salestype);
        // Redirect to product list if updating product wasn't existed
        if ($yimulu_salestype == null || count($yimulu_salestype->all()) == 0) {
            return redirect()->intended('/admin/yimulu_salestypes/index');
        }
        return view('admin.yimulu_salestypes.edit',['yimulu_salestype'=>$yimulu_salestype]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\yimulu_sales_type  $yimulu_salestype
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, yimulu_sales_type $yimulu_salestype)
    {
       
        $this->validateInput($request);
        $yimulu_salestype->yimulu_sales_name = $request['yimulu_sales_name'];
        $yimulu_salestype->face_value = $request['face_value'];
         $yimulu_salestype->save(); 
        return redirect()->route('admin.yimulu_salestypes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\yimulu_sales_type  $yimulu_salestype
     * @return \Illuminate\Http\Response
     */
    public function destroy(yimulu_sales_type $yimulu_salestype)
    {
        //
    }
    private function validateInput($request)
    {
        $this->validate($request, [
            'yimulu_sales_name' => 'required|max:25|',
            
            'face_value' => 'required|numeric',
           
            
        ]);
    }

}
