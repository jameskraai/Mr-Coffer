<?php

use Illuminate\Database\Seeder;
use MrCoffer\Account\Type;

class AccountTypesTableSeeder extends Seeder
{
    /**
     * Account Type Model.
     *
     * @var Type
     */
    protected $type;

    public function __construct(Type $type)
    {
        $this->type = $type;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->type->name = 'checking';
        $this->type->save();
    }
}
