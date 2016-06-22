<?php namespace MrCoffer\Http\Controllers\Account;

use Illuminate\Http\Request;
use MrCoffer\Account\Account;
use Illuminate\Auth\AuthManager;
use MrCoffer\Http\Controllers\Controller;
use Illuminate\Routing\Redirector as Redirect;
use Illuminate\Validation\Factory as ValidatorFactory;

/**
 * Class PatchController
 * Responsible for handling the updating of an existing Account.
 *
 * @package MrCoffer\Http\Controllers\Account
 */
class PatchController extends Controller
{
    /**
     * Get and set information about the current
     * authentication state.
     *
     * @var AuthManager
     */
    protected $auth;

    /**
     * Useful for getting information from the Http Request.
     *
     * @var Request
     */
    protected $request;

    /**
     * Useful for setting and sending a redirect http response.
     *
     * @var Redirect
     */
    protected $redirect;

    /**
     * Factory class to make new Validators.
     *
     * @var ValidatorFactory
     */
    protected $validatorFactory;

    /**
     * PatchController constructor.
     *
     * @param AuthManager      $auth
     * @param Request          $request
     * @param Redirect         $redirect
     * @param ValidatorFactory $validatorFactory
     */
    public function __construct(AuthManager $auth, Request $request, Redirect $redirect, ValidatorFactory $validatorFactory)
    {
        $this->middleware('auth');
        $this->auth = $auth;
        $this->request = $request;
        $this->redirect = $redirect;
        $this->validatorFactory = $validatorFactory;
    }



    /**
     * Validates the incoming request from the edit Account form, then checks for which values have
     * changed (if any) then if something has changed perform a database update of the Account
     * record then route the User back to the dashboard.
     *
     * @param int     $id      The ID of the Account to be updated.
     * @param Account $account Account model to update the database with.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function patch($id, Account $account)
    {
        /** @var \Illuminate\Database\Eloquent\Model  $account */
        $account = $account->query()->findOrFail($id);

        // Make a new Validator and pass it the required data.
        $validator = $this->validatorFactory->make($this->request->all(), [
            'name'          => 'required',
            'number'        => 'required',
            'account-type'  => 'required|exists:accountTypes,id',
            'bank'          => 'required|exists:banks,id',
        ]);

        // If validation fails then redirect back to the edit page with errors.
        if ($validator->fails()) {
            return $this->redirect->route('account.edit')->withErrors($validator)->withInput();
        }

        // Unpack request data.
        $requestName = $this->request->input('name');
        $requestNumber = $this->request->input('number');
        $requestTypeID = $this->request->input('account-type');
        $requestBankID = $this->request->input('bank');

        // Simple flag whether we changed anything or not.
        $changed = false;

        // Set the 'name' attribute on the Account if it has changed.
        if ($account->getAttribute('name') !== $requestName) {
            $account->setAttribute('name', $requestName);
            $changed = true;
        }

        // Set the 'number' attribute on the Account if it has changed.
        if ($account->getAttribute('number') !== $requestNumber) {
            $account->setAttribute('number', $requestNumber);
            $changed = true;
        }

        // Set the 'type_id' attribute on the Account if it has changed.
        if ($account->getAttribute('type_id') !== $requestTypeID) {
            $account->setAttribute('type_id', $requestTypeID);
            $changed = true;
        }

        // Set the 'bank_id' on the Account if it has changed.
        if ($account->getAttribute('bank_id') !== $requestBankID) {
            $account->setAttribute('bank_id', $requestBankID);
            $changed = true;
        }

        // Only perform an update if something has changed.
        if ($changed) {
            $account->update();
        }

        // Redirect back to the dashboard.
        return $this->redirect->route('dashboard');
    }
}
