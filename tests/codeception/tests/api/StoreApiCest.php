<?php

require '../../vendor/vlucas/phpdotenv/src/Dotenv.php';
require '../../vendor/vlucas/phpdotenv/src/Loader.php';

$dotenv = new Dotenv\Dotenv('../../', '.env');
$dotenv->load();

class StoreApiCest
{

    public function setEnviroment(AcceptanceTester $I)
    {
        $this->apiToken = getenv('API_TOKEN');
    }

    public function listProducts(ApiTester $I)
    {
        $I->wantTo('List Products');
        $I->sendGET('/store/1/products', ['api_token' => $this->apiToken]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->sendGET('/store/1/products', ['category' => 'aroma-oils', 'api_token' => $this->apiToken]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->sendGET('/store/1/products', ['category' => 'aroma-oils', 'group' => 'food', 'api_token' => $this->apiToken]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function listItems(ApiTester $I)
    {
        $I->wantTo('List Product');
        $I->sendGET('/store/1/list', ['items' => 'oilgroups', 'api_token' => $this->apiToken]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function viewProduct(ApiTester $I)
    {
        $I->wantTo('View Product');
        $I->sendGET('/store/1/product/fig-essence', ['variation' => '1', 'api_token' => $this->apiToken]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();

        $I->sendGET('/store/1/product/fig-essence', ['api_token' => $this->apiToken]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }

    public function viewProductsById(ApiTester $I)
    {
        $I->wantTo('List Products By ID');
        $I->sendPOST('/store/1/products', ['products' => [1,2,3], 'api_token' => $this->apiToken]);
        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
    }
}
