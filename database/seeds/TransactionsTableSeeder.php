<?php

use Illuminate\Database\Seeder;
use MrCoffer\Account\Account;
use MrCoffer\Transaction\Category;
use MrCoffer\Transaction\Payee;
use MrCoffer\Transaction\Status;
use MrCoffer\Transaction\Transaction;

/**
 * Class TransactionsTableSeeder.
 */
class TransactionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = Category::where('name', 'automotive')->first();
        $payee = Payee::where('name', 'The Greatest Car Shop')->first();
        $status = Status::where('name', 'cleared')->first();
        $account = Account::where('number', 11292014)->first();

        $transaction = new Transaction();
        $transaction->memo = 'beefing up the bug.';
        $transaction->category_id = $category->id;
        $transaction->amount = 100.21;
        $transaction->payee_id = $payee->id;
        $transaction->status_id = $status->id;
        $transaction->account_id = $account->id;
        $transaction->save();
    }
}
