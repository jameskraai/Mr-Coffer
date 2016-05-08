<?php

namespace MrCoffer\Http\Controllers\Auth;

use Validator;
use MrCoffer\User;
use MrCoffer\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Where to redirect if login failed.
     *
     * @var string
     */
    protected $loginPath = '/login';

    /**
     * Where to redirect to after successfully logging out.
     *
     * @var string
     */
    protected $redirectAfterLogout = '/login';

    /**
     * Eloquent model instance.
     *
     * @var User
     */
    protected $user;

    /**
     * Create a new authentication controller instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->middleware($this->guestMiddleware(), ['except' => ['logout', 'getLogout']]);
        $this->user = $user;
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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
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
        $this->user->name = $data['name'];
        $this->user->email = $data['email'];
        $this->user->password = bcrypt($data['password']);
        $this->user->save();

        return $this->user;
    }
}
