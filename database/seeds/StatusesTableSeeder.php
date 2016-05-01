<?php

use Illuminate\Database\Seeder;
use MrCoffer\Transaction\Status;

/**
 * Class StatusesTableSeeder
 */
class StatusesTableSeeder extends Seeder
{
    /**
     * @var Status
     */
    protected $status;

    /**
     * StatusesTableSeeder constructor.
     * @param Status $status
     */
    public function __construct(Status $status)
    {
        $this->status = $status;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->status->name = 'pending';
        $this->status->save();

        $cleared = $this->status->fresh();
        $cleared->name = 'cleared';
        $cleared->save();
    }
}
