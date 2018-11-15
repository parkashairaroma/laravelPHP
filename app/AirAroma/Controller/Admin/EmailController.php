<?php

namespace AirAroma\Controller\Admin;

use AirAroma\Repository\PageRepository;
use AirAroma\Repository\TokenRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use AirAroma\Repository\EmailRepository;

class EmailController extends Controller
{

	function __construct(Request $request, EmailRepository $emailRepository, TokenRepository $tokenRepository) {
		$this->request = $request;
		$this->tokenRepository = $tokenRepository;
        $this->emailRepository = $emailRepository;
	}

	/*
	* show all emails list
	*/
	public function getEmailsList()
	{
        $emaillist = $this->emailRepository->getEmailsList();
		return view('admin.emails.list')->with(compact('emaillist'));
	}

    /**
     * ajax emails edit
     */
	public function updateEmailList($emailtype, $region ,$emails)
	{
		$updateEmail = $this->emailRepository->updateEmailList($emailtype, $region ,$emails);

		if ($updateEmail) {
			return response()->json(['status' => true, 'reason' => 'Saved']);
		}
        else
        {
            return null;
        }
	}

}
