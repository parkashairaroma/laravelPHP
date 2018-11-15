<?php

require '../../vendor/vlucas/phpdotenv/src/Dotenv.php';
require '../../vendor/vlucas/phpdotenv/src/Loader.php';

$dotenv = new Dotenv\Dotenv('../../', '.env');
$dotenv->load();

class AirAromaAdminCest
{   
    protected $user;
    protected $password;

    public function setPassword(AcceptanceTester $I)
    {
        $this->user = getenv('TEST_USER');
        $this->password = getenv('TEST_PASSWORD');
    }

    public function visitAdmin(AcceptanceTester $I)
    {
        $I->wantTo('Visit Admin');
        $I->amOnPage('/admin/login');
        $I->see('Sign In');
    }

    public function checkLogin(AcceptanceTester $I)
    {
        $I->wantTo('Check authenication');
        $I->amOnPage('/admin/login');
        $I->fillField('login', $this->user);
        $I->fillField('password', $this->password);
        $I->click('Sign In');
    }

    public function visitBlog(AcceptanceTester $I)
    {
        $I->wantTo('Visit Blog');
        $I->amOnPage('/admin/login');
        $I->fillField('login', $this->user);
        $I->fillField('password', $this->password);
        $I->click('Sign In');
        $I->amOnPage('/admin/blog');
        $I->see('Actions');
        $I->amOnPage('/admin/blog/edit/614');
        $I->see('Slug');
        $I->amOnPage('/admin/blog/create');
        $I->see('Blog Post');
    }
    public function visitPages(AcceptanceTester $I)
    {
        $I->wantTo('Visit Banners');
        $I->amOnPage('/admin/login');
        $I->fillField('login', $this->user);
        $I->fillField('password', $this->password);
        $I->click('Sign In');
        $I->amOnPage('/admin/pages');
        $I->see('Actions');
        $I->amOnPage('/admin/pages/edit/0');
        $I->see('Actions');
    }
    public function visitBanners(AcceptanceTester $I)
    {
        $I->wantTo('Visit Banners');
        $I->amOnPage('/admin/login');
        $I->fillField('login', $this->user);
        $I->fillField('password', $this->password);
        $I->click('Sign In');
        $I->amOnPage('/admin/banners');
        $I->see('Actions');
    }
    public function visitTags(AcceptanceTester $I)
    {
        $I->wantTo('Visit Tags');
        $I->amOnPage('/admin/login');
        $I->fillField('login', $this->user);
        $I->fillField('password', $this->password);
        $I->click('Sign In');
        $I->amOnPage('/admin/tags');
        $I->see('Actions');
    }
    public function visitLinks(AcceptanceTester $I)
    {
        $I->wantTo('Visit Tags');
        $I->amOnPage('/admin/login');
        $I->fillField('login', $this->user);
        $I->fillField('password', $this->password);
        $I->click('Sign In');
        $I->amOnPage('/admin/links');
        $I->see('Actions');
    }
}
