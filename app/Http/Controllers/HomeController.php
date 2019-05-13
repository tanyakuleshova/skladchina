<?php

namespace App\Http\Controllers;

use App\Models\Project\Project;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\App;

//use GuzzleHttp\Client;
//use Illuminate\Support\Facades\Storage;
//use File;

class HomeController extends Controller
{

    /**
     * Отображает главную страницу.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //----------------------Выбор редакции--------------------------------------------------------------------------
        //$main_project = Project::active()->orderBy('need_sum', 'DESC')->first();
        
        //проект набравший самое большое количество подтверждённых заказов пользователей, если кол-во совпадет то где больше сумма
        $main_project = Project::active()->where('level_project',1)->first();
        if (!$main_project) {
            $main_project = Project::active()->withCount(['orders'=> function ($query) {return $query->approved();}])
                ->orderBy('orders_count','desc')
                ->orderBy('current_sum','desc')
                ->first();
        }

        //-----------------Все проекты---------------------------------------------------------------------
        //
        $all_home_projects = Project::AllClosed()->take(3)->get();
        
        //---------------------------------------------------------------------------------------------
        //---------------------Популярные проекты-----------------------------------------------------------------------
        $popular_projects = Project::active()
            ->orderBy('current_sum', 'DESC')
            ->take(3)
            ->get();
        $popular_projects = collect();
        //--------------------------------------------------------------------------------------------------------------
        //---------------------Новые проекты----------------------------------------------------------------------------
        $new_projects = Project::active()
            ->orderBy('date_start', 'DESC')
            ->take(3)
            ->get();
        //$new_projects = collect();
        //--------------------------------------------------------------------------------------------------------------
        return view('home', compact('new_projects', 'main_project','popular_projects', 'all_home_projects'));
    }
    
    /**
     * Отпарвка сообщений со страницы контакты
     * @param Request $request
     * @return redirect
     */
    public function contactssend(Request $request){
        $this->validate($request,[
                'name'=>'required',
                'email'=>'required|email',
                'smessage'=>'required|min:6'
        ],[
            'name.required'     =>'Данное поле обязательное к заполнению.',
            'email.required'    =>'Данное поле обязательное к заполнению.',
            'email.email'       =>'Не верный E-mail адрес',
            'smessage.required' =>'Данное поле обязательное к заполнению.',
            'smessage.min'      =>'Минимальное кол-во символов 6.'
        ]);
        
        $data['name']       = $request->name;
        $data['email']      = $request->email;
        $data['smessage']    = $request->smessage;
        
        Mail::send('emails.email_from_contact',$data, function ($message) use ($data){
            $message->to('support@dreamstarter.com.ua');
            $message->subject('Сообщение из КОНТАКТЫ, от '.$data['name']);
        });
        return back()->with('success_message', 'Ваше сообщение успешно отправлено !')->withInput();
    }

    public function faq(){
        $local = App::getLocale();
        
        if (view()->exists('front.faq_'.$local)) { 
            return view('front.faq_'.$local); 
        }
        
        return view('front.faq');
    }

    public function rulesCreateProject(){
        $local = App::getLocale();
        
        if (view()->exists('front.rules_service_'.$local)) { 
            return view('front.rules_service_'.$local); 
        }

        return view('front.rules_service');
    }
    
    public function agreement(){
        $local = App::getLocale();
        
        if (view()->exists('front.agreement_'.$local)) { 
            return view('front.agreement_'.$local); 
        }
        
        return view('front.agreement');
    }
    
    public function contacts(){
        $local = App::getLocale();
        
        if (view()->exists('front.contacts_'.$local)) { 
            return view('front.contacts_'.$local); 
        }
        
        return view('front.contacts');
    }
        
    public function curators(){
        $local = App::getLocale();
        
        if (view()->exists('front.curators_'.$local)) { 
            return view('front.curators_'.$local); 
        }
        
        return view('front.curators');
    }
    
    public function manual(){
        $local = App::getLocale();
        
        if (view()->exists('front.manual_'.$local)) { 
            return view('front.manual_'.$local); 
        }
        
        return view('front.manual');
    }
    
    public function returnmoney(){
        $local = App::getLocale();
        
        if (view()->exists('front.returnmoney_'.$local)) { 
            return view('front.returnmoney_'.$local); 
        }
        
        return view('front.returnmoney');
    }
    
    public function about(){
        $local = App::getLocale();
        
        if (view()->exists('front.about_'.$local)) { 
            return view('front.about_'.$local); 
        }
        
        return view('front.about');
    }
}
