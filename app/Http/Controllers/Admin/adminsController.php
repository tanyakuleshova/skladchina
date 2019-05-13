<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class adminsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = Admin::get();
        return view('admin.admins.list',compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.admins.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|min:6|confirmed',
        ]);
        
        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        
        if ($request->hasFile('image_avatar')) {
            Storage::disk('public')->delete($admin->account->avatar_link);
            $img_link = $request->file('image_avatar')->storePublicly('admin/'.$admin->id,'public');
            $admin->account()->update(['avatar_link'=>$img_link]);
        } 

        return redirect(route('admins.index'))->with('success','Успешно создан администратор '.$admin->fullName);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->edit($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $admin = Admin::find($id);
        
        if ($admin->id == 1 && Auth::guard('admin')->user()->id != 1) {
            return back()->with('success','Недостаточно прав для редактирования.');
        }
        
        return view('admin.admins.edit',compact('admin'));
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
        $admin = Admin::findOrFail($id);
        
        $this->validate($request,[
            'name_user'=>'required|min:3',
            'password' => 'nullable|string|min:6|confirmed',
        ]);
        
        if($request->password) {
            if ($admin->id != Auth::guard('admin')->user()->id  && Auth::guard('admin')->user()->id != 1) {
                return back()->with('success','Недостаточно прав для редактирования.');
            }
            
            $admin->update(['password' => bcrypt($request->password)]);

        }
        
        $admin->update(['name'=>$request->name_user]);
        
        
        if ($request->hasFile('image_avatar')) {
            Storage::disk('public')->delete($admin->account->avatar_link);
            $img_link = $request->file('image_avatar')->storePublicly('admin/'.$admin->id,'public');
            $admin->account()->update(['avatar_link'=>$img_link]);
        } 
        
        
        if($admin->id == 1 ) {
            $status = 1;
            $sa = 0;
        } else {
            $status = $request->input('status')?1:0;
            $sa = $request->input('manager')?1:0;
        }
        
        
        $admin->account()->update([
            'status_id'             => $status,
            'last_name'             => $request->input('last_name_user'),
            'city_birth'            => $request->input('city'),
            'contact_phone'         => $request->input('phone'),
            'about_self'            => $request->input('about_user'),
            'day_birth'             => $request->input('day_birth'),
            'social_href_facebook'  => $request->input('social_href_facebook'),
            'social_href_google'    => $request->input('social_href_google'),
            'social_href_twitter'   => $request->input('social_href_twitter'),
            'social_href_youtube'   => $request->input('social_href_youtube'),
            'social_href_instagram' => $request->input('social_href_instagram'),
            'manager'               => $sa
        ]);
        
        
       return redirect(route('admins.index'))->with('success','Профиль администратора '.$admin->fullName);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);
        if ($admin->id != 1) {
            $admin->account()->update(['status_id'=>0]);
            return back()->with('success','Админа нельзя удалить, только выключить.');
        }
        return back()->with('success','Админа нельзя удалить, только выключить.');
    }
}
