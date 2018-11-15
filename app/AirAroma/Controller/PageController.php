<?php

namespace AirAroma\Controller;

use App\Http\Controllers\Controller;
use Spatie\Newsletter\Newsletter as Newsletter;
use AirAroma\Repository\WebsiteRepository;

class PageController extends Controller
{

    protected $lang;

    public function __construct(Newsletter $newsletter, WebsiteRepository $website)
    {
        $this->request = app('request');
        $this->blade = $this->request->get('blade');
        $this->newsletter = $newsletter;
        $this->website = $website;
    }

    /**
     * Generate page based on template
     * Todo:
     * Translations
     * Segment referencing
     *
     * @return Response
     */
    public function index($lang = null)
    {
        $bannerRepository = app('AirAroma\Repository\BannerRepository');
        $clientRepository = app('AirAroma\Repository\ClientRepository');
        $blogRepository = app('AirAroma\Repository\BlogRepository');

        $banners = $bannerRepository->getBannersFromSiteConfig(['status' => 1, 'limit' => 6]);

        $clients = $clientRepository->getClients(['limit' => 4]);
        $clientLogoPath = $clientRepository->getClientLogoPath();

        $clientsproject = $clientRepository->clientsRecentProjects();

        $blogs = $blogRepository->blogPosts()->where('blg_status', 1)->first();

        return view('index')
            ->with(compact('banners', 'clients', 'clientLogoPath', 'blogs','clientsproject'));
    }


    public function aropromo($lang = null)
    {
        $clientRepository = app('AirAroma\Repository\ClientRepository');

        $clients = $clientRepository->getClients(['limit' => 4, 'byWeight' => 'true', 'byClients' => ['unilever', 'axe', 'caudalie', 'colgate']]);
        $clientLogoPath = $clientRepository->getClientLogoPath();

        return view('pages.aropromo')
            ->with(compact('clients', 'clientLogoPath'));
    }

    /**
     * Description
     * @param type $lang
     * @return type
     */
    public function showPage($lang = null)
    {
        return view('pages'.$this->blade);
    }

    /**
     * Description
     * @param type $industryName
     * @param type $lang
     * @return type
     */
    public function scenting($lang = null, $industryName = null)
    {
        $industryRepository = app('AirAroma\Repository\IndustryRepository');
        $clientRepository = app('AirAroma\Repository\ClientRepository');

        if (! isLanguageSet($lang)) {
            $industryName = $lang;
        }

        if ($industryName) {

            $industry = $industryRepository->getIndustryIdByName($industryName);
            if ($industry == null)
            {
                return abort(404);
            }
            $clients = $industryRepository->getClientsByIndustryId($industry->ind_id, ['limit' => 4])->get();
            $clientLogoPath = $clientRepository->getClientLogoPath();

            return view('pages.scenting.'.$industry->ind_slug)
                ->with(compact('clients', 'clientLogoPath'));

        }

        $industries = $industryRepository->getIndustriesByWebsiteId(websiteId())->get();

        return view('pages.scenting')
            ->with(compact('industries'));
    }

    /**
     * Description
     * @param type $clientName
     * @param type $lang
     * @return type
     */
    public function clients($lang = null, $clientName = null)
    {

        $clientRepository = app('AirAroma\Repository\ClientRepository');

        if (! isLanguageSet($lang)) {
            $clientName = $lang;
        }

        $blade = 'pages.clients';

        if ($clientName) {
            $blade .= '.'.'post';

            $clientexists = $clientRepository->ifClientExists($clientName);

            if (! view()->exists($blade) || count($clientexists) == 0) {
                return abort(404);
            }

            $clientPost = $clientRepository->getClientBySlug($clientName);

            view()->share('clientDesc', $clientPost->clt_cli_tagdescription);

            return view($blade)
                ->with(compact('clientPost'));
        }

        $clients = $clientRepository->getClients(['limit' => 12, 'byWeight' => 'true', 'byClients' => [
            'sls-hotel-casino', 'max-mara', 'aston-martin', 'cathay-pacific',
            'cirque-du-soleil', 'fairmont', 'langham-hotel', 'mercedes-benz',
            'moooi', 'sofitel', 'ritz-carlton', 'infiniti'
            ]]);

        $clientspage = $clientRepository->getClientsPage();

        $clientLogoPath = $clientRepository->getClientLogoPath();

        return view($blade)
            ->with(compact('clients', 'clientLogoPath', 'clientspage'));
    }

    /**
     * Description
     * @param type $clientName
     * @param type $lang
     * @return type
     */
    public function blogList($lang = null, $page = null)
    {
        $blogRepository = app('AirAroma\Repository\BlogRepository');
        $instagramFeed = app('AirAroma\Library\SocialFeed\InstagramFeed');

        if (! isLanguageSet($lang)) {
            $page = $lang;
        }

        $blogs = $blogRepository->blogPosts(['status' => 1, 'approved' => 2, 'paginate' => 6]);

        /* removed instagram: requested by Alan */
        //$instagrams = $instagramFeed->pull();

        return view('pages.blog')
            ->with(compact('blogs', 'instagrams'));
    }

    /**
     * Description
     * @param type $clientName
     * @param type $lang
     * @return type
     */
    public function blogPost($lang = null, $blogSlug = null)
    {
        $blogRepository = app('AirAroma\Repository\BlogRepository');
        $tagRepository = app('AirAroma\Repository\TagRepository');
        $auth = app('Illuminate\Contracts\Auth\Guard');

        if (! isLanguageSet($lang)) {
            $blogSlug = $lang;
        }

        $blogPost = $blogRepository->getBlogBySlug($blogSlug);

        if (! $blogPost) {
            return abort(404);
        }

        if (! $blogPost->blg_status) {
            if (! $auth->check()) {
                return abort(404);
            }
        }

        if ($blogPost->blg_status && $blogPost->blg_approved != 2) {
            if (! $auth->check()) {
                return abort(404);
            }
        }

        $tags = $tagRepository->getTagsByBlogId($blogPost->blg_id)->get();

        view()->share('blogTitle', $blogPost->blg_title);
        view()->share('blogSummary', paragraph($blogPost->blg_content));
        view()->share('blogImage', url($blogPost->blg_hero));

        return view('pages.blog.post')
            ->with(compact('blogPost', 'tags'));
    }

    /**
     * Description
     * @param type $clientName
     * @param type $lang
     * @return type
     */
    public function blogTag($lang = null, $tag = null)
    {
        $blogRepository = app('AirAroma\Repository\BlogRepository');

        if (! isLanguageSet($lang)) {
            $tag = $lang;
        }

        $posts = $blogRepository->getPostsByTag($tag)->get();

        return view('pages.blog.tag')
            ->with(compact('posts', 'tag'));
    }

    /**
     * Description
     * @param type $locationName
     * @param type $lang
     * @return type
     */
    public function contact($lang = null)
    {
        $recaptchaSiteKey = getenv('RECAPTCHA_KEY');
        $recaptchaRequired = env('RECAPTCHA_REQUIRED');
        $recaptchaIgnore = explode(',', getenv('RECAPTCHA_IGNORE'));

        $countryRepository = app('AirAroma\Repository\CountryRepository');
        $countries = $countryRepository->getCountries();
        $countryCode = null;
        $stateCode = null;

        $key = env('MAILCHIMP_APIKEY');
        $quickkey = env('MAILCHIMP_INTEREST_QUICK');

        if ($this->request->isMethod('post')) {

            $countryCode = $this->request->get('contact-form-country');
            $stateCode = $this->request->get('contact-form-state');

            $contactService = app('AirAroma\Service\ContactService');

            $valid = $contactService->validateForm();

            if ($valid->fails()) {
                return redirect('contact')->withErrors($valid)->withInput();
            }

            if ($recaptchaRequired && ! in_array($this->request->server('REMOTE_ADDR'), $recaptchaIgnore)) {
                if ($contactService->validateRecaptcha() === false) {
                    $recaptcha = ["recaptchaError" => true];
                    return redirect('contact')->withErrors($recaptcha)->withInput();
                }
            }

            $name = explode(" ", $this->request->get('contact-form-name'), 2);

            $lastname = "";

            if (count($name) > 1)
            {
                $lastname = $name[1];
            }

            $firstname = $name[0];

            $website = $this->website->getWebsiteById(websiteId())->first();

            if ($this->request->get('airaroma_newsletter') != null)
            {
                $this->newsletter->subscribeOrUpdate($this->request->get('contact-form-email'),['FNAME'=>$firstname, 'LNAME'=>$lastname, 'COUNTRY'=>$this->request->get('country_text')], 'subscribers', ['interests'=>[$website->web_mc_interestgroup=>true,$quickkey=>true]]);
            }

            if ($contactService->sendEmails()) {
                $this->request->session()->flash('successMessage', true);
            }
        }
        if ($this->request->old('contact-form-country') != "") {
            $countryCode = $this->request->old('contact-form-country');
        }
        if ($countryCode == null) {
            $countryCode = $countryRepository->getCountryCodeFromGeoLocation();
        }
        $states = $countryRepository->getCountryStatesByCountryCode($countryCode);

        return view('pages.contact')
            ->with(compact('recaptchaSiteKey', 'countries', 'states', 'countryCode', 'stateCode'));
    }

    /**
     * Description
     * @param type $locationName
     * @param type $lang
     * @return type
     */
    public function locations($lang = null, $countrySlug = null)
    {
        $countryRepository = app('AirAroma\Repository\CountryRepository');

        $countryCode = null;

        $scrollToLocations = false;

        if (! isLanguageSet($lang)) {
            $countrySlug = $lang;
        }

        // If Slug is set, validate it and get the CountryCode
        if ($countrySlug != null) {
            if (!$countryRepository->isValidSlug($countrySlug)) {
                return redirect('locations');
            }
            $country = $countryRepository->getCountryBySlug($countrySlug);
            if ($country) {
                $countryCode = $country->cou_code;
            }
            $scrollToLocations = true;
        }

        // If code is not set, get it from Geolocation
        if ($countryCode == null) {
            $countryCode = $countryRepository->getCountryCodeFromGeoLocation();
        }

        // Get countries and locations
        $countries = $countryRepository->getCountries();
        $locations = $countryRepository->getLocationsByCountryCode($countryCode);

        return view('pages.locations')
            ->with(compact('countries', 'locations', 'countryCode', 'scrollToLocations'));
    }
    /**
     * Description
     * @param type $locationName
     * @param type $lang
     * @return type
     */
    public function country($lang = null)
    {
        $websiteRepository = app('AirAroma\Repository\WebsiteRepository');
        $countryRepository = app('AirAroma\Repository\CountryRepository');

        $websites = $websiteRepository->getWebsiteNamesAndDomains();
        $countryFlagPath = $countryRepository->getCountryFlagPath();

        return view('pages.country')
            ->with(compact('websites', 'countryFlagPath'));
    }

    public function sitemap($lang = null)
    {
        $sitemapRepository = app('AirAroma\Repository\SitemapRepository');

        $sitemapRepository->lang = (isLanguageSet($lang)) ? DIRECTORY_SEPARATOR.$lang : null;

        $sitemap = $sitemapRepository->generateArray();

        return view('pages.sitemap')
            ->with(compact('sitemap'));
    }

    public function sitemapXML($lang = null)
    {

        $sitemapRepository = app('AirAroma\Repository\SitemapRepository');

        $sitemapRepository->lang = (isLanguageSet($lang)) ? DIRECTORY_SEPARATOR.$lang : null;

        $output = $sitemapRepository->generateXML();

        return response()
            ->make($output, '200')
            ->header('Content-Type', 'text/xml');
    }


}
