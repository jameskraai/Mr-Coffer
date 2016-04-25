<?php

use MrCoffer\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * @var User
     */
    protected $user;

    /**
     * UsersTableSeeder constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->user->name = 'James';
        $this->user->email = 'james@example.com';
        $this->user->password = bcrypt('secret');
        $this->user->save();
    }
}
