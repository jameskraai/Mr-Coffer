<?php namespace MrCoffer\Http\Controllers\Account;

use Illuminate\View\Factory as View;
use MrCoffer\Http\Controllers\Controller;

/**
 * Class CreateController
 * @package MrCoffer\Http\Controllers\Account
 */
class CreateController extends Controller
{
    public function create(View $view)
    {
        return $view->make('account.create', []);
    }
}