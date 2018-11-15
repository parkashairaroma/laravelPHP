<?php

namespace AirAroma\Controller\Admin;

use AirAroma\Model\Account;
use AirAroma\Model\Passwordreset;
use AirAroma\Repository\Store\AccountRepository;
use AirAroma\Repository\Store\OrderRepository;
use AirAroma\Repository\Store\StoreRepository;
use AirAroma\Service\FormService;
use App\Http\Controllers\Controller;
use Illuminate\Hashing\BcryptHasher as Hash;
use Illuminate\Mail\Mailer as Mail;
use Laravel\Socialite\Contracts\Factory as Socialite;

class AccountController extends Controller
{
    public function __construct(
        Mail $mail,
        Hash $hash,
        Account $account,
        Socialite $socialite,
        FormService $formService,
        Passwordreset $passwordreset,
        AccountRepository $accountRepository,
        OrderRepository $orderRepository,
        StoreRepository $storeRepository
    ) {

        $this->mail = $mail;
        $this->hash = $hash;
        $this->account = $account;
        $this->socialite = $socialite;
        $this->formService = $formService;
        $this->passwordreset = $passwordreset;
        $this->accountRepository = $accountRepository;
        $this->orderRepository = $orderRepository;
        $this->storeRepository = $storeRepository;
    }

    /**
     * get list of members
     */
	public function getMembers()
	{
        $members = $this->accountRepository->getAccounts();
        return view('admin.members.list')->with(compact('members'));
	}
}
