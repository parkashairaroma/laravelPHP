<?php

namespace AirAroma\Controller\Admin;

use AirAroma\Repository\RolesRepository;
use AirAroma\Repository\UserRepository;
use AirAroma\Service\UserService;
use AirAroma\Repository\WebsiteRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class UserController extends Controller
{
	public function __construct(Request $request, UserRepository $userRepository, WebsiteRepository $websiteRepository, RolesRepository $rolesRepository, UserService $userService)
	{
		$this->request  = $request;
		$this->userRepository = $userRepository;
		$this->websiteRepository = $websiteRepository;
		$this->rolesRepository = $rolesRepository;
        $this->userService = $userService;
	}

	/*
	* Show users page
	*/
	public function getUsers()
	{
  $users = $this->userRepository->getUsers();
		$rolesList = $this->rolesRepository->getRolesSelectList();

  if (websiteId() == 1)         // Only Grab Websitelist when its USA Website.
  {
      $websitesList = $this->websiteRepository->getWebsitesSelectList();
  }

		return view('admin.users.list')->with(compact('users', 'rolesList', 'websitesList'));
	}

	/**
	 * ajax user edit
	 */
	public function updateUser($userId)
	{
		$updateUser = $this->userRepository->updateUser($this->request->all(), $userId);

		if ($updateUser) {
			return response()->json(['status' => true, 'reason' => 'Saved']);
		}
	}

    /**
     * ajax user add
     */
	public function createUser()
	{
        if ($this->request->isMethod('post')) {
            $valid = $this->userService->validateForm();
            if ($valid->fails()) {
                return redirect()->back()->withErrors($valid)->withInput();
            }

            $json = $this->userRepository->createAuthAPI();

            //if (! $json) {
            //    return view('admin.login')->withErrors(['Authentication failed.']);
           // }

            $this->userRepository->insertUserAdmin();
        }
		return view('admin.users.form');
	}
}