<?php namespace MrCoffer\Http\Controllers\Account;

use MrCoffer\Account\Account;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use MrCoffer\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Routing\Redirector as Redirect;
use Illuminate\Contracts\View\Factory as ViewFactory;

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
     * Factory instance that will make new View instances.
     *
     * @var ViewFactory
     */
    protected $viewFactory;

    /**
     * Service for making Http Redirects.
     *
     * @var Redirect
     */
    protected $redirect;

    /**
     * AccountShowCtrl constructor.
     *
     * @param Account     $account
     * @param Gate        $gate
     * @param ViewFactory $viewFactory
     * @param Redirect    $redirect
     */
    public function __construct(Account $account, Gate $gate, ViewFactory $viewFactory, Redirect $redirect)
    {
        $this->middleware('auth');
        $this->account = $account;
        $this->gate = $gate;
        $this->viewFactory = $viewFactory;
        $this->redirect = $redirect;
    }

    /**
     * Authorizes that the currently authenticated user is able to see the requested
     * Account. If so then return the view of the Account.
     *
     * @param string $id Unique identifier of the Account we would like to view.
     * @return View|RedirectResponse
     */
    public function show($id)
    {
        // Attempt to find the Account database record by the received $id.
        $account = $this->account->query()->where('id', intval($id))->firstOrFail();

        // Now that we have an Account we must ensure that the currently authenticated
        // User is allowed to access this Account.
        if ($this->gate->denies('canShow', $account)) {
            // Route the User back to the dashboard if they are not
            // allowed to see the requested Account.
            return $this->redirect->route('dashboard');
        }

        // Should this be the User's Account then render the view.
        return $this->viewFactory->make('account.show', ['account' => $account]);
    }
}
