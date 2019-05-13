<?php

namespace App\Http\Controllers\User;

use App\Models\Application\ApplicationGetMoney;
use App\Models\Project\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Image;
use File;

use Illuminate\Support\Facades\Storage;

class personalAreaController extends Controller
{

    /**
     * personalAreaController constructor.
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
        return view('front.user.personal_area');
    }

    /**
     * Метод вывода проектов пользователя
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showMyProjects()
    {
        $projects = Project::where('user_id',Auth::id())->active()->get();
        return view('front.user.user_projects',compact('projects'));
    }

    /**
     * Метод вывод проспонсированых проектов
     */
    public function showSponsored()
    {
        return view('front.user.sponsored');
    }

//    public function withdrawMoneyApplication()
//    {
//        return view('front.user.withdraw_money_form');
//    }

    /**
     * Метод обновления информации пользователя
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSettingProfile(Request $request)
    {
        $user = Auth::user();
        if ($request->name) {
            $this->validate($request,[
                'name'=>'min:3|max:15'
            ],[
                'name.min'=>'Допустимо минимум 3 символа в имени.',
            ]);
            $user->name = strip_tags($request->name);
        }
        if ($request->last_name) {
            $this->validate($request,[
                'last_name'=>'min:3|max:50'
            ],[
                'last_name.min'=>'Допустимо минимум 3 символа в фамилии.'
            ]);
            $user->update([
                'last_name' => strip_tags($request->last_name),
            ]);
        }
        if ($request->hasFile('avatar')) {

            Storage::disk('public')->delete($user->account->avatar_link);
//            $avatar = $request->file('avatar');
//            $filename = 'avatar_'.$user->name.'.'. $avatar->getClientOriginalExtension();
//            Image::make($avatar)->resize(300, 300)->save(public_path('images/avatar/' . $filename));
            $user->account()->update([
                'avatar_link' => $request->file('avatar')->storePublicly('users/'.$user->id,'public')
            ]);
        }
        
        if($request->city){
            $this->validate($request,[
                'city'=>'min:4|max:50'
            ],[
                'city.min'=>'Допустимо минимум 4 символа в названии города.',
            ]);
            $user->account()->update([
                'city_birth'=>strip_tags($request->city)
            ]);
        }
        if($request->contact_phone){
            $user->account()->update([
                'contact_phone'=>$request->contact_phone,
            ]);
        }
        if($request->about_self){
            $this->validate($request,[
                'about_self'=>'min:100'
            ],[
                'about_self.min'=>'Информация о себе должна быть не меньше 100 символов'
            ]);
            $user->account()->update([
                'about_self'=>$request->about_self,
            ]);
        }
        return back()->with('success_message','Информация успешно обновлена.');
    }

    /**
     * Метод изменения социальных сетей пользователя
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addSocialInfo(Request $request)
    {
        $user = Auth::user();
        if($request->site){
            $user->account()->update([
                'user_site'=>$request->site,
            ]);
        }
        if($request->sc_facebook){
            $user->account()->update([
                'social_href_facebook'=>$request->sc_facebook,
            ]);
        }
        if($request->sc_google){
            $user->account()->update([
                'social_href_google'=>$request->sc_google,
            ]);
        }
        if($request->sc_twitter){
            $user->account()->update([
                'social_href_twitter'=>$request->sc_twitter,
            ]);
        }
        if($request->sc_youtube){
            $user->account()->update([
                'social_href_youtube'=>$request->sc_youtube,
            ]);
        }
        if($request->sc_instagram){
            $user->account()->update([
                'social_href_instagram'=>$request->sc_instagram,
            ]);
        }
        return back()->with('success_message','Информация успешно обновлена.');
    }

    public function showAdditionForm(){
        if(Auth::check()){
            return view('front.user.addition');
        }
        return redirect('/login');
    }

    /**
     * Метод вывода представления настройки информации пользователя
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit()
    {
        return view('front.user.settings_profile');
    }

    /**
     * Метод изменения пароля пользователя
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changePassword(Request $request)
    {
        $user = Auth::user();
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
        if(Hash::check($request->old_password,$user->password)){
            if($request->new_password === $request->password_confirm){
                $user->update([
                    'password'=>Hash::make($request->new_password)
                ]);
                return back()->with('success_message','Пароль успешно изменен');
            }
            return back()->with('warning_message','Пароли не совпадают!');
        }
        return back()->with('warning_message','Старый пароль введен не верный.');
    }


    public function changeEmail(Request $request)
    {
        $user = Auth::user();
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
        if(Hash::check($request->password,$user->password)){
            if($user->email === $request->old_email){
                $data['name']= $user->name;
                $data['email'] = $request->new_email;
                $data['email_token']=str_random(25);
                $user->update([
                    'email'=>$data['email'],
                    'email_token'=>$data['email_token'],
                    'confirm_email_status'=>0,
                ]);
                Mail::send('auth.register_mail.change_email',$data,function ($message) use ($data){
                    $message->to($data['email']);
                    $message->subject('Изменения почты на Dreamstarter');
                });
                Auth::logout();
                return back()
                    ->with('success_message','Вы изменили почту.Ссылка с подверждение отправлена Вам на новую почту.');
            }
            return back()->with('warning_message','Старая почта не совпадает с текущей почтой. ');
        }
        return back()->with('warning_message','Пароль не верный');
    }

//    public function applicationGetMoney(Request $request){
//        $user = Auth::user();
//        $this->validate($request,[
//            'application_image'=>'required',
//            'money_sum'=>'required|min:2',
//            'type_cart'=>'required',
//            'number'=>'required',
//        ],[
//            'required'=>'Данні поля обов\'язкові',
//            'money_sum.min'=>'Сумма надто мала.'
//        ]);
//        $application = $request->file('application_image');
//        $hash_str= str_random(5);
//        $filename = 'bid'.$hash_str.'.'. $application->getClientOriginalExtension();
//        Image::make($application)->save(public_path('images/proposal/'.$filename));
//        $new_application = new ApplicationGetMoney();
//        $new_application->user_id = $user->id;
//        $new_application->application_image = 'images/proposal/'.$filename;
//        $new_application->money_sum = $request->money_sum;
//        $new_application->type_cart = $request->type_cart;
//        $new_application->number_score= $request->number;
//        $new_application->status = 0;
//        $new_application->save();
//        return back()->with('success_message','Ваша заявка отправлена на расмотрение. Ожидайте на почте письмо.');
//    }
}
