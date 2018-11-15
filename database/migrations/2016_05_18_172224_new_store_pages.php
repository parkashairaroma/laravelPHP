<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NewStorePages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sqlCommand = "INSERT INTO pages (pag_id, pag_name, pag_url, pag_translatable, pag_sitemap_title, pag_subsite, pag_sitemap_order, pag_status) VALUES (111, 'Store', '/store', 1, 'Store', 0, null, false); ";
        DB::statement($sqlCommand);
        $sqlCommand = "INSERT INTO linktranslations (lts_pag_id, lts_url, lts_enabled, lts_web_id) VALUES (111, '/store', 0, 1000); ";
        DB::statement($sqlCommand);

        $sqlCommand = "INSERT INTO pages (pag_id, pag_name, pag_url, pag_translatable, pag_sitemap_title, pag_subsite, pag_sitemap_order, pag_status) VALUES (112, 'Aromax', '/store/aromax', 1, 'Aromax', 0, null, false); ";
        DB::statement($sqlCommand);
        $sqlCommand = "INSERT INTO linktranslations (lts_pag_id, lts_url, lts_enabled, lts_web_id) VALUES (112, '/store/aromax', 0, 1000); ";
        DB::statement($sqlCommand);

        $sqlCommand = "INSERT INTO pages (pag_id, pag_name, pag_url, pag_translatable, pag_sitemap_title, pag_subsite, pag_sitemap_order, pag_status) VALUES (113, 'Activation', '/store/activation', 1, 'Activation', 0, null, false); ";
        DB::statement($sqlCommand);
        $sqlCommand = "INSERT INTO linktranslations (lts_pag_id, lts_url, lts_enabled, lts_web_id) VALUES (113, '/store/activation', 0, 1000); ";
        DB::statement($sqlCommand);

        $sqlCommand = "INSERT INTO pages (pag_id, pag_name, pag_url, pag_translatable, pag_sitemap_title, pag_subsite, pag_sitemap_order, pag_status) VALUES (114, 'Checkout', '/store/checkout', 1, 'Checkout', 0, null, false); ";
        DB::statement($sqlCommand);
        $sqlCommand = "INSERT INTO linktranslations (lts_pag_id, lts_url, lts_enabled, lts_web_id) VALUES (114, '/store/checkout', 0, 1000); ";
        DB::statement($sqlCommand);

        $sqlCommand = "INSERT INTO pages (pag_id, pag_name, pag_url, pag_translatable, pag_sitemap_title, pag_subsite, pag_sitemap_order, pag_status) VALUES (115, 'Cart', '/store/cart', 1, 'Cart', 0, null, false); ";
        DB::statement($sqlCommand);
        $sqlCommand = "INSERT INTO linktranslations (lts_pag_id, lts_url, lts_enabled, lts_web_id) VALUES (115, '/store/cart', 0, 1000); ";
        DB::statement($sqlCommand);

        $sqlCommand = "INSERT INTO pages (pag_id, pag_name, pag_url, pag_translatable, pag_sitemap_title, pag_subsite, pag_sitemap_order, pag_status) VALUES (116, 'Sign In', '/store/signin', 1, 'Sign In', 0, null, false); ";
        DB::statement($sqlCommand);
        $sqlCommand = "INSERT INTO linktranslations (lts_pag_id, lts_url, lts_enabled, lts_web_id) VALUES (116, '/store/signin', 0, 1000); ";
        DB::statement($sqlCommand);

        $sqlCommand = "INSERT INTO pages (pag_id, pag_name, pag_url, pag_translatable, pag_sitemap_title, pag_subsite, pag_sitemap_order, pag_status) VALUES (117, 'Sign Up', '/store/signup', 1, 'Sign Up', 0, null, false); ";
        DB::statement($sqlCommand);
        $sqlCommand = "INSERT INTO linktranslations (lts_pag_id, lts_url, lts_enabled, lts_web_id) VALUES (117, '/store/signup', 0, 1000); ";
        DB::statement($sqlCommand);

        $sqlCommand = "INSERT INTO pages (pag_id, pag_name, pag_url, pag_translatable, pag_sitemap_title, pag_subsite, pag_sitemap_order, pag_status) VALUES (118, 'Arobalance', '/store/arobalance', 1, 'Arobalance', 0, null, false); ";
        DB::statement($sqlCommand);
        $sqlCommand = "INSERT INTO linktranslations (lts_pag_id, lts_url, lts_enabled, lts_web_id) VALUES (118, '/store/arobalance', 0, 1000); ";
        DB::statement($sqlCommand);

        $sqlCommand = "INSERT INTO pages (pag_id, pag_name, pag_url, pag_translatable, pag_sitemap_title, pag_subsite, pag_sitemap_order, pag_status) VALUES (119, 'Aroma Oils', '/store/aroma-oils', 1, 'Aroma Oils', 0, null, false); ";
        DB::statement($sqlCommand);
        $sqlCommand = "INSERT INTO linktranslations (lts_pag_id, lts_url, lts_enabled, lts_web_id) VALUES (119, '/store/aroma-oils', 0, 1000); ";
        DB::statement($sqlCommand);

        $sqlCommand = "INSERT INTO pages (pag_id, pag_name, pag_url, pag_translatable, pag_sitemap_title, pag_subsite, pag_sitemap_order, pag_status) VALUES (120, 'Essential Oils', '/store/essential-oils', 1, 'Essential Oils', 0, null, false); ";
        DB::statement($sqlCommand);
        $sqlCommand = "INSERT INTO linktranslations (lts_pag_id, lts_url, lts_enabled, lts_web_id) VALUES (120, '/store/essential-oils', 0, 1000); ";
        DB::statement($sqlCommand);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
