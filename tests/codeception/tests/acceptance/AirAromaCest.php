<?php

require '../../vendor/vlucas/phpdotenv/src/Dotenv.php';
require '../../vendor/vlucas/phpdotenv/src/Loader.php';

$dotenv = new Dotenv\Dotenv('../../', '.env');
$dotenv->load();

class AirAromaCest
{

    public function setEnviroment(AcceptanceTester $I)
    {
        $this->env = getenv('APP_ENV');
        $this->appEmail = getenv('APP_EMAIL');
        $this->branch = getenv('BRANCH');
    }

    public function visitHome(AcceptanceTester $I)
    {
        $I->wantTo('Visit Homepage');
        $I->amOnPage('/');
        $I->seeResponseCodeIs(200);
    }

    public function checkMissingRoutes(AcceptanceTester $I)
    {
        $I->wantTo('Check route not found 404');
        $I->amOnPage('/this-is-a-test');
        $I->seeResponseCodeIs(404);
    }

    public function checkIndexPHP(AcceptanceTester $I)
    {
        $I->wantTo('Check index.php');
        $I->amOnPage('/index.php');
        $I->seeInCurrentUrl('/404');
        $I->amOnPage('/blog/index.php');
        $I->seeInCurrentUrl('/404');
    }

    public function checkPages(AcceptanceTester $I)
    {
        $I->wantTo('Check if some pages are loading');
        $I->amOnPage('/scent-marketing');
        $I->seeResponseCodeIs(200);;

        $I->amOnPage('/why-air-aroma');
        $I->seeResponseCodeIs(200);

        $I->amOnPage('/scenting');
        $I->seeResponseCodeIs(200);

        $I->amOnPage('/diffusers');
        $I->seeResponseCodeIs(200);

        $I->amOnPage('/signature-scent');
        $I->seeResponseCodeIs(200);

        $I->amOnPage('/scents');
        $I->seeResponseCodeIs(200);

        $I->amOnPage('/aropromo');
        $I->seeResponseCodeIs(200);

        $I->amOnPage('/locations');
        $I->seeElement('select');

        $I->amOnPage('/sitemap');
        $I->seeResponseCodeIs(200);
        
        $I->amOnPage('/sitemap/xml');

    }

    public function checkQueryString(AcceptanceTester $I)
    {
        $I->wantTo('Check  query string');

        $I->amOnPage('/?this=test&another=test');
        $I->dontSee('no_token');

        $I->amOnPage('/clients/?this=test&another=test');
        $I->dontSee('no_token');

        $I->amOnPage('//clients/?this=test&another=test');
        $I->dontSee('no_token');
    }

    public function checkSlugRegex(AcceptanceTester $I)
    {
        $I->wantTo('Check slug regex');

        $I->amOnPage('/blog/tag/fragrance+');
        $I->seeResponseCodeIs(404);

        $I->amOnPage('/blog/tag/fragrances');
        $I->seeResponseCodeIs(200);
    }

    public function checkClients(AcceptanceTester $I)
    {
        $I->wantTo('Check client pages');

        $I->amOnPage('/clients');
        $I->seeResponseCodeIs(200);

        $I->amOnPage('/clients/sofitel');
        $I->seeResponseCodeIs(200);
    }

    public function checkBlog(AcceptanceTester $I)
    {
        $I->wantTo('Check blog posts');

        $I->amOnPage('/');
        $I->click('Blog');

        $I->amOnPage('/blog/tag/air-aroma');
        $I->seeResponseCodeIs(200);

        $I->amOnPage('/blog/page/2');
        $I->seeResponseCodeIs(200);

        $I->amOnPage('/blog');
        $I->click('Read More');
        $I->seeResponseCodeIs(200);
    }

    public function submitContactForm(AcceptanceTester $I)
    {
        $I->wantTo('Contact Form Submission');
        $I->amOnPage('/contact');
        $I->fillField('contact-form-name', '['.$this->branch.'] PHPUnit Website Tester');
        $I->fillField('contact-form-email', $this->appEmail);
        $I->fillField('contact-form-email2', $this->appEmail);
        $I->fillField('contact-form-phone', '1234567890');
        $I->selectOption('contact-form-country', 'AU');
        $I->selectOption('contact-form-reason', 'contact_form_reason_it_support');
        $I->fillField('contact-form-message', 'PHPUnit Website Tester');
        $I->click('Submit');
        $I->see('Thank you for contacting Air Aroma, one of our representatives will be in touch soon.');
    }
}
