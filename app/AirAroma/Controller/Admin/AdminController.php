<?php

namespace AirAroma\Controller\Admin;

use AirAroma\Model\User;
use AirAroma\Repository\UserRepository;
use AirAroma\Repository\WebsiteRepository;
use App\Http\Controllers\Controller;
use Illuminate\Config\Repository as Config;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Validation\Factory as Validator;


class AdminController extends Controller
{

    /**
     * 
     *
     * @var array
     */
    public function index()
    {       
        return view('admin.index');
    }

    /**
     * 
     *
     * @var array
     */
    public function logout()
    {
        auth()->guard('admin')->logout();
        return redirect(basePath().'/admin/login');
    }


    /**
     * 
     *
     * @var array
     */
    public function login(Validator $validator, UserRepository $userRepository, WebsiteRepository $websiteRepository)
    {
        if (auth()->guard('admin')->check()) {
            return redirect(basePath().'/admin');
        }

        if (request()->isMethod(('post'))) {

            $rules = [
                'login' => 'required',
                'password' => 'required',
            ];

            $valid = $validator->make(request()->all(), $rules);

            if ($valid->fails()) {
                return view('admin.login')->withErrors(['Credentials are missing.']);
            }

            $json = $userRepository->loginAuthAPI();

            if (! $json) {
                return view('admin.login')->withErrors(['Authentication failed.']);
            }

            $user = $userRepository->insertUser($json);
            $userWebsiteRestriction = $websiteRepository->getAuthWebsitesArray($user);

            if (! in_array(websiteId(), $userWebsiteRestriction)) {
                return view('admin.login')->withErrors(['Account not configured.']);
            }

            auth()->guard('admin')->login($user,false);

            if (auth()->guard('admin')->check()) {
                request()->session()->put('websiteId', websiteId());
                return redirect(basePath().'/admin');
            }
        }

        return view('admin.login');
    }
}
