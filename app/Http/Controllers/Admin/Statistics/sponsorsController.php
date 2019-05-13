<?php

namespace App\Http\Controllers\Admin\Statistics;

use App\Models\Sponsored\Sponsors;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Billing\Balance;
use App\Models\Billing\BalanceProjects;
use App\Models\Billing\Order;

class sponsorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $sponsors = Sponsors::orderBy('created_at','DESC')->get();
        $orders = Order::approved()
                ->orderBy('user_id')
                ->orderBy('project_id')
                ->with(['user','project','gift'])
                ->get();
//        $orders = Order::latest()
//                            ->where('status_id', 3)
//                            ->get();
        
        return view('admin.sponsors.sponsors_list',compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
