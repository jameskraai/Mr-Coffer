<?php

use MrCoffer\Bank;
use Illuminate\Database\Seeder;

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
