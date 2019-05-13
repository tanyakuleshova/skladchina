<?php

namespace App\Http\Controllers\Admin\Project;


use App\Models\Project\ProjectUpdate;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class updatesProjectController extends Controller
{
    /**
     * Покажем все обновления что были, пусть фронт сам разбирается
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::guard('admin')->user()->isAdmin) {
            $updates = ProjectUpdate::orderBy('created_at','DESC')->get();
        } else {
            $updates = ProjectUpdate::where('admin_id',Auth::guard('admin')->id())->orderBy('created_at','DESC')->get();
        }
        
        return view('admin.project.updates.list',compact('updates'));
    }


    /**
     * Показать обновление для проекта детально.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Auth::guard('admin')->user()->isAdmin) {
            $update = ProjectUpdate::find($id);
        } else {
            $update = ProjectUpdate::where('admin_id',Auth::guard('admin')->id())->find($id);
        }
        if(!$update){ return back()->with('info','Обновление не найден'); }

        return view('admin.project.updates.show',compact('update'));
    }
    
    /**
     * Display the specified resource.
     * @param Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        if(Auth::guard('admin')->user()->isAdmin) {
            $update = ProjectUpdate::pending()->find($id);
        } else {
            $update = ProjectUpdate::pending()->where('admin_id',Auth::guard('admin')->id())->find($id);
        }
        
        if(!$update){ return back()->with('info','Обновление не найдено'); }
        
        $action         = trim($request->input('action'));
        $admin_text     = trim($request->input('admin_text'))?:null;
        
        switch ($action){
            case 'approved':
                $update->update(['admin_id'=> Auth::guard('admin')->id(), 'status_id'=>3, 'admin_text'=>$admin_text]);
                return redirect()->route('a_updates.index')->with('success','Обновление '.$update->shotDesc.' доступно в проекте');
            case 'rejected':
                $update->update(['admin_id'=> Auth::guard('admin')->id(), 'status_id'=>2, 'admin_text'=>$admin_text]);
                return redirect()->route('a_updates.index')->with('success','Обновление '.$update->shotDesc.' заблокировано');
        }
        return back()->with('error','Неизвестная комманда, сообщите администратору')->withInput();
    }
}
