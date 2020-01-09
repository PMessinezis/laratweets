<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Socialite;
use App\AuditLog;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;


    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    /**
     * Redirect to social site oAuth url 
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {

        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (Exception $e) {
            AuditLog::log(AuditLog::ERROR, $e);
            return redirect('/login');
        }
        $appUser = $this->findOrCreateUser($socialUser, $provider);
        AuditLog::log(AuditLog::USER_OAUTH_AUTHENTICATION, $appUser);
        Auth::login($appUser, true);
        return redirect($this->redirectTo);
    }


    public function findOrCreateUser($providerUser, $provider)
    {

        $q =  EntityManager::createQuery("Select u from App\User u where u.provider ='$provider' and u.provider_id = " . $providerUser->getId());
        $users = $q->getResult();
        $user = $users[0] ?? null;

        if (!$user) {
            $user = new User;
            $user->setProvider($provider);
            $user->setProviderId($providerUser->getId());
            $user->setName($providerUser->getName());
        }
        $user->setEmail($providerUser->getEmail());
        $user->setProviderToken($providerUser->token);
        $user->setProviderSecret($providerUser->tokenSecret);
        $user->setProviderScreenName($providerUser->nickname);
        $user->setProviderAvatar($providerUser->avatar);
        $user->save();
        return $user;
    }
}
