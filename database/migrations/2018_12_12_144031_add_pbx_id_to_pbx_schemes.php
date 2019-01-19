<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPbxIdToPbxSchemes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pbx_schemes', function (Blueprint $table) {
            $table->string('pbx_id')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pbx_schemes', function (Blueprint $table) {
            $table->dropColumn('pbx_id');
        });
    }
}
