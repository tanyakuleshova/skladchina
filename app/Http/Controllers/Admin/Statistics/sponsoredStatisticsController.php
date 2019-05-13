<?php

namespace App\Http\Controllers\Admin\Statistics;

use App\Models\Sponsored\SponsoredStatistic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Project\Project;

class sponsoredStatisticsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::with(['orders'=>function($query) {
            $query->approved();
        }])->whereHas('orders',function($query) {
            $query->approved();
        })->orderBy('created_at','DESC')->get();
//        $projects = Project::latest()
////            ->where('status_id', 1)
//            ->get();
        //dd($projects);
        return view('admin.sponsors.sponsored_project_list',compact('projects'));
    }


    /**
     * Нестандарт. 
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
        $project = Project::with(['orders'=>function($query) {
            $query->approved();
        }])->whereHas('orders',function($query) {
            $query->approved();
        })->find($id);
        
        if(!$project) { return back()->with('info','Хм, проект не найден или в нём нет ордеров.'); }
        
        return view('admin.sponsors.sponsored_project_show',compact('project'));
    }

    /**
     * Не стандарт.
     * Получить список в виде json
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::with(['orders'=>function($query) {
            $query->approved();
        }])->whereHas('orders',function($query) {
            $query->approved();
        })->findOrFail($id);
        
        $res = [];
        foreach ($project->orders as $order) {
            if (!$order->usergifts) { 
                $status = '';
            }elseif($order->history && isset($order->history['send'])) {
                $status = $order->history['send'];
            }else {
                $status = $order->gift->deliveryMethod;
            }
            
            $child = view('admin.sponsors.part_one_order',  compact('order'))->render();
            
            $res['data'][] = [
                'name'      => $order->user->fullName,
                'email'     => $order->user->email,
                'summa'     => $order->summa,
                'gift'      => $status,
                'created'   => $order->created_at->toDateTimeString(),
                'updated'   => $order->updated_at->toDateTimeString(),   
                'child'     => $child
            ];
        }

        return response()->json($res);
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

        return back()->with('success','Запись успешно удалена!');
    }
}
