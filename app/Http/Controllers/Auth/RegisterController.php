<?php

namespace MrCoffer\Http\Controllers\Auth;

use MrCoffer\User;
use MrCoffer\Http\Controllers\Controller;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Contracts\Validation\Factory as ValidatorFactory;

/**
 * Class RegisterController
 * This controller handles the registration of new users as well as their
 * validation and creation. By default this controller uses a trait to
 * provide this functionality without requiring any additional code.
 */
class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * New User model that can have attributes assigned
     * and then saved to the database.
     *
     * @var User
     */
    protected $user;

    /**
     * Factory to make new Validators.
     *
     * @var ValidatorFactory
     */
    protected $validatorFactory;

    /**
     * RegisterController constructor.
     *
     * @param User             $user             New User model.
     * @param ValidatorFactory $validatorFactory Validates incoming data.
     */
    public function __construct(User $user, ValidatorFactory $validatorFactory)
    {
        $this->middleware('guest');
        $this->user = $user;
        $this->validatorFactory = $validatorFactory;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data Data to be validated.
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
     * Set the attributes of our User and return the User.
     *
     * @param  array  $data Data to set on the new User.
     *
     * @return User
     */
    protected function create(array $data)
    {
        $this->user->setAttribute('name', $data['name']);
        $this->user->setAttribute('email', $data['email']);
        $this->user->setAttribute('password', $data['password']);

        return $this->user;
    }
}