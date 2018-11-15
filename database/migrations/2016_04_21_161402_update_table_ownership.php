<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTableOwnership extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sqlCommand = 'ALTER TABLE jobs OWNER TO aai2016users ;';
        DB::statement($sqlCommand);
        $sqlCommand = 'ALTER TABLE migrations OWNER TO aai2016users ;';
        DB::statement($sqlCommand);
        $sqlCommand = 'ALTER TABLE sessions OWNER TO aai2016users ;';
        DB::statement($sqlCommand);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $sqlCommand = 'ALTER TABLE jobs OWNER TO aai2016site ;';
        DB::statement($sqlCommand);
        $sqlCommand = 'ALTER TABLE migrations OWNER TO aai2016site ;';
        DB::statement($sqlCommand);
        $sqlCommand = 'ALTER TABLE sessions OWNER TO aai2016site ;';
        DB::statement($sqlCommand);
    }
}
