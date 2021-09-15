<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToQatestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('qatests', function (Blueprint $table) {
            //
            $table->longText('test_cases')->nullable();
            $table->boolean('is_archieved')->default($value=false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('qatests', function (Blueprint $table) {
            //
            $table->dropColumn('test_cases');
            $table->dropColumn('is_archieved');
        });
    }
}
