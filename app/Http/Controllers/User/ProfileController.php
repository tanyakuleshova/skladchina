<?php

namespace App\Http\Controllers\User;


use App\Models\Project\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Image;
use File;

use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    
    protected $actions = ['#myabout','#mysocials','#mysecurity'];

    /**
     * ProfileController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Метод вывода профиля пользователя
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('front.user.profile.show');
    }
    
    
    /**
     * Метод обновления профиля пользователя
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        if ($request->user()->id != $id) { return back()->with('warning_message','Пользватель ?')->withInput(); }
        if (!in_array($request->input('action'), $this->actions)) { return back()->with('warning_message','Пользватель? ошибочка!')->withInput(); }
        
        switch ($request->input('action')) {
            case '#myabout':
                return $this->updateMyAbout($request);
            case '#mysocials':
                return $this->updateMySocials($request);
            case '#mysecurity':
                return $this->updateMySecurity($request);
        }
        return back()->with('warning_message','Что-то пошло не так :(')->withInput();
    }

    



    /**
     * Метод обновления информации пользователя
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function updateMyAbout(Request $request)
    {
        $request->user()->update([
            'name'          => $request->input('name'),
            'last_name'     => $request->input('last_name')]);
        
        $avatar = $request->user()->account->avatar_link;
        if ($request->hasFile('avatar')) {
            Storage::disk('public')->delete($avatar);
            $avatar = $request->file('avatar')->storePublicly('users/'.$request->user()->id,'public');
        }

        $request->user()->account()->update([
            'avatar_link'       => $avatar,
            'city_birth'        => $request->input('city'),
            'contact_phone'     => $request->input('contact_phone'),
            'about_self'        => $request->input('about_self')
            
        ]);
        
        return back()->with('success_message','Информация успешно обновлена.')->withInput();
    }

    /**
     * Метод изменения социальных сетей пользователя
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function updateMySocials(Request $request)
    {
        $request->user()->account()->update([
            'user_site'             =>$request->input('site'),
            'social_href_facebook'  =>$request->input('sc_facebook'),
            'social_href_google'    =>$request->input('sc_google'),
            'social_href_twitter'   =>$request->input('sc_twitter'),
            'social_href_youtube'   =>$request->input('sc_youtube'),
            'social_href_instagram' =>$request->input('sc_instagram'),
        ]);
        return back()->with('success_message','Информация успешно обновлена.')->withInput();
    }

    /**
     * Метод изменения социальных сетей пользователя
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function updateMySecurity(Request $request)
    {
        switch ($request->input('subaction')) {
            case 'password':
                return $this->changePassword($request);
            case 'email':
                return $this->changeEmail($request);
        }
        return back()->with('warning_message','Не безопасное действие :(')->withInput();
    }

    /**
     * Метод изменения пароля пользователя
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function changePassword(Request $request)
    {
        $this->validate($request,[
                'old_password'=>'required',
                'new_password'=>'required|min:6',
                'password_confirm'=>'required|min:6'
        ],[
            'old_password.required'=>'Данное поле обязательные к заполнению.',
            'new_password.required'=>'Данное поле обязательные к заполнению.',
            'password_confirm.required'=>'Данное поле обязательные к заполнению.',
            'new_password.min'=>'Минимальное кол-во символов 6.',
            'password_confirm.min'=>'Минимальное кол-во символов 6.'
        ]);
        
        if(Hash::check($request->old_password,$request->user()->password)){
            if($request->new_password === $request->password_confirm){
                $request->user()->update([ 'password'=>Hash::make($request->new_password) ]);
                return back()->with('success_message','Пароль успешно изменен')->withInput();
            }
            return back()->with('warning_message','Пароли не совпадают!')->withInput();
        }
        return back()->with('warning_message','Старый пароль введен не верный.')->withInput();
    }


    protected function changeEmail(Request $request)
    {
        $this->validate($request,[
            'password'=>'required',
            'old_email'=>'required|email',
            'new_email'=>'required|email|max:255|unique:users,email',
        ],[
            'password.required'=>'Данное поле обязательно к заполнению.',
            'old_email.required'=>'Данное поле обязательно к заполнению.',
            'new_email.required'=>'Данное поле обязательно к заполнению.',
            'new_email.unique'=>'Данный email уже существует.'
        ]);
        
        if(Hash::check($request->password,$request->user()->password)){
            if($request->user()->email === $request->old_email){
                $data['name']= $request->user()->name;
                $data['email'] = $request->new_email;
                $data['email_token']=str_random(25);
                $request->user()->update([
                    'email'=>$data['email'],
                    'email_token'=>$data['email_token'],
                    'confirm_email_status'=>0,
                ]);
                Mail::send('auth.register_mail.change_email',$data,function ($message) use ($data){
                    $message->to($data['email']);
                    $message->subject('Изменения почты на Dreamstarter');
                });
                Auth::logout();
                return back()->with('success_message','Вы изменили почту.Ссылка с подверждение отправлена Вам на новую почту.')->withInput();
            }
            return back()->with('warning_message','Старая почта не совпадает с текущей почтой. ')->withInput();
        }
        return back()->with('warning_message','Пароль не верный')->withInput();
    }

}
