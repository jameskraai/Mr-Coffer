<?php

use Illuminate\Database\Seeder;
use MrCoffer\User;

class UsersTableSeeder extends Seeder
{
    /**
     * @var User
     */
    protected $user;

    /**
     * UsersTableSeeder constructor.
     *
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
        $this->user->name = 'Coffer';
        $this->user->email = 'mrcoffer@example.com';
        $this->user->password = bcrypt('secret');
        $this->user->save();

        $secondUser = new User();
        $secondUser->setAttribute('name', 'acorn');
        $secondUser->setAttribute('email', 'acorn@example.com');
        $secondUser->setAttribute('password', bcrypt('secret'));
        $secondUser->save();
    }
}
