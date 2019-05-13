<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;

use File;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Auth;

class SocialProviderController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect('/login')->with('error_message', 'Произошла ошибка при авторизации через соц. сеть.');
        }
        
        $check_user = User::where('email',$socialUser->getEmail())->first();
        if($check_user){
            if ($check_user->isDefaultAvatar()) {
                    $check_user->account->update([
                        'avatar_link'   => $this->downloadAvatar($check_user, $socialUser, $provider),
                        $provider.'_id' => $socialUser->getId()
                        ]);
                } 
            Auth::login($check_user, true);    
            return redirect()->intended('/');
        }
        
        $this->createUser($socialUser,$provider);
        return redirect()->intended('/');
    }

    /**
     * Создаём нового пользователя
     * @todo Отправка писем при регистрации через социальную сеть
     * @param type $socialUser
     * @param type $provider
     */
    protected function createUser($socialUser,$provider) {
        if(!$socialUser->getEmail() || empty($socialUser->getEmail())) { return; }
        $password = str_random(10);
        $user = User::create([
            'name'                  => $socialUser->getName() ? $socialUser->getName() : '',
            'email'                 => $socialUser->getEmail(),
            'password'              => Hash::make($password),
            'confirm_email_status'  => 1,
            //'email_token'           => Hash::make($password.time().$socialUser->getEmail())
        ]);

        $user->account()->update([
            'avatar_link'           => $this->downloadAvatar($user, $socialUser, $provider),
            $provider.'_id'         => $socialUser->getId()
        ]);
        
        $data['password']   = $password;
        $data['email']      = $user->email;
        $data['name']       = $user->name;
        //$data['email_token']= $user->email_token;
        Mail::send('auth.register_mail.confirm_email_social',$data, function ($message) use ($data){
            $message->to($data['email']);
            $message->subject('Registration Dreamstarter.com.ua');
        });

        Auth::login($user, true);
    }
    
    /**
     * Загрузка аватара пользователя
     * @todo Проверить на всех провайдерах
     * @param type $user
     * @param type $socialUser
     * @return string
     */
    protected function downloadAvatar($user, $socialUser ,$provider) {
        $exten = [
            'image/png'     => 'png',
            'image/jpeg'    => 'jpg',
            'image/gif'     => 'gif',
            'image/bmp'     => 'bmp',
            'image/tiff'    => 'tiff',
            'image/svg+xml' => 'svg'];
        
        $FileName = basename(tempnam(sys_get_temp_dir(), $provider.'-'));
        $patch = 'users/'.$user->id.'/'.$FileName;

        try {
            Storage::disk('public')->put($patch, file_get_contents($socialUser->getAvatar()));
            $type = Storage::disk('public')->mimeType($patch);
            $fullp = Storage::disk('public')->path($patch);
            
            $NewPath = '';
            if (array_key_exists($type, $exten)) {
                $NewPath = $patch.'.'.$exten[$type];
                rename($fullp, $fullp.'.'.$exten[$type]);
            } else {
                Storage::disk('public')->delete($patch);
            }
            
            return $NewPath;
        } catch (Exception $ex) {
            return '';
        }
    }
}
