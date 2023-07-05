<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->bigIncrements('id');

            $table->text('category_name');
            $table->text('category_description')->nullable();

            $table->foreignId('category_father_id')
            ->nullable()
            ->constrained('categories','id');

            $table->foreignId('modifiertemplate_id')
            ->nullable()
            ->constrained('modifier_templates','id');

            $table->string('categoryimg')->nullable();
            $table->integer('category_index')->nullable();


            $table->bigInteger('reference_id')->nullable();
            $table->timestamps();
        });
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
