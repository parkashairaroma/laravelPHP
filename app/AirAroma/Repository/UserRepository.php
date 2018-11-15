<?php

namespace AirAroma\Repository;

use AirAroma\Model\Role;
use AirAroma\Model\User;
use AirAroma\Model\Usersrole;
use AirAroma\Model\Userswebsites;
use AirAroma\Repository\WebsiteRepository;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Hashing\BcryptHasher as Hash;

class UserRepository
{
    function __construct(Userswebsites $usersWebsites, Usersrole $usersRole, Role $role, User $user, Hash $hash, WebsiteRepository $websiteRepository)
    {
        $this->user = $user;
        $this->role = $role;
        $this->websiteRepository = $websiteRepository;
        $this->hash = $hash;
        $this->usersRole = $usersRole;
        $this->usersWebsites = $usersWebsites;
    }

    /**
     * authenticate user with orders api
     */
    public function loginAuthAPI()
    {
        $api = app('AirAroma\Library\API');

        $input = app('Input');
        $config = app('config');

        $params = [
            'login' => $input->get('login'),
            'password' => $input->get('password')
        ];

        $url = $config->get('airaroma.orders_api') . '/auth';

        $api->post($url, $params);

        return json_decode($api->response());
    }

    /**
     * create user with orders api
     */
    public function createAuthAPI()
    {
        $api = app('AirAroma\Library\API');

        $input = app('Input');
        $config = app('config');

        $params = [
            'login' => $input->get('login'),
            'password' => $input->get('password')
        ];

        $url = $config->get('airaroma.orders_api') . '/auth';

        $api->post($url, $params);

        return json_decode($api->response());
    }
    /**
     *  Find or Insert user after successful API authentication
     */
    public function insertUser($json)
    {
        extract((array) $json);

        $account = $this->user->firstOrNew(['api_token' => $USERS_TOKEN]);

        $account->usr_name = $USERS_USERNAME;
        $account->usr_email = $USERS_EMAIL;
        $account->api_token = $USERS_TOKEN;
        $account->password = $this->hash->make($USERS_TOKEN);

        $account->save();

        return $account;
    }

    /**
     *  Insert user Admin
     */
    public function insertUserAdmin()
    {
        //extract((array) $json);

        $account = $this->user->firstOrNew(['api_token' => null]);

        $input = app('Input');

        $account->usr_name = $input->get('login');
        $account->usr_email = $input->get('user_email');
        //$account->api_token = $USERS_TOKEN;
        $account->password = $this->hash->make($input->get('password'));

        $account->save();

        return $account;
    }

    /**
     * list of configured users and their corresponding roles, and sites.
     */
    public function getUsers()
    {
        if (websiteId() == 1)         // Only Grab Userslist when its USA Website.
        {
            return $this->user->get();
        }
        else
        {
            return $this->user->join('userswebsites', function ($join) {
                $join->on('userswebsites.usrweb_usr_id', '=', 'users.usr_id');
            })->where('usrweb_web_id', websiteId())->get();
        }
    }

    /**
     * ajax update user settings
     */
    public function updateUser($request, $userId) {

        foreach ($request as $item => $values) {
            switch ($item) {
                case 'usr_roles':
                    $this->usersRole->where('usrrol_usr_id', $userId)->delete();
                    foreach ($values as $value) {
                        $this->usersRole->create([
                            'usrrol_usr_id' => $userId,
                            'usrrol_rol_id' => $value
                        ]);
                    }
                break;
                case 'usr_websites':
                    $this->usersWebsites->where('usrweb_usr_id', $userId)->delete();
                    foreach ($values as $value) {
                        $this->usersWebsites->create([
                            'usrweb_usr_id' => $userId,
                            'usrweb_web_id' => $value
                        ]);
                    }
                break;
            }
        }
        return true;
    }
}
