<?php

namespace App\Http\Controllers\Admin\Users;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
class usersController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::get();
        return view('admin.users.users_list',compact('users'));
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
     * ЭТО ФИКЦИЯ
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::find($request->id);
        if(!$user){ return back()->with('info','Пользователь не найден'); }

        Auth::guard('web')->login($user);
        
        return redirect()->route('myprofile.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('admin.users.user_details',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.users.user_edit',compact('user'));
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
        $user = User::find($id);
        if(!$user){
            return back()->with('info','Пользователь не найден!');
        }
        $this->validate($request,[
            'name_user'=>'required|min:3',
        ]);
        $user->update([
            'name'=>$request->name_user,
            'last_name'=>$request->last_name_user,
        ]);
        $user->account()->update([
            'city_birth'=>$request->city,
            'contact_phone'=>$request->phone,
            'about_self'=>$request->about_user,
            //'balance'=>$request->balance,
            'day_birth'=>$request->day_birth,
            'user_site'=>$request->user_site,
            'social_href_facebook'=>$request->social_href_facebook,
            'social_href_google'=>$request->social_href_google,
            'social_href_twitter'=>$request->social_href_twitter,
            'social_href_youtube'=>$request->social_href_youtube,
            'social_href_instagram'=>$request->social_href_instagram,
        ]);
       return redirect(route('users.index'))->with('success','Провиль пользователя '.$user->name);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if(!$user){
            return back()->with('info','Пользователь не найден!');
        }
        $user->delete();
        return back()->with('success','Пользователь успешно удален.');
    }
    
    /**
     * Метод авторизации под юзером и переходом на проект который нужно модерировать
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function inUserProject(Request $request, $id) {
        $project = Project::moderation()->find($id);
        if(!$project){ return back()->with('info','Проект не найден'); }
        $user = $project->author;
        
        //Auth::guard('web')->logout();
        Auth::guard('web')->login($user);
        
        return redirect()->route('edit_project',$project->id);
        
    }
    
    
}
