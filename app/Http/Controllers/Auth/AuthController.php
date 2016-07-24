<?php

namespace MrCoffer\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Validation\Factory as ValidatorFactory;
use Illuminate\Validation\Validator;
use MrCoffer\Http\Controllers\Controller;
use MrCoffer\User;

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
     * Factory class to make new Validator instances.
     *
     * @see Validator
     *
     * @var ValidatorFactory
     */
    protected $validatorFactory;

    /**
     * Create a new authentication controller instance.
     *
     * @param User             $user
     * @param ValidatorFactory $validatorFactory
     */
    public function __construct(User $user, ValidatorFactory $validatorFactory)
    {
        $this->middleware($this->guestMiddleware(), ['except' => ['logout', 'getLogout']]);
        $this->user = $user;
        $this->validatorFactory = $validatorFactory;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     *
     * @return Validator
     */
    protected function validator(array $data)
    {
        return $this->validatorFactory->make($data, [
            'name'     => 'required|max:255',
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return User
     */
    protected function create(array $data)
    {
        $this->user->setAttribute('name', $data['name']);
        $this->user->setAttribute('email', $data['email']);
        $this->user->setAttribute('password', $data['password']);
        $this->user->save();

        return $this->user;
    }
}
