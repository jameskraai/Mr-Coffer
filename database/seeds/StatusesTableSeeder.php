<?php

use Illuminate\Database\Seeder;
use MrCoffer\Transaction\Status;

/**
 * Class StatusesTableSeeder
 */
class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pending = new Status();
        $pending->name = 'pending';
        $pending->save();

        $cleared = new Status();
        $cleared->name = 'cleared';
        $cleared->save();
    }
}
