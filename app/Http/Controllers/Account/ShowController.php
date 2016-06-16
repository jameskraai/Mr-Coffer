<?php namespace MrCoffer\Http\Controllers\Account;

use Illuminate\View\View;
use MrCoffer\Account\Account;
use MrCoffer\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Access\Gate;

/**
 * Class AccountShowCtrl
 * This controller is singularly responsible for displaying a single
 * Account that the current User is authorized to view.
 *
 * @package MrCoffer\Http\Controllers\Account
 */
class ShowController extends Controller
{
    /**
     * Account Model.
     *
     * @var Account
     */
    protected $account;

    /**
     * Access Gate service.
     *
     * @var Gate
     */
    protected $gate;

    /**
     * AccountShowCtrl constructor.
     *
     * Account $account
     * Gate    $gate
     */
    public function __construct(Account $account, Gate $gate)
    {
        $this->middleware('auth');
        $this->account = $account;
        $this->gate = $gate;
    }

    /**
     * @return View
     */
    public function show($id)
    {
        $account = $this->account->query()->where('id', $id)->firstOrFail();

        if ($this->gate->denies('canShow', $account)) {
            abort(403, 'Nope.');
        }

        return view('account.show', ['account' => $account]);
    }
}