<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\TestingStatesModel;

class CreateTestingstatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('testingstates', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('status_name');
            $table->string('slug');
            $table->string('color');
        });

        $basic_states = array(
            [
                "status_name" => "Passed",
                "slug" => "passed",
                "color" => "06d6a0"
            ],
            [
                "status_name" => "Failed",
                "slug" => "failed",
                "color" => "ef476f"
            ],
            [
                "status_name" => "Pending",
                "slug" => "pending",
                "color" => "6c757d"
            ]
            );

        foreach ($basic_states as $state) {
            $testing_state_model = new TestingStatesModel();
            $testing_state_model->status_name = $state['status_name'];
            $testing_state_model->slug = $state['slug'];
            $testing_state_model->color = $state['color'];
            $testing_state_model->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('testingstates');
    }
}
