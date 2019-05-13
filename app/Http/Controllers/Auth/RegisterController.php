<?php

namespace App\Http\Controllers\Auth;


use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\UrlGenerator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    public function getRedirectUrl() {
        
        $previous = request()->session()->pull('redirect_router_project');
        if(!$previous) {
            $previous = app(UrlGenerator::class)->previous();
        }
        
        if(!$previous) {
            $previous = route('myprofile.index');
        }
        
        return $previous;
    }

    

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    protected function register(Request $request){
        $input = $request->all();
        $validator = $this->validator($input);
        if($validator->passes()){
            
            $data = $this->create($input)->toArray();
            $data['email_token']= str_random(25);
            $user = User::find($data['id']);
            $user->email_token = $data['email_token'];
            $user->save();
            
            Mail::send('auth.register_mail.confirm_email',$data, function ($message) use ($data){
                $message->to($data['email']);
                $message->subject('Registration Confirmation');
            });
            
            return redirect($this->getRedirectUrl())->with('warning_message','Для завершения регистрации подтвердите Ваш email. Письмо отправлено на ваш почтовый адрес.');
        }
        return redirect($this->getRedirectUrl())->with('error_message','Такой email существует.');
    }

    public function confirmation($token){
        $user  = User::where('email_token',$token)->first();
        if(!is_null($user)){
            $user->update(['confirm_email_status'=>1,'email_token'=>'']);
            Auth::login($user, true);
            return redirect($this->getRedirectUrl())->with('success_message','Ваш профиль активирован.');
        }
        return redirect($this->getRedirectUrl())->with('error_message','Ошибка подтверждения.');
    }
}
