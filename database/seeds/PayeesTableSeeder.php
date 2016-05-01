<?php

use Illuminate\Database\Seeder;
use MrCoffer\Transaction\Payee;

/**
 * Class PayeesTableSeeder
 */
class PayeesTableSeeder extends Seeder
{
    /**
     * @var Payee
     */
    protected $payee;

    /**
     * PayeesTableSeeder constructor.
     * @param Payee $payee
     */
    public function __construct(Payee $payee)
    {
        $this->payee = $payee;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->payee = 'The Greatest Car Shop';
        $this->payee->save();
    }
}
