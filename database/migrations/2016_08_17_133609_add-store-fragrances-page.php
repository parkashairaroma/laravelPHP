<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStoreFragrancesPage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $url = '/store/fragrances';
        $name = 'Fragrances';
        $sitemapTitle = 'Fragrances';

        $pag_id = DB::table('pages')->insertGetId(
            [
                'pag_name' => $name,
                'pag_url' => $url,
                'pag_translatable' => 1,
                'pag_sitemap_title' => $sitemapTitle,
                'pag_subsite' => 0,
                'pag_sitemap_order' => null,
                'pag_status' => false
            ], 'pag_id'
        );

        DB::table('linktranslations')->insert(
            [
                [
                    'lts_pag_id' => $pag_id,
                    'lts_url' => $url,
                    'lts_enabled' => 0,
                    'lts_web_id' => 1000
                ],
                [
                    'lts_pag_id' => $pag_id,
                    'lts_url' => $url,
                    'lts_enabled' => 0,
                    'lts_web_id' => 1
                ]
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        $page = DB::table('pages')->select('pag_id')->where('pag_url', '=', '/store/fragrances')->take(1)->get();

        $pag_id = $page[0]->pag_id;

        DB::table('pages')->where('pag_id', '=', $pag_id)->delete();

        DB::table('linktranslations')->where('lts_pag_id', '=', $pag_id)->delete();

    }
}
