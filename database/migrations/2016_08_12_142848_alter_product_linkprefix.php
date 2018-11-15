<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterProductLinkprefix extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        $result = DB::update('update products set pro_linkprefix = ? where pro_linkprefix = ? ; ', ['/aroma-oils', '/aromaoils']);
        $result = DB::update('update products set pro_linkprefix = ? where pro_linkprefix = ? ; ', ['/essential-oils', '/essentialoils']);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $result = DB::update('update products set pro_linkprefix = ? where pro_linkprefix = ? ; ', ['/aromaoils', '/aroma-oils']);
        $result = DB::update('update products set pro_linkprefix = ? where pro_linkprefix = ? ; ', ['/essentialoils', '/essential-oils']);
    }
}
