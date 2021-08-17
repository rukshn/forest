<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\CategoryModel;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('name');
            $table->text('slug');
            $table->string('color');
        });

        $basic_categories = array(
            [
                'name' => 'Issues',
                'slug' => 'issues',
                'color' => 'ef476f'
            ],
            [
                'name' => 'Tasks',
                'slug' => 'tasks',
                'color' => 'ee6c4d'
            ],
            [
                'name' => 'Milestones',
                'slug' => 'milestones',
                'color' => '118ab2'
            ]
        );

        foreach ($basic_categories as $cat) {
            $category = new CategoryModel();
            $category->name = $cat['name'];
            $category->slug = $cat['slug'];
            $category->color = $cat['color'];
            $category->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
