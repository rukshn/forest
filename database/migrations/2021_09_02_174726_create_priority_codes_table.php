<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\PriorityCodes;

class CreatePriorityCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('priority_codes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('priority_code');
            $table->string('color');
            $table->string('slug');
        });

        $basic_priorities = array(
            [
                'priority_code' => 'lowest',
                'color' => '4895ef',
                'slug' => 'lowest'
            ],
            [
                'priority_code' => 'low',
                'color' => '4361ee',
                'slug' => 'low'
            ],
            [
                'priority_code' => 'medium',
                'color' => '277da1',
                'slug' => 'medium'
            ],
            [
                'priority_code' => 'high',
                'color' => 'e85d04',
                'slug' => 'high'
            ],
            [
                'priority_code' => 'highest',
                'color' => 'd00000',
                'slug' => 'highest'
            ]
        );

        foreach ($basic_priorities as $priority) {
            $priority_code_model = new PriorityCodes;
            $priority_code_model->slug = $priority['slug'];
            $priority_code_model->color = $priority['color'];
            $priority_code_model->priority_code = $priority['priority_code'];
            $priority_code_model->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('priority_codes');
    }
}
