<?php

use Illuminate\Database\Seeder;
use MrCoffer\Bank;

class BanksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $chase = new Bank();
        $chase->name = 'chase';
        $chase->save();

        $wellsFargo = new Bank();
        $wellsFargo->name = 'wells fargo';
        $wellsFargo->save();
    }
}
