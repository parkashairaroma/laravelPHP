<?php

namespace AirAroma\Repository;
use AirAroma\Model\ClientsPageWebsite;

use Illuminate\Http\Request;

class ClientRepository
{
    /* fixed path for now, to be remedied at a later date */
    protected $colours = ['#000000' => '', '#1f1f1f' => '', '#333333' => '', '#474747' => '', '#5c5c5c' => '', '#707070' => '', '#858585' => '', '#999999' => '', '#adadad' => '', '#c2c2c2' => '', '#d6d6d6' => '', '#ffffff' => ''];
    protected $clientLogoPath = '/images/clients/logos/';

    public function __construct(ClientsPageWebsite $clientspagewebsite, Request $request)
    {
        $this->clientspagewebsite = $clientspagewebsite;
        $this->request = $request;
        $this->websiteId = websiteId();
    }

    public function getClientLogoPath()
    {
        return $this->clientLogoPath;
    }

    public function getClientsFromSiteConfig($options = [])
    {

        $defaults = ['status' => null, 'limit' => null, 'order' => 'asc'];

        if ($options) {
            $defaults = array_merge($defaults, $options);
        }

        extract($defaults);

        $client = app('AirAroma\Model\Client');

        $clients = $client->select('*')->where('cli_web_id', websiteId());
        $clients->leftjoin('clientspagewebsites', 'clientspagewebsites.clipagweb_cli_id', '=', 'clients.cli_id');


        if ($limit) {
            $banners->limit($limit);
        }

        $clients->orderby('clipagweb_ord_num', $order);

        return $clients->get();
    }

    public function getClients($options = [])
    {
        $client = app('AirAroma\Model\Client');

        $defaults = ['byClients' => [], 'approved' => 2, 'order' => 'desc', 'limit' => 6, 'byWeight' => true];

        if ($options) {
            $defaults = array_merge($defaults, $options);
        }

        extract($defaults);

        $clients = $client->select('*');
        $clients->where('cli_enabled', true);
        $clients->where('cli_display_logo', true);

        if ($byClients) {
            $clients->whereIn('cli_slug', $byClients);
        }

        if ($limit) {
            $clients->limit($limit);
        }
        if ($byWeight) {
            $clients->orderby('cli_weight', 'desc');
        }
        return $clients->get();
    }

    public function getClientsPage()
    {
        $client = app('AirAroma\Model\Client');

        $clients = $client->select('*');

        $clients->join('clienttranslations', 'clienttranslations.clt_cli_id', '=', 'clients.cli_id');
        $clients->join('clientspagewebsites', 'clientspagewebsites.clipagweb_cli_id', '=', 'clients.cli_id');
        $clients->where('cli_web_id', websiteId());
        $clients->where('clipagweb_is_enabled', true);
        $clients->orderby('clipagweb_ord_num', 'asc');

        return $clients->get();

    }

    public function getClientBySlug($clientName)
    {
        $client = app('AirAroma\Model\Client');

        $clients = $client->select('*');

        $clients->join('clienttranslations', 'clienttranslations.clt_cli_id', '=', 'clients.cli_id');
        $clients->join('clientspagewebsites', 'clientspagewebsites.clipagweb_cli_id', '=', 'clients.cli_id');
        $clients->where('cli_slug', $clientName);
        $clients->where('clipagweb_is_enabled', true);
        $clients->where('cli_web_id', websiteId());
        return $clients->first();
    }

    public function getColours()
    {
        return $this->colours;
    }

    public function getClientById($clientId)
    {
        $client = app('AirAroma\Model\Client');

        $clients = $client->select('*');

        $clients->join('clienttranslations', 'clienttranslations.clt_cli_id', '=', 'clients.cli_id');
        $clients->join('clientspagewebsites', 'clientspagewebsites.clipagweb_cli_id', '=', 'clients.cli_id');
        $clients->where('cli_id', $clientId);
        //$clients->where('clipagweb_is_enabled', true);
        $clients->where('cli_web_id', websiteId());
        return $clients->first();
    }

    public function clientsRecentProjects()
    {
        $client = app('AirAroma\Model\Client');

        $clients = $client->select('*');

        $clients->join('clienttranslations', 'clienttranslations.clt_cli_id', '=', 'clients.cli_id');
        $clients->join('clientspagewebsites', 'clientspagewebsites.clipagweb_cli_id', '=', 'clients.cli_id');
        $clients->where('cli_web_id', websiteId());
        $clients->where('clipagweb_is_enabled', true);
        //$clients->where('clipagweb_recent_proj', true);

        $clients->orderby('clipagweb_ord_num', 'asc');

        return $clients->take(2)->get();

    }

    public function ifClientExists($clientname)
    {
        $client = app('AirAroma\Model\Client');

        $clients = $client->select('*');

        $clients->join('clientspagewebsites', 'clientspagewebsites.clipagweb_cli_id', '=', 'clients.cli_id');
        $clients->where('cli_web_id', websiteId());
        $clients->where('clipagweb_is_enabled', true);
        $clients->where('cli_slug', $clientname);

        return $clients->get();

    }

    /*
     * update client order
     */
    public function updateClientOrder($clients)
    {
        foreach ($clients['order'] as $order => $clientId) {
            $this->clientspagewebsite->where('clipagweb_cli_id', $clientId)->update(['clipagweb_ord_num' => $order]);
        }
        return true;
    }

    public function updateClient($id)
    {
        $client = app('AirAroma\Model\Client');

        $client->where('cli_id', $id)
            ->update([
                'cli_name' => $this->request->get('cli_name'),
                'cli_slug' => $this->request->get('cli_slug')
            ]);

        $clienttranslation = app('AirAroma\Model\ClientTranslation');

        $clienttranslation->where('clt_cli_id', $id)
            ->update([
                'clt_cli_hero' => $this->request->get('clt_cli_hero'),
                'clt_cli_header' => $this->request->get('clt_cli_header'),
                'clt_cli_text' => $this->request->get('clt_cli_text'),
                'clt_cli_scentheader' => $this->request->get('clt_cli_scentheader'),
                'clt_cli_scenttext' => $this->request->get('clt_cli_scenttextparagraph_content'),
                'clt_cli_banner' => $this->request->get('clt_cli_banner'),
                'clt_cli_feature' => $this->request->get('clt_cli_feature'),
                'clt_cli_textinner' => $this->request->get('clt_cli_textinnerparagraph_content'),
                'clt_cli_quote' => $this->request->get('clt_cli_quoteparagraph_content'),
                'clt_cli_tile1' => $this->request->get('clt_cli_tile1'),
                'clt_cli_tile2' => $this->request->get('clt_cli_tile2'),
                'clt_cli_video' => $this->request->get('clt_cli_video'),
                'clt_cli_title' => $this->request->get('clt_cli_title'),
                'clt_cli_tagdescription' => $this->request->get('clt_cli_tagdescription'),
            ]);

        $clientpagewebsite = app('AirAroma\Model\ClientsPageWebsite');

        $clientpagewebsite->where('clipagweb_cli_id', $id)
            ->update([
                'clipagweb_is_enabled' => $this->request->get('clipagweb_is_enabled'),
            ]);

    }

    public function insertClient()
    {
        $client = app('AirAroma\Model\Client');

        $clientdet = $client->create([
                'cli_name' => $this->request->get('cli_name'),
                'cli_weight' => 30,
                'cli_slug' => $this->request->get('cli_slug'),
                'cli_web_id' => websiteId()
            ]);

        $clienttranslation = app('AirAroma\Model\ClientTranslation');

        $clienttranslation->create([
                'clt_cli_id' => $clientdet->cli_id,
                'clt_cli_hero' => $this->request->get('clt_cli_hero'),
                'clt_cli_header' => $this->request->get('clt_cli_header'),
                'clt_cli_text' => $this->request->get('clt_cli_text'),
                'clt_cli_scentheader' => $this->request->get('clt_cli_scentheader'),
                'clt_cli_scenttext' => $this->request->get('clt_cli_scenttextparagraph_content'),
                'clt_cli_banner' => $this->request->get('clt_cli_banner'),
                'clt_cli_feature' => $this->request->get('clt_cli_feature'),
                'clt_cli_textinner' => $this->request->get('clt_cli_textinnerparagraph_content'),
                'clt_cli_quote' => $this->request->get('clt_cli_quoteparagraph_content'),
                'clt_cli_tile1' => $this->request->get('clt_cli_tile1'),
                'clt_cli_tile2' => $this->request->get('clt_cli_tile2'),
                'clt_cli_video' => $this->request->get('clt_cli_video'),
                'clt_cli_title' => $this->request->get('clt_cli_title'),
                'clt_cli_tagdescription' => $this->request->get('clt_cli_tagdescription'),
            ]);

        $clientpagewebsite = app('AirAroma\Model\ClientsPageWebsite');

        $clients = $client->select('*');

        $clients->join('clientspagewebsites', 'clientspagewebsites.clipagweb_cli_id', '=', 'clients.cli_id');

        $maxValue = $clients->where('cli_web_id', websiteId())->orderBy('clipagweb_ord_num', 'desc')->value('clipagweb_ord_num'); // gets only the id

        $clientpagewebsite->create([
                'clipagweb_cli_id' => $clientdet->cli_id,
                'clipagweb_recent_proj' => false,
                'clipagweb_is_enabled' => $this->request->get('clipagweb_is_enabled'),
                'clipagweb_ord_num' => $maxValue+1
            ]);

    }

    public function deleteClient($id)
    {
        $client = app('AirAroma\Model\Client');
        $clienttranslation = app('AirAroma\Model\ClientTranslation');
        $clientpagewebsite = app('AirAroma\Model\ClientsPageWebsite');

        $clientpagewebsite->where('clipagweb_cli_id', $id)->delete();
        $clienttranslation->where('clt_cli_id', $id)->delete();
        $client->where('cli_id', $id)->delete();

        return null;
    }
}
