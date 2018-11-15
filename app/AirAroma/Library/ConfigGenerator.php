<?php

namespace AirAroma\Library;

use AirAroma\Repository\PageRepository;
use AirAroma\Repository\WebsiteRepository;
use Illuminate\Config\Repository as Config;
use Illuminate\Http\Request;

class ConfigGenerator
{
    public function __construct(PageRepository $pageRepository, WebsiteRepository $websiteRepository, Config $config, Request $request)
    {
        $this->config = $config;
        $this->request = $request;
        $this->websiteRepository = $websiteRepository;
        $this->pageRepository = $pageRepository;

        $this->domain = $this->websiteRepository->domain();
        $this->lang = $this->websiteRepository->language();
    }


    /**
     * Creates the config array within the container, accessed via app()
     *
     */
    public function create()
    {
        $config['siteConfig'] = $this->websiteConfig();

        $this->redirectOnReason($config['siteConfig']);

        if (is_array($config['siteConfig'])) {

            $websiteId = $config['siteConfig']['web_id'];

            $this->websiteRepository->setWebsiteId($websiteId);

            $config['siteConfig']['base_path'] = $this->websiteRepository->setBasePath();
            $config['siteConfig']['tld'] = $this->websiteRepository->setTld();
            $config['siteConfig']['interface'] = $this->websiteRepository->setInterfaceId();
            $config['siteConfig']['alias'] = $this->websiteRepository->setAlias();
            $config['siteConfig']['website_url'] = 'https://'.$this->websiteRepository->setWebsiteUrl();

            if (! isset($config['siteTranslations'])) {
                $pageId = ($this->pageRepository->getPageId()) ?: null;
                $config['siteTranslations']['pageId'] = $pageId;
                $config['siteTranslations']['links'] = $this->pageRepository->getLinksByWebsiteId($websiteId);
                $config['siteTranslations']['translations'] = $this->pageRepository->getTranslationsByWebsiteAndPageId($websiteId, [0, 5, 90,154, $pageId]);
                $config['siteTranslations']['tags'] = $this->pageRepository->getTagsByWebsiteId($websiteId);
                $config['siteTranslations']['industries'] = $this->pageRepository->getIndustriesByWebsiteId($websiteId);
                $config['siteTranslations']['templates'] = $this->pageRepository->getTemplatesByLink($config['siteTranslations']['links']);
                $config['siteTranslations']['features'] = $this->pageRepository->getIndustriesByWebsiteId($websiteId);

                $adminPageId = ($this->pageRepository->getAdminPageId()) ?: $pageId;
                $config['baseTranslations']['links'] = $this->pageRepository->getLinksByWebsiteId(baseId());
                $config['baseTranslations']['translations'] = $this->pageRepository->getTranslationsByWebsiteAndPageId(baseId(), [0, 5, 90, 154, $adminPageId]);
                $config['baseTranslations']['tags'] = $this->pageRepository->getTagsByWebsiteId(baseId());
                $config['baseTranslations']['industries'] = $this->pageRepository->getIndustriesByWebsiteId(baseId());
                $config['baseTranslations']['templates'] = $this->pageRepository->getTemplatesByLink($config['baseTranslations']['links']);
            }
        }
        $this->config->set($config);
    }

    /**
     * Redirects initial page request determined by the reason configured by websiteConfig()
     *
     * @param string $reason
     */
    public function redirectOnReason($reason)
    {
        switch ($reason) {
            case "default_language":
            case "language_unavailable":
                $slug = $this->removeSlugLanguage();
                redirect('/'.$slug, 301)->send();
                exit();
            break;
            case "no_domain":
            case "not_configured":
                $appUrl = $this->config->get('app.url');
                redirect($appUrl, 301)->send();
                exit();
            break;
        }
    }

    /**
     * Remove slug from URL
     *
     * @return string
     */
    public function removeSlugLanguage()
    {
        return substr($this->request->server('REQUEST_URI'), 4);
    }


    /**
     * Generate container config
     *
     * @return string|array
     */
    public function websiteConfig()
    {
        if ($this->lang) {
            $query = $this->websiteRepository->getWebsiteConfigByLanguage($this->lang, $this->domain)->first();
        } else {
            $query = $this->websiteRepository->getWebsiteConfigByDefaultLanguage($this->domain)->first();
        }

        if (! $this->websiteRepository->isDomainValid($this->domain)) {
            return 'no_domain';
        }

        if (! $this->websiteRepository->isDomainConfigured($this->domain)) {
            return 'not_configured';
        }

        if (! $query) {
            return 'language_unavailable';
        }

        if ($query->web_lang == $this->lang && $query->web_lang_default) {
            return 'default_language';
        }
        
        return $query->toArray();
    }
}
