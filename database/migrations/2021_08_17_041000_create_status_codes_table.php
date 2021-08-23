<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\PostStatusCodeModel;

class CreateStatusCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_codes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('status_name');
            $table->string('color');
        });

        $basic_status = array(
            [
                "status_name" => "Todo",
                "slug" => "todo",
                "color" => "3d5a80"
            ],
            [
                "status_name" => "In progress",
                "slug" => "in-progress",
                "color" => "8338ec"
            ],
            [
                "status_name" => "Completed",
                "slug" => "completed",
                "color" => "06d6a0"
            ]
        );

        foreach ($basic_status as $status) {
            $status_model = new PostStatusCodeModel();
            $status_model->status_name = $status['status_name'];
            $status_model->slug = $status['slug'];
            $status_model->color = $status['color'];
            $status_model->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('status_codes');
    }
}
