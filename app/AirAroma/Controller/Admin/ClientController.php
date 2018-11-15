<?php

namespace AirAroma\Controller\Admin;

use AirAroma\Model\Client;
use AirAroma\Repository\ClientRepository;
use AirAroma\Service\ClientService;
use App\Http\Controllers\Controller;
use Illuminate\Config\Repository as Config;
use Illuminate\Contracts\Routing\ResponseFactory as Reponse;
use Illuminate\Http\Request;


class ClientController extends Controller
{
    public function __construct(Config $config, Request $request, Reponse $response, ClientService $clientService, ClientRepository $clientRepository, Client $client)
	{
		$this->request = $request;
		$this->response = $response;
		$this->client = $client;
		$this->config = $config;
		$this->clientService = $clientService;
		$this->clientRepository = $clientRepository;
		$this->websiteId = websiteId();
	}

	/*
	* show all banners
	*/
	public function getClients()
	{
  $clients = $this->clientRepository->getClientsFromSiteConfig(['order' => 'asc']);
		return view('admin.clients.list', compact('clients'));
	}

	/*
	* create a new banner
	*/
	public function createClient()
	{
		if ($this->request->isMethod('post')) {

      $fields = [
                'cli_name' => 'required',
                'cli_slug' => 'required',
            ];

      $valid = $this->clientService->validateForm($fields);
            if ($valid->fails()) {
                return redirect()->back()->withErrors($valid)->withInput();
            }
			$this->clientRepository->insertClient();

			return redirect('/admin/clients');
		}

  $colours = $this->clientRepository->getColours();

		return view('admin.clients.form', compact('colours', 'client'));
	}

	/*
	* edit existing banner
	*/
	public function editClient($clientId)
	{
		if ($this->request->isMethod('POST')) {


      $fields = [
                'cli_name' => 'required',
                'cli_slug' => 'required',
            ];

      $valid = $this->clientService->validateForm($fields);
            if ($valid->fails()) {
                return redirect()->back()->withErrors($valid)->withInput();
            }
			$this->clientRepository->updateClient($clientId);

			return redirect('/admin/clients');
		}

		$client = $this->clientRepository->getClientById($clientId);
		$colours = $this->clientRepository->getColours();

		return view('admin.clients.form', compact('colours', 'client'));
	}

	/*
	* delete banner
	*/
	public function deleteClient($clientId)
	{
     if ($this->clientRepository->deleteClient($clientId)) {
        	return redirect('admin/clients');
        }
     return redirect('admin/clients');
	}

	/*
	* api: update banner status
	*/
	public function updateBannerStatus($bannerId)
	{
		 $updateBannerStatus = $this->bannerRepository->updateBannerStatus($bannerId, $this->request->get('status'));

        if ($updateBannerStatus) {
        	return response()->json(['status' => true, 'reason' => 'Changed']);
        }
	}

	/*
	* api: update client order
	*/
	public function updateClientOrder()
	{
		$updateClientOrder = $this->clientRepository->updateClientOrder($this->request->all());

        if ($updateClientOrder) {
        	return response()->json(['status' => true, 'reason' => 'Saved']);
        }
	}
}