<?php

namespace App\Http\Controllers;

use App\Models\Project\Project;
use App\Models\Project\ProjectUpdate;
use App\Models\Account\UserDeclarationRefund;
use App\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects_count  = Project::count();
        $users_count = User::count();
        
        //обновления
        $updates = collect();
        $updates->put('all_u', ProjectUpdate::count());
        $updates->put('new_u', ProjectUpdate::pending()->count());
        
        
        $refund = collect();
        $refund->put('all_r', UserDeclarationRefund::count());
        $refund->put('new_r', UserDeclarationRefund::pending()->count());

        return view('admin.adminHome',compact('projects_count','users_count','updates','refund'));
    }
}

