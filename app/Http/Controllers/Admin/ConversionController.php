<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gate;
use App\Conversion;
use Illuminate\Support\Facades\DB;

class ConversionController extends Controller
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

        $conversions = Conversion::all();
        // dd($conversions);
        return view('admin.conversions.index', ['conversions' => $conversions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.conversions.create');
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
        $conversion = new Conversion();
        $this->validateInput($request);
        $conversion->dollar = $request['dollar'];
        $conversion->birr = $request['birr'];
        $conversion->commission=$request['commission'];
        $conversion->save();
        return redirect()->route('admin.conversions.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Conversion  $conversion
     * @return \Illuminate\Http\Response
     */
    public function show(Conversion $conversion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Conversion  $conversion
     * @return \Illuminate\Http\Response
     */
    public function edit(Conversion $conversion)
    {
        //

        //dd((Gate::denies('edit-conversion')));
        // dd($conversion->hasRole('Agent Manager'));
        if (Gate::denies('manage-system')) {
            //dd($conversion->hasRole('Agent Manager'));
            return redirect(route('admin.conversion.index'));
        }
        // $conversion = Conversion::find($id);
        //dd($conversion);
        // Redirect to product list if updating product wasn't existed
        if ($conversion == null || count($conversion->all()) == 0) {
            return redirect()->intended('/admin/conversions/index');
        }
        return view('admin.conversions.edit', ['conversion' => $conversion]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Conversion  $conversion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Conversion $conversion)
    {

        $this->validateInput($request);
        $conversion->dollar = $request['dollar'];
        $conversion->birr = $request['birr'];
        $conversion->commission=$request['commission'];
        $conversion->save();
        return redirect()->route('admin.conversions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Conversion  $conversion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Conversion $conversion)
    {
        //
    }
    private function validateInput($request)
    {
        $this->validate($request, [

            'dollar' => 'required|numeric',
            'birr' => 'required|numeric',
            'commission' => 'required|numeric'
        ]);
    }
}
