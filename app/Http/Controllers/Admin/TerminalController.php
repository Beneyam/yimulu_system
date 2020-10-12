<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Terminal;

class TerminalController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        
        $terminals=Terminal::all();
       // dd($terminals);
        return view('admin.terminals.index',['terminals'=>$terminals]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.terminals.create');
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
        $terminal = new Terminal();
        $this->validateInput($request);
        $terminal->brand = $request['brand'];

        $terminal->serial_number = $request['serial_number'];
        $terminal->save(); 
         if(!isset($request['serial_number'])|| $request['serial_number']==""){

             $terminal->serial_number=str_pad($terminal->id, 5, '0', STR_PAD_LEFT);
             $terminal->save();
         }
        return redirect()->route('admin.terminals.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Terminal  $terminal
     * @return \Illuminate\Http\Response
     */
    public function show(Terminal $terminal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Terminal  $terminal
     * @return \Illuminate\Http\Response
     */
    public function edit(Terminal $terminal)
    {
        //

        //dd((Gate::denies('edit-terminal')));
       // dd($terminal->hasRole('Agent Manager'));
        if(Gate::denies('manage-system')){
            //dd($terminal->hasRole('Agent Manager'));
            return redirect(route('admin.terminal.index'));
        }
       // $terminal = Terminal::find($id);
        //dd($terminal);
        // Redirect to product list if updating product wasn't existed
        if ($terminal == null || count($terminal->all()) == 0) {
            return redirect()->intended('/admin/terminals/index');
        }
        return view('admin.terminals.edit',['terminal'=>$terminal]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Terminal  $terminal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Terminal $terminal)
    {
       
        $this->validateInput($request);
        $terminal->brand = $request['brand'];
        $terminal->serial_number = $request['serial_number'];
        
        $terminal->save(); 
        return redirect()->route('admin.terminals.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Terminal  $terminal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Terminal $terminal)
    {
        //
    }
    private function validateInput($request)
    {
        $this->validate($request, [
            
            'brand' => 'required|max:50',
            'serial_number' =>'max:15',
            
        ]);
    }
}
